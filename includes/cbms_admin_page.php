<?php
	require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_header.php' );	
?>
		<div id = "cbms_admin_buttons">	
			<a class = "cbms_admin_buttons" href="<?php COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR ?>?page=comic_book_management_system&action=listall">List All Upcoming Books</a>  
			
			<a class = "cbms_admin_buttons" href="<?php COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR ?>?page=comic_book_management_system&action=addbook">Add An Upcoming Book</a>  
				
			<a class = "cbms_admin_buttons" href="<?php COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR ?>?page=comic_book_management_system&action=listavailablenow">List All Available Now Books</a>  
					
			<a class = "cbms_admin_buttons" href="<?php COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR ?>?page=comic_book_management_system&action=addavailablenow">Add An Available Now Book</a> 
		</div>		
<?php	
	require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_footer.php' );	
?>

