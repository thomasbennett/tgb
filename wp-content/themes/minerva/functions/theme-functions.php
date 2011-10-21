<?php

/* Theme Functions  */
function excerpt($excerpt_length) {
  global $post;
	$content = $post->post_content;
	$words = explode(' ', $content, $excerpt_length + 1);
	if(count($words) > $excerpt_length) :
		array_pop($words);
		array_push($words, '<a href="'.the_permalink().'">read more</a>');
		$content = implode(' ', $words);
	endif;
  
  $content = strip_tags(strip_shortcodes($content));
  
	echo $content;

}

function minerva_excerpt($length, $ellipsis) {
	$text = get_the_content();
	$text = preg_replace('`\[(.*)]*\]`','',$text);
	$text = strip_tags($text);
	$text = substr($text, 0, $length);
	$text = substr($text, 0, strripos($text, " "));
	$text = $text.$ellipsis;
	return $text;
}

function minerva_truncate($string, $limit, $break=".", $pad="read more") {
	if(strlen($string) <= $limit) return $string;
	
	 if(false !== ($breakpoint = strpos($string, $break, $limit))) {
		if($breakpoint < strlen($string) - 1) {
			$string = substr($string, 0, $breakpoint) . $pad;
		}
	  }
	return $string; 
}

// Custom Comments Display
function mytheme_comment($comment, $args, $depth) { 
  $GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID() ?>">
		<div class="avatar"><?php echo get_avatar($comment,$size='64'); ?></div>
    <div class="comment-text" ><h5><?php comment_author_link() ?></h5>
      <?php if ($comment->comment_approved == '0') : ?>
  		<p>Your comment is awaiting moderation.</p>
  		<?php endif; ?>
  		<?php comment_text() ?>
      <div class="smalltext">
        <small>
          <span class="commdate"><?php comment_date('F jS, Y') ?></span>
          <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </small>
      </div>
    </div>		
		</li>  
<?php
}

function mytheme_ping($comment, $args, $depth) { ?>
		<li id="comment-<?php comment_ID() ?>">
		<div class="avatar"><?php echo get_avatar($comment,$size='64'); ?></div>
    <div class="comment-text" ><h5><?php comment_author_link() ?></h5>
      <?php if ($comment->comment_approved == '0') : ?>
  		<p>Your comment is awaiting moderation.</p>
  		<?php endif; ?>
  		<?php comment_text() ?>
      <div class="smalltext">
        <small>
          <span class="commdate"><?php comment_date('F jS, Y') ?></span>
          <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </small>
      </div>
    </div>		
		</li>  
<?php
}


function minerva_add_javascripts() {  
  wp_enqueue_scripts('jquery'); 
  wp_enqueue_script( 'jquery.bxSlider.min', get_template_directory_uri().'/js/jquery.bxSlider.min.js', array( 'jquery' ) );
  wp_enqueue_script( 'jquery.twitter', get_template_directory_uri().'/js/jquery.twitter.js', array( 'jquery' ) );
  wp_enqueue_script( 'jquery.prettyPhoto', get_template_directory_uri().'/js/jquery.prettyPhoto.js', array( 'jquery' ) );
  wp_enqueue_script( 'jquery.roundabout.min', get_template_directory_uri().'/js/jquery.roundabout.min.js', array( 'jquery' ) );
  wp_enqueue_script( 'jquery.tools.tabs.min', get_template_directory_uri().'/js/jquery.tools.tabs.min.js', array( 'jquery' ) );
  
  wp_register_script( 'jquery-gmap', get_template_directory_uri().'/js/jquery.gmap-1.1.0-min.js', array('jquery'));
  wp_enqueue_script( 'functions', get_template_directory_uri().'/js/functions.js', array( 'jquery' ) );
}

if (!is_admin()) {
  add_action( 'wp_print_scripts', 'minerva_add_javascripts' ); 
}

if(get_option('minerva_google_map_key')){
	function theme_add_gmap_script(){
		echo "\n<script type='text/javascript' src='http://maps.google.com/maps?file=api&amp;v=2&amp;key=".get_option('minerva_google_map_key')."'></script>\n";
		wp_print_scripts( 'jquery-gmap');
	}
	add_filter('wp_head','theme_add_gmap_script');
}

function minerva_add_stylesheet() { 
  ?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/prettyPhoto.css" type="text/css" media="screen" />
  <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/css/custom_style.php" type="text/css" media="screen" />
<?php 
}

add_action('wp_head', 'minerva_add_stylesheet');


/* Register Nav Menu Features For Wordpress 3.0 */
register_nav_menus( array(
	'topnav' => __( 'Main Navigation')
) );

/* Native Pages List function for Main Menu */
/* Native Nagivation Pages List for Main Menu */
function minerva_topmenu_pages() {
  global $excludeinclude_pages;
  
  $excludeinclude_pages = get_option('minerva_excludeinclude_pages');
  if(is_array($excludeinclude_pages)) {
    $page_exclusions = implode(",",$excludeinclude_pages);
  }
?>
	<ul class="navigation">
  	<li <?php if (is_home() || is_front_page()) echo 'class="current"';?>><a href="<?php echo home_url();?>">Home</a></li>
  	<?php wp_list_pages('title_li=&sort_column=menu_order&depth=2&exclude='.$page_exclusions);?>
  </ul>

<?php
}

/* Remove Default Container for Nav Menu Features */
function minerva_nav_menu_args( $args = '' ) {
	$args['container'] = false;
	return $args;
} 
add_filter( 'wp_nav_menu_args', 'minerva_nav_menu_args' );

function get_shortcode_name($name) {
  if (strstr(get_shortcode_regex(),$name)) {
    return true;
  }
}

        
function detect_ext($file) {
  $ext = pathinfo($file, PATHINFO_EXTENSION);
  return $ext;
}

function is_quicktime($file) {
  $quicktime_file = array("mov","3gp","mp4");
  if (in_array(pathinfo($file, PATHINFO_EXTENSION),$quicktime_file)) {
    return true;
  } else {
    return false;
  }
}

function is_flash($file) {
  if (pathinfo($file, PATHINFO_EXTENSION) == "swf") {
    return true;
  } else {
    return false;
  }
}

function is_youtube($file) {
  if (preg_match('/youtube/i',$file)) {
    return true;
  } else {
    return false;
  }
}

function is_vimeo($file) {
  if (preg_match('/vimeo/i',$file)) {
    return true;
  } else {
    return false;
  }
}

function minerva_latestnews($blogcat,$num=4,$title="",$sidebar=1) { 
  global $post;
  
  echo $title;
  
  if(is_array($blogcat)) {
    $blog_includes = implode(",",$blogcat);
  } else {
    $blog_includes = $blogcat;
  }  
  
  query_posts('cat='.$blog_includes.'&showposts='.$num);
  ?>
    <ul class="popular-list">
      <?php
      while ( have_posts() ) : the_post();
      ?>
      <li>
        <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
          <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=65&amp;w=65&amp;zc=1" alt=""  />
        <?php } else {?>
          <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php get_template_directory_uri();?>/images/nothumbnail2.jpg&amp;h=65&amp;w=65&amp;zc=1" alt=""/>
        <?php } ?>     
        <p><?php the_time( get_option('date_format') );?></p>
        <p class="popular-title"><a href="<?php echo the_permalink();?>" class="titlepost"><?php the_title();?></a></p>   
      </li>
      <?php endwhile;?>
 	  </ul>
  <?php
}

function minerva_latestworks($num=3,$title="") { 
  global $post;
  
  echo $title;
  
  ?>
    <div class="sidebar-roundabout">
      <ul>
      <?php
        query_posts(array( 'post_type' => 'portfolio', 'showposts' => $num));
        while ( have_posts() ) : the_post();
        ?>  
        <li>
        <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
          <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=140&amp;w=203&amp;zc=1" alt=""  />
        <?php } ?>             
        </li>
      <?php endwhile;?>    
    </ul>
    </div>
  <?php     
}

function minerva_servicesbox($service_page,$num=4,$title) { 
  global $post;
  
  echo $title;
  ?>
  <!-- Services List Start //-->     
    <ul id="serviceslist">
  <?php
    
    if (!is_numeric($service_page)) {
      $servicespid = get_page_by_title($service_page);
      query_posts('post_type=page&post_parent='.$servicespid->ID.'&showposts='.$num); 
    } else {
      query_posts('post_type=page&post_parent='.$service_page.'&showposts='.$num);
    } 
    
    while ( have_posts() ) : the_post();
    $thumbnail_image = get_post_meta($post->ID,'_page_thumbnail_image',true);
  ?>
    <li>
      <?php if ($thumbnail_image) : ?>
      <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo $thumbnail_image;?>&amp;h=49&amp;w=49&amp;zc=1" alt="" class="imgleft" />
      <?php endif;?>
      <h5><a href="<?php the_permalink();?>"><?php the_title();?></a></h5>
      <p><?php excerpt(8);?></p>
    </li>
    <?php endwhile;wp_reset_query();?>
  </ul>        
  <!-- Services List End //-->    
    <div class="clr"></div>      
  <?php
}

function minerva_testimonial($cat,$num=1,$title="") {
  global $post;
  
  echo $title;
  ?>
  <?php
    if (!is_numeric($cat))
      $testicatid = get_cat_ID($cat); 
    else 
      $testicatid = $cat;
    
    query_posts('cat='.$testicatid.'&showposts='.$num.'&orderby=rand');
    
    while ( have_posts() ) : the_post();
    ?>
    
    <blockquote>
    <p><?php echo get_the_content();?></p>
    </blockquote>
    <p><strong><?php the_title();?></strong></p>    
  <?php
  endwhile;
}

/* Get vimeo Video ID */
function vimeo_videoID($url) {
	if ( 'http://' == substr( $url, 0, 7 ) ) {
		preg_match( '#http://(www.vimeo|vimeo)\.com(/|/clip:)(\d+)(.*?)#i', $url, $matches );
		if ( empty($matches) || empty($matches[3]) ) return __('Unable to parse URL', 'ovum');

		$videoid = $matches[3];
		return $videoid;
	}
}

function youtube_videoID($url) {
	preg_match( '#http://(www.youtube|youtube|[A-Za-z]{2}.youtube)\.com/(watch\?v=|w/\?v=|\?v=)([\w-]+)(.*?)#i', $url, $matches );
	if ( empty($matches) || empty($matches[3]) ) return __('Unable to parse URL', 'ovum');
  
  $videoid = $matches[3];
	return $videoid;
}

// Use shortcodes in text widgets.
add_filter('widget_text', 'do_shortcode');

// Make theme available for translation
// Translations can be filed in the /languages/ directory
load_theme_textdomain( 'ovum', TEMPLATEPATH . '/languages' );

$locale = get_locale();
$locale_file = TEMPLATEPATH . "/languages/$locale.php";
if ( is_readable( $locale_file ) )
	require_once( $locale_file );

function minerva_admin_scripts() {
  wp_enqueue_script('jquery.tools.min', get_template_directory_uri().'/js/tabs/jquery.tools.min.js', array('jquery'), '0.5');
}

add_action('admin_print_scripts', 'minerva_admin_scripts');

// Add default posts and comments RSS feed links to head
add_theme_support( 'automatic-feed-links' );


if (function_exists('add_theme_support')) {
	add_theme_support( 'post-thumbnails');
	set_post_thumbnail_size( 200, 200 );
	add_image_size('post_thumb', 616, 149, true);
}

function thumb_url(){  
  $thumb_src= wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), array( 2100,2100 ));
  return $thumb_src[0];
}

function get_related_portfolio($number) {
  ?>
<h3><?php echo __('Related Portfolio','onixus');?></h3>
  <ul class="latestpost-list">
    <?php
    global $post;
    $myterms = get_the_terms($post->ID,'portfolio_category');
    foreach ($myterms as $myterm ) {
      
      query_posts(array( 'post_type' => 'portfolio', 'showposts' => $number,'portfolio_category'=>$myterm->name,'orderby'=>'rand'));
      while ( have_posts() ) : the_post();
      ?>
        <li>
        <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
        <a href="<?php echo ($pf_link) ? $pf_link : thumb_url();?>" rel="prettyPhoto[portfolio]">
          <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=49&amp;w=49&amp;zc=1" alt="" class="latestpost-img" />
        </a>
        <?php } ?>
        	<p><a href="<?php the_permalink();?>"><strong><?php the_title();?></strong></a></p>
          <p><?php excerpt(12);?></p>
        </li>
      <?php endwhile;?>
    <?php } ?>
 	  </ul>  
  <?php
}

/**
 * Disable Automatic Formatting on Posts
 * Thanks to TheBinaryPenguin (http://wordpress.org/support/topic/plugin-remove-wpautop-wptexturize-with-a-shortcode)
 */
function theme_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	
	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}

	return $new_content;
}
remove_filter('the_content',	'wpautop');
remove_filter('the_content',	'wptexturize');

add_filter('the_content', 'theme_formatter', 99);

/* Add excerpt feature for page */
add_post_type_support( 'page', 'excerpt' );

function get_related_post() {
  global $post;  
  
  $relatedposts_num = (get_option('ezine_relatedposts_num')) ? get_option('ezine_relatedposts_num') : 4 ;
  $original_post = $post;
  $tags = wp_get_post_tags($post->ID);
  if ($tags) {
    $first_tag = $tags[0]->term_id;
    $args=array(
      'tag__in' => array($first_tag),
      'post__not_in' => array($post->ID),
      'showposts'=>$relatedposts_num,
      'caller_get_posts'=>1
     );
     ?>
    
    <!-- Related Posts Start //-->
    <?php
    echo '<div id="recentPostList">';
    echo '<div id="related-post-title"><h5>'.__('Related Posts','minerva').'</h5></div>';      
    $my_query = new WP_Query($args);
    if( $my_query->have_posts() ) {
      $counter = 0;
      while ($my_query->have_posts()) : $my_query->the_post();
      $counter++;
      ?>
        <div class="related-item-wrapper<?php if ($counter ==4) echo '-last';?>">           	                            	
        <a href="<?php the_permalink();?>">
        <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
          <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=116&amp;w=135&amp;zc=1" alt=""  class="img-related" />
        <?php } else {?>
          <img src="<?php echo get_template_directory_uri();?>/images/nothumbnail2.jpg" alt=""  class="img-related" />
        <?php } ?>      
        </a>
        <p><a href="<?php the_permalink();?>"><?php the_title();?></a></p>
        </div>
      <?php endwhile;
    }
    echo '</div>';
  }
  $post = $original_post;
  wp_reset_query();
}

function minerva_social_bookmarks() { ?>
  <!--Begin sharing box-->
  <div class="sharing-box">
    <div class="share-facebook">
      <?php if ($disable_fblikebutton != "true") { ?>
      <iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo urlencode(get_permalink($post->ID)); ?>&amp;layout=button_count&amp;show_faces=false&amp;width=80&amp;action=like&amp;font&amp;colorscheme=light&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:200px; height:21px;" allowTransparency="true"></iframe>
      <?php } ?>
    </div>
    
    <div class="share-social">
      <ul>
          <li><a title="Click to Tweet This!" href="http://twitter.com/home?status<?php echo urlencode(get_permalink($post->ID)); ?>" class="twitter">Tweet This</a></li>
          <li><a title="Share on Facebook" href="http://www.facebook.com/share.php?u<?php echo urlencode(get_permalink($post->ID)); ?>" class="facebook">Share on Facebook</a></li>
      </ul>
    </div>
  </div>
  <div class="clear"></div>
  <!--End sharing box-->    
  <?php
}

function minerva_popular_posts($title="",$number=5) {
  global $wpdb,$post;
  
  echo $title;
  
  $result = $wpdb->get_results("SELECT comment_count,ID,post_date,post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $number");
  ?>
  <ul class="popular-list">
  <?php
    foreach ($result as $post) {
    setup_postdata($post);
    $postid = $post->ID;
    $post_title = $post->post_title;
    $commentcount = $post->comment_count;
    if ($commentcount != 0) { ?>
    <li>
      <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
        <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=65&amp;w=65&amp;zc=1" alt=""  />
      <?php } else {?>
        <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php get_template_directory_uri();?>/images/nothumbnail2.jpg&amp;h=65&amp;w=65&amp;zc=1" alt=""/>
      <?php } ?>     
      <p><?php echo mysql2date(get_option('date_format'),$post->post_date) ?></p>
      <p class="popular-title"><a href="<?php echo get_permalink($postid);?>" class="titlepost"><?php echo $post_title;?></a></p>   
    </li>
    <?php } 
    } ?>
    </ul>
  <?php
}

/* Posts List base on category*/
function minerva_postslist($category, $num, $orderby="menu_order", $title="") {  
  global $post;
  
  $post_category_id = get_cat_ID($category);
  
  $post_num = ($num) ? $num : 4;
  $counter = 0;
  
  $out .= ($title) ? "<h4>".$title."</h4>" : "";
  $out = '<ul class="team-list">';
  
  query_posts('cat='.$post_category_id.'&showposts='.$post_num.'&orderby='.$orderby);
  while (have_posts()) : the_post();
    $thumb_image = get_post_meta($post->ID,"_thumb_image",true);
  
    $counter++;
    if ($counter%4 ==0) {
      $out .= "<li class='team-last'>";
    } else {
      $out .= "<li>"; 
    }
    if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {
      $out .= '<img src="'.get_template_directory_uri().'/timthumb.php?src='.thumb_url().'&amp;h=186&amp;w=159&amp;zc=1" alt="" />';
    } 
    $out .= '<strong>'.get_the_title().'</strong>';
    $out .="</li>";
    endwhile;
    wp_reset_query();
    $out .= "</ul>";
  return $out;
}

/* Pagination */
function wpapi_pagination($pages = '', $range = 4) {
  $showitems = ($range * 2)+1;
  
  global $paged;
  
  if(empty($paged)) $paged = 1;
    if($pages == '') {
    global $wp_query;
    $pages = $wp_query->max_num_pages;
    if(!$pages) {
      $pages = 1;
    }
  }

 if(1 != $pages) {
  echo '<div class="blog-pagination"><div class="pages blogpages"><span class="pageof">Page '.$paged.' of '.$pages.'</span>';
  if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo; First</a>";
  if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo; Previous</a>";
   for ($i=1; $i <= $pages; $i++) {
    if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
      echo ($paged == $i)? '<a "'.get_pagenum_link($i).'" class="current">'.$i.'</a>':'<a href="'.get_pagenum_link($i).'">'.$i.'</a>';
    }
  }

   if ($paged < $pages && $showitems < $pages) echo '<a href="'.get_pagenum_link($paged + 1).'">Next &rsaquo;</a>';
   if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>Last &raquo;</a>";
   echo "</div></div>";
 }
}

/* Remove Wordpress automatic formatting */
function remove_wpautop( $content ) { 
    $content = do_shortcode( shortcode_unautop( $content ) ); 
    $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
    return $content;
}

function minerva_clientlist($cat,$num=5,$title="") {
  global $post;
  
  echo $title;

  ?>
  
	<ul class="client-list">
  
  <?php
    query_posts('cat='.$cat.'&posts_per_page='.$num);
    while ( have_posts() ) : the_post();
    $image_thumbnail = get_post_meta($post->ID, '_image_thumbnail', true );
    ?>
		  <li>
      <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
        <img src="<?php echo get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=60&amp;w=172&amp;zc=1" alt=""/>
      <?php } ?>          
      </li>
    <?php endwhile;?>    
    </ul>	
  <?php
}

?>
