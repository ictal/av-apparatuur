<?php

/**
*  class page
*/
class Page
{
	//current page that the user in on.
	private $current_page;
	
	//pages the user can access.
	private $page_list = array(
		'login' => 
			array(
					'parent' => 'index.php',
					'dir' => '/pages/login.php', 
				),
		'user_profile' => 
			array(
					'parent' => 'index.php',
					'dir' => '/pages/user_profile.php', 
				),
		'index' => 
			array(
					'parent' => 'dashboard.php',
					'dir' => '/pages/dashboard/index.php', 
				),
		'users' => 
			array(
					'parent' => 'dashboard.php',
					'dir' => '/pages/dashboard/users.php', 
				),
		'products' => 
			array(
					'parent' => 'dashboard.php',
					'dir' => '/pages/dashboard/products.php', 
				),
		);

	private $error_List = array(
	
		'WRONG_LOGIN_DETAILS' => array(
			'message' => 'De door u ingevoerde combinatie van gebruikersnaam en wachtwoord is bij ons niet bekend.'
			),
			
		'INCOMPLETE_FORM' => array(
			'message' => 'U heeft niet alle verplichte velden ingevuld.'
			),
			
		'UNACCEPTED_TERMS' => array(
			'message' => 'U bent niet akkoord gegaan met onze voorwaarden.'
			),
			
		'INVALID_TOKEN' => array(
			'message' => 'U probeert te registreren met een ongeldige token. Uw handelingen zijn opgeslagen voor nader onderzoek.'
			)
			
	);
	function __construct( $page = false)
	{
		//defines the current page
		if($page)
			$this->current_page = $page;

		if($this->_GET('p')){
			$this->current_page = $this->_GET('p');
		}

	}
	

	//defines the $key in the $_GET
	public function _GET ( $key )
	{

		if( isset( $_GET[ $key ] ) )
		{
		
			return $_GET[ $key ];
	
		}
		else
		{
		
			return false;
	
		}
	}

	public function redirect ( $page, $get )
	{
		header( 'Location: ' .$page .$get );
	}

	public function handleGET()
	{
		foreach($_GET as $key => $value )
		{
			$request =  $key ;
			$request_value = $this->_GET( $request );

			switch( $request )
			{
				case 'logout':
					$_SESSION = [];
					session_destroy();
					$this->redirect('index.php');
				break;
				case 'p':
				if($request_value)
					$this->load( $request_value );
				break;

			}

		}

	}
	//loads requested file
	public function load( $page = false  )
	{	
		if($page == $this->current_page)
			return;
		
		if(!$page)
			$page = $this->getCurrentPage();

		//local varible that contains page_page list array
		$page_list = $this->page_list;
		
		//does tha page exist in our page list
		if( array_key_exists($page, $page_list) )
		{
			//get the dir name of the requested page.
			$page_dir = $page_list[ $page ]['dir'];
			$parent = $page_list[ $page]['parent'];

			if( strpos($_SERVER['SCRIPT_NAME'],  $parent) !== false)
			{
				//include the page to the this file.
				$this->_include( $page_dir );
			}
		
			
		}
	}

	//$root = http://localhost/AV/
	//include file from $root/php/html/
	public function _include( $file )
	{

		//include requested file
		include( dirname( __FILE__ ) .$file);

	}


	public function display_errors() 
	{
		$session = new Session();

		if($session->_isset('error'))
		{
			return $this->error( $session->get('error') );
		}
	}

	private function error( $errorType )
	{
		$errorType = strtoupper( $errorType );
		$error = $this->error_List[ $errorType ]['message'];

		$error_string = "<section class='notice'>";
		$error_string .= "<p>$error</p></section>";

		return $error_string;
	}

	//getter and setter for $this->current_page;
	public function getCurrentPage()
	{
		return $this->current_page;
	}

	public function setCurrentPage( $page )
	{
		$this->current_page = $page;
	}
}
?>