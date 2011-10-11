            <!-- BEGIN OF SLIDESHOW -->
            <!-- BEGIN OF SLIDESHOW -->
            <div id="slideshow-container">
            	<div id="slideshow-roundabout">
                <div class="roundabout">
                  <ul>
                    <?php
                    global $post;
                    
                    $slideshow_order = get_option('minerva_slideshow_order');
                    
                    query_posts(array( 'post_type' => 'slideshow', 'showposts' => -1,'orderby'=>$slideshow_order,'order'=>'ASC'));
                    
                    while (have_posts()) : the_post();
                                        
                    ?>
                      <li>
                        <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                          <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=307&amp;w=600&amp;zc=1" alt="" />                          
                        <?php } ?>                        
                      </li>        
                    <?php endwhile;?>                   
                    </ul> 
                </div>     
              </div>                
            </div>
            <!-- END OF SLIDESHOW -->