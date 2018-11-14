<?php 
require 'db.php';

$add = R::dispense('friends');
$add->user_id = $_GET['friend'];
$add->sender = $_SESSION['logged_user']->id;
$add->taker = "0";
$add->accept = "0";
R::store($add);
header('Location: people.php');
 ?>
