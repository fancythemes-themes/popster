<?php
/*
Author: CircaThemes
URL: http://circathemes.com/
*/

/*
Initial WordPress load, contains used global variable, include files call etc.
*/

// Call required PHP files
require_once('inc/circathemes-helper.php');
require_once('inc/widgets/recent_posts.php');
require_once('inc/widgets/recent_comments.php');
require_once('inc/widgets/video.php');
require_once('inc/widgets/flickr.php');
require_once('inc/customizer-simple.php');           
require_once('inc/customizer.php');

function popster_setup() {
	
	/**
	* Set the content width based on the theme's design and stylesheet.
	*/
	global $content_width;
	if ( ! isset( $content_width ) ) {
		$content_width = 710; /* pixels */
	}

	/************* THUMBNAIL SIZE OPTIONS *************/

	// Thumbnail sizes
	add_image_size( 'popster-thumb-300', 300, 200, true );
	add_image_size( 'popster-thumb-60', 60, 60, true );
	add_theme_support( 'post-thumbnails' ); 
	set_post_thumbnail_size( 175, 175, true );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

}
add_action( 'after_setup_theme', 'popster_setup' );

/**
 * Enqueues scripts and styles.
 *
 * @since Twenty Sixteen 1.0
 */
function popster_scripts() {

	// Theme stylesheet.
	wp_enqueue_style( 'popster-style', get_stylesheet_uri() );

	// Load the Internet Explorer specific stylesheet.
	wp_enqueue_style( 'popster-ie', get_template_directory_uri() . '/css/ie.css', array( 'popster-style' ), '20151118' );
	wp_style_add_data( 'popster-ie', 'conditional', 'lt IE 8' );
	
	// Load the selectivizr.js shiv.
	wp_enqueue_script( 'popster-selectivizr', get_template_directory_uri() . '/js/libs/selectivizr.js', array(), '3.7.3' );
	wp_script_add_data( 'popster-selectivizr', 'conditional', 'lt IE 9' );

	// Load the respond.min.js shiv.
	wp_enqueue_script( 'popster-respond', get_template_directory_uri() . '/js/libs/respond.min.js', array(), '3.7.3' );
	wp_script_add_data( 'popster-respond', 'conditional', 'lt IE 9' );
    
    if ( $theme_options['homepage_featured_slider'] ){
        wp_enqueue_script( 'popster-featured-slider', get_template_directory_uri() . '/js/featured-slider.js', array(), '1.0', true );
    }

}
add_action( 'wp_enqueue_scripts', 'popster_scripts' );


/************* LOAD TEXTDOMAIN *************/

load_theme_textdomain( 'popster', get_template_directory() . '/languages' );

/************* ACTIVE SIDEBARS ********************/

// Sidebars & Widgetizes Areas
function popster_register_sidebars() {
	register_sidebar(array(
		'id' => 'sidebar1',
		'name' => esc_html__('Sidebar 1', 'popster') ,
		'description' => esc_html__('The first (primary) sidebar.', 'popster'),
		'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle"><span>',
		'after_title' => '</span></h4>'
	));

	register_sidebar(array(
		'id' => 'header-sidebar',
		'name' => esc_html__('Header Sidebar', 'popster'),
		'description' => esc_html__('Widget area on the header, best use for advertisement.', 'popster'),
		'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<h4 class="widgettitle"><span>',
		'after_title' => '</span></h4>'
	));
} // don't remove this bracket!
		  
/************* COMMENT LAYOUT *********************/
		
// Comment Layout
function popster_comments($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
	<li <?php comment_class(); ?>>
		<article id="comment-<?php comment_ID(); ?>" class="clearfix">
			<header class="comment-author vcard">
				<?php echo get_avatar($comment,$size='45',$default='<path_to_url>' ); ?>
				<?php printf(__('<cite class="fn">%s</cite>', 'popster'), get_comment_author_link()) ?>
				<p class="meta"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(esc_html__('%1$s', 'popster'), get_comment_date(get_option('date_format')). ' ' .  get_comment_time(get_option('time_format'))) ?></a>, <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></p>
				<?php edit_comment_link(esc_html__('(Edit)', 'popster'),'  ','') ?>
			</header>
			<?php if ($comment->comment_approved == '0') : ?>
       			<div class="help">
          			<p><?php esc_html_e('Your comment is awaiting moderation.', 'popster') ?></p>
          		</div>
			<?php endif; ?>
			<section class="comment_content clearfix">
				<?php comment_text() ?>
			</section>
		</article>
    <!-- </li> is added by wordpress automatically -->
<?php
} // don't remove this bracket!

/************* SEARCH FORM LAYOUT *****************/

// Search Form
function popster_wpsearch($form) {
    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" class="shadow-inset" >
    <label class="screen-reader-text" for="s">' . __('Search for:', 'popster') . '</label>
    <input type="text" value="' . get_search_query() . '" name="s" id="s" />
    <input type="submit" id="searchsubmit" value="'. __('Search', 'popster') .'" />
    </form>';
    return $form;
}

/**
 * HTML sanitization callback example.
 *
 * - Sanitization: html
 * - Control: text, textarea
 */
function popster_sanitize_html( $html ) {
	return wp_filter_post_kses( $html );
}

/**
 * Select sanitization callback example.
 *
 * - Sanitization: select
 * - Control: select, radio
 * 
 */
function popster_sanitize_select( $input, $setting ) {
	
	// Ensure input is a slug.
	$input = sanitize_key( $input );
	
	// Get list of choices from the control associated with the setting.
	$choices = $setting->manager->get_control( $setting->id )->choices;
	
	// If the input is a valid key, return it; otherwise, return the default.
	return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
}

function popster_sanitize_checkbox( $input ) {
    if ( $input ) {
            $output = '1';
    } else {
            $output = false;
    }
    return $output;
}

function popster_sanitize_image( $image, $setting ) {
	/*
	 * Array of valid image file types.
	 *
	 * The array includes image mime types that are included in wp_get_mime_types()
	 */
    $mimes = array(
        'jpg|jpeg|jpe' => 'image/jpeg',
        'gif'          => 'image/gif',
        'png'          => 'image/png',
        'bmp'          => 'image/bmp',
        'tif|tiff'     => 'image/tiff',
        'ico'          => 'image/x-icon'
    );
	// Return an array with file extension and mime_type.
    $file = wp_check_filetype( $image, $mimes );
	// If $image has a valid mime_type, return it; otherwise, return the default.
    return ( $file['ext'] ? $image : $setting->default );
}

?>