<?php 
require 'db.php';

if (!is_numeric($_GET['who']) || !(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
}else{

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
	<script type="text/javascript">
		$(document).ready(function(){
			$('#add_mess').bind('click', function(){
				var author = <?=$id ?>;
				var recipient = <?=$_GET['who'] ?>;
				var text = $("#text_dialog").val();
				function Before(){
					$('#error').text('Отправка сообщения');
				}
				function Suc(){
					$("#articles").load("/dialog.php?who=<?=$_GET['who'] ?> #articles > *");
					$("#text_dialog").val("");
				}
				$.ajax({
					url: "add_dialog_mess.php",
					type: 'POST',
					data: ({author: author, recipient: recipient, text: text}),
					dataType: 'html',
					sendBefore: Before,
					success: Suc
				});
			});
		});
	</script>
</head>
<body>
	<?php include 'wrapper/header.php'; ?>
 	<section>
 		<div id="articles" class="results">
			
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


				<article id="sms_article">
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
 						<textarea id="text_dialog" name="text" rows="5" placeholder="Напиши текст"></textarea><br>
 						<p id="error"></p>
 						<input id="add_mess"  type="submit" value="Отправить" name="send_text">

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

<?php } ?>
