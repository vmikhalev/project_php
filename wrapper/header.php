<header>
	<content style="margin: 0 auto;">
		<div class="null">
			<h1 style="font-family: 'LifeCraft'; margin-top: 1%; ">Prometheus</h1>
		</div>
		<div class="logo">
			
		</div>
		<div class="search">
			<form method="post" action="search.php">
				<input type="text" name="search" placeholder="Поиск друзей">
				<input type="submit" name="go_search" value="Найти">
			</form>
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