<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wapi Library</title>
	<link rel="stylesheet" href="/assets/style.css">
</head>
<body>
<?php

?>
	<div class="container">
		<header>
			<img src="/assets/images/logo.png" alt="Wapi Bulgaria Library">
			<nav>
				<a href="/library" class="button">
					All books
					<img src="/assets/images/all_books.png">
				<?php
				if($isLogged){
					echo '<a href="/logout" class="button">Logoff
						<img src="/assets/images/login.png">
						</a>';
				}
				else {
					echo '<a href="/login" class="button">Login
						<img src="/assets/images/login.png">
						</a>';
				}
				?>
			</button>
			</a>
			</nav>
		</header>
		<main>
			<form method="post" class="main" id="bookform" enctype="multipart/form-data">
				<div class="inputinfo">
					<div class="info">
						<input type="text" name="title" placeholder="Book Title">
						<input type="text" name="author" placeholder="Author">
					</div>
					<div class="info">
						<input type="text" name="publish_date" placeholder="Publish Date">
						<select name="format" ="">
							<option style="display:none" selected value>Select Format</option>
							<option value="A4">A4</option>
							<option value="A3">A3</option>
						</select>
					</div>
				</div>
				<div class="inputinfo">
					<div class="info">
						<input type="text" name="page_count" placeholder="Page Count">
						<input type="text" name="isbn" placeholder=" ISBN">
					</div>
					<div class="info">
						<textarea name="resume" placeholder="Resume" class="resume" form="bookform"></textarea>
					</div>
				</div>
				<?php
				if(isset($_SESSION['errors'])){
					foreach ($_SESSION['errors'] as $errors) {
						foreach ($errors as $error) {
							echo '<div class="alert">'.$error.'</div>';	
						}
					}
				}
					
				?>
				<footer>
					<div class="footer right">
						<img src="/assets/images/image_upload.png">
						<input type="file" name='cover'>
					</div>
					
					<div class="footer left">
						<input type="image" src="/assets/images/submit.png">
					</div>
				</footer>
			</form>
		</main>
	</div>
</body>
</html>