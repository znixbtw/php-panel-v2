<?php

require_once '../app/require.php';
require_once '../app/controllers/AdminController.php';

$user = new UserController;
$admin = new AdminController;

Session::init();

$username = Session::get("username");

$userList = $admin->getUserArray();

Util::adminCheck();
Util::head('Admin Panel');
Util::navbar();

// if post request 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

	if (isset($_POST["resetHWID"])) { 
		$rowUID = $_POST['resetHWID'];
		$admin->resetHWID($rowUID); 
	}

	if (isset($_POST["setBanned"])) { 
		$rowUID = $_POST['setBanned'];
		$admin->setBanned($rowUID); 
	}

	if (isset($_POST["setAdmin"])) { 
		$rowUID = $_POST['setAdmin'];
		$admin->setAdmin($rowUID); 
	}

	header("location: users.php");

}

?>

<div class="container mt-2">
	<div class="row">

		<?php Util::adminNavbar(); ?>

		<div class="col-12 mt-3 mb-2">
			<table class="rounded table">


				<thead>
					<tr>

						<th scope="col" class="text-center">UID</th>

						<th scope="col">Username</th>

						<th scope="col" class="text-center">Admin</th>

						<th scope="col" class="text-center">Banned</th>

						<th scope="col">Actions</th>

					</tr>
				</thead>


				<tbody>

					<!--Loop for number of rows-->
					<?php foreach ($userList as $row) : ?>
						<tr>

							<th scope="row" class="text-center"><?php Util::display($row->uid); ?></th>

							<td><?php Util::display($row->username); ?></td>

							<td class="text-center">
								<?php if ($row->admin == 1) : ?>
									<i class="fas fa-check-circle"></i>
								<?php else : ?>
									<i class="fas fa-times-circle"></i>
								<?php endif; ?>
							</td>

							<td class="text-center">
								<?php if ($row->banned == 1) : ?>
									<i class="fas fa-check-circle"></i>
								<?php else : ?>
									<i class="fas fa-times-circle"></i>
								<?php endif; ?>
							</td>

							<td>
								<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
								
									<button value="<?php Util::display($row->uid); ?>" name="resetHWID"  title="Reset HWID" data-toggle="tooltip" data-placement="top" class="btn btn-sm text-white" type="submit">
										<i class="fas fa-microchip"></i>
									</button>

									<button value="<?php Util::display($row->uid); ?>" name="setBanned"  title="Ban/unban user" data-toggle="tooltip" data-placement="top" class="btn btn-sm text-white" type="submit">
										<i class="fas fa-user-slash"></i>
									</button>

									<button value="<?php Util::display($row->uid); ?>" name="setAdmin"  title="Set admin/non admin" data-toggle="tooltip" data-placement="top" class="btn btn-sm text-white" type="submit">
										<i class="fas fa-crown"></i>
									</button>

								</form>
							</td>

						</tr>
					<?php endforeach; ?>

				</tbody>

			</table>
		</div>
	</div>

</div>
<?php Util::footer(); ?>

<script>
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();   
});
</script>