<?php
class Menu {
  protected $db;
  public $id, $menu_name, $menu;
  public $items = [];
  public $tree = [];
  public $userPerms = [0];
  public $userTags = [];
  public $show_branding = true;
  public $show_active = 0;
  public $disabled = 0;

  public function __construct($id_or_name) {
    if($id_or_name == 0) {
      return;
    }
    $this->db = DB::getInstance();
    if(is_numeric($id_or_name)) {
      $col = "id";

    } else {
      $col = "menu_name";
    }
    $q = $this->db->query("SELECT * FROM us_menus WHERE $col = ?",[$id_or_name]); // nosemgrep: userspice-raw-query-concat - $col is hardcoded to 'id' or 'menu_name', value is parameterized
    $c = $q->count();
    if($c < 1){
      // Escaped in case a plugin/page ever passes user input as the menu identifier
      $id_or_name = safeReturn($id_or_name);
      die("Your menu $id_or_name is missing. If you have just upgraded UserSpice,
      please navigate to users/updates in your browser to create your menus.
      Otherwise, please go into your database and restore a backup or select a different menu.
      If you do not have a backup, you can also create a UserSpice file and run the function migrateUSMainMenu() to
      attempt to create a new Main Menu");
    }else{
      $menu = $q->first();
    }

    if(!$menu) return;
    $this->menu = $menu;
    $this->id = $menu->id;
    $this->menu_name = $menu->menu_name;
    $this->disabled = $menu->disabled;
    $this->show_active = $menu->show_active;
    $this->show_branding = true;
    $this->_loadItems();
    $this->tree = $this->_loadTree(0);
    global $user;
    if($user->isLoggedIn()) {
      //clear out the default 0 perm that non logged in users have
      $perms = $this->db->query("SELECT * FROM user_permission_matches WHERE user_id = ?",[$user->data()->id])->results();
      foreach($perms as $perm) {
        $this->userPerms[] = $perm->permission_id;
      }
      if(pluginActive("usertags",true)){
        $tags = $this->db->query("SELECT * FROM plg_tags_matches WHERE user_id = ?",[$user->data()->id])->results();

        foreach($tags as $tag) {
          $this->userTags[] = $tag->tag_id;
        }
 
      }
    }
  }

  public function display($override = []) {
    if(isset($override["layout"]) && ($override["layout"] == "horizontal" || $override["layout"] == "vertical" || $override["layout"] == "accordion") ){
        $this->menu->type = $override["layout"] ;
    }
    if(isset($override["show_active"])){
      $this->menu->show_active = $override["show_active"];
    }

    if(isset($override["branding_html"])){
      $this->menu->brand_html = $override["branding_html"];
    }

    if(isset($override["show_branding"]) && $override["show_branding"] == false){
      $this->show_branding = false;
    }

    if(isset($override["theme"]) && $override["theme"] == false){
      $this->menu->theme = $override["theme"];
    }

    $html = $this->generate();
    echo $html;
  }

  public function generate() {
    $html = $this->_generateHtml($this->tree, false);
    // Sticky lives on the <nav> wrapper, not the <ul>: the ul's containing
    // block is the nav, so position:sticky on the ul has no scroll room.
    $navClass = !empty($this->menu->sticky) ? " class='us_sticky'" : "";
    // menu.css has this rule too. Repeating it once per page keeps the brand and
    // the hamburger visible on templates that serve a stale, unversioned menu.css.
    static $chromeCssSent = false;
    $chromeCss = "";
    if (!$chromeCssSent) {
      global $userspice_nonce;
      $chromeCssSent = true;
      $chromeCss = "<style nonce='" . htmlspecialchars($userspice_nonce ?? '', ENT_QUOTES, 'UTF-8') . "'>"
        . "ul.us_menu > li.us_menu_chrome, ul.us_menu.horizontal > li.us_menu_chrome"
        . "{display:contents !important;visibility:visible !important;}</style>";
    }
    return $chromeCss . "<nav{$navClass}>" . $html . "</nav>";
  }

  public function recursivelyDeleteMenuItem($itemId) {
    $children = $this->_loadTree($itemId);
    foreach($children as $child) {
      $this->recursivelyDeleteMenuItem($child->id);
    }
    $this->db->deleteById('us_menu_items', $itemId);
  }

  private function hasPerms($item) {
    global $user;

    $itemPerms = json_decode($item->permissions ?? "", true);
    if($itemPerms == "") $itemPerms = [];
    $itemTags = json_decode($item->tags ?? "", true);
    if($itemTags == "") $itemTags = [];

    // Once a user is logged in, the 0 permission on the item does not mean anything
    // and should be removed
    if ($user->isLoggedIn() && in_array("0", $itemPerms)) {
        unset($itemPerms[array_search("0", $itemPerms)]);
    }

    // Check if the user has any permissions in common with the item's permissions
    $hasPermission = sizeof(array_intersect($itemPerms, $this->userPerms)) > 0;

    // Check if the user has any tags in common with the item's permissions
    $hasTag = sizeof(array_intersect($itemTags, $this->userTags)) > 0;

    // Return true if either permission or tag is present
    return $hasPermission || $hasTag;
}

  // Brand HTML is admin-entered, and the shipped defaults have a logo <img> with no
  // alt and an <a> that is never closed. Repair both at render time so existing
  // installs are fixed without rewriting anyone's saved brand_html.
  private function _brandHtml() {
    global $us_url_root, $settings;
    if($this->show_branding == false || empty($this->menu->brand_html)){
      return "";
    }
    $brandHtml = html_entity_decode($this->menu->brand_html, ENT_QUOTES, 'UTF-8');
    $brandHtml = str_replace("{{root}}",$us_url_root,$brandHtml);
    // A logo needs a text alternative, unless the brand already shows text: then
    // the image is decorative (alt="") and would only repeat it. site_name is
    // stored HTML-escaped, so decode before escaping it once.
    $hasText = trim(html_entity_decode(strip_tags($brandHtml), ENT_QUOTES, 'UTF-8')) !== '';
    $alt = $hasText ? '' : safeReturn(lang("MENU_LOGO_HOME", [$settings->site_name ?? ""]), true);
    $brandHtml = preg_replace_callback('/<img\b((?:[^>"\']|"[^"]*"|\'[^\']*\')*)>/i', function ($m) use ($alt) {
      if (preg_match('/(?<![-\w])alt\s*=/i', $m[1])) {
        return $m[0];
      }
      return '<img alt="' . $alt . '"' . $m[1] . '>';
    }, $brandHtml);
    $countable = preg_replace('/<!--.*?-->/s', '', $brandHtml);
    $unclosed = preg_match_all('/<a\b/i', $countable) - preg_match_all('/<\/a\s*>/i', $countable);
    if($unclosed > 0){
      $brandHtml .= str_repeat("</a>", $unclosed);
    }
    return $brandHtml;
  }

  // Accessible name for an item whose label is blank (icon-only), guessed from
  // its link as stored (before the site root is prefixed). Plain text; escape it.
  private function _fallbackLabel($rawLink, $hasDropdown) {
    if($hasDropdown){
      return lang("MENU_MENU");
    }
    $link = trim(html_entity_decode((string) $rawLink, ENT_QUOTES, 'UTF-8'));
    $parts = parse_url($link);
    $scheme = strtolower($parts['scheme'] ?? '');
    if ($link === '' || $link[0] === '#' || $scheme === 'javascript' || $parts === false) {
      return lang("MENU_MENU");
    }
    if ($scheme === 'mailto') {
      // English fallback for sites whose own language file lacks the key
      // (lang() returns "{ Missing Text ... }" rather than '' for those)
      $address = $parts['path'] ?? '';
      return isset($GLOBALS['lang']['MENU_EMAIL']) ? lang("MENU_EMAIL", [$address]) : 'Email ' . $address;
    }
    if ($scheme === 'tel') {
      $number = $parts['path'] ?? '';
      return isset($GLOBALS['lang']['MENU_CALL']) ? lang("MENU_CALL", [$number]) : 'Call ' . $number;
    }
    if (!empty($parts['host']) && strcasecmp($parts['host'], (string) Server::get('HTTP_HOST')) !== 0) {
      return preg_replace('/^www\./i', '', $parts['host']);
    }
    parse_str($parts['query'] ?? '', $query);
    if (!empty($query['view']) && is_string($query['view'])) {
      return ucwords(str_replace(["_", "-"], " ", $query['view']));
    }
    $path = $parts['path'] ?? '';
    if ($path === '' || substr($path, -1) === '/') {
      return lang("MENU_HOME");
    }
    return ucwords(str_replace(["_", "-"], " ", pathinfo($path, PATHINFO_FILENAME)));
  }

  private function _generateHtml($items, $isDropdown = false, $level = 0, $toggleId = "") {
    if(!isset($this->menu->id) || $this->menu->id == 0){
      return "";
    }
    global $abs_us_root,$us_url_root,$lang;
    $uniq = "_" . uniqid();
    // $uniq = "";
    $level++;
    $ulClass = $isDropdown? "us_sub-menu": "us_menu";
    $z = $this->menu->z_index?? 50;
    $ulStyle = " z-index: {$z};";
    $menuId = $level == 1? "id='us_menu_{$this->menu->id}{$uniq}' data-menu_id='{$this->menu->id}'" : "";
    if($level == 1) {
      $ulClass .= " " . $this->menu->type;
    }

    if($level == 1 && $this->menu->theme == 'dark') {
      $ulClass .= " dark";
    }elseif($level == 1 && $this->menu->theme == 'custom') {
      $ulClass .= " custom";
    }

    if($level == 1 && !empty($this->menu->nav_class)) {
      $ulClass .= " {$this->menu->nav_class}";
    }

    if($level > 2) {
      $ulClass .= " us_deep-sub-menu";
    }
    // A submenu is named by its toggle (aria-labelledby) and has an id the
    // toggle points at with aria-controls (see the toggle's $linkAttrs below).
    $labelledBy = ($isDropdown && $toggleId != "")? "id='{$toggleId}_menu' aria-labelledby='{$toggleId}'" : '';
    $html = "<ul class='{$ulClass}' {$labelledBy} style='{$ulStyle}' {$menuId}>";

    if($level == 1) {
      $brandHtml = $this->_brandHtml();

      // A <ul> may only contain <li>, so the brand, spacer and mobile controls share one
      // <li> (the home link + menu button). menu.css sets it to display:contents so its
      // children still lay out as direct flex items of the menu as they always have.
      $html .= "<li class='us_menu_chrome'>";
      $html .= "<div class='us_brand full_screen'>{$brandHtml}</div>";

      if($this->menu->justify == "right"){
          $html .= "<div class='flex-grow-1'></div>";
      }


      $html .= "<div class='us_menu_mobile_wrapper'><div class='us_brand'>{$brandHtml}</div>";


      $html .= "<span class='additional-mobile-icons'>";
            $mobile_menu_hooks = $abs_us_root . $us_url_root . "usersc/hooks/mobile_menu/";
      $php_files = glob($mobile_menu_hooks . "*.php");
      
      foreach ($php_files as $php_file) {
        ob_start();
        include $php_file;
        $data = ob_get_clean();
        $html .=  $data;
      }
      $html .= "</span>";
      $toggleLabel = safeReturn(lang("MENU_MENU"));
      $html .= "<button type='button' class='us_menu_mobile_control' data-target='{$this->menu->id}{$uniq}' data-bs-target='{$this->menu->id}{$uniq}' aria-controls='us_menu_{$this->menu->id}{$uniq}' aria-expanded='false' aria-label='{$toggleLabel}'><i class='fa fa-bars' aria-hidden='true'></i></button></div>";
      $html .= "</li>";

    }
    foreach($items as $item) {
      // dump(parseMenuLabel($item->label));
      // dump($this->hasPerms($item));
      // dump("********************************************");
      if(!$this->hasPerms($item) || $item->disabled == 1) continue;
      if($item->type == 'separator') {
        // decorative only; an <li> keeps the <ul> valid, aria-hidden keeps it out of the item count
        $html .= "<li class='dropdown-divider' aria-hidden='true'></li>";
        continue;
      }
      $hasDropdown = sizeof($item->items) > 0;
      $liClass = $hasDropdown? "dropdown" : "";
      $liClass .= $item->li_class ? " $item->li_class": "";

      // check if the li should be active (i.e. its URL matches the current page)
      $currentPage = basename(Server::get('REQUEST_URI'));
      $linkPage = substr($item->link, strrpos($item->link, "/") + 1);

        if(($this->show_active == 1 || $this->show_active == true) && $currentPage == $linkPage){
          $liClass .= " active active-style";
        }elseif($currentPage == $linkPage){
          $liClass .= " active";
        }

      // if($currentPage == $linkPage){
      //   $liClass .= " active";
      // }
      // build link
      $linkClass = $hasDropdown? "sub-toggle" : "";
      $linkClass .= $item->a_class? " $item->a_class": "";
   
      $linkAttrs = " target='";
      $linkAttrs .= $item->link_target ? $item->link_target : "_self";
      $linkAttrs .= "' ";
      
      $toggle = "";
      if($hasDropdown) {
        $toggle = "menu_{$item->menu}{$uniq}_dropdown_{$item->id}";
        $linkAttrs = "id='{$toggle}' role='button' aria-expanded='false' aria-controls='{$toggle}_menu'"; // a disclosure, not an ARIA menu
      }

      if($item->type == "snippet" && file_exists($abs_us_root . $us_url_root . $item->link)){
        //check file exists
        // Snippet contract: the output lands directly inside the menu's <ul>, so a
        // snippet must emit complete <li> element(s) and nothing else at the top
        // level (no bare <div>, <a> or text), or the list becomes invalid HTML
        // and screen readers misreport it.

        $html .= "";
        //we're going to capture the OUTPUT of the php file as html and inject it into the menu
        ob_start();
        include $abs_us_root . $us_url_root . $item->link;
        $data = ob_get_clean();
        $html .=  $data;
        $html .= "";
      }else{
        $html .= "<li class='{$liClass}' data-menu='{$item->menu}'>";
        $rawLink = $item->link;
        // only relative paths get the site root: any scheme (http:, mailto:, tel:,
        // javascript:...), a #fragment or a //host link is used as stored
        if(!preg_match('~^([a-z][a-z0-9+.-]*:|#|//)~i', $item->link)){
          $item->link = $us_url_root . $item->link;
        }
        // for accessibility, don't allow blank labels - they are meaningless to screen readers.
        // Screen reader mode shows the fallback as visible text; otherwise it is an aria-label.
        $parsedLabel = parseMenuLabel($item->label);
        if ($parsedLabel == "") {
          $fallback = safeReturn($this->_fallbackLabel($rawLink, $hasDropdown), true);
          if (isset($this->menu->screen_reader_mode) && $this->menu->screen_reader_mode == 1) {
            $parsedLabel = $fallback;
          } else {
            $linkAttrs .= " aria-label='{$fallback}'";
          }
        }

        $html .= "<a class='{$linkClass}' href='{$item->link}' {$linkAttrs}>";
        if(!empty($item->icon_class)) {
          $html .= "<i class='{$item->icon_class}' aria-hidden='true'></i>";
        }

        $html .= "<span class='labelText'>" . $parsedLabel . "</span>";
        // $html .= $item->label;

        if($hasDropdown) {
          $html .= "<span class='caret fa fa-caret-down' aria-hidden='true'></span>";
        }
        $html .= "</a>";
        if($hasDropdown) {
          $html .= $this->_generateHtml($item->items, true, $level, $toggle);
        }
          $html .= "</li>";
      } //end non-snippet links


    }
    $html .= "</ul>";
    return $html;
  }

  public function miniMap($itemId) {
    $html = "<div class='minimap'>";
    $html .= $this->miniMapLinks($this->tree, $itemId, 0);
    $html .= "</div>";
    return $html;
  }

  public function miniMapLinks($items, $itemId, $level) {
    global $us_url_root;
    $html = "";
    if($level == 0) {
      // the menu itself is the root item; its items nest inside its <li> (a <ul>
      // directly inside a <ul> is invalid list markup)
      $active = $itemId == 0? 'active': '';
      $html .= "<ul><li><a class='{$active}' href='{$us_url_root}users/admin.php?view=edit_menu&menu_id={$this->menu->id}&parent_id=0'>{$this->menu->menu_name}</a>";
    }
    $html .= "<ul>";
    foreach($items as $item) {
      $parsedLabel = parseMenuLabel($item->label);

      if ($parsedLabel == "" || $parsedLabel == null) {
        if($item->type == "separator"){
          $parsedLabel = "(separator)";
        }else{
          $parsedLabel = "(no label)";
        }

      }
      $active = $item->id == $itemId? 'active' : '';
      $html .= "<li>";
      // disabled items are dimmed with a readable theme color and say so in text,
      // not by color alone
      $disabled = $item->disabled == 1;
      $linkClass = trim($active . ($disabled ? ' text-body-secondary' : ''));
      $disabledNote = $disabled ? "<span class='visually-hidden'> (disabled)</span>" : '';
      $html .= "<a class='{$linkClass}' href='{$us_url_root}users/admin.php?view=edit_menu&menu_id={$this->menu->id}&item_id={$item->id}&parent_id={$item->parent}'> $parsedLabel{$disabledNote}</a>";
      if(!empty($item->items)) {
        $html .= $this->miniMapLinks($item->items, $itemId, $level + 1);
      }
      $html .= "</li>";
    }
    $html .= "</ul>";
    if($level == 0) {
      $html .= "</li></ul>";
    }
    return $html;
  }

  public function setInitialTypes() {
    $this->_populateTypeColumn($this->tree);
  }

  public function setInitialDisplayOrder() {
    $this->_populateInitialDisplayOrder($this->tree);
  }

  private function _populateInitialDisplayOrder($items) {
    $i = 1;
    foreach($items as $item) {
      $this->db->update('us_menu_items', $item->id, ['display_order' => $i]);
      $i++;
      if(sizeof($item->items) > 0) {
        $this->_populateInitialDisplayOrder($item->items);
      }
    }
  }

  private function _populateTypeColumn($items) {
    foreach($items as $item) {
      if(empty($item->type)) {
        $hasDropdown = sizeof($item->items) > 0;
        if($hasDropdown) {
          $this->db->update('us_menu_items', $item->id, ['type' => 'dropdown']);
          $this->_populateTypeColumn($item->items);
        } else {
          $this->db->update('us_menu_items', $item->id, ['type' => 'link']);
        }
      }
    }
  }

  private function _loadTree($parent) {
    $children = [];
    foreach($this->items as $item) {
      if($item->parent == $parent) {
        $branch = clone $item;
        $branch->items = $this->_loadTree($item->id);
        $children[$item->id] = $branch;
      }
    }
    return $children;
  }

  private function _loadItems(){
    $this->items = $this->db->query("SELECT * FROM us_menu_items WHERE menu = ? ORDER BY display_order ASC", [$this->id])->results();
  }

}
