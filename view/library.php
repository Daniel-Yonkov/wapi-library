<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Wapi Library</title>
	<link rel="stylesheet" href="assets/style.css">
</head>
<body>
	<div class="container">
	<header>
			<img src="/assets/images/logo.png" alt="Wapi Bulgaria Library">
			<nav>
				<a href="/" class="button">
					New book
					<img src="/assets/images/all_books.png">
				</a>
				<a href="/logout" class="button">
					Logoff
					<img src="/assets/images/login.png">
				</a>
			</button>
			</a>
			</nav>
		</header>
		<div class="books">
			
			<?php
				foreach ($data as $v) {
					echo 
					'<div class="book-wrapper">
						<cite class="Title">'.$v['title'].'</cite>'.
					'	<picture class="thumb-cover">
							<img src="'.$v['cover'].'" alt="'.$v['title'].'">
						</picture>
					</div>';
				};
			?>
		</div>
		<div class="pagination">
			<?php
			for($i=1;$i<=$numPages; $i++){
				echo '<a href="library?page='.$i.'">'.$i.'</a>';
		
			}
			?>
		</div>
	</div>
</body>
</html>