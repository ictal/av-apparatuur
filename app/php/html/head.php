<?php 
$page = new Page();

$current_page = $page->_define('p');
?>
<!doctype html>
<html ng-app='av_apparatuur'>
	<head>
		<meta charset="uft-8">
		<title>AV - Apparatuur</title>
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		
		<?php if($current_page == 'user_profile') : ?>
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
			<script src='https://ajax.googleapis.com/ajax/libs/angularjs/1.5.0-rc.1/angular.min.js' type='text/javascript'></script>
			<link rel="stylesheet" href="css/main_style.css">
			<script src='js/app.js' type='text/javascript'></script>
		<?php endif; ?>
		
		<?php if($current_page != 'user_profile') : ?>
			<script type='text/javascript' src='js/style.js'></script>
		<?php endif; ?>
		
</head><?php 
	
//cleaning the code
echo '' ."\r\n"; 
?>
