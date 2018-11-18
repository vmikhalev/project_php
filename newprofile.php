<?php 
require 'db.php';

if (!is_numeric($_GET['id']) || !(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
    header('Location: index.php');
}else{

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


$friends_sender = R::getAssoc("SELECT * FROM friends WHERE sender != 0 AND user_id = ".$post->id);
$friends_sender1 = count($friends_sender);

R::close();
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Мой профиль</title>
	<?php include('wrapper/links.php'); ?>
	<link rel="stylesheet" type="text/css" href="css/new.css">
</head>
<body style="background: #E9EBEE;">
	<?php include('wrapper/header.php'); ?>
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
	<div class="grid-profile">
		<div class="grid-block1">

        <ul>
            <li><a href="profile.php?id=<?=$_SESSION['logged_user']->id?>">Профиль</a></li>
            <li><a href="gallery.php">Мои фото</a></li>
            <li><a href="messages.php">Сообщения</a>
                <?php if($friends_sender1 > 0): ?>
                    <b style="color: white;background-color: red;border-radius: 50px; padding: 4px 4px 4px 4px;"><?=$friends_sender1 ?></b>
                <?php endif; ?>
            </li>
            <li><a href="friends.php">Друзья</a> 
                <?php if($friends_sender1 > 0): ?>
                    <b style="color: white;background-color: red;border-radius: 50px; padding: 4px 4px 4px 4px;"><?=$friends_sender1 ?></b>
                <?php endif; ?>
            </li>
            <li><a href="#">Музыка</a></li>
            <li><a href="people.php">Люди</a></li>
        </ul>

		</div>
		<div class="grid-block2">
			<img style="border-radius: 50%; width: 100%;" src="images/1542538491AT_Icons_100x100_Finn.jpg">
		</div>
		<div class="grid-block3">
			<h1><?=$post->name ?>&nbsp; <?=$post->surname ?></h1>
            
            <div class="info">
                <ul>
                    <li onclick="ok(a);">Дата рождения: <?=$post->birthday ?></li>
                    <li onclick="ok(a);">Город: <?=$post->city ?></li>
                    <li onclick="ok(a);">Семейное положение: </li>
                    <li onclick="ok(a);">Место работы: </li>
                </ul>
            </div>
		</div>
		<div class="grid-block4">
			<?php if (isset($_SESSION['logged_user']) && $_SESSION['logged_user']->email == $post->email):?>
                <button id="startmodal" class="stand_button">Загрузить фото</button>
            <?php else: ?>
                <button id="startmodal" class="stand_button">Написать сообщение</button>
            <?php endif; ?>
		</div>
		<div class="grid-block5">
			<div class="friends">
			<h1>Друзья:</h1>
            <div class="friends_blocks">
            <?php foreach ($friends as $r) {
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
		<div class="grid-block6">
			<h6>Все фото</h6>
                <div class="img-list-container">
                    <?php foreach($photos2 as $block): ?>
                        <div class="img-grid">
                            <img src="<?=$block['image_href'] ?>">
                        </div>
                    <?php endforeach; ?>
                </div>
		</div>
		<div class="grid-block7">
						<h1 style="padding-left: 10px;"><b>Публикации</b></h1>
<?php if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']->email == $post->email): ?>
			<div style="padding-left: 10px; padding-right: 10px;" class="add_post">
				
					<textarea style="width: 100%;" id="text_post" rows="7" placeholder="Добавить текст" name="text_new_post"></textarea><br>
					<input id="add_post_" style="float: right;" type="submit" name="add_new_post" value="Добавить запись">
				
			</div>
<?php endif; ?>
<br><br><br>


<article class="posts">

			<div class="container" style="width: 100%;">
    <div id="all_posts" class="row" style="display: grid;">

<?php foreach($postslook1 as $key): ?>
        <div class="[ col-xs-12 col-sm-offset-1 col-sm-5 ]">
            <div style="width: 200%;" class="[ panel panel-default ] panel-google-plus">
                <div class="panel-heading">
                    <img style="width: 10%;" class="[ img-circle pull-left ]" src="<?=$post->avatar ?>" alt="" />
                    <h3><?=$post->name ?>
                    	<?=$post->surname ?>
                    </h3>
                    <h5></h5>
                </div>
                <div class="panel-body">
                    <p><?=$key['text']; ?></p>
                </div>
                <div class="panel-footer">
                    <button type="button" class="[ btn btn-default ]">+1</button>
                    <button type="button" class="[ btn btn-default ]">
                        <span class="[ glyphicon glyphicon-share-alt ]"></span>
                    </button>
                    <div class="input-placeholder">Добавить комментарий</div>
                </div>
                <div class="comment_container">
                    
                </div>
                <div class="panel-google-plus-comment">
                    <img style="width: 50px;" class="img-circle" src="<?=$_SESSION['logged_user']->avatar; ?>" alt="Ваше фото" />
                    <div class="panel-google-plus-textarea">
                        
                            <textarea id="text_comment" required name="comment_text" rows="4"></textarea><br>
                            <button id="button_comment" type="submit" class="[ btn btn-success enabled ]">Добавить</button>&nbsp;
                        
                    <button type="reset" class="[ btn btn-default ]">Отменить</button>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
<?php endforeach; ?>

    </div>
</div>


</article>
		</div>
		<div class="grid-block8">8</div>
	</div>

	<script type="text/javascript" src="js/profile.js"></script>
</body>

</html>