<header>
	<content style="margin: 0 auto;">
		<div class="null">
			<?php if(isset($_SESSION['logged_user'])): ?>
				<h1 style="font-family: 'LifeCraft'; margin-top: 1%; cursor: pointer; "><a style="color: #333333; text-decoration: none;" href="profile.php?id=<?=$_SESSION['logged_user']->id ?>" >Prometheus</a></h1>
			<?php else: ?>

			<h1 style="font-family: 'LifeCraft'; margin-top: 1%; cursor: pointer; "><a style="color: #333333; text-decoration: none;" href="index.php">Prometheus</a></h1>
		<?php endif; ?>
		</div>
		<div class="logo">
			
		</div>
		<div class="search">
			<?php if(isset($_SESSION['logged_user'])): ?>
			<form method="post" action="search.php">
				<input type="text" name="search" placeholder="Поиск друзей">
				<input type="submit" name="go_search" value="Найти">
			</form>
		<?php endif; ?>
		</div>
		<div class="my_profile">
			<div>
				<img src="">
			</div>
		</div>
		<div class="exit">
			<?php if(isset($_SESSION['logged_user'])): ?>
			<button onclick="location.href='logout.php'">Выйти</button>
		<?php endif; ?>
		</div>
	</content>
</header>