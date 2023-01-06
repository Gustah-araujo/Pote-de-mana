<?php
/**
 * Comments template.
 *
 * @package Sapid
 * @subpackage Templates
 */

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'Direct script access denied.' );
}

do_action( 'sapid_before_comments' );

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
}
?>

<?php if ( have_comments() ) : ?>

	<div id="comments" class="comments-container">
		<?php ob_start(); ?>
		<h3><?php comments_number( esc_html__( 'No Comments', 'Sapid' ), esc_html__( 'One Comment', 'Sapid' ), esc_html( _n( '% Comment', '% Comments', get_comments_number(), 'Sapid' ) ) ); ?></h3>

		<ol class="comment-list commentlist list-unstyled with-noborder m-t-30">
			<?php wp_list_comments( 'callback=sapid_comment'); ?>
		</ol><!-- .comment-list -->
	</div>

<?php endif; ?>

<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'Sapid' ); ?></p>
<?php endif; ?>

<?php if ( comments_open() ) : ?>
	<?php
	$commenter = wp_get_current_commenter();
	$req       = get_option( 'require_name_email' );
	$aria_req  = ( $req ) ? ' aria-required="true"' : '';
	$html_req  = ( $req ) ? ' required="required"' : '';
	$name      = ( $req ) ? __( 'Name (required)', 'Sapid' ) : __( 'Name', 'Sapid' );
	$email     = ( $req ) ? __( 'Email (required)', 'Sapid' ) : __( 'Email', 'Sapid' );
	$html5     = ( 'html5' === current_theme_supports( 'html5', 'comment-form' ) ) ? 'html5' : 'xhtml';
	$consent   = empty( $commenter['comment_author_email'] ) ? '' : ' checked="checked"';

	$fields = [];

	$fields['author'] = '<div class="form-group col-md-4" id="comment-input"><input id="author" class="form-control" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" placeholder="' . esc_attr( $name ) . '" size="30"' . $aria_req . $html_req . ' aria-label="' . esc_attr( $name ) . '"/></div>';
	$fields['email']  = '<div class="form-group col-md-4" id="comment-input-email"><input id="email" class="form-control" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_email'] ) . '" placeholder="' . esc_attr( $email ) . '" size="30" ' . $aria_req . $html_req . ' aria-label="' . esc_attr( $email ) . '"/></div>';
	$fields['url']    = '<div class="form-group col-md-4" id="comment-input-website"><input id="url" class="form-control" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" placeholder="' . esc_html__( 'Website', 'Sapid' ) . '" size="30" aria-label="' . esc_attr__( 'URL', 'Sapid' ) . '" /></div>';
	if ( get_option( 'show_comments_cookies_opt_in' ) ) {
		$fields['cookies'] = '<p class="comment-form-cookies-consent"><input id="wp-comment-cookies-consent" name="wp-comment-cookies-consent" type="checkbox" value="yes"' . $consent . ' /><label for="wp-comment-cookies-consent">' . esc_html__( 'Save my name, email, and website in this browser for the next time I comment.', 'Sapid' ) . '</label></p>';
	}

	$comments_args = [
		'fields'               => apply_filters( 'comment_form_default_fields', $fields ),
		'comment_field'        => '<div id="comment-textarea" class="form-group col-md-12 "><textarea name="comment" id="comment" cols="45" rows="5" aria-required="true" required="required" tabindex="0" class="form-control textarea-comment" placeholder="' . esc_html__( 'Comment...', 'Sapid' ) . '"></textarea></div>',
		'title_reply'          => esc_html__( 'Leave A Comment', 'Sapid' ),
		'title_reply_to'       => esc_html__( 'Leave A Comment', 'Sapid' ),
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h3>',
		/* translators: Opening and closing link tags. */
		'must_log_in'          => '<p class="must-log-in">' . sprintf( esc_html__( 'You must be %1$slogged in%2$s to post a comment.', 'Sapid' ), '<a href="' . wp_login_url( apply_filters( 'the_permalink', get_permalink() ) ) . '">', '</a>' ) . '</p>',
		/* translators: %1$s: The username. %2$s and %3$s: Opening and closing link tags. */
		'logged_in_as'         => '<p class="logged-in-as">' . sprintf( esc_html__( 'Logged in as %1$s. %2$sLog out &raquo;%3$s', 'Sapid' ), '<a href="' . admin_url( 'profile.php' ) . '">' . $user_identity . '</a>', '<a href="' . wp_logout_url( apply_filters( 'the_permalink', get_permalink() ) ) . '" title="' . esc_html__( 'Log out of this account', 'Sapid' ) . '">', '</a>' ) . '</p>',
		'comment_notes_before' => '',
		'class_form'           => 'row',
		'id_submit'            => 'comment-submit',
		'class_submit'         => 'sapid-button main-solid-btn',
		'label_submit'         => esc_html__( 'Post Comment', 'Sapid' ),
	];
	echo '<div class="mini-spacer pt-3">';
		comment_form( $comments_args );
	echo'</div>';
endif;
