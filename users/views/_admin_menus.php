<?php
$db = DB::getInstance();
$menus = $db->query("SELECT * FROM us_menus")->results();
$count = $db->query("SELECT z_index as z, COUNT(*) z_index FROM us_menus GROUP BY z_index HAVING z_index > 1")->results();
$dupes = [];
foreach ($count as $c) {
  if ($c->z_index > 1) {
    $dupes[] = $c->z;
  }
}

$codeUsage = '<?php
  // replace ID with the ID from the table below for the menu you want to display.
  $menu = new Menu(ID);
  $menu->display();

  // some features can be overridden between instantiation and displaying the menu.
  $menu = new Menu(1);
  $override = [
      "layout"=>"vertical",  //horizontal, accordion
      "branding_html"=>"<h1>Foo</h1>",
      "show_branding"=>true,
  ];
  $menu->display($override);
?>
';

?>

<div class="d-flex justify-content-between align-items-center mb-3">
  <h2>Menus</h2>
  <div>
    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#codeExample" data-bs-toggle="modal" data-bs-target="#codeExample">
      Code Usage
    </button>
    <a class="btn btn-dark" href="admin.php?view=edit_menu&menu_id=new">New Menu</a>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <div class="row">
      <div class="col-md-12">
        <?php if ($dupes != []) { ?>
          <p><b style="color:red;">WARNING: </b> Z-indexes should not be repeated. We have turned your repeated indexes red.</p>
        <?php } ?>
        <table class="table table-bordered table-hover table-condensed" id="menuTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Menu Name</th>
              <th>Menu Type</th>
              <th>Z-Index</th>
              <th>Status</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $i = 0;
            $itemCount = sizeof($menus);
            foreach ($menus as $menu) : ?>
              <tr>
                <td><?= $menu->id ?></td>
                <td><?= $menu->menu_name ?></td>
                <td><?= ucfirst($menu->type) ?></td>
                <td>
                  <?php if (in_array($menu->z_index, $dupes)) {
                    $color = "red";
                  } else {
                    $color = "";
                  }
                  ?>
                  <span style="color:<?= $color ?>">
                    <?= $menu->z_index ?>
                  </span>
                </td>
                <td><?= $menu->disabled ? 'Disabled' : 'Active' ?></td>
                <td class="text-end">
                  <a class="btn btn-sm btn-outline-dark mr-1" href="admin.php?view=edit_menu&menu_id=<?= $menu->id ?>" title="edit"><i class="fa fa-pencil"></i></a>
                  <?php if ($menu->id != 1 && $menu->id != 2) { ?>
                    <button class="btn btn-sm btn-outline-danger" onclick="usDeleteMenu('<?= $menu->id ?>')" title="delete"><i class="fa fa-close"></i></button>
                  <?php } else {  ?>
                    <button disabled class="btn btn-sm btn-outline-secondary"><i class="fa fa-close"></i></button>
                  <?php } ?>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="codeExample" tabindex="-1" role="dialog" aria-labelledby="codeExampleLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="codeExampleLabel">Code Usage Example</h5>
        <button type="button" class="close" data-dismiss="modal" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php highlight_string($codeUsage); ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="js/pagination/datatables.min.js"></script>
<script>
  $(document).ready(function() {
    $('#menuTable').DataTable({
      "pageLength": 25,
      "stateSave": true,
      "aLengthMenu": [
        [25, 50, 100, -1],
        [25, 50, 100, "All"]
      ],
      "aaSorting": []
    });
  });

  function usDeleteMenu(id) {
    if (id == 1 || id == 2) {
      if (window.confirm("You cannot delete menu 1 or 2")) {
        window.location.href = `<?= $us_url_root ?>users/admin.php?view=menus`;
      }
    } else {
      if (window.confirm("Are you sure? This cannot be undone!")) {
        window.location.href = `<?= $us_url_root ?>users/admin.php?view=delete_menu&menu_id=${id}`;
      }
    }

  }
</script>