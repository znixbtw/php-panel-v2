<?php

require_once '../app/require.php';
require_once '../app/controllers/AdminController.php';

$user = new UserController;
$admin = new AdminController;

Session::init();

$username = Session::get("username");

$subList = $admin->getSubCodeArray();

Util::adminCheck();
Util::head('Admin Panel');
Util::navbar();

// if post request 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


	if (isset($_POST["genSub"])) {
		$admin->getSubCodeGen($username); 
	}

	header("location: sub.php");

}
?>

<div class="container mt-2">
	<div class="row">

		<?php Util::adminNavbar(); ?>

		<div class="col-12 mt-3">
			<div class="rounded p-3 mb-3">

				<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
								
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
							<td><?php Util::display($row->code); ?></td>
							<td><?php Util::display($row->createdBy); ?></td>
						</tr>
					<?php endforeach; ?>

				</tbody>

			</table>

		</div>
	</div>

</div>

<?php Util::footer(); ?>