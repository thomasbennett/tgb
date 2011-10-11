                    <div id="sidebar-right">
                        <?php
                          global $post;
                          
                      		$children=wp_list_pages( 'echo=0&child_of=' . $post->ID . '&title_li=' );
                      		if ($children) {
                      			$parent = $post->ID;
                      		}else{
                      			$parent = $post->post_parent;
                      			if(!$parent){
                      				$parent = $post->ID;
                      			}
                      		}              
                          $children = wp_list_pages("title_li=&child_of=".$parent."&echo=0&depth=1&menu_order=sort_column");
                          $parent_title = get_the_title($parent);
                          ?>      
                        <?php if ($children) { ?>
                          <div class="sidebar-content">
                            <h4><?php echo $parent_title;?></h4>
                            <ul class="sidebar-list"> 
                           	  <?php echo $children;?>
                           </ul> 
                          </div>                
                        <?php } ?>

                        <?php 
                        
                        $blog_page = get_option('minerva_blog_page');
                        $blog_pid = get_page_by_title($blog_page);
                        
                        if (is_page($blog_pid->ID)) {
                          if (function_exists('dynamic_sidebar') && dynamic_sidebar('Blog Sidebar')) : else : 
                            if (function_exists('dynamic_sidebar') && dynamic_sidebar('General Sidebar'));
                          endif;
                        } else if (is_single()) {
                          if (function_exists('dynamic_sidebar') && dynamic_sidebar('Single Post')) : else : 
                            if (function_exists('dynamic_sidebar') && dynamic_sidebar('General Sidebar')) : endif;
                          endif;
                        } else if (is_category() || is_archive() || is_search()) {
                          if (function_exists('dynamic_sidebar') && dynamic_sidebar('Category Sidebar')) : else : 
                            if (function_exists('dynamic_sidebar') && dynamic_sidebar('General Sidebar')) : endif;
                          endif;
                        } else {
                          if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('General Sidebar')) :;
                        ?>         
                          <div class="sidebar-content">
                            <h4>Categories</h4>
                            <ul class="sidebar-list"> 
                            <?php wp_list_categories('title_li=');?>
                            </ul>
                          </div>
                          
                          <div class="sidebar-content">
                            <h4>Popular Post</h4>
                            <?php if (function_exists('minerva_popular_posts')) minerva_popular_posts("",5);?>
                          </div>                                   
                            <div class="sidebar-content">
                              <?php 
                                $blog_cats_include = get_option('onixus_blog_cats_include');
                                onixus_latestnews($blog_cats_include,5,"<h3>Latest News</h3>",1);
                              ?>
                            </div>
                       <?php 
                        endif;
                        }?>         
                    </div>