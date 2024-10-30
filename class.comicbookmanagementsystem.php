<?php
class ComicBookManagementSystem{

    public function __construct() {
        add_action('admin_enqueue_scripts', array($this,'enqueueAdmin'));
        add_action('wp_enqueue_scripts', array($this,'enqueue'));
		add_action('admin_menu', array(&$this, 'cbms_AdminMenu'));
    }

  
	/**Load Admin Scripts.*/
    public function enqueueAdmin() {
    	wp_enqueue_script('cbms_admin_script', plugins_url('js/cbms_admin.js', __FILE__), array('jquery'), '1.0', true);
    	wp_enqueue_style('cbms_admin_style', plugins_url('css/cbms_admin.css', __FILE__), null, '1.0');
    }
	

	/**Load Front-End Scripts.*/
    public function enqueue() {
    	wp_enqueue_script('cbms_script', plugins_url('js/cbms.js', __FILE__), array('jquery'), '1.0', true);
    	wp_enqueue_style('cbms_style', plugins_url('css/cbms.css', __FILE__), null, '1.0');
		wp_enqueue_script('owl-js', plugins_url('owl/owl.carousel.js', __FILE__), array('jquery'), '1.0', true);
    	wp_enqueue_style('owl-css', plugins_url('owl/owl.carousel.min.css', __FILE__), null, '1.0');
    	wp_enqueue_style('owl-theme--css', plugins_url('owl/owl.theme.default.css', __FILE__), null, '1.0');
    }
	
	
	/**Admin Menu.*/
	function cbms_AdminMenu() {
		add_menu_page('Comic Book Management System','CBMS', 'manage_options',  'comic_book_management_system', array( &$this, 'cbms_admin_page'), plugins_url('img/icon.png', __FILE__) );		
    }	

	
	/**Display Menu.*/
	function cbms_admin_page() {
		$action = isset($_GET['action']) ? $_GET['action'] : "";

		/**Main Admin Page.*/
		function cbms_welcome() {
			require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_admin_page.php' );
		}
		
		/**List All Books.*/
		function cbms_listall() {
			$results = array();
			$results['book'] = cbms_Book::getList();
			require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_listall.php' );
		}		
		
		/**Add A New Book.*/
		function cbms_addbook() {
			if( isset( $_POST['addbook'] ) ) 
		      {
			    if( !empty( $_POST['diamondcode'] ) )
				  {
					$diamond_code = sanitize_text_field($_POST['diamondcode']);
					$diamond_code = strtoupper($diamond_code);
					update_post_meta(0, 'diamondcode', $diamond_code);
				  }
				$title = sanitize_text_field($_POST['title']);
				update_post_meta(0, 'title', $title);

			    if( !empty( $_POST['creative_team'] ) )
				  {
					$creative_team = sanitize_textarea_field($_POST['creative_team']);
					update_post_meta(0, 'creative_team', $creative_team);
				  }

			    if( !empty( $_POST['synopsis'] ) )
				  {
					$synopsis = sanitize_textarea_field($_POST['synopsis']);
					update_post_meta(0, 'synopsis', $synopsis);
				  }				  

				$job = null;
				if(!empty( $_POST['job'] ))
				  {
				    $job = filter_var_array( $_POST['job'], FILTER_SANITIZE_STRING, true );
				  }
				$jobString = "";
				$count = 0;  
			  
				if( !empty( $job ) ) 
			      {
					foreach( $job as $check ) 
				    {
				      if( $count == 0 )
					   {
					     $jobString = ( $check );
					   }
				      else
				       {
					     $jobString = ( $jobString . ", " . $check );
					   }
					  
				      $count++;
				    }
			     }			  
			   
				$_POST['job'] = $jobString;			  
			    $book = new cbms_Book; 
				$book->storeFormValues( $_POST );
			    $book->insert();
				
				if( isset( $_FILES['bookimage'] ) ) 
				  {
					$book->storeUploadedImage( $_FILES['bookimage'] );
				  }	
				
				$_SESSION['status'] = esc_attr( $title ) . " Added";
		      	cbms_welcome();
			  }
			else
			  {
				require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_addbook.php' );	
			  }
		}

		
		
		/**Update Book.*/
		function cbms_updatebook() {
			$results = array();
			$results['formAction'] = "updateBook";

			if( isset( $_POST['updatebook'] ) )
			  {
			  	$id = filter_var( $_POST['id'], FILTER_SANITIZE_NUMBER_INT);
			    if( !empty( $_POST['diamondcode'] ) )
				  {
					$diamond_code = sanitize_text_field($_POST['diamondcode']);
					$diamond_code = strtoupper($diamond_code);
					update_post_meta(0, 'diamondcode', $diamond_code);
				  }
				$title = sanitize_text_field($_POST['title']);
				update_post_meta(0, 'title', $title);

			    if( !empty( $_POST['creative_team'] ) )
				  {
					$creative_team = sanitize_textarea_field($_POST['creative_team']);
					update_post_meta(0, 'creative_team', $creative_team);
				  }

			    if( !empty( $_POST['synopsis'] ) )
				  {
					$synopsis = sanitize_textarea_field($_POST['synopsis']);
					update_post_meta(0, 'synopsis', $synopsis);
				  }				  

				$job = null;
				if( !empty( $_POST['job'] ))
				  {
				    $job = filter_var_array( $_POST['job'], FILTER_SANITIZE_STRING, true );
				  }
				  
				$jobString = "";
				$count = 0;  
			  
				if( !empty( $job ) ) 
			      {
					foreach( $job as $check ) 
				    {
				      if( $count == 0 )
					   {
					     $jobString = ( $check );
					   }
				      else
				       {
					     $jobString = ( $jobString . ", " . $check );
					   }
					  
				      $count++;
				    }
			      }			  
			    $_POST['job'] = $jobString; 

				$bookStored = cbms_Book::isStored( $id );
				if( $bookStored ) 
				  {
				    $book = new cbms_Book;
				    $book->storeFormValues( $_POST );

					if( isset( $_FILES['bookimage']['name'] ) ) 
					  {
						 $book->storeUploadedImage( $_FILES['bookimage'] );
					  }
					$book->update();
					$_SESSION['status'] = esc_attr( $title ) . " Updated";
				  }
				else
				  {
					$_SESSION['status'] =  "Book Not Found";
				  }		

				cbms_welcome();
			  }
			else
			  {
			  	 $id = absint( $_GET['id'] );	
				 $results['book']= cbms_Book::getByID( $id );

				 if($results['book'] != null)
				   {
				     require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_addbook.php' );	
				   }
				 else
				  {
					cbms_listall();
				  }
			  }			  	
		}		

		
		/**Delete Book.*/
		function cbms_deletebook() {
			$results = array();
			$id = absint( $_GET['id'] );
			$results['book']= cbms_Book::getByID( $id );
			if($results['book'] != null)	
			  {
				$book = new cbms_Book;
				$book->storeFormValues( $results['book'] );
				$book->deleteImages(); 
				$book->delete();
				$_SESSION['status'] = $_GET['title'] . " Deleted";
			  }
			 else
			  {
				$_SESSION['status'] =  $_GET['title'] . " Not Found";
			  }
			
			cbms_welcome();
		}

		

		
		
		
		/**Add a Book Available Now.*/
		function cbms_addavailablenow() {
			if( isset( $_POST['addavailablebook'] ) ) 
		      {
			    if( !empty( $_POST['diamondcode'] ) )
				  {
					$diamond_code = sanitize_text_field($_POST['diamondcode']);
					$diamond_code = strtoupper($diamond_code);
					update_post_meta(0, 'diamondcode', $diamond_code);
				  }
				  
				$title = sanitize_text_field($_POST['title']);
				update_post_meta(0, 'title', $title);

			    if( !empty( $_POST['creative_team'] ) )
				  {
					$creative_team = sanitize_textarea_field($_POST['creative_team']);
					update_post_meta(0, 'creative_team', $creative_team);
				  }

			    if( !empty( $_POST['synopsis'] ) )
				  {
					$synopsis = sanitize_textarea_field($_POST['synopsis']);
					update_post_meta(0, 'synopsis', $synopsis);
				  }	

				$job = null;
				if( !empty( $_POST['job'] ))
				  {
				    $job = filter_var_array( $_POST['job'], FILTER_SANITIZE_STRING, true );
				  }
				  
				$jobString = "";
				$count = 0;  
			  
				if( !empty( $job ) ) 
			      {
					foreach( $job as $check ) 
				    {
				      if( $count == 0 )
					   {
					     $jobString = ( $check );
					   }
				      else
				       {
					     $jobString = ( $jobString . ", " . $check );
					   }
					  
				      $count++;
				    }
			     }			  
			   
				$_POST['job'] = $jobString;			  
			    $availablebook = new cbms_AvailableBook; 
				$availablebook->storeFormValues( $_POST );
			    $availablebook->insert();
				
				if( isset( $_FILES['bookimage'] ) ) 
				  {
					$availablebook->storeUploadedImage( $_FILES['bookimage'] );
				  }	
				
				$_SESSION['status'] = esc_attr( $title ) . " Added";
				cbms_welcome();
			  }
			else
			  {
				require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_addavailablebook.php' );	
			  }			  
		}
		
		
		/**List All Books Available Now.*/
		function cbms_listavailablenow() {
			$resultsAvailableNow = array();
			$resultsAvailableNow['bookAvailablenow'] = cbms_AvailableBook::getList();
			require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_listallavailablenow.php' );
		}		
		
		
		/**Update Book Available Now.*/
		function cbms_updateavailablebook() {
			$resultsAvailableNow = array();
			$resultsAvailableNow['formAction'] = "updateBook";
			
			if( isset( $_POST['updatebook'] ) )
			  {
			  	$id = filter_var( $_POST['id'], FILTER_SANITIZE_NUMBER_INT);
			    if( !empty( $_POST['diamondcode'] ) )
				  {
					$diamond_code = sanitize_text_field($_POST['diamondcode']);
					$diamond_code = strtoupper($diamond_code);
					update_post_meta(0, 'diamondcode', $diamond_code);
				  }
				$title = sanitize_text_field($_POST['title']);
				update_post_meta(0, 'title', $title);

			    if( !empty( $_POST['creative_team'] ) )
				  {
					$creative_team = sanitize_textarea_field($_POST['creative_team']);
					update_post_meta(0, 'creative_team', $creative_team);
				  }

			    if( !empty( $_POST['synopsis'] ) )
				  {
					$synopsis = sanitize_textarea_field($_POST['synopsis']);
					update_post_meta(0, 'synopsis', $synopsis);
				  }				  

				$job = null;
				if( !empty( $_POST['job'] ))
				  {
				    $job = filter_var_array( $_POST['job'], FILTER_SANITIZE_STRING, true );
				  }
				  
				$jobString = "";
				$count = 0;  
			  
				if( !empty( $job ) ) 
			      {
					foreach( $job as $check ) 
				    {
				      if( $count == 0 )
					   {
					     $jobString = ( $check );
					   }
				      else
				       {
					     $jobString = ( $jobString . ", " . $check );
					   }
					  
				      $count++;
				    }
			      }			  
			    $_POST['job'] = $jobString; 

				$bookStored = cbms_AvailableBook::isStored( $id );
				if( $bookStored ) 
				  {
				    $book = new cbms_AvailableBook;
				    $book->storeFormValues( $_POST );

					if( isset( $_FILES['bookimage']['name'] ) ) 
					  {
						 $book->storeUploadedImage( $_FILES['bookimage'] );
					  }
					$book->update();
					$_SESSION['status'] = esc_attr( $title ) . " Updated";
				  }
				else
				  {
					$_SESSION['status'] =  "Book Not Found";
				  }		
				cbms_welcome();
			  }
			else
			  {
			  	 $id = absint( $_GET['id'] );
				 $resultsAvailableNow['bookAvailablenow'] = cbms_AvailableBook::getByID( $id );	 
				 if($resultsAvailableNow['bookAvailablenow'] != null)
				   {
				     require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_addavailablebook.php' );	
				   }
				 else
				  {
					cbms_listavailablenow();
				  }
			  }		
		}		
		
		
		/**Delete Book Available Now.*/
		function cbms_deleteavailablebook() {
			$resultsAvailableNow = array();
			$id = absint( $_GET['id'] );
			$resultsAvailableNow['bookAvailablenow'] = cbms_AvailableBook::getByID( $id );
			if($resultsAvailableNow['bookAvailablenow'] != null)	
			  {
				$book = new cbms_AvailableBook;
				$book->storeFormValues( $resultsAvailableNow['bookAvailablenow'] );
				$book->deleteImages(); 
				$book->delete();
				$_SESSION['status'] = "Book Deleted";
			  }
			 else
			  {
				$_SESSION['status'] =  "Book Not Found";
			  }
			
			cbms_welcome();
		}		


		switch($action) 
		{	
		  case 'listall':
			cbms_listall();
			break;
		  case 'addbook':
			cbms_addbook();
			break;	
		  case 'updatebook':
			cbms_updatebook();
			break;	
		  case 'deletebook':
			cbms_deletebook();
			break;					
		  case 'addavailablenow':
			cbms_addavailablenow();
			break;		
		  case 'listavailablenow':
			cbms_listavailablenow();
			break;	
		  case 'updateavailablebook':
			cbms_updateavailablebook();
			break;	
		  case 'deleteavailablebook':
			cbms_deleteavailablebook();
			break;				
		  default:
			cbms_welcome();
		} 	
	
	}
	


	/**Display Books Out This Week - Light*/
	public static function cbms_thisweek() {
		ob_start();
		require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_thisweek.php' );	
		return ob_get_clean(); 
	}

	
	/**Display Books Out Next Week  - Light*/
	public static function cbms_nextweek() {
		ob_start();
		require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_nextweek.php' );	
		return ob_get_clean(); 
	}
	

	/**Display Books Available to Pre-Order  - Light*/
	public static function cbms_preorder() {
		ob_start();
		require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_preorder.php' );	
		return ob_get_clean(); 
	}	
	
	
	/**Display All Books  - Light*/
	public static function cbms_showall() {
		ob_start();
		require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_showall.php' );	
		return ob_get_clean(); 
	}		
	

	/**Display All Available Now Books  - Light*/
	public static function cbms_showallavailable() {
		ob_start();
		require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_showallavailable.php' );	
		return ob_get_clean(); 
	}		


	
}
add_shortcode( 'cbms_thisweek', array( 'ComicBookManagementSystem', 'cbms_thisweek' ) );
add_shortcode( 'cbms_nextweek', array( 'ComicBookManagementSystem', 'cbms_nextweek' ) );
add_shortcode( 'cbms_preorder', array( 'ComicBookManagementSystem', 'cbms_preorder' ) );
add_shortcode( 'cbms_showall', array( 'ComicBookManagementSystem', 'cbms_showall' ) );
add_shortcode( 'cbms_showallavailable', array( 'ComicBookManagementSystem', 'cbms_showallavailable' ) );



global $cbms;
$cbms = new ComicBookManagementSystem();
