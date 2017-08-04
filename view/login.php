<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wapi Library</title>
	<link rel="stylesheet" href="assets/style.css">
</head>
<body>
	<div class="container container-login">
	<header class="header-login">
		<h2>Wapi Library Login</h2>
	</header>
			<form method="post" class="login">
				<div class="loginfo">
					<label for="username" class="login-label">Username:</label>
					<input type="text" name="username" placeholder="Username">
				</div>
				<div class="loginfo">
					<label for="password" class="login-label">Password:</label>
					<input type="password" name="password" placeholder="Password">
				</div>
				<input type="submit" value="Login" >
			</form>
			<?php
			if(isset($_SESSION['errors'])){
					foreach ($_SESSION['errors'] as $errors) {
						foreach ($errors as $error) {
							echo '<div class="alert">'.$error.'</div>';	
						}
					}
				}
			?>
	</div>
</body>
</html>