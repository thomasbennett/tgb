<?php

/*-----------------------------------------------------------------------------------*/
/* Options Framework Functions
/*-----------------------------------------------------------------------------------*/

/* Set the file path based on whether the Options Framework is in a parent theme or child theme */

if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('OF_FILEPATH', TEMPLATEPATH);
	define('OF_DIRECTORY', get_template_directory_uri());
} else {
	define('OF_FILEPATH', STYLESHEETPATH);
	define('OF_DIRECTORY', get_stylesheet_directory_uri());
}

/* These files build out the options interface.  Likely won't need to edit these. */

require_once (OF_FILEPATH . '/admin/admin-functions.php');		// Custom functions and plugins
require_once (OF_FILEPATH . '/admin/admin-interface.php');		// Admin Interfaces (options,framework, seo)

/* These files build out the theme specific options and associated functions. */

require_once (OF_FILEPATH . '/admin/theme-options.php'); 		// Options panel settings and custom settings

require_once (OF_FILEPATH . '/functions/theme-functions.php'); 	// Theme actions based on options settings
require_once (OF_FILEPATH . '/functions/metabox.php'); 	
require_once (OF_FILEPATH . '/functions/post-types.php'); 	
require_once (OF_FILEPATH . '/functions/theme-widgets.php'); 	
require_once (OF_FILEPATH . '/functions/shortcodes.php');
require_once (OF_FILEPATH . '/admin/tinymce/shortcodes-generator.php');


// Load static framework options pages 
$functions_path = OF_FILEPATH . '/admin/';

function optionsframework_add_admin() {

    global $query_string;
    
    $themename =  get_option('of_themename');      
    $shortname =  get_option('of_shortname'); 
   
    if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework' ) {
		if (isset($_REQUEST['of_save']) && 'reset' == $_REQUEST['of_save']) {
			$options =  get_option('of_template'); 
			of_reset_options($options,'optionsframework');
			header("Location: admin.php?page=optionsframework&reset=true");
			die;
		}
    }
		
    //$of_page = add_submenu_page('themes.php', $themename, 'Theme Options', 'edit_theme_options', 'optionsframework','optionsframework_options_page'); // Default
    $of_page = add_menu_page($themename." Options", $themename, 'edit_themes', 'optionsframework', 'optionsframework_options_page');
	
	// Add framework functionaily to the head individually
	add_action("admin_print_scripts-$of_page", 'of_load_only');
	add_action("admin_print_styles-$of_page",'of_style_only');
} 

add_action('admin_menu', 'optionsframework_add_admin');

remove_action( 'wp_head', 'feed_links_extra', 3 ); // Display the links to the extra feeds such as category feeds
remove_action( 'wp_head', 'feed_links', 2 ); // Display the links to the general feeds: Post and Comment Feed
remove_action( 'wp_head', 'rsd_link' ); // Display the link to the Really Simple Discovery service endpoint, EditURI link
remove_action( 'wp_head', 'wlwmanifest_link' ); // Display the link to the Windows Live Writer manifest file.
remove_action( 'wp_head', 'index_rel_link' ); // index link
remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 ); // prev link
remove_action( 'wp_head', 'start_post_rel_link', 10, 0 ); // start link
remove_action( 'wp_head', 'adjacent_posts_rel_link', 10, 0 ); // Display relational links for the posts adjacent to the current post.
remove_action( 'wp_head', 'wp_generator' ); // Display the XHTML generator that is generated on the wp_head hook, WP version

remove_filter('the_content', 'wptexturize');
remove_filter('comment_text', 'wptexturize');
?>
