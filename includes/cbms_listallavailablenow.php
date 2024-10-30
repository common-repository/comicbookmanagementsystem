	<?php
	require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_header.php' );	
?>
		<h3>List All Available Now Books</h3>
<?php
		if($resultsAvailableNow['bookAvailablenow'] != null)
		  {
			foreach( $resultsAvailableNow['bookAvailablenow'] as $book ) 
			{
				$jobs[] = explode( ", ", $book-> job );			
?>
				<div class="cbms_list">
					<div class="cbms_list_info">
						<input type="hidden" id="id" name="id" value="<?php echo( $book->id); ?>">
						<span class="cbms_list_header">Diamond Code:</span>
						<span class="cbms_list_information"><?php echo($book->diamondcode); ?></span>
						<br><br>
						<span class="cbms_list_header">Title:</span>
						<span class="cbms_list_information"><?php echo($book->title); ?></span>
						<br><br>
						<span class="cbms_list_header">Job:</span>
						<span class="cbms_list_information"><?php echo( $book-> job ); ?></span>
						<br><br>
						<span class="cbms_list_header">Creative Team:</span>
						<span class="cbms_list_information"><?php echo( nl2br($book-> creative_team )); ?></span>
						<br><br>
						<span class="cbms_list_header">Solicitation/Synopsis:</span>
						<span class="cbms_list_information"><?php echo( nl2br($book-> synopsis )); ?></span>	
						<br>
					</div>
					<div class="cbms_list_img">
						<img src = "<?php echo(COMIC_BOOK_MANAGEMENT_SYSTEM__AVAILABLE_COVERS . $book->id . $book->img); ?>" alt = "<?php echo($book->title); ?>"/>
					</div>

					<a class = "cbms_adminbuttons" href="<?php COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR ?>?page=comic_book_management_system&action=updateavailablebook&amp;id=<?php echo( $book->id );?>">Edit Book</a>
					<br><br>			
					<a class = "cbms_adminbuttons"  href="<?php COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR ?>?page=comic_book_management_system&action=deleteavailablebook&amp;id=<?php echo( $book->id );?>">Delete Book</a>  

				</div>			
<?php		
			}
		}
?>
		<br>
		<a class = "cbms_adminbuttons" href="<?php COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR ?>?page=comic_book_management_system">Main Menu</a> 			
<?php	
	require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_footer.php' );	
?>

