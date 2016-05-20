<?php
	class User extends database implements ArrayAccess {
		
		private $id;
		private $table = 'users';
		private $container;
		
		function __construct ( $id )
		{

			 parent::__construct();
			
			$this->id = $id;
			$this->container = $this->getUser();
		
		}
		
		public function getId()
		{

			return intval( $this->id );
		}
		
		public function getName()
		{

			return $this->getUser( 'name' );

		}
		
		public function getStatus() {
			return intval( $this->getUser( 'status' ) );
		}
		
		public function getPermission()
		{

			return intval( $this->getUser( 'permission' ) );

		}

		public function getFullName()
		{
			return $this->container['first_name'] .' ' .$this->container['tsn_voegsel'] .' ' .$this->container['last_name'];
		}
		
		
		public function getUser( $value  = '*' )
		{
			$sql = "SELECT $value FROM users WHERE id = ?";

			$result = parent::query($sql, $this->id)->fetch(PDO::FETCH_ASSOC);

			if( count( $result ) == 1 )
			{

				$result = implode('', $result);
			
			}

			return $result;
		}

		public function offsetSet($offset, $value) {
			if (is_null($offset)) {
				$this->container [] = $value;
			} else {
				$this->container [$offset] = $value;
			}
		}

		public function offsetExists($offset) {
			return isset($this->container [$offset]);
		}

		public function offsetUnset($offset) {
			unset($this->container [$offset]);
		}

		public function offsetGet($offset) {
			return isset($this->container [$offset]) ? $this->container [$offset] : null;
		}
		
	}


?>