<?php 
require 'db.php';

if (isset($_POST['go_load'])) {
	if (empty($_FILES['file']['size']))
		exit('Вы не выбрали фото');

	if($_FILES['file']['size'] > (5 * 1024 * 1024))
		exit('Размер фото не должен превышать 5МБ');

	$imageinfo = getimagesize($_FILES['file']['tmp_name']);
	$arr = array('image/jpeg', 'image/png', 'image/jpg');
	if(!in_array($imageinfo['mime'], $arr))
		exit('Картинка должна быть формата JPG, JPEG, PNG');
	else{
		$upload_dir = '/images/';
		$name = $upload_dir.date('YmdHis').basename($_FILES['file']['name']);
		$mov = move_uploaded_file($_FILES['file']['tmp_name'], $name);
		// if($mov){
		// 	require 'db.php';
		// 	$name = stripcslashes(strip_tags(trim($name)));
		// 	$add = R::dispense('people');
		// 	$add->avatar = 

		// }
		echo "Все ок";
		header('Location: profile.php?id='.$_SESSION['logged_user']->id);
	}
}

 ?>