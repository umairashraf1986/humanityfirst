<?php
/**
* Initiating Titan Framework
*/
$titan = TitanFramework::getInstance( 'sage' );

/**
* Contact Us Section Options
*/
$contactHeading = $titan->getOption( 'hf_footer_contact_heading' );
$contactDesc = $titan->getOption( 'hf_footer_desc_heading' );

/**
* About Information Section Options
*/
$aboutDesc = $titan->getOption( 'hf_about_desc' );
$aboutPhone = $titan->getOption( 'hf_about_phone' );
$aboutEmail = $titan->getOption( 'hf_about_email' );
$aboutAddress = $titan->getOption( 'hf_about_address' );

/**
* Follow Us Section Options
*/
$followFB = $titan->getOption( 'hf_follow_fb' );
$followTwitter = $titan->getOption( 'hf_follow_twitter' );
$followGP = $titan->getOption( 'hf_follow_google_plus' );
$followEmail = $titan->getOption( 'hf_follow_email' );

/**
* Copyright Section Options
*/
$coprightText = $titan->getOption( 'hf_footer_copyright_text' );
?>
<!--============================
=            Footer            =
=============================-->
<div class="clearfix"></div>
<footer class="footer">
  
  <!-- Newsletter -->

  <div class="newsletter-wrapper">
    <div class="container h-100">
      <div class="row h-100">
        <div class="col-md-9 col-lg-9 col-sm-12">
          <!-- <h1 class="title">Drop us a line! <span class="color-gray" style="font-weight: bold; text-transform: uppercase;">Contact Us</span></h1> -->
          <h1 class="title"><?php echo $contactHeading; ?></h1>
          <!-- <h5 class="subscribe-text">Ipsa aspernatur, dolore obcaecati facilis a asperiores <span class="color-gray">sit fugit quaerat</span> iste porro! </h5> -->
          <h5 class="subscribe-text"><?php echo $contactDesc; ?></h5>
        </div>
        <div class="col-md-3 col-lg-3 col-sm-12">
          <div class="input-wrapper">
            <!-- <input type="email" placeholder="Enter your email here..." class="form-control" />
              <div class="btn-share"><i class="fa fa-share" aria-hidden="true"></i></div> -->
              <a href="<?php echo home_url('/contact-us'); ?>" class="footer-contact-btn">CONTACT US</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ./Newsletter -->

    <div class="container">
      <div class="row">
        <!-- About Information -->
        <div class="col-md-12 col-sm-12 col-lg-4">
          <div class="about">
            <h4 class="heading">About Information</h4>
            <div class="desc"><?php echo $aboutDesc; ?></div>
            <ul class="info-list">
              <?php if( !empty($aboutPhone) ) {?>
              <li>
                <div class="info-name"><i class="fa fa-phone" aria-hidden="true"></i> Phone:</div>
                <div class="info-value"><?php echo $aboutPhone; ?></div>
              </li>
              <?php } ?>
              <?php if( !empty($aboutEmail) ) {?>
              <li>
                <div class="info-name"><i class="fa fa-envelope-o" aria-hidden="true"></i> Email:</div>
                <div class="info-value"><a href="mailto:<?php echo $aboutEmail; ?>" class="color-primary"><?php echo $aboutEmail; ?></a></div>
              </li>
              <?php } ?>
              <?php if( !empty($aboutAddress) ) {?>
              <li>
                <div class="info-name"><i class="fa fa-map-o" aria-hidden="true"></i> Address:</div>
                <div class="info-value"><?php echo $aboutAddress; ?></div>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
        <!-- ./About Information -->

        <!-- Latest Updates -->
        <div class="col-md-12 col-sm-12 col-lg-4">
          <div class="updates">
            <h4 class="heading">Latest Updates</h4>
            <ul class="update-list">
              <?php $loop = new WP_Query( array( 'post_type' => 'post', 'category_name' => 'news', 'posts_per_page' => 3 ) ); ?>
              <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
                <li>
                  <div class="update-wrapper">
                    <?php if(has_post_thumbnail(get_the_ID())){ ?>
                    <a href="<?php the_permalink(); ?>">
                      <img src="<?php echo get_the_post_thumbnail_url( get_the_ID(), 'thumbnail' ); ?>" alt="<?php the_title(); ?>" class="img">
                    </a>
                    <?php } ?>
                    <div class="info-wrapper">
                      <h5 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                      <div class="date"><?php the_date(); ?></div>
                      <div class="category"><span class="color-primary">Posted in:</span> <?php the_category(', '); ?></div>
                    </div>
                  </div>
                </li>
              <?php endwhile; wp_reset_query(); ?>
            </ul>
          </div>
        </div>
        <!-- ./Latest Updates -->

        <!-- Join Our Community -->
        <div class="col-md-12 col-sm-12 col-lg-4">
          <div class="join">
            <h4 class="heading">Join Our Community</h4>
            <?php wp_nav_menu( array( 'theme_location' => 'footer_navigation' ) ); ?>
            <?php if( !(empty($followFB) && empty($followTwitter) && empty($followGP) && empty($followEmail)) ) {?>
            <h4 class="heading">Follow Us</h4>
            <ul class="social-list">
              <?php if( !empty($followFB) ) {?>
              <li>
                <a href="<?php echo $followFB; ?>" class="facebook" target="_blank"><span class="social-border"></span><i class="fa fa-facebook" aria-hidden="true"></i></a>
              </li>
              <?php } ?>
              <?php if( !empty($followTwitter) ) {?>
              <li>
                <a href="<?php echo $followTwitter; ?>" class="twitter" target="_blank"><span class="social-border"></span><i class="fa fa-twitter" aria-hidden="true"></i></a>
              </li>
              <?php } ?>
              <?php if( !empty($followEmail) ) {?>
              <li>
                <a href="mailto:<?php echo $followEmail; ?>" class="email"><span class="social-border"></span><i class="fa fa-envelope" aria-hidden="true"></i></a>
              </li>
              <?php } ?>
            </ul>
            <?php } ?>
          </div>
        </div>
        <!-- ./Join Our Community -->
      </div>
    </div>
    
    <!-- Copyright -->
    <div class="container">
      <hr>
      <div class="copyright-wrapper">
        <div class="row align-items-center">
          <div class="col">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" class="footer-logo" width="190"></img>
          </div>
          <div class="col text-right">
            <em><?php echo $coprightText; ?></em>
          </div>
        </div>
      </div>
    </div>
    <!-- ./Copyright -->

  </footer>

  <!--====  End of Footer  ====-->
