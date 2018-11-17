<?php
require 'db.php';
$data = $_POST;

//Вход
if (isset($data['do_login'])) {
  $errors = array();
  if (trim($data['email_login'] == '')) {
    $errors[] = 'Введите ник';
  }
  if (trim($data['password_login'] == '')) {
    $errors[] = 'Введите пароль';
  }

    $user = R::findone('people', 'email=?', array($data['email_login']));
    if ($user) {
      if(password_verify($data['password_login'], $user->password)){
      $_SESSION['logged_user'] = $user;
      header("Location: profile.php?id=".$_SESSION['logged_user']->id );
    }else {
      $errors[] = "Не правильный пароль";
    }
  }else {
    $errors[] = "Пользователь не найден";
  }
}

//Регистрация
if (isset($data['registration'])) {
  if (trim($data['name'] == '')) {
    $errors[] = "Введите имя";
  }
  if (trim($data['surname'] == '')) {
    $errors[] = "Введите фамилию";
  }
  if (trim($data['email'] == '')) {
    $errors[] = "Введите email или номер телефона";
  }
  if (trim($data['city'] == '')) {
    $errors[] = "Введите свой город";
  }
  if ($data['password'] == '') {
    $errors[] = "Введите пароль";
  }
  if ($data['birthday'] == ''){
  	$errors[] = "Введите свою дату рождения";
  }

  if (R::count('people','login=?', array($data['login'])) > 0) {
    $errors[] = "Данный ник уже используется";
  }
  if (R::count('people','email=?', array($data['email'])) > 0) {
    $errors[] = "Данный email уже используется";
  }

  if (empty($errors)) {
    $users = R::dispense('people');
    $users->name = $data['name'];
    $users->surname = $data['surname'];
    $users->email = $data['email'];
    $users->password = password_hash($data['password'], PASSWORD_DEFAULT);
    $users->birthday = $data['birthday'];
    $users->city = $data['city'];
    $users->avatar = '/images/no_photo.png';
    $users->activated = '0';
    R::store($users);
    echo "<script>alert('Ви успешно зарегистрировались, на вашу почту отправлено подтверждающее письмо')</script>";
    mail($data['email'], 'subject', 'message');
  }

}
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Выполните вход или зарегистрируйтесь</title>
	<link rel="stylesheet" type="text/css" href="/css/index.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<?php include '/wrapper/links.php'; ?>
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
	<meta charset="utf-8">
</head>
<body style="margin: 0; background: #E9EBEE;">
	<header>
		<div class="headercontent">
			<div class="logo">
				<h1 style="font-family: 'LifeCraft'">Prometheus</h1>
			</div>
			<div class="login">
			<form style="display: inline-flex;" method="post" action="index.php">
				<div class="email_login">
					<label>Электронный адрес или номер телефона</label><br />
					<input required type="text" name="email_login">
				</div>
				<div class="password_login">
					<label>Пароль</label><br />
					<input required type="password" name="password_login">
				</div>
				<div class="button_login">
					<button  name="do_login">Вход</button>
				</div>
			</form>
			</div>
		</div>
	</header>
	<section>
		<div class="content_body">
			<div class="about">
				<h1>
					Про сайт
				</h1>
			</div>
			<div class="reg">
				<h1>Создать новый аккаунт</h1>
				<h3>Это бесплатно</h3>
				<br />
				<form method="post" class="reg_form">
					<input type="text" name="name" placeholder="Имя" required>
					<input type="tetx" name="surname" placeholder="Фамилия" required><br /><br />
					<input type="text" name="email" placeholder="Номер мобильного телефона или эл. адрес" required>
					<input type="password" name="password" placeholder="Пароль" required><br /><br />
					<input type="text" name="city" placeholder="Укажите свой город" required><br /><br />
					<label>Дата рождения</label><br />
					<input type="date" name="birthday" required><br /><br />
					<!-- <select name="result" id="selectItem">
						<option id="chelyabinsk">Челябинск</option>
						<option id="moskva">Москва</option>
						<option id="piter">Санкт-Петербург</option>
						<option id="nnovgor">Нижний Новгород</option>
					</select> -->
					<button name="registration">Регистрация</button>
				</form>
			</div>
		</div>
	</section>
	<footer>
		
	</footer>

<!-- 	<script type="text/javascript">
		var a = document.getElementById('female');
		var b = document.getElementById('male');
		var c = document.getElementById('radio_');
		function radio(){
			if(a.checked)
				document.getElementById('radio_').value = 'Женщина';
			if(b.checked)
				document.getElementById('radio_').value = 'Мужчина';

		}
	</script> -->
</body>
</html>