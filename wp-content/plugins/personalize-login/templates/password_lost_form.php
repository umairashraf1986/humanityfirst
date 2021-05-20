<div class="row justify-content-center">
    <div class="col-xl-6 col-lg-12">
        <div id="password-lost-form" class="widecolumn">
            <?php if ( $attributes['show_title'] ) : ?>
                <h3><?php _e( 'Forgot Your Password?', 'personalize-login' ); ?></h3>
            <?php endif; ?>

            <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
                <?php foreach ( $attributes['errors'] as $error ) : ?>
                    <div class="alert alert-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <div class="alert alert-info">
                <?php
                    _e(
                        "Enter your email address and we'll send you a link you can use to pick a new password.",
                        'personalize_login'
                    );
                ?>
            </div>

            <form id="lostpasswordform" action="<?php echo wp_lostpassword_url(); ?>" method="post">
                <div class="form-group">
                    <label for="user_login"><?php _e( 'Email *', 'personalize-login' ); ?></label>
                    <input type="text" name="user_login" id="user_login" class="form-control">
                </div>

                <p class="lostpassword-submit">
                    <input type="submit" name="submit" class="lostpassword-button btn btn-green"
                           value="<?php _e( 'Reset Password', 'personalize-login' ); ?>"/>
                </p>
            </form>
        </div>
    </div>
</div>