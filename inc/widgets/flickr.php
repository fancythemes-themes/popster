<?php

// www.circathemes.com

class WP_Widget_Flickr_Popster extends WP_Widget {
	
	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Set up the widget options.
		$widget_ops = array('classname' => 'widget_flickr', 'description' => esc_html__( 'Popster - Flickr', 'popster') );

		// Create the widget.
		parent::__construct('flickr_popster', esc_html__('Popster - Flickr', 'popster'), $widget_ops);
		
	}

	function widget($args, $instance) {		
		extract( $args );
		$default = array('widget_title'=> esc_html__('Latest Pictures','popster'), 'id'=> '', 'qty'=>8 );			
		$instance = wp_parse_args($instance, $default);			
		$widget_title = apply_filters('widget_title', $instance['widget_title']);
		$id = $instance['id'];
		$qty = $instance['qty'];
		// WIDGET OUTPUT
		echo $before_widget;
		?>
		<?php if(!empty($widget_title)){ echo $before_title.$widget_title.$after_title ;} ?>
		<div class="flickr_widget clearfix">
		<script type="text/javascript" src="http://www.flickr.com/badge_code_v2.gne?count=<?php echo $qty; ?>&amp;display=latest&amp;size=s&amp;layout=x&amp;source=user&amp;user=<?php echo $id; ?>"></script>
		</div>
		<p><a rel="nofollow" class="widget-more" href="http://www.flickr.com/photos/<?php echo $id; ?>/"><?php _e('More Photos', 'popster'); ?> &rarr;</a></p>
		<?php
		echo $after_widget;		
	}

	function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['widget_title'] = strip_tags($new_instance['widget_title']);
		$instance['id'] = $new_instance['id'];
		$instance['qty'] = $new_instance['qty'];

		return $instance;
	}

	function form($instance) {	
		$default = array('widget_title'=>__('Latest Pictures','popster'), 'id'=> '', 'qty'=>8 );			
		$instance = wp_parse_args($instance, $default);			
		$widget_title = $instance['widget_title'];
		$id = $instance['id'];
		$qty = $instance['qty'];
	?>
		<input style="display:none;" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		<p>
			<?php esc_html_e('Widget title: ', 'popster'); ?>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo $widget_title; ?>" />
		</p>
		<p>
			<?php esc_html_e('Enter ID of your flickr account ', 'popster'); ?> (<a href="http://www.idgettr.com">idGettr</a>) 
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('id'); ?>" value="<?php echo $id; ?>" />
		</p>
		<p>
			<?php esc_html_e('Display up to : ', 'popster'); ?>
            <input class="widefat" type="text" name="<?php echo $this->get_field_name('qty'); ?>" value="<?php echo $qty; ?>" />
			Photos
		</p>

	<?php
	}

}

/**
 * Register Widgets
 *
 * @since 1.0.0
*/

function popster_register_flickr_widgets() {

    register_widget( 'WP_Widget_Flickr_Popster' );

}

add_action( 'widgets_init', 'popster_register_flickr_widgets' );