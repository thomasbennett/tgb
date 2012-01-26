<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta content="utf-8" />
  <title><?php if (is_home () ) { bloginfo('name'); echo " - "; bloginfo('description'); 
  } elseif (is_category() ) {single_cat_title(); echo " - "; bloginfo('name');
  } elseif (is_single() || is_page() ) {single_post_title(); echo " - "; bloginfo('name');
  } elseif (is_search() ) {bloginfo('name'); echo " search results: "; echo esc_html($s);
  } else { wp_title('',true); }?></title>
  <meta name="robots" content="follow, all" />
  <meta name="keywords" content="affordable web design, best web design, corporate web design, creative web design, dynamic web design, freelance web designer, nashville web design, nashville web designer, nashville web development, nashville web hosting, professional web design, small business web design, web design firms, web design nashville, web design nashville tn, web design pricing, web design rates, web designer, web designer nashville" />
  <meta name="google-site-verification" content="HFav62C1SHzF6PfHmh6pW4yjz4oxzI9FeBzEw42W8tM" />
  <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
  <?php $favico = get_option('minerva_custom_favicon');?>
  <link rel="shortcut icon" href="<?php echo ($favico) ? $favico : get_template_directory_uri().'/images/favicon.ico';?>"/>
  <script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-18232057-1']);
    _gaq.push(['_trackPageview']);

    (function() {
      var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
      ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
      var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
  </script>

  <?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
  <?php wp_head(); ?>

  <?php if (is_home()) { ?>
  <script type="text/javascript"> 
      <?php
        $slideshow_direction = get_option('minerva_slideshow_direction');
        $slideshow_speed  = get_option('minerva_slideshow_speed');
        $slideshow_auto = get_option('minerva_slideshow_auto');
        $slideshow_pager  = get_option('minerva_slideshow_pager');
        $slideshow_controls = get_option('minerva_slideshow_controls');
        $slideshow_loop = get_option('minerva_slideshow_loop');
        $slideshow_hidecontrol = get_option('minerva_slideshow_hidecontrol');
        $slideshow_pause = get_option('minerva_slideshow_pause');
      ?> 
      jQuery(function($) {
        var numImgs = $('#slideshow').find("img").length;
        if (numImgs > 0) {
          $('#slideshow').bxSlider({
            speed: <?php echo ($slideshow_speed) ? $slideshow_speed : "700";?>,
            pause: <?php echo ($slideshow_pause) ? $slideshow_pause : '3000';?>,       
            auto: <?php echo ($slideshow_auto) ? $slideshow_auto : 'true';?>,
            pager: <?php echo ($slideshow_pager) ? $slideshow_pager : 'true';?>,
            controls: <?php echo ($slideshow_controls) ? $slideshow_controls : 'false';?>,
            infiniteLoop: <?php echo ($slideshow_loop) ? $slideshow_loop : 'true';?>,
            mode: '<?php echo ($slideshow_direction) ? $slideshow_direction : "horizontal";?>',
            hideControlOnEnd : <?php echo ($slideshow_hidecontrol) ? $slideshow_hidecontrol : 'false';?>
         });
        }
      });
  </script>
  <?php } ?>
  <script type="text/javascript">
      <?php $twitter_id = get_option('minerva_twitter_id');?>
      //Twitter Jquery	
    jQuery(document).ready(function($) {
      $("#twitter").getTwitter({
        userName: "<?php echo $twitter_id ? $twitter_id : 'tgbeazy';?>",
        numTweets: 1,
        loaderText: "Loading tweets...",
        slideIn: true,
        slideDuration: 750,
        userNameImage: '<img src="<?php echo get_template_directory_uri();?>/images/tweet-footer.png" alt="" />' 
      });
    });
  </script>
</head>

<body <?php body_class($class); ?>>	
	<div id="container">    	
    	<div id="top-container">
        
        	<!-- BEGIN OF HEADER -->
        	<div id="header">
            
            	<div id="left-header">
                	<!-- begin of logo and mainmenu -->
                	<h1 id="logo">
                    <?php $logo = get_option('minerva_logo'); ?>
                    <a href="<?php echo home_url();?>"><img src="<?php echo ($logo) ? $logo : get_template_directory_uri().'/images/logo.jpg';?>" alt=""/></a>                    
                  </h1>
                  <div id="slogan">
                    <?php $site_slogan = get_option('minerva_site_slogan');?>
                    <?php echo $site_slogan ? $site_slogan : "Lorem Ipsum Dolor Amet Consectetur<br/>Adipisicing Elit, Sed Do Eiusmod Tempor";?>
                  </div>
                    <!-- end of logo and mainmenu -->
                </div>
                
                <div id="right-header">
                	<!-- begin of searchbox -->
                	<div id="s-container">
                    	<div id="search-box">
                        <form  method="get" id="search" action="<?php echo home_url();?>/" >
                          <fieldset class="search-fieldset">  
                            <input type="text" name="s" id="s" value="<?php echo __('Begin Searching...','minerva');?>" onblur="if (this.value == ''){this.value = '<?php echo __('Begin Searching...','minerva');?>'; }" onfocus="if (this.value == '<?php echo __('Begin Searching...','minerva');?>') {this.value = ''; }"   />
                            <input type="submit" class="go" value="" />
                          </fieldset>      					                	
                        </form>                      
                      </div>                    	
                    </div>
                    <div id="s-container-right"></div>
                    <!-- end of searchbox -->
                    
                    <!-- begin of mainmenu -->
                    <div id="mainmenu"><?php 
                      if (function_exists('wp_nav_menu')) { 
                        wp_nav_menu( array( 'menu_id'=>'menu','menu_class' => '', 'theme_location' => 'topnav', 'fallback_cb'=>'minerva_topmenu_pages','depth' =>4 ) );
                      } 
                      ?>
                    </div>
                    <!-- end of mainmenu -->
                </div>
                
            </div>
            <!-- END OF HEADER -->
