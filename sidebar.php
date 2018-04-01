				<div id="sidebar1" class="clearfix" role="complementary">
				
					<?php if ( is_active_sidebar( 'sidebar1' ) ) : ?>

						<?php dynamic_sidebar( 'sidebar1' ); ?>

					<?php else : ?>

						<!-- This content shows up if there are no widgets defined in the backend. -->
						
						<div class="help">
						
							<p><?php esc_html_e('Please activate some Widgets.', 'popster'); ?></p>
						
						</div>

					<?php endif; ?>

				</div>