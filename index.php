<?php

require_once './app/require.php';

Util::isUser();
Util::isBanned();

require_once './app/controllers/cheatController.php';
require_once './app/controllers/userController.php';

$userController = new userController;
$cheatData = (new cheatController)->getCheatData();

$userCount = $userController->getCount();
$newestUser = $userController->getNew();
$hasSub = $userController->getSubscription() > 0;

Util::head($user['username']);
Util::navbar();

?>

<main class="container mt-2">

    <div class="row">

        <!--Welcome message-->
        <div class="col-12 mt-3 mb-2">
            <div class="alert alert-primary" role="alert">
                Welcome back,
                <a href="<?= (BASE_PATH); ?>profile.php"><b><?= Util::display($user['username']) ?></b></a>.
            </div>
        </div>

        <!--Statistics-->
        <div class="col-lg-9 col-md-12">
            <div class="rounded p-3 mb-3">
                <div class="h5 border-bottom border-secondary pb-1"><i class="fas fa-chart-area"></i> Statistics</div>
                <div class="row text-muted">

                    <!--Total Users-->
                    <div class="col-12 clearfix">
                        Users: <p class="float-right mb-0"><?= Util::display($userCount); ?></p>
                    </div>

                    <!--Latest User-->
                    <div class="col-12 clearfix">
                        Latest User: <p class="float-right mb-0"><?= Util::display($newestUser); ?></p>
                    </div>

                </div>
            </div>
        </div>

        <!--Status-->
        <div class="col-lg-3 col-md-12">
            <div class="rounded p-3 mb-3">
                <div class="h5 border-bottom border-secondary pb-1"><i class="fas fa-exclamation-circle"></i> Status
                </div>
                <div class="row text-muted">

                    <!--Detected // Undetected-->
                    <div class="col-12 clearfix">
                        Status: <p class="float-right mb-0"><?= Util::display($cheatData->status); ?></p>
                    </div>

                    <!--Cheat version-->
                    <div class="col-12 clearfix">
                        Version: <p class="float-right mb-0"><?= Util::display($cheatData->version); ?></p>
                    </div>

                    <!-- Check if user has a sub -->
                    <?php if ($hasSub) : ?>
                        <div class="col-12 text-center pt-1">
                            <div class="border-top border-secondary pt-1">

                                <a href="/download.php">Download Loader</a>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

    </div>

</main>
<?php Util::footer(); ?>
