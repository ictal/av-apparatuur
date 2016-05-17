<?php 
	/* alle gegevens dat wordt gelezen van de client moet worden gestript. */
	include( dirname(__FILE__) .'/php/html/page.php');
	include_once(dirname(__FILE__).'/php/net/session.php');
	include_once(dirname(__FILE__).'/php/net/database.php');
	
	$page = new Page();
	$request = $page->_define('q');
	$db = new Database();
	#$db->connect();
	
	switch($request){
		case 'load':
			$db = new Database();
			$db->connect();
				
			$product = $db->fetch_assoc( "SELECT * FROM product" ); // REMEMBER !
			
			print_r( json_encode( $product ) );
			
			$db->destroy();
			break;
			//TODO  get userid get productid make a loop through post
		case 'save':
			$db = new Database();
			$db->connect();
			
			$session = new session;
			$userId = $session->get("userId");
			$productId = 'p';
			$date = 'vandaag';
			
			$db->query("INSERT INTO rented (user_id, product_id, date) VALUES ('$userId', '$productId', '$date')");
			
			$db->destroy();
			break;
		case 'remove':
			break;
		/*array {
			table: prodct
			id: 5
			change : stock
			to : 4;
		
		array( table : user, change : pass, to : blabla, id : 1);
		case 'update':
			$array = json_decode($_POST);
				db->query("UPDATE $array['tabel'] set $array['change'] = '$array['to']' WHERE id = $array['id'] ");
			break;
		/*
			$array ();
			id
			
		case 'add':
		$array = json_decode($_POST);
		$db->query( "INSERT INTO product (serial, name, description, img, stock, serial_number)('$array[serial]', '$array[name]','$array[description]','$array[img]','$array[stock]','$array[stock]')" );
			break;
*/
	}
	
	$db->destroy();
?>