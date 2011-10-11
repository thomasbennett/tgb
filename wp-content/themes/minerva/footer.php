            <!-- BEGIN OF FOOTER -->
            <div id="bottom-container">
            	<div class="footer-container">
                	<div class="footer-top">
                    <?php
                      $quote_text = get_option('minerva_quote_text');
                      $quote_buttontext = get_option('minerva_quote_buttontext');
                      $quote_link = get_option('minerva_quote_link');
                    ?>
                    	<div class="slogan-heading"><h3><?php echo $quote_text ? $quote_text : "Want to buy this theme? Get it only on Themeforest";?></h3></div>
                        <div class="slogan-button">
                        	<a class="button-grey" href="<?php echo $quote_link ? $quote_link : "#";?>" onclick="this.blur();"><span><?php echo $quote_buttontext ? $quote_buttontext : "Buy Now";?></span></a>
                        </div>
                    </div>
                    <!-- fopter content left -->
                    <div class="footer-bottom-left">
                    	<div id="logo-footer">
                      <?php $footer_logo = get_option('minerva_footerlogo');?>
                      <a href="<?php echo home_url();?>"><img src="<?php echo $footer_logo ? $footer_logo : get_template_directory_uri().'/images/footer-logo.png';?>" alt="" /></a></div>
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
                            phone. <?php echo $info_phone ? $info_phone : "777.888.9999";?> / fax. <?php echo $info_fax ? $info_fax : "777.888.5555";?> / <?php echo $info_email ? $info_email : "info@minerva.com";?><br/>
                            <?php echo $footer_text ? $footer_text : "Copyright &copy; 2011 Minerva Company.  All rights reserved";?>
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
