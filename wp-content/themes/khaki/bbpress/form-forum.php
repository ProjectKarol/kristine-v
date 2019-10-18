<?php

/**
 * New/Edit Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php if ( bbp_is_forum_edit() ) : ?>

<div id="bbpress-forums">

	<?php bbp_single_forum_description( array( 'forum_id' => bbp_get_forum_id() ) ); ?>

<?php endif; ?>

<?php if ( bbp_current_user_can_access_create_forum_form() ) : ?>

	<div id="new-forum-<?php bbp_forum_id(); ?>" class="bbp-forum-form nk-box-3 bg-gray-3">

		<form id="new-post" name="new-post" method="post" action="<?php the_permalink(); ?>" class="nk-form nk-form-style-1">

			<?php do_action( 'bbp_theme_before_forum_form' ); ?>

			<fieldset class="bbp-form">
				<legend>

					<?php
						if ( bbp_is_forum_edit() )
							printf( esc_html__( 'Now Editing &ldquo;%s&rdquo;', 'khaki' ), bbp_get_forum_title() );
						else
							bbp_is_single_forum() ? printf( esc_html__( 'Create New Forum in &ldquo;%s&rdquo;', 'khaki' ), bbp_get_forum_title() ) : esc_html_e( 'Create New Forum', 'khaki' );
					?>

				</legend>

				<?php do_action( 'bbp_theme_before_forum_form_notices' ); ?>

				<?php if ( !bbp_is_forum_edit() && bbp_is_forum_closed() ) : ?>

                    <div class="nk-info-box bg-main-1"><div class="nk-info-box-icon"><span class="ion-ios-information-circle"></span></div>
					<?php esc_html_e( 'This forum is closed to new content, however your account still allows you to do so.', 'khaki' ); ?>
					</div>

				<?php endif; ?>

				<?php if ( current_user_can( 'unfiltered_html' ) ) : ?>

                    <div class="nk-info-box bg-main-1"><div class="nk-info-box-icon"><span class="ion-ios-information-circle"></span></div>
						<?php esc_html_e( 'Your account has the ability to post unrestricted HTML content.', 'khaki' ); ?>
					</div>

				<?php endif; ?>

				<?php //do_action( 'bbp_template_notices' ); ?>
				<?php do_action('khaki_bbp_template_notices'); ?>
				<div>

					<?php do_action( 'bbp_theme_before_forum_form_title' ); ?>

					<p>
						<input type="text" id="bbp_forum_title" value="<?php bbp_form_forum_title(); ?>" tabindex="<?php bbp_tab_index(); ?>" size="40" name="bbp_forum_title" maxlength="<?php bbp_title_max_length(); ?>" class="form-control" placeholder="<?php printf( esc_html__( 'Forum Name (Maximum Length: %d):', 'khaki' ), bbp_get_title_max_length() ); ?>"/>
					</p>

					<?php do_action( 'bbp_theme_after_forum_form_title' ); ?>

					<?php do_action( 'bbp_theme_before_forum_form_content' ); ?>

					<?php bbp_the_content( array( 'context' => 'forum' ) ); ?>

					<?php do_action( 'bbp_theme_after_forum_form_content' ); ?>

					<?php if ( ! ( bbp_use_wp_editor() || current_user_can( 'unfiltered_html' ) ) ) : ?>

						<p class="form-allowed-tags">
							<label><?php esc_html_e( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:','khaki' ); ?></label><br />
							<code><?php bbp_allowed_tags(); ?></code>
						</p>

					<?php endif; ?>

					<?php do_action( 'bbp_theme_before_forum_form_type' ); ?>

					<p>
						<label for="bbp_forum_type"><?php esc_html_e( 'Forum Type:', 'khaki' ); ?></label><br />
						<?php bbp_form_forum_type_dropdown(); ?>
					</p>

					<?php do_action( 'bbp_theme_after_forum_form_type' ); ?>

					<?php do_action( 'bbp_theme_before_forum_form_status' ); ?>

					<p>
						<label for="bbp_forum_status"><?php esc_html_e( 'Status:', 'khaki' ); ?></label><br />
						<?php bbp_form_forum_status_dropdown(); ?>
					</p>

					<?php do_action( 'bbp_theme_after_forum_form_status' ); ?>

					<?php do_action( 'bbp_theme_before_forum_form_status' ); ?>

					<p>
						<label for="bbp_forum_visibility"><?php esc_html_e( 'Visibility:', 'khaki' ); ?></label><br />
						<?php bbp_form_forum_visibility_dropdown(); ?>
					</p>

					<?php do_action( 'bbp_theme_after_forum_visibility_status' ); ?>

					<?php do_action( 'bbp_theme_before_forum_form_parent' ); ?>

						<label for="bbp_forum_parent_id"><?php esc_html_e( 'Parent Forum:', 'khaki' ); ?></label><br />

						<?php
							bbp_dropdown( array(
								'select_id' => 'bbp_forum_parent_id',
								'show_none' => esc_html__( '(No Parent)', 'khaki' ),
								'selected'  => bbp_get_form_forum_parent(),
								'exclude'   => bbp_get_forum_id()
							) );
						?>

					<?php do_action( 'bbp_theme_after_forum_form_parent' ); ?>

					<?php do_action( 'bbp_theme_before_forum_form_submit_wrapper' ); ?>

					<div class="bbp-submit-wrapper">

						<?php do_action( 'bbp_theme_before_forum_form_submit_button' ); ?>

						<button type="submit" tabindex="<?php bbp_tab_index(); ?>" id="bbp_forum_submit" name="bbp_forum_submit" class="nk-btn nk-btn-effect-2-right nk-btn-color-dark-1">
							<span><?php esc_html_e( 'Submit', 'khaki' ); ?></span>
							<span class="icon"><span class="ion-ios-undo"></span></span></button>

						<?php do_action( 'bbp_theme_after_forum_form_submit_button' ); ?>

					</div>

					<?php do_action( 'bbp_theme_after_forum_form_submit_wrapper' ); ?>

				</div>

				<?php bbp_forum_form_fields(); ?>

			</fieldset>

			<?php do_action( 'bbp_theme_after_forum_form' ); ?>

		</form>
	</div>

<?php elseif ( bbp_is_forum_closed() ) : ?>

	<div id="no-forum-<?php bbp_forum_id(); ?>" class="bbp-no-forum">
		<div class="bbp-template-notice">
			<p><?php printf( esc_html__( 'The forum &#8216;%s&#8217; is closed to new content.', 'khaki' ), bbp_get_forum_title() ); ?></p>
		</div>
	</div>

<?php else : ?>

	<div id="no-forum-<?php bbp_forum_id(); ?>" class="bbp-no-forum">
		<div class="bbp-template-notice">
			<p><?php is_user_logged_in() ? esc_html_e( 'You cannot create new forums.', 'khaki' ) : esc_html_e( 'You must be logged in to create new forums.', 'khaki' ); ?></p>
		</div>
	</div>

<?php endif; ?>

<?php if ( bbp_is_forum_edit() ) : ?>

</div>

<?php endif; ?>
