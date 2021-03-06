<?php get_header();?>
            
            <!-- BEGIN OF CONTENT -->
            <div id="content">
            	<div class="maincontent-blog">  
                  <div id="content-left">
                  <?php if (have_posts()) :?>
                  <?php while ( have_posts() ) : the_post();?>                     	                  
                    <div class="blog-post">
                    	<div class="post-info">
                      	<div class="left-info">
                          <h4 class="minih5"><?php the_title();?></h4>
                          <span class="post-row"><img src="<?php echo get_template_directory_uri();?>/images/comment-icon.jpg" alt="" class="post-icon" /><?php comments_popup_link(__('0 Comments','onixus'),__('1 Comment','onixus'),__('% Comments','onixus'));?></span>
                          <span class="post-row"><img src="<?php echo get_template_directory_uri();?>/images/category-icon.jpg" alt="" class="post-icon" /><?php the_category(',');?></span>
                        </div>
                        <div class="right-info">
                        	<?php the_time('M'); ?><br/><?php the_time('d'); ?>
                        </div>
                      </div>
                      <div class="post-content">
                        <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                          <?php $alt = get_post_meta($attachment_id, '_wp_attachment_image_alt', true); ?>
                          
                          <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=240&amp;w=464&amp;zc=1&amp;a=t" class="light-border heading-image" alt="<?php the_title(); ?>" />
                        <?php } else {?>
                          <img src="<?php echo get_template_directory_uri();?>/images/nothumbnail.jpg" alt="No image displayed." />
                        <?php } ?>
                        <?php the_content();?>                                
                      </div>
                      <?php $disable_social_bookmark = get_option('minerva_disable_social_bookmark');?>
                      <?php if ($disable_social_bookmark != "true") { ?>
                        <?php if (function_exists('minerva_social_bookmarks')) minerva_social_bookmarks();?>
                      <?php } ?>
                      
                      <!-- Begin of Related Post -->
                      <?php $disable_related_posts = get_option('minerva_disable_related_posts');?>
                      <?php if ($disable_related_posts != "true") { ?>
                        <?php if (function_exists('get_related_post')) get_related_post();?>
                      <?php } ?>
                      <!-- End of Related Post -->   
                      
                      <?php $disable_comment = get_option('minerva_disable_comment');?>
                      <?php if ($disable_comment != "true") { ?>
                        <div id="comment">
                        <?php comments_template('', true);  ?>
                        </div>
                      <?php } ?>
                    </div>
                    <?php endwhile;?>  
                    <?php endif;?>                
                  </div>
                <?php get_sidebar();?>                    
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>
