<?php

require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/net/session.php';
require_once dirname(__FILE__) . '/net/encryption.php';

class Mail {
	
	private $receiver;
	private $sender = 'av-apparatuur@info.nl';
	private $subject;
	private $message;
	private static $header = "";
	
	function __construct( $receiver ){
		
		$this->receiver = $receiver;
		
	}
	
	public function sendRecovery(){
		$receiver = $this->receiver;
		$message = $this->generateMessage();
		$headers = "From: av_apparatuur@info.nl\n";
		$headers .= "Reply-To: $receiver\n";
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1";
		$this->subject = "Wachtwoord herstel";
		mail($this->receiver, $this->subject, $message, $headers);
	}
	
	
	public function generateMessage(){
		$session = new Session();
		
		$DATE_TIME = date("Y-m-d H:i:s") ."/" .microtime_float();
		$TOKEN = Encryption::generateToken('recovering');
		$USER_ID = $session->get('userId');
		
		$link = HTTP_HOST ."recover.php?d=" . urlencode($DATE_TIME) . "&t=" .urlencode($TOKEN['token']) ."&u=" .urlencode( $USER_ID );
		
		$session_array = array( "date" => $DATE_TIME, 'token' => $TOKEN['token'], 'userId' => $USER_ID );
		$session->set('recoveryDetails', $session_array );
		$message = <<<EOF
		<!doctype html>
			<head>
				<meta charset="utf-8">
				<title>Test</title>
			</head>
			<body>
				<p>Beste student,waarschijnlijk ben jij je wachtwoord vergeten.. Anders hadden we dit mail niet naar je gestuurd..<br>
				Klick op de onderstaande link om je wachtwoord te resetten</p>
				<a href=$link>Wachtwoord Resetten</a>
				
				<p>kopieer de onderstaande link en plak hem in je url bar</p>
				$link
			</body>
		</html>
EOF;
	return $message;
	}
	
	
	

}

function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return ((float)$usec + (float)$sec);
}