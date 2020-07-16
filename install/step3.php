<?php
require_once("install/includes/header.php");
require_once("../users/classes/Redirect.php");
?>
<div class="container mb-5">
<div class="row justify-content-center mt-4">
        <div class="col-6">
            <div class="list-group list-group-horizontal-xl">
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Step 1</h5>
                    </div>
                    <p class="mb-1"><?= $step1 ?></p>
                </a>
                <a href="#" class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Step 2</h5>
                    </div>
                    <p class="mb-1"><?= $step2 ?></p>
                </a>
                <a href="#" class="list-group-item list-group-item-action active">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">Step 3</h5>
                    </div>
                    <p class="mb-1"><?= $step3 ?></p>
                </a>
            </div>
        </div>
    </div>
          <div class="row">
              <div class="col-xs-3"></div>
              <div class="col-xs-6">
                <H2>Final Cleanup</H2>
                <p>
                  Congratulations! You can now cleanup the install files and begin using your software. If you have any problems, you can edit the init.php directly or reinstall the app.
                </p>
                <div class="text-center">
                  <a class="btn btn-danger btn-lg" href="cleanup.php">Cleanup Install Files</a>
                </div>
              </div>
        </div>
    </div>
<?php require_once("install/includes/footer.php"); ?>
