<?php

/* List Styles */
function minerva_checklist( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="checklist">', do_shortcode($content));
	return remove_wpautop($content);
	
}
add_shortcode('checklist', 'minerva_checklist');

function minerva_bulletlist( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="circle">', do_shortcode($content));
	return remove_wpautop($content);
	
}
add_shortcode('bulletlist', 'minerva_bulletlist');

function minerva_arrowlist( $atts, $content = null ) {
	$content = str_replace('<ul>', '<ul class="arrow">', do_shortcode($content));
	return remove_wpautop($content);
	
}
add_shortcode('arrowlist', 'minerva_arrowlist');

/* Messages Box */

function minerva_warningbox( $atts, $content = null ) {
   return '<div class="warning">' . do_shortcode($content) . '</div>';
}
add_shortcode('warning', 'minerva_warningbox');


function minerva_infobox( $atts, $content = null ) {
   return '<div class="info">' . do_shortcode($content) . '</div>';
}
add_shortcode('info', 'minerva_infobox');

function minerva_successbox( $atts, $content = null ) {
   return '<div class="success">' . do_shortcode($content) . '</div>';
}
add_shortcode('success', 'minerva_successbox');

function minerva_errorbox( $atts, $content = null ) {
   return '<div class="error">' . do_shortcode($content) . '</div>';
}
add_shortcode('error', 'minerva_errorbox');

//************************************* Pullquotes

function minerva_pullquote_right( $atts, $content = null ) {
   return '<span class="pullquote_right">' . do_shortcode($content) . '</span>';
}
add_shortcode('pullquote_right', 'minerva_pullquote_right');


function minerva_pullquote_left( $atts, $content = null ) {
   return '<span class="pullquote_left">' . do_shortcode($content) . '</span>';
}
add_shortcode('pullquote_left', 'minerva_pullquote_left');

function minerva_italic_text( $atts, $content = null ) {
   return '<p class="italictext">' . do_shortcode($content) . '</p>';
}
add_shortcode('italic_text', 'minerva_italic_text');


/* Dropcap */
function minerva_drop_cap( $atts, $content = null ) {
   return '<span class="dropcap">' . do_shortcode($content) . '</span>';
}
add_shortcode('dropcap', 'minerva_drop_cap');

/* Line Divider */
function minerva_linedivider( $atts, $content = null ) {
   return '<hr>';
}
add_shortcode('line', 'minerva_linedivider');

/* ======================================
   Buttons 
   ======================================*/
function minerva_button( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'link'      => '#',
    ), $atts));

	$out = "<a class=\"button\" href=\"" .$link. "\"><span>" .do_shortcode($content). "</span></a>";
    
    return $out;
}
add_shortcode('button', 'minerva_button');

/*  Columns */
function minerva_col_133( $atts, $content = null ) {
   return '<div class="col_133">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_133', 'minerva_col_133');

function minerva_col_133_last( $atts, $content = null ) {
   return '<div class="col_133_last">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_133_last', 'minerva_col_133_last');

function minerva_col_238( $atts, $content = null ) {
   return '<div class="col_238">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_238', 'minerva_col_238');

function minerva_col_238_last( $atts, $content = null ) {
   return '<div class="col_238_last">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_238_last', 'minerva_col_238_last');

function minerva_col_210( $atts, $content = null ) {
   return '<div class="col_210">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_210', 'minerva_col_210');

function minerva_col_210_last( $atts, $content = null ) {
   return '<div class="col_210_last">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_210_last', 'minerva_col_210_last');

function minerva_col_214( $atts, $content = null ) {
   return '<div class="col-214">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_214', 'minerva_col_214');

function minerva_col_214_last( $atts, $content = null ) {
   return '<div class="col-214-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_214_last', 'minerva_col_214_last');

function minerva_col_297( $atts, $content = null ) {
   return '<div class="col-297">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_297', 'minerva_col_297');

function minerva_col_297_last( $atts, $content = null ) {
   return '<div class="col-297-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_297_last', 'minerva_col_297_last');

function minerva_col_461( $atts, $content = null ) {
   return '<div class="col-461">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_461', 'minerva_col_461');

function minerva_col_461_last( $atts, $content = null ) {
   return '<div class="col-461-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_461_last', 'minerva_col_461_last');

function minerva_col_629( $atts, $content = null ) {
   return '<div class="col-629">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_629', 'minerva_col_629');

function minerva_col_629_last( $atts, $content = null ) {
   return '<div class="col-629-last">' . do_shortcode($content) . '</div>';
}
add_shortcode('col_629_last', 'minerva_col_629_last');

#### Vimeo eg http://vimeo.com/5363880 id="5363880"
function vimeo_code($atts,$content = null){

	extract(shortcode_atts(array(  
		"id" 		=> '',
		"width"		=> $width, 
		"height" 	=> $height
	), $atts)); 
	 
  $width = ($width) ? $width : 620;
  $height = ($height) ? $height : 345;
  	 
	$data = "<object width='$width' height='$height' data='http://vimeo.com/moogaloop.swf?clip_id=$id&amp;server=vimeo.com' type='application/x-shockwave-flash'>
    <param name='allowfullscreen' value='true' />
			<param name='allowscriptaccess' value='always' />
			<param name='wmode' value='opaque'>
			<param name='movie' value='http://vimeo.com/moogaloop.swf?clip_id=$id&amp;server=vimeo.com' />
		</object>";
	return $data;
} 
add_shortcode("vimeo_video", "vimeo_code"); 

#### YouTube eg http://www.youtube.com/v/MWYi4_COZMU&hl=en&fs=1& id="MWYi4_COZMU&hl=en&fs=1&"
function youTube_code($atts,$content = null){

	extract(shortcode_atts(array(  
      "id" 		=> '',
  		"width"		=> $width, 
  		"height" 	=> $height
		 ), $atts)); 
  
  $width = ($width) ? $width : 620;
  $height = ($height) ? $height : 345;

	$data = "<object width='$width' height='$height' data='http://www.youtube.com/v/$id' type='application/x-shockwave-flash'>
			<param name='allowfullscreen' value='true' />
			<param name='allowscriptaccess' value='always' />
			<param name='FlashVars' value='playerMode=embedded' />
			<param name='wmode' value='opaque'>
			<param name='movie' value='http://www.youtube.com/v/$id' />
		</object>";
	return $data;
} 
add_shortcode("youtube_video", "youTube_code");

/* Images */
function minerva_imgalignment( $atts, $content = null ) {
    extract(shortcode_atts(array(
        'source'      => '#',
        'align' => $align
    ), $atts));
  
  switch ($align) {
    case "left" :
      $class="imgleft";
    break;
    case "right" :
      $class="imgright";
    break;
    case "center" :
      $class="imgcenter";
    break;
  }
  
	$out = "<img class=\"".$class."\" src=\"" .$source. "\" alt=\"\">";
    
  return $out;
}
add_shortcode('image', 'minerva_imgalignment');

/* Tabs and Accordiaon */
function theme_shortcode_tabs($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'style' => false
	), $atts));
	
	if (!preg_match_all("/(.?)\[(tab)\b(.*?)(?:(\/))?\](?:(.+?)\[\/tab\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		$output = '<ul class="'.$code.'">';
		
		for($i = 0; $i < count($matches[0]); $i++) {
			$output .= '<li><a href="#">' . $matches[3][$i]['title'] . '</a></li>';
		}
		$output .= '</ul>';
		$output .= '<div class="panes">';
		for($i = 0; $i < count($matches[0]); $i++) {
			$output .= '<div class="pane">' . do_shortcode(trim($matches[5][$i])) . '</div>';
		}
		$output .= '</div>';
		
		return '<div class="'.$code.'_container">' . $output . '</div>';
	}
}
add_shortcode('tabs', 'theme_shortcode_tabs');
add_shortcode('mini_tabs', 'theme_shortcode_tabs');

function theme_shortcode_accordions($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'style' => false
	), $atts));
	
	if (!preg_match_all("/(.?)\[(accordion)\b(.*?)(?:(\/))?\](?:(.+?)\[\/accordion\])?(.?)/s", $content, $matches)) {
		return do_shortcode($content);
	} else {
		for($i = 0; $i < count($matches[0]); $i++) {
			$matches[3][$i] = shortcode_parse_atts($matches[3][$i]);
		}
		$output = '';
		for($i = 0; $i < count($matches[0]); $i++) {
			$output .= '<div class="tab">' . $matches[3][$i]['title'] . '</div>';
			$output .= '<div class="pane">' . do_shortcode(trim($matches[5][$i])) . '</div>';
		}

		return '<div class="accordion">' . $output . '</div>';
	}
}
add_shortcode('accordions', 'theme_shortcode_accordions');

function theme_shortcode_toggle($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		'title' => false
	), $atts));
	return '<div class="toggle"><div class="toggle_title"><h4>' . $title . '</h4></div><div class="toggle_content">' . do_shortcode(trim($content)) . '<div class="clear"></div></div></div>';
}
add_shortcode('toggle', 'theme_shortcode_toggle');

/* ======================================
   Google Map
   ======================================*/
function theme_shortcode_googlemap($atts, $content = null, $code) {
	extract(shortcode_atts(array(
		"width" => '600',
		"height" => '400',
		"address" => '',
		"latitude" => 0,
		"longitude" => 0,
		"zoom" => 1,
		"html" => '',
		"popup" => 'false',
		"controls" => '[]',
		"scrollwheel" => 'true',
		"maptype" => 'G_NORMAL_MAP',
		"marker" => 'true',
	), $atts));
	
	if($width && is_numeric($width)){
		$width = 'width:'.$width.'px;';
	}else{
		$width = '';
	}
	if($height && is_numeric($height)){
		$height = 'height:'.$height.'px';
	}else{
		$height = '';
	}
	
	$id = rand(100,1000);
	if($marker != 'false'){
		return <<<HTML
[raw]
<div id="google_map_{$id}" class="google_map" style="{$width}{$height}"></div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery("#google_map_{$id}").gMap({
	    zoom: {$zoom},
	    markers:[{
	    address: "{$address}",
			latitude: {$latitude},
	    longitude: {$longitude},
	    html: "{$html}",
	    popup: {$popup}
		}],
		controls: {$controls},
		maptype: {$maptype},
	    scrollwheel:{$scrollwheel}
	});
});
</script>
[/raw]
HTML;
	}else{
return <<<HTML
[raw]
<div id="google_map_{$id}" class="google_map" style="{$width}{$height}"></div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	jQuery("#google_map_{$id}").gMap({
    zoom: {$zoom},
    latitude: {$latitude},
    longitude: {$longitude},
    address: "{$address}",
    controls: {$controls},
    maptype: {$maptype},
    scrollwheel:{$scrollwheel}
	});
});
</script>
[/raw]
HTML;
	}
}
   
add_shortcode('gmap','theme_shortcode_googlemap');


/* ======================================
   Posts List base on category
   ======================================*/
function minerva_postslist_shortcode($atts,$content=null) {
  global $post;
  
  extract(shortcode_atts(array(
    "category" => $category,
    "num" => $num,
    "orderby" => $orderby,
    "title" => $title
  ),$atts));
  
  return minerva_postslist($category,$num,$orderby,$title);
}

add_shortcode('postslist','minerva_postslist_shortcode');
?>