<?php 

include(dirname(__FILE__).'/php/form/form.php');
include(dirname(__FILE__).'/php/user/login.php');
include_once(dirname(__FILE__).'/php/net/session.php');
include_once(dirname(__FILE__).'/php/net/database.php');
include_once(dirname(__FILE__).'/php/html/page.php');

$form = new Form( $_POST );
$page = new Page();
$session = new session();
$db = new Database();

switch( $form->_type ){
	
	case 'registration':
		if( $form->validate()) {
			
			$token = Encryption::_hash( 'registration', $session->get('registration_token') );
			if($token == $form['token']){
				
				unset($form['token']);
				
				var_dump( $db->addUser( $form ) );
				

				$session->remove('registration_token');
				$session->remove('error');

				$page->redirect('index.php?p=user');
				
			}else{
				
				$form->sendError('invalid_token', 'register.php');
				
			}
		}else{
			
			$form->sendError('incomplete_form', 'register.php');
			
		}
		
		
	break;
	
	case 'login':
		if( $form->validate()) {
			$token = Encryption::_hash( 'login', $session->get('login_token') );

			if($token == $form['token']){
				
				if( $db->existUser($form['username'], $form['password']) ){
					
					$user = new User( $db->getUser( $form['username'], 'id') );
					
					$session->set( 'userId', $user->getId() );
					
					$session->set( 'logged_in', true );
					
					$page->redirect('?p=user');
					$session->remove('error');
					
				}else{
					$form->sendError('wrong_login_details', 'index.php');
					
				}
				
				$session->remove('login_token');
				
			}else{
				
				$form->sendError('invalid_token', 'index.php');
				
			}
		}else{
			
			$form->sendError('incomplete_form', 'index.php');
			
		}
		
		$session->remove('login_token');
	break;
}
	
#header('Location: ' ."http://localhost/AV/".'index.php');
?>