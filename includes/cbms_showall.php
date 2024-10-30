<?php
    global $wpdb;
    $table_name = $wpdb->prefix . 'cbms_books';

    $ncbd = date("Y-m-d", strtotime("today"));
        
    $books = $wpdb->get_results( 
        "SELECT * 
        FROM " . $table_name .
        " WHERE releaseDate >= '" . $ncbd ."' ORDER BY releaseDate ASC"
    );
?>
    <div id = "cbms_showall">
        <h2>Upcoming Books</h2>
        <div id = "cbms_showall_slider" class="owl-carousel owl-theme">
<?php                   
            $bookcount = count( $books );
            if( $bookcount > 0 )
              {
                foreach( $books as $book )
                {
                  $id = $book->id; 
                  $diamondcode = $book->diamondcode;
                  $title = $book->title;
                  $job = $book->job;
                  $creative_team = $book->creativeteam;
                  $synopsis = $book->synopsis;                  
                  $date = explode( "-", $book-> releaseDate );  
                  $monthName = date('F', mktime(0, 0, 0, $date[1], 10));         
                  $releasedate = $monthName . " " . $date[2] . ", " . $date[0];   
                  $img = $book->img;
?>
              <div class = "cbms_book">
                    <div class = "cbms_cover_display">
                          <div class = "cbms_img">
                          <?php
                            if(getimagesize(COMIC_BOOK_MANAGEMENT_SYSTEM__COVERS . $id . $img))
                              {
                          ?>
                              <img src = "<?php echo(COMIC_BOOK_MANAGEMENT_SYSTEM__COVERS . $id . $img); ?>" alt = "<?php echo($title); ?>" />
                          <?php
                              }
                            else
                              {
                          ?>
                                <img src = "<?php echo(COMIC_BOOK_MANAGEMENT_SYSTEM__COVERS . $diamondcode . $img); ?>" alt = "<?php echo($title); ?>" />
                          <?php
                              }
                          ?>
                        </div>
                        <div class = "cbms_info">
                            <div class = "cbms_title"><?php echo($title); ?></div>
                            <div class = "cbms_releasedate"><?php echo($releasedate); ?></div>
                            <div class = "cbms_diamondcode">Diamond Code: <?php echo($diamondcode); ?></div>
                            <div class = "cbms_job"><?php echo($job); ?></div>
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
                <div class = "cbms_nobooks">No Upcoming Books Available</div>
<?php             
              }
?>      
    </div>
