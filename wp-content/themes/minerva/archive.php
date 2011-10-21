<?php get_header();?>
            
            <!-- BEGIN OF CONTENT -->
            <div id="content">
            	<div class="maincontent-blog">  
                  <div id="content-left">
                    <h2><?php the_category(); ?></h2>
                  <?php
                    while ( have_posts() ) : the_post();
                  	?>                     	                  
                    <div class="blog-post">
                    	<div class="post-info">
                        	<div class="left-info">
                            <h4 class="minih5"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                            <span class="post-row"><img src="<?php echo get_template_directory_uri();?>/images/author-icon.jpg" alt="" class="post-icon" /><?php the_author_posts_link();?></span>
                            <span class="post-row"><img src="<?php echo get_template_directory_uri();?>/images/comment-icon.jpg" alt="" class="post-icon" /><?php comments_popup_link(__('0 Comments','onixus'),__('1 Comment','onixus'),__('% Comments','onixus'));?></span>
                          </div>
                          <div class="right-info">
                          	<?php the_time('M'); ?><br/><?php the_time('d'); ?>
                          </div>
                        </div>
                        <div class="post-content">
                          <a href="<?php the_permalink(); ?>">
                          <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                            <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=240&amp;w=464&amp;zc=1&amp;a=t" alt="<?php the_title() ?>" class="light-border" />
                          <?php } else {?>
                            <img src="<?php echo get_template_directory_uri();?>/images/nothumbnail.jpg" alt="" />
                          <?php } ?>
                          </a>
                          <?php the_excerpt();?>                                
                        </div>
                    </div>
                    <?php endwhile;?>     
                    <div class="clear"></div>
                    <?php 
                    if (function_exists("wpapi_pagination")) {
                      wpapi_pagination($additional_loop->max_num_pages);
                    } else {
                      ?>
                      <div class="page-navigation">
                  			<div class="alignleft"><?php next_posts_link(__('&laquo; Previous Entries','vulcan')) ?></div>
                  			<div class="alignright"><?php previous_posts_link(__('Next Entries &raquo;','vulcan')) ?></div>
                  			<div class="clr"></div>
                  		</div>
                      <?php                      
                    }
                    ?>            
                  </div>
                <?php get_sidebar();?>                    
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>
