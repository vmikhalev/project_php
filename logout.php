<?php
require 'db.php';
if (!(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
}else{

unset($_SESSION['logged_user']);

header('Location: index.php');
}
 ?>