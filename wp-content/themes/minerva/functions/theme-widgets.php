<?php

/* Widgets Functions  */

if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name'=>'General Sidebar',
    'before_widget' => '<div class="sidebar-content"><div id="%1$s" class="widgets %2$s">',
    'after_widget' => '</div></div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>'
  ));
if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name'=>'Blog Sidebar',
    'before_widget' => '<div class="sidebar-content"><div id="%1$s" class="widgets %2$s">',
    'after_widget' => '</div></div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>'
  ));
if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name'=>'Single Post',
    'before_widget' => '<div class="sidebar-content"><div id="%1$s" class="widgets %2$s">',
    'after_widget' => '</div></div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>'
  )); 
if ( function_exists('register_sidebar') )
  register_sidebar(array(
    'name'=>'Category Sidebar',
    'before_widget' => '<div class="sidebar-content"><div id="%1$s" class="widgets %2$s">',
    'after_widget' => '</div></div>',
    'before_title' => '<h4>',
    'after_title' => '</h4>'
  ));
class PageBox_Widget extends WP_Widget {
  function PageBox_Widget() {
    $widgets_opt = array('description'=>'Display pages as small box in sidebar');
    parent::WP_Widget(false,$name= "minerva - Page to Box",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $pageid = esc_attr($instance['pageid']);
    $opt_thumbnail = esc_attr($instance['opt_thumbnail']);
    $pageexcerpt = esc_attr($instance['pageexcerpt']);
    
		$pages = get_pages();
		$listpages = array();
		foreach ($pages as $pagelist ) {
		   $listpages[$pagelist->ID] = $pagelist->post_title;
		}
  ?>  
	 <p><label>Please select the page
		<select  name="<?php echo $this->get_field_name('pageid'); ?>"  id="<?php echo $this->get_field_id('pageid'); ?>" >
			<?php foreach ($listpages as $opt => $val) { ?>
		<option value="<?php echo $opt ;?>" <?php if ( $pageid  == $opt) { echo ' selected="selected" '; }?>><?php echo $val; ?></option>
		<?php } ?>
		</select>
		</label></p>
  <p>
		<input class="checkbox" type="checkbox" <?php if ($opt_thumbnail == "on") echo "checked";?> id="<?php echo $this->get_field_id('opt_thumbnail'); ?>" name="<?php echo $this->get_field_name('opt_thumbnail'); ?>" />
		<label for="<?php echo $this->get_field_id('opt_thumbnail'); ?>"><small>display thumbnail?</small></label><br />
    </p>
    <p><label for="pageexcerpt">Number of words for excerpt :
  		<input id="<?php echo $this->get_field_id('pageexcerpt'); ?>" name="<?php echo $this->get_field_name('pageexcerpt'); ?>" type="text" class="widefat" value="<?php echo $pageexcerpt;?>" /></label></p>  
    <?php    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $pageid = apply_filters('pageid',$instance['pageid']);
    $opt_thumbnail = apply_filters('opt_thumbnail',$instance['opt_thumbnail']);
    $pageexcerpt = apply_filters('pageexcerpt',$instance['pageexcerpt']);
    if ($pageexcerpt =="") $pageexcerpt = 20;
    
    echo $before_widget;
    $pagelist = new WP_Query('post_type=page&page_id='.$pageid);
    
    while ($pagelist->have_posts()) : $pagelist->the_post();
    ?>
    <h4><?php the_title();?></h4>
      <?php if ($opt_thumbnail == "on") { ?>
        <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
          <img src="<?php get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=120&amp;w=240&amp;zc=1" alt=""  class="imgcenter-border" />                   
        <?php } 
      }?>
    <p><?php excerpt($pageexcerpt);?><a href="<?php the_permalink();?>"  class="linkreadmore"> <?php echo __('Read more &raquo;','minerva');?></a></p>
    <?php      
    endwhile;
    echo $after_widget;
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("PageBox_Widget");'));

/* Latest News Widget */

class LatestNews_Widget extends WP_Widget {
  
  function LatestNews_Widget() {
    $widgets_opt = array('description'=>'Display latest news from blog');
    parent::WP_Widget(false,$name= "minerva - Latest News",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $catid = esc_attr($instance['catid']);
    $newstitle = esc_attr($instance['newstitle']);
    $numnews = esc_attr($instance['numnews']);
    
    $categories_list = get_categories('hide_empty=0');
    
    $categories = array();
    foreach ($categories_list as $catlist) {
    	$categories[$catlist->cat_ID] = $catlist->cat_name;
    }

  ?>
    <p><label for="newstitle">Title:
  		<input id="<?php echo $this->get_field_id('newstitle'); ?>" name="<?php echo $this->get_field_name('newstitle'); ?>" type="text" class="widefat" value="<?php echo $newstitle;?>" /></label></p>  
	 <p><small>Please select category for <b>News</b>.</small></p>
		<select  name="<?php echo $this->get_field_name('catid'); ?>"  id="<?php echo $this->get_field_id('catid'); ?>" >
			<?php foreach ($categories as $opt => $val) { ?>
		<option value="<?php echo $opt ;?>" <?php if ( $catid  == $opt) { echo ' selected="selected" '; }?>><?php echo $val; ?></option>
		<?php } ?>
		</select>
		</label></p>	
    <p><label for="numnews">Number to display:
  		<input id="<?php echo $this->get_field_id('numnews'); ?>" name="<?php echo $this->get_field_name('numnews'); ?>" type="text" class="widefat" value="<?php echo $numnews;?>" /></label></p>
    <?php    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $catid = apply_filters('catid',$instance['catid']);
    $newstitle = apply_filters('newstitle',$instance['newstitle']);
    $numnews = apply_filters('numnews',$instance['numnews']);    
    
    if ($numnews == "") $numnews = 4;
    if ($newstitle == "") $newstitle = "Latest News";
    
    echo $before_widget;
    $title = $before_title.$newstitle.$after_title;
    minerva_latestnews($catid,$numnews,$title);
    ?>
   <div class="clear"></div>
   <?php
   wp_reset_query();    
   echo $after_widget;
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("LatestNews_Widget");'));

/* Popular News Widget */

class PopularNews_Widget extends WP_Widget {
  
  function PopularNews_Widget() {
    $widgets_opt = array('description'=>'Display popular news from blog category');
    parent::WP_Widget(false,$name= "minerva - Popular News",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $catid = esc_attr($instance['catid']);
    $newstitle = esc_attr($instance['newstitle']);
    $numnews = esc_attr($instance['numnews']);
    
    $categories_list = get_categories('hide_empty=0');
    
    $categories = array();
    foreach ($categories_list as $catlist) {
    	$categories[$catlist->cat_ID] = $catlist->cat_name;
    }

  ?>
    <p><label for="newstitle">Title:
  		<input id="<?php echo $this->get_field_id('newstitle'); ?>" name="<?php echo $this->get_field_name('newstitle'); ?>" type="text" class="widefat" value="<?php echo $newstitle;?>" /></label></p>  
	 <p><small>Please select category for <b>News</b>.</small></p>
		<select  name="<?php echo $this->get_field_name('catid'); ?>"  id="<?php echo $this->get_field_id('catid'); ?>" >
			<?php foreach ($categories as $opt => $val) { ?>
		<option value="<?php echo $opt ;?>" <?php if ( $catid  == $opt) { echo ' selected="selected" '; }?>><?php echo $val; ?></option>
		<?php } ?>
		</select>
		</label></p>	
    <p><label for="numnews">Number to display:
  		<input id="<?php echo $this->get_field_id('numnews'); ?>" name="<?php echo $this->get_field_name('numnews'); ?>" type="text" class="widefat" value="<?php echo $numnews;?>" /></label></p>
    <?php    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $catid = apply_filters('catid',$instance['catid']);
    $newstitle = apply_filters('newstitle',$instance['newstitle']);
    $numnews = apply_filters('numnews',$instance['numnews']);    
    
    if ($numnews == "") $numnews = 5;
    if ($newstitle == "") $newstitle = __("Popular News".'minerva');
    
    echo $before_widget;
    $title = $before_title.$newstitle.$after_title;
    minerva_popular_posts($title,$numnews)
    ?>
   <div class="clear"></div>
   <?php
   wp_reset_query();    
   echo $after_widget;
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("PopularNews_Widget");'));

/* Latest News Widget */

class LatestWorks_Widget extends WP_Widget {
  
  function LatestWorks_Widget() {
    $widgets_opt = array('description'=>'Display latest portfolio items');
    parent::WP_Widget(false,$name= "minerva - Latest Works",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $pftitle = esc_attr($instance['pftitle']);
    
  ?>
    <p><label for="pftitle">Title:
  		<input id="<?php echo $this->get_field_id('pftitle'); ?>" name="<?php echo $this->get_field_name('pftitle'); ?>" type="text" class="widefat" value="<?php echo $pftitle;?>" /></label></p>
		</label></p>	
    <?php    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $pftitle = apply_filters('pftitle',$instance['pftitle']);
    
    if ($pftitle == "") $pftitle = __("Latest Works",'minerva');
    
    echo $before_widget;
    $title = $before_title.$pftitle.$after_title;
    minerva_latestworks(3,$title);
    ?>
   <div class="clear"></div>
   <?php
   wp_reset_query();    
   echo $after_widget;
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("LatestWorks_Widget");'));

/* Testimonial Widget */

class Testimonial_Widget extends WP_Widget {
  function Testimonial_Widget() {
    $widgets_opt = array('description'=>'minerva Testimonial Theme Widget');
    parent::WP_Widget(false,$name= "minerva - Testimonial",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $catid = esc_attr($instance['catid']);
    $testititle = esc_attr($instance['testititle']);
    $numtesti = esc_attr($instance['numtesti']);
    
    $categories_list = get_categories('hide_empty=0');
    
    $categories = array();
    foreach ($categories_list as $catlist) {
    	$categories[$catlist->cat_ID] = $catlist->cat_name;
    }

  ?>
    <p><label for="testititle">Title:
  		<input id="<?php echo $this->get_field_id('testititle'); ?>" name="<?php echo $this->get_field_name('testititle'); ?>" type="text" class="widefat" value="<?php echo $testititle;?>" /></label></p>  
	 <p><small>Please select category for <b>Testimonial</b>.</small></p>
		<select  name="<?php echo $this->get_field_name('catid'); ?>"  id="<?php echo $this->get_field_id('catid'); ?>" >
			<?php foreach ($categories as $opt => $val) { ?>
		<option value="<?php echo $opt ;?>" <?php if ( $catid  == $opt) { echo ' selected="selected" '; }?>><?php echo $val; ?></option>
		<?php } ?>
		</select>
		</label></p>	
    <p><label for="numtesti">Number to display:
  		<input id="<?php echo $this->get_field_id('numtesti'); ?>" name="<?php echo $this->get_field_name('numtesti'); ?>" type="text" class="widefat" value="<?php echo $numtesti;?>" /></label></p>
    <?php    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $catid = apply_filters('catid',$instance['catid']);
    $testititle = apply_filters('testititle',$instance['testititle']);
    $numtesti = apply_filters('numtesti',$instance['numtesti']);    
        
    if ($numtesti == "") $numtesti = 1;
    if ($testititle == "") $testititle = __("Testimonials",'minerva');
    
    echo $before_widget;
    $title = $before_title.$testititle.$after_title;
    minerva_testimonial($catid,$numtesti,$title);
   echo $after_widget;
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("Testimonial_Widget");'));

/* Post to Homepage Box or Sidebar Box Widget */

class PostBox_Widget extends WP_Widget {
  function PostBox_Widget() {
    $widgets_opt = array('description'=>'Display Posts as small box in sidebar');
    parent::WP_Widget(false,$name= "minerva - Post to Box",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $postid = esc_attr($instance['postid']);
    $opt_thumbnail = esc_attr($instance['opt_thumbnail']);
    $postexcerpt = esc_attr($instance['postexcerpt']);
    
		$centitaposts = get_posts('numberposts=-1')
		?>  
	<p><label>Please select post display
			<select  name="<?php echo $this->get_field_name('postid'); ?>"  id="<?php echo $this->get_field_id('postid'); ?>" >
				<?php foreach ($centitaposts as $post) { ?>
			<option value="<?php echo $post->ID;?>" <?php if ( $postid  ==  $post->ID) { echo ' selected="selected" '; }?>><?php echo  the_title(); ?></option>
			<?php } ?>
			</select>
	</label></p>
  <p>
		<input class="checkbox" type="checkbox" <?php if ($opt_thumbnail == "on") echo "checked";?> id="<?php echo $this->get_field_id('opt_thumbnail'); ?>" name="<?php echo $this->get_field_name('opt_thumbnail'); ?>" />
		<label for="<?php echo $this->get_field_id('opt_thumbnail'); ?>"><small>display thumbnail?</small></label><br />
    </p>
    <p><label for="postexcerpt">Number of words for excerpt :
  		<input id="<?php echo $this->get_field_id('postexcerpt'); ?>" name="<?php echo $this->get_field_name('postexcerpt'); ?>" type="text" class="widefat" value="<?php echo $postexcerpt;?>" /></label></p>  
    <?php    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);
    
    $postid = apply_filters('postid',$instance['postid']);
    $opt_thumbnail = apply_filters('opt_thumbnail',$instance['opt_thumbnail']);
    $postexcerpt = apply_filters('postexcerpt',$instance['postexcerpt']);
    if ($postexcerpt =="") $postexcerpt = 20;
    
    echo $before_widget;
    $postlist = new WP_Query('p='.$postid);
    
    while ($postlist->have_posts()) : $postlist->the_post();
    ?>
      <h4><?php the_title();?></h4>
      <?php if ($opt_thumbnail == "on") { ?>
        <?php if (function_exists('has_post_thumbnail') && has_post_thumbnail()) {?>
          <img src="<?php get_template_directory_uri();?>/timthumb.php?src=<?php echo thumb_url();?>&amp;h=120&amp;w=240&amp;zc=1" alt=""  class="imgcenter-border" />                   
        <?php } 
      }?>
    <p><?php excerpt($postexcerpt);?><a href="<?php the_permalink();?>"  class="linkreadmore"> <?php echo __('Read more &raquo;','minerva');?></a></p>
    <?php   
    endwhile;
    echo $after_widget;
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("PostBox_Widget");'));

/* Ads Banner Widget */
class AdsBanner_Widget extends WP_Widget {
  function AdsBanner_Widget () {
    $widgets_opt = array('description'=>'125x125 Banner Widget');
    parent::WP_Widget(false,$name= "minerva - 125x125 Banner Widget",$widgets_opt);
  }
  
  function form($instance) {
    global $post;
    
    $banner_title  = esc_attr($instance['banner_title']);
    $banner_img1 = esc_attr($instance['banner_img1']);
    $banner_url1 = esc_attr($instance['banner_url1']);
    $banner_img2 = esc_attr($instance['banner_img2']);
    $banner_url2 = esc_attr($instance['banner_url2']);
    $banner_img3 = esc_attr($instance['banner_img3']);
    $banner_url3 = esc_attr($instance['banner_url3']);
    $banner_img4 = esc_attr($instance['banner_img4']);
    $banner_url4 = esc_attr($instance['banner_url4']);
    
  ?>
  	<p><label for="banner_title">Title :
    <input id="<?php echo $this->get_field_id('banner_title'); ?>" name="<?php echo $this->get_field_name('banner_title'); ?>" type="text" class="widefat" value="<?php echo $banner_title;?>" /></label></p>  		
    <p><label for="banner_img1">Banner Image Source #1:
  		<input id="<?php echo $this->get_field_id('banner_img1'); ?>" name="<?php echo $this->get_field_name('banner_img1'); ?>" class="widefat" value="<?php echo $banner_img1;?>"/></label></p>  		
    <p><label for="banner_url1">Banner Image URL #1:
  		<input id="<?php echo $this->get_field_id('banner_img1'); ?>" name="<?php echo $this->get_field_name('banner_url1'); ?>" class="widefat" value="<?php echo $banner_url1;?>"/></label></p>
    <p><label for="banner_img2">Banner Image Source #2:
  		<input id="<?php echo $this->get_field_id('banner_img2'); ?>" name="<?php echo $this->get_field_name('banner_img2'); ?>" class="widefat" value="<?php echo $banner_img2;?>"/></label></p>  		
    <p><label for="banner_url2">Banner Image URL #2:
  		<input id="<?php echo $this->get_field_id('banner_img2'); ?>" name="<?php echo $this->get_field_name('banner_url2'); ?>" class="widefat" value="<?php echo $banner_url2;?>"/></label></p>
    <p><label for="banner_img1">Banner Image Source #3:
  		<input id="<?php echo $this->get_field_id('banner_img3'); ?>" name="<?php echo $this->get_field_name('banner_img3'); ?>" class="widefat" value="<?php echo $banner_img3;?>"/></label></p>  		
    <p><label for="banner_url1">Banner Image URL #3:
  		<input id="<?php echo $this->get_field_id('banner_img3'); ?>" name="<?php echo $this->get_field_name('banner_url3'); ?>" class="widefat" value="<?php echo $banner_url3;?>"/></label></p>
    <p><label for="banner_img2">Banner Image Source #4:
  		<input id="<?php echo $this->get_field_id('banner_img4'); ?>" name="<?php echo $this->get_field_name('banner_img4'); ?>" class="widefat" value="<?php echo $banner_img4;?>"/></label></p>  		
    <p><label for="banner_url2">Banner Image URL #4:
  		<input id="<?php echo $this->get_field_id('banner_img4'); ?>" name="<?php echo $this->get_field_name('banner_url4'); ?>" class="widefat" value="<?php echo $banner_url4;?>"/></label></p>
  		
	  <?php    
  } 
  
  function update($new_instance, $old_instance) {
    return $new_instance;
  }
  
  function widget( $args, $instance ) {
    global $post;
    
    extract($args);

    $banner_title  = apply_filters('banner_title',$instance['banner_title']);
    $banner_img1 = apply_filters('banner_img1',$instance['banner_img1']);
    $banner_url1 = apply_filters('banner_url1',$instance['banner_url1']);
    $banner_img2 = apply_filters('banner_img2',$instance['banner_img2']);
    $banner_url2 = apply_filters('banner_img2',$instance['banner_url2']);
    $banner_img3 = apply_filters('banner_img3',$instance['banner_img3']);
    $banner_url3 = apply_filters('banner_url3',$instance['banner_url3']);
    $banner_img4 = apply_filters('banner_img4',$instance['banner_img4']);
    $banner_url4 = apply_filters('banner_img4',$instance['banner_url4']);
    
    echo $before_widget;
    ?>
    	<?php echo $before_title.$banner_title.$after_title;?>
      <ul class="sponsors-list">
        <li><a href="<?php echo $banner_url1;?>"><img src="<?php echo ($banner_img1) ? $banner_img1 : get_template_directory_uri().'/images/tf-banner.gif';?>" alt="" /></a></li>
        <li class="sponsors-nomargin"><a href="<?php echo $banner_url2;?>"><img src="<?php echo ($banner_img2) ? $banner_img2 : get_template_directory_uri().'/images/gr-banner.gif';?>" alt="" /></a></li>
        <li><a href="<?php echo $banner_url3;?>"><img src="<?php echo ($banner_img3) ? $banner_img3 : get_template_directory_uri().'/images/aj-banner.gif';?>" alt="" /></a></li>
        <li class="sponsors-nomargin"><a href="<?php echo $banner_url4;?>"><img src="<?php echo ($banner_img4) ? $banner_img4 : get_template_directory_uri().'/images/ad-banner.gif';?>" alt="" /></a></li>        
      </ul> 
    <?php 
    echo $after_widget;
  } 
}

add_action('widgets_init', create_function('', 'return register_widget("AdsBanner_Widget");'));

?>