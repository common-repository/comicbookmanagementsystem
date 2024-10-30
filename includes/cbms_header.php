
	<div class = "cbms_header_wrapper">
		<div class = "cbms_logo">
			<img src="<?php echo esc_url(COMIC_BOOK_MANAGEMENT_SYSTEM__PLUGIN_DIR_LOGO); ?>" alt = "Comic Book Management System" />
		</div>
	</div>



	<div class="wrap cbms_adminwrapper">
	<?php
			if( isset( $_SESSION['status'] ) && !empty( $_SESSION['status'] ) )
			  {
	?>
				<br><div class = "status"><?php echo( $_SESSION['status'] );?></div>
	<?php		  
			  }
	?>	

