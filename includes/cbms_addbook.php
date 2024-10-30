<?php
	require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_header.php' );	
	
	if( isset( $results['formAction'] ) )
	  { 
?>
		<h3>Update Book</h3>
		<form class = "cbms_form" method="POST" enctype="multipart/form-data">
			<input type="hidden" id="id" name="id" value="<?php echo( $results['book']['id']); ?>">
			<div class = "cbms_labels">Diamond Code:</div>
			<input class = "cbms_inputs" type="text" name="diamondcode" placeholder="Not Required" autocomplete="off" value="<?php echo htmlspecialchars( $results['book']['diamondcode'] ); ?>" />
			<br><br>
			<div class = "cbms_labels">Title:</div>
			<textarea class = "cbms_inputs" type="text" name="title" required /><?php echo htmlspecialchars($results['book']['title']); ?></textarea>
			<br><br>
			<div class = "cbms_labels">Job:</div>	
			<div class = "cbms_checkboxes">
<?php
			$jobs = explode(", ", $results['book']['job']);
?>			
				<input type="checkbox" name="job[]" value="writer"
<?php
				   foreach($jobs as $value) 
				   {
				     if($value == "writer")
					   {
?>
						checked 
<?php		   
					   }
				   }		
?>				
				>Writer<br><br>
				<input type="checkbox" name="job[]" value="artist"
<?php
				   foreach($jobs as $value) 
				   {
				     if($value == "artist")
					   {
?>
						checked 
<?php		   
					   }
				   }			
?>					
				>Artist<br><br>
				<input type="checkbox" name="job[]" value="cover"
<?php
				   foreach($jobs as $value) 
				   {
				     if($value == "cover")
					   {
?>
						checked 
<?php		   
					   }
				   }			
?>					
				>Cover<br><br>
				<input type="checkbox" name="job[]" value="variant"
<?php
				   foreach($jobs as $value) 
				   {
				     if($value == "variant")
					   {
?>
						checked 
<?php		   
					   }
				   }			
?>					
				>Variant<br><br>
				<input type="checkbox" name="job[]" value="colorist"
<?php
				   foreach($jobs as $value) 
				   {
				     if($value == "colorist")
					   {
?>
						checked 
<?php		   
					   }
				   }		
?>					
				>Colorist<br><br>
				<input type="checkbox" name="job[]" value="letterer"
<?php
				   foreach($jobs as $value) 
				   {
				     if($value == "letterer")
					   {
?>
						checked 
<?php		   
					   }
				   }	
?>					
				>Letterer<br>
			</div>
			<br><br>
			<div class = "cbms_labels">Creative Team:</div>
			<textarea id = "creative_team" name = "creative_team"><?php echo( $results['book']['creativeteam']); ?></textarea>
			<br><br>
			<div class = "cbms_labels">Solicitation/Synopsis:</div>
			<textarea id = "synopsis" name = "synopsis"><?php echo( $results['book']['synopsis']); ?></textarea>
			<br><br>
			<div class="cbms_labels">Release Date:</div>
			<input  type="date" name="releasedate" id = "releasedate" placeholder="YYYY-MM-DD" required value = "<?php echo htmlspecialchars($results['book']['releasedate']); ?>" />
			<br><br>
			<div class="cbms_labels">Cover Image:</div>
			<div class="cbms_cover_image">
    			<?php
                     if(getimagesize(COMIC_BOOK_MANAGEMENT_SYSTEM__COVERS . $results['book']['id']. $results['book']['img']))
                       {
                ?>
                           <img src="<?php echo COMIC_BOOK_MANAGEMENT_SYSTEM__COVERS . htmlspecialchars( $results['book']['id'] . htmlspecialchars( $results['book']['img'] ) ) ?>" alt="<?php echo htmlspecialchars( $results['book']['title'] )?>" />
                <?php
                        }
                      else
                        {
                ?>
                          <img src="<?php echo COMIC_BOOK_MANAGEMENT_SYSTEM__COVERS . htmlspecialchars( $results['book']['diamondcode'] . htmlspecialchars( $results['book']['img'] ) ) ?>" alt="<?php echo htmlspecialchars( $results['book']['title'] )?>" />
                <?php
                        }
                ?>
				
				<input type="file" name="bookimage" id = "bookimage" placeholder="Choose an image to upload" />
			</div>
			<br><br><br>
			<input type="hidden" name="img" value="<?php echo( $results['book']['img'] ); ?>">
			<input class = "cbms_adminbuttons_input" type="submit" name="updatebook" value="Update Book">
		</form>	
<?php		  
	  }
	else
	  {
?>
		<h3>Add An Upcoming Book</h3>
		<form class = "cbms_form" method="POST" enctype="multipart/form-data">
			<div class = "cbms_labels">Diamond Code:</div>
			<input class = "cbms_inputs" type="text" name="diamondcode" autocomplete="off" />
			<br><br>
			<div class = "cbms_labels">Title:</div>
			<textarea class = "cbms_inputs" type="text" name="title" required /></textarea>
			<br><br>
			<div class = "cbms_labels">Job:</div>	
			<div class = "cbms_checkboxes">
				<input type="checkbox" name="job[]" value="writer">Writer<br><br>
				<input type="checkbox" name="job[]" value="artist">Artist<br><br>
				<input type="checkbox" name="job[]" value="cover">Cover<br><br>
				<input type="checkbox" name="job[]" value="variant">Variant<br><br>
				<input type="checkbox" name="job[]" value="colorist">Colorist<br><br>
				<input type="checkbox" name="job[]" value="letterer">Letterer<br>
			</div>
			<br><br>
			<div class = "cbms_labels">Creative Team:</div>
			<textarea id = "creative_team" name = "creative_team"></textarea>
			<br><br>
			<div class = "cbms_labels">Solicitation/Synopsis:</div>
			<textarea id = "synopsis" name = "synopsis"></textarea>
			<br><br>
			<div class="cbms_labels">Release Date:</div>
			<input  type="date" name="releasedate" id = "releasedate" placeholder="YYYY-MM-DD" />
			<br><br>
			<div class = "cbms_labels">Cover Image:</div>
			<input type="file" name="bookimage" id = "bookimage" placeholder="Choose an image to upload" required />
			<br><br><br>
			<input class = "cbms_adminbuttons_input" type="submit" name="addbook" value="Add Book">
		</form>	
<?php	  
	  }
?> 
		<br>
		<a class = "cbms_adminbuttons" href="<?php COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR ?>?page=comic_book_management_system">Main Menu</a> 		
<?php	
	require( COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR . '/includes/cbms_footer.php' );	
?>	  