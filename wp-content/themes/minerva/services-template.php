<?php
/*
Template Name: Services Template
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
                <?php
                  global $post;
                  
                  $services_page = get_option('minerva_services_pid');
                 	$servicespage = get_page_by_title($services_page);
                 	$servicespid = ($post->ID) ? $post->ID: $servicespage->ID;
                                     
                  query_posts('page_id='.$servicespid);
                  while (have_posts()) : the_post();
                  the_content();
                  endwhile;
                ?>              

                <?php
                  $services_order = get_option('minerva_services_order') ? get_option('minerva_services_order') : "date";
                  
                  query_posts('post_type=page&showposts=-1&post_parent='.$servicespid.'&orderby='.$services_order.'&order=DESC');
                  $counter = 0; 
                  while ( have_posts() ) : the_post();
                  $services_thumbnail = get_post_meta($post->ID,'_page_thumbnail_image',true);
                  $subtitle  = get_post_meta($post->ID,'_subtitle',true);
                  $counter++;
                ?>                
                <div class="services-item">
                	<div class="serv-title">
                    	<h4><?php the_title();?></h4>
                    </div>
                    <div class="serv-desc">
                    	<?php the_excerpt();?>
                    </div>
                    <div class="serv-button">
                    	<img src="<?php echo get_template_directory_uri();?>/images/tour-icon.png" alt="" />                            
                        <h4><?php echo __('Take a Tour','miverva');?></h4>
                        <h3><a href="<?php the_permalink();?>"><?php echo __('CLICK HERE','minerva');?></a></h3>                            
                    </div>                    
                </div>    
              <?php endwhile;?>                
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>