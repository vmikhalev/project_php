<?php
require 'libs/rb.php';
R::setup('mysql:host=localhost; dbname=social', 'admin', '123');
if (!R::testConnection()) {
  echo "Не удалось подключится к базе данных";
}

session_start();
$user = $_SESSION['logged_user'];
 ?>