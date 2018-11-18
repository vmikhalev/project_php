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
      if($user->activated == 0){
        $errors[] = "Не активирован аккаунт";
        exit(header('Location: index.php'));
      }
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

   $chars = 'abdefhiknrstyz1234567890';
   $numChars = strlen($chars);
   $string = '';
   for ($i = 0; $i < 8; $i++)
   {
      $string .= substr($chars, rand(1, $numChars) - 1, 1);
   }
   $string1 = md5($string);


    $users = R::dispense('people');
    $users->name = $data['name'];
    $users->surname = $data['surname'];
    $users->email = $data['email'];
    $users->password = password_hash($data['password'], PASSWORD_DEFAULT);
    $users->birthday = $data['birthday'];
    $users->city = $data['city'];
    $users->avatar = '/avatars/no_photo.png';
    $users->activated = '0';
    $users->user_hash = $string1;
    R::store($users);
    echo "<script>alert('Ви успешно зарегистрировались, на вашу почту отправлено подтверждающее письмо')</script>";


    $to      = $data["email"];
    $subject = 'Подтверждение почты на сайте Prometheus';
    $message = '
    <html>
    <head>
      <title></title>
    </head>
    <body>
      <h3>Перейдите по ссылке, чтобы активировать почту</h3>
      <a href=localhost/verification.php?hash='.$string1.'>Нажми на меня</a>
    </body>
    </html>
    ';
    $headers = 'From: prometheus.epizy@gmail.com' . "\r\n" .
        'Content-type: text/html; charset=iso-8859-1' . "\r\n".
        'X-Mailer: PHP/';

    mail($to, $subject, $message, $headers);
  }

}


R::close();
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
					<div style="height: 35%;">
						<label>Электронный адрес</label><br />
					</div>
					<input required type="text" name="email_login">
				</div>
				<div class="password_login">
					<div style="height: 35%;">
						<label>Пароль</label><br />
					</div>
					<input required type="password" name="password_login">
				</div>
				<div class="button_login">
					<div style="height: 45%;"></div>
					<button class="" name="do_login">Вход</button>
				</div>
			</form>
			</div>
		</div>
	</header>
	<section>
		<div class="content_body">
			<div class="about">
				<h1>
					Prometgeus - это
				</h1>
				<p>
					  	

 веб-сайт, который предназначен для построения и организации социальных взаимоотношений. Если говорить другими словами, Prometheus – это интернет-сообщество пользователей, которые объединены по какому-либо признаку на базе одного веб-сайта, который и является в данном случае этот сайт. В интернете сайт строится на основе тех же принципов, что и в реальном мире, но отличается от реальных сообществ тем, что для функционирования сети не имеет значения географическая удаленность участников друг от друга. 
				</p>
			</div>
			<div class="reg">
				<h1>Создать новый аккаунт</h1>
				<h3>Это бесплатно</h3>
				<br />
				<form method="post" class="reg_form">
					<input type="text" name="name" placeholder="Имя" required>
					<input type="text" name="surname" placeholder="Фамилия" required><br /><br />
					<input type="email" name="email" placeholder="эл. адрес" required>
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




date_default_timezone_set('Etc/UTC');

// Edit this path if PHPMailer is in a different location.
require './PHPMailer/PHPMailerAutoload.php';

$mail = new PHPMailer;
$mail->isSMTP();

/*
 * Server Configuration
 */

$mail->Host = 'smtp.gmail.com'; // Which SMTP server to use.
$mail->Port = 587; // Which port to use, 587 is the default port for TLS security.
$mail->SMTPSecure = 'tls'; // Which security method to use. TLS is most secure.
$mail->SMTPAuth = true; // Whether you need to login. This is almost always required.
$mail->Username = "prometheus.epizy@gmail.com"; // Your Gmail address.
$mail->Password = "fy53nbk7j63gf"; // Your Gmail login password or App Specific Password.

/*
 * Message Configuration
 */

$mail->setFrom('$data['email']', 'Awesome Website'); // Set the sender of the message.
$mail->addAddress('$data['email']'); // Set the recipient of the message.
$mail->Subject = '&#1055;&#1086;&#1076;&#1090;&#1074;&#1077;&#1088;&#1078;&#1076;&#1077;&#1085;&#1080;&#1077; &#1087;&#1086;&#1095;&#1090;&#1099; &#1085;&#1072; &#1089;&#1072;&#1081;&#1090;&#1077; Prometheus'; // The subject of the message.

/*
 * Message Content - Choose simple text or HTML email
 */

// Choose to send either a simple text email...
$mail->Body = 'This is a plain-text message body'; // Set a plain text body.

// ... or send an email with HTML.
//$mail->msgHTML(file_get_contents('contents.html'));
// Optional when using HTML: Set an alternative plain text message for email clients who prefer that.
//$mail->AltBody = '<h3>&#1063;&#1090;&#1086;&#1073;&#1099; &#1087;&#1086;&#1076;&#1090;&#1074;&#1077;&#1088;&#1076;&#1080;&#1090;&#1100; &#1087;&#1086;&#1095;&#1090;&#1091; &#1087;&#1077;&#1088;&#1077;&#1081;&#1076;&#1080;&#1090;&#1077; &#1087;&#1086; &#1089;&#1089;&#1099;&#1083;&#1082;&#1077;</h3><br /><a href="prometheus.epizy.com/verification.php?hash=$string1">&#1053;&#1072;&#1078;&#1084;&#1080; &#1085;&#1072; &#1084;&#1077;&#1085;&#1103;</a>'; 

// Optional: attach a file
$mail->addAttachment('images/phpmailer_mini.png');

if ($mail->send()) {
    echo "Your message was sent successfully!";
} else {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
