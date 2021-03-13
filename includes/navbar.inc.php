<body>

	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">

		<div class="container">

			<a class="navbar-brand" href="<?php echo SITE_URL ?>"><?php Util::display(SITE_NAME); ?></a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>

			<div class="collapse navbar-collapse" id="navbarNav">

				<ul class="navbar-nav ml-auto">

					<!-- Check if logged in --> 
					<?php if (Session::isLogged() == true) : ?>

						<li class="nav-item">
							<a class="nav-link" href="<?= SUB_DIR ?>/profile.php">Profile</a>
						</li>

						<!-- Check if admin --> 
						<?php if (Session::isAdmin() == true) : ?>
							
							<li class="nav-item">
								<a class="nav-link" href="<?= SUB_DIR ?>/admin">Admin</a>
							</li>

						<?php endif; ?>

						<li class="nav-item">
							<a class="nav-link" href="<?= SUB_DIR ?>/logout.php">Logout</a>
						</li>

					<?php else : ?>

						<li class="nav-item">
							<a class="nav-link" href="<?= SUB_DIR ?>/login.php">Login</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="<?= SUB_DIR ?>/register.php">Register</a>
						</li>

					<?php endif; ?>

				</ul>

			</div>

		</div>

	</nav>