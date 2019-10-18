<?php
/*
 * This is the page users will see logged out.
 * You can edit this, but for upgrade safety you should copy and modify this file into your template folder.
 * The location from within your template folder is plugins/login-with-ajax/ (create these directories if they don't exist)
*/
?>
<div class="nk-sign-form-container lwa lwa-default"><?php //class must be here, and if this is a template, class name should be that of template directory ?>
    <!-- START: Login Form -->
    <form class="nk-sign-form-login active lwa-form" action="<?php echo esc_attr(LoginWithAjax::$url_login); ?>" method="post">
        <div>
            <h4 class="text-center"><?php echo esc_html__('Sign In', 'khaki');?></h4>

            <span class="lwa-status"></span>

            <span class="lwa-username">
                <span class="lwa-username-input">
                    <input class="form-control" type="text" placeholder="<?php echo esc_attr__('Username or Email', 'khaki');?>" name="log">
                </span>
            </span>

            <div class="nk-gap"></div>

            <span class="lwa-password">
                <span class="lwa-password-input">
                    <input class="form-control" type="password" placeholder="<?php echo esc_attr__('Password', 'khaki');?>" name="pwd">
                </span>
            </span>

            <div class="nk-gap"></div>

            <div class="lwa-submit">
                <div class="form-row align-items-center">
                    <div class="col-auto">
                        <div class="custom-control custom-checkbox float-left mr-sm-2">
                            <input type="checkbox" class="custom-control-input lwa-rememberme" name="rememberme" value="forever" id="remembermeLwa">
                            <label class="custom-control-label" for="remembermeLwa"><?php esc_html_e('Remember Me', 'khaki');?></label>
                        </div>
                    </div>
                    <div class="col lwa-submit-button">
                        <button class="nk-btn nk-btn-rounded nk-btn-color-white text-dark-1" name="wp-submit" id="lwa_wp-submit" value="<?php esc_attr_e('Log In', 'khaki'); ?>"><?php esc_html_e('Log In', 'khaki');?></button>
                        <input type="hidden" name="lwa_profile_link" value="<?php echo esc_attr($lwa_data['profile_link']); ?>" />
                        <input type="hidden" name="login-with-ajax" value="login" />
                        <?php if( !empty($lwa_data['redirect']) ): ?>
                            <input type="hidden" name="redirect_to" value="<?php echo esc_url($lwa_data['redirect']); ?>" />
                        <?php endif; ?>
                    </div>
                </div>
            </div>


            <div class="clearfix"></div>
            <div class="nk-gap"></div>
            <div class="text-right">
                <?php if ( get_option('users_can_register') && !empty($lwa_data['registration']) ) : ?>
                <a class="nk-sign-form-register-toggle" href="#"><?php esc_html_e('Register', 'khaki');?></a>
                |
                <?php endif; ?>
                <a class="nk-sign-form-lost-toggle" href="#"><?php esc_html_e('Lost Password?', 'khaki');?></a>
            </div>
        </div>
    </form>
    <!-- END: Login Form -->
    <?php if( !empty($lwa_data['remember']) && $lwa_data['remember'] == 1 ): ?>
    <!-- START: Lost Password Form -->
    <form class="nk-sign-form-lost lwa-remember" action="#" action="<?php echo esc_attr(LoginWithAjax::$url_remember) ?>" method="post">
        <div>
            <h4 class="text-center"><?php esc_html_e('Lost Password', 'khaki');?></h4>

            <span class="lwa-status"></span>

            <span class="lwa-remember-email">
                <?php $msg = __("Enter username or email", 'khaki'); ?>
                <input type="text" name="user_login" class="form-control lwa-user-remember" value="<?php echo esc_attr($msg); ?>" onfocus="if(this.value == '<?php echo esc_attr($msg); ?>'){this.value = '';}" onblur="if(this.value == ''){this.value = '<?php echo esc_attr($msg); ?>'}" />
                <?php do_action('lostpassword_form'); ?>
            </span>

            <div class="nk-gap"></div>

            <span class="lwa-remember-buttons">
                <button class="nk-btn nk-btn-rounded nk-btn-color-white text-dark-1 float-right lwa-button-remember"><?php esc_html_e('Get New Password', 'khaki');?></button>
                <input type="hidden" name="login-with-ajax" value="remember" />
            </span>

            <div class="clearfix"></div>
            <div class="nk-gap"></div>
            <a class="nk-sign-form-login-toggle float-right" href="#"><?php esc_html_e('Back to Log In', 'khaki');?></a>
        </div>
    </form>
    <!-- END: Lost Password Form -->
    <?php endif; ?>
    <?php if( get_option('users_can_register') && !empty($lwa_data['registration']) && $lwa_data['registration'] == 1 ): ?>
    <!-- START: Register Form -->
    <div class="nk-sign-form-register lwa-register">
        <form class="lwa-register-form" action="<?php echo esc_attr(LoginWithAjax::$url_register); ?>" method="post">
            <div>
                <h4 class="text-center"><?php esc_html_e('Register', 'khaki');?></h4>

                <span class="lwa-status"></span>

                <span class="lwa-username">
                        <input type="text" name="user_login" id="user_login" class="form-control" placeholder="<?php esc_attr_e('Username', 'khaki');?>"/>
                </span>

                <div class="nk-gap"></div>

                <span class="lwa-email">
                        <input type="text" name="user_email" id="user_email" class="form-control" placeholder="<?php esc_attr_e('Email', 'khaki');?>"/>
                </span>
                <?php do_action('register_form'); ?>
                <?php do_action('lwa_register_form'); ?>
                <div class="nk-gap"></div>

                <div class="lwa-register-tip"><?php esc_html_e('A password will be emailed to you.', 'khaki');?></div>
                <div class="nk-gap"></div>

                <span class="submit">
                    <button class="nk-btn nk-btn-rounded nk-btn-color-white text-dark-1 float-right" name="wp-submit" id="wp-submit" value="<?php esc_attr_e('Register', 'khaki'); ?>"><?php esc_html_e('Register', 'khaki'); ?></button>
                </span>
                <input type="hidden" name="login-with-ajax" value="register" />

                <div class="clearfix"></div>
                <div class="nk-gap"></div>
                <a class="nk-sign-form-login-toggle float-right" href="#"><?php esc_html_e('Back to Log In', 'khaki');?></a>
            </div>
        </form>
    </div>
    <!-- END: Register Form -->
    <?php endif; ?>
</div>
