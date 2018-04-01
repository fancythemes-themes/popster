<?php 
get_header();
$theme_options = get_theme_mods('popster_options');
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

						<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix default-post'); ?> role="article" itemscope itemtype="http://schema.org/BlogPosting">

							<header>

								<h1 class="post-title" itemprop="headline"><?php the_title(); ?></h1>

								<!--<p class="meta"> <time datetime="<?php echo the_time('Y-m-d'); ?>"><?php the_time(get_option('date_format')); ?></time>, <?php the_author_posts_link(); ?>, <?php comments_popup_link(esc_html__('Leave a comment', 'popster'), esc_html__('1 Comment', 'popster'), esc_html__('% Comments', 'popster'),'', esc_html__('Comment closed', 'popster') ); ?></p>-->

							</header> <!-- end article header -->

                            <aside>
								<ul>
									<li><time datetime="<?php echo the_time('Y-m-d'); ?>"><span><?php the_time('j'); ?></span> <?php the_time('F Y'); ?></time></li>
									<li>
										<?php $gravatar = md5(get_the_author_meta('user_email')); $default = get_template_directory_uri().'/images/avatar.png'; ?>
										<img class="author-avatar alignleft" src="http://www.gravatar.com/avatar/<?php echo $gravatar; ?>?d=<?php echo $default; ?>&amp;s=50" style="margin-top:5px;" alt="author avatar"  />
										<span><?php esc_html_e('Written by', 'popster'); ?></span> <?php the_author_posts_link(); ?>
									</li>
									<li><span><?php esc_html_e('Categories', 'popster'); ?></span> <?php the_category(', '); ?></li>
									<li><?php the_tags('<span>Tags</span> ', ', ', ''); ?></li>
								</ul>
							</aside>					
							<section class="post_content clearfix" itemprop="articleBody">
	                        	<?php if ( get_post_format() == 'video' ) echo popster_video_post(); ?>
								<?php the_content(); ?>

							</section> <!-- end article section -->

							<footer>
								<?php wp_link_pages('before=<nav class="page-navigation">&after=</nav>&next_or_number=number&pagelink=page %'); ?>
								<?php if ( !isset($theme_options['disable_related_box']) || !$theme_options['disable_related_box'] ): ?>
								<div id="related-box" class="clearfix">
									<h4 class="widgettitle"><?php esc_html_e('Related Posts', 'popster'); ?></h4>
                                    <?php popster_related_posts(); ?>
								</div>
								<?php endif; ?>
							</footer> <!-- end article footer -->

						</article> <!-- end article -->

						<?php endwhile; ?>
							<?php comments_template(); ?>

						<?php else : ?>

						<article id="post-not-found">
						    <header>
						    	<h1>Not Found</h1>
						    </header>
						    <section class="post_content">
						    	<p>Sorry, but the requested resource was not found on this site.</p>
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