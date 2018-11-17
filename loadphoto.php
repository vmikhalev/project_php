<?php
ini_set('display_errors','On');
error_reporting(E_ALL | E_STRICT);

require 'db.php';

if(isset($_POST['load'])){
$path = '/images/'; // директория для загрузки // расширение
$new_name = time(); // новое имя с расширением
$full_path = $path.$_FILES['myfile']['name']; // полный путь с новым именем и расширением


print_r($_FILES);

if($_FILES['myfile']['error'] == 0){
    if(move_uploaded_file($_FILES['myfile']['tmp_name'], $full_path)){
        // Если файл успешно загружен, то вносим в БД (надеюсь, что вы знаете как)
        // Можно сохранить $full_path (полный путь) или просто имя файла - $new_name
        R::exec('UPDATE people SET avatar = '.$full_path.' WHERE email = '.$user->id);
        print_r($_FILES);
        header('Location: profile.php?id='.$user->id);
    }
}

}
?>


<form action="" method="post" enctype="multipart/form-data">
    <label>Выгрузить файл на сервер</label><br />
    <input type="file" name="myfile" id="userfile"><br />
    <input name="load" type="submit" value="Выгрузить!">
</form>