<?php
	class cbms_AvailableBook
	{
		public $id = null;
		public $diamondcode = null;
		public $title = null;
		public $job = null;		
		public $creative_team = null;
		public $synopsis = null;
		public $img = null;
		
		public function __construct( $data=array() ) 
		{
		  if(isset($data['id']))
			{
			  $this->id = (int) $data['id'];
			}	
			
		  if( isset( $data['diamondcode'] ) )
			{
			  $this->diamondcode = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['diamondcode'] );
			}
			
		  if( isset( $data['title'] ) )
			{
			  $this->title = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()\#]/", "", $data['title'] );
			}		
			
		  if( isset( $data['job'] ) )
			{
			  $this->job = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['job'] );
			}

		  if( isset( $data['creative_team'] ) )
			{
			  $this->creative_team = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()(\n){2}]/", "", $data['creative_team'] );
			}
			
		  if( isset( $data['synopsis'] ) )
			{
			  $this->synopsis = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()(\n){2}]/", "", $data['synopsis'] );
			}			
			
		  if( isset( $data['img'] ) )
			{
			  $this->img = preg_replace ( "/[^\.\,\-\_\'\"\@\?\!\:\$ a-zA-Z0-9()]/", "", $data['img'] );
			}						
		}	

		
		/**Store Values Passed By Admin.*/
		public function storeFormValues( $params ) {
			$this->__construct( $params );
		}



		/**Insert New Book.*/
		public function insert() {
			global $wpdb;
			$table_name = $wpdb->prefix . 'cbms_availablenow';
			$wpdb->insert($table_name, 
				array(
				  'id'			=> $this->id,	
				  'diamondcode' => $this->diamondcode,
				  'title'       => $this->title,
				  'job'       	=> $this->job,			
				  'creativeteam'=> $this->creative_team,
				  'synopsis'    => $this->synopsis,
				  'img'       	=> $this->img
				)
			  ); 
			  
			$this->id = $wpdb->insert_id; 
		}
		

		
		/**Update Book.*/
		public function update() {
			if(is_null($this->id))
              {
				trigger_error("There is No Book with ID $this->id", E_USER_ERROR );
			  }

			global $wpdb;
			$table_name = $wpdb->prefix . 'cbms_availablenow';			  
			$wpdb->update( $table_name, 
				array( 
					'id' 		  => $this->id,
					'diamondcode' => $this->diamondcode,
					'title'       => $this->title,
					'job'       	=> $this->job,			
					'creativeteam'=> $this->creative_team,
				    'synopsis'    => $this->synopsis,
					'img'       	=> $this->img
				), 
				array( 'id' => $this->id ), 
				array( 
					'%s',
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'	
				), 
				array( '%s' ) 
			);	
		}		
		

		
		/**Delete Book.*/
		public function delete() {
			if(is_null($this->id))
              {
				trigger_error("Cannot Find Book $this->title", E_USER_ERROR );
			  }

			global $wpdb;
			$table_name = $wpdb->prefix . 'cbms_availablenow';			  
			$wpdb->delete( $table_name, array( 'id' => $this->id ) );
		}			
		
		
		
		
		/**Get Book List.*/
		public static function getList( $numRows=1000000 ) {
			global $wpdb;
			$table_name = $wpdb->prefix . 'cbms_availablenow';	

			$books = $wpdb->get_results( 
				"SELECT * 
				FROM " . $table_name ." ORDER BY title ASC"
			);
			
			if( count( $books ) > 0 )
			  {
				 foreach( $books as $book )
				 {
					$array = array(							
							'id' => $book->id,
							'diamondcode' => $book->diamondcode,
							'title' => $book->title,
							'job' => $book->job,
							'creative_team'=> $book->creativeteam,
				  		 	'synopsis'    => $book->synopsis,
							'img' => $book->img
					);				   
				   $upcomingbook = new cbms_AvailableBook($array);
				   $list[] = $upcomingbook;
				 }
				return($list); 
			  }						
			return(null);
		}		

		
		
		/**Check if Book is Already Stored.*/
		 public static function isStored( $id ) {		
			$bookStored = false;
			global $wpdb;
			$table_name = $wpdb->prefix . 'cbms_availablenow';		
		 
			$books = $wpdb->get_results( 
				"SELECT * 
				FROM " . $table_name .
				" WHERE id = " . $id ." LIMIT 1"
			);		
			
			if( count($books)> 0 )
			  {
			    $bookStored = true;	 
			  }			
			
			return $bookStored;	
		}
		
		
		
		/**Get By ID.*/
		public static function getByID( $id ) {		
			$bookStored = false;
			global $wpdb;
			$table_name = $wpdb->prefix . 'cbms_availablenow';		
			$array = array();
			
			$books = $wpdb->get_results( 
				"SELECT * 
				FROM " . $table_name .
				" WHERE id = " . $id ." LIMIT 1"
			);		
			
			if( count($books)> 0 )
			  {
			    foreach ( $books as $book ) 
			    {
					$array = array(
					  'id'			=> $book->id,
					  'diamondcode' => $book->diamondcode,
					  'title'       => $book->title,
					  'job'       	=> $book->job,
					  'creativeteam'=> $book->creativeteam,
				      'synopsis'    => $book->synopsis,
					  'img'       	=> $book->img
					);
			    }
			  }	
			  
		  return $array;	  
		}		

		

		/**Store the Cover Image That Was Uploaded.*/
		public function storeUploadedImage( $image ) {
 
			if( $image['error'] == UPLOAD_ERR_OK )
			 {  
				if( is_null( $this->id ) ) 
				  {
				    trigger_error( "Book::storeUploadedImage(): Attempt to upload an image for an Article object that does not have its ID property set.", E_USER_ERROR );
				  }
				  
				$this->deleteImages();
				$this->img = strtolower( strrchr($image['name'], '.' ) );

				$tempFilename = trim( $image['tmp_name'] ); 
		 
				if(is_uploaded_file($tempFilename)) 
				  {
					if( !( move_uploaded_file( $tempFilename, $this->getImagePath() ) ) )
					  {
						trigger_error("Book::storeUploadedImage(): Couldn't move uploaded file.", E_USER_ERROR);
					  }
					
					if( !( chmod( $this->getImagePath(), 0666 ) ) ) 
					  {
						trigger_error("Book::storeUploadedImage(): Couldn't set permissions on uploaded file.", E_USER_ERROR);
					  }
					
				  }

				$attrs = getimagesize( $this->getImagePath() );
				$imageWidth = $attrs[0];
				$imageHeight = $attrs[1];
				$imageType = $attrs[2];
 
 
				switch( $imageType ){
					case IMAGETYPE_GIF:
					  $imageResource = imagecreatefromgif( $this->getImagePath() );
					  break;
					case IMAGETYPE_JPEG:
					  $imageResource = imagecreatefromjpeg( $this->getImagePath() );
					  break;
					case IMAGETYPE_PNG:
					  $imageResource = imagecreatefrompng( $this->getImagePath() );
					  break;
					default:
					  trigger_error( "Book::storeUploadedImage(): Unhandled or unknown image type ($imageType)", E_USER_ERROR );
				}
 
			    $this->update();
		      }
		}

 
		/**Delete Cover Images.*/
		public function deleteImages() {
			foreach( glob( trailingslashit( WP_CONTENT_DIR ) . 'cbms_CoversNow/'  . $this->id . $this->img) as $filename )
			{
			   if( !unlink( $filename ) ) 
				 {
				   trigger_error( "Book::deleteImages(): Couldn't delete image file.", E_USER_ERROR );
				 }
			}

			$this->img = "";
		}
 
 
		/**Set The Path For Cover Image.*/
		public function getImagePath() {
			return( $this->id && $this->img ) ? (trailingslashit( WP_CONTENT_DIR ) . 'cbms_CoversNow/'  . $this->id . $this->img ) : false;
		}




	}