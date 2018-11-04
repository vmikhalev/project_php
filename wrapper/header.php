<header>
	<content style="margin: 0 auto;">
		<div class="null">
			
		</div>
		<div class="logo">
			
		</div>
		<div class="search">
			<input type="text" name="search">
		</div>
		<div class="my_profile">
			<div>
				<img src="">
			</div>
		</div>
		<div class="exit">
			<?php if(isset($_SESSION['logged_user'])): ?>
			<button><a href="logout.php">Выйти</a></button>
		<?php endif; ?>
		</div>
	</content>
</header>