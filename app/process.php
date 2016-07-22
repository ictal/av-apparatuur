<?php 
echo '<pre>';
include(dirname(__FILE__).'/php/form/form.php');
include(dirname(__FILE__).'/php/user/login.php');
include(dirname(__FILE__).'/php/products.php');
include_once(dirname(__FILE__).'/php/net/session.php');
include_once(dirname(__FILE__).'/php/net/database.php');
include_once(dirname(__FILE__).'/php/html/page.php');
include_once dirname( __FILE__) .'/php/mail.php';
$form = new Form( $_POST );
$page = new Page();
$session = new session();
$db = new Database();

switch( $form->_type ){
	
	case 'registration':
		if( $form->validate() ) {
			
			$token = Encryption::_hash( 'registration', $session->get('registration_token') );
			if($token == $form['token']){
				
				unset($form['token']);
				
				if( isset( $_POST['voorwaarden'] ) ){
					$db->addUser( $form );
					
					$session->remove('registration_token');
					$session->remove('error');

					$page->redirect('index.php','p=user');
				}else {
					
					$form->sendError('terms_not_accepted', 'register.php');
					
				}
				
			}else{
				
				$form->sendError('invalid_token', 'register.php');
				
			}
		}else{
			
			$form->sendError('incomplete_form', 'register.php');
			
		}
		
		
	break;
	case 'products':
		$product = new Product('product_img', $_POST['product_name'], $_POST['product_description'] );
		if( $product->saveProduct() ){
			$page->redirect('dashboard.php' ,'p=products');
		}else{
      		$session->set( 'POST_DATA', $form->getContainer() );
      			//$page->redirect('dashboard.php' ,'p=products&error=' . $product->getError() );

      		$product->debug();
		}
 	break;
	case 'login':
		if( $form->validate()) {
			$token = Encryption::_hash( 'login', $session->get('login_token') );

			if($token == $form['token']){
				
				if( $db->existUser($form['username'], $form['password']) ){
					
					$user = new User( $db->getUser( $form['username'], 'id') );
					$user->updateLastLogin();
					//has not validate email.
					if( $user->getStatus() < 1 ){
						$form->sendError('account_not_activated', 'index.php');
						return false;
					}
					
					
					$session->set( 'userId', $user->getId() );
					
					$session->set( 'logged_in', true );
					
					$page->redirect('index.php' ,'p=user');
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
	case 'recover':
		$email = $_POST['mail'];
		
		$sql = "SELECT 1 FROM users WHERE email = ?";
		$result = $db->fetch( $sql, array( $email ) );
		
		if($result){
			$mail = new Mail($email);
			$mail->sendRecovery();
			$page->redirect('recover.php' ,'r=messageSend');
		}else{
			$form->sendError('invalid_email', 'recover.php');
		}
		
	break;
}

?>