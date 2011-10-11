<?php get_header();?>
            
            <!-- BEGIN OF CONTENT -->
            <div id="content">
            	<div class="maincontent-blog">  
                  <div id="content-left">
                  <?php
                    while ( have_posts() ) : the_post();
                  	?>                     	                  
                    <div class="blog-post">
                    	<div class="post-info">
                        	<div class="left-info">
                            <span class="post-row"><img src="<?php echo get_template_directory_uri();?>/images/author-icon.jpg" alt="" class="post-icon" /><?php the_author_posts_link();?></span>
                            <span class="post-row"><img src="<?php echo get_template_directory_uri();?>/images/comment-icon.jpg" alt="" class="post-icon" /><?php comments_popup_link(__('0 Comment','onixus'),__('1 Comment','onixus'),__('% Comments','onixus'));?></span>
                            <?php if (has_tag()) { ?>
                              <span class="post-row"><img src="<?php echo get_template_directory_uri();?>/images/tag.png" alt="" class="post-icon" /><?php the_tags();?></span>
                            <?php } ?>
                          </div>
                          <div class="right-info">
                          	<?php the_time('M'); ?><br/><?php the_time('d'); ?>
                          </div>
                        </div>
                        <div class="post-content">
                          <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                            <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=142&amp;w=464&amp;zc=1" alt="" />
                          <?php } else {?>
                            <img src="<?php echo get_template_directory_uri();?>/images/nothumbnail.jpg" alt="" />
                          <?php } ?>
                          <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
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