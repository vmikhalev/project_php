<?php 

require 'db.php';

if (!(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
}else{

$add = R::dispense('posts');
$add->author = $_POST['author'];
$add->text = htmlspecialchars($_POST['text']);
$add->date = date('H:i:s | Y-m-d');
R::store($add);

}
 ?>