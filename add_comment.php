<?php
require 'db.php';

if (!is_numeric($_GET['post_id']) || !is_numeric($_GET['who']) || !(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
}else{
    $comm = R::dispense('comments');
    $comm->who_posted = $_GET['who'];
    $comm->post_id = $_GET['post_id'];
    $comm->text = htmlspecialchars($_POST['comment_text']);
    R::store($comm);
}