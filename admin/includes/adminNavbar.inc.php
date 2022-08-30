<!--Admin navigation-->

<!-- Check if admin // This is not important really.-->
<?php if (Session::get('admin')) : ?>
    <div class="col-12 mt-3 mb-2">
        <div class="rounded p-3">
            <a href='<?= (BASE_PATH); ?>admin/index.php' class="btn btn-outline-primary btn-sm">Home</a>
            <a href='<?= (BASE_PATH); ?>admin/users.php' class="btn btn-outline-primary btn-sm">Users</a>
            <a href='<?= (BASE_PATH); ?>admin/invites.php' class="btn btn-outline-primary btn-sm">Invite codes</a>
            <a href='<?= (BASE_PATH); ?>admin/sub.php' class="btn btn-outline-primary btn-sm">Sub codes</a>
            <a href='<?= (BASE_PATH); ?>admin/cheat.php' class="btn btn-outline-primary btn-sm">cheat</a>
        </div>
    </div>
<?php endif; ?>