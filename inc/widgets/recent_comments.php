<?php
// www.circathemes.com

class WP_Widget_Recent_Comments_Popster extends WP_Widget {
	
	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 1.0.0
	 */
	function __construct() {

		// Set up the widget options.
		$widget_ops = array('classname' => 'widget_comments_wrap', 'description' => esc_html__( 'Popster - Recent Comments', 'popster') );

		// Create the widget.
		parent::__construct('recent_comments_popster', esc_html__('Popster - Recent Comments', 'popster'), $widget_ops);
		
	}

	/** @see WP_Widget::widget */
	function widget($args, $instance) {		
		extract( $args );
		$default = 	array('widget_title'=>esc_html__('Latest Comments', 'popster'), 'quantity'=>'5' );
		$instance = wp_parse_args($instance, $default);			
		$widget_title = apply_filters('widget_title', $instance['widget_title']);
		$quantity = $instance['quantity'];
		// DISPLAY WIDGET
		echo $before_widget;
		?>
			<?php if(!empty($instance['widget_title'])){ echo $before_title . $widget_title . $after_title; } ?>
			<div class="widget_posts">
			<?php
				$q = $quantity;
				$i = 0;
				$recent_comments = get_comments( array(
					'number'    => $quantity,
					'status'    => 'approve'
				) );
				$size = 55;
//print_r($recent_comments);
				foreach ( $recent_comments as $comment ){
					$grav_url = "http://www.gravatar.com/avatar/" . md5( strtolower( trim( $comment->comment_author_email ) ) ) . "?s=" . $size;
				?>
				<article>
                	<header class="clearfix">
					<a href="<?php echo get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID; ?>" class="home-thumb alignleft"><img src="<?php echo $grav_url; ?>" alt="" class="alignleft"  /></a>
					<p class="meta"><a href="<?php echo get_permalink($comment->comment_post_ID).'#comment-'.$comment->comment_ID; ?>" class="comment_link"><?php echo $comment->comment_author; ?></a> <?php _e('commented on', 'popster'); ?> </p>
					<h4 class="h4"><a href="<?php echo get_permalink($comment->comment_post_ID ).'#comment-'.$comment->comment_ID;  ?>"><?php echo (get_the_title( $comment->comment_post_ID )); ?></a></h4>
                    </header>
					
				</article>
				<?php
				}
				?>
			</div>
		<?php
		echo $after_widget;
	}

	/** @see WP_Widget::update */
	function update($new_instance, $old_instance) {				
		$instance = $old_instance;
		$instance['widget_title'] = strip_tags($new_instance['widget_title']);
		$instance['quantity'] = strip_tags($new_instance['quantity']);

		return $instance;
	}

	/** @see WP_Widget::form */
	function form($instance) {		
		$default = 	array('widget_title'=>esc_html__('Latest Comments', 'popster'), 'quantity'=>'5' );
		$instance = wp_parse_args($instance, $default);			
		$widget_title = $instance['widget_title'];
		$quantity = $instance['quantity'];
		?>
		<input style="display:none;" type="text" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title; ?>" />
		<p>
			<?php esc_html_e('Widget title: ', 'popster' ); ?>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('widget_title'); ?>" value="<?php echo $widget_title; ?>" />
		</p>
		<p>
			<?php esc_html_e('Posts: ', 'popster' ); ?>
			<input class="widefat" type="text" name="<?php echo $this->get_field_name('quantity'); ?>" value="<?php echo $quantity; ?>" />
		</p>
		<?php 
	}

} // class FooWidget

/**
 * Register Widgets
 *
 * @since 1.0.0
*/

function popster_register_recent_comments_widgets() {

    register_widget( 'WP_Widget_Recent_Comments_Popster' );

}

add_action( 'widgets_init', 'popster_register_recent_comments_widgets' );
?>