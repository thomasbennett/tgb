<?php
/*
Template Name: Pricing Table
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
                  	
                  	$product_order = get_option('minerva_product_order') ? get_option('minerva_product_order') : "date";
                    
                    if (post_type_exists('product')) {
                      query_posts(array( 'post_type' => 'product', 'showposts' => $product_num,'orderby'=>$product_order));
                    }
                    $counter = 0; 
                    while ( have_posts() ) : the_post();
                    $counter++;
                    $product_price = get_post_meta($post->ID,'_product_price',true);
                    $product_url = get_post_meta($post->ID,'_product_url',true) ? get_post_meta($post->ID,'_product_url',true) : "#";
                    $product_feature = get_post_meta($post->ID,'_product_feature',true);
                    $features_list = explode(",",$product_feature);
                    $currency = get_option('minerva_currency');
                    $billing_cycle = get_option('minerva_billing_cycle');
                    $product_desc = get_option('minerva_product_desc');
                    
                  ?>                          
                    <div class="pricing-box"><!-- Pricing 1 -->
                    	<h2><?php the_title();?></a></h2>
                      <p class="pricing-desc"><?php echo get_the_content();?></p>
                    	<div class="pricing-inner">
                      	<ul class="pricing-list">
                          <?php foreach ($features_list as $feature_list) { ?>
                          <li><?php echo $feature_list;?></li>
                          <?php } ?>
                        </ul>
                        <div class="pricebutton-group">
                          <div class="price-group">
                            <p class="price-text"><?php echo $currency;?><?php echo $product_price;?></p>
                            <p class="per-text">per <?php if ($billing_cycle == "monthly") echo 'month'; else echo 'year';?></p>
                          </div>
                          <div class="signup-button">
                            <a class="button" href="<?php echo $product_url;?>" onclick="this.blur();"><span><?php echo __("Sign Up",'minerva');?></span></a>
                          </div>                         
                        </div>
                      </div>
                    </div>
                    <?php endwhile;?>
                    <p class="italictext"><?php echo $product_desc;?></p>
                    
                    <div class="client-logo"><!-- Client/Partner Logo -->
                      <?php 
                        $clients_cat = get_option('minerva_clients_cid');
                        $clients_cid = get_cat_ID($clients_cat);
                      ?>
                      <?php if (function_exists('minerva_clientlist')) minerva_clientlist($clients_cid,5,"<h4>Trusted by the web's biggest site</h4>")?>
                    </div>                
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>