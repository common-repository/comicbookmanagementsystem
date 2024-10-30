<?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'cbms_availablenow';

    $books = $wpdb->get_results( 
        "SELECT * 
        FROM " . $table_name . " ORDER BY title ASC"
    );
?>
    <div id = "cbms_showallavailable">
        <h2>Available Now</h2>
        <div id = "cbms_showallavailable_slider" class="owl-carousel owl-theme">
<?php                   
            $bookcount = count( $books );
            if( $bookcount > 0 )
              {
                foreach( $books as $book )
                {
                  $id = $book->id;
                  $diamondcode = $book->diamondcode;
                  $title = $book->title;
                  $creative_team = $book->creativeteam;
                  $synopsis = $book->synopsis;
                  $job = $book->job;
                  $img = $book->img;
?>
                <div class = "cbms_book">
                    <div class = "cbms_cover_display">
                        <div class = "cbms_img">
                            <img src = "<?php echo(COMIC_BOOK_MANAGEMENT_SYSTEM__AVAILABLE_COVERS . $id . $img); ?>" alt = "<?php echo($title); ?>" />
                        </div>
                        <div class = "cbms_info">
                            <div class = "cbms_title"><?php echo($title); ?></div>
                            <div class = "cbms_job"><?php echo($job); ?></div>

<?php                       
                        if(!$diamondcode == "")
                          {
?>
                            <div class = "cbms_diamondcode">Diamond Code: <?php echo($diamondcode); ?></div>
<?php                         
                          }
?>                            
                        </div>

                <?php
                        if($creative_team != "" || $synopsis != null)
                          {
                ?>       
                            <div class = "cbms_additional_info">
                                <div class = "cbms_additional_info_content">
                                    <strong><?php echo( nl2br( $creative_team ) ); ?></strong>
                                    <br><br>
                                    <p>
                                        <?php echo( nl2br( $synopsis ) ); ?>    
                                    </p>
                                </div>
                            </div>


                <?php
                          }
                ?>       
                    </div>
                </div>
<?php         
                }
              }
?>
        </div>
<?php
            if( $bookcount == 0 )
              {
?>
                <div class = "cbms_nobooks">No Books Listed At This Time</div>
<?php             
              }
?>      
    </div>