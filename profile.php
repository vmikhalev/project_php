<?php 
require 'db.php';

if (!is_numeric($_GET['id'])){
  exit();
}

$post_id = $_GET['id'];
$post = R::load('people', $post_id);


$postslook =  R::getAssoc('SELECT * FROM posts WHERE people_id = '.$post_id);
$postslook1 = array_reverse($postslook);


$errors_new_post = '';
if(isset($_POST['add_new_post'])){
	if(trim($_POST['text_new_post'] == '')){
		$errors_new_post = "Напишите текст!";
	}

	if (trim($errors_new_post == '')) {
		$add = R::dispense('posts');
		$add->people_id = $post->id;
		$add->text = $_POST['text_new_post'];
		$add->date = time();
		R::store($add);
		header('Location: profile.php?id='.$post->id);
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
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
</head>
<body style="margin: 0; background: #E9EBEE;">
	<?php include 'wrapper/header.php'; ?>


<section class="user">
	<section class="data">
		<div class="user_img">
			<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTlWin_mmxqWOhpO7wb4AV3KmS6_13umVIWKPLxVMSoLDAP90vX">
		</div>
		<div class="user_data">
			<h1><?=$post->name ?>&nbsp; <?=$post->surname ?></h1>
		</div>
	</section>
	<section class="data_bottom">
		<div class="friends">
			<h1>Друзья:</h1>
		</div>
		<div class="articles">
			<h1><b>Публикации</b></h1>
<?php if(isset($_SESSION['logged_user']) && $_SESSION['logged_user']->email == $post->email): ?>
			<div class="add_post">
				<form method="post">
					<textarea rows="7" placeholder="Добавить текст" name="text_new_post"></textarea><br>
					<input style="float: right;" type="submit" name="add_new_post" value="Добавить запись">
				</form>
			</div>
<?php endif; ?>
<br><br><br><br>


<article class="posts">

			<div class="container" style="width: 100%;">
    <div class="row" style="display: grid;">

<?php foreach($postslook1 as $key): ?>
        <div class="[ col-xs-12 col-sm-offset-1 col-sm-5 ]">
            <div style="width: 200%;" class="[ panel panel-default ] panel-google-plus">
                <div class="dropdown">
                    <span class="dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="[ glyphicon glyphicon-chevron-down ]"></span>
                    </span>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Another action</a></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Something else here</a></li>
                        <li role="presentation" class="divider"></li>
                        <li role="presentation"><a role="menuitem" tabindex="-1" href="#">Separated link</a></li>
                    </ul>
                </div>
                <div class="panel-heading">
                    <img style="width: 10%;" class="[ img-circle pull-left ]" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTlWin_mmxqWOhpO7wb4AV3KmS6_13umVIWKPLxVMSoLDAP90vX" alt="" />
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
                <div class="panel-google-plus-comment">
                    <img class="img-circle" src="https://lh3.googleusercontent.com/uFp_tsTJboUY7kue5XAsGA=s46" alt="User Image" />
                    <div class="panel-google-plus-textarea">
                        <textarea rows="4"></textarea>
                        <button type="submit" class="[ btn btn-success disabled ]">Добавить</button>
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









<script type="text/javascript" src="js/profile.js"></script>
</body>

</html>