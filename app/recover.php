<?php 
include_once dirname(__FILE__) .'/php/html/page.php';
$page = new Page();
$m = '';

if( isset( $_GET['r'] ) ){
	$m = "<p class='notice' style='color: white !important'>Er is een herstel link verstuurd naar u mail, controleer ook eventueel u spam box.</p>";
}
?><!doctype html>
<html >
	<head>
		<meta charset="uft-8">
		<title>AV - Apparatuur</title>
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/style.css" >
		<script type='text/javascript' src='js/style.js'></script>
	</head>
	<body>
		<section class='inner-body'>
			
			<section id='login' class='login clearfix' >
				<h1>Wachtwoord vergeten?</h1> <!-- Title -->
				<?php echo $m ?> 
				<?php echo $page->display_errors() ?>
				<section class='container clearfix'>
					<form action='process.php' method='POST' style='margin:0px'>
						<input type='mail' name='mail' placeholder='voer uw email adres in'>
						<input type='hidden' name='type' value='recover' required>
						<input type='submit' value='versturen'>
					</form>
					<a href='index.php' class='pull-left link-1'><-- Terug</a>
				</section>
			<!--	wachtwoord resetten 
				<form action='process.php' method='post'>
					<section class='input_fields full-width'>
						<input type='text' name='student_nummer' placeholder='studenten nummer of e-mail' required>
						<input type='hidden' name='type' value='recover'>
					</section>
					<input type='submit' class='btn-full-width' value='reset wachtwoord'>
					<a href='/AV/index.php' class='pull-left'><-- Terug</a>-->
			</section>
		</section>
	</body>
</html>
