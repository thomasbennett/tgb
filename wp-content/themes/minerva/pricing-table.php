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
                            <form action="https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/909216256452592" id="BB_BuyButtonForm" method="post" name="BB_BuyButtonForm" target="_top">
                                <input name="item_name_1" type="hidden" value="<?php the_title(); ?>"/>
                                <input name="item_description_1" type="hidden" value="<?php echo get_the_content(); ?>"/>
                                <input name="item_quantity_1" type="hidden" value="1"/>
                                <input name="item_price_1" type="hidden" value="<?php echo ($product_price * 12)?>"/>
                                <input name="item_currency_1" type="hidden" value="USD"/>
                                <input name="_charset_" type="hidden" value="utf-8"/>
                                <input alt="" src="/wp-content/themes/minerva/images/signup.png" type="image"/>
                            </form>
                          </div>                         
                        </div>
                      </div>
                    </div>

                    <?php endwhile;?>

                    <div style="clear:both;"></div>
                    <p class="small-callout">Because the dramatic variables of a custom website or a monthly maintenance plan, pricing will vary. However, don't hesitate to shoot an <a href="mailto:thomas.g.bennett@gmail.com">email</a> or give a call. Estimates are quick and painless.</p>
                    <p class="italictext"><?php echo $product_desc;?></p>
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>
