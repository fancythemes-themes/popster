<!doctype html>  

<!--[if IEMobile 7 ]> <html <?php language_attributes(); ?> class="no-js iem7"> <![endif]-->
<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6 oldie"> <![endif]-->
<!--[if IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie7 oldie"> <![endif]-->
<!--[if IE 8 ]> <html <?php language_attributes(); ?> class="no-js ie8 oldie"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes(); ?> class="no-js"><!--<![endif]-->
	
	<?php $theme_options = get_theme_mod('popster_options'); ?>
	<head>
		<meta charset="utf-8">
		
		<!-- meta tags should be handled by SEO plugin. I reccomend (http://yoast.com/wordpress/seo/) -->
		
		<!-- mobile optimized -->
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<!-- allow pinned sites -->
		<meta name="application-name" content="<?php bloginfo('name'); ?>" />	
		
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
		
		<?php wp_head(); ?>
		
	</head>
	
	<body <?php body_class(); ?>>
		<div id="container">
			
			<header role="banner" class="header wrap">

				<div id="inner-header" class="clearfix">
				
					<!-- to use a image just replace the bloginfo('name') with your img src and remove the surrounding <p> -->
					<!--<p id="logo" class="h1 col620"><a href="<?php echo home_url(); ?>" rel="nofollow"><?php bloginfo('name'); ?></a></p>-->
					<!-- if you'd like to use the site description you can un-comment it below -->
					<nav role="navigation" class="nav clearfix">
						<?php popster_main_nav(); // Adjust using Menus in Wordpress Admin ?>
					</nav>
				<?php if ( is_active_sidebar( 'Header Sidebar' ) ) : ?>
					<div id="sidebar-top">
						<?php dynamic_sidebar( 'Header Sidebar' ); ?>
					</div>
				<?php endif; ?>
					<p id="logo" class="h1">
						<a href="<?php echo home_url(); ?>" rel="nofollow">
						<?php 
						if ( $theme_options['text_logo'] ){
							bloginfo('name'); 
							echo '<span class="meta">';
							bloginfo('description');
							echo '</span>';
						}else{
							if ( $theme_options['custom_logo'] )
								echo '<img src="' . esc_url( $theme_options['custom_logo'] ) . '" alt="' . get_bloginfo('name'). '" />';
							else
								echo '<img src="' . get_template_directory_uri() . '/images/logo.png" alt="' . get_bloginfo('name'). '" />';
						}
						?>
						</a>
                    </p>
				<?php if ( !is_active_sidebar( 'Header Sidebar' ) ) : ?>
					<div id="search-header" class="right">
                    	<?php get_search_form(); ?>
                    </div>					
				<?php endif; ?>
				
				</div> <!-- end #inner-header -->
			
			</header> <!-- end header -->
