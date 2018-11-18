<?php 
require 'db.php';

// if (!is_numeric($_GET['id']) || !(isset($_SESSION['logged_user']))) {
//     R::close();
//     exit();
//     header('Location: index.php');
// }else{

$post_id = $_GET['id'];
$post = R::load('people', $post_id);

$is_friend = R::getAll("SELECT * FROM friends WHERE accept = ".$post->id." AND user_id = ".$_SESSION['logged_user']->id);
$yes = 0;
$a = 0;
for($i = 0; $i <= count($is_friend); $i++){
    if ($post->id == $i['accept']) {
        $a = 1;
    }
}
if ($a == 1) {
    $yes = 1;
}

$postslook =  R::getAll('SELECT * FROM posts WHERE author = '.$post_id);
$postslook1 = array_reverse($postslook);

$friends = R::getAll('SELECT * FROM friends WHERE accept != 0 AND user_id = '.$post->id);
$friends_count = count($friends);
$friends1 = array_slice($friends, 0, 6);

$photos = R::getAssoc('SELECT * FROM gallery WHERE author = '.$post->id);
$photos1 = array_reverse($photos);
$photos2 = array_slice($photos1, 0, 4);


if (isset($_POST['send_message'])) {
    if (trim($_POST['text_message'] == '')) {
        $errors_text_message = 'Введите текст сообщения';
    }
    if (trim($errors_text_message == '')) {
        $send = R::dispense('messages');
        $send->chat_id = $post->id;
        $send->author = $_SESSION['logged_user']->id;
        $send->recipient = $_GET['id'];
        $send->text = htmlspecialchars($_POST['text_message']);
        $send->data = date("l dS of F Y h:I:s A");
        $send->read = '0';
        R::store($send);
    }
}


$friends_sender = R::getAssoc("SELECT * FROM friends WHERE sender != 0 AND user_id = ".$_SESSION['logged_user']->id);
$friends_sender1 = count($friends_sender);
$mess_read = R::getAll("SELECT * FROM messages WHERE recipient=".$_SESSION['logged_user']->id);

R::close();
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>
     <?=$post->name; ?>
     <?=$post->surname; ?>   
    </title>
	<?php include('wrapper/links.php'); ?>
	<link rel="stylesheet" type="text/css" href="css/new.css">
    <script type="text/javascript">
        $(document).ready(function(){
            $('#add_post_').bind('click', function(){
                var author_id = <?=$post->id ?>;
                var text = $("#text_post").val();
                function Before(){
                    
                }
                function Suc(){
                    $("#all_posts").load("/profile.php?id=<?=$post->id ?> #all_posts > *");
                    $("#text_post").val("");
                }
                function CommSuccess(){
                    $("#all_posts").load("/profile.php?id=<?=$post->id ?> #all_posts > *");
                    $("#text_comment").val("");
                }
                $.ajax({
                    url: "add_post.php",
                    type: 'POST',
                    data: ({author: author_id, text: text}),
                    dataType: 'html',
                    sendBefore: Before,
                    success: Suc
                });
            });
            $("#button_comment").bind('click', function(){
                var author = <?=$post->id ?>;
                var post_id = <?=$post->id ?>;
                var text_comm ;
                $.ajax({
                    url: "add_comment.php",
                    type: 'POST',
                    data: ({author: author, post_id: post_id, text: text_comm}),
                    dataType: 'html',
                    success: CommSuccess
                });
            });
            setInterval(function(){ $("#nav-menu").load("profile.php?id=<?=$post->id ?> #nav-menu"); }, 1000);
        });
</script>
</head>
<body style="background: #E9EBEE;">
     <div id="blackground"></div>
	<?php include('wrapper/header.php'); ?>
	<div class="grid-profile">
		<div class="grid-block1" style="background: #E9EBEE;">
<nav style="background-color: white;height: 400px;border-radius: 10px;" id="#nav-menu">
        <ul>
            <li><a href="profile.php?id=<?=$_SESSION['logged_user']->id?>">Профиль</a></li>
            <li><a href="gallery.php?id=<?=$post->id ?>">Мои фото</a></li>
            <li><a href="messages.php">Сообщения</a>
                <?php if($friends_sender1 > 0): ?>
                    <b style="color: white;background-color: red;border-radius: 50px; padding: 4px 4px 4px 4px;"><?=$mess_read ?></b>
                <?php endif; ?>
            </li>
            <li><a href="friends.php">Друзья</a> 
                <?php if($friends_sender1 > 0): ?>
                    <b style="color: white;background-color: red;border-radius: 50px; padding: 4px 4px 4px 4px;"><?=$friends_sender1 ?></b>
                <?php endif; ?>
            </li>
            <!-- <li><a href="#">Музыка</a></li> -->
            <li><a href="people.php">Люди</a></li>
        </ul>
</nav>
		</div>
		<div class="grid-block2">
			<img style="border-radius: 0; width: 100%;" src="<?=$post->avatar ?>">
		</div>
		<div class="grid-block3">
			<h1 style="padding-left: 5px;"><?=$post->name ?>&nbsp; <?=$post->surname ?></h1>
            
            <div class="info">
                <ul>
                    <li onclick="ok(a);"><b>Дата рождения:</b> <?=$post->birthday ?></li>
                    <li onclick="ok(a);"><b>Город:</b> <?=$post->city ?></li>
                    <li onclick="ok(a);"><b>Семейное положение:</b> </li>
                    <li onclick="ok(a);"><b>Место работы:</b> </li>
                </ul>
                <?php if (isset($_SESSION['logged_user']) && $_SESSION['logged_user']->email == $post->email):?>

        <?php elseif($post->id == $is_friend->accept): ?>
            <a href="add_friend.php?friend=<?=$row['id'] ?>"><button style="" name="add_friend">Удалить из друзей</button></a>
        <?php else: ?>
            <a href="add_friend.php?friend=<?=$post->id ?>"><button style="" name="add_friend">Добавить в друзья</button></a>
        <?php endif; ?>
            </div>
		</div>
		<div class="grid-block4" style="background: #E9EBEE;">
			<?php if (isset($_SESSION['logged_user']) && $_SESSION['logged_user']->email == $post->email):?>
                <button id="startmodal" class="stand_button">Загрузить фото</button>
            <?php else: ?>
                <button id="startmodal" class="stand_button">Написать сообщение</button>
            <?php endif; ?>
            <div id="modalcontainer">
                <div class="modalcontent">
                    <p style="cursor: pointer;" id="close">X</p>
                    <?php if($_SESSION['logged_user']->email == $post->email): ?>
                        
                        <h1>Загрузка изображения</h1>
                        <h3>Допустимые расширения файлов: .gif .png .jpg .jpeg</h3>
                        <div class="form_modal">
                            <form action="loadphoto.php" method="post" enctype="multipart/form-data">
                                <input type="file" name="userfile" id="userfile">
                                <br>
                                <input class="in_mod" name="load" type="submit" value="Загрузить">
                            </form>
                        </div>

                    <?php else: ?>
                        <h1>Messages</h1>
                        <form method="post">
                            <textarea name="text_message" style="width: 100%;" rows="10"></textarea><br>
                            <input type="submit" name="send_message">
                        </form>
                    <?php endif; ?>
                </div>
            </div>
		</div>
		<div style="background: #E9EBEE;" class="grid-block5">
			<div class="friends">
			<h1 style="font-size: 20px;">Друзья: <?=$friends_count; ?></h1>
            <div class="friends_blocks">
            <?php foreach ($friends1 as $r) {
                $kent = $r['accept'];

                $q = R::getAll("SELECT * FROM people WHERE id = ".$kent);
                foreach ($q as $a) {
                ?>
                <a class="a_art" href="profile.php?id=<?=$kent; ?>"><article style="">
                    <div class="img_friend">
                        <img src="<?=$a['avatar'] ?>">
                    </div>
                    <div>
                            <p style="font-size: 10px;"><?=$a['name']; ?>
                               <?=$a['surname']; ?>
                            </p>
                    </div>
                </article></a>
                <?php
                }
            }   
            ?>
            </div>
		</div>
		</div>
		<div class="grid-block6" >
			<a href="gallery.php?id=<?=$post->id ?>"><h6 style="text-align: right;">Все фото</h6></a>
                <div class="img-list-container">
                    <?php foreach($photos2 as $block): ?>
                        <div class="img-grid">
                            <img src="<?=$block['image_href'] ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
		</div>
		<div class="grid-block7" >
						<h1 style="padding-left: 10px;font-size: 20px;"><b>Публикации</b></h1>
<?php if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']->email == $post->email): ?>
			<div style="padding-left: 10px; padding-right: 10px;" class="add_post">
				
					<textarea style="width: 100%;" id="text_post" rows="7" placeholder="Добавить текст" name="text_new_post"></textarea><br>
					<input id="add_post_" style="float: right;" type="submit" name="add_new_post" value="Добавить запись">
				
			</div>
<?php endif; ?>
<br><br>
<article class="posts">

            <div class="container" style="width: 100%;">
    <div id="all_posts" class="row" style="display: grid;">

<?php foreach($postslook1 as $key): ?>
        <article style="border-bottom: 1px solid grey;">
                    <div>
                        <img style="width: 70px;height: 70px;" src="<?=$post->avatar ?>">
                    </div>
                    <div>
                            <p><?=$post->name; ?>
                               <?=$post->surname; ?>
                            </p>
                            <p>
                                <?=$key['text'] ?>
                            </p>
                    </div>
                </article>
<?php endforeach; ?>

    </div>
</div>


</article>
		</div>
		<div style="background: #E9EBEE;" class="grid-block8"></div>
	</div>

	<script type="text/javascript" src="js/profile.js"></script>
</body>

</html>