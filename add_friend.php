<?php 
require 'db.php';

if (!is_numeric($_GET['friend']) ||!(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
}else{

$add = R::dispense('friends');
$add->user_id = $_GET['friend'];
$add->sender = $_SESSION['logged_user']->id;
$add->taker = "0";
$add->accept = "0";
R::store($add);
header('Location: people.php');

}
 ?>
