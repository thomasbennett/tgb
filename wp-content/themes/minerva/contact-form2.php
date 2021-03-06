<?php
/*
Template Name: Contact Form Alternative
*/
?>
<?php get_header();?>
<?php
  $info_address = get_option('minerva_info_address') ? get_option('minerva_info_address') : "Enter your addres from theme options";
  $info_latitude = get_option('minerva_info_latitude') ? get_option('minerva_info_latitude') : "-6.229555086277892";
  $info_longitude = get_option('minerva_info_longitude') ? get_option('minerva_info_longitude') : "106.82551860809326";
?>
<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery("#map-alt").gMap({
	    zoom: 15,
	    markers:[{
	    	address: "",
			  latitude: <?php echo $info_latitude;?>,
	    	longitude: <?php echo $info_longitude;?>,
	    	html: "<?php echo $info_address;?>",
	    	popup: true
		}],
		controls: [],
		maptype: G_NORMAL_MAP,
	    scrollwheel:true
	});
});
</script>
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
                    
                    <div class="contact-column1-alt"><!-- contact column1 -->
                      	<?php if (have_posts()) : ?>
                        <?php while (have_posts()) : the_post(); ?> 
                          <?php the_content();?>
                        <?php endwhile;?>
                        <?php endif;?>
                        <div class="success-contact"><img src="<?php get_template_directory_uri();?>/images/success.png" alt="" class="succes-icon" />Your message has been sent successfully. Thank you! </div>
                        <div id="contactFormArea-alt">                                
                            <!-- Contact Form Start //-->
                            <form action="#" id="contactform">
                            <fieldset>
                            <div class="label-form-inline">
                            <label><?php echo __('Name ','minerva');?></label><br />
                            <input type="text" name="name" class="textfield-alt" id="name" value="" /><br />
                            </div>
                            <div class="label-form-inline">
                            <label><?php echo __('Subject ','minerva');?></label><br />
                            <input type="text" name="subject" class="textfield-alt" id="subject" value="" /><br />
                            </div>
                            <div class="label-form-inline">
                            <label><?php echo __('E-mail ','minerva');?></label><br />
                            <input type="text" name="email" class="textfield-alt  field-nomargin" id="email" value="" /><br />
                            </div>  
                            <label><?php echo __('Message ','minerva');?></label><br />
                            <textarea name="message" id="message" class="textarea-alt" cols="2" rows="7"></textarea>
                            <input type="hidden" name="sendto" id="sendto" value="<?php echo (get_option('minerva_info_email')) ? get_option('minerva_info_email') : get_option('admin_email');?>" />
                            <input type="hidden" name="siteurl" id="siteurl" value="<?php echo get_template_directory_uri();?>" />
                            <button type="submit" name="submit" id="buttonsend" class="input-submit"><?php echo __('Send Now','minerva');?></button>                            
                            <span class="loading" style="display: none;"><?php echo __('Please wait..','minerva');?></span>                            
                            <fieldset>
                            </form>
                            <!-- Contact Form End //-->                                      
                        </div>                                	
                    </div>
                    
                    <div class="contact-column2-alt"><!-- contact column2 -->                    	
                       	<div id="map-shadow-alt">
                       		<div id="map-alt"></div>
                       	</div>
                        <div class="social-network-alt">
                        	<h4><?php echo __('Follow Us On','minerva');?></h4>
                          <?php 
                            $facebook_url = get_option('minerva_facebook_url');
                            $twitter_id = get_option('minerva_twitter_id');
                          ?>
                            <ul class="social-list-alt">
                                <li><a href="<?php echo $facebook_url ? $facebook_url : "#";?>"><img src="<?php echo get_template_directory_uri();?>/images/facebook-logo.jpg" alt="" /></a></li>
                                <li><a href="http://twitter.com/<?php echo $twitter_id;?>"><img src="<?php echo get_template_directory_uri();?>/images/twitter-logo.jpg" alt="" /></a></li>
                            </ul>
                        </div>                              	
                    </div>
                
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>