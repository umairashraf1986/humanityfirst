<?php use Roots\Sage\Titles; ?>
<?php
  $is_volunteer = false;
  if(is_user_logged_in()) {
    $user = new WP_User(get_current_user_id());
    if(in_array('volunteer', $user->roles)) {
      $is_volunteer = true;
    }
  }
?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>

  <div class="iptc-content">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->
<?php $stylesheetDirectory = get_stylesheet_directory_uri(); ?>
<section class="page-wrapper be-a-sponsor">
  <div class="container">
  	<?php
  		if( !$is_volunteer ) {
  			the_content();
  		} else {
  			echo "You already have registered as volunteer.";
  		}
	?>
  </div>
</section>