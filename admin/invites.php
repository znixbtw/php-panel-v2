<?php

require_once '../app/require.php';
require_once '../app/controllers/adminController.php';
require_once '../app/controllers/userController.php';

Util::isAdmin();

$admin = new adminController;
$invList = $admin->getInvCodeArray();

Util::head('Admin Panel');
Util::navbar();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST["genInv"])) {
    $admin->getInvCodeGen($user['username']);
    header("location: invites.php");
}
?>

    <div class="container mt-2">
        <div class="row">

            <?php Util::adminNavbar(); ?>

            <div class="col-12 mt-3">
                <div class="rounded p-3 mb-3">

                    <form method="POST" action="<?= Util::display($_SERVER['PHP_SELF']); ?>">

                        <button name="genInv" type="submit" class="btn btn-outline-primary btn-sm">
                            Gen Inv
                        </button>

                    </form>

                </div>
            </div>

            <div class="col-12 mb-2">
                <table class="rounded table">

                    <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Created By</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php foreach ($invList as $row) : ?>
                        <tr>
                            <td><?= Util::display($row->code); ?></td>
                            <td><?= Util::display($row->createdBy); ?></td>
                        </tr>
                    <?php endforeach; ?>

                    </tbody>

                </table>

            </div>
        </div>

    </div>

<?php Util::footer(); ?>