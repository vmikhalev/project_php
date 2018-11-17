<?php 
require 'db.php';

if (!is_numeric($_GET['id']) || !(isset($_SESSION['logged_user']))) {
    R::close();
    exit();
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

R::close();
 ?>
<!DOCTYPE html>
<html>
<meta charset="utf-8">
 
<head>
	<title><?=$post->name ?>
		   <?=$post->surname ?>
	</title>
	<?php include 'wrapper/links.php'; ?>
	<link rel="stylesheet" type="text/css" href="css/profile.css">
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

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
                $.ajax({
                    url: "add_post.php",
                    type: 'POST',
                    data: ({author: author_id, text: text}),
                    dataType: 'html',
                    sendBefore: Before,
                    success: Suc
                });
            });
        });
</script>

</head>
<body style="margin: 0; background: #E9EBEE;">
    <div id="blackground"></div>
	<?php include 'wrapper/header.php'; ?>


<div style="display: inline-flex;">
<aside class="menu">

    <nav>
        <ul>
            <li><a href="profile.php?id=<?=$_SESSION['logged_user']->id?>">Профиль</a></li>
            <li><a href="messages.php">Сообщения</a></li>
            <li><a href="friends.php">Друзья</a></li>
            <li><a href="#">Музыка</a></li>
            <li><a href="people.php">Люди</a></li>
        </ul>
    </nav>
    
</aside>
<section class="user">
	<section class="data">
		<div class="user_img">
			<img style="border-radius: 50%;width: 180px; height: 180px;" src="<?=$post->avatar ?>">
            <?php if (isset($_SESSION['logged_user']) && $_SESSION['logged_user']->email == $post->email):?>
                <button id="startmodal" class="stand_button">Загрузить фото</button>
            <?php else: ?>
                <button id="startmodal" class="stand_button">Написать сообщение</button>
            <?php endif; ?>

            <div id="modalcontainer">
                <div class="modalcontent">
                    <?php if($_SESSION['logged_user']->email == $post->email): ?>
                        <h1>Загрузка изображения</h1>

                        <form action="loadphoto.php" method="post" enctype="multipart/form-data">
                            <input type="file" name="avatar">
                            <button>Загрузить</button>
                        </form>


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
		<div class="user_data">
            <div class="logo_text">
			<h1><?=$post->name ?>&nbsp; <?=$post->surname ?></h1>
            </div>
            <div class="info">
                <ul>
                    <li onclick="ok(a);">Дата рождения: <?=$post->birthday ?></li>
                    <li onclick="ok(a);">Город: <?=$post->city ?></li>
                    <li onclick="ok(a);">Семейное положение: </li>
                    <li onclick="ok(a);">Место работы: </li>
                </ul>
            </div>
        <?php if (isset($_SESSION['logged_user']) && $_SESSION['logged_user']->email == $post->email):?>

        <?php elseif($post->id == $is_friend->accept): ?>
            <a href="add_friend.php?friend=<?=$row['id'] ?>"><button style="" name="add_friend">Удалить из друзей</button></a>
        <?php else: ?>
            <a href="add_friend.php?friend=<?=$post->id ?>"><button style="" name="add_friend">Добавить в друзья</button></a>
        <?php endif; ?>
		</div>
	</section>
	<section class="data_bottom">
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
		<div class="articles">
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
                        <form method="get" action="add_comment.php">
                        <textarea required name="comment_text" rows="4"></textarea><br>
                        <a href="add_comment.php?post_id=<?=$key['id']?>&who=<?=$post->id?>"><button type="submit" class="[ btn btn-success enabled ]">Добавить</button></a>&nbsp;
                    </form>
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
	</section>
</section>


</div>





<script type="text/javascript" src="js/profile.js"></script>
</body>

</html>

<?php } ?>