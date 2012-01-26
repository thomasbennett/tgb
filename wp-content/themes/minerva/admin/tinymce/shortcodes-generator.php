<?php

// add shortcode buttons to the tinyMCE editor row 3
function add_button() {
   if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') )
   {
     add_filter('mce_external_plugins', 'add_plugin');
     add_filter('mce_buttons', 'register_button');
   }
}
//setup array of shortcode buttons to add
function register_button($buttons) {
  array_push($buttons, "dropcap");
  array_push($buttons, "pullquote_left");
  array_push($buttons, "pullquote_right");
  array_push($buttons, "tabs");
  array_push($buttons, "toggle"); 
  array_push($buttons, "bulletlist");
  array_push($buttons, "checklist");
  array_push($buttons, "arrowlist");
  array_push($buttons, "image");
  array_push($buttons, "info");
  array_push($buttons, "success");
  array_push($buttons, "warning");
  array_push($buttons, "error");
  array_push($buttons, "button");
  array_push($buttons, "gmap");
  array_push($buttons, "vimeo_video");
  array_push($buttons, "youtube_video");
  array_push($buttons, "col_214");
  array_push($buttons, "col_214_last");
  array_push($buttons, "col_297");
  array_push($buttons, "col_297_last");
  array_push($buttons, "col_461");
  array_push($buttons, "col_461_last");
  array_push($buttons, "col_629");
  array_push($buttons, "col_629_last");
  array_push($buttons, "line");
  array_push($buttons, "shortcodes");
  return $buttons;
}
//setup array for tinyMCE editor interface
function add_plugin($plugin_array) {
   $plugin_array['dropcap'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['pullquote_right'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['pullquote_left'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['tabs'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['toggle'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['bulletlist'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['checklist'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['arrowlist'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['image'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['info'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['success'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['warning'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['error'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['button'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['gmap'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['vimeo_video'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['youtube_video'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['col_214'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['col_214_last'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['col_297'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['col_297_last'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['col_461'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['col_461_last'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['col_629'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['col_629_last'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   $plugin_array['line'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';    
   $plugin_array['shortcodes'] = get_template_directory_uri().'/admin/tinymce/shortcodes.js';
   return $plugin_array;
}
add_action('init', 'add_button'); // add th
?>