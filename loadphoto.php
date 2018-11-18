<?php
require 'db.php';

if (!(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
}else{

$name = $_FILES['userfile']['name'];

$allowed =  array('gif','png' ,'jpg', 'jpeg');
$ext = pathinfo($name, PATHINFO_EXTENSION);
if(!in_array($ext,$allowed) ) {
	echo "<script>alert('Не допустимое раширение файла!')</script>";
    header('Location: profile.php?id='.$user->id);
    exit();
}else{

$uploads_dir = 'avatars/';
$new_name = time().$name;
$full_dir = $uploads_dir.$new_name;

if (is_uploaded_file($_FILES['userfile']['tmp_name']))
{
     move_uploaded_file($_FILES['userfile']['tmp_name'], $uploads_dir.$new_name);
     R::exec( "UPDATE people SET avatar= '/avatars/$new_name' WHERE id=".$user->id );
     header('Location: profile.php?id='.$user->id);
}


}
}