<?php
/*
Template Name: Contact Form
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
	jQuery("#map").gMap({
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
                    
                    <div class="contact-column1"><!-- contact column1 -->
                    	<?php if (have_posts()) : ?>
                      <?php while (have_posts()) : the_post(); ?> 
                        <?php the_content();?>
                      <?php endwhile;?>
                      <?php endif;?>
                      <div class="success-contact"><img src="<?php get_template_directory_uri();?>/images/success.png" alt="" class="succes-icon" />Your message has been sent successfully. Thank you! </div>
                        <div id="contactFormArea">                                
                            <!-- Contact Form Start //-->                            
                            <form action="#" id="contactform"> 
                              <fieldset>
                                <label><?php echo __('Name ','minerva');?></label><br />
                                <input type="text" name="name" class="textfield" id="name" value="" /><br />
                                <label><?php echo __('Subject ','minerva');?></label><br />
                                <input type="text" name="subject" class="textfield" id="subject" value="" /><br />
                                <label><?php echo __('E-mail ','minerva');?></label><br />
                                <input type="text" name="email" class="textfield" id="email" value="" /><br />  
                                <label><?php echo __('Message ','minerva');?></label><br />
                                <textarea name="message" id="message" class="textarea" cols="2" rows="7"></textarea>
                                <input type="hidden" name="sendto" id="sendto" value="<?php echo (get_option('minerva_info_email')) ? get_option('minerva_info_email') : get_option('admin_email');?>" />
                                <input type="hidden" name="siteurl" id="siteurl" value="<?php echo get_template_directory_uri();?>" />
                                <button type="submit" name="submit" id="buttonsend" class="input-submit"><?php echo __('Send Now','minerva');?></button>                            
                                <span class="loading" style="display: none;"><?php echo __('Please wait..','minerva');?></span>                            
                              </fieldset>
                            </form>
                            <!-- Contact Form End //-->                                      
                        </div>                                	
                    </div>
                    
                    <div class="contact-column2"><!-- contact column2 -->                    	
                       	<div id="map-shadow">
                       		<div id="map">
                             <iframe width="423" height="302" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?hl=en&amp;q=P.O.+Box+128042+Nashville,+TN+37212&amp;ie=UTF8&amp;hq=&amp;hnear=Nashville,+Tennessee+37212&amp;gl=us&amp;t=m&amp;z=13&amp;vpsrc=0&amp;ll=36.128163,-86.796924&amp;output=embed"></iframe> 
                           </div>
                       	</div>
                        <div class="social-network">
                        	<h4><?php echo __('Connect','minerva');?></h4>
                          <?php 
                            $facebook_url = get_option('minerva_facebook_url');
                            $twitter_id = get_option('minerva_twitter_id');
                          ?>
                            <ul class="social-list">
                                <li><a href="<?php echo $facebook_url ? $facebook_url : "#";?>"><img src="<?php echo get_template_directory_uri();?>/images/facebook-logo.jpg" alt="" /></a></li>
                                <li><a href="http://twitter.com/<?php echo $twitter_id;?>"><img src="<?php echo get_template_directory_uri();?>/images/twitter-logo.jpg" alt="" /></a></li>
                            </ul>
                        </div>                              	
                    </div>
                
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>
