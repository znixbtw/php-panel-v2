<?php
require_once '../app/require.php';
require_once '../app/controllers/adminController.php';

Util::isAdmin();

$admin = new adminController;
$subList = $admin->getSubCodeArray();

Util::head('Admin Panel');
Util::navbar();

// if post request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["genSub"])) {
        $admin->getSubCodeGen($user['username']);
    }
    header("location: sub.php");
}
?>

    <div class="container mt-2">
        <div class="row">

            <?php Util::adminNavbar(); ?>

            <div class="col-12 mt-3">
                <div class="rounded p-3 mb-3">

                    <form method="POST" action="<?= Util::display($_SERVER['PHP_SELF']); ?>">

                        <button name="genSub" type="submit" class="btn btn-outline-primary btn-sm">
                            Gen Subscription code
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

                    <?php foreach ($subList as $row) : ?>
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