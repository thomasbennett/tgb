<!-- BEGIN OF FOOTER -->
            <div id="bottom-container">
            	<div class="footer-container">
                	<div class="footer-top">
                    <h3 class="alignleft">Latest News:</h3>
                    <ul id="news">
                      <?php query_posts('posts_per_page=1') ?>
                      <?php if(have_posts()): while(have_posts()): the_post(); ?>
                        <li class="article">
                          <h4><a class="news-headline" href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                          <span class="entry"><?php the_excerpt(); ?></span>
                        </li>
                      <?php endwhile; endif; ?>
                      <?php wp_reset_query(); ?>
                    </ul>
                    <a href="/blog" class="view-all-news">[view all &raquo;]</a>
                  </div>
                    <!-- fopter content left -->
                    <div class="footer-bottom-left">
                    	<div id="logo-footer">
                        <?php $footer_logo = get_option('minerva_footerlogo');?>
                        <a href="<?php echo home_url();?>"><img src="<?php echo $footer_logo ? $footer_logo : get_template_directory_uri().'/images/footer-logo.png';?>" alt="" /></a>
                      </div>
                    	<div id="address-footer">
                        	<strong><?php bloginfo('blogname');?></strong><br/>
                          <?php
                          $info_address = get_option('minerva_info_address');
                          $info_phone = get_option('minerva_info_phone');
                          $info_fax = get_option('minerva_info_fax');
                          $info_email = get_option('minerva_info_email');
                          $footer_text = get_option('minerva_footer_text');
                          ?>
                          <?php echo $info_address ? $info_address : "15 Kuningan Raya 54th Street 14th / Indonesia,JKT 10220";?><br/>
                          phone. <?php echo $info_phone ? $info_phone : "777.888.9999";?>  / email: <a href="mailto: <?php echo $info_email ?>"><?php echo $info_email ? $info_email : "info@minerva.com";?></a><br/>
                      </div>
                    </div>
                    <!-- fopter content right -->
                    <div class="footer-bottom-right">
                    	<div class="tweet-box">                        	
                            <div id="twitter"></div>
                        </div>                        
                    </div>
                </div>            
            </div>
            <!-- END OF FOOTER -->
        </div>       
    </div>      
  <?php wp_footer();?>     
</body>
</html>