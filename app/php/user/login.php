<?php
include_once(dirname(__FILE__).'/../net/session.php');

$session = new Session();
	if($session->_isset('userId'))
		header('Location: http://localhost/AV/index.php');
	
include_once(dirname(__FILE__)."/../net/database.php");
include_once(dirname(__FILE__).'/../html/page.php');
include(dirname(__FILE__).'/user.php');

	class Login{
		
		private $_username;
		private $_password;
		
		function __construct ($username, $password ) {
			
			$this->_username = $username;
			$this->_password = $password;
			
		}
		
		public function proceed(){
			
			$db = new Database();

			$username = $this->_username;
			$password = $this->_password;
		
			if( $db->existUser($username, $password )){ 
				$user = $db->getUser( $username );
				
				$session = new session();
				$session->set("logged_in", 'true' );
				$session->set("userId", $user["username"]);
				
				header('Location: ' ."http://localhost/AV/".'index.php'); // TODO root/index.php
				$db->destroy();
				return true;
			}else{
				header('location: '. "http://localhost/AV/".'?error=1');
				$db->destroy();
				return false;
			}
			
			$db->destroy();
			return false;
		}
		
		public function _die(){
			
			
		}
		
		
	}
	
	
	
?>