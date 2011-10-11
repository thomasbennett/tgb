<?php get_header();?>
            <!-- BEGIN OF PAGE TITLE -->
            <div id="page-title">
              <?php $page_subtitle = get_post_meta($post->ID,"_page_subtitle",true);?>
              <h3><?php the_title();?></h3>
              <h1><?php echo $page_subtitle;?></h1>
            </div>
            <!-- END OF PAGE TITLE -->
            
            <!-- BEGIN OF CONTENT -->
            <div id="content">
            	<div class="maincontent-blog"> 
                    <div id="content-left">
                      <?php if (have_posts()) : ?>
                      <?php while (have_posts()) : the_post();?>
                        <div class="testi-name"><!-- testimonial 1 -->
                        	<h5><?php the_title();?></h5>
                            <p class="position-testi"></p>
                            <a class="preview" href="<?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?><?php get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=180&amp;w=180&amp;zc=1<?php } ?>">
                              <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                              <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=180&amp;w=180&amp;zc=1" alt="" class="testi-people-img"/>
                              <?php } ?>                                      
                            </a>
                        </div>
                        <div class="testi-box">
                        	<blockquote>
                            <?php echo get_the_content();?>
                            </blockquote>
                        </div>                      
                      <?php endwhile;?>
                      <?php endif;?>
                    </div>
                <?php get_sidebar();?>                    
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>