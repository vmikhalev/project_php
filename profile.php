<?php 
require 'db.php';

if (!is_numeric($_GET['id'])){
  exit();
}

$post_id = $_GET['id'];


$post = R::load('people', $post_id);

R::close();
 ?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
 
<head>
	<title><?=$_SESSION['logged_user']->name; ?></title>
	<?php include 'wrapper/links.php'; ?>
	<link rel="stylesheet" type="text/css" href="css/profile.css">
</head>
<body style="margin: 0;">
	<?php include 'wrapper/header.php'; ?>


<section class="user">
	<section class="data">
		<div class="user_img">
			<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTlWin_mmxqWOhpO7wb4AV3KmS6_13umVIWKPLxVMSoLDAP90vX">
		</div>
		<div class="user_data">
			<h1><?=$post->name ?>&nbsp; <?=$post->surname ?></h1>
		</div>
	</section>
	<section class="data_bottom">
		<div class="friends">
			<h1>Друзья:</h1>
		</div>
		<div class="articles">
			<h1>Посты:</h1>
		</div>
	</section>
</section>








</body>

</html>