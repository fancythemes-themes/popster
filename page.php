<?php get_header(); ?>
			
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

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix post'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">
						
							<header>
							
								<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>
                                
													
							</header> <!-- end article header -->
							
							<section class="post_content clearfix" itemprop="articleBody">
	                        	<?php if ( get_post_format() == 'video' ) echo popster_video_post(); ?>
								<?php the_content(); ?>
					
							</section> <!-- end article section -->						
					
						</article> <!-- end article -->
						
						<?php endwhile; ?>			
							<?php comments_template(); ?>
						
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
    				
					<?php get_sidebar(); // sidebar 1 ?>
    			
    			</div> <!-- #inner-content -->
    			
			</div> <!-- end #content -->

<?php get_footer(); ?>