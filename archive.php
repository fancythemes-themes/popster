<?php get_header(); ?>

			<div id="content">
				<?php
				$current_page = get_query_var('paged');
				?>
				<div id="inner-content" class="wrap clearfix">
					<div id="main" class="boxed clearfix" role="main">
						<?php 
						if ( function_exists('yoast_breadcrumb')) : 
							yoast_breadcrumb('<div id="breadcrumbs">','</div>'); 
						else : 
							popster_breadcrumb(); 
						endif; 
						?>
						<!--<h4 class="widgettitle"><span>Recent Posts</span></h4>-->
						<?php if (have_posts()) : $i = 1; while ( have_posts() ) : the_post(); ?>

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article">

								<?php if (has_post_thumbnail()): ?>
								<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="home-thumb"><?php the_post_thumbnail('thumbnail'); ?></a>
								<?php else : 
										if ( get_post_format() == 'video'){
											$video_options = get_post_meta(get_the_ID(), '_popster_video_options', true );
											if ( $video_options['video_provider'] == 'youtube' ){ ?>
											<a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>" class="home-thumb"><img src="http://img.youtube.com/vi/<?php echo $video_options['video_id']; ?>/hqdefault.jpg" /></a>	
								<?php		}
										}
								?>
								<?php endif; ?>

							<header>
								<div class="category-meta"><?php the_category(', '); ?></div>
								<div class="meta"><time datetime="<?php echo the_time('Y-m-d'); ?>"><?php the_time(get_option('date_format')); ?></time><!--, 
									<?php the_author_posts_link(); ?>, 	
									<?php comments_popup_link( 
										esc_html__('No Comment', 'popster'),
										esc_html__('1 Comment', 'popster'),
										esc_html__('% Comment', 'popster'),
										'',
										esc_html__('Comment Closed') ); ?>-->
								</div>
								<h2 class="post-title h3"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
								


							</header> <!-- end article header -->

							<section class="post_content clearfix">
								<?php the_excerpt(); ?>
								<p class="read-more"><a href="<?php the_permalink() ?>"><?php _e('Read Post', 'popster'); ?></a></p>
							</section> <!-- end article section -->							
						
						</article> <!-- end article -->
						
						<?php comments_template(); ?>
						<?php 	$i++; ?>
						<?php endwhile; ?>	
						
						<?php 
							if (function_exists('popster_pagenavi')) { 
									popster_pagenavi();
							} else { // if it is disabled, display regular wp prev & next links ?>

							<nav class="wp-prev-next">
								<ul class="clearfix">
									<li class="prev-link"><?php next_posts_link(__('&laquo; Older Entries', 'popster')) ?></li>
									<li class="next-link"><?php previous_posts_link(__('Newer Entries &raquo;', 'popster')) ?></li>
								</ul>
							</nav>
						<?php } ?>		
						
						<?php else : ?>
						
						<article id="post-not-found">
						    <header>
						    	<h1><?php esc_html_e('Not Found', 'popster'); ?></h1>
						    </header>
						    <section class="post_content">
						    	<p><?php esc_html_e('Sorry, but the requested resource was not found on this site.', 'popster'); ?></p>
						    </section>
						    <footer>
						    </footer>
						</article>
						
						<?php endif; ?>
					
					</div> <!-- end #main -->
					<?php get_sidebar();  ?>
					
				</div> <!-- end #inner-content -->
    
			</div> <!-- end #content -->

<?php get_footer(); ?>