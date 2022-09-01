<?php
require_once '../app/require.php';
require_once '../app/controllers/adminController.php';
require_once '../app/controllers/userController.php';

Util::isAdmin();

$userController = new userController;

Util::head('Admin Panel');
Util::navbar();

?>

    <div class="container mt-2">
        <div class="row">

            <?php Util::adminNavbar(); ?>

            <!--Total Users-->
            <div class="col-xl-3 col-sm-6 col-xs-12 mt-3">
                <div class="card">
                    <div class=" card-body row">
                        <div class="col-6 text-center">
                            <h3><i class="fas fa-users fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3 class="text-center"><?= Util::display($userController->getCount()); ?></h3>
                            <span class="small text-muted text-uppercase">total users</span>
                        </div>
                    </div>
                </div>
            </div>

            <!--Newest registered user-->
            <div class="col-xl-3 col-sm-6 col-xs-12 mt-3">
                <div class="card">
                    <div class=" card-body row">
                        <div class="col-6 text-center">
                            <h3><i class="fas fa-user fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3 class="text-center text-truncate"><?= Util::display($userController->getNew()); ?></h3>
                            <span class="small text-muted text-uppercase">latest user</span>
                        </div>
                    </div>
                </div>
            </div>

            <!--Total banned users-->
            <div class="col-xl-3 col-sm-6 col-xs-12 mt-3">
                <div class="card">
                    <div class=" card-body row">
                        <div class="col-6 text-center">
                            <h3><i class="fas fa-user-slash fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3 class="text-center"><?= Util::display($userController->getCountBanned()); ?></h3>
                            <span class="small text-muted text-uppercase">banned users</span>
                        </div>
                    </div>
                </div>
            </div>

            <!--Total active sub users-->
            <div class="col-xl-3 col-sm-6 col-xs-12 mt-3">
                <div class="card">
                    <div class=" card-body row">
                        <div class="col-6 text-center">
                            <h3><i class="fas fa-user-clock fa-2x"></i></h3>
                        </div>
                        <div class="col-6">
                            <h3 class="text-center"><?= Util::display($userController->getCountActive()); ?></h3>
                            <span class="small text-muted text-uppercase">active sub</span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php Util::footer(); ?>