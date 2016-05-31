<?php

require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/net/database.php';

class product {
	
	private $image;
	private $name;
	private $description;
	private $serials = [];	
	private $FileExtentions = [ 'png', 'jpg', 'jpeg', 'gif' ];
	
	function __construct ($image, $name, $description, $serials)
	{
		$this->image = $image;
		$this->name = $name;
		$this->description = $description;
		$this->serials = $serials;
	}
	
	public function saveProducts() 
	{
		$image = $this->saveImage( $this->image );
		
		if( $image ){
			
			$db = new database();
			$sql = 'INSERT INTO products (name, description, img) VALUES( ?, ?, ?)';
			
			$db->query($sql, array($this->name, $this->description, $image) );
			
			$product_id = $db->getInsertedLastId();
			
			foreach( $this->serials as $serial){
				
				$sql = 'INSERT INTO serials ( product_id, serial) VALUES(?, ?)';
				
				$db->query( $sql, array($product_id, $serial) );
				
			}
			
			return true;
		}
		
		return false;
	}
	
	public function saveImage( $name ){
		
		$image = $_FILES[ $name ];
		
		$size = $image['size'];
		$name = $image['name'];
		$tmp  = $image['tmp_name'];
		$type = strtolower( pathinfo( $name, PATHINFO_EXTENSION) );
		
		if( $this->fileReadyToUpload($name, $size, $type) ){
			
			if( file_exists( ASSET_PATH .$name ))
				move_uploaded_file( $tmp, ASSET_PATH .$name );
			
			return $name;
		}
		
		
		return false;
	}
	// fn = file_name, 
	// fs = file_size, 
	// $ft = file_type
	public function fileReadyToUpload( $fn, $fs, $ft ){
		
		
		if( $fs > 500000){
			$this->error_message = 'size';

			return false;
		}
		
		if( !in_array($ft, $this->FileExtentions ) ){
			$this->error_message = 'unsported_file';
			return false;
		}
		
		return true;
	}
}