<?php
echo "Загрузка аватара:<br>";
     
     // если аватар был отправлен юзером, загрузим его
     if($_POST['go']==5)
     {
     // проверим соответсвует ли загружаемый аватар нашим параметрам
     if($_FILES['avatar']['size']>50000){$err_avatar_size='Аватар слишком велик!';}
     if(!($_FILES['avatar']['type']=='image/pjpeg' OR $_FILES['avatar']['type']=='image/jpeg' OR $_FILES['avatar']['type']=='image/gif'))
     {$err_avatar_type='Файл имеет неразрешенный тип!';}
     
     // сохраним аватар на сервере, если нет ошибок
     if(!$err_avatar_size AND !$err_avatar_type)
         {
         $avatar_name=$_SESSION['id'];
         
         $avatar_way="avatars/".$avatar_name; // путь в аватару
         
         // удалим уже существующие аватары
         $avatar_del=$avatar_way.".gif";
         @unlink($avatar_del);
         $avatar_del=$avatar_way.".jpg";
         @unlink($avatar_del);
         
         // добавляем расширение к файлу
         switch($_FILES['avatar']['type'])
             {
             case 'image/pjpeg': $avatar_way.=".jpg"; break;
             case 'image/jpeg': $avatar_way.=".jpg"; break;
             case 'image/gif': $avatar_way.=".gif"; break;
             }
         
         copy($_FILES['avatar']['tmp_name'], $avatar_way); // сохраним файл на сервер
         }
     }
     
     // выведем ошибки, если они есть
     if($err_avatar_size){echo $err_avatar_size;}
     if($err_avatar_type){echo $err_avatar_type;}
     
     $catalog="avatars";
     
     // удалим аватар
     if($_GET['del_avatar'])
     {
     $del_ava=$catalog."/".$_GET['del_avatar'];
     @unlink($del_ava);
     }
     
     
     // отобразим уже загруженный аватар
     $i=1;
     $dir = opendir ($catalog);
     while ($file = readdir ($dir)) 
     {
     if(is_file($catalog."/".$file))
         {
         echo '<br><img src="'.$catalog.'/'.$file.'"></img><br>';
         echo '<a href="'.$_SERVER['PHP_SELF'].'?profile=5&del_avatar='.$file.'">Удалить</a><br>';
         }
     }
     closedir ($dir);
     
     
     // форма загрузки
     ?>
     <form action="loadphoto.php" method="post" enctype="multipart/form-data">
     <input type="hidden" name="go" value="5">
     <input type="file" name="avatar"><br><br>
     <input type="submit" value="закачать"><input type="Reset" value="сброс">
     </form>