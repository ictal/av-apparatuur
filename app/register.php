<?php
include_once( dirname(__FILE__) .'/php/html/page.php');
include_once( dirname(__FILE__) .'/php/net/session.php');
include_once(dirname(__FILE__).'/php/net/encryption.php');

$page = new Page();
$session = new Session();
$token = Encryption::generateToken('registration');
$session->set('registration_token', $token['salt']);
print_r($_SESSION);
$m = '';

print_r( $_GET);
if( isset( $_GET['r'] ) ){
	$m = 'Er is een herstel link verstuurd naar u mail, bekijk u spam voor het bericht.';
}
?>

<!doctype html>
<html>
	<head>
		<meta charset="uft-8">
		<title>AV - Apparatuur</title>
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/style.css" >
		<script type='text/javascript' src='js/formValidation.js'></script>

	</head>
	<body>
		<section class='inner-body'>
			
			<section id='login' class='login clearfix'>
				<h1>Registeren</h1>

				<form method='post' action='process.php'>
				
					<section class='input_fields full-width'>
						<?php echo $m ?> 
						<?php echo $page->display_errors() ?>
						<input type='text' name='username' placeholder='username' required>
						<input type='text' name='student_nummer' av-validate='int' placeholder='Studenten nummer' required>
						<input type='password' name='password' av-validate='password' placeholder='password' required>
						<input type='email' name='email'  placeholder='E-mail' required>
						<label>
							<input type='text' name='first_name' av-validate='string' placeholder='Voornaam' class='col-2' required>
							<input type='text' name='tsn_voegsel' av-validate='string' placeholder='tussen-voegsel' class='col-2'>
						</label>
						<input type='text' name='last_name' av-validate='string' placeholder='Achternaam' required>
						<input type='text' name='mobile' av-validate='mobile' placeholder='mobiel nummer' required>
						<input type='hidden' name='type' value='registration'>
						<input type='hidden' name='token' value='<?php echo $token['token'] ?>'>
						<div class='b'><input type='checkbox' name='voorwaarden'> <span style='color: white; font-size: 13px; margin-right: 5px;'>Ik accepteer de voorwaarden</span> 
						<br>
						<input type='submit' class='btn-full-width' value='Registeren'>
						</div>
						<a href='index.php' class='pull-left'><-- Terug</a>
					</section>
					
				</form>
			</section>
		</section>
	</body>
</html>