<?php
require_once( dirname(__FILE__) .'/php/net/session.php');
require_once( dirname(__FILE__) .'/php/net/database.php');
require_once( dirname(__FILE__) .'/php/html/page.php');
require_once( dirname(__FILE__) .'/php/user/user.php');
require_once( dirname(__FILE__) .'/php/mail.php');

$session = new Session();
$page = new Page( 'index' );
$mail = new Mail("teest");
$page->handleGET();

if( $session->_isset( 'userId' ) )
	$user = new User( $session->get('userId') );

if($user->getPermission() < 1)
{

	$page->redirect('index.php');
}

?>

<!doctype html>
<html  ng-app='av_apparatuur'>
	<head>
		<meta charset="uft-8">
		<title>AV - Apparatuur</title>
		
		<link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="css/style.css" >
		<link rel="stylesheet" type="text/css" href="css/dashboard.css" >
		<link rel="stylesheet" type="text/css" href="css/popup.css" >
		<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.4.9/angular.min.js"></script>
		<script src='js/av_apparatuur.js' type='text/javascript'></script>
		<script type="text/javascript">
			function hide( id ) {
				document.getElementById( id ).style.display = 'none';
			}
		</script>
	</head>
	<body>
		<section class='inner-body clearfix'>
			
			<section class='dashboard-nav'>
			<section class='top-nav'>
				<h1>AV Apparatuur</h1>
				<p>ROC Lammenschans</p>
				</section>
				<nav>
					<ul>
						<li class='user clearfix'>
							<section class='profile-img'>
								<?php echo "<img src='img/profile/$user[picture]'>"; 
								
								?>
								
							</section>
							<section class='profile-name'>
								<h1><?php echo $user->getFullName() ?></h1>
								<p><?php echo $user["student_number"]; ?>
								<br><span style='font-size: 12px'><?php echo  $user['email'] ?> </span> </p>
							</section>
						</li>
						<!-- TODO PHP generated Navigation -->
						<li <?php if($page->getCurrentpage() == 'index') { echo "id='active'";} ?>  > 
							<img src='img/icon-home.png' class='icon'> 
							<a href="?p=index">Dashboard</a> 
						</li>
						<li <?php if($page->getCurrentpage() == 'users') { echo "id='active'";} ?> > 
							<img src='img/icon-message.png' class='icon'> 
							<a href="?p=users">Gebruikers</a> 
						</li>
						<li <?php if($page->getCurrentpage() == 'products') { echo "id='active'";} ?> > 
							<img src='img/icon-product.png' class='icon'> 
							<a href="?p=products">Producten</a> 
						</li>
						<hr>
						<li class='n-list'> 
							<a href="#">Users</a> 
						</li>
						<li class='n-list'> 
							<a href="#">Settings</a> 
						</li>
						<li class='n-list'> 
							<a href="#">Security</a> 
						</li>
					</ul>
				</nav>
			</section>
			
			<section class='dashboard-body'>
				<section class='top-nav'>
				<nav>
					<ul>
						<li class='pull-right'><a href='?logout=true'><img src='img/icon-logout.png'></a></li>
					</ul>
				</nav>
				</section>
				
				<?php if( isset( $_GET['error'] ) ) {  ?>
				
					<section id='error' class='error_product_page'>
							<p><span onclick="hide('error');" class=' btn-x pull-right'>x</span></p>
						<h1>Foutje!</h1>
						<?php echo $page->display_errors(); ?>
					</section>
					
				<?php }

					 $page->load();

				?>
				
			</section>
			
		</section>
	</body>
</html>
