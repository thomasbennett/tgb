<?php
/*
Template Name: About Template
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
                    
                    <div class="about-column1"><!-- about column1 -->
                    	<div class="about-shadow">
                        <?php $about_image = get_option('minerva_about_image');?>
                        <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo $about_image ? $about_image : get_template_directory_uri().'/images/about-img.jpg';?>&amp;h=302&amp;w=233&amp;zc=1" alt="" />
                        </div>	                 
                    </div>
                    
                    <div class="about-column2"><!-- about column2 -->
                    	 <?php if (have_posts()) : ?>
                       <?php while (have_posts()) : the_post();?>
                        <?php the_content();?>
                      <?php endwhile;?>
                      <?php endif;?>
                        	
                    </div>
                
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>