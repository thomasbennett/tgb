<?php get_header();?>
            <!-- BEGIN OF PAGE TITLE -->
            <div id="page-title">
              <h3><?php echo __('Search','minerva');?></h3>
              <h1><?php echo __("Search Result for ",'minerva') .'"'.$s.'"';?></h1>
            </div>
            <!-- END OF PAGE TITLE -->
                        
            <!-- BEGIN OF CONTENT -->
            <div id="content">
            	<div class="maincontent-blog">  
                  <div id="content-left">
                  <?php
                    while ( have_posts() ) : the_post();
                  	?>                     
                      <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                        <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=116&amp;w=135&amp;zc=1" alt="" class="imgleft" />
                      <?php } else {?>
                        <img src="<?php echo get_template_directory_uri();?>/images/nothumbnail2.jpg" alt="" class="imgleft"/>
                      <?php } ?>
                      <h4><a href="<?php the_permalink();?>"><?php the_title();?></a></h4>
                      <?php the_excerpt();?>
                      <div class="clear"></div>
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