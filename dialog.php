<?php 
// if(!is_string($_GET['who'])){
// 	exit();
// }else{

require 'db.php';

$id = $_SESSION['logged_user']->id;

$allsms = R::getAssoc("SELECT * FROM messages");
$sms = R::getAssoc("SELECT * FROM messages WHERE recipient = ".$id." AND author = ".$_GET['who']." OR recipient = ".$_GET['who']." AND author = ".$id);

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Мои сообщения</title>
	<?php include 'wrapper/links.php'; ?>
	<link rel="stylesheet" type="text/css" href="css/dialog.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

</head>
<body>
	<?php include 'wrapper/header.php'; ?>
 	<section>
 		<div class="results">
 			<?php foreach ($sms as $key) {
 				$author = $key['author'];
 				$recipient = $key['recipient'];
 				$text = $key['text'];
 				$data = $key['data'];

 				$sms_users = R::getAssoc("SELECT * FROM people WHERE id = ".$author);
 				foreach ($sms_users as $row) {
 					$id = $row['id'];
 					$name = $row['name'];
 					$surname = $row['surname'];
 					$avatar = $row['avatar'];
 					?>


				<article>
 					<div>
 						<img style="border-radius:50%;width: 70px;height: 70px;" src="<?=$row['avatar'] ?>">
 					</div>
 					<div>
 						<div style="display: inline-flex;">
 							<h6 class="name"><b><?=$row['name'] ?> <?=$row['surname'] ?></b></h6>
 							<p class="date">&nbsp; <?=$key['data'] ?></p>
 						</div>
 						<p class="text_in_article"><?=$key['text'] ?></p>
 					</div>
 				</article>
<br>



 					<?php
 				}
 			} ?>

 		</div>
 		<section class="add_text_content">
 				<div>
 					<form id="mess_form" method="post" action="">
 						<textarea id="text_dialog" name="text" rows="5" placeholder="Напиши текст"></textarea><br>
 						<span id="error_m"></span><br>
 						<input id="add_mess"  type="submit" value="Отправить" name="send_text">
 				</form>
 				<h3 style="color: red;"><?=$error; ?></h3>
 				</div>
 		</section>
 	</section>
 	<script type="text/javascript">
 		$(document).ready(function() {
			$('.results').scrollTop(1000000);
		});
 	</script>
</body>
</html>

