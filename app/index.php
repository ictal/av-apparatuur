<?php
echo 'Current PHP version: ' . phpversion();
require_once( dirname(__FILE__) .'/php/html/page.php');
require_once( dirname(__FILE__) .'/php/net/session.php');
require_once( dirname(__FILE__) .'/php/net/database.php');
require_once( dirname(__FILE__) .'/php/user/user.php');

$page = new Page();
$session = new Session();
$database = new Database();

	//load page head
	$page->handleGET();
	
	// check if the user session is set.
	$user_session = $session->_isset('logged_in');
	
	//if user has session load page() else send user to login/registration page.
	if($user_session){
		
		//get user data from the database.
		$user = new User( $session->get('userId') );
		#echo $session->get('userId');
		//get user permission lvl: 0 => user  1 => admin.
		$permission_lvl = $user->getPermission();

		#echo $permission_lvl;
		//send the user to his own permission lvl page.
		if($permission_lvl == 0){
			$page->load('user_profile');
		}
		else
			$page->redirect('dashboard.php');
	}else{
		
		$page->load('login');
	}

	//close database connection
	$database->destroy();

	#print_r(  $_SERVER );
	#print_r(  $_SESSION );
	#print_r(  $_GET );
?>