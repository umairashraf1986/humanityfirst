<?php
/**
 Template Name: Register
 **/
 use Roots\Sage\Titles;
 ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section program-detail-page">
  
  <div class="iptc-content">
    <h1>Register</h1>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<div class="page-wrapper">
  <div class="container">
    <?php
      if(is_user_logged_in()) {
        echo "You are already signed in.";
      } else {
    ?>
      <div class="row justify-content-center">
        <div class="main-content col-md-8">
            <form id="pippin_registration_form" class="register_form" action="" method="POST">
                <fieldset>
                    <div class="form-group">
                        <label for="user_email"><?php _e('Email *'); ?></label>
                        <input name="user_email" id="user_email" class="form-control field" type="email" required/>
                        <div class="error email-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="user_first"><?php _e('First Name *'); ?></label>
                        <input name="user_first" id="user_first" class="form-control field" type="text" required/>
                        <div class="error fn-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="user_last"><?php _e('Last Name *'); ?></label>
                        <input name="user_last" id="user_last" class="form-control field" type="text" required/>
                        <div class="error ln-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="user_company"><?php _e('Company *'); ?></label>
                        <input name="user_company" id="user_company" class="form-control field" type="text" required/>
                        <div class="error company-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="user_role"><?php _e('Role *'); ?></label>
                        <input name="user_role" id="user_role" class="form-control field" type="text" required/>
                        <div class="error role-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="password"><?php _e('Password *'); ?></label>
                        <input name="password" id="password" class="form-control field" type="password" required/>
                        <div class="error pass-error"></div>
                    </div>
                    <div class="form-group">
                        <label for="password_again"><?php _e('Repeat Password *'); ?></label>
                        <input name="password_again" id="password_again" class="form-control field" type="password" required/>
                        <div class="error rp-error"></div>
                    </div>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LejGTIUAAAAADHIetCzuvCqHU1fnmfjN_1f0imB"></div>
                        <div class="error recaptcha-error"></div>
                    </div>
                    <div class="form-group">
                        <input type="hidden" name="pippin_register_nonce" value="<?php echo wp_create_nonce('pippin-register-nonce'); ?>"/>
                        <input type="submit" id="btn-register" class="btn btn-green" value="<?php _e('Register Your Account'); ?>"/>
                        <img class="ajax-loader hidden" src="<?php echo get_stylesheet_directory_uri().'/assets/images/loader.gif'; ?>" />
                    </div>
                </fieldset>
            </form>
        </div>
      </div>
    <?php
      }
    ?>
  </div>
</div>