<?php

/**
 * Edit Topic Tag
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php if ( current_user_can( 'edit_topic_tags' ) ) : ?>

	<div id="edit-topic-tag-<?php bbp_topic_tag_id(); ?>" class="bbp-topic-tag-form">

		<fieldset class="bbp-form" id="bbp-edit-topic-tag">

			<legend><?php printf( esc_html__( 'Manage Tag: "%s"', 'khaki' ), bbp_get_topic_tag_name() ); ?></legend>

			<fieldset class="bbp-form" id="tag-rename">

				<legend><?php echo esc_html__( 'Rename', 'khaki' ); ?></legend>

				<div class="bbp-template-notice info">
					<p><?php echo esc_html__( 'Leave the slug empty to have one automatically generated.', 'khaki' ); ?></p>
				</div>

				<div class="bbp-template-notice">
					<p><?php echo esc_html__( 'Changing the slug affects its permalink. Any links to the old slug will stop working.', 'khaki' ); ?></p>
				</div>

				<form id="rename_tag" name="rename_tag" method="post" action="<?php the_permalink(); ?>">

					<div>
						<label for="tag-name"><?php echo esc_html__( 'Name:', 'khaki' ); ?></label>
						<input type="text" id="tag-name" name="tag-name" size="20" maxlength="40" tabindex="<?php bbp_tab_index(); ?>" value="<?php echo esc_attr( bbp_get_topic_tag_name() ); ?>" />
					</div>

					<div>
						<label for="tag-slug"><?php echo esc_html__( 'Slug:', 'khaki' ); ?></label>
						<input type="text" id="tag-slug" name="tag-slug" size="20" maxlength="40" tabindex="<?php bbp_tab_index(); ?>" value="<?php echo esc_attr( apply_filters( 'editable_slug', bbp_get_topic_tag_slug() ) ); ?>" />
					</div>

					<div class="bbp-submit-wrapper">
						<button type="submit" tabindex="<?php bbp_tab_index(); ?>" class="button submit"><?php esc_attr_e( 'Update', 'khaki' ); ?></button>

						<input type="hidden" name="tag-id" value="<?php bbp_topic_tag_id(); ?>" />
						<input type="hidden" name="action" value="bbp-update-topic-tag" />

						<?php wp_nonce_field( 'update-tag_' . bbp_get_topic_tag_id() ); ?>

					</div>
				</form>

			</fieldset>

			<fieldset class="bbp-form" id="tag-merge">

				<legend><?php echo esc_html__( 'Merge', 'khaki' ); ?></legend>

				<div class="bbp-template-notice">
					<p><?php echo esc_html__( 'Merging tags together cannot be undone.', 'khaki' ); ?></p>
				</div>

				<form id="merge_tag" name="merge_tag" method="post" action="<?php the_permalink(); ?>">

					<div>
						<label for="tag-existing-name"><?php echo esc_html__( 'Existing tag:', 'khaki' ); ?></label>
						<input type="text" id="tag-existing-name" name="tag-existing-name" size="22" tabindex="<?php bbp_tab_index(); ?>" maxlength="40" />
					</div>

					<div class="bbp-submit-wrapper">
						<button type="submit" tabindex="<?php bbp_tab_index(); ?>" class="button submit" onclick="return confirm('<?php echo esc_js( sprintf( esc_html__( 'Are you sure you want to merge the "%s" tag into the tag you specified?', 'khaki' ), bbp_get_topic_tag_name() ) ); ?>');"><?php esc_attr_e( 'Merge', 'khaki' ); ?></button>

						<input type="hidden" name="tag-id" value="<?php bbp_topic_tag_id(); ?>" />
						<input type="hidden" name="action" value="bbp-merge-topic-tag" />

						<?php wp_nonce_field( 'merge-tag_' . bbp_get_topic_tag_id() ); ?>
					</div>
				</form>

			</fieldset>

			<?php if ( current_user_can( 'delete_topic_tags' ) ) : ?>

				<fieldset class="bbp-form" id="delete-tag">

					<legend><?php echo esc_html__( 'Delete', 'khaki' ); ?></legend>

					<div class="bbp-template-notice info">
						<p><?php echo esc_html__( 'This does not delete your topics. Only the tag itself is deleted.', 'khaki' ); ?></p>
					</div>
					<div class="bbp-template-notice">
						<p><?php echo esc_html__( 'Deleting a tag cannot be undone.', 'khaki' ); ?></p>
						<p><?php echo esc_html__( 'Any links to this tag will no longer function.', 'khaki' ); ?></p>
					</div>

					<form id="delete_tag" name="delete_tag" method="post" action="<?php the_permalink(); ?>">

						<div class="bbp-submit-wrapper">
							<button type="submit" tabindex="<?php bbp_tab_index(); ?>" class="button submit" onclick="return confirm('<?php echo esc_js( sprintf( esc_html__( 'Are you sure you want to delete the "%s" tag? This is permanent and cannot be undone.', 'khaki' ), bbp_get_topic_tag_name() ) ); ?>');"><?php esc_attr_e( 'Delete', 'khaki' ); ?></button>

							<input type="hidden" name="tag-id" value="<?php bbp_topic_tag_id(); ?>" />
							<input type="hidden" name="action" value="bbp-delete-topic-tag" />

							<?php wp_nonce_field( 'delete-tag_' . bbp_get_topic_tag_id() ); ?>
						</div>
					</form>

				</fieldset>

			<?php endif; ?>

		</fieldset>
	</div>

<?php endif; ?>
