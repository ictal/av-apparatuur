<?php 
$page = new Page();
$session = new Session();

	$token = Encryption::generateToken('login');
	
	$session->set('login_token', $token['salt']);

	?>
	<!doctype html>
	<html ng-app='av_apparatuur'>
		<head>
			<meta charset="uft-8">
			<title>AV - Apparatuur</title>
			<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>

			<link rel="stylesheet" href="css/style.css">
			<script type='text/javascript' src='js/style.js'></script>
	</head>
	<body>
		<section class='inner-body'>
			
			<section id='login' class='login clearfix'>
				<h1>AV apparatuur</h1>
				
			<!--	login -->
				<form method='post' action='process.php' >
					<?php echo $page->display_errors(); ?>
					<section class='input_fields'>
						<input type='text' name='username' placeholder='Username'>
						<input type='password' name='password' placeholder='password'>
						<input type='hidden' name='type' value='login'> <!-- Essential -->
						<input type='hidden' name='token' value='<?php echo $token['token'] ?>'>
						<input type='hidden' name='salt' value='<?php echo $session->get('login_token') ?>'>
						<section class='recover_info'>
							<a href='recover.php'>Wachtwoord vergeten?</a>
							<a onclick=''href='register.php'>Registreren</a>
						</section>
					</section>
					<input type='submit' class='btn icon-lock-close' value=''>
				</form> <!-- -->
				
			</section>
		</section>
	</body>
</html>