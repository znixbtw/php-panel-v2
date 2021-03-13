<?php

require_once '../app/require.php';
require_once '../app/controllers/AdminController.php';
require_once '../app/controllers/CheatController.php';

$user = new UserController;
$cheat = new CheatController;
$admin = new AdminController;

Session::init();

$username = Session::get("username");

Util::adminCheck();
Util::head('Admin Panel');
Util::navbar();

// if post request 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


	if (isset($_POST["cheatStatus"])) {
		$admin->setCheatStatus(); 
	}

	if (isset($_POST["cheatMaint"])) {
		$admin->setCheatMaint(); 
	}

	if (isset($_POST["cheatVersion"])) {
		$ver = floatval($_POST['version']);
		$admin->setCheatVersion($ver); 
	}

	header("location: cheat.php");

}
?>

<div class="container mt-2">
	<div class="row">

		<?php Util::adminNavbar(); ?>


		<!--Total Users-->
		<div class="col-xl-4 col-sm-6 col-xs-12 mt-3">
			<div class="card">
				<div class=" card-body row">
					<div class="col-6 text-center">
						<h3><i class="fas fa-thermometer fa-2x"></i></h3>
					</div>
					<div class="col-6">
						<h4><?php Util::display($cheat->getCheatData()->status); ?></h4>
						<span class="small text-muted text-uppercase">status</span>
					</div>
				</div>
			</div>
		</div>

		<!--Total Users-->
		<div class="col-xl-4 col-sm-6 col-xs-12 mt-3">
			<div class="card">
				<div class=" card-body row">
					<div class="col-6 text-center">
						<h3><i class="fas fa-code-branch fa-2x"></i></h3>
					</div>
					<div class="col-6">
						<h4><?php Util::display($cheat->getCheatData()->version); ?></h4>
						<span class="small text-muted text-uppercase">version</span>
					</div>
				</div>
			</div>
		</div>

		<!--Total Users-->
		<div class="col-xl-4 col-sm-6 col-xs-12 mt-3">
			<div class="card">
				<div class=" card-body row">
					<div class="col-6 text-center">
						<h3><i class="fas fa-wrench fa-2x"></i></h3>
					</div>
					<div class="col-6">
						<h4><?php Util::display($cheat->getCheatData()->maintenance); ?></h4>
						<span class="small text-muted text-uppercase">maintenance</span>
					</div>
				</div>
			</div>
		</div>

		<div class="col-12 mt-3">
			<div class="rounded p-3 mb-3">

				<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
								
					<button name="cheatStatus" type="submit" class="btn btn-outline-primary btn-sm">
						SET detected+-
					</button>
								
					<button name="cheatMaint" type="submit" class="btn btn-outline-primary btn-sm">
						SET maintenance+-
					</button>

				</form>

				<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
					<div class="form-row mt-1">
    					<div class="col">
							<input type="text" class="form-control form-control-sm" placeholder="Version" name="version" required>
						</div>
						
    					<div class="col">
							<button class="btn btn-outline-primary btn-sm" name="cheatVersion" type="submit" value="submit">Update</button>
    					</div>
  					</div>
					
				</form>

			</div>
		</div>

	</div>
</div>

<?php Util::footer(); ?>