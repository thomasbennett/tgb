<?php get_header();?>
            
            <!-- BEGIN OF CONTENT -->
            <div id="content">
            	<div class="maincontent">
                  	<ul class="client-list">
                    <?php
                      while ( have_posts() ) : the_post();
                    ?>
                		  <li>
                      <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                        <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=60&amp;w=172&amp;zc=1" alt=""/>
                      <?php } ?>          
                      </li>
                    <?php endwhile;?>    
                    </ul>	                   
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>