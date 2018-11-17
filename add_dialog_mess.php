<?php 
require 'db.php';

if (!(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
}else{

$add = R::dispense('messages');
$add->author = $_POST['author'];
$add->recipient = $_POST['recipient'];
$add->text = htmlspecialchars($_POST['text']);
$add->data = date("H:i:s | d F Y");
R::store($add);

}
 ?>