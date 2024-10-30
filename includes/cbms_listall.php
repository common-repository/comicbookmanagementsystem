<?php
	require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_header.php' );	
?>
		<h3>List All Upcoming Books</h3>
<?php
		if($results['book'] != null)
		  {
			foreach( $results['book'] as $book ) 
			{
				$jobs[] = explode( ", ", $book-> job );	
				$releaseDateString = "";
				if( $book-> releasedate != '0000-00-00' )
				  {
					$date = explode( "-", $book-> releasedate );	
					$monthName = date('F', mktime(0, 0, 0, $date[1], 10));
					$releaseDateString = ($monthName . " " . $date[2] . ", " . $date[0]);
				  }
				else
				 {
				 	$releaseDateString = "NO DATE ENTERED";
				 }
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
						<span class="cbms_list_header">Release Date:</span>
						<span class="cbms_list_information"><?php echo( $releaseDateString); ?></span>
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


                          <?php
                            if(getimagesize(COMIC_BOOK_MANAGEMENT_SYSTEM__COVERS . $book->id . $book->img))
                              {
                          ?>
                              <img src = "<?php echo(COMIC_BOOK_MANAGEMENT_SYSTEM__COVERS . $book->id . $book->img); ?>" alt = "<?php echo($book->title); ?>"/>
                          <?php
                              }
                            else
                              {
                          ?>
                                <img src = "<?php echo(COMIC_BOOK_MANAGEMENT_SYSTEM__COVERS . $book->diamondcode . $book->img); ?>" alt = "<?php echo($book->title); ?>"/>
                          <?php
                              }
                          ?>
					</div>
					
					<a class = "cbms_adminbuttons" href="<?php COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR ?>?page=comic_book_management_system&action=updatebook&amp;id=<?php echo( $book->id );?>">Edit Book</a>
					<br><br>			
					<a class = "cbms_adminbuttons"  href="<?php COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR ?>?page=comic_book_management_system&action=deletebook&amp;id=<?php echo( $book->id );?>">Delete Book</a>  

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

