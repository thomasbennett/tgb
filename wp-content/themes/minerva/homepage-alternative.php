<?php
/*
Template Name: Homepage Alternative
*/
?>
<?php get_header();?>  
<script type="text/javascript">
<?php $roundabout_speed = get_option('minerva_roundabout_speed');?>
jQuery(document).ready(function($) {
		//Roundabout Slider Jquery 
  	   jQuery('.roundabout ul').roundabout({
  	      shape: 'square',
          minOpacity: 0.8,
          minScale: 0.5,
          duration: <?php echo $roundabout_speed ? $roundabout_speed : "1200";?>
  	   }).hover(
			function() {
			clearInterval(interval);},
			function() {
			interval = startAutoPlay();}
			);				
			
			interval = startAutoPlay();
    	});     

		function startAutoPlay() {
			return setInterval(function() {
				jQuery('.roundabout ul').roundabout_animateToNextChild();
			}, 6000);
		}
</script>

            <?php include(TEMPLATEPATH.'/slideshow-alternative.php');?>
            
            <!-- BEGIN OF CONTENT -->
            <div id="content">
            	<div class="maincontent">
                  <?php
                  	 $homebox_title1 = get_option('minerva_homebox_title1');
                  	 $homebox_desc1 = get_option('minerva_homebox_desc1');
                  	 $homebox_image1 = get_option('minerva_homebox_image1');
                  	 $homebox_desturl1 = get_option('minerva_homebox_desturl1');
                  	 $homebox_title2 = get_option('minerva_homebox_title2');
                  	 $homebox_desc2 = get_option('minerva_homebox_desc2');
                  	 $homebox_image2 = get_option('minerva_homebox_image2');
                  	 $homebox_desturl2 = get_option('minerva_homebox_desturl2');
                  	 $homebox_title3 = get_option('minerva_homebox_title3');
                  	 $homebox_desc3 = get_option('minerva_homebox_desc3');
                  	 $homebox_image3 = get_option('minerva_homebox_image3');
                  	 $homebox_desturl3 = get_option('minerva_homebox_desturl3');
                  	?>                  
                     <div class="front-column1-alt"><!-- front column1 -->
                      <?php
                      $welcome_title = get_option('minerva_welcome_title');
                      $welcome_subtitle = get_option('minerva_welcome_subtitle');
                      $welcome_desc = get_option('minerva_welcome_desc');
                      ?>                     
                    	<h3><?php echo $welcome_title ? stripslashes($welcome_title) : "Welcome to Minerva, The Home of Solutions";?></h3>
                        <p class="sub-heading-alt"><?php echo $welcome_subtitle ? stripslashes($welcome_subtitle) : "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis";?></p>
                        <?php if ($welcome_desc) echo stripslashes($welcome_desc); else echo  
                        do_shortcode('[image source="http://localhost/minerva/wp-content/uploads/2011/04/ipad.jpg" align="left"]').'
                        <p>At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores quas molestias excepturi sint occaec cupiditate non provident similique sunt in culpa qui officia dita distinctio </p>
                        <p>Nam libero tempore, cum soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere possimus, omnis voluptas assumenda est, omnis dolor repellendus. Temporibus autem quibusdam et aut officiis debitis autero rerum necessitatibus saepe eveniet ut et voluptates repudiandae sint et molestiae non recusandae earum rerum hic tenetur sapiente delectus ut aut reiciendis maiores alias</p>
                        ';?>
                        
                        <div class="sub-front-column1"><!-- sub-front column1 -->
                          <?php $alt_content = get_option('minerva_alt_content');?>
                        	<!-- begin of FAQ 1 -->
                          <?php 
                            if ($alt_content !="") {
                              echo do_shortcode($alt_content); 
                            } else {
                              echo do_shortcode('
                              [toggle title="Sed ut perspiciatis unde omnis iste natus errorris"]
                                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam.
                              [/toggle]
                              [toggle title="Consectetur adipisicing elit sed do eiusmod"]
                                [checklist]
                                <ul>
                                  <li>Quis autem iure reprehenderit voluptate molestiae</li>
                                  <li>Et harum quidem rerum facilis est et expedita distinctio</li>
                                  <li>Temporibus autem quibusdam et aut officiis debitis</li>
                                </ul>
                                [/checklist]
                              [/toggle]
                              [toggle title="Accusamus etorus iusto odio dignissimos ducimus"]
                                <h5>Sample Heading on Box</h5>
                                At vero eos et accusamus et iusto odio dignissimos ducimus qui facilis blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi sint occaecati cupiditate non provident, similique sunt in culpa qui offici deserunt mollitia animi idest laborum et dolorum fuga eta harum quidem rerum.
                              [/toggle]
                            ');
                            }
                          ?>                                 
                        </div>
                        
                        <div class="sub-front-column2"><!-- sub-front column2 -->
                          <?php
                            $alt_addimage1 = get_option('minerva_alt_addimage1');
                            $alt_addimage2 = get_option('minerva_alt_addimage2');
                          ?>
                        	<img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo $alt_addimage1 ? $alt_addimage1 : get_template_directory_uri().'/images/store-button1.jpg';?>&amp;h=63&amp;w=203&amp;zc=1" alt="" class="store-button" />
                          <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo $alt_addimage1 ? $alt_addimage1 : get_template_directory_uri().'/images/store-button2.jpg';?>&amp;h=63&amp;w=203&amp;zc=1" alt="" class="store-button" />
                        </div>
                                            
                    </div>
                    
                    <div class="side-box"><!-- side box1 -->
                    	<img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo $homebox_image1 ? $homebox_image1 : get_template_directory_uri().'/images/side-icon1.jpg';?>&amp;h=71&amp;w=80&amp;zc=1" alt="" class="imgleft" />
                        <h4><?php echo $homebox_title1 ? stripslashes($homebox_title1) : "Cloud Server Technology";?></h4>
                        <p><?php echo $homebox_desc1 ? stripslashes($homebox_desc1) : "Sed ut perspiciatis undelure omnis iste natus error sit voluptate accusantium doloremque lauda totam rem aperiam";?></p>
                    </div>
                    <div class="side-box"><!-- side box2 -->
                    	<img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo $homebox_image2 ? $homebox_image2 : get_template_directory_uri().'/images/side-icon2.jpg';?>&amp;h=71&amp;w=80&amp;zc=1" alt="" class="imgleft" />
                        <h4><?php echo $homebox_title2 ? stripslashes($homebox_title2) : "24 Hours Monitoring";?></h4>
                        <p><?php echo $homebox_desc2 ? stripslashes($homebox_desc2) : "Sed ut perspiciatis undelure omnis iste natus error sit voluptate accusantium doloremque lauda totam rem aperiam";?></p>
                    </div>
                    <div class="side-box"><!-- side box3 -->
                    	<img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo $homebox_image3 ? $homebox_image3 : get_template_directory_uri().'/images/side-icon1.jpg';?>&amp;h=71&amp;w=80&amp;zc=1" alt="" class="imgleft" />
                        <h4><?php echo $homebox_title3 ? stripslashes($homebox_title3) : "Email Notification";?></h4>
                        <p><?php echo $homebox_desc3 ? stripslashes($homebox_desc3) : "Sed ut perspiciatis undelure omnis iste natus error sit voluptate accusantium doloremque lauda totam rem aperiam";?></p>
                    </div>  
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>