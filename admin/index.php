<?php

require_once '../app/require.php';
require_once '../app/controllers/AdminController.php';

$user = new UserController;
$admin = new AdminController;

Session::init();

$username = Session::get("username");

Util::adminCheck();
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
						<h3 class="text-center"><?php Util::display($user->getUserCount()); ?></h3>
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
						<h3 class="text-center text-truncate"><?php Util::display($user->getNewUser()); ?></h3>
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
						<h3 class="text-center"><?php Util::display($user->getBannedUserCount()); ?></h3>
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
						<h3 class="text-center"><?php Util::display($user->getActiveUserCount()); ?></h3>
						<span class="small text-muted text-uppercase">active sub</span>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>

<?php Util::footer(); ?>