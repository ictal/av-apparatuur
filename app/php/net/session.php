<?php
if(!session_started())
	session_start();

	class session {

		//Return value of $key;
		function get($key){
			return unserialize($_SESSION[$key]);
		}
		
		//set $value in session with $key as name;
		function set($key, $value){
			if($this->_isset( $key )){
				$this->remove( $key );
			}
			$_SESSION[$key] = serialize($value);
		}
		
		//destroy the session;
		public function destroy(){
			session_unset();
			session_destroy();
		}
		
		//check if the $key is set in Session
		public function _isset( $key ){
			return isset($_SESSION[$key]);
		}
		
		//remove $key and value from session;
		public function remove($key){
			unset($_SESSION[$key]);
		}
		
		public function getUser( $arg='*' ){
			$db = new Database();
			$user = $db->getUser($this->get('userId'), $arg);
			$db->destroy();
			return $user;
		
		}
		
			
	}
	
	function session_started()
	{
		if ( php_sapi_name() !== 'cli' ) {
			if ( version_compare(phpversion(), '5.4.0', '>=') ) {
				return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
			} else {
				return session_id() === '' ? FALSE : TRUE;
			}
		}
		return FALSE;
	}
?>