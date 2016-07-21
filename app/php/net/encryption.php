<?php
include_once(dirname(__FILE__).'/session.php');


	class Encryption {
		
		public static function _hash ($password, $salt) {
			$options = [
				'cost' => 11,
				'salt' => $salt,
			];
			return password_hash($password, PASSWORD_BCRYPT, $options);
		}
		
		public static function generateSalt($size = 22){
			return base64_encode( mcrypt_create_iv($size, MCRYPT_DEV_URANDOM) );
		}
		
		public static function generateToken( $token ){
			$salt = Encryption::generateSalt();
			
			return array('token' => Encryption::_hash($token, $salt), 'salt' => $salt );
		}
		
	}
	/*
	$options = [
		'cost' => 11,
		'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
	];
	echo base64_encode($options['salt']);
	echo "\n";
	echo "Hello -> Hashed = " .password_hash("Hello", PASSWORD_BCRYPT)."\n";
	*/
?>