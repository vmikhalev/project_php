<?php 
require 'db.php';

if (!(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
}else{

$id = $_SESSION['logged_user']->id;

$mess =  R::getAssoc("SELECT * FROM messages WHERE recipient = ".$id);
$mess1 = R::getAssoc("SELECT * FROM messages WHERE author = ".$id);
$messages = array_reverse($mess);
$messages1 = array_reverse($mess1);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Мои сообщения</title>
	<?php include 'wrapper/links.php'; ?>
	<link rel="stylesheet" type="text/css" href="css/messages.css">
	<script type="text/javascript">
		$(document).ready(function(){
			setInterval(function(){ $("#inbox").load("messages.php #inbox"); }, 1000);
		});
	</script>
</head>
<body>
	<?php include 'wrapper/header.php'; ?>
	<div style="display: inline-flex;" class="panels">
 	<section class="message_border">
 		<div id="results" class="results">
 			<div id="inbox">
 			<?php foreach ($messages as $r) {
 				$author = $r['author'];
 				$recipient = $r['recipient'];




 				$q = R::getAssoc("SELECT * FROM people WHERE id = ".$author);
 				foreach ($q as $a) {
 				?>
 				<a href="dialog.php?who=<?=$author; ?>"><article style="border-bottom: 1px solid grey;">
 					<div>
 						<img style="width: 70px;height: 70px;" src="<?=$a['avatar'] ?>">
 					</div>
 					<div>
 							<p><?=$a['name']; ?>
 						   	   <?=$a['surname']; ?>
 							</p>
 							<p>
 								<?=$r['text'] ?>
 							</p>
 					</div>
 				</article></a>
 				<?php
 				}
			}	
		?>

</div>
<div id="outbox">
 			<?php foreach ($messages1 as $r1) {
 				$author1 = $r1['author'];
 				$recipient1 = $r1['recipient'];




 				$q1 = R::getAssoc("SELECT * FROM people WHERE id = ".$author1);
 				foreach ($q1 as $a1) {
 				?>
 				<a href="dialog.php?who=<?=$recipient1; ?>"><article style="border-bottom: 1px solid grey;">
 					<div>
 						<img style="width: 70px;height: 70px;" src="<?=$a1['avatar'] ?>">
 					</div>
 					<div>
 							<p><?=$a1['name']; ?>
 						   	   <?=$a1['surname']; ?>
 							</p>
 							<p>
 								<?=$r1['text'] ?>
 							</p>
 					</div>
 				</article></a>
 				<?php
 				}
			}	
		?>
</div>
 		</div>
 	</section>
 	<aside>
 		<section class="type_message">
 			<ul>
 				<li><a onclick="in1()" id="inbox_button" href="#">Входящие</a></li>
 				<li><a onclick="out1()" id="outbox_button" href="#">Исходящие</a></li>
 			</ul>
 		</section>
 	</aside>
 </div>

 <script type="text/javascript" src="js/messages.js"></script>
</body>
</html>

<?php } ?>