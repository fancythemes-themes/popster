<?php
// www.circathemes.com

class WP_Widget_Recent_Posts_Popster extends WP_Widget {
	
	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Set up the widget options.
		$widget_ops = array('classname' => 'widget_posts_wrap', 'description' => esc_html__( 'Popster - Recent Posts', 'popster') );

		// Create the widget.
		parent::__construct('recent_posts_popster', esc_html__('Popster - Recent Posts', 'popster'), $widget_ops);
		
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {		
		extract( $args );
		$default = array ('widget_title'=>esc_html__('Recent Posts','popster'), 'cats'=>'', 'cat'=>'', 'quantity'=>1, 'exclude'=>'', 'order'=>'date', 'display'=>'type-2', 'excerpt'=>'display', 'not_in'=>'' );
		$instance = wp_parse_args($instance, $default);
		$widget_title = apply_filters('widget_title', $instance['widget_title']);
		$cats = $instance['cats'];
		$cat = $instance['cat'];
		$quantity = $instance['quantity'];
		$exclude = $instance['exclude'];
		$order = $instance['order'];
		//$display = $instance['display'];
		$display = 'type-3';
		$excerpt = $instance['excerpt'];
		$not_in = $instance['not_in'];
		$thumbsize = array(54,54);
		if ( $excerpt != 'hide') $excp = '';
		else $excp = 'no-exerpt';
		// DISPALY WIDGET
		echo $before_widget;
		?>
			<?php if(!empty($instance['widget_title']) && $cat == "multiple_cat"){ echo $before_title . $widget_title . $after_title; } ?>
            <?php if($cat != 'multiple_cat') { echo $before_title. apply_filters('widget_title', get_cat_name( $cat )) .$after_title; } ?>
			<div class="widget_posts<?php if ($order == 'comment_count' ) echo ' popular-posts'; ?>">
			<?php
				$q = $quantity;
				$i = 0;
				if ( $cat == "multiple_cat" ){
					$category = $cats;
				}else{
					$category = $cat;
				}
			$r = new WP_Query(array('showposts' => $quantity, 'cat' => $category, 'orderby'=>$order, 'post_status' => 'publish', 'ignore_sticky_posts' => 1,'post__not_in' => $not_in));
			$i = 0;
			while ($r->have_posts()) : $r->the_post();
			?>
				<article>

							<header class="clearfix">
								<?php if ( has_post_thumbnail() ) { ?>
									<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="home-thumb alignleft"><?php the_post_thumbnail('post-thumbnail'); ?></a>
								<?php } ?>
								<p class="meta"> <time datetime="<?php echo the_time('Y-m-d'); ?>" ><?php the_time(get_option('date_format')); ?></time><span class="author-meta">, <?php the_author_posts_link(); ?></span><span class="comment-count-meta">, <?php comments_popup_link(esc_html__('No Comment', 'popster'), '1 Comment', '% Comments','','Comment Closed'); ?></span></p>
								<h4 class="h4"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>


							</header> <!-- end article header -->

				</article>
			<?php 
				$i++;
			endwhile;
			wp_reset_query(); 
			?>
			</div>
			<div class="clear"><!-- --></div>
		<?php
		echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['widget_title'] = strip_tags($new_instance['widget_title']);
		$instance['cats'] = strip_tags($new_instance['cats']);
		$instance['cat'] = strip_tags($new_instance['cat']);
		$instance['quantity'] = strip_tags($new_instance['quantity']);
		$instance['exclude'] = strip_tags($new_instance['exclude']);
		$instance['order'] = strip_tags($new_instance['order']);
		$instance['display'] = strip_tags($new_instance['display']);
		
		$default = array ('widget_title'=>esc_html__('Recent Posts','popster'), 'cats'=>'', 'cat'=>'', 'quantity'=>1, 'exclude'=>'', 'order'=>'date', 'display'=>'type-2');

		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {				
		$default = array ('widget_title'=>esc_html__('Recent Posts','popster'), 'cats'=>'', 'cat'=>'', 'quantity'=>1, 'exclude'=>'', 'order'=>'date', 'display'=>'type-2');
		$instance = wp_parse_args( $instance, $default );
		$widget_title = $instance['widget_title'];
		$cats = $instance['cats'];
		$cat = $instance['cat'];
		$quantity = $instance['quantity'];
		$exclude = $instance['exclude'];
		$order = $instance['order'];
		$display = $instance['display'];
		?>
		<input style="display:none;" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		<p>
			<?php esc_html_e('Widget title ( Will automaticly use category name when select single category ) :', 'popster'); ?>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo $widget_title; ?>" />
		</p>
        <p>
        	<?php esc_html_e('Category :', 'popster'); ?>
            <select name="<?php echo $this->get_field_name('cat'); ?>">
            	<option value="multiple_cat" <?php if ($cat == 'multiple_cat') echo 'selected';  ?>>Multiple Categories</option>
                <?php
				$of_categories = array();  
				$of_categories_obj = get_categories('hide_empty=0');
				foreach ($of_categories_obj as $of_cat) {
				?>
				<option value="<?php echo $of_cat->cat_ID; ?>" <?php if ($cat == $of_cat->cat_ID) echo 'selected'; ?>><?php echo $of_cat->cat_name; ?></option>
                <?php //$of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
				}
				?>
            </select>
        </p>
		<p>
			<?php esc_html_e('Enter ID of categories e.g. 1,2,3,4. Leave it blank to pull all categories ( if multiple category choosed ).', 'popster'); ?>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('cats'); ?>" value="<?php echo $cats; ?>" />
		</p>
		<p>
			<?php esc_html_e('Posts:', 'popster'); ?>
			<select name="<?php echo $this->get_field_name('quantity'); ?>">
				<option value="1" <?php if ($quantity=="1"):?> selected <?php endif; ?>>1</option>
				<option value="2" <?php if ($quantity=="2"):?> selected <?php endif; ?>>2</option>
				<option value="3" <?php if ($quantity=="3"):?> selected <?php endif; ?>>3</option>
				<option value="4" <?php if ($quantity=="4"):?> selected <?php endif; ?>>4</option>
				<option value="5" <?php if ($quantity=="5"):?> selected <?php endif; ?>>5</option>
				<option value="6" <?php if ($quantity=="6"):?> selected <?php endif; ?>>6</option>
				<option value="7" <?php if ($quantity=="7"):?> selected <?php endif; ?>>7</option>
				<option value="8" <?php if ($quantity=="8"):?> selected <?php endif; ?>>8</option>
				<option value="9" <?php if ($quantity=="9"):?> selected <?php endif; ?>>9</option>
				<option value="10" <?php if ($quantity=="10"):?> selected <?php endif; ?>>10</option>
				<option value="11" <?php if ($quantity=="11"):?> selected <?php endif; ?>>11</option>
				<option value="12" <?php if ($quantity=="12"):?> selected <?php endif; ?>>12</option>
				<option value="13" <?php if ($quantity=="13"):?> selected <?php endif; ?>>13</option>
				<option value="14" <?php if ($quantity=="14"):?> selected <?php endif; ?>>14</option>
				<option value="15" <?php if ($quantity=="15"):?> selected <?php endif; ?>>15</option>
			</select>
		</p>
		<p>
			<?php esc_html_e('Order posts by:', 'popster'); ?>
			<select name="<?php echo $this->get_field_name('order'); ?>">
				<option value="date" <?php if ($order=="date"):?> selected <?php endif; ?>>date</option>
				<option value="rand" <?php if ($order=="rand"):?> selected <?php endif; ?>>random</option>
                <option value="comment_count" <?php if ($order=="comment_count"):?> selected <?php endif; ?>>popular</option>
			</select>
			<div style="height:12px; border-top:2px solid #DFDFDF;"><!-- --></div>
		</p>
        <!--<p>
			<?php esc_html_e('Display type:', 'popster'); ?>
			<select name="<?php echo $this->get_field_name('display'); ?>">
				<option value="type-1" <?php if ( $display=="type-1") : ?> selected <?php endif; ?>>Type 1 ( Big images )</option>
				<option value="type-2" <?php if ( $display=="type-2") : ?> selected <?php endif; ?>>Type 2 ( Big images for first post )</option>
				<option value="type-3" <?php if ( $display=="type-3") : ?> selected <?php endif; ?>>Type 3 ( Small images )</option>
			</select>
		</p>-->
		<?php 
	}

} // class FooWidget

/**
 * Register Widgets
 *
 * @since 1.0.0
*/

function popster_register_widgets() {

    register_widget( 'WP_Widget_Recent_Posts_Popster' );

}

add_action( 'widgets_init', 'popster_register_widgets' );
?>