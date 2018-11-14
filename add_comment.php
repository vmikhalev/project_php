<?php
require 'db.php';
    $comm = R::dispense('comments');
    $comm->who_posted = $_GET['who'];
    $comm->post_id = $_GET['post_id'];
    $comm->text = $_POST['comment_text'];
    R::store($comm);
