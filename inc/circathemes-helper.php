<?php

// remove WP version from RSS
add_filter('the_generator', 'popster_rss_version');
function popster_rss_version() { return ''; }

// loading jquery reply elements on single pages automatically
add_action('wp_enqueue_scripts', 'popster_queue_js');
function popster_queue_js(){ 
	if (!is_admin()){ 
		wp_enqueue_script( 'jquery' ); 
		wp_register_script('modernizr', get_template_directory_uri(). '/js/modernizr.full.min.js');
		wp_enqueue_script( 'modernizr' ); 
		wp_register_script('fitvids', get_template_directory_uri(). '/js/jquery.fitvids.js');
		wp_enqueue_script( 'fitvids' ); 
		wp_register_script('flexslider', get_template_directory_uri(). '/js/jquery.flexslider.min.js');
		wp_enqueue_script( 'flexslider' ); 
		wp_register_script('popster-scripts', get_template_directory_uri(). '/js/scripts.js');
		wp_enqueue_script( 'popster-scripts' ); 
		if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) 
			wp_enqueue_script( 'comment-reply' );
			
		// register googlefont stylesheet
		wp_deregister_style('Raleway-200');
		wp_register_style('Raleway-200', 'http://fonts.googleapis.com/css?family=Raleway:200');
		wp_enqueue_style('Raleway-200');
		wp_deregister_style('Montserrat-400');
		wp_register_style('Montserrat-400', 'http://fonts.googleapis.com/css?family=Montserrat:400');
		wp_enqueue_style('Montserrat-400'); 
	}
}

/* Adding browser name as body class */
add_filter('body_class','browser_body_class');
function browser_body_class($classes) {
    global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
    if($is_lynx) $classes[] = 'lynx';
    elseif($is_gecko) $classes[] = 'gecko';
    elseif($is_opera) $classes[] = 'opera';
    elseif($is_NS4) $classes[] = 'ns4';
    elseif($is_safari) $classes[] = 'safari';
    elseif($is_chrome) $classes[] = 'chrome';
    elseif($is_IE) $classes[] = 'ie';
    else $classes[] = 'unknown';
    if($is_iphone) $classes[] = 'iphone';
    return $classes;
}

// Fixing the Read More in the Excerpts
add_filter('excerpt_more', 'popster_excerpt_more');
function popster_excerpt_more($more) {
	global $post;
	return '...';
}

// Modify the excerpt length into 35
add_filter( 'excerpt_length', 'popster_excerpt_length', 999 );
function popster_excerpt_length( $length ) {
	return 35;
}


// Adding WP 3+ Functions & Theme Support
// launching this stuff after theme setup
add_action('after_setup_theme','popster_theme_support');	
function popster_theme_support() {
	add_theme_support('post-thumbnails');      // wp thumbnails (sizes handled in functions.php)
	set_post_thumbnail_size(125, 125, true);   // default thumb size
	//add_custom_background();                   // wp custom background
	$defaults = array(
		'default-color'          => '',
		'default-image'          => '',
		'wp-head-callback'       => '_custom_background_cb',
		'admin-head-callback'    => '',
		'admin-preview-callback' => ''
	);
	add_theme_support('custom-background', $defaults);
	add_theme_support('automatic-feed-links'); // rss thingy
	// to add header image support go here: http://themble.com/support/adding-header-background-image-support/
	// adding post format support
	add_theme_support( 'post-formats',      // post formats
		array( 
			'video',   // video 
		)
	);	
	add_theme_support( 'menus' );            // wp menus
	register_nav_menus(                      // wp3+ menus
		array( 
			'main_nav' => 'The Main Menu',   // main nav in header
			'footer_links' => 'Footer Links' // secondary nav in footer
		)
	);	
}

// adding sidebars to Wordpress (these are created in functions.php)
add_action( 'widgets_init', 'popster_register_sidebars' );
// adding the bones search form (created in functions.php)
add_filter( 'get_search_form', 'popster_wpsearch' );
// removing default styling for gallery style
add_filter( 'use_default_gallery_style', '__return_false' );

// Registering main menu
function popster_main_nav() {
	// display the wp3 menu if available
    	wp_nav_menu(array( 
    		'menu' => 'main_nav', /* menu name */
    		'theme_location' => 'main_nav', /* where in the theme it's assigned */
    		'container_class' => 'col940 clearfix', /* container class */
    		'fallback_cb' => 'popster_main_nav_fallback'/*,  menu fallback */
			,'depth' => 4 /* maximum depth for the menu */
    	));
}

// Registering menu for footer link
function popster_footer_links() { 
	// display the wp3 menu if available
    wp_nav_menu(
    	array(
    		'menu' => 'footer_links', /* menu name */
    		'theme_location' => 'footer_links', /* where in the theme it's assigned */
    		'container_class' => 'footer-links clearfix', /* container class */
			'menu_class'      => 'footer-menu',
    		'fallback_cb' => 'popster_footer_links_fallback', /* menu fallback */
			'depth' => 0
    	)
	);
}

// this is the fallback for header menu
function popster_main_nav_fallback() { 
	wp_page_menu( 'show_home=Home&menu_class=menu' ); 
}

// this is the fallback for footer menu
function popster_footer_links_fallback() { 
}

// remove the p from around imgs (http://css-tricks.com/snippets/wordpress/remove-paragraph-tags-from-around-images/)
add_filter('the_content', 'filter_ptags_on_images');
function filter_ptags_on_images($content){
   return preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
}

/** 
 * Filter TinyMCE Buttons
 *
 * Here we are filtering the TinyMCE buttons and adding a button
 * to it. In this case, we are looking to add a style select 
 * box (button) which is referenced as "styleselect". In this 
 * example we are looking to add the select box to the second
 * row of the visual editor, as defined by the number 2 in the
 * mce_buttons_2 hook.
 */
function themeit_mce_buttons_2( $buttons ) {
  array_unshift( $buttons, 'styleselect' );
  return $buttons;
}
add_filter( 'mce_buttons_2', 'themeit_mce_buttons_2' );

/**
 * Add Style Options
 *
 * First we provide available formats for the style format drop down.
 * This should contain a comma separated list of formats that 
 * will be available in the format drop down list.
 *
 * Next, we provide our style options by adding them to an array.
 * Each option requires at least a "title" value. If only a "title"
 * is provided, that title will be used as a divider heading in the
 * styles drop down. This is useful for creating "groups" of options.
 *
 * After the title, we set what type of element it is and how it should
 * be displayed. We can then provide class and style attributes for that
 * element. The example below shows a variety of options.
 *
 * Lastly, we encode the array for use by TinyMCE editor
 *
 * {@link http://tinymce.moxiecode.com/examples/example_24.php }
 */
//add_filter( 'tiny_mce_before_init', 'popster_tiny_mce_before_init' );
function popster_tiny_mce_before_init( $settings ) {
 	$settings['theme_advanced_blockformats'] = 'p,a,div,span,h1,h2,h3,h4,h5,h6,tr,';

	$style_formats = array(
		array( 'title' => 'Two Column', 'block' => 'p', 'classes' => 'one-half' ),
		array( 'title' => 'Three Column', 'block' => 'p', 'classes' => 'one-third' ),
	);

	$settings['style_formats'] = json_encode( $style_formats );
	return $settings;
}

// Adding an extra css file for used in tiny MCE editor
add_action( 'after_setup_theme', 'popster_add_editor_style' );
function popster_add_editor_style() {
  add_editor_style( 'style-editor.css' );
}

add_action('wp_head','popster_sticky_menu_option');
function popster_sticky_menu_option(){
	$theme_options = get_theme_mod('popster_options');
	if ( isset($theme_options['disable_sticky_menu']) && $theme_options['disable_sticky_menu'] ) {
		echo '<script> var disableStickyMenu = true; </script>';
	}else{
		echo '<script> var disableStickyMenu = false; </script>';
	}
}
// Function to exclude categories from recent posts on homepage
function popster_exclude_categories( $query ){
	$theme_options = get_theme_mod('popster_options');
	if ( $query->is_home() && $query->is_main_query() && isset($theme_options['exclude_posts_categories']) && $theme_options['exclude_posts_categories'] ) {
		//$query->set( 'cat', '-1,-1347' );
		$query->query_vars['category__not_in'] = $theme_options['exclude_posts_categories'];
	}
}
add_action( 'pre_get_posts', 'popster_exclude_categories' );

/****************** PLUGINS & EXTRA FEATURES **************************/

/* Breadcrumbs function */
function popster_breadcrumb() {
	if ( !is_front_page() ) {
		echo '<div id="breadcrumbs" class="col940"> <a href="';
		echo home_url();
		echo '">';
		esc_html_e('Home', 'popster');
		echo "</a> ";
	}

	if ( (is_category() || is_single()) && !is_attachment() ) {
		$category = get_the_category();
		if (count($category) > 0){
			$ID = $category[0]->cat_ID;
			if ( $ID )	echo get_category_parents($ID, TRUE, ' ', FALSE );
		}
	}

	if(is_single() || is_page()) {the_title();}
	if(is_tag()){ esc_html_e('Tag: ', 'popster') .single_tag_title('',FALSE); }
	if(is_404()){ esc_html_e('404 - Page not Found' , 'popster'); }
	if(is_search()){ esc_html_e('Search', 'popster'); }
	if(is_year()){ echo get_the_time('Y'); }
	if(is_month()){ echo get_the_time('F Y'); }

	echo "</div>";	
}

add_filter( 'the_category', 'popster_add_nofollow_cat' );
function popster_add_nofollow_cat( $text) {
	$strings = array('rel="category"', 'rel="category tag"', 'rel="whatever may need"');
	$text = str_replace('rel="category tag"', "", $text);
	return $text;
}

// Show the popular tags ( tags with most posts ), this is shown on the theme under the menu
function popster_popular_tags($title){
	$tags = get_tags( array( 'orderby' => 'count', 'number'=> 10, 'order'=>'DESC') );
	$html = '<div class="popular-tags">';
	$html .= "<span>$title</span>";
	foreach ($tags as $tag){
		$tag_link = get_tag_link($tag->term_id);
			
		$html .= "<a href='{$tag_link}' title='{$tag->name} Tag' class='{$tag->slug} popular-tags-item'>";
		$html .= "{$tag->name}</a> ";
	}
	$html .= '</div>';
	echo $html;
}


// Related Posts Function (call using popster_related_posts(); )
function popster_related_posts() {
	global $post;
	$tags = wp_get_post_tags($post->ID);
	if($tags) {
		$tag_arr = '';
		foreach($tags as $tag) { $tag_arr .= $tag->slug . ','; }
		$category = get_the_category($post->ID);
		$cat_id = $category[0]->cat_ID;
        $args = array(
        	'category' => $cat_id,
        	'numberposts' => 3, /* you can change this to show more */
        	'post__not_in' => array($post->ID)
     	);
        $related_posts = get_posts($args);
        if($related_posts) {
        	foreach ($related_posts as $post) : setup_postdata($post); ?>
	           	<article class="clearfix boxed" >
					<div>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('thumbnail'); ?></a>
					<p class="meta"> <time datetime="<?php echo the_time('Y-m-d'); ?>" ><?php the_time(get_option('date_format')); ?></time></p>
					<h3 class="post-title-small h4"><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
                    </div>
				</article>
	        <?php endforeach; } 
	    else { ?>
            <div class="no_related_post type-3"><?php esc_html_e('Cannot Retrieved a Related Posts Yet!', 'popster'); ?></div>
		<?php }
	}
	wp_reset_query();
}

// Numeric Page Navi (built into the theme by default)
function popster_pagenavi(){
	global $wp_query;
	$theme_options = get_theme_mod('popster_options');
	$show_number = 2;
	$total = $wp_query->max_num_pages;
	/*if ( is_home() ){
		$posts_per_page = get_option('posts_per_page');
		$total_posts = $wp_query->found_posts;
		$posts_count_home = ( $theme_options['homepage_recent_posts'] ) ? $theme_options['homepage_recent_posts'] : $posts_per_page;
		
		if ( $posts_count_home < $posts_per_page )
			$total = ceil (( $total_posts + $posts_per_page - $posts_count_home ) / $posts_per_page );
	}*/
	if ( $total > 1 )  {
		if ( !$current_page = get_query_var('paged') )
			$current_page = 1;
		
		if ( !get_option('permalink_structure' ) ){
			$format = '&paged=%#%';
			if ( is_home() ) $format = '?paged=%#%';
		}else
			$format = 'page/%#%/';
		
		if ( is_search() ){
			$format = '&paged=%#%';
		}

		echo '<nav class="page-navigation">';
		$paginate =  paginate_links(array(
			'base' => get_pagenum_link(1) . '%_%',
			'format' => $format,
			'current' => $current_page,
			'total' => $total,
			'show_all' => true,
			'type' => 'array',
			'prev_text' => '&larr;',
			'next_text' => '&rarr;',
		));
		$fi = 0;
		$prev = '';
		$first = '';
		$left_dot = '';
		if ( strpos( $paginate[0], 'prev' ) !== false ){
			$fi = 1;
			$prev = '<li>' . $paginate[0] . '</li>';
			if ( ($current_page - $show_number ) > 1 ){
				$fi = $current_page - $show_number;
				$first = '<li>' . preg_replace('/>[^>]*[^<]</', '>First<', $paginate[1]) . '</li>';
				$left_dot = '<li><span>...</span></li>';
			}
		}
		$la = count($paginate) - 1;
		$next = '';
		$last = '';
		$right_dot = '';
		if ( strpos( $paginate[count($paginate) - 1], 'next' ) !== false ){
			$la = count($paginate) - 2;
			$next = '<li>' . $paginate[count($paginate) - 1] . '</li>';
			if ( ($current_page + $show_number ) < $total ){
				$la = $current_page + $show_number;
				$last = '<li>' . preg_replace('/>[^>]*[^<]</', '>Last<', $paginate[count($paginate) - 2]) . '</li>';
				$right_dot = '<li><span>...</span></li>';
			}
		}
		
		echo '<span class="page-of">'. esc_html__('Page', 'popster') . ' ' . $current_page . esc_html__(' of ', 'popster') . $total . '</span>';
		echo '<ul class="page_navi clearfix">';
		echo $first . $left_dot;
		echo $prev;
		for ( $i = $fi; $i <= $la; $i++ ){
			echo '<li>' . $paginate[$i] .'</li>';
		}
		echo $right_dot . $last;
		echo $next;
		echo '</ul>';
		echo '</nav>';
	}else{
		echo '<nav class="page-navigation">';
		echo '<span class="page-of">'. esc_html__('Page 1 of 1', 'popster') . '</span>';
		echo '</nav>';
	}
}

// To show the featured posts aka the Slider
function popster_featured_posts( $args = 0 ){

	global $theme_options; 
	
	$recent = new WP_Query($args);
	//$total_post = count( get_posts($args) );
	$total_post = $recent->post_count;
	if ( ! $recent->have_posts() ) return 0;	?>

	<div id="featured-slider" class="flexslider">
		<ul id="featured-items" class="slides">
			<?php $i = 1; ?>
			<?php while($recent->have_posts()) : $recent->the_post();?>
				<li class="post clearfix">
					<?php if (has_post_thumbnail()): ?>
					<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="featured-thumb"><?php the_post_thumbnail('large'); ?></a>
					<?php endif; ?>		
					<article class="boxed">

						<header>
							<div class="category-meta"><?php esc_html_e('Featured ', 'popster'); echo $i;  esc_html_e(' of ', 'popster'); echo $total_post; ?> </div> 
							<h2 class="post-title h1"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						</header>

						<div class="post_content">
							<p class="read-more"><a href="<?php the_permalink() ?>"><?php esc_html_e('Read Post', 'popster'); ?></a></p>
						</div>

					</article>

					<!--<p class="galery-slide-desc"><?php echo popster_get_option('stratify_featured_posts_title') ? popster_get_option('stratify_featured_posts_title') : esc_html_e('Featured', 'popster'); ?> <?php echo $i; ?> of <?php echo $total_post; ?></p>-->

				</li> <!-- end article header -->
				<?php $i++; ?>
			<?php endwhile;wp_reset_query(); ?>
		</ul>
	</div> <!--End of slider-->

<?php

}

function popster_custom_loop_posts( $args = 0, $title='' ){
	
	global $theme_options; 
	
	$htag = ( isset($args['heading-tag']) ) ? $args['heading-tag'] : 'h1';
	$img_size = ( isset($args['thumb-size']) ) ? $args['thumb-size'] : 'popster-thumb-300';
	
	$recent = new WP_Query($args);
	if (! ($recent->have_posts()) ) return 0;
	$index_nav = '';
	?>
	<div class="custom-loop clearfix">
		<h4 class="widgettitle"><span><?php echo $title; ?></span></h4>
		<div class="loop-items clearfix">
		<?php $i = 0; $caption =""; $nav = ''; ?>
			<?php while($recent->have_posts()) : $recent->the_post();?>
						<article <?php post_class('item-' . $i . ' item clearfix'); ?> role="article">
						
							<?php if (has_post_thumbnail()): ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="carousel-thumb"><?php the_post_thumbnail($img_size); ?></a>
							<?php endif; ?>
							<header>
								<h3 class="post-title <?php echo $htag; ?>"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h3>
								<p class="meta"> <time datetime="<?php echo the_time('Y-m-d'); ?>"><?php the_time(get_option('date_format')); ?></time>, <?php the_author_posts_link(); ?></p>
							
							</header> <!-- end article header -->
						
						
						</article> <!-- end article -->
			<?php
			$i++;
			$index_nav .= '<a href="#" class="nav-index"><span>' . $i . '</span></a>';
			endwhile;wp_reset_query(); ?>
		</div>
		<nav class="clearfix">
			<a href="#" class="slider-prev"><span>&larr;</span></a>
            <?php echo $index_nav; ?>
			<a href="#" class="slider-next"><span>&rarr;</span></a>
		</nav>
	</div> <!--End of custom posts-->
<?php

}

function popster_get_option($optname){
	global $theme_options;
	
	if ( !isset($theme_options[$optname]) ){
		$optret = false;
	}else{
		$optret = $theme_options[$optname];
	}
	
	return $optret;
}

/*
 * Convert the text with URL format into link
 *
 */
function popster_autolink($str, $attributes=array()) {

	$attrs = '';
	foreach ($attributes as $attribute => $value) {
		$attrs .= " {$attribute}=\"{$value}\"";
	}

	$str = ' ' . $str;
	$str = preg_replace(
		'`([^"=\'>])((http|https|ftp)://[^\s<]+[^\s<\.)])`i',
		'$1<a href="$2"'.$attrs.'>$2</a>',
		$str
	);
	$str = substr($str, 1);
	
	return $str;
}


/*
 * Function relative time
 *
 */
function popster_relative_time($time = false, $limit = 86400, $format = 'g:i A M jS') {
	if (empty($time) || (!is_string($time) && !is_numeric($time))) $time = time();
	elseif (is_string($time)) $time = strtotime($time);

	$now = time();
	$relative = '';

	if ($time === $now) $relative = esc_html__('now', 'popster');
	elseif ($time > $now) $relative = esc_html__('in the future', 'popster');
	else {
		$diff = $now - $time;

		/*if ($diff >= $limit) $relative = date($format, $time);
		else*/if ($diff < 60) {
			$relative = esc_html__('less than one minute ago', 'popster');
		} elseif (($minutes = ceil($diff/60)) < 60) {
			$relative = $minutes.' Minute'.(((int)$minutes === 1) ? '' : 's').' ago';
		} elseif ( $diff < (24*60*60) ){
			$hours = ceil($diff/3600);
			$relative = $hours.' Hour'.(((int)$hours === 1) ? '' : 's').' ago';
		}elseif ( $diff < (48*60*60) ){
			$hours = ceil($diff/3600);
			$relative = esc_html__('1 Day ago', 'popster');
		}else{
			$relative = ceil($diff / 86400) . ' Days ago';
		}
	}

	return $relative;
}

?>