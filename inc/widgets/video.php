<?php

// circathemes - VIDEO WIDGET
// www.circathemes.com

class WP_Widget_Video_Popster extends WP_Widget {
	
	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Set up the widget options.
		$widget_ops = array('classname' => 'widget_video', 'description' => esc_html__( 'Popster - Latest video', 'popster') );

		// Create the widget.
		parent::__construct('video_popster', esc_html__('Popster - Latest video', 'popster'), $widget_ops);
		
	}

	function widget($args, $instance) {		
		extract( $args );
		$default = array('widget_title'=>esc_html__('Latest Videos','popster'), 'id'=> '', 'qty'=>1 );			
		$instance = wp_parse_args($instance, $default);			
		$widget_title = apply_filters('widget_title', $instance['widget_title']);
		$id = $instance['id'];
		$qty = $instance['qty'];
		// WIDGET OUTPUT
		echo $before_widget;
		?>
 		<?php if(!empty($widget_title)){ echo $before_title.$widget_title.$after_title ; } 
				else { echo $empty_title.$widget_title.$after_title ; }
		?>
       <div class="video-post-wrap loop-items clearfix">
		<?php
		$args = array(
			'tax_query' => array(
				array(
					'taxonomy' => 'post_format',
					'field' => 'slug',
					'terms' => 'post-format-video'
					)
			), 'showposts' => $qty
		);
		$r = new WP_Query($args);
		$post_found = count($r->posts);
		$i = 1;
		while ($r->have_posts()) : $r->the_post();
		?>
			<div class="the-video item">
				<?php echo popster_video_post(); ?>
            	<p class="meta">Video <?php echo $i; ?> of <?php echo ($post_found); ?></p>
				<h4 class="video-title post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
			</div>
		<?php 
			$i++;
		endwhile;
		?>
        </div>
		<nav>
			<a href="#" class="slider-prev">&larr;</a>
			<a href="#" class="slider-next">&rarr;</a>
		</nav>
		<?php
		echo $after_widget;		
	}

	function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['widget_title'] = strip_tags($new_instance['widget_title']);
		$instance['qty'] = strip_tags($new_instance['qty']);

		return $instance;
	}

	function form($instance) {	
		$default = array('widget_title'=>esc_html__('Latest Videos','popster'), 'id'=> '', 'qty'=>1 );			
		$instance = wp_parse_args($instance, $default);			
		$widget_title = $instance['widget_title'];
		$qty = $instance['qty'];
	?>
		<p>
			<?php esc_html_e('Widget title:', 'popster'); ?>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo $widget_title; ?>" />
		</p>
		<p>
			<?php esc_html_e('Quantity:', 'popster'); ?>
			<select name="<?php echo $this->get_field_name('qty'); ?>" >
				<option value="1" <?php selected($qty, "1"); ?>>1</option>
				<option value="2" <?php selected($qty, "2"); ?>>2</option>
				<option value="3" <?php selected($qty, "3"); ?>>3</option>
				<option value="4" <?php selected($qty, "4"); ?>>4</option>
				<option value="5" <?php selected($qty, "5"); ?>>5</option>
				<option value="6" <?php selected($qty, "6"); ?>>6</option>
				<option value="7" <?php selected($qty, "7"); ?>>7</option>
				<option value="8" <?php selected($qty, "8"); ?>>8</option>
				<option value="9" <?php selected($qty, "9"); ?>>9</option>
				<option value="10" <?php selected($qty, "10"); ?>>10</option>
			</select>
		</p>

	<?php
	}

}

/**
 * Register Widgets
 *
 * @since 1.0.0
*/

function popster_register_video_widgets() {

    register_widget( 'WP_Widget_Video_Popster' );

}

add_action( 'widgets_init', 'popster_register_video_widgets' );