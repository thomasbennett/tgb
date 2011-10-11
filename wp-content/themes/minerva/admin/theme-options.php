<?php

add_action('init','of_options');

if (!function_exists('of_options')) {
function of_options(){
	
// VARIABLES
$themename = get_theme_data(STYLESHEETPATH . '/style.css');
$themename = $themename['Name'];
$shortname = "minerva";

// Populate OptionsFramework option in array for use in theme
global $of_options;
$of_options = get_option('of_options');

$GLOBALS['template_path'] = OF_DIRECTORY;

//Access the WordPress Categories via an Array
$of_categories = array();  
$of_categories_obj = get_categories('hide_empty=0');
foreach ($of_categories_obj as $of_cat) {
  $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
}    
//$categories_tmp = array_unshift($of_categories, "Select a category:");    

//Access the WordPress Pages via an Array
$of_pages = array();
$of_pages_obj = get_pages('parent=0');
foreach ($of_pages_obj as $of_page) {
  $of_pages[$of_page->ID] = $of_page->post_title; 
}
//$of_pages_tmp = array_unshift($of_pages, "Select a page:");       

// Image Alignment radio box
$options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 

// Image Links to Options
$options_image_link_to = array("image" => "The Image","post" => "The Post"); 

//Testing 
$options_select = array("one","two","three","four","five"); 
$options_radio = array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five"); 

//Stylesheets Reader
$alt_stylesheet_path = OF_FILEPATH . '/styles/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if(stristr($alt_stylesheet_file, ".css") !== false) {
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}

/* Get Cufon fonts into a drop-down list */
$cufonts = array();
if(is_dir(TEMPLATEPATH . "/js/fonts/")) {
	if($open_dirs = opendir(TEMPLATEPATH . "/js/fonts")) {
		while(($cufontfonts = readdir($open_dirs)) !== false) {
			if(stristr($cufontfonts, ".js") !== false) {
				$cufonts[] = $cufontfonts;
			}
		}
	}
}
$cufonts_dropdown = $cufonts;

//More Options
$uploads_arr = wp_upload_dir();
$all_uploads_path = $uploads_arr['path'];
$all_uploads = get_option('of_uploads');
$other_entries = array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
$body_repeat = array("no-repeat","repeat-x","repeat-y","repeat");
$body_pos = array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");

$slide_effects = array("random","fold","fade","sliceDown","sliceDownLeft","sliceUp","sliceUpLeft","sliceUpDown","sliceUpDownLeft");
// Set the Options Array
$options = array();

$options[] = array( "name" => "General Settings",
                    "icon" => "general",
                    "type" => "heading");

$options[] = array( "type" => "info",
                    "std" => "General settings for your site that will be used in general pages");

$options[] = array( "name" => "Main Logo",
					"desc" => "Upload you main site logo, recommended size is 79x93px",
					"id" => $shortname."_logo",
					"std" => "",
					"type" => "upload");

$options[] = array( "name" => "Footer Logo",
					"desc" => "Upload your footer here, recommended size is 79x91px",
					"id" => $shortname."_footerlogo",
					"std" => "",
					"type" => "upload");
          
$options[] = array( "name" => "Custom Favicon",
					"desc" => "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
					"id" => $shortname."_custom_favicon",
					"std" => "",
					"type" => "upload"); 

$options[] = array( "type" => "info",
                    "std" => "Quote Text");
					
$options[] = array( "name" => "Quote Text",
					"desc" => "Enter your quote text here",
					"id" => $shortname."_quote_text",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Quote Button Text ",
					"desc" => "Enter your text for quote button here",
					"id" => $shortname."_quote_buttontext",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Quote Custon URL",
					"desc" => "Enter custom URL for quote button",
					"id" => $shortname."_quote_link",
					"std" => "",
					"type" => "text");	 

$options[] = array( "type" => "info",
                    "std" => "Tracking Code");
					
$options[] = array( "name" => "Tracking Code",
					"desc" => "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
					"id" => $shortname."_ga_code",
					"std" => "",
					"type" => "textarea");                       

$options[] = array( "type" => "info",
                    "std" => "404 Text");
                                  
$options[] = array( "name" => "404 Text",
					"desc" => "Enter your 404 (Page Not Found) Text here.",
					"id" => $shortname."_404_text",
					"std" => "",
					"type" => "textarea");         

$options[] = array( "type" => "info",
                    "std" => "Footer Text (Site Copyright)");
                    
$options[] = array( "name" => "Footer Text",
					"desc" => "Enter your site copyright here.",
					"id" => $shortname."_footer_text",
					"std" => "",
					"type" => "textarea");                                                

$options[] = array( "name" => "Pages &amp; Categories",
                    "icon" => "page_cat",
                    "type" => "heading");
                              
$options[] = array( "name" => "Your About page",
					"desc" => "Select your about page.",
					"id" => $shortname."_about_pid",
					"std" => "",
					"type" => "select",
					"options" => $of_pages);
          
$options[] = array( "name" => "Image for About Page Sidebar",
					"desc" => "Upload your image for about page sidebar, recommended size 223x302px, if you have a bigger size, image will be resized automatically",
					"id" => $shortname."_about_image",
					"std" => "",
					"type" => "upload");
          
$options[] = array( "name" => "Your Contact page",
					"desc" => "Select your contact page.",
					"id" => $shortname."_contact_pid",
					"std" => "",
					"type" => "select",
					"options" => $of_pages);

$options[] = array( "name" => "Your Services page",
					"desc" => "Select your Services page.",
					"id" => $shortname."_services_pid",
					"std" => "",
					"type" => "select",
					"options" => $of_pages);
          
$options[] = array( "name" => "Services page Order",
					"desc" => "Select your order parameter for your services page tems.",
					"id" => $shortname."_services_order",
					"std" => "",
					"type" => "select",
					"options" => array("author","date","title","modified","menu_order","parent","ID","rand"));				                                                    

$options[] = array( "name" => "Your Testimonial Category",
					"desc" => "Select your Testimonial category.",
					"id" => $shortname."_testimonial_cid",
					"std" => "",
					"type" => "select",
					"options" => $of_categories);

$options[] = array( "name" => "Your Clients Category",
					"desc" => "Select your Clients category.",
					"id" => $shortname."_clients_cid",
					"std" => "",
					"type" => "select",
					"options" => $of_categories);
          					          
$options[] = array( "name" => "Homepage Settings",
                    "icon" => "homepage",
                    "type" => "heading");

$options[] = array( "type" => "info",
                    "std" => "Site Slogan setting for your site");
                    
$options[] = array( "name" => "Site Slogan",
					"desc" => "Enter your brief site slogan here",
					"id" => $shortname."_site_slogan",
					"std" => "",
					"type" => "textarea");
					       
$options[] = array( "type" => "info",
                    "std" => "3 columns Site features for homepage");
                    
$options[] = array( "name" => "Title for Homepage features box #1",
					"desc" => "Enter your title for homepage features box #1",
					"id" => $shortname."_homebox_title1",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Custom URL for Homepage features box #1",
					"desc" => "Enter your custom URL for homepage features box #1",
					"id" => $shortname."_homebox_desturl1",
					"std" => "",
					"type" => "text"); 
					
$options[] = array( "name" => "Icon for Homepage features box #1",
					"desc" => "Upload your icon for homepage features box #1, recommended size 116x206px, if you have a bigger size, image will be resized automatically",
					"id" => $shortname."_homebox_image1",
					"std" => "",
					"type" => "upload");
              
$options[] = array( "name" => "Short Description for Homepage features box #1",
					"desc" => "Enter your brief short description for homepage features box #1",
					"id" => $shortname."_homebox_desc1",
					"std" => "",
					"type" => "textarea");  

$options[] = array( "name" => "Title for Homepage features box #2",
					"desc" => "Enter your title for homepage features box #2",
					"id" => $shortname."_homebox_title2",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Custom URL for Homepage features box #2",
					"desc" => "Enter your custom URL for homepage features box #2",
					"id" => $shortname."_homebox_desturl2",
					"std" => "",
					"type" => "text"); 
					
$options[] = array( "name" => "Icon for Homepage features box #2",
					"desc" => "Upload your icon for homepage features box #2, recommended size 116x206px, if you have a bigger size, image will be resized automatically",
					"id" => $shortname."_homebox_image2",
					"std" => "",
					"type" => "upload");
              
$options[] = array( "name" => "Short Description for Homepage features box #2",
					"desc" => "Enter your brief short description for homepage features box #2",
					"id" => $shortname."_homebox_desc2",
					"std" => "",
					"type" => "textarea");  
                 
$options[] = array( "name" => "Title for Homepage features box #3",
					"desc" => "Enter your title for homepage features box #3",
					"id" => $shortname."_homebox_title3",
					"std" => "",
					"type" => "text");
					
$options[] = array( "name" => "Custom URL for Homepage features box #3",
					"desc" => "Enter your custom URL for homepage features box #3",
					"id" => $shortname."_homebox_desturl3",
					"std" => "",
					"type" => "text"); 
					
$options[] = array( "name" => "Icon for Homepage features box #3",
					"desc" => "Upload your icon for homepage features box #3, recommended size 116x206px, if you have a bigger size, image will be resized automatically",
					"id" => $shortname."_homebox_image3",
					"std" => "",
					"type" => "upload");
              
$options[] = array( "name" => "Short Description for Homepage features box #3",
					"desc" => "Enter your brief short description for homepage features box #3",
					"id" => $shortname."_homebox_desc3",
					"std" => "",
					"type" => "textarea");  
          
$options[] = array( "type" => "info",
                    "std" => "Welcome Message Section");
					
$options[] = array( "name" => "Welcome Title",
					"desc" => "Enter your welcome title here",
					"id" => $shortname."_welcome_title",
					"std" => "",
					"type" => "text");

$options[] = array( "name" => "Welcome Subtitle",
					"desc" => "Enter your welcome subtitle here",
					"id" => $shortname."_welcome_subtitle",
					"std" => "",
					"type" => "text");
          
$options[] = array( "name" => "Description",
					"desc" => "Enter your short brief description here",
					"id" => $shortname."_welcome_desc",
					"std" => "",
					"type" => "textarea");

$options[] = array( "type" => "info",
                    "std" => "Middle Right Content");
          
$options[] = array( "name" => "Midde Right Content",
					"desc" => "Enter your content here, you can use tabs shortcode in your content, eg.<br />
                    [tabs]<br />
                    [tab title='title 1'] contents 1[/tab]<br /> 
                    [tab title='title 2'] contents 2[/tab] <br />
                    [/tabs]          
                    ",
					"id" => $shortname."_middle_rightcontent",
					"std" => "",
					"type" => "textarea");

$options[] = array( "type" => "info",
                    "std" => "Homepage Alternative Content");
          
$options[] = array( "name" => "Homepage Alternative Content",
					"desc" => "Enter your content here, you can use Toggle shortcode in your content, eg.<br />
                    [toglle title='your title here']
                       your content here
                    [/toggle]
                    <br />
                    [toglle title='your title here']
                       your content here
                    [/toggle]
                    <br />
                    [toglle title='your title here']
                       your content here
                    [/toggle]        
                    ",
					"id" => $shortname."_alt_content",
					"std" => "",
					"type" => "textarea");

$options[] = array( "name" => "Additional Image #1 for Homepage Alternative Content",
					"desc" => "Upload your icon/image for Homepage Alternative Content, recommended size 203x63px, if you have a bigger size, image will be resized automatically",
					"id" => $shortname."_alt_addimage1",
					"std" => "",
					"type" => "upload");

$options[] = array( "name" => "Additional Image #2 for Homepage Alternative Content",
					"desc" => "Upload your icon/image for Homepage Alternative Content, recommended size 203x63px, if you have a bigger size, image will be resized automatically",
					"id" => $shortname."_alt_addimage2",
					"std" => "",
					"type" => "upload");
                    		
$options[] = array( "name" => "Slideshow Setting",
                    "icon" => "slideshow",
                    "type" => "heading");
                    
$options[] = array( "name" => "Slideshow Items Order",
					"desc" => "Select your order parameter for slideshow items.",
					"id" => $shortname."_slideshow_order",
					"std" => "",
					"type" => "select",
					"options" => array("author","date","title","modified","menu_order","parent","ID","rand"));				                                                    
                                         					

$options[] = array( "type" => "info",
                    "std" => "Main Slideshow Settings");

$options[] = array( "name" => "Slide Direction",
					"desc" => "Please choose slide direction for the slideshow",
					"id" => $shortname."_slideshow_direction",
					"std" => "horizontal",
					"type" => "select",
					"options" => array("horizontal","vertical","fade"));
					
$options[] = array( "name" => "Slide Speed",
					"desc" => "Please enter your slideshow speed, eg. 700",
					"id" => $shortname."_slideshow_speed",
					"std" => "700",
					"type" => "text");					
					
$options[] = array( "name" => "Slide Pause",
					"desc" => "The duration between each slide transition",
					"id" => $shortname."_slideshow_pause",
					"std" => "3000",
					"type" => "text");		
          					
$options[] = array( "name" => "Automatic slide",
					"desc" => "Make slideshow change automatically?",
					"id" => $shortname."_slideshow_auto",
					"std" => "true",
					"type" => "select",
					"options" => array("true","false"));
                    
$options[] = array( "name" => "Slide Pager",
					"desc" => "Display a pager in your slidehsow?",
					"id" => $shortname."_slideshow_pager",
					"std" => "true",
					"type" => "select",
					"options" => array("true","false"));
                              					
$options[] = array( "name" => "Slide controls",
					"desc" => "Display previous and next controls in your slidehsow?",
					"id" => $shortname."_slideshow_controls",
					"std" => "true",
					"type" => "select",
					"options" => array("true","false"));
					
$options[] = array( "name" => "Slide Infinite Loop",
					"desc" => "Display first slide after last?",
					"id" => $shortname."_slideshow_loop",
					"std" => "true",
					"type" => "select",
					"options" => array("true","false"));

$options[] = array( "name" => "Hide slide control",
					"desc" => "if true, will hide 'next' control on last slide and 'prev' control on first",
					"id" => $shortname."_slideshow_hidecontrol",
					"std" => "true",
					"type" => "select",
					"options" => array("true","false"));	    

$options[] = array( "type" => "info",
                    "std" => "Roundabout Slider Settings");
          
$options[]	= array(	"name" => "Slide speed",
    			"desc" => "Please enter transation speed (in milliseconds).",
    			"id" => $shortname."_roundabout_speed",
    			"type" => "text");					

$options[] = array( "name" => "Portfolio Options",
          "icon" => "portfolio",
					"type" => "heading");

$options[] = array( "name" => "Your portfolio page",
					"desc" => "Select your portfolio page.",
					"id" => $shortname."_portfolio_page",
					"std" => "",
					"type" => "select",
					"options" => $of_pages);
          
$options[] = array( "name" => "Portfolio Items Order",
					"desc" => "Select your order parameter for portfolio items.",
					"id" => $shortname."_portfolio_order",
					"std" => "",
					"type" => "select",
					"options" => array("author","date","title","modified","menu_order","parent","ID","rand"));				                                                    

$options[] = array( "name" => "Products Options",
          "icon" => "product",
					"type" => "heading"); 	   

$options[] = array( "name" => "Currency Sign",
					"desc" => "Please enter your currency sign here, you can add your currency html special character, for detail please visit <a href='http://webdesign.about.com/od/localization/l/blhtmlcodes-cur.htm'>http://webdesign.about.com/od/localization/l/blhtmlcodes-cur.htm</a> in Numerical Code column",
					"id" => $shortname."_currency",
					"std" => "&#36;",
					"type" => "text");

$options[] = array( "name" => "Billing Cycle",
					"desc" => "Please enter your billig cycle",
					"id" => $shortname."_billing_cycle",
					"std" => "monthly",
					"type" => "select",
          "options" => array("monthly","yearly")
          );
                    
$options[] = array( "name" => "Product page description",
					"desc" => "Please enter your description about your product here, will be displayed in product page.",
					"id" => $shortname."_product_desc",
					"std" => "",
					"type" => "textarea");

$options[] = array( "name" => "Product Items Order",
					"desc" => "Select your order parameter for portfolio items.",
					"id" => $shortname."_product_order",
					"std" => "",
					"type" => "select",
					"options" => array("author","date","title","modified","menu_order","parent","ID","rand"));				                                                    
          
$options[] = array( "name" => "Blog Options",
          "icon" => "blog",
					"type" => "heading"); 	   

$options[] = array( "name" => "Your Blog page",
					"desc" => "Select your Services page.",
					"id" => $shortname."_blog_page",
					"std" => "",
					"type" => "select",
					"options" => $of_pages);
          
$options[] = array( "name" => "Blog Categories",
					"desc" => "Please check the categories that you want to include in Blog page.",
					"id" => $shortname."_blog_categories",
					"std" => "",
					"type" => "multicheck",
					"options" => $of_categories);				  
					
$options[] = array( "name" => "Blog Items Order",
					"desc" => "Select your order parameter for blog items.",
					"id" => $shortname."_blog_order",
					"std" => "",
					"type" => "select",
					"options" => array("author","date","title","modified","menu_order","parent","ID","rand"));				                                                    
                                         
$options[] = array( "name" => "Number items to display per page",
					"desc" => "Please enter your number to display your Blog items per page.",
					"id" => $shortname."_blog_items_num",
					"std" => "",
					"type" => "text");					
					
$options[] = array( "name" => "Disable Social Bookmark?",
					"desc" => "Please check this option if you want to hide social bookmark in actual post.",
					"id" => $shortname."_disable_social_bookmark",
					"std" => "false",
					"type" => "checkbox");			

$options[] = array( "name" => "Disable Related Posts?",
					"desc" => "Please check this option if you want to hide related posts in actual post.",
					"id" => $shortname."_disable_related_posts",
					"std" => "false",
					"type" => "checkbox");			
          
$options[] = array( "name" => "Disable Posts Comment?",
					"desc" => "Please check this option if you want to hide posts comment section in actual post.",
					"id" => $shortname."_disable_comment",
					"std" => "false",
					"type" => "checkbox");	
                                                                                                      
$options[] = array( "name" => "Styling Options",
          "icon" => "styling",
					"type" => "heading");

$options[] = array( "name" => "Cufon Font",
					"desc" => "Select your default cufon font.",
					"id" => $shortname."_cufon_fonts",
					"std" => "",
					"type" => "select",
					"options" => $cufonts);
          
$options[] = array( "name" => "Body Text Typograpy",
					"desc" => "Please set this option if you want to use your custom styling for body text paragraph",
					"id" => $shortname."_custom_body_text",
					"std" => array('size' => '12','unit' => 'px','face' => 'Tahoma, Arial, verdana','color' => '#868686'),
					"type" => "typography");
					
$options[] = array( "name" => "Custom CSS",
          "desc" => "Quickly add some CSS to your theme by adding it to this block.",
          "id" => $shortname."_custom_css",
          "std" => "",
          "type" => "textarea");
          
$options[] = array( "name" => "Contact Info",
          "icon" => "contact",
					"type" => "heading");      

$options[] = array( "name" => "Google Map API Key",
					"desc" => "Please add your google map API key here, if you dont have one, you can signup at <a href='http://code.google.com/intl/en-US/apis/maps/signup.html'>http://code.google.com/intl/en-US/apis/maps/signup.html</a>",
					"id" => $shortname."_google_map_key",
					"std" => "",
					"type" => "textarea");
          
$options[] = 	array(	"name" => "Latitude",
			"desc" => "Enter your latitude here, for quick search your latitude, please visit <a href='http://universimmedia.pagesperso-orange.fr/geo/loc.htm'>http://universimmedia.pagesperso-orange.fr/geo/loc.htm</a>",
			"id" => $shortname."_info_latitude",
			"type" => "text");

$options[] = 	array(	"name" => "Longitude",
			"desc" => "Enter your longitude here, for quick search your longitude, <a href='http://universimmedia.pagesperso-orange.fr/geo/loc.htm'>http://universimmedia.pagesperso-orange.fr/geo/loc.htm</a>",
			"id" => $shortname."_info_longitude",
			"type" => "text");
      
$options[] = array( "name" => "Your main office addess",
					"desc" => "Please add your main office address here.",
					"id" => $shortname."_info_address",
					"std" => "",
					"type" => "textarea");    

$options[] = array( "name" => "Phone nubmer",
					"desc" => "Please add your phone number here.",
					"id" => $shortname."_info_phone",
					"std" => "",
					"type" => "text");    

$options[] = array( "name" => "FAX nubmer",
					"desc" => "Please add your FAX number here.",
					"id" => $shortname."_info_fax",
					"std" => "",
					"type" => "text");   
          
$options[] = array( "name" => "E-mail Address",
					"desc" => "Please add your e-mail address here.",
					"id" => $shortname."_info_email",
					"std" => "",
					"type" => "text");
        			
$options[] = 	array(	"name" => "Sucess Message",
			"desc" => "Please enter the success message for contact form when email successfully sent.",
			"id" => $shortname."_success_msg",
			"type" => "textarea");
      
$options[] = array( "type" => "info",
            "std" => "Social Links Profile");                      

$options[] = array( "name" => "Twitter",
					"desc" => "Please add your Twitter ID here.",
					"id" => $shortname."_twitter_id",
					"std" => "",
					"type" => "text");           
$options[] = array( "name" => "Facebook Profile URL",
					"desc" => "Please enter your facebook profile url here.",
					"id" => $shortname."_facebook_url",
					"std" => "",
					"type" => "text");           
                    
update_option('of_template',$options); 					  
update_option('of_themename',$themename);   
update_option('of_shortname',$shortname);

}
}
?>
