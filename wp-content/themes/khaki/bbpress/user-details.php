<?php

/**
 * User Details
 *
 * @package bbPress
 * @subpackage Theme
 */

?>
        <aside class="nk-sidebar nk-sidebar-left nk-sidebar-sticky">
            <div>
                <?php do_action('bbp_template_before_user_details'); ?>
                <div id="bbp-single-user-details">
                    <div id="bbp-user-navigation">
                            <div class="nk-gap-4"></div>
                                <div class="nk-doc-links">
                                    <ul>
                                        <li class="<?php if (bbp_is_single_user_profile()) : ?>active<?php endif; ?>">
                                            <a class="url fn n" href="<?php bbp_user_profile_url(); ?>"
                                               title="<?php printf(esc_attr__("%s's Profile", 'khaki'), bbp_get_displayed_user_field('display_name')); ?>"
                                               rel="me"><?php esc_html_e('Profile', 'khaki'); ?></a>
                                        </li>

                                        <li class="<?php if (bbp_is_single_user_topics()) : ?>active<?php endif; ?>">
                                            <a href="<?php bbp_user_topics_created_url(); ?>"
                                               title="<?php printf(esc_attr__("%s's Topics Started", 'khaki'), bbp_get_displayed_user_field('display_name')); ?>"><?php esc_html_e('Topics Started', 'khaki'); ?></a>
                                        </li>

                                        <li class="<?php if (bbp_is_single_user_replies()) : ?>active<?php endif; ?>">
                                            <a href="<?php bbp_user_replies_created_url(); ?>"
                                               title="<?php printf(esc_attr__("%s's Replies Created", 'khaki'), bbp_get_displayed_user_field('display_name')); ?>"><?php esc_html_e('Replies Created', 'khaki'); ?></a>
                                        </li>

                                        <?php if (bbp_is_favorites_active()) : ?>
                                            <li class="<?php if (bbp_is_favorites()) : ?>active<?php endif; ?>">
                                                <a href="<?php bbp_favorites_permalink(); ?>"
                                                   title="<?php printf(esc_attr__("%s's Favorites", 'khaki'), bbp_get_displayed_user_field('display_name')); ?>"><?php esc_html_e('Favorites', 'khaki'); ?></a>
                                            </li>
                                        <?php endif; ?>

                                        <?php if (bbp_is_user_home() || current_user_can('edit_users')) : ?>

                                            <?php if (bbp_is_subscriptions_active()) : ?>
                                                <li class="<?php if (bbp_is_subscriptions()) : ?>active<?php endif; ?>">
                                                    <a href="<?php bbp_subscriptions_permalink(); ?>"
                                                       title="<?php printf(esc_attr__("%s's Subscriptions", 'khaki'), bbp_get_displayed_user_field('display_name')); ?>"><?php esc_html_e('Subscriptions', 'khaki'); ?></a>
                                                </li>
                                            <?php endif; ?>

                                            <li class="<?php if (bbp_is_single_user_edit()) : ?>active<?php endif; ?>">
                                                <a href="<?php bbp_user_profile_edit_url(); ?>"
                                                   title="<?php printf(esc_attr__("Edit %s's Profile", 'khaki'), bbp_get_displayed_user_field('display_name')); ?>"><?php esc_html_e('Edit', 'khaki'); ?></a>
                                            </li>

                                        <?php endif; ?>

                                    </ul>
                                </div>
                            <div class="nk-gap-4"></div>
                    </div><!-- #bbp-user-navigation -->
                </div><!-- #bbp-single-user-details -->
                <?php do_action('bbp_template_after_user_details'); ?>
            </div>
        </aside>
