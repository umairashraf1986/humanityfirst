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
<!--====================================
=             PAGE                     =
=====================================-->
<section class="page-wrapper blog-content">
	<div class="container">

        <div class="row">
            <div class="col-md-12 col-lg-8 col-sm-12">
                
                <?php the_content(); ?>

            </div>

            <div class="col-lg-4 col-md-12 col-sm-12">

            	<div class="sidebar-styling">
            		
                <div class="blog-sidebar">
                  <div class="write-your-story-btn" style="display: none;">
                    <a href="<?php echo home_url('/covid-19-volunteer-registration'); ?>" ><i class="fa fa-universal-access"></i> COVID-19 Volunteer Registration</a>
                  </div>
                  <?php if(!$is_volunteer) { ?>
                    <div class="write-your-story-btn">
                      <a href="<?php echo home_url('/register-volunteer'); ?>" ><i class="fa fa-universal-access"></i> Register as Volunteer</a>
                    </div>
                  <?php } ?>

                  <div class="write-your-story-btn">
                    <a href="<?php echo home_url('/careers'); ?>" ><i class="fa fa-cogs"></i> Apply for a Job</a>
                  </div>
                  <?php $loop_jobs = new WP_Query( array( 'post_type' => 'hf_jobs', 'job_category' => 'featured', 'posts_per_page' => 5 ) ); ?>
                  <?php if( $loop_jobs->have_posts() ) : ?>
                    <div class="sidebar-links">
                      <h4>Featured Jobs</h4>
                      <ul class="disk-list">

                        <?php while ( $loop_jobs->have_posts() ) : $loop_jobs->the_post(); ?>
                          <li><a href="<?php echo home_url('/careers'); ?>"><?php the_title(); ?></a></li>
                        <?php endwhile; wp_reset_query(); ?>
                      </ul>
                    </div>
                  <?php endif; ?>

                </div>

            	</div>

            </div>
        </div>
	</div>
</section>
<!--====  End of PAGE  ====-->