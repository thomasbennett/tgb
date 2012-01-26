<?php
/*
Template Name: Services Alternative
*/
?>

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
            	<div class="maincontent">
                <ul class="serviceslist-alt">
                <?php
                  global $post;
                  
                  $services_page = get_option('minerva_services_pid');
                 	$servicespage = get_page_by_title($services_page);
                 	                   
                  query_posts('page_id='.$servicespage->ID);
                  while (have_posts()) : the_post();
                  the_content();
                  endwhile;
                  wp_reset_query();
                ?>              

                <?php
                  $services_order = get_option('minerva_services_order') ? get_option('minerva_services_order') : "date";
                  
                  query_posts('post_type=page&showposts=-1&post_parent='.$servicespage->ID.'&orderby='.$services_order.'&order=DESC');
                  $counter = 0; 
                  while ( have_posts() ) : the_post();
                  $services_thumbnail = get_post_meta($post->ID,'_page_thumbnail_image',true);
                  $subtitle  = get_post_meta($post->ID,'_subtitle',true);
                  $counter++;
                ?>
                <li <?php if ($counter %2 !=0) echo 'class="last"';?>>
                	<div class="services-item-alt">    
                    <div class="serv-desc-alt">
                    	<h4><?php the_title();?></h4>
                        <?php the_excerpt();?>
                        <div class="serv-button-alt">
                          <a class="button-big" href="<?php the_permalink();?>" onclick="this.blur(); "><span><?php echo __('Take a Tour','minerva');?></span></a>
                          <a class="button-big" href="#" onclick="this.blur();"><span><?php echo __('Sign Up','minerva');?></span></a>
                        </div>
                    </div>                                    
                  </div>
                </li>                                 
              <?php endwhile;?>
              </div>                      
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>