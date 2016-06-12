<?php 

	/* alle gegevens dat wordt gelezen van de client moet worden gestript. */
	include( dirname(__FILE__) .'/php/html/page.php');
	include_once(dirname(__FILE__).'/php/net/session.php');
	include_once(dirname(__FILE__).'/php/net/database.php');
	include_once(dirname(__FILE__).'/php/form/form.php');
	include_once(dirname(__FILE__).'/php/user/user.php');
	
	$page = new Page();
	$request = $page->_GET('q');
	$db = new Database();
	$session = new Session();
			
	/*
		
	*/
	switch($request){
		//Load all the products in the database
		case 'loadProductSerial':
			$sql = 'SELECT id, serial FROM serials WHERE product_id = ?';
			$responce = $db->fetchAll( $sql, array( $_POST['product_id'] ) );
			
			print_r( json_encode( array_values( $responce ) ) );
		break;
		case 'loadProducts':
			$sql = 'SELECT p.id, name, COUNT( s.product_id ) AS aantal, description FROM products AS p LEFT JOIN serials AS s ON s.product_id = p.id GROUP BY p.id';
			
			$responce = $db->fetchAll( $sql );
			
			print_r( json_encode( $responce ) );
			
		break;
		case 'loadProductsForUsers':
			#print_r( $_POST );
			
			$sql = 'SELECT * FROM products';
			
			$products = $db->fetchAll( $sql );
			
			#print_r( $products );
			
			$responce = array( 'products' => array(), 'amount' => array() );
			$amount = array();
			
			foreach( $products as $key => $value ){
				#echo 'ID: ' .$value['id'];
				#print_r( $value );
				// Total 
				$total = 'SELECT COUNT( id ) FROM serials WHERE product_id = ?';
				
				// now rented 
				$rented = 'SELECT COUNT( pr.product_id ) Amount FROM reservations AS r JOIN productreservations AS pr ON pr.reservation_id = r.id WHERE ? <= r.date_retour AND ? >= r.date_rented AND pr.product_id = ?';
				
				
				// available today
				$sql = "SELECT ( $total ) - ( $rented ) amount";
				$available_amount = $db->fetch( $sql, array( $value['id'], $_POST['date_one'], $_POST['date_two'], $value['id'] ) );
				
				
				$available_products = intval( $available_amount['amount'] );
				
				$amount[ $value['name'] ]  = $available_products;
				
				if( $available_products > 0 )
					array_push( $responce['products'], $products[ $key ] );
				
			}
		
			$responce['amount'] = $amount;
			
			print_r( json_encode( $responce ) );

			break;
		case 'users':
		
			$users = $db->fetchAll( "SELECT id, first_name, tsn_voegsel, last_name, email, mobile, student_number, last_login FROM users" ); // REMEMBER !

			print_r( json_encode( $users ) );
			
			$db->destroy();
			
			break;
		case 'statistic':
		
			$rentedProducts = $db->fetch( "SELECT COUNT( id ) amount FROM productreservations WHERE product_serial iS NOT NULL" )['amount'];
			$reservationsList = $db->fetch( "SELECT COUNT(id) amount FROM reservations" )['amount'];
			$newReservations = $db->fetch( "SELECT COUNT( id ) amount FROM productreservations WHERE product_serial iS NULL" )['amount'];
			$productsList = $db->fetch( "SELECT COUNT( id ) amount FROM serials " )['amount'];
			
			$responce = array(
				'rentedProducts' => $rentedProducts,
				'reservationsList' => $reservationsList,
				'newReservations' => $newReservations,
				'productsList' => $productsList
			);
			
			print_r( json_encode( $responce ) );
			
			break;
		case 'reservations':
		
			$sql = "SELECT 
					r.id , 
					CONCAT( u.first_name, ' ', u.tsn_voegsel, ' ', u.last_name ) AS user_name, 
					u.picture as user_img,
					p.name AS product_name,
					r.date_rented,
					r.date_retour,
					COUNT(pr.reservation_id) AS product_amount
					FROM reservations as r 
					JOIN productreservations as pr ON r.id = pr.reservation_id 
					JOIN products as p ON p.id = pr.product_id
					JOIN users as u ON r.user = u.id 
					WHERE pr.product_serial IS NULL
					GROUP BY pr.reservation_id";
					
			$sql_two = "SELECT r.id, CONCAT( u.first_name, ' ', u.tsn_voegsel, ' ', u.last_name ) AS username,  u.picture as user_img, pr.product_id,p.name product , COUNT( pr.id ) product_amount, r.date_rented, r.date_retour FROM reservations AS r JOIN productreservations AS pr ON pr.reservation_id = r.id JOIN products AS p ON p.id = pr.product_id JOIN users AS u ON u.id = r.user WHERE pr.product_serial IS NOT NULL GROUP BY pr.product_id";
				
			$active_reservations = $db->fetchAll( $sql   );
			$confirmed_reservations = $db->fetchAll( $sql_two );
			
			$responce = array(
				'reservationsList' => '',
				'confirmed_reservations' => $confirmed_reservations,
				'active_reservations' => $active_reservations,
			);
			
			print_r( json_encode( $responce ) );
			break;
		case 'updateReservation':
			print_r( $_POST );
			if( $session->_isset('logged_in') ){
				
				$user = new User( $session->get('userId') );
				$reservation_id = $_POST['reservation_id'];
				
				if( $user->getPermission() > 0 ){
					
					foreach( $_POST['selectedProducts'] as $key ){
						$sql = 'UPDATE productreservations SET product_serial = ? WHERE product_id = ? AND id = ? AND reservation_id = ?';
						
						$db->query( $sql , array( $key['serial'], $key['productId'], $key['id'], $_POST['reservation_id']));
						
					}
				}
			}
			
			break;
		case 'loadSerials':
			#print_r( $_POST );
			
			if( $session->_isset('logged_in') ){
				
				$user = new User( $session->get('userId') );
				$reservation_id = $_POST['reservation_id'];
				
				if( $user->getPermission() > 0 ){
					
					//get selected product Id;
					$sql = "SELECT pr.id, p.id AS productId, p.img, p.name FROM productreservations AS pr JOIN products AS p ON p.id = pr.product_id WHERE pr.reservation_id = ?";
					$selected_products = $db->fetchAll( $sql, array( $reservation_id ) );
					
					#print_r( $selected_products );
					
					$product_array = array();
					foreach( $selected_products as $key ){
						$id = $key['productId'];
						if( !array_key_exists($id, $product_array ) ){
							
							$sql = 'SELECT s.id, s.serial AS value FROM serials AS s LEFT JOIN productreservations AS pr ON s.id = pr.product_serial WHERE pr.product_serial IS NULL AND s.product_id = ?';
							$result = $db->fetchAll( $sql, array( $id ) );
							$product_array[ $id ] = $result;
						}
						
					}
					$responce = array(
						'slected_products' => $selected_products,
						'serialList' => $product_array,
						'reservationId' => $_POST['reservation_id'],
					);
					
					print_r( json_encode( $responce ) );	
				}
			}
			
			break;
		case 'updateUser':
		
			//security CHECK.
		
			if( $session->_isset('logged_in') ){
				
					$user = new User( $session->get('userId') );
					$user_id = $_POST['id'];
					
					unset($_POST['id']);
					unset($_POST['$$hashKey']);
					
					$user_details = array_keys($_POST);
					$update_details = array_values($_POST);
					
					print_r($user_details);
					print_r($update_details);
					
					var_dump( $db->updateUser($user_id , $user_details, $update_details) );
					
				/*	
					$form = new Form($_POST);
					$type = $form['type'];
					
					switch( $type ){
						
						case 'reservations':
							$accepted = $form['accepted'];
							$user_id = $form['user_id'];
							if($accepted){
								var_dump( $db->updateReservation($user_id, array('rented'), array('1'), 'reservations') );
								echo 'succeed';
							}
							
							break;
						
					}*/
				
				
			}
			break;
		
		case 'updateProduct':
		
			
			if( $session->_isset('userId') )
			{
				$user = new User( $session->get('userId') );
				
				if($user->getPermission() > 0)
				{
					//TODO Token check.
					unset($_POST['$$hashKey'],$_POST['stock'] );
					$db->updateProduct( $_POST );
				}
			}
			break;
		case 'deleteReservation':
			
			if( $session->_isset('userId') )
			{
				$user = new User( $session->get('userId') );
				
				if($user->getPermission() > 0)
				{
					
					$sql_one = 'DELETE FROM reservations WHERE id = ?';
					$sql_two = 'DELETE FROM productreservations WHERE reservation_id = ?';
					
					$db->query( $sql_one, $_POST['reservation_id'] );
					$db->query( $sql_two, $_POST['reservation_id'] );
						
				}
			}
		break;
		case 'deleteUser':
			$id = $_POST['id'];
			if( $session->_isset('userId') )
			{
				$user = new User( $session->get('userId') );
				
				if($user->getPermission() > 0)
				{
					
					$sql = 'DELETE FROM users WHERE id = ?';
					
					$db->query( $sql, array( $id ) );
					
				}
				
			}
		break;
		case 'deleteProducts':

			if( $session->_isset('userId') )
			{
				$user = new User( $session->get('userId') );
				
				if($user->getPermission() > 0)
				{
					
					$db->deleteProduct( $_POST['products'] );
				}
			}
			break;
		case 'saveEditProduct':
			if( $session->_isset('userId') )
			{
				$user = new User( $session->get('userId') );
				
				if($user->getPermission() > 0)
				{
					
					print_r( $_POST );
					
					//update product sql 
					$product_sql = 'UPDATE products SET name = ?, description = ?, img = ? WHERE id = ?';
					
					$db->query($product_sql, array( $_POST['name'], $_POST['description'], $_POST['img'], $_POST['id'] ));
					foreach( $_POST['serials'] as $key => $value ){
						$id = explode('_', $value['id']);
						
						print_r($value);
						
						//new serial
							$sql = 'INSERT INTO serials (product_id, serial) VALUES(? , ?)';
							$db->query($sql, array( $_POST['id'], $value['serial'] ) );
							
						}else{
							$sql = 'UPDATE serials SET serial = ? WHERE id = ? AND product_id = ?';
							
							$db->query( $sql, array( $value['serial'], $value['id'], $_POST['id'] ) );
						}
					}
					
					
				}
			}
		break;
		case 'save':
			if($session->_isset( 'logged_in' )){
				#print_r( $_POST );
				
				$orderList = $_POST['orderList'];
				$userId = $session->get('userId');
				$rent_date = $orderList[0]['rent_date'];
				$retour_date = $orderList[0]['retour_date'];
				
				unset( $orderList[0] );
				
				//make a new reservation.
				$sql = 'INSERT INTO reservations ( user , date_rented, date_retour) VALUES ( ?, ?, ? )';
				$values = array( $userId, $rent_date, $retour_date );
				$db->query($sql, $values);
				
				$reservation_id = $db->getlastInsertId();
				echo $reservation_id;
				//make add product info to the reservation.
				foreach($orderList as $key ){

					$times = intval( $key['amount'] );
					for( $i = 0 ; $i < $times; $i++){
						
						$sql = 'INSERT INTO productreservations ( reservation_id, product_id ) VALUES ( ?, ? )';
						$db->query( $sql, array( $reservation_id, $key['id'] ) );
						
					}
				}
			
			}
			break;
		case 'userHistory':
			if($session->_isset('logged_in')){
				$userId = $session->get( 'userId' );
				//history
				$sql = "SELECT p.name , r.amount, s.serial, r.date_rented, r.date_retour FROM reservations as r JOIN products as p on p.id = r.product JOIN serial as s ON p.id = s.product_id WHERE r.user = '$userId' AND r.rented = '1'";
				$history = $db->fetchAll($sql);
				
				//recenty activity
				$sql = "SELECT p.name , r.amount, s.serial, r.date_rented, r.date_retour FROM reservations as r JOIN products as p on p.id = r.product JOIN serial as s ON p.id = s.product_id WHERE r.user = '$userId' AND r.rented = '0'";
				$activity = $db->fetchAll($sql);
				
				$responce = array( 
					'history' => $history,
					'activity' => $activity,
				);
				
				print_r( json_encode( $responce ) );
			}
			break;
		
	}
	
	$db->destroy();
?>