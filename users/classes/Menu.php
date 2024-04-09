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
      return true;
    }
    $this->db = DB::getInstance();
    if(is_numeric($id_or_name)) {
      $col = "id";

    } else {
      $col = "menu_name";
    }
    $q = $this->db->query("SELECT * FROM us_menus WHERE $col = ?",[$id_or_name]);
    $c = $q->count();
    if($c < 1){
      die("Your menu $id_or_name is missing. If you have just upgraded UserSpice,
      please navigate to users/updates in your browser to create your menus.
      Otherwise, please go into your database and restore a backup or select a different menu.
      If you do not have a backup, you can also create a UserSpice file and run the function migrateUSMainMenu() to
      attempt to create a new Main Menu");
    }else{
      $menu = $q->first();
    }

    if(!$menu) return false;
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
    return "<nav>" . $html . "</nav>";
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

  private function _generateHtml($items, $isDropdown = false, $level = 0) {
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
    }

    if($level == 1 && !empty($this->menu->nav_class)) {
      $ulClass .= " {$this->menu->nav_class}";
    }

    if($level > 2) {
      $ulClass .= " us_deep-sub-menu";
    }
    reset($items);
    $firstKey = key($items);
    $ulId = $isDropdown? "menu_{$items[$firstKey]->menu}_dropdown_{$items[$firstKey]->parent}" : false;
    $labelledBy = $isDropdown? "aria-labelledby='{$ulId}'" : '';
    $html = "<ul class='{$ulClass}' {$labelledBy} style='{$ulStyle}' {$menuId}>";

    if($level == 1) {
      $brandHtml = !empty($this->menu->brand_html)? html_entity_decode($this->menu->brand_html, ENT_QUOTES, 'UTF-8') : '';
      $brandHtml = str_replace("{{root}}",$us_url_root,$brandHtml);
      if($this->show_branding == false){
        $brandHtml = "";
      }

      $html .= "<div class='us_brand full_screen'>{$brandHtml}</a></div>";

      if($this->menu->justify == "right"){
          $html .= "<div class='flex-grow-1'></div>";
      }


      $html .= "<div class='us_menu_mobile_wrapper'><div class='us_brand'>{$brandHtml}</a></div>";


      $html .= "<span class='additional-mobile-icons'>";
            $mobile_menu_hooks = $abs_us_root . $us_url_root . "usersc/hooks/mobile_menu/";
      $php_files = glob($mobile_menu_hooks . "*.php");
      
      foreach ($php_files as $php_file) {
        ob_start();
        include $php_file;
        $data = ob_get_clean();
        $html .=  $data;
        @ob_end_flush();
      }
      $html .= "</span>";
      $html .= "<div class='us_menu_mobile_control' data-target='{$this->menu->id}{$uniq}'><i class='fa fa-bars'></i></div></div>";
 
    }
    foreach($items as $item) {
      // dump(parseMenuLabel($item->label));
      // dump($this->hasPerms($item));
      // dump("********************************************");
      if(!$this->hasPerms($item) || $item->disabled == 1) continue;
      if($item->type == 'separator') {
        $html .= "<div class='dropdown-divider'></div>";
        continue;
      }
      $hasDropdown = sizeof($item->items) > 0;
      $liClass = $hasDropdown? "dropdown" : "";
      $liClass .= $item->li_class ? " $item->li_class": "";

      // check if the li should be active (i.e. its URL matches the current page)
      $currentPage = substr($_SERVER["REQUEST_URI"], strrpos($_SERVER["REQUEST_URI"], "/") + 1);
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
      
      if($hasDropdown) {
        $toggle = "menu_{$item->menu}{$uniq}_dropdown_{$item->id}";
        $linkAttrs = "id='{$toggle}' role='button' aria-haspopup='true' aria-expanded='false' data-toggle='dropdown' data-target='#{$toggle}'";
      }

      if($item->type == "snippet" && file_exists($abs_us_root . $us_url_root . $item->link)){
        //check file exists

        $html .= "";
        //we're going to capture the OUTPUT of the php file as html and inject it into the menu
        ob_start();
        include $abs_us_root . $us_url_root . $item->link;
        $data = ob_get_clean();
        $html .=  $data;
        @ob_end_flush();
        $html .= "";
      }else{
        $html .= "<li class='{$liClass}' data-menu='{$item->menu}'>";
        if(strtolower(substr($item->link,0,5) != "http:") && strtolower(substr($item->link,0,6) != "https:")){
          $item->link = $us_url_root . $item->link;
        }
        $html .= "<a class='{$linkClass}' href='{$item->link}' {$linkAttrs}>";
        if(!empty($item->icon_class)) {
          $html .= "<i class='{$item->icon_class}'></i>";
        }

        $parsedLabel = parseMenuLabel($item->label);
        if ($parsedLabel == ""  && isset($this->menu->screen_reader_mode) && $this->menu->screen_reader_mode == 1) {
            $parsedLabel = lang("MENU_MENU");// for accessibility, don't allow blank labels - they are meaningless to screen readers
        }
        $html .= "<span class='labelText'>" . $parsedLabel . "</span>";
        // $html .= $item->label;

        if($hasDropdown) {
          $html .= "<span class='caret fa fa-caret-down'></span>";
        }
        $html .= "</a>";
        if($hasDropdown) {
          $html .= $this->_generateHtml($item->items, true, $level);
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
    $html = "<ul>";
    if($level == 0) {
      $active = $itemId == 0? 'active': '';
      $html .= "<li><a class='{$active}' href='{$us_url_root}users/admin.php?view=edit_menu&menu_id={$this->menu->id}&parent_id=0'>{$this->menu->menu_name}</a></li><ul>";
    }
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
      $html .= "<a ";
      if($item->disabled==1) { $html .= "style='color:lightgray'"; }
      $html .= " class='{$active}' href='{$us_url_root}users/admin.php?view=edit_menu&menu_id={$this->menu->id}&item_id={$item->id}&parent_id={$item->parent}'> $parsedLabel</a>";
      if(!empty($item->items)) {
        $level++;
        $html .= $this->miniMapLinks($item->items, $itemId, $level);
      }
      $html .= "</li>";
    }
    if($level == 0) {
      $html .= "</ul>";
    }
    $html .= "</ul>";
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
