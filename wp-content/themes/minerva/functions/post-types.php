<?php
/* Register Custom Post Type for Portfolio */
add_action('init', 'portfolio_post_type_init');
function portfolio_post_type_init() {
  $labels = array(
    'name' => __('Portfolio', 'post type general name','minerva'),
    'singular_name' => __('portfolio', 'post type singular name','minerva'),
    'add_new' => __('Add New', 'portfolio','minerva'),
    'add_new_item' => __('Add New portfolio','minerva'),
    'edit_item' => __('Edit portfolio','minerva'),
    'new_item' => __('New portfolio','minerva'),
    'view_item' => __('View portfolio','minerva'),
    'search_items' => __('Search portfolio','minerva'),
    'not_found' =>  __('No portfolio found','minerva'),
    'not_found_in_trash' => __('No portfolio found in Trash','minerva'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'show_in_nav_menus' => false,
    'menu_position' => 1000,
    'rewrite' => array(
      'slug' => 'portfolio_item',
      'with_front' => FALSE,
    ),         
    'taxonomies' => array('portfolio_category', 'post_tag'),
    'supports' => array(
      'title',
      'editor',
      'author',
      'thumbnail',
      'excerpt',
      'comments',
      'thumbnail',
      'trackbacks',
      'custom-fields',
      'revisions',
      'page-attributes'
    )
  );

  register_post_type('portfolio',$args);

	register_taxonomy_for_object_type('post_tag', 'portfolio');

	register_taxonomy("portfolio_category", 
				    	array("portfolio"), 
				    	array( "hierarchical" => true, 
				    			"label" => __("Portfolio Categories",'minerva'), 
				    			"singular_label" => __("Portfolio Categories",'minerva'), 
				    			"rewrite" => true,
                  "public" => true,
                  "show_ui" => true,                   
                  "show_in_nav_menus" => true,
				    			"query_var" => true
				    		));  
  
}


/* Register Custom Post Type for Slideshow */
add_action('init', 'slideshow_post_type_init');
function slideshow_post_type_init() {
  $labels = array(
    'name' => __('Slideshow', 'post type general name','minerva'),
    'singular_name' => __('slideshow', 'post type singular name','minerva'),
    'add_new' => __('Add New', 'slideshow','minerva'),
    'add_new_item' => __('Add New slideshow','minerva'),
    'edit_item' => __('Edit slideshow','minerva'),
    'new_item' => __('New slideshow','minerva'),
    'view_item' => __('View slideshow','minerva'),
    'search_items' => __('Search slideshow','minerva'),
    'not_found' =>  __('No slideshow found','minerva'),
    'not_found_in_trash' => __('No slideshow found in Trash','minerva'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'rewrite' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'show_in_nav_menus' => false,
    'menu_position' => 1000,
    'supports' => array(
      'title',
      'editor',
      'author',
      'thumbnail',
      'excerpt',
      'comments',
      'thumbnail',
      'trackbacks',
      'custom-fields',
      'revisions'       
    )
  );
  register_post_type('slideshow',$args);
}

/* Register Custom Post Type for Products */
add_action('init', 'products_post_type_init');
function products_post_type_init() {
  $labels = array(
    'name' => __('Product', 'post type general name','minerva'),
    'singular_name' => __('product', 'post type singular name','minerva'),
    'add_new' => __('Add New', 'product','minerva'),
    'add_new_item' => __('Add New product','minerva'),
    'edit_item' => __('Edit product','minerva'),
    'new_item' => __('New product','minerva'),
    'view_item' => __('View product','minerva'),
    'search_items' => __('Search product','minerva'),
    'not_found' =>  __('No product found','minerva'),
    'not_found_in_trash' => __('No product found in Trash','minerva'), 
    'parent_item_colon' => ''
  );
  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'rewrite' => true,
    'query_var' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
    'show_in_nav_menus' => false,
    'menu_position' => 1000,
    'rewrite' => array(
      'slug' => 'product',
      'with_front' => FALSE,
    ),    
    'supports' => array(
      'title',
      'editor',
      'author',
      'thumbnail',
      'excerpt',
      'comments',
      'thumbnail',
      'trackbacks',
      'custom-fields',
      'revisions'       
    )
  );
  register_post_type('product',$args);
}

?>