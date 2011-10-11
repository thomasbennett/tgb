<?php get_header();?>
            
           <!-- BEGIN OF CONTENT -->
            <div id="content-portfolio">
            	<div class="maincontent">
                    
                    <!-- begin of portfolio list -->
                    <div id="portfolio-detail">
                    <?php 
                    while ( have_posts() ) : the_post();
                      $counter++;
                      $pf_link = get_post_meta($post->ID, '_portfolio_link', true );
                      $pf_url = get_post_meta($post->ID, '_portfolio_url', true );
                      ?>            
                      <div class="portfolio-summary">
                        <div class="pf-desc-two">
                        <h5><?php the_title();?></h5>
                          <?php the_excerpt();?>
                        </div>
					              <div class="pf-image-three">
                        	<?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                          <a href="<?php echo ($pf_link) ? $pf_link : thumb_url();?>" rel="prettyPhoto"><img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=209&amp;w=465&amp;zc=1" alt=""/></a>
                          <?php } ?>              
                        </div>
                      </div>
                      <div class="portfolio-text">
					              <div class="pf-detail-text">
                          <?php the_content();?>
                          <a href="<?php echo $pf_url;?>" class="button" onclick="this.blur();"><span><?php echo __('Visit Site','minerva');?></span></a>
                        </div>
                      </div>                      
                      <?php endwhile;?>           
                    </div>
                    <!-- end of portfolio list -->
                
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>