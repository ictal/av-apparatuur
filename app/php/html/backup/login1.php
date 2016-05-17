<?php
$page = new Page();

	$err = $page->_define('error');


?>
<body>

	<section class='center-page'>

		<section class='login-box'>
		
			<!--<section class='imgholder'>
				<img src='http://zblogged.com/wp-content/uploads/2015/11/17.jpg'>
			</section>-->
			
			<form action='process.php' method='post'>
			<?php 
			
			if($err != 'null'&& $err == '1') {
				$page->error('f-error', 'De opgegeven gebruikersnaam of wachtwoord is onjuist, probeer het nogmaals.');
			}
			
				
			?>
				<input type='text' name='username' placeholder='username'>
				<input type='password' name='password' placeholder='password'>
				<input type='submit' value='login'>
				<input type='hidden' name='name' value='login'>
			</form>
			<a href='rest.php' style='float: right; color: white; text-decoration: none; font-size: 12px; margin-top: 10px;'>wachtwoord vergeten</a>
		</section>
	
	</section>

</body>
</html>
