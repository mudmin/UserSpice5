<?php
// PHP Goes Here!
$hooks = getMyHooks(['page' => 'adminPage']);
$pageId = Input::get('id');
$errors = [];
$successes = [];

// Check if selected pages exist
if (!pageIdExists($pageId)) {
  Redirect::to($us_url_root . 'users/admin.php?view=pages');
  exit();
}

$pageDetails = fetchPageDetails($pageId); // Fetch information specific to page

/**
 * Decode the JSON permission list stored on us_menu_items into an array of string IDs.
 */
function adminPageDecodeMenuPerms($json) {
  $decoded = json_decode($json ?? '', true);
  if (!is_array($decoded)) return [];
  return array_values(array_map('strval', $decoded));
}

/**
 * Page perm IDs as strings. For a public page, treat as ["0"] so it lines up with menu "Public".
 */
function adminPagePerms($pagePermissions, $pageDetails) {
  if ($pageDetails->private == 0) return ["0"];
  $out = [];
  foreach ($pagePermissions as $p) { $out[] = (string)$p->permission_id; }
  sort($out);
  return $out;
}

/**
 * Strip {{}} wrapper from a lang-key style label, return null if not in that form.
 */
function adminPageExtractLangKey($label) {
  if ($label === null) return null;
  $trim = trim($label);
  if (strlen($trim) > 4 && substr($trim, 0, 2) === '{{' && substr($trim, -2) === '}}') {
    return substr($trim, 2, -2);
  }
  return null;
}

// Forms posted
if (Input::exists()) {
  $token = Input::get('csrf');
  if (!Token::check($token)) {
    include $abs_us_root . $us_url_root . 'usersc/scripts/token_error.php';
  }
  $update = 0;

  $private = Input::get('private');

  // Toggle private page setting
  if ($private == 0) {
    if ($pageDetails->private == 1) {
      if (updatePrivate($pageId, 0)) {
        usSuccess(lang('PAGE_PRIVATE_TOGGLED', ['public']));

        logger($user->data()->id, 'Pages Manager', "Changed private from private to public for Page #$pageId.");
      } else {
        usError(lang('SQL_ERROR'));
      }
    }
  }

  if ($private == 1) {

    if ($pageDetails->private == 0) {
      if (updatePrivate($pageId,1)) {
        usSuccess(lang('PAGE_PRIVATE_TOGGLED', ['private']));
        logger($user->data()->id, 'Pages Manager', "Changed private from public to private for Page #$pageId.");
      } else {
        usError(lang('SQL_ERROR'));
      }
    }
  }



  // Remove permission level(s) access to page
  if (!empty($_POST['removePermission'])) {
    $remove = Input::get('removePermission');
    if ($deletion_count = removePage($pageId, $remove)) {
      usSuccess(lang('PAGE_ACCESS_REMOVED', [$deletion_count]));
      logger($user->data()->id, 'Pages Manager', "Deleted $deletion_count permission(s) from $pageDetails->page.");
    } else {
      usError(lang('SQL_ERROR'));
    }
  }

  // Add permission level(s) access to page
  if (!empty($_POST['addPermission'])) {
    $add = Input::get('addPermission');
    $addition_count = 0;
    foreach ($add as $perm_id) {
      if (addPage($pageId, $perm_id)) {
        ++$addition_count;
      }
    }
    if ($addition_count > 0) {
      usSuccess(lang('PAGE_ACCESS_ADDED', [$addition_count]));
      logger($user->data()->id, 'Pages Manager', "Added $addition_count permission(s) to $pageDetails->page.");
    }
  }

  // Changed title for page
  if ($_POST['changeTitle'] != $pageDetails->title) {
    $newTitle = Input::get('changeTitle');
    if ($db->query('UPDATE pages SET title = ? WHERE id = ?', [$newTitle, $pageDetails->id])) {
      usSuccess(lang('PAGE_RETITLED', [$newTitle]));
      logger($user->data()->id, 'Pages Manager', "Retitled '{$pageDetails->page}' to '$newTitle'.");
    } else {
      usError(lang('SQL_ERROR'));
    }
  }

  // Changed lang_key for page
  $newLangKey = Input::get('changeLangKey');
  $currentLangKey = $pageDetails->lang_key ?? '';
  if ($newLangKey != $currentLangKey) {
    $langKeyValue = $newLangKey === '' ? null : $newLangKey;
    if ($db->query('UPDATE pages SET lang_key = ? WHERE id = ?', [$langKeyValue, $pageDetails->id])) {
      if ($langKeyValue) {
        usSuccess("Language key updated to '$langKeyValue'.");
        logger($user->data()->id, 'Pages Manager', "Set lang_key to '$langKeyValue' for '{$pageDetails->page}'.");
      } else {
        usSuccess("Language key removed.");
        logger($user->data()->id, 'Pages Manager', "Removed lang_key for '{$pageDetails->page}'.");
      }
    } else {
      usError(lang('SQL_ERROR'));
    }
  }

  // UltraMenu integration actions. The button name encodes "action:targetId".
  $menuAction = Input::get('menu_action');
  if ($menuAction !== '' && strpos($menuAction, ':') !== false) {
    list($mAct, $mTarget) = explode(':', $menuAction, 2);
    $mTarget = (int)$mTarget;
    $refreshedPagePerms = fetchPagePermissions($pageId);
    $pagePermIds = adminPagePerms($refreshedPagePerms, fetchPageDetails($pageId));
    $pageDetailsForMenu = fetchPageDetails($pageId);
    $insertLabel = !empty($pageDetailsForMenu->lang_key)
      ? '{{' . $pageDetailsForMenu->lang_key . '}}'
      : ($pageDetailsForMenu->title ?: $pageDetailsForMenu->page);

    if ($mAct === 'insert' || $mAct === 'goto') {
      $menuRow = $db->query('SELECT id FROM us_menus WHERE id = ?', [$mTarget])->first();
      $existing = $menuRow
        ? $db->query('SELECT id FROM us_menu_items WHERE menu = ? AND link = ?', [$mTarget, $pageDetailsForMenu->page])->first()
        : null;
      if ($menuRow && !$existing && $mAct === 'insert') {
        $lastOrderRow = $db->query('SELECT COALESCE(MAX(display_order),0) AS mo FROM us_menu_items WHERE menu = ?', [$mTarget])->first();
        $nextOrder = ($lastOrderRow ? (int)$lastOrderRow->mo : 0) + 1;
        $db->query(
          'INSERT INTO us_menu_items (menu, type, label, link, parent, display_order, disabled, permissions) VALUES (?, ?, ?, ?, 0, ?, 0, ?)',
          [$mTarget, 'link', $insertLabel, $pageDetailsForMenu->page, $nextOrder, json_encode($pagePermIds)]
        );
        usSuccess("Inserted into menu.");
        logger($user->data()->id, 'Pages Manager', "Inserted '{$pageDetailsForMenu->page}' into menu #$mTarget.");
      } elseif ($menuRow && $mAct === 'goto') {
        // If not in menu yet, insert first so we have an item to land on.
        if (!$existing) {
          $lastOrderRow = $db->query('SELECT COALESCE(MAX(display_order),0) AS mo FROM us_menu_items WHERE menu = ?', [$mTarget])->first();
          $nextOrder = ($lastOrderRow ? (int)$lastOrderRow->mo : 0) + 1;
          $db->query(
            'INSERT INTO us_menu_items (menu, type, label, link, parent, display_order, disabled, permissions) VALUES (?, ?, ?, ?, 0, ?, 0, ?)',
            [$mTarget, 'link', $insertLabel, $pageDetailsForMenu->page, $nextOrder, json_encode($pagePermIds)]
          );
          logger($user->data()->id, 'Pages Manager', "Inserted '{$pageDetailsForMenu->page}' into menu #$mTarget (via Update & Go).");
          $existing = $db->query('SELECT id, parent FROM us_menu_items WHERE menu = ? AND link = ?', [$mTarget, $pageDetailsForMenu->page])->first();
        } else {
          $existing = $db->query('SELECT id, parent FROM us_menu_items WHERE menu = ? AND link = ?', [$mTarget, $pageDetailsForMenu->page])->first();
        }
        if ($existing) {
          $_SESSION['redirect_after_save'] = true;
          $_SESSION['redirect_after_uri'] = $us_url_root . 'users/admin.php?view=edit_menu&menu_id=' . $mTarget . '&item_id=' . $existing->id . '&parent_id=' . (int)$existing->parent;
        }
      }
    } elseif ($mAct === 'sync_perms') {
      $itemRow = $db->query('SELECT id, menu FROM us_menu_items WHERE id = ?', [$mTarget])->first();
      if ($itemRow) {
        $db->query('UPDATE us_menu_items SET permissions = ? WHERE id = ?', [json_encode($pagePermIds), $mTarget]);
        usSuccess("Synced menu item permissions.");
        logger($user->data()->id, 'Pages Manager', "Synced perms to menu item #$mTarget for '{$pageDetailsForMenu->page}'.");
      }
    } elseif ($mAct === 'sync_label') {
      $itemRow = $db->query('SELECT id FROM us_menu_items WHERE id = ?', [$mTarget])->first();
      if ($itemRow) {
        $db->query('UPDATE us_menu_items SET label = ? WHERE id = ?', [$insertLabel, $mTarget]);
        usSuccess("Synced menu item label.");
        logger($user->data()->id, 'Pages Manager', "Synced label to '$insertLabel' on menu item #$mTarget.");
      }
    }
  }

  includeHook($hooks, 'post');
  $pageDetails = fetchPageDetails($pageId);
  if (isset($_SESSION['redirect_after_save']) && $_SESSION['redirect_after_save'] == true) {
    if (!empty($_SESSION['redirect_after_uri'])) {
      $redirect_uri = $_SESSION['redirect_after_uri'];
      unset($_SESSION['redirect_after_save']);
      unset($_SESSION['redirect_after_uri']);
      Redirect::to(html_entity_decode($redirect_uri));
    }
  }
  if (Input::get('return') != '') {
    Redirect::to('admin.php?view=pages');
  }
}
$pagePermissions = fetchPagePermissions($pageId);
$permissionData = fetchAllPermissions();
$countQ = $db->query('SELECT id, permission_id FROM permission_page_matches WHERE page_id = ? ', [$pageId]);
$countCountQ = $countQ->count();

// UltraMenu integration: per-menu lookup of items linking to this page.
$ultraMenus = $db->query('SELECT id, menu_name FROM us_menus ORDER BY id')->results();
$ultraItemsByMenu = [];
foreach ($ultraMenus as $um) {
  $row = $db->query('SELECT id, label, permissions, parent FROM us_menu_items WHERE menu = ? AND link = ? LIMIT 1', [$um->id, $pageDetails->page])->first();
  $ultraItemsByMenu[$um->id] = $row ?: null;
}
$permNameLookup = ["0" => "Public"];
foreach ($permissionData as $pn) { $permNameLookup[(string)$pn->id] = $pn->name; }
$pagePermIdsForCompare = adminPagePerms($pagePermissions, $pageDetails);
$pageLangKey = $pageDetails->lang_key ?? null;
$desiredLabel = !empty($pageLangKey) ? '{{' . $pageLangKey . '}}' : ($pageDetails->title ?: $pageDetails->page);
?>
<form action='' method='post'>
  <?= tokenHere(); ?>
  <h2>Page Permissions</h2>
  <div class="row">
    <div class="col-12 col-sm-6">
      <h4><a href="<?= $us_url_root . $pageDetails->page?>" target="_blank"><span style="color:blue;"><?= $pageDetails->page; ?></span></a></h4>
      <h5>Page ID: <?= $pageDetails->id ?></h5>
    </div>
    <div class="col-12 col-sm-6">
      <span class="float-end">
        <a class='btn btn-warning' href="<?php echo $us_url_root; ?>users/admin.php?view=pages">Cancel</a>
        <input class='btn btn-secondary' name="return" type='submit' value='Update & Close' class='submit' />
        <input class='btn btn-primary' type='submit' value='Update' class='submit' />
      </span>
    </div>
  </div>
  <div class="row">
    <div class="col-12 col-md-6">
      <div class="form-group">
        <label for="title">Page Title:</label> <span class="small">(This is the text that's displayed on the browser's titlebar or tab)</span>

        <input type="text" class="form-control" name="changeTitle" maxlength="50" value="<?php echo $pageDetails->title; ?>" />
      </div>
      <div class="form-group">
        <label for="langKey">Language Key:</label> <span class="small">(Optional - if set, this lang() key will be used instead of the title above)</span>

        <input type="text" class="form-control" name="changeLangKey" maxlength="100" value="<?php echo htmlspecialchars($pageDetails->lang_key ?? ''); ?>" placeholder="e.g. PAGE_TITLE_HOME" />
      </div>
      <div class="form-group">
        <label for="">Set this page as private?</label>
        <select class="form-control mb-2" name="private" required>
          <option value="0" <?php if ($pageDetails->private == 0) {
                              echo "selected='selected'";
                            } ?>>This Page is Public</option>
          <option value="1" <?php if ($pageDetails->private == 1) {
                              echo "selected='selected'";
                            } ?>>This Page is Private (Protected)</option>
        </select>
        <p>Marking a page as 'private' will cause UserSpice to protect this page with the securePage function that is at the top of every page. Please also note that the folder this page resides in must also be set on the <a href="admin.php?view=pages">Admin Pages</a> dashboard. Marking it public will allow the page to be visible to all site visitors.</p>
      </div>
      <?php
      includeHook($hooks, 'form');
      ?>

    </div>
    <div class="col-12 col-md-6">
      <div class="card mb-3">
        <div class="card-header py-2">
          <strong>UltraMenu Integration</strong>
          <span class="small text-body-secondary">— how this page is wired into each menu</span>
        </div>
        <div class="card-body p-2">
          <?php if (empty($ultraMenus)) { ?>
            <p class="small text-body-secondary mb-0">No UltraMenus defined yet. Create one at <a href="<?= $us_url_root ?>users/admin.php?view=menus">UltraMenu</a>.</p>
          <?php } else { ?>
            <table class="table table-sm mb-0">
              <thead>
                <tr>
                  <th class="small">Menu</th>
                  <th class="small">Status / Label</th>
                  <th class="small">Perms</th>
                  <th class="small text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($ultraMenus as $um) {
                  $item = $ultraItemsByMenu[$um->id];
                  $inMenu = $item !== null;
                  $resolvedLabel = $inMenu ? parseMenuLabel($item->label) : '';
                  $rawLabel = $inMenu ? $item->label : '';
                  $itemLangKey = $inMenu ? adminPageExtractLangKey($rawLabel) : null;
                  $labelInSync = false;
                  if ($inMenu) {
                    if (!empty($pageLangKey)) {
                      $labelInSync = ($itemLangKey === $pageLangKey);
                    } else {
                      $labelInSync = ($rawLabel === ($pageDetails->title ?: $pageDetails->page));
                    }
                  }
                  $itemPerms = $inMenu ? adminPageDecodeMenuPerms($item->permissions) : [];
                  $itemPermsSorted = $itemPerms; sort($itemPermsSorted);
                  $permsInSync = $inMenu && ($itemPermsSorted === $pagePermIdsForCompare);
                ?>
                  <tr>
                    <td class="small align-middle"><?= htmlspecialchars($um->menu_name) ?></td>
                    <td class="small align-middle">
                      <?php if ($inMenu) { ?>
                        <span class="badge bg-success">In menu</span>
                        <div><?= htmlspecialchars($resolvedLabel) ?></div>
                        <?php if ($itemLangKey !== null) { ?>
                          <div class="text-body-secondary" style="font-size:0.75rem;">lang: <?= htmlspecialchars($itemLangKey) ?></div>
                        <?php } ?>
                        <?php if (!$labelInSync) { ?>
                          <div class="text-warning" style="font-size:0.75rem;">label differs from page</div>
                        <?php } ?>
                      <?php } else { ?>
                        <span class="badge bg-secondary">Not in menu</span>
                      <?php } ?>
                    </td>
                    <td class="small align-middle">
                      <?php if ($inMenu) {
                        $names = [];
                        foreach ($itemPerms as $pid) { $names[] = $permNameLookup[$pid] ?? ('#' . $pid); }
                        echo htmlspecialchars($names ? implode(', ', $names) : '(none)');
                        if ($permsInSync) {
                          echo ' <span class="text-success">&#10003;</span>';
                        } else {
                          echo ' <span class="text-warning" title="differs from page">&#9888;</span>';
                        }
                      } else { echo '<span class="text-body-secondary">&mdash;</span>'; } ?>
                    </td>
                    <td class="small align-middle text-end">
                      <?php if (!$inMenu) { ?>
                        <button type="submit" name="menu_action" value="insert:<?= (int)$um->id ?>" class="btn btn-sm btn-success">Insert</button>
                      <?php } else { ?>
                        <?php if (!$permsInSync) { ?>
                          <button type="submit" name="menu_action" value="sync_perms:<?= (int)$item->id ?>" class="btn btn-sm btn-outline-warning" title="Push page perms to this menu item">Sync Perms</button>
                        <?php } ?>
                        <?php if (!$labelInSync) { ?>
                          <button type="submit" name="menu_action" value="sync_label:<?= (int)$item->id ?>" class="btn btn-sm btn-outline-warning" title="Push page title/lang key to this menu item">Sync Label</button>
                        <?php } ?>
                        <a class="btn btn-sm btn-outline-dark" href="<?= $us_url_root ?>users/admin.php?view=edit_menu&menu_id=<?= (int)$um->id ?>&item_id=<?= (int)$item->id ?>&parent_id=<?= (int)$item->parent ?>" title="Open in UltraMenu editor">Edit &rarr;</a>
                      <?php } ?>
                      <button type="submit" name="menu_action" value="goto:<?= (int)$um->id ?>" class="btn btn-sm btn-primary" title="Save page then jump to this menu item">Update &amp; Go</button>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-12 col-md-6">
          <label for="">Remove Permission</label>
          <div class="form-group">
            <?php
            // Display list of permission levels with access
            $perm_ids = [];
            foreach ($pagePermissions as $perm) {
              $perm_ids[] = $perm->permission_id;
            }
            foreach ($permissionData as $v1) {
              if (in_array($v1->id, $perm_ids)) { ?>
                <label class="normal"><input type='checkbox' name='removePermission[]' id='removePermission[]' value='<?php echo $v1->id; ?>'> <?php echo $v1->name; ?></label><br />
            <?php }
            } ?>
          </div>
        </div>

        <div class="col-12 col-md-6">
          <label for="">Add Permissions</label>
          <div class="form-group">
            <?php
            // Display list of permission levels without access
            foreach ($permissionData as $v1) {
              if (!in_array($v1->id, $perm_ids)) { ?>
                <?php if ($settings->page_permission_restriction == 0) { ?><label class="normal"><input type='checkbox' name='addPermission[]' id='addPermission[]' value='<?php echo $v1->id; ?>'> <?php echo $v1->name; ?></label><br /><?php } ?>

                <?php if ($settings->page_permission_restriction == 1) { ?><label class="normal"><input type="radio" name="addPermission[]" id="addPermission[]" value="<?php echo $v1->id; ?>" <?php if ($countCountQ > 0 || $pageDetails->private == 0) { ?> disabled <?php } ?>>
                    <?php echo $v1->name; ?></label><br />
            <?php }
              }
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
