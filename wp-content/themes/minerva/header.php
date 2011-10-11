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
<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<?php $favico = get_option('minerva_custom_favicon');?>
<link rel="shortcut icon" href="<?php echo ($favico) ? $favico : get_template_directory_uri().'/images/favicon.ico';?>"/>
<?php if ( is_singular() ) wp_enqueue_script( 'comment-reply' ); ?>
<?php wp_head(); ?>

<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/cufon-yui.js"></script>
<?php $cufon_font = get_option('minerva_cufon_font'); if ($cufon_font == "") $cufon_font = "Vegur_400.font.js";?>
<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/fonts/<?php echo $cufon_font;?>"></script>
<script type="text/javascript">
            Cufon.replace('h1') ('h2') ('h3') ('h4') ('h5') ('h6') ('#mainmenu') ('ul.tabs li a') 			
			 ('.slogan-heading', {hover:true, textShadow:'0px 1px 0px #f4f4f4'})
			 ('.slide-type1 h1', {hover:true, textShadow:'0px 1px 0px #f4f4f4'})
			 ('.slide-type1 h3', {hover:true, textShadow:'0px 1px 0px #f4f4f4'})
			 ('.slide-type2 h1', {hover:true, textShadow:'0px 1px 0px #f4f4f4'})
			 ('.slide-type2 h3', {hover:true, textShadow:'0px 1px 0px #f4f4f4'})
			 ('.slide-type4 h1', {hover:true, textShadow:'0px 1px 0px #f4f4f4'})
			 ('h1.slide-big', {hover:true, textShadow:'0px 1px 0px #f4f4f4'})			 
			 ('.button', {hover:true,	textShadow:'0px 1px 0px #f0d698'})
			 ('.button-big', {hover:true,	textShadow:'0px 1px 0px #f0d698'})
			 ('.button-grey', {hover:true,	textShadow:'0px 1px 0px #ffffff'})
       ('.right-info')
			;
</script>
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
    jQuery(document).ready(function($) {
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
			userName: "<?php echo $twitter_id ? $twitter_id : 'Indoneztheme';?>",
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
                	<div id="logo">
                    <?php $logo = get_option('minerva_logo'); ?>
                    <a href="<?php echo home_url();?>"><img src="<?php echo ($logo) ? $logo : get_template_directory_uri().'/images/logo.jpg';?>" alt=""/></a>                    
                  </div>
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
                            <input type="text" name="s" id="s" value="<?php echo __('Begin Search','minerva');?>" onblur="if (this.value == ''){this.value = '<?php echo __('Search here...','minerva');?>'; }" onfocus="if (this.value == '<?php echo __('Search here...','minerva');?>') {this.value = ''; }"   />
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
            
