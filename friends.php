<?php 
require 'db.php';

if (!(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
}else{

$id = $_SESSION['logged_user']->id;

$friends_all =  R::getAll("SELECT * FROM friends WHERE accept != 0 AND user_id = ".$id);
$friends_sender = R::getAssoc("SELECT * FROM friends WHERE sender != 0 AND user_id = ".$id);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Мои сообщения</title>
	<?php include 'wrapper/links.php'; ?>
	<link rel="stylesheet" type="text/css" href="css/friends.css">
</head>
<body>
	<?php include 'wrapper/header.php'; ?>
	<div style="display: inline-flex;" class="panels">
 	<section class="message_border">
 		<div class="results">
 			<div id="inbox">
 			<?php foreach ($friends_all as $r) {
 				$kent = $r['accept'];

 				$q = R::getAll("SELECT * FROM people WHERE id = ".$kent);
 				foreach ($q as $a) {
 				?>
 				<a href="profile.php?id=<?=$a['id']; ?>"><article style="border-bottom: 1px solid grey;">
 					<div>
 						<img style="width: 70px;height: 70px;" src="<?=$a['avatar'] ?>">
 					</div>
 					<div>
 							<p><?=$a['name']; ?>
 						   	   <?=$a['surname']; ?>
 							</p>
 							<p>
 								<a href="dialog.php?who=<?=$a['id'] ?>"><button>Написать</button></a>
 							</p>
 					</div>
 				</article></a>
 				<?php
 				}
			}	
		?>

</div>
<div id="outbox">
 			<?php foreach ($friends_sender as $r1) {
 				$kent1 = $r1['sender'];

 				$q1 = R::getAll("SELECT * FROM people WHERE id = ".$kent1);
 				foreach ($q1 as $a1) {
 				?>
 				<a href="dialog.php?who=<?=$author; ?>"><article style="border-bottom: 1px solid grey;">
 					<div>
 						<img style="width: 70px;height: 70px;" src="<?=$a1['avatar'] ?>">
 					</div>
 					<div>
 							<p><?=$a1['name']; ?>
 						   	   <?=$a1['surname']; ?>
 							</p>
 							<p>
 									<a href="get_friend.php?friend=<?=$a1['id'] ?>"><button>Одобрить</button></a>
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
 				<li><a onclick="in1()" id="inbox_button" href="#">Друзья</a></li>
 				<li><a onclick="out1()" id="outbox_button" href="#">Запросы</a></li>
 			</ul>
 		</section>
 	</aside>
 </div>

 <script type="text/javascript" src="js/messages.js"></script>
</body>
</html>

<?php } ?>