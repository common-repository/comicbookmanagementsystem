<?php
/**
 * Plugin Name: ComicBookManagementSystem
 * Plugin URI: https://www.inksplat.ie/wordpress-plugins/comic-book-management-system
 * Description: Allows comic book creators to upload images, diamond codes, release dates and job category for upcoming projects, to make it easier for fans to know what's coming out and when.
 * Version: 4.1
 * Author: Inksplat
 * Author URI: https://www.inksplat.ie
 * License: GPL v2 or later
 * Text Domain: ComicBookManagementSystem
 */

if( ! defined ('ABSPATH' ) ){
	die;
}

if (!defined('CBMS_VERSION'))
    define('CBMS_VERSION', '4.0');


define( 'COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR_LOGO',  plugins_url( 'img/logo.png', __FILE__ ) );
define( 'COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR_ICON',  plugins_url( 'img/icon.png', __FILE__ ) );
define( 'COMIC_BOOK_MANAGEMENT_SYSTEM__COVERS', content_url( 'cbms_Covers/',  __FILE__ ) );
define( 'COMIC_BOOK_MANAGEMENT_SYSTEM__AVAILABLE_COVERS', content_url( 'cbms_CoversNow/',  __FILE__ ) );
require_once( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . 'class.comicbookmanagementsystem.php' );
require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . 'class.book.php' );
require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . 'class.availablebook.php' );
register_activation_hook( __FILE__, 'cbms_activate' );
register_deactivation_hook( __FILE__, 'cbms_deactivate' );


/**Activation.*/
function cbms_activate() {

	global $wpdb;
	global $cbms_db_version;
	$charset_collate = $wpdb->get_charset_collate();
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );

	error_log("Activated");

	if(CBMS_VERSION !== get_option('cbms_plugin_version'))
	  {
		modify_current_cbms_books_table();

     	$table_name = $wpdb->prefix . 'cbms_books';
		$sql = "CREATE TABLE $table_name (
			id INT AUTO_INCREMENT, 
			diamondcode VARCHAR(20),
			title VARCHAR(200) NOT NULL,
			job VARCHAR(200) NOT NULL,
			img VARCHAR(200),
			creativeteam TEXT,
			synopsis TEXT,
			releaseDate date DEFAULT '0000-00-00' NOT NULL,	
			PRIMARY KEY  (id)
		);";

		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'cbms_availablenow';
		$sql = "CREATE TABLE $table_name (
			id INT NOT NULL AUTO_INCREMENT,
			diamondcode VARCHAR(20),
			title VARCHAR(200) NOT NULL,
			job VARCHAR(200) NOT NULL,
			creativeteam TEXT,
			synopsis TEXT,		
			img VARCHAR(200),
			PRIMARY KEY  (id)
		);";

		dbDelta( $sql );
		update_option('cbms_plugin_version', CBMS_VERSION);
	  }
	else
	  {
	  	$table_name = $wpdb->prefix . 'cbms_books';
	  	$sql = "CREATE TABLE $table_name (
			id INT AUTO_INCREMENT, 
			diamondcode VARCHAR(20),
			title VARCHAR(200) NOT NULL,
			job VARCHAR(200) NOT NULL,
			img VARCHAR(200),
			creativeteam TEXT,
			synopsis TEXT,
			releaseDate date DEFAULT '0000-00-00' NOT NULL,	
			PRIMARY KEY  (id)
		) $charset_collate;";

		dbDelta( $sql );

		$table_name = $wpdb->prefix . 'cbms_availablenow';
		$sql = "CREATE TABLE $table_name (
			id INT NOT NULL AUTO_INCREMENT,
			diamondcode VARCHAR(20) NOT NULL,
			title VARCHAR(200) NOT NULL,
			job VARCHAR(200) NOT NULL,
			img VARCHAR(200),
			PRIMARY KEY  (id)
		) $charset_collate;";

		dbDelta( $sql );	

		add_option('cbms_plugin_version', CBMS_VERSION);
	  }
	  
	$file_dir = WP_CONTENT_DIR . '/cbms_Covers/';	
	if( !file_exists( $file_dir ) )
	  {
		 wp_mkdir_p( $file_dir );
	  }  
	  
	$file_dir = WP_CONTENT_DIR . '/cbms_CoversNow/';	
	if( !file_exists( $file_dir ) )
	  {
		 wp_mkdir_p( $file_dir );
	  } 	  
}


/**Deactivation.*/
function cbms_deactivate() {
	
}


/**Update Database Check.*/
function cbms_update_db_check() {

	if (CBMS_VERSION !== get_option('cbms_plugin_version'))
    cbms_activate();
}
add_action( 'plugins_loaded', 'cbms_update_db_check' );




/**Modify Current CBMS Table.*/
function modify_current_cbms_books_table(){
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'cbms_books';	
	$sql = "ALTER TABLE $table_name ADD id INT NOT NULL FIRST";
    $wpdb->query($sql);
	$books = $wpdb->get_results( "SELECT * FROM " . $table_name);
	$id_count = 1;
	if( count($books)> 0 )
	  {
	    foreach ( $books as $book ) 
	    {
	    	$title = $book->title;
			$wpdb->update( $table_name, 
				array( 
					'id' => $id_count,
				), 
				array( 'title' => $title ), 
				array( 
					'%s'	
				), 
				array( '%s' ) 
			);		    	
	      $id_count++;
	    }
	  }

	$sql = "ALTER TABLE $table_name DROP PRIMARY KEY, ADD PRIMARY KEY(id)";
	$wpdb->query($sql);
}



