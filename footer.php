<?php
$theme_options = get_theme_mod('popster_options');
?>
			<footer role="contentinfo" class="footer">
				<div id="inner-footer" class="wrap clearfix">
					
					<div class="attribution col940">
                    	<nav>
							<?php popster_footer_links(); // Adjust using Menus in Wordpress Admin ?>
						</nav>
						<?php if ( isset($theme_options['footer_credit_text']) && $theme_options['footer_credit_text'] ): ?>
						<p><?php echo $theme_options['footer_credit_text'] ?></p>
						<?php else: ?>
						<p>&copy; <?php bloginfo('name'); ?> <?php _e('is powered by', 'popster'); ?> <a href="http://wordpress.org/" title="WordPress"><?php esc_html_e('WordPress', 'popster'); ?></a> &amp; <a href="http://www.popster.com" title="popster" class="footer_bones_link"><?php _e('CircaThemes', 'popster'); ?></a>.</p>
						<?php endif; ?>
					</div> 
				
				</div> <!-- end #inner-footer -->
				
			</footer> <!-- end footer -->
		
		</div> <!-- end #container-->
		<?php wp_footer(); // js scripts are inserted using this function ?>

	</body>

</html>