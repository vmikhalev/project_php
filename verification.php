<?php 
require 'db.php';
$hash = $_GET['hash'];

$user = R::findone('people', 'user_hash=?', array($hash));

if($user){
	$a =   R::exec( 'UPDATE people SET activated=1 WHERE id='.$user->id );
	echo "Подтверждение прошло успешно <a href='index.php'>Главная</a>";
	R::close();
	exit();
}else{
	R::close();
	exit();
}