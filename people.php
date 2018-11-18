<?php 
require 'db.php';

if (!(isset($_SESSION['logged_user']))) {
    R::close();
    exit('404');
}else{

$people =  R::getAll('SELECT * FROM people WHERE id != '.$_SESSION['logged_user']->id);


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
 			<h3>Вы можете их знать</h3>
 			<?php foreach($people as $row): ?>
 				<article>
 					<div>
 						<img style="border-radius: 50%;width: 70px;height: 70px;" src="<?=$row['avatar'] ?>">
 					</div>
 					<div>
 							<p><a href='profile.php?id=<?=$row['id'] ?>'><?=$row['name']; ?>
 						   												<?=$row['surname']; ?></a>
 							</p>
 					</div>
 					<!-- <div style="width: 60%;" class="add_friend">
 							<a href="add_friend.php?friend=<?=$row['id'] ?>"><button style="float: right;" name="add_friend">Добавить в друзья</button></a>
 					</div> -->
 				</article>
 			<?php endforeach; ?>
 		</div>
 	</section>
 </body>
 </html>


 <?php } ?>