<?php
/*
Template Name: Portfolio 4 Cols
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
            <div id="content-portfolio">
            	<div class="maincontent">          
                    
                    <!-- begin of portfolio filter -->
                    <ul id="portfolio-filter">
                      <li><a class="button" href="#all" onclick="this.blur(); return false;"><span>All Category</span></a></li>
                      <?php  
                        $categories = get_categories('taxonomy=portfolio_category&orderby=ID&title_li=&hide_empty=0');
                        foreach ($categories as $category) {
                          $cat_slug = str_replace("-","",$category->slug);
                          echo '<li><a href="#'.$cat_slug.'" class="button" onclick="this.blur(); return false;"><span>'.$category->name.'</span></a></li>';
                        }
                        ?>                        
                    </ul>
                    <!-- end of portfolio filter -->
                    
                    <!-- begin of portfolio list -->
                    <ul id="portfolio-list-four">
                    <?php 
                    $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                    $portfolio_items_num  = (get_option('minerva_portfolio_items_num')) ? get_option('minerva_portfolio_items_num') : 4; 
                    $portfolio_order = (get_option('minerva_portfolio_order')) ? get_option('minerva_portfolio_order') : "date";
                    
                    query_posts(array( 'post_type' => 'portfolio', 'showposts' => -1,'paged'=>$page,'orderby'=>$portfolio_order));
                    while ( have_posts() ) : the_post();
                      $counter++;
                      $pf_link = get_post_meta($post->ID, '_portfolio_link', true );
                      $pf_url = get_post_meta($post->ID, '_portfolio_url', true );
                      $portfolio_type = get_post_meta($post->ID, '_portfolio_type', true );
                      $myterms = get_the_terms($post->ID,'portfolio_category');
                      foreach ($myterms as $myterm) {
                        $cat_slug = str_replace("-","",$myterm->slug);
                      }
                      ?>            
                      <li class="<?php echo $cat_slug;?>">
                        <div class="pf-desc-four">
                        <h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
                          <?php the_excerpt();?>
                        </div>
					              <div class="pf-image-four">
                        	<?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                          <a href="<?php echo ($pf_link) ? $pf_link : thumb_url();?>" rel="prettyPhoto"><img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=209&amp;w=217&amp;zc=1" alt=""/></a>
                          <?php } ?>              
                        </div>
                      </li>
                      <?php endwhile;?>           
                    </ul>
                    <!-- end of portfolio list -->
                
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>
