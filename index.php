<?php

require_once 'app/require.php';
require_once 'app/controllers/CheatController.php';

$user = new UserController;
$cheat = new CheatController;

Session::init();

if (!Session::isLogged()) { Util::redirect('/login.php'); }

$username = Session::get("username");

Util::banCheck();
Util::head($username);
Util::navbar();

?>

<main class="container mt-2">

	<div class="row">

		<!--Welome message-->
		<div class="col-12 mt-3 mb-2">
			<div class="alert alert-primary" role="alert">
				Welcome back, <a href="/profile.php"><b><?php Util::display($username) ?></b></a>.
			</div>
		</div>


		<!--Statistics-->
		<div class="col-lg-9 col-md-12">
			<div class="rounded p-3 mb-3">
				<div class="h5 border-bottom border-secondary pb-1"><i class="fas fa-chart-area"></i> Statistics</div>
				<div class="row text-muted">

					<!--Total Users-->
					<div class="col-12 clearfix">
						Users: <p class="float-right mb-0"><?php Util::display($user->getUserCount()); ?></p>
					</div>

					<!--Latest User-->
					<div class="col-12 clearfix">
						Latest User: <p class="float-right mb-0"><?php Util::display($user->getNewUser()); ?></p>
					</div>

				</div>
			</div>
		</div>


		<!--Status-->
		<div class="col-lg-3 col-md-12">
			<div class="rounded p-3 mb-3">
				<div class="h5 border-bottom border-secondary pb-1"><i class="fas fa-exclamation-circle"></i> Status</div>
				<div class="row text-muted">

					<!--Detected // Undetected-->
					<div class="col-12 clearfix">
						Status: <p class="float-right mb-0"><?php Util::display($cheat->getCheatData()->status); ?></p>
					</div>

					<!--Cheat version-->
					<div class="col-12 clearfix">
						Version: <p class="float-right mb-0"><?php Util::display($cheat->getCheatData()->version); ?></p>
					</div>
	
					<!-- Check if has sub --> 
					<?php if ($user->getSubStatus() > 0) : ?>
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
