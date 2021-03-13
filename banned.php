<?php

require_once 'app/require.php';

$user = new UserController;

Session::init();

if (!Session::isLogged()) { Util::redirect('/login.php'); }
if (!Session::isBanned()) { Util::redirect('/index.php'); }

$username = Session::get("username");

Util::banCheck();
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