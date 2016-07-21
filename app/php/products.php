<?php

require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/net/database.php';

class product {
	
	private $image;
	private $name;
	private $description;
	private $serials = [];
	private $error_message;
	private $lastInsertedId;
	private $img_name;
	private $FileExtentions = [ 'png', 'jpg', 'jpeg', 'gif' ];
	
	function __construct ($image, $name, $description)
	{
		$this->image = $_FILES[ $image ];
		$this->name = $name;
		$this->description = $description;
		
	}
	
	public function saveProduct() 
	{
		
		$db = new database();
			
		$sql = 'INSERT INTO products (name, description ) VALUES( ?, ?)';
		
		$db->query($sql, array($this->name, $this->description ) );
		$this->lastInsertedId = $db->getInsertedLastId();
		if( $this->saveImage() ){
			$sql = "UPDATE products SET img = ? WHERE id = ?";
			$db->query( $sql, array( $this->img_name, $this->lastInsertedId ));
		}
		
			
	}
	
	public function saveImage(){
		
		$image = $this->image;
		print_r( $image );
		$id = uniqid();
		$size = $image['size'];
		$name = $id .'_' .$image['name'];
		$tmp  = $image['tmp_name'];
		$type = strtolower( pathinfo( $name, PATHINFO_EXTENSION) );
		
		if( $this->fileReadyToUpload($name, $size, $type) ){
			move_uploaded_file( $tmp, ASSET_PATH .$name );
			$this->img_name = $name;
			return true;
		}
		
		
		return false;
	}
	// fn = file_name, 
	// fs = file_size, 
	// $ft = file_type
	public function fileReadyToUpload( $fn, $fs, $ft ){
		
		if( $fs > 500000){
			$this->error_message = 'file_size_error';
			return false;
		}
		
		if( !in_array($ft, $this->FileExtentions ) ){
			$this->error_message = 'file_unsuported';
			return false;
		}
		
		return true;
	}

	public function debug() {

	}

	public function getError() {

		return $this->error_message;
	}

}