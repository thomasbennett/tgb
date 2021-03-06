<?php
/*
Template Name: Full Width
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
              	<?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                <?php the_content();?>
                <?php endwhile;?>
                <?php endif;?>               
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>