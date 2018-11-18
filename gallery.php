<?php 
require 'db.php';

if (!(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
}else{

$id = $_SESSION['logged_user']->id;
$photo = R::getAssoc('SELECT * FROM gallery WHERE author = '.$_GET['id']);

$human = R::load('people', $_GET['id']);

if (isset($_POST['load'])) {

	$name = $_FILES['photo']['name'];
	$allowed =  array('gif','png' ,'jpg', 'jpeg');
	$ext = pathinfo($name, PATHINFO_EXTENSION);
	if(!in_array($ext,$allowed) ) {
		echo "<script>alert('Не допустимое раширение файла!')</script>";
	     exit();
	}else{

	$uploads_dir = 'images/';
	$new_name = time().$name;
	$full_dir = $uploads_dir.$new_name;

	if (is_uploaded_file($_FILES['photo']['tmp_name'])){
	     		move_uploaded_file($_FILES['photo']['tmp_name'], $uploads_dir.$new_name);
	     		$load = R::dispense('gallery');
	     		$load->author = $id;
	     		$load->image_href = $full_dir;
	     		$load->date = date('H:m:s | Y:m:d');
	     		R::store($load);
	     		header('Location: gallery.php?id='.$user->id);
			}
		}

}

 ?>
<!DOCTYPE html>
<html>
<head>
	<?php if($_GET['id'] == $id && $user->id == $_GET['id']): ?>
	<title>Мои фото</title>
	<?php else: ?>
		<title>Галерея <?=$human->name ?> <?=$human->surname ?></title>
	<?php endif; ?>
	<?php include 'wrapper/links.php'; ?>
	<link rel="stylesheet" type="text/css" href="css/gallery.css">
</head>
<body>
	<?php include 'wrapper/header.php'; ?>
	<div style="display: inline-flex;" class="panels">
	 	<section style="padding-left: 10px; padding-top: 10px;" class="message_border"> 
	 		<?php if($_GET['id'] == $id && $user->id == $_GET['id']): ?>
	 			<h3 style="text-align: center;">Мои фото</h3>
	 		<?php else: ?>
	 			<h3 style="text-align: center;">Фото <?=$human->name ?> <?=$human->surname ?></h3>
	 		<?php endif; ?>
	 		  <div class="grid-container">
	 		  	<?php foreach($photo as $grid): ?>
			  	<div class="grid-item">
			  		<div class="grid-item-img">
			  			<img src="<?=$grid['image_href'] ?>">
			  		</div>
			  	</div>
				<?php endforeach; ?>
			</div> 
			<div class="footer_section"></div>
	 	</section>
 	<?php if($_GET['id'] == $id && $user->id == $_GET['id']): ?>
 	<aside>
 		<section class="type_message">
 			<ul style="padding-top: 10%;">
 				<form action="" method="post" enctype="multipart/form-data">
                    <input type="file" name="photo" id="userfile">
                    <br>
                    <input class="in_mod" name="load" type="submit" value="Загрузить">
                </form>
 			</ul>
 		</section>
 	</aside>
 <?php endif; ?>
 </div>
 <br><br><br>

 <script type="text/javascript" src="js/messages.js"></script>
</body>
</html>

<?php } ?>