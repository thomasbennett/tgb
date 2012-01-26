<?php get_header();?>  
            
            <?php if (is_home()) include(TEMPLATEPATH.'/slideshow.php');?>
  
            <!-- BEGIN OF CONTENT -->
            <div id="content">
            	<div class="maincontent-front">
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
                    <div class="column-box"><!-- front box 1 -->
                        <h4><?php echo $homebox_title1 ? stripslashes($homebox_title1) : "Iphone Business Application";?></h4>
                        <p><?php echo $homebox_desc1 ? stripslashes($homebox_desc1) : "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lauda totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo nemo enim";?></p>                        
                        <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo $homebox_image1 ? $homebox_image1 : get_template_directory_uri().'/images/phone1.jpg';?>&amp;h=206&amp;w=116&amp;zc=1" alt="" class="phone-image" />
                        <div class="small-button">
                        	<a class="button" href="<?php echo $homebox_desturl1 ? $homebox_desturl1: "#";?>" onclick="this.blur();"><span><?php echo __('More Info','minerva');?></span></a>
                        </div>
                    </div>
                    
                    <div class="column-box"><!-- front box 2 -->
                        <h4><?php echo $homebox_title2 ? stripslashes($homebox_title2) : "Blackberry Business Application";?></h4>
                        <p><?php echo $homebox_desc2 ? stripslashes($homebox_desc2) : "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lauda totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo nemo enim";?></p>                        
                        <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo $homebox_image2 ? $homebox_image2 : get_template_directory_uri().'/images/phone2.jpg';?>&amp;h=206&amp;w=116&amp;zc=1" alt="" class="phone-image" />
                        <div class="small-button">
                        	<a class="button" href="<?php echo $homebox_desturl2 ? $homebox_desturl2 : "#";?>" onclick="this.blur();"><span><?php echo __('More Info','minerva');?></span></a>
                        </div>
                    </div>
                    
                    <div class="column-box-last"><!-- front box 3 -->
                        <h4><?php echo $homebox_title3 ? stripslashes($homebox_title3) : "Android Business Application";?></h4>
                        <p><?php echo $homebox_desc3 ? stripslashes($homebox_desc3) : "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque lauda totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo nemo enim";?></p>                        
                        <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo $homebox_image3 ? $homebox_image3 : get_template_directory_uri().'/images/phone3.jpg';?>&amp;h=206&amp;w=116&amp;zc=1" alt="" class="phone-image" />
                        <div class="small-button">
                        	<a class="button" href="<?php echo $homebox_desturl3 ? $homebox_desturl3 : "#";?>" onclick="this.blur();"><span><?php echo __('More Info','minerva');?></span></a>
                        </div>
                    </div>
                   
                   <?php/*
                    <div class="front-column1"><!-- front column1 -->
                      <?php
                      $welcome_title = get_option('minerva_welcome_title');
                      $welcome_subtitle = get_option('minerva_welcome_subtitle');
                      $welcome_desc = get_option('minerva_welcome_desc');
                      ?>
                    	<h3><?php echo $welcome_title ? stripslashes($welcome_title) : "Discover Our New Products and Services";?></h3>
                        <p class="sub-heading"><?php echo $welcome_subtitle ? stripslashes($welcome_subtitle) : "At vero eos et accusamus et iusto odio dignissimos ducimus qui blanditiis";?></p>
                        <p><?php echo $welcome_desc ? stripslashes($welcome_desc) : "Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo commodi consequatur Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet consectetur, adipisci velit sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem, uteli enim ad minima veniam quis nostrum exercitationem ullam corporis.";?></p>                    
                    </div>
                    
                    <div class="front-column2"><!-- front column2 -->
                    <?php 
                    $middle_rightcontent = get_option('minerva_middle_rightcontent');
                    if ($middle_rightcontent)  {
                      echo do_shortcode($middle_rightcontent); 
                    } else { 
                      echo do_shortcode('
                      [tabs]
                        [tab title="Tab no. 1"]
                          [image source="'.get_template_directory_uri().'/images/ipad.jpg" alt="" align="left"]
                          <p>At vero eos accusamus et iusto odio dignissi ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas</p>
                          <ul class="arrow">
                              <li>sed quia numquam eius modi tempora</li>
                              <li>architecto beatae vitae dicta explicabo</li>
                              <li>nemo enim ipsam voluptatem voluptas </li>                            
                          </ul>                        
                        [/tab]
                        [tab title="Tab no. 2"]
                          [image source="'.get_template_directory_uri().'/images/ipad.jpg" alt="" align="left"]
                          <p>At vero eos accusamus et iusto odio dignissi ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas</p>
                          <ul class="arrow">
                              <li>sed quia numquam eius modi tempora</li>
                              <li>architecto beatae vitae dicta explicabo</li>
                              <li>nemo enim ipsam voluptatem voluptas </li>                            
                          </ul>                          
                        [/tab]
                        [tab title="Tab no. 3"]
                          [image source="'.get_template_directory_uri().'/images/ipad.jpg" alt="" align="left"]
                          <p>At vero eos accusamus et iusto odio dignissi ducimus qui blanditiis praesentium voluptatum deleniti atque corrupti quos dolores et quas</p>
                          <ul class="arrow">
                              <li>sed quia numquam eius modi tempora</li>
                              <li>architecto beatae vitae dicta explicabo</li>
                              <li>nemo enim ipsam voluptatem voluptas </li>                            
                          </ul>                          
                        [/tab]                      
                      [/tabs]
                      ');
                      } ?>
                    </div>
               */?> 
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>
