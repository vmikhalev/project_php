<?php 
require 'db.php';

$people =  R::getAssoc('SELECT * FROM people');
$people_id = R::getAssoc('SELECT id FROM people');
 ?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Люди</title>
 	<?php include 'wrapper/links.php'; ?>
 	<link rel="stylesheet" type="text/css" href="css/people.css">
 </head>
 <body>
 	<?php include 'wrapper/header.php'; ?>
 	<section>
 		<div class="results">
 			<?php foreach($people as $row): ?>
 				<article>
 					<div>
 						<img src="http://dummyimage.com/60x60/4d494d/686a82.gif&text=placeholder+image" alt="placeholder+image">
 					</div>
 					<div>
 						<?php foreach($people_id as $id): ?>
 							<p><a href='profile.php?id=<?=$id['id'] ?>'><?=$row['name']; ?>
 						   												<?=$row['surname']; ?></a>
 							</p>
 						<?php endforeach; ?>
 					</div>
 				</article>
 			<?php endforeach; ?>
 			 	

 		</div>
 	</section>
 </body>
 </html>