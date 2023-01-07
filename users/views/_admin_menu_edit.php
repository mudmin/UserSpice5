<?php
global $user, $us_url_root;
$db = DB::getInstance();
$menuId = Input::get('menu_id');
$itemId = Input::get('item_id') ? Input::get('item_id') : 0;
$parentId = Input::get('parent_id');
$perms = $db->query("SELECT * FROM permissions ORDER BY name")->results();
$permNames = ["0" => "Public"];
foreach ($perms as $p) {
  $permNames[$p->id] = $p->name;
}
$index = $db->query("SELECT DISTINCT z_index FROM us_menus ORDER BY z_index")->results();
$indexes = [];
foreach ($index as $i) {
  $indexes[] = $i->z_index;
}
$parentOpts = $db->query("SELECT * FROM us_menu_items WHERE menu = ? AND `type` = ? ORDER BY label", [$menuId, "dropdown"])->results();
$switchParent = ["0" => "Top Level"];
foreach ($parentOpts as $p) {
  $switchParent[$p->id] = $p->label;
}


$item = false;
$lastOrder = 0;
if ($parentId) {
  $lastSibling = $db->query("SELECT * FROM us_menu_items WHERE parent = ? AND menu = ? ORDER BY display_order DESC", [$parentId, $menuId])->first();
  if ($lastSibling) {
    $lastOrder = $lastSibling->display_order;
  }
}
$children = [];
if ($itemId !== 'new') {
  $item = $db->query("SELECT * FROM us_menu_items WHERE id = ? AND menu = ?", [$itemId, $menuId])->first();
  $children = $db->query("SELECT * FROM us_menu_items WHERE menu = ? AND parent = ? ORDER BY display_order", [$menuId, $itemId])->results();
}
if($itemId == 'new' && $itemId !== 0) {
  $item = (object)['id' => '', 'menu' => $menuId, 'type' => 'link',  'label' => '', 'link' => '', 'icon_class' => '', 'link_target' => '_self', 'parent' => $parentId, 'display_order' => $lastOrder + 1, 'li_class' => '', 'a_class' => '', 'permissions' => "[0]", 'disabled' => "0"];
}
if ($item) {
  $item->permissions = json_decode($item->permissions, true);
}
$menuObj = new Menu($menuId);
$menu = $menuObj->menu;
if ($menuId == 'new' || !$menu) {
  $menu = (object)['id' => '', 'menu_name' => '', 'disabled' => 0, 'theme' => 'light', 'type' => 'horizontal', 'justify' => 'right', 'nav_class' => '', 'z_index' => 50, 'brand_html' => ''];
}

$snippets = [];

$folders = ["users/includes/menu_hooks", "usersc/hooks/menu"];
$usplugins = parse_ini_file($abs_us_root . $us_url_root . 'usersc/plugins/plugins.ini.php', true);
foreach ($usplugins as $k => $v) {
  if ($v == 1) {
    if (is_dir($abs_us_root . $us_url_root . 'usersc/plugins/' . $k . '/menu_hooks')) {
      $folders[] = 'usersc/plugins/' . $k . '/menu_hooks';
    }
  }
}


foreach ($folders as $f) {
  $fetch = fetchFolderFiles($f);

  foreach ($fetch['links'] as $l) {
    $snippets[] = $l;
  }
}


if ($_POST) {
  $parentId = Input::get('parent');
  if ($item) {
    $fields = ['type', 'label', 'link', 'icon_class', 'link_target', 'a_class', 'li_class', 'disabled'];
    $data = ['menu' => $menuId, 'parent' => $parentId];
    foreach ($fields as $field) {
      $data[$field] = Input::get($field);
      $item->{$field} = Input::get($field);
    }

    if ($data['type'] == "snippet") {
      $data['link'] = Input::get('snippet');
    }

    if ($data['type'] == "link" && $data['link'] == "") {
      $data['link'] = "#";
    }
    $data['permissions'] = json_encode(Input::get('permissions'));
    if ($itemId == 'new') {
      $data['display_order'] = $lastOrder + 1;
      $db->insert('us_menu_items', $data);
      $itemId = $db->lastId();
      $success = !$db->error();
    } else {
      $success = $db->update('us_menu_items', $itemId, $data);
      $menuObj = new Menu($menuId);
    }
    if ($success) {
      Redirect::to("{$us_url_root}users/admin.php?view=edit_menu&menu_id={$menuId}&item_id={$itemId}&parent_id={$parentId}");
    }
  } else {
    // $data = [
    //   'menu_name' => Input::get('menu_name'), 'disabled' => Input::get('disabled'),
    //   'theme' => Input::get('theme'), 'type' => Input::get('menu_type'), 'nav_class' => Input::get('nav_class'),
    //   'z_index' => Input::get('z_index'), 'brand_html' => $_POST['brand_html'],'justify'=>Input::get('justify')
    // ];
    $data = [
      'menu_name' => Input::get('menu_name'), 'disabled' => Input::get('disabled'),
      'theme' => Input::get('theme'), 'type' => Input::get('menu_type'), 'nav_class' => Input::get('nav_class'),
      'z_index' => Input::get('z_index'), 'brand_html' => Input::get('brand_html'), 'justify' => Input::get('justify')
    ];
    if ($menuId == 'new') {
      $success = $db->insert('us_menus', $data);
      if ($success) {
        $menuId = $db->lastId();
      }
    } else {
      $success = $db->update('us_menus', $menuId, $data);
    }
    if ($success) {
      Redirect::to("{$us_url_root}users/admin.php?view=edit_menu&menu_id={$menuId}");
    }
  }
}
?>

<div class="row mb-2">
  <div class="col-12 col-sm-6">
    <h2>
      <?php
      if(isset($item->label)){
        $heading = $item->label;
      }elseif($itemId !== "new"){
        $heading = $menu->menu_name;
      }else{
        $heading = "New Item";
      }
      echo $heading;
      ?>
    </h2>
  </div>
  <div class="col-12 col-sm-6 text-end">
    <a href="<?=$us_url_root?>users/admin.php?view=menus" class="btn btn-dark">Return to Menu Manager</a>
  </div>

</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-4">
        <?php if ($item) : ?>

          <form method="post">

            <div class="form-group">
              <label for="menu_name">Label</label>
              <input id="label" name="label" class="form-control" value="<?= $item->label ?>" onchange="setDirty(true)" />
              <small class="form-text text-muted">For multilanguage, use any language key in users/lang/en-US.php and wrap the key in {{THIS_LANGUAGE}} and it will be translated. Add your own keys in usersc/lang. </small>
            </div>

            <div class="form-group">
              <label for="permissions">Permissions</label><br>
              <div class="form-check form-check-inline">
                <input class="form-check-input perm-check" type="checkbox" id="permission_0" name="permissions[]" value="0" <?= in_array(0, $item->permissions) ? 'checked' : "" ?>>
                <label class="form-check-label" for="permission_0">Public</label>
              </div>
              <?php foreach ($perms as $perm) : ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input other-perms perm-check" type="checkbox" id="permission_<?= $perm->id ?>" name="permissions[]" value="<?= $perm->id ?>" <?= in_array($perm->id, $item->permissions) ? 'checked' : "" ?>>
                  <label class="form-check-label" for="permission_<?= $perm->id ?>"><?= $perm->name ?></label>
                </div>
              <?php endforeach; ?>
              <br><small class="form-text text-muted">"Public" is for non logged in users. If you want all users to see a menu item, use the permission "User".</small>
            </div>


            <div class="form-group">
              <label for="li_class">li Class</label>
              <input id="li_class" name="li_class" class="form-control" value="<?= $item->li_class ?>" onchange="setDirty(true)" />
              <small class="form-text text-muted">Custom Class to add to the li tag.</small>
            </div>

            <div class="form-group">
              <label for="icon_class">Icon Class</label>
              <input id="icon_class" name="icon_class" class="form-control" value="<?= $item->icon_class ?>" onchange="setDirty(true)" />
              <small class="form-text text-muted">If you add a font awesome icon class the menu item will have an icon before the label. ie "fa fa-home"</small>
            </div>

            <div class="form-group">
              <label for="type">Type</label>
              <select name="type" id="type" class="form-control" onchange="setDirty(true)">
                <option value="" <?= $item->type == '' ? 'selected' : '' ?>>Choose Type</option>
                <option value="link" <?= $item->type == 'link' ? 'selected' : '' ?>>Link</option>
                <option value="dropdown" <?= $item->type == 'dropdown' ? 'selected' : '' ?>>Dropdown</option>
                <option value="separator" <?= $item->type == 'separator' ? 'selected' : '' ?>>Separator</option>
                <option value="snippet" <?= $item->type == 'snippet' ? 'selected' : '' ?>>Snippet</option>
              </select>
            </div>
            <div id="link_wrapper">
              <div class="form-group">
                <label for="link">Link</label>
                <input id="link" name="link" class="form-control" value="<?= $item->link ?>" onchange="setDirty(true)" />
                <small class="form-text text-muted">This will be placed in the href attribute of the link</small>
              </div>

              <div class="form-group">
                <label for="a_class">A Class</label>
                <input id="a_class" name="a_class" class="form-control" value="<?= $item->a_class ?>" onchange="setDirty(true)" />
                <small class="form-text text-muted">Custom Class to add to the a tag.</small>
              </div>
            </div>

            <div class="form-group" id="snippet_wrapper">
              <label for="snippet">Snippet</label>
              <select class="form-control" name="snippet" id="snippet" onchange="setDirty(true)">
                <option value=""></option>
                <?php foreach ($snippets as $s) {
                  $s = str_replace($us_url_root, "", $s);
                ?>
                  <option <?php if ($item->link == $s) {
                            echo "selected='selected'";
                          } ?> value="<?= $s ?>"><?= $s ?></option>
                <?php } ?>
              </select>
              <small class="form-text text-muted">Snippets can be located in usersc/hooks/menu or in a plug-in's menu_hooks folder.</small>
            </div>

            <div class="form-group" id="target_wrapper">
              <label for="link_target">Target</label>
              <select class="form-control" name="link_target" id="link_target" onchange="setDirty(true)">
                <option value="_self">Self</option>
                <option value="_blank">Blank</option>
                <option value="_parent">Parent</option>
              </select>
              <small class="form-text text-muted">Default behavior is self.</small>
            </div>

            <div class="form-group" id="parent_wrapper">
              <label for="parent">Parent</label>
              <select class="form-control" name="parent" id="parent" onchange="setDirty(true)">
                <option value="<?php if($item){ echo $item->parent; }  ?>"><?php if($item){ echo parseMenuLabel($switchParent[$item->parent]);}  ?> (Current)</option>
                <?php
                foreach ($switchParent as $k => $v) {
                  if ($k == $item->parent) {
                    continue;
                  }
                ?>
                  <option value="<?= $k ?>"><?= parseMenuLabel($v); ?></option>
                <?php } ?>
              </select>
              <small class="form-text text-muted">Use this to move a menu item (and its children) to a different branch of the menu tree.</small>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" id="disabled" name="disabled" <?= $item->disabled ? "checked" : "" ?> onchange="setDirty(true)">
              <label class="form-check-label" for="disabled">
                Disabled
              </label>
            </div>

            <div class="d-flex justify-content-end align-items-center">
              <a class="btn btn-secondary mr-1" href="<?= $us_url_root ?>users/admin.php?view=menus">Cancel</a>
              <button type="submit" onclick="setDirty(false)" class="btn btn-primary save-button">Save</button>
            </div>
          </form>
        <?php else : ?>
          <form method="post">

            <div class="form-group">
              <label for="menu_name">Menu Name</label>
              <input id="menu_name" name="menu_name" class="form-control" value="<?= $menu->menu_name ?>" onchange="setDirty(true)" />
            </div>

            <div class="form-group">
              <label for="menu_type">Menu Type</label>
              <select name="menu_type" id="menu_type" class="form-control">
                <!-- <option value="">Choose Menu Type</option> -->
                <option value="horizontal" <?= $menu->type == 'horizontal' ? 'selected' : '' ?>>Horizontal</option>
                <option value="vertical" <?= $menu->type == 'vertical' ? 'selected' : '' ?>>Vertical</option>
                <option value="accordion" <?= $menu->type == 'accordion' ? 'selected' : '' ?>>Accordion</option>
              </select>
            </div>

            <div class="form-group" id="justify_wrapper">
              <label for="menu_type">Horizontal Menu Justification</label>
              <select name="justify" id="justify" class="form-control">
                <!-- <option value="">Choose Justification</option> -->
                <option value="right" <?= $menu->justify == 'right' ? 'selected' : '' ?>>Right</option>
                <option value="left" <?= $menu->justify == 'left' ? 'selected' : '' ?>>Left</option>
              </select>
            </div>

            <div class="form-group">
              <label for="nav_class">Menu Class</label>
              <input id="nav_class" name="nav_class" class="form-control" value="<?= $menu->nav_class ?>" onchange="setDirty(true)" />
              <small class="form-text text-muted">Add custom class to the top level UL element. You can often use bg-primary to or bg-danger etc to use one of your template button colors as a menu background to make your menu feel more integrated.</small>
            </div>

            <div class="form-group">
              <label for="theme">Theme</label>
              <select name="theme" id="theme" class="form-control">
                <option value="">Choose Theme</option>
                <option value="light" <?= $menu->theme == 'light' ? 'selected' : '' ?>>Light</option>
                <option value="dark" <?= $menu->theme == 'dark' ? 'selected' : '' ?>>Dark</option>
              </select>
            </div>

            <div class="form-group">
              <label for="z_index">Z Index</label>
              <input id="z_index" name="z_index" type="number" step="5" min="0" class="form-control" value="<?= $menu->z_index ?>" onchange="setDirty(true)" />
              Currently used z-indexes: <b><?= oxfordList($indexes); ?></b>
              <small class="form-text text-muted">If you have multiple menus you most likely will want to set different z-index so that they do not clash. </small>


            </div>

            <div class="form-group">
              <label for="brand_html">Brand HTML</label>
              <textarea id="brand_html" name="brand_html" class="form-control" rows="10" onchange="setDirty(true)"><?= trim(html_entity_decode($menu->brand_html ?? '', ENT_QUOTES, 'UTF-8')) ?>
                </textarea>
              <small class="form-text text-muted">This box accepts html and javascript. For links and other resources that require a path, you can substitute {{root}} where you would normally use $us_url_root.</small>
            </div>

            <div class="form-check">
              <input class="form-check-input" type="checkbox" value="1" id="disabled" name="disabled" <?= $menu->disabled ? "checked" : "" ?> onchange="setDirty(true)">
              <label class="form-check-label" for="disabled">
                Disabled
              </label>
            </div>

            <div class="d-flex justify-content-end align-items-center">
              <a class="btn btn-secondary mr-1" href="<?= $us_url_root ?>users/admin.php?view=menus">Cancel</a>
              <button type="submit" onclick="setDirty(false)" class="btn btn-primary">Save</button>
            </div>
          </form>
        <?php endif; ?>
      </div>
      <div class="col-md-6">
        <div id="menu_items_wrapper" style="display: <?= $item ? 'none' : 'block' ?>;">
          <?php if ($menuId != 'new') : ?>
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h3>Items</h3>
              <a class="btn btn-sm btn-dark" href="<?= $us_url_root ?>users/admin.php?view=edit_menu&menu_id=<?= $menuId ?>&item_id=new&parent_id=<?= $itemId ?>">Add Item</a>
            </div>
            <table class="table table-sm">
              <thead>
                <tr>
                  <th></th>
                  <th>Label</th>
                  <th>Language Key</th>
                  <th>Permissions</th>
                  <th>Status</th>
                  <th class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody id="menu_items_sortable">
                <?php foreach ($children as $child) :
                  $parsedLabel = parseMenuLabel($child->label);
                ?>
                  <tr class="child-sortable" data-id="<?= $child->id ?>">
                    <td class="text-muted"><i class="fa fa-arrows"></i></td>
                    <td><?= $parsedLabel ?></td>
                    <td>
                      <?php if ($parsedLabel != $child->label) {
                        echo $child->label;
                      } ?>
                    </td>
                    <td>
                      <?php $cperms = json_decode($child->permissions);
                      $string = "";
                      foreach ($cperms as $k => $v) {
                        if (array_key_exists($v, $permNames)) {
                          $string .= $permNames[$v] . ", ";
                        }
                      }
                      $string = rtrim($string, ", ");
                      if ($string == "") {
                        $string = "None";
                      }
                      echo $string;
                      ?>
                    </td>
                    <td>
                      <?php if ($child->disabled == 0) {
                        echo "Enabled";
                      } else {
                        echo "Disabled";
                      }
                      ?>
                    </td>
                    <td class="text-end">
                      <a class="btn btn-sm btn-outline-dark mr-1" href="<?= $us_url_root ?>users/admin.php?view=edit_menu&menu_id=<?= $menuId ?>&item_id=<?= $child->id ?>&parent_id=<?= $child->parent ?>"><i class="fa fa-pencil"></i></a>
                      <button class="btn btn-sm btn-outline-danger mr-1" onclick="usDeleteMenuItem('<?= $child->id ?>')"><i class="fa fa-trash"></i></button>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </div>
      <div class="col-md-2">
        <?php if ($menuId != 'new') : ?>
          <h3 class="text-center">Mini Map</h3>
          <p class="text-center border-bottom mb-2">(Click to Jump to an Item)</p>
          <?= $menuObj->miniMap($itemId); ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<script>
  let dirty = false;

  function setDirty(state) {
    dirty = state;
  }
  window.addEventListener('beforeunload', (event) => {
    if (dirty) {
      event.preventDefault();
      event.returnValue = '';
    }
  });
  $(document).ready(function() {
    const type = $('#type').val();
    updateDisplayFields(type);
    // setTimeout(()=>{
    //   setDirty(false);
    // }, 250);
    // perms have been updated to allow one item to be public and private
    // $( "#permission_0" ).change(function() {
    //   var value = $(this).prop("checked");
    //   if(value == true){
    //     $(".other-perms").prop("checked",false);
    //   }
    // });
    // $( ".other-perms" ).change(function() {
    //   var value = $(this).prop("checked");
    //   if(value == true){
    //     $("#permission_0").prop("checked",false);
    //   }
    // });

  });

  $('#type').change(function() {
    const type = $(this).val();
    updateDisplayFields(type);
  });

  function updateDisplayFields(type) {
    if (type === 'dropdown') {
      $('#snippet_wrapper').hide();
      $('#menu_items_wrapper').show();
      $('#link_wrapper').hide();
      $('#target_wrapper').hide();
    } else if (type === 'link') {
      $('#snippet_wrapper').hide();
      $('#menu_items_wrapper').hide();
      $('#link_wrapper').show();
      $('#target_wrapper').show();
    } else if (type === 'separator') {
      $('#snippet_wrapper').hide();
      $('#menu_items_wrapper').hide();
      $('#link_wrapper').hide();
      $('#target_wrapper').hide();
    } else if (type === 'snippet') {
      $('#snippet_wrapper').show();
      $('#menu_items_wrapper').hide();
      $('#link_wrapper').hide();
      $('#target_wrapper').hide();
    }
  }

  $('#menu_type').change(function() {
    const type = $(this).val();
    updateMenuDisplayFields(type);
  });

  $('.perm-check').change(function() {
    if ($('.perm-check:checkbox:checked').length > 0) {
      $(".save-button").html("Save");
      $(".save-button").prop('disabled', false);

    } else {
      $(".save-button").prop('disabled', true);
      $(".save-button").html("Please select at least 1 permission");
      console.log("nothing is checked");
    }

  });

  function updateMenuDisplayFields(type) {
    if (type === 'horizontal') {
      $('#justify_wrapper').show();
    } else {
      $('#justify_wrapper').hide();
    }
  }

  var childrenEl = document.getElementById('menu_items_sortable');
  new Sortable(childrenEl, {
    sortable: true,
    draggable: '.child-sortable',
    group: {
      name: "children",
      put: false,
      pull: false
    },
    store: {
      set: (sortable) => {
        var order = sortable.toArray();
        $.ajax({
          url: '<?= $us_url_root ?>users/parsers/menus.php',
          type: 'POST',
          dataType: 'json',
          data: {
            action: 'sort_menu_items',
            order,
            menu_id: '<?= $menuId ?>',
            item_id: '<?= $itemId ?>',
            token: '<?= Token::generate() ?>'
          }
        });
      }
    }
  });

  function usDeleteMenuItem(itemId) {
    if (window.confirm("Are you sure you want to delete this menu item? This cannot be undone.")) {
      window.location.href = `<?= $us_url_root ?>users/admin.php?view=delete_menu_item&menu_id=<?= $menuId ?>&item_id=${itemId}`;
    }
  }
</script>
