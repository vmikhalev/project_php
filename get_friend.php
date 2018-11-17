<?php 
require 'db.php';

if (!(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
}else{

R::exec('UPDATE friends SET accept = '.$_GET['friend'].' WHERE sender = '.$_GET['friend']);
R::exec('UPDATE friends SET sender = 0 WHERE accept = '.$_GET['friend']);
$update = R::dispense('friends');
$update->user_id = $_GET['friend'];
$update->sender = '0';
$update->taker = '0';
$update->accept = $_SESSION['logged_user']->id;
R::store($update);


header('Location: friends.php');

}