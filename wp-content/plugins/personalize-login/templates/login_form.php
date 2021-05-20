<?php if ( true ) : ?>
  <div class="row justify-content-center">
    <div class="col-xl-6 col-lg-12">
      <div class="login-form-container">
       <?php if ( $attributes['show_title'] ) : ?>
        <h2><?php _e( 'Sign In', 'personalize-login' ); ?></h2>
      <?php endif; ?>

      <!-- Show errors if there are any -->
      <?php if ( count( $attributes['errors'] ) > 0 ) : ?>
        <?php foreach ( $attributes['errors'] as $error ) : ?>
          <div class="alert alert-danger">
            <?php echo $error; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>

      <!-- Show logged out message if user just logged out -->
      <?php if ( $attributes['logged_out'] ) : ?>
        <div class="alert alert-info">
         <?php _e( 'You have signed out. Would you like to sign in again?', 'personalize-login' ); ?>
       </div>
     <?php endif; ?>

     <?php if ( $attributes['registered'] ) : ?>
      <div class="alert alert-success">
       <?php
       printf(
         __( 'You have successfully registered to <strong>%s</strong>. Use your email and password to login.', 'personalize-login' ),
         get_bloginfo( 'name' )
       );
       ?>
     </div>
   <?php endif; ?>

   <?php if ( $attributes['lost_password_sent'] ) : ?>
    <div class="alert alert-info">
     <?php _e( 'Check your email for a link to reset your password.', 'personalize-login' ); ?>
   </div>
 <?php endif; ?>

 <?php if ( $attributes['password_updated'] ) : ?>
  <div class="alert alert-success">
   <?php _e( 'Your password has been changed. You can sign in now.', 'personalize-login' ); ?>
 </div>
<?php endif; ?>

<?php
     // wp_login_form(
     //     array(
     //         'label_username' => __( 'Email', 'personalize-login' ),
     //         'label_log_in' => __( 'Sign In', 'personalize-login' ),
     //         'redirect' => $attributes['redirect'],
     //     )
     // );
?>

<?php
$url = wp_login_url();
$parts = parse_url($url);
if(isset($parts['query'])) {
  parse_str($parts['query'], $query);
  if(!isset($query['wpe-login'])) {
    $url .= "&wpe-login=true";
  }
} else {
  $url .= "?wpe-login=true";
}
?>

<div class="login-form-container">
  <form method="post" action="<?php echo $url; ?>" id="loginform" name="loginform">
    <div class="form-group">
      <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?></label>
      <input type="text" class="form-control" name="log" id="user_login">
    </div>
    <div class="form-group">
      <label for="user_pass"><?php _e( 'Password', 'personalize-login' ); ?></label>
      <input type="password" class="form-control" name="pwd" id="user_pass">
    </div>
    <div class="sign-in-container">
      <input name="redirect_to" value="<?php echo !empty($_GET['redirect_to']) ? $_GET['redirect_to'] : ''; ?>" type="hidden">
      <button type="submit" id="wp-submit" name="wp-submit" class="btn btn-green">Sign In</button>
      <span>or</span>
      <a href="<?php echo home_url('/member-register'); ?>">Sign Up</a>
    </div>
  </form>

  <div class="form-group">
    <a class="forgot-password" href="<?php echo wp_lostpassword_url(); ?>">
      <?php _e( 'Forgot your password?', 'personalize-login' ); ?>
    </a>
  </div>

  <div class="row">
    <div class="col-12 col-md-12">
      <div class="form-group">
        <a class="btn btn-block btn-login-fb py-2" href="javascript:void(0);">
          <i class="fa fa-facebook-square d-inline-block" aria-hidden="true"></i>
          <div class="btn-text d-inline-block">Login with Facebook</div>
        </a>
      </div>
    </div>
    <!-- <div class="col-12 col-md-6">
      <div class="form-group">
        <a class="btn btn-block btn-login-google py-2" href="javascript:void(0);">
          <i class="fa fa-google-plus-square d-inline-block" aria-hidden="true"></i>
          <span class="btn-text d-inline-block">Login with Google+</span>
        </a>
      </div>
    </div> -->
  </div>
</div>
</div>
</div>
</div>
<?php else : ?>
  <div class="login-form-container">
    <form method="post" action="<?php echo wp_login_url(); ?>">
      <p class="login-username">
        <label for="user_login"><?php _e( 'Email', 'personalize-login' ); ?></label>
        <input type="text" name="log" id="user_login">
      </p>
      <p class="login-password">
        <label for="user_pass"><?php _e( 'Password', 'personalize-login' ); ?></label>
        <input type="password" name="pwd" id="user_pass">
      </p>
      <div class="form-group">
        <a class="btn btn-block btn-login-fb py-2" href="javascript:void(0);">
          <i class="fa fa-facebook-square d-inline-block" aria-hidden="true"></i>
          <div class="btn-text d-inline-block">Login with Facebook</div>
        </a>
      </div>
      <p class="login-submit">
        <input type="submit" value="<?php _e( 'Sign In', 'personalize-login' ); ?>">
      </p>
    </form>
  </div>
<?php endif; ?>
