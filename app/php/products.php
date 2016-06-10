<?php

require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/net/database.php';

class product {
	
	private $image;
	private $name;
	private $description;
	private $serials = [];	
	private $FileExtentions = [ 'png', 'jpg', 'jpeg', 'gif' ];
	
	function __construct ($image, $name, $description)
	{
		$this->image = $image;
		$this->name = $name;
		$this->description = $description;
		
	}
	
	public function saveProduct() 
	{
		
		$db = new database();
			
		$sql = 'INSERT INTO products (name, description ) VALUES( ?, ?)';
		$db->query($sql, array($this->name, $this->description ) );
		
		return true;
	}
	
	public function saveImage( $name, $id ){
		
		$image = $_FILES[ $name ];
		
		$size = $image['size'];
		$name = $id .'_' .$image['name'];
		$tmp  = $image['tmp_name'];
		$type = strtolower( pathinfo( $name, PATHINFO_EXTENSION) );
		
		if( $this->fileReadyToUpload($name, $size, $type) ){
			
			move_uploaded_file( $tmp, ASSET_PATH .$name );
			
			return $name;
		}
		
		
		return false;
	}
	// fn = file_name, 
	// fs = file_size, 
	// $ft = file_type
	public function fileReadyToUpload( $fn, $fs, $ft ){
		
		if( file_exists( ASSET_PATH .$fn ) ){
			$this->error_message = 'file_exists';
			return false;
		}
		
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
}