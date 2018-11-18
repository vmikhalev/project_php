<?php
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
		}
	}
