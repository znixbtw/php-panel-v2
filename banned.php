<?php

require_once 'app/require.php';

Session::init();

Util::userCheck();
Util::banCheck();

$user = new userController;
$username = Session::get("username");

Util::head($username);
Util::navbar();

?>

    <main class="container mt-2">
        <div class="row">
            <!--Banned message-->
            <div class="col-12 mt-3 mb-2">
                <div class="alert alert-primary" role="alert">
                    You have been permanently banned.
                </div>
            </div>
        </div>
    </main>
<?php Util::footer(); ?>