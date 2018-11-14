<?php 
require 'db.php';

R::exec('UPDATE friends SET accept = '.$_GET['friend'].' WHERE sender = '.$_GET['friend']);
R::exec('UPDATE friends SET sender = 0 WHERE accept = '.$_GET['friend']);

header('Location: friends.php');