<?php
include_once(dirname(__FILE__).'/../net/session.php');
include_once(dirname(__FILE__).'/../html/page.php');

	class Form implements ArrayAccess{
		
		public $_type;
		private $container = array();
		private $empty_input_exeptions = array( 'tsn_voegsel' );

		function __construct ($post ){
			$this->_type  = $post['type'];
			$this->container  = $post;
			$this->strip();
			
			unset($this->container['type']);
			unset($this->container['voorwaarden']);
			
		}

		public function getValue( $input ){
			
			return $this->container [ $input ];
		}
		
		public function setValue( $input, $value ){
			
			$this->container [ $name ] = $value;
			
		}
		
		public function getName(){
			return $this->_name;
		}
		
		public function getContainer() {
			return $this->container;
		}
		
		public function strip() {
			
			foreach( $this->container  as $key => $value ) {
				
				$clear = strip_tags($value);
				$clear = html_entity_decode($clear);
				$clear = urldecode($clear);
				$clear = preg_replace('/[^A-Za-z0-9]/', ' ', $clear);
				$clear = preg_replace('/ +/', ' ', $clear);
				$clear = trim($clear);
				$value = $clear;
				
				
			}
			
		}
		
			public function validate() {
				
				foreach( $this->container as $key => $value ){
					echo $value;
					if( !in_array( $key, $this->empty_input_exeptions ) && empty( $value ) ){
						return false;
					}
				}
				
				if( !array_key_exists('token', $this->container ) ){					
					return false;
				}
				
				return true;
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
		
		public function sendError( $error, $page ){
			$session = new Session();
			$p = new Page();
			
			$session->set('error', $error);
			$p->redirect($page ,'?error=' .$error);
		}
		
	}
	
	
?>