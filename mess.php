<?php 
require 'db.php';

if(isset($_POST['send_text'])){

		$add = R::dispense('messages');
		$add->author = $id;
		$add->recipient = $_GET['who'];
		$add->text = $_POST['text'];
		$add->data = date("H:i:s | d F Y");
		R::store($add);
	
}


 ?>