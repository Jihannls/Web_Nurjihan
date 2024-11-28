<?php

// if password is required
if ( post_password_required() ) {
	return;
}

// if post has comments
if ( have_comments() ) : ?>

	<h2  class="comment-title">
		<?php comments_number( esc_html__( '0 Comments', 'st-resume' ), esc_html__( 'One Comment', 'st-resume' ), esc_html__( '% Comments', 'st-resume' ) ); ?>
	</h2>
	
	<ul class="commentslist" >
		<?php wp_list_comments(); ?>
	</ul>

	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
	<div class="comments-nav-section">					
		<p class="fl"></p>
		<p class="fr"></p>

		<div>				
			<div class="default-previous">
			<?php  previous_comments_link( '&#8592;&nbsp;'. esc_html__( 'Older Comments', 'st-resume' )  ); ?>
			</div>

			<div class="default-next">
				<?php  next_comments_link( esc_html__( 'Newer Comments', 'st-resume' ) . '&nbsp;&#8594;'  ); ?>
			</div>
		</div>
	</div>
<?php
	endif;

// have_comments()
endif;

// Form
comment_form([
	'title_reply' => esc_html__( 'Leave a Reply', 'st-resume' ),
	'comment_field' => '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Comment', 'st-resume' ) . '</label><textarea name="comment" id="comment" cols="45" rows="8"  maxlength="65525" required="required" spellcheck="false"></textarea></p>',
	'label_submit' => esc_html__( 'Post Comment', 'st-resume' )
]);

?>