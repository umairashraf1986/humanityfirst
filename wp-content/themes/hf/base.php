<?php
use Roots\Sage\Setup;
use Roots\Sage\Wrapper;

?>
<?php
    // Template files without Header and Footer
    $templateFiles = array(
            'login-verification.php',
            'existing-user-verification.php',
            'get-all-users.php',
            'charge-stripe.php',
            'charge-paypal.php',
            'donations-by-state.php',
            'braintree-token.php',
            'template-paypal-payment.php',
            'template-facebook-login.php',
            'template-google-login.php',
            'template-stripe-payment.php',
            'template-program-donation-info.php',
            'template-campaign-programs-donations.php',
            'template-charge-stripe-web.php',
            'template-charge-stripe-mobile.php',
            'template-get-user-jobs.php',
            'template-update-device-token.php',
            'template-apply-for-job-mobile.php',
            'template-become-a-sponsor-mobile.php',
            'template-add-bookings-mobile.php',
            'template-bookings-mobile.php',
            'template-write-a-story-mobile.php',
            'template-project-woking-hours.php',
            'template-get-woking-hours.php',
            'template-volunteer-form-fields-mobile.php',
            'template-get-donations-mobile.php',
            'template-get-all-posts.php',
            'template-program-details.php',
            'template-event-details.php',
            'template-telethon-stats.php',
            'template-campaign-stats.php'
    );



    if ( !is_page_template($templateFiles) ) {

?>
<!doctype html>
<html <?php language_attributes(); ?>>
  <?php get_template_part('templates/head'); ?>
  <body <?php body_class(); ?>>

    <?php if(!wp_is_mobile()) { ?>
    <!-- Preloader -->
    <div class="preloader">
      <div class="spinner"></div>
    </div>
    <!-- ./Preloader -->
    <?php } ?>

    <!--[if IE]>
      <div class="alert alert-warning">
        <?php _e('You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.', 'sage'); ?>
      </div>
    <![endif]-->
    <?php
      do_action('get_header');
      // if (!is_page_template('template-telethon.php') && !is_page_template('template-dinner.php'))  {
        get_template_part('templates/header');
      // }
    ?>
    <div class="wrap <?php if(isset($GLOBALS['campaigns']) && $GLOBALS['campaigns']) echo "with-campaign-slider"; ?>" role="document">
      <div class="content">
        <main class="main-wrapper">
          <?php include Wrapper\template_path(); ?>
        </main><!-- /.main -->
        <?php //if (Setup\display_sidebar()) : ?>
<!--          <aside class="sidebar-wrapper">-->
            <?php //include Wrapper\sidebar_path(); ?>
<!--          </aside> -->
        <!-- <?php //endif; ?> -->
      </div><!-- /.content -->
    </div><!-- /.wrap -->
    <?php
      do_action('get_footer');
      // if (!is_front_page() && !is_page_template('template-telethon.php') && !is_page_template('template-dinner.php')) {
        get_template_part('templates/footer');
      // }
      wp_footer();
    ?>

  </body>
</html>
<?php } else {
  include Wrapper\template_path();
}?>

