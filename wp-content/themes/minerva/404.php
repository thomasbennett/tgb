<?php get_header();?>
            
            <!-- BEGIN OF CONTENT -->
            <div id="content">
            	<div class="maincontent-blog"> 
                  <div class="error404-left">
                    	<h1>404</h1>
                        <h2>error message</h2>
                    </div>
                    <div class="error404-right">
                    	<h1>Oops</h1>
                        <h1 class="head-not-found">Page not found</h1>
                        <hr class="content-line" />
                        <p>We're sorry, but we can't find the page you were looking for. It's probably something we've done wrong but now we know about it we'll try to fix it. In the meantime, try returning to the homepage or search for something below.</p>
                        <div id="search-box-404">                        	
                        	 <form  method="get" id="search" action="<?php echo home_url()?>/" >
                            <fieldset class="search-fieldset">
              						  <input type="text" name="s" value="<?php echo __('Search here...','minerva');?>" onblur="if (this.value == ''){this.value = '<?php echo __('Search here...','minerva');?>'; }" onfocus="if (this.value == '<?php echo __('Search here...','minerva');?>') {this.value = ''; }"  class="s-404" />
                            <input type="submit" class="go" value="" />
                            </fieldset>      						
              						</form>                            
                        </div>
                    </div>                  
            	</div>
            </div>
            <!-- END OF CONTENT -->
            
<?php get_footer();?>
