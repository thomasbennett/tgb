<?php

/* Add Meta Box for Portfolio */
function minerva_portfolio_meta_boxes() {
  $meta_boxes = array(
    "portfolio_link" => array(
      "name" => "_portfolio_link",
      "title" => "Preview link",
      "description" => "please enter image or video url if you want to create video post.<br/>Images : <br />http://wp-demo.indonez.com/minerva/wp-content/uploads/2010/07/image.jpg<br/> Video : <br />
      http://www.youtube.com/watch?v=tESK9RcyexU<br />
      http://vimeo.com/12816548<br />
      http://wp-demo.indonez.com/minerva/wp-content/uploads/2010/07/sample.3gp<br />
      http://wp-demo.indonez.com/minerva/wp-content/uploads/2010/07/sample.mp4<br />
      http://wp-demo.indonez.com/minerva/wp-content/uploads/2010/07/sample.mov<br />
      http://www.adobe.com/jp/events/cs3_web_edition_tour/swfs/perform.swf?width=680&height=405<br />
      Note : for swf movie, you need to specify the width and height for movie, as above example",
      "type" => "text"
    ),
    "portfolio_url" => array(
      "name" => "_portfolio_url",
      "title" => "Custom URL",
      "description" => "Add link / custom URL for your portfolio items, eg. link to external url.",
      "type" => "text"
    )          
  );
  
  return apply_filters( 'minerva_portfolio_meta_boxes', $meta_boxes );
}


function minerva_page_meta_boxes() {

  $meta_boxes = array(
    "short_desc" => array(
      "name" => "_page_subtitle",
      "title" => __("Sub Title",'minerva'),
      "description" => "Add your page subtitle here.",
      "type" => "text"
    ) 
  );

	return apply_filters( 'minerva_page_meta_boxes', $meta_boxes );
}

function minerva_slideshow_meta_boxes() {

  $meta_boxes = array(
    "subheading" => array(
      "name" => "_subheading",
      "title" => __("Slideshow subtitle",'minerva'),
      "description" => "Subtitle for slideshow.",
      "type" => "text"
    ),  
    "slideshow_url" => array(
      "name" => "_slideshow_url",
      "title" => __("Custom Slideshow Url",'minerva'),
      "description" => "Custonm url for slideshow.",
      "type" => "text"
    ),
    "slideshow_url_text" => array(
      "name" => "_slideshow_url_text",
      "title" => __("Slideshow Text Button",'minerva'),
      "description" => __("Custom text for slideshow button.",'minerva'),
      "type" => "text"
    ),        
    "slideshow_style" => array(
      "name" => "_slideshow_style",
      "title" => __("Slideshow Stage Style",'minerva'),
      "description" => "Please one style of them for each image slideshow.",
      "type" => "select",
      "options" => array("full image","with right description","with left description","with bottom description")
    )        
  );

	return apply_filters( 'minerva_slideshow_meta_boxes', $meta_boxes );
}

function minerva_product_meta_boxes() {

  $meta_boxes = array(
    "product_price" => array(
      "name" => "_product_price",
      "title" => __("Product Price",'minerva'),
      "description" => __("Add price for your product",'minerva'),
      "type" => "text"
    ),  
    "product_feature" => array(
      "name" => "_product_feature",
      "title" => __("Product Features",'minerva'),
      "description" => __("Please enter your product features in comma-separated, eg. feature 1, feature 2",'minerva'),
      "type" => "textarea"
    ),
    "product_url" => array(
      "name" => "_product_url",
      "title" => __("Custom Product Url",'minerva'),
      "description" => __("Please enter your custom url for your product,if not setted then will be linked to actual product page",'minerva'),
      "type" => "text"
    )
  );

	return apply_filters( 'minerva_product_meta_boxes', $meta_boxes );
}

function  portfolio_meta_boxes() {
  global $post;
  $meta_boxes = minerva_portfolio_meta_boxes();
  ?>

  <table class="form-table">
	<?php foreach ( $meta_boxes as $meta ) :

		$value = get_post_meta( $post->ID, $meta['name'], true );

		if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );

	endforeach; ?>
  </table>
  <?php
}


function page_meta_boxes() {
	global $post;
	$meta_boxes = minerva_page_meta_boxes(); ?>

	<table class="form-table">
	<?php foreach ( $meta_boxes as $meta ) :

		$value = stripslashes( get_post_meta( $post->ID, $meta['name'], true ) );

		if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );

	endforeach; ?>
	</table>
<?php
}

function slideshow_meta_boxes() {
	global $post;
	$meta_boxes = minerva_slideshow_meta_boxes(); ?>

	<table class="form-table">
	<?php foreach ( $meta_boxes as $meta ) :

		$value = stripslashes( get_post_meta( $post->ID, $meta['name'], true ) );

		if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );

	endforeach; ?>
	</table>
<?php
}

function product_meta_boxes() {
	global $post;
	$meta_boxes = minerva_product_meta_boxes(); ?>

	<table class="form-table">
	<?php foreach ( $meta_boxes as $meta ) :

		$value = stripslashes( get_post_meta( $post->ID, $meta['name'], true ) );

		if ( $meta['type'] == 'text' )
			get_meta_text_input( $meta, $value );
		elseif ( $meta['type'] == 'textarea' )
			get_meta_textarea( $meta, $value );
		elseif ( $meta['type'] == 'select' )
			get_meta_select( $meta, $value );

	endforeach; ?>
	</table>
<?php
}

function get_meta_text_input( $args = array(), $value = false ) {

	extract( $args ); ?>

	<tr>
		<th style="width:10%;">
			<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
			<input type="text" name="<?php echo $name; ?>" id="<?php echo $name; ?>" value="<?php echo esc_html( $value, 1 ); ?>" size="30" tabindex="30" style="width: 97%;" /><br /><small><?php echo $args['description']; ?></small>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
		</td>
	</tr>
	<?php
}

function get_meta_select( $args = array(), $value = false ) {

	extract( $args ); ?>

	<tr>
		<th style="width:10%;">
			<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
			<select name="<?php echo $name; ?>" id="<?php echo $name; ?>">
			<?php foreach ( $options as $option ) : ?>
				<option <?php if ( htmlentities( $value, ENT_QUOTES ) == $option ) echo ' selected="selected"'; ?>>
					<?php echo $option; ?>
				</option>
			<?php endforeach; ?>
			</select><br /><small><?php echo $args['description']; ?></small>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
		</td>
	</tr>
	<?php
}


function get_meta_textarea( $args = array(), $value = false ) {

	extract( $args ); ?>

	<tr>
		<th style="width:10%;">
			<label for="<?php echo $name; ?>"><?php echo $title; ?></label>
		</th>
		<td>
			<textarea name="<?php echo $name; ?>" id="<?php echo $name; ?>" cols="60" rows="4" tabindex="30" style="width: 97%;"><?php echo esc_html( $value, 1 ); ?></textarea><br /><small><?php echo $args['description']; ?></small>
			<input type="hidden" name="<?php echo $name; ?>_noncename" id="<?php echo $name; ?>_noncename" value="<?php echo wp_create_nonce( plugin_basename( __FILE__ ) ); ?>" />
		</td>
	</tr>
	<?php
}

function minerva_create_meta_box() {
	global $theme_name;

	add_meta_box( 'page-meta-boxes', __('Page options','minerva'), 'page_meta_boxes', 'page', 'normal', 'high' );
	add_meta_box( 'slideshow-meta-boxes', __('Slideshow options','minerva'), 'slideshow_meta_boxes', 'slideshow', 'normal', 'high' );
	add_meta_box( 'portfolio-meta-boxes', __('Portfolio options','minerva'), 'portfolio_meta_boxes', 'portfolio', 'normal', 'high' );
  add_meta_box( 'product-meta-boxes', __('Products options','minerva'), 'product_meta_boxes', 'product', 'normal', 'high' );
}

function minerva_save_meta_data( $post_id ) {
	global $post;

	if ( 'page' == $_POST['post_type'] )
		$meta_boxes = array_merge( minerva_page_meta_boxes() );
  else if ( 'slideshow' == $_POST['post_type'] )
    $meta_boxes = array_merge( minerva_slideshow_meta_boxes() );
  else if ( 'product' == $_POST['post_type'] )
    $meta_boxes = array_merge( minerva_product_meta_boxes() );    
  else
    $meta_boxes = array_merge( minerva_portfolio_meta_boxes() );
  
	foreach ( $meta_boxes as $meta_box ) :

		if ( !wp_verify_nonce( $_POST[$meta_box['name'] . '_noncename'], plugin_basename( __FILE__ ) ) )
			return $post_id;

		if ( 'page' == $_POST['post_type'] && !current_user_can( 'edit_page', $post_id ) )
			return $post_id;

		elseif ( 'slideshow' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
			return $post_id;

		elseif ( 'portfolio' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
      
    elseif ( 'product' == $_POST['post_type'] && !current_user_can( 'edit_post', $post_id ) )
			return $post_id;
      
		$data = stripslashes( $_POST[$meta_box['name']] );

		if ( get_post_meta( $post_id, $meta_box['name'] ) == '' )
			add_post_meta( $post_id, $meta_box['name'], $data, true );

		elseif ( $data != get_post_meta( $post_id, $meta_box['name'], true ) )
			update_post_meta( $post_id, $meta_box['name'], $data );

		elseif ( $data == '' )
			delete_post_meta( $post_id, $meta_box['name'], get_post_meta( $post_id, $meta_box['name'], true ) );

	endforeach;
}



/* Add a new meta box to the admin menu. */
	add_action( 'admin_menu', 'minerva_create_meta_box' );

/* Saves the meta box data. */
	add_action( 'save_post', 'minerva_save_meta_data' );

?>