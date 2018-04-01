<?php

// Do not delete these lines
  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
    die ('Please do not load this page directly. Thanks!');

  if ( post_password_required() ) { ?>
  	<div class="help">
    	<p class="nocomments"><?php esc_html_e('This post is password protected. Enter the password to view comments.', 'popster'); ?></p>
  	</div>
  <?php
    return;
  }
?>

<!-- You can start editing here. -->
<div class="clearfix" style="display:block; height:3px; width:100%;">&nbsp;</div>
<?php if ( have_comments() ) : ?>
	
	<h3 id="comments" class="widgettitle"><?php comments_number(esc_html__('No Responses', 'popster'), esc_html__('One Response', 'popster'), esc_html__('% Responses', 'popster') );?></h3>

	<nav id="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link() ?></li>
	  		<li><?php next_comments_link() ?></li>
	 	</ul>
	</nav>
	
	<ol class="commentlist">
		<?php wp_list_comments('type=comment&callback=popster_comments'); ?>
	</ol>
	
	<nav id="comment-nav">
		<ul class="clearfix">
	  		<li><?php previous_comments_link() ?></li>
	  		<li><?php next_comments_link() ?></li>
		</ul>
	</nav>
  
	<?php else : // this is displayed if there are no comments so far ?>

	<?php if ( comments_open() ) : ?>
    	<!-- If comments are open, but there are no comments. -->

	<?php else : // comments are closed ?>
	<!-- If comments are closed.
	<p class="nocomments">Comments are closed.</p> -->

	<?php endif; ?>

<?php endif; ?>


<?php if ( comments_open() ) : ?>
	
		<?php 

		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );
		
		$fields =  array(	'author' => '<p class="comment-form-author comment-field shadow-inset">' . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" placeholder="' . esc_html__('Your Name', 'popster') . ( $req ? ' *' : '' ) . '" ' . $aria_req . ' /></p>',
							'email'  => '<p class="comment-form-email comment-field shadow-inset">' . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" placeholder="' . esc_html__( 'Your Email', 'popster' ) . ( $req ? ' *' : '' ) . '" ' . $aria_req . ' /></p>',
							'url'    => '<p class="comment-form-url comment-field shadow-inset">' . '<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" placeholder="' . esc_html__( 'Your Website', 'popster' ) . '" /></p>'  );
		$comment_field = '<textarea name="comment" id="comment" placeholder="' . esc_html__( 'Your Comment Here...', 'popster') . '" class="shadow-inset" tabindex="4"></textarea>';					
		comment_form( array ('fields' => apply_filters( 'comment_form_default_fields', $fields ), 'comment_field' => $comment_field, 'comment_notes_before' => '', 'comment_notes_after' => '<p class="required-attr meta">' . esc_html__('(*) Required, Your email will not be published', 'popster') . '</p>' ) );
		?>

<?php endif; // if you delete this the sky will fall on your head ?>
