<?php

require_once './app/require.php';

Util::isUser();
Util::isBanned();

require_once './app/controllers/userController.php';

$userController = new userController;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST["updatePassword"])) {
        $error = $userController->updatePassword($_POST);
    }

    if (isset($_POST["addSubscription"])) {
        $error = $userController->addSubscription($_POST);
    }
}

$sub = $userController->getSubscription();

Util::head($user['username']);
Util::navbar();

?>

    <main class="container mt-2">

        <div class="row justify-content-center">

            <div class="col-12 mt-3 mb-2">

                <?php if (isset($error)) : ?>
                    <div class="alert alert-primary" role="alert">
                        <?= Util::display($error); ?>
                    </div>
                <?php endif; ?>

            </div>

            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-7 col-xs-12 my-3">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title text-center">Update Password</h4>

                        <form method="POST">

                            <div class="form-group">
                                <input type="password" class="form-control form-control-sm"
                                       placeholder="Current Password" name="currentPassword" required>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control form-control-sm" placeholder="New Password"
                                       name="newPassword" required>
                            </div>

                            <div class="form-group">
                                <input type="password" class="form-control form-control-sm"
                                       placeholder="Confirm password" name="confirmPassword" required>
                            </div>

                            <button class="btn btn-outline-primary btn-block" name="updatePassword" type="submit"
                                    value="submit">Update
                            </button>

                        </form>

                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-lg-4 col-md-5 col-sm-7 col-xs-12 my-3">
                <div class="row">

                    <div class="col-12 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="h5 border-bottom border-secondary pb-1"><?= Util::display($user['username']); ?></div>
                                <div class="row">
                                    <div class="col-12 clearfix">
                                        UID: <p class="float-right mb-0"><?= Util::display($user['uid']); ?></p>
                                    </div>
                                    <div class="col-12 clearfix">
                                        Sub:
                                        <p class="float-right mb-0"><?= Util::display(($sub > 0) ? "${sub} days" : '0 days') ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if ($sub <= 0) : ?>
                        <div class="col-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title text-center">Activate Sub</h4>

                                    <form method="POST">

                                        <div class="form-group">
                                            <input type="text" class="form-control form-control-sm"
                                                   placeholder="Subscription Code" name="subCode" required>
                                        </div>

                                        <button class="btn btn-outline-primary btn-block" name="addSubscription"
                                                type="submit" value="submit">Activate Sub
                                        </button>

                                    </form>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>

    </main>
<?php Util::footer(); ?>
