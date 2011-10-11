<?php get_header();?>
            
            <!-- BEGIN OF CONTENT -->
            <div id="content">
            	<div class="maincontent">
                  <ul class="team-list-full">
                  <?php
                    $counter = 0;
                    while ( have_posts() ) : the_post();
                    $counter++;
                    ?>
                    <li>
                    <?php
                    if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {
                      ?>
                      <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=186&amp;w=159&amp;zc=1" alt="" />
                      <?php
                    } 
                    ?>
                    <strong><?php the_title();?></strong>
                    <?php the_content();?>
                    </li>                    
                    <?php endwhile;?>   
                    </ul>                                 
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>