<?php
/*
Template Name: Blog Template
*/
?>
<?php get_header();?>
            
            <!-- BEGIN OF CONTENT -->
            <div id="content">
            	<div class="maincontent-blog">  
                  <div id="content-left">
                  <?php
                    $blog_cats_include = get_option('minerva_blog_categories');
                    if(is_array($blog_cats_include)) {
                      $blog_include = implode(",",$blog_cats_include);
                    } 
                    
                    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    
                    $blog_order = get_option('minerva_blog_order') ?  get_option('minerva_blog_order')  : "date";
                    $blog_items_num = get_option('minerva_blog_items_num') ? get_option('minerva_blog_items_num') : 5;
                    
                    query_posts(array('cat'=>$blog_include,'posts_per_page'=>$blog_items_num,'orderby'=>$blog_order,'order'=>'DESC','paged'=>$paged));
                    
                    while ( have_posts() ) : the_post();
                  	?>                     	                  
                    <div class="blog-post">
                    	<div class="post-info">
                        	<div class="left-info">
                            <h4 class="minih5"><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                            <span class="post-row"><img src="<?php echo get_template_directory_uri();?>/images/comment-icon.jpg" alt="" class="post-icon" /><?php comments_popup_link(__('0 Comments','onixus'),__('1 Comment','onixus'),__('% Comments','onixus'));?></span>
                            <span class="post-row"><img src="<?php echo get_template_directory_uri();?>/images/category-icon.jpg" alt="" class="post-icon" /><?php the_category(',');?></span>
                          </div>
                          <div class="right-info">
                          	<?php the_time('M'); ?><br/><?php the_time('d'); ?>
                          </div>
                        </div>
                        <div class="post-content  <?php post_class(); ?>" <?php if ( ! isset( $content_width ) ) $content_width = '';?>>
                          <a href="<?php the_permalink(); ?>">
                          <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                            <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=240&amp;w=464&amp;zc=1&amp;a=t" alt="<?php the_title(); ?>" class="light-border" />
                          <?php } else {?>
                            <img src="<?php echo get_template_directory_uri();?>/images/nothumbnail.jpg" alt="No thumbnail displayed." />
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
                  <?php wp_reset_query();?>
                <?php get_sidebar();?>                    
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>
