            <!-- BEGIN OF SLIDESHOW -->
            <div id="slideshow-container">
            	<div id="slideshow-holder" >
                	<ul id="slideshow">
                    <?php
                    global $post;
                    
                    $slideshow_order = get_option('minerva_slideshow_order');
                    
                    query_posts(array( 'post_type' => 'slideshow', 'showposts' => -1,'orderby'=>$slideshow_order,'order'=>'ASC'));
                    
                    while (have_posts()) : the_post();
                    
                    $slideshow_url = get_post_meta($post->ID,"_slideshow_url",true) ? get_post_meta($post->ID,"_slideshow_url",true) : get_permalink();
                    $slideshow_url_text = get_post_meta($post->ID,"_slideshow_url_text",true) ? get_post_meta($post->ID,"_slideshow_url_text",true) : __("Read More",'minerva');
                    $slideshow_style = get_post_meta($post->ID,"_slideshow_style",true);
                    $subheading = get_post_meta($post->ID,"_subheading",true);
                                        
                    ?>
                    <?php if ($slideshow_style == "with right description") { ?>
                        <li class="slide-type1">
                            <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                              <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=308&amp;w=435&amp;zc=1" alt="" />                          
                            <?php } ?>                        
                            <h1><?php the_title();?></h1>
                            <h3><?php echo $subheading;?></h3>
                            <?php the_content();?>
                            <div class="big-button">
                            	<a class="button-big" href="<?php echo $slideshow_url;?>" onclick="this.blur();"><span><?php echo $slideshow_url_text;?></span></a>
                            </div>
                        </li>
                        <?php } else if ($slideshow_style == "with left description") { ?>
                        <li class="slide-type2">
                            <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                              <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=380&amp;w=381&amp;zc=1" alt="" />                          
                            <?php } ?>
                            <h1><?php the_title();?></h1>
                            <h3><?php echo $subheading;?></h3>
                            <?php the_content();?>
                            <div class="big-button2">
                                <a class="button-big" href="<?php echo $slideshow_url;?>" onclick="this.blur();"><span><?php echo $slideshow_url_text;?></span></a>
                            </div>
                        </li>
                        <?php } else if ($slideshow_style == "full image") { ?>
                        <li class="slide-type3">
                            <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                              <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=355&amp;w=832&amp;zc=1" alt="" />                          
                            <?php } ?>                            
                        </li>
                        <?php } else { ?>
                        <li class="slide-type4">
                        	  <h1><?php the_title();?></h1>
                            <h1 class="slide-big"><?php echo $subheading;?></h1>
                            <?php the_content();?>
                            <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
                              <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=123&amp;w=585&amp;zc=1" alt="" />                          
                            <?php } ?>
                            <div class="clr"></div>                            
                        </li>
                        <?php } ?>  
                      <?php endwhile;?>
                      <?php wp_reset_query();?>                           
                    </ul>      
                </div>                
            </div>
            <!-- END OF SLIDESHOW -->