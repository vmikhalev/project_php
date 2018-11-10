<?php 
require 'db.php';

if (isset($_POST['go_search'])) {


	echo "<script>alert('Ok')</script>";
}

 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Результаты поиска</title>
	<?php include 'wrapper/links.php'; ?>
	<link rel="stylesheet" type="text/css" href="css/search.css">
</head>
<body style="margin: 0; background: #E9EBEE;">
<?php include 'wrapper/header.php'; ?>

<div class="body">
	<div class="results">
		
	</div>
</div>


</body>
</html>