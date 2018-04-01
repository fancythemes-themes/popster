<?php 
/**
 * Template Name: Archives
 *
 * A custom page to serve archive
 *
*/

get_header(); 

?>
			
			<div id="content">
			
				<div id="inner-content" class="wrap clearfix">
			
					<div id="main" class="boxed clearfix" role="main">

					<?php 
						if ( function_exists('yoast_breadcrumb')) : 
							yoast_breadcrumb('<div id="breadcrumbs">','</div>'); 
						else : 
							popster_breadcrumb(); 
						endif; 
					?>
					<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
						<article id="id404" class="page hentry" role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
							<header>
							
								<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>                           

							</header> <!-- end article header -->
							
							<section class="post_content clearfix">
                            	<?php the_content(); ?>
								<h4><?php esc_html_e('Last 30 Posts', 'popster'); ?></h4>
								<ul>
								<?php
								$r = new WP_Query(array('showposts' => 30,'post_status' => 'publish', 'ignore_sticky_posts' => 1));
								while ($r->have_posts()) : $r->the_post();
								?>
									<li>
										<a href="<?php the_permalink() ?>"><?php the_title() ?></a>
									</li>
								<?php 
								endwhile;
								?>
								</ul>
								<h4><?php esc_html_e('Archives by Month:', 'popster'); ?></h4>
								<ul>
									<?php wp_get_archives('type=monthly'); ?>
								</ul>
								<!--<h4><?php esc_html_e('Archives by Subject:', 'popster'); ?></h4>
								<ul>
									<?php wp_list_categories( 'title_li=' ); ?>
								</ul>-->
							</section> <!-- end article section -->
					
						</article> <!-- end article -->
					<?php endwhile; endif; ?>					
					</div> <!-- end #main -->
    				
					<?php get_sidebar(); // sidebar 1 ?>
    			
    			</div> <!-- #inner-content -->
    			
			</div> <!-- end #content -->

<?php get_footer(); ?>