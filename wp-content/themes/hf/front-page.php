<?php

/**
* Initiating Titan Framework
*/
$titan = TitanFramework::getInstance( 'sage' );

/**
* Hero Section Options
*/
$heroTagline = $titan->getOption( 'hf_hero_tagline' );
$heroHeading = $titan->getOption( 'hf_hero_heading' );
$heroDescription = $titan->getOption( 'hf_hero_description' );
$heroVideo = $titan->getOption( 'hf_hero_video' );

/**
* About Us Section Options
*/
$aboutTitle = $titan->getOption( 'hf_about_title' );
$aboutText = $titan->getOption( 'hf_about_text' );
$aboutBGImg = $titan->getOption( 'hf_about_bg_img' );

/**
* Our Work Section Options
*/
$owTitle = $titan->getOption( 'hf_ow_title' );
$owText = $titan->getOption( 'hf_ow_text' );
$owBGImg = $titan->getOption( 'hf_ow_bg_img' );

/**
* Our Impact Section Options
*/
$oiTitle = $titan->getOption( 'hf_oi_title' );
$oiText = $titan->getOption( 'hf_oi_text' );
$oiBGImg = $titan->getOption( 'hf_oi_bg_img' );

/**
* Current Happenings Section Options
*/
$chTitle = $titan->getOption( 'hf_ch_title' );
$chText = $titan->getOption( 'hf_ch_text' );
$chBGImg = $titan->getOption( 'hf_ch_bg_img' );

/**
* Multimedia Section Options
*/
$resourcesTitle = $titan->getOption( 'hf_resources_title' );
$resourcesText = $titan->getOption( 'hf_resources_text' );
$resourcesBGImg = $titan->getOption( 'hf_resources_bg_img' );

/**
* Get Involved Section Options
*/
$giTitle = $titan->getOption( 'hf_gi_title' );
$giText = $titan->getOption( 'hf_gi_text' );
$giBGImg = $titan->getOption( 'hf_gi_bg_img' );

?>
<style type="text/css">
body.home{
  overflow: hidden;
}
</style>
<div class="vid-container" style="position: absolute; width: 100%; height: 100vh; overflow: hidden; top: 65px; left: 0;">
  <?php if(!wp_is_mobile()) { ?>
  <video class="b-lazy" poster="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/hero-poster.jpg" id="bgvid" style="object-fit: cover; max-width: 100%; min-height: 100vh; width: 100%;" playsinline autoplay muted loop>
    <!-- <source src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/videos/vodto.webm" type="video/webm">
      <source src="<?php echo get_stylesheet_directory_uri(); ?>/dist/images/videos/vodto.ogv" type="video/ogv"> -->
        <source src="<?php echo wp_get_attachment_url($heroVideo);?>" type="video/mp4">
        </video>
      <?php } else { ?>
        <div class="poster" style="object-fit: cover; max-width: 100%; min-height: 100vh; width: 100%; background-image: url(<?php echo get_stylesheet_directory_uri(); ?>/assets/images/hero-poster.jpg)"></div>
      <?php } ?>
      </div>
<div class="sections-wrapper">
<?php /*
  <!-- Slide 1 Start -->
  <div>

<!--==================================
=            Hero Section            =
===================================-->


<section class="home-hero-section section full-height-fold" id="hero-fold">
        <div class="hf-overlay"></div>
        <div class="hero-text-wrapper">
          <div class="container">
            <div class="row vertical-middle w-100">
              <div class="col">
                <div class="hero-text  p-0">
                  <h4 class="hf-tagline text-center"><?php echo $heroTagline; ?></h4>
                  <h1 class="hf-headline text-center"><?php echo $heroHeading; ?></h1>
                  <div class="clearfix"></div>
                  <p class="hf-desc text-center"><?php echo $heroDescription; ?></p>
                  <div class="clearfix"></div>
                </div>
              </div>

            </div>

          </div>

        </div>
        <div class="below-fold-bottom-navigation">
          <div class="about-navigation">
            <ul class="slick-dots">
              <li><a class="hn-about scrollTo forAboutSlide"><span class="sprite-icons hn-about"></span><span>about us</span></a></li>
              <li><a class="hn-our-work scrollTo forWorkSlide"><span class="sprite-icons hn-what-we-do"></span><span>our work</span></a></li>
              <li><a class="hn-our-impact scrollTo forImpactSlide"><span class="sprite-icons hn-our-impact"></span><span>our impact</span></a></li>
              <li><a class="hn-newsroom scrollTo forHappeningSlide"><span class="sprite-icons hn-current-happenings"></span><span>current happenings</span></a></li>
              <li><a class="hn-resources scrollTo forResourcesSlide"><span class="sprite-icons hn-resources"></span><span>multimedia</span></a></li>
              <li><a class="hn-get-involved scrollTo forInvolvedSlide"><span class="sprite-icons hn-get-involved"></span><span>get involved</span></a></li>
            </ul>
          </div>
        </div>
      </section>

      <!--====  End of Hero Section  ====-->

    </div>
    <!-- Slide 1 End -->



    <!-- Slide 2 Start -->
    <div>

<!--===================================
=            About Section            =
====================================-->

<section id="fp-about-section" class="fp-about-section section full-height-fold b-lazy" style="<?php echo (!empty($aboutBGImg)) ? 'background-image: url('.wp_get_attachment_url($aboutBGImg).')' : ''; ?> background: none;">
  <div class="hf-overlay"></div>
  <div class="hero-text-wrapper">
    <div class="container">
      <div class="row vertical-middle w-100">
        <div class="col">
          <div class="hero-text  p-0">
            <!-- <h4 class="hf-tagline float-right">About us</h4> -->
            <!--                                         -->
            <h1 class="hf-headline text-center"><?php echo $aboutTitle; ?></h1>
            <div class="clearfix"></div>
            <p class="hf-desc  text-center"><?php echo $aboutText; ?></p>
            <div class="clearfix"></div>
          </div>
        </div>

      </div>
    </div>

  </div>
  <div class="below-fold-bottom-navigation">

    <div class="about-navigation">
      <ul>
        <li><a href="<?php echo home_url('/history'); ?>"><span class="sprite-icons hn-history"></span><span>History</span></a></li>
        <li><a href="<?php echo home_url('/mission'); ?>"><span class="sprite-icons hn-mission"></span><span>Mission</span></a></li>
        <li><a href="<?php echo home_url('/team'); ?>"><span class="sprite-icons hn-team"></span><span>Team</span></a></li>
        <li><a href="<?php echo home_url('/faqs'); ?>"><span class="hn-faqs sprite-icons"></span><span>FAQs</span></a></li>
        <li><a href="<?php echo home_url('/sponsors'); ?>"><span class="sprite-icons hn-sponsors"></span><span>Sponsors</span></a></li>
        <li><a href="<?php echo home_url('/partners'); ?>"><span class="sprite-icons hn-partners"></span><span>Partners</span></a></li>
        <li><a href="<?php echo home_url('/global-sites'); ?>"><span class="sprite-icons hn-i-sites"></span><span>Global sites</span></a></li>
        <li><a href="<?php echo home_url('/message-from-chairman'); ?>"><span class="sprite-icons hn-i-chairman"></span><span>Message From Chairman</span></a></li>
        <li><a href="<?php echo home_url('/message-from-director'); ?>"><span class="sprite-icons hn-i-director"></span><span>Message From Director</span></a></li>
      </ul>
    </div>
  </div>
</section>

<!--====  End of About Section  ====-->

</div>
<!-- Slide 2 End -->



<!-- Slide 3 Start -->
<div>

<!--================================
=            Our Work            =
=================================-->

<section id="fp-owrk-section" class="fp-our-work-section section full-height-fold b-lazy" style="<?php echo (!empty($owBGImg)) ? 'background-image: url('.wp_get_attachment_url($owBGImg).')' : ''; ?> background: none;">
  <div class="hf-overlay"></div>
  <div class="hero-text-wrapper">
    <div class="container">
      <div class="row vertical-middle w-100">
        <div class="col">
          <div class="hero-text p-0">
            <h1 class="hf-headline text-center"><?php echo $owTitle; ?></h1>
            <div class="clearfix"></div>
            <p class="hf-desc text-center"><?php echo $owText; ?></p>

            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="below-fold-bottom-navigation">
    <div class="about-navigation">
      <ul>
        <li><a href="<?php echo home_url('/programs'); ?>"><span class="hn-our-programs sprite-icons "></span><span>Our programs</span></a></li>
        <li><a href="<?php echo home_url('/geographic-regions'); ?>"><span class="hn-geo-regions sprite-icons"></span><span>Geographic regions</span></a></li>
        <li><a href="<?php echo home_url('/projects'); ?>"><span class="hn-our-projects sprite-icons"></span><span>Our Projects</span></a></li>
      </ul>
    </div>
  </div>
</section>

<!--====  End of Our Work  ====-->

</div>
<!-- Slide 3 End -->



<!-- Slide 4 Start -->
<div>

<!--================================
=            Our Impact            =
=================================-->

<section id="fp-oi-section" class="fp-our-impact-section section full-height-fold b-lazy" style="<?php echo (!empty($oiBGImg)) ? 'background-image: url('.wp_get_attachment_url($oiBGImg).')' : ''; ?> background: none;">
  <div class="hf-overlay"></div>
  <div class="hero-text-wrapper">
    <div class="container">
      <div class="row vertical-middle w-100">
        <div class="col">
          <div class="hero-text p-0">
            <h1 class="hf-headline text-center"><?php echo $oiTitle; ?></h1>
            <div class="clearfix"></div>
            <p class="hf-desc text-center"><?php echo $oiText; ?></p>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="below-fold-bottom-navigation">
    <div class="about-navigation">
      <ul>
        <li><a href="<?php echo home_url('/geographic-reach'); ?>"><span class="hn-geo-reach sprite-icons"></span><span>Geographic reach</span></a></li>
        <li><a href="<?php echo home_url('/years-in-the-field'); ?>"><span class="hn-yit-field sprite-icons"></span><span>Years in the field</span></a></li>
        <li><a href="<?php echo home_url('/our-impact/lives-impacted'); ?>"><span class="hn-lives-impact sprite-icons"></span><span>Lives Impacted</span></a></li>
        <!-- <li><a href="<?php echo home_url('/dollars-raised'); ?>"><span class="hn-dollars-raised sprite-icons"></span><span>Dollars Raised</span></a></li> -->
      </ul>
    </div>
  </div>
</section>

<!--====  End of Our Impact  ====-->

</div>
<!-- Slide 4 End -->



<!-- Slide 5 Start -->
<div>

<!--================================
=      Current Happenings          =
=================================-->

<section id="fp-chapp-section" class="fp-current-happenings-section section full-height-fold b-lazy" style="<?php echo (!empty($chBGImg)) ? 'background-image: url('.wp_get_attachment_url($chBGImg).')' : ''; ?> background: none;">
  <div class="hf-overlay"></div>
  <div class="hero-text-wrapper">
    <div class="container">
      <div class="row vertical-middle w-100">
        <div class="col">
          <div class="hero-text p-0">
            <h1 class="hf-headline text-center"><?php echo $chTitle; ?></h1>
            <div class="clearfix"></div>
            <p class="hf-desc text-center"><?php echo $chText; ?></p>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="below-fold-bottom-navigation">
    <div class="about-navigation">
      <ul>
        <li><a href="<?php echo home_url('/news'); ?>"><span class="hn-latest-news sprite-icons"></span><span>Latest News</span></a></li>
        <li><a href="<?php echo home_url('/events'); ?>"><span class="hn-latest-events sprite-icons"></span><span>Events</span></a></li>
          <li><a href="<?php echo home_url('/campaigns'); ?>"><span class="hn-latest-campaigns sprite-icons"></span><span>Campaigns</span></a></li>
        <li><a href="<?php echo home_url('/message-board'); ?>"><span class="hn-message-board sprite-icons"></span><span>Message Board</span></a></li>
        <li><a href="<?php echo home_url('/blog'); ?>"><span class="hn-blog sprite-icons"></span><span>Blog</span></a></li>
        <li><a href="<?php echo home_url('/stories'); ?>"><span class="sprite-icons hn-stories"></span><span>Stories</span></a></li>
        <li><a href="<?php echo home_url('/alerts'); ?>"><span class="hn-alert sprite-icons"></span><span>Alerts</span></a></li>
      </ul>
    </div>
  </div>
</section>

<!--====  End of Current Happenings  ====-->


</div>
<!-- Slide 5 End -->



<!-- Slide 6 Start -->
<div>

<!--================================
=          Multimedia        =
=================================-->

<section id="fp-hr-section" class="fp-resources-section section full-height-fold b-lazy" style="<?php echo (!empty($resourcesBGImg)) ? 'background-image: url('.wp_get_attachment_url($resourcesBGImg).')' : ''; ?> background: none;">
  <div class="hf-overlay"></div>
  <div class="hero-text-wrapper">
    <div class="container">
      <div class="row vertical-middle w-100">
        <div class="col">
          <div class="hero-text  p-0">
            <h1 class="hf-headline text-center"><?php echo $resourcesTitle; ?></h1>
            <div class="clearfix"></div>
            <p class="hf-desc text-center"><?php echo $resourcesText; ?></p>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="below-fold-bottom-navigation">
    <div class="about-navigation">
      <ul>
        <li><a href="<?php echo home_url('/photo-gallery'); ?>"><span class="hn-photo-gallery sprite-icons"></span><span>photo gallery</span></a></li>
        <li><a href="<?php echo home_url('/videos'); ?>"><span class="hn-videos sprite-icons"></span><span>videos</span></a></li>
        <li><a href="<?php echo home_url('/downloads'); ?>"><span class="hn-downloads sprite-icons"></span><span>downloads</span></a></li>
      </ul>
    </div>
  </div>
</section>

<!--====  End of Helpful Resources  ====-->

</div>
<!-- Slide 6 End -->




<!-- Slide 7 Start -->
<div>

<!--================================
=           Get Involved           =
=================================-->

<section id="fp-gi-section" class="fp-get-involved-section section full-height-fold b-lazy" style="<?php echo (!empty($giBGImg)) ? 'background-image: url('.wp_get_attachment_url($giBGImg).')' : ''; ?> background: none;">
  <div class="hf-overlay"></div>
  <div class="hero-text-wrapper">
    <div class="container">
      <div class="row vertical-middle w-100">
        <div class="col">
          <div class="hero-text  p-0">
            <h1 class="hf-headline text-center"><?php echo $giTitle; ?></h1>
            <div class="clearfix"></div>
            <p class="hf-desc text-center"><?php echo $giText; ?></p>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <div class="below-fold-bottom-navigation">
    <div class="about-navigation">
      <ul>

        <li><a href="<?php echo home_url('/become-a-volunteer'); ?>"><span class="hn-be-a-volunteer sprite-icons"></span><span>Become a volunteer</span></a></li>
        <li><a href="https://fundraise.humanityfirst.org/give/59013/#!/donation/checkout" target="_blank"><span class="hn-donate sprite-icons"></span><span>donate</span></a></li>
        <li><a href="<?php echo home_url('/become-a-sponsor'); ?>"><span class="hn-be-a-sponser sprite-icons"></span><span>Become a Sponsor</span></a></li>
      </ul>
    </div>
  </div>
</section>

<!--====  End of Get Involved  ====-->

</div>
<!-- Slide 7 End -->
*/ ?>

<?php

$args = array(
  'post_type' => 'hf_hero_slides',
  'posts_per_page' => -1
);
$slides_loop = new WP_Query($args);
if($slides_loop->have_posts()) {
  while($slides_loop->have_posts()) : $slides_loop->the_post();

    $slides_buttons = get_post_meta( get_the_ID(), 'hero_slides_buttons');
    $bottom_nav = get_post_meta( get_the_ID(), 'hero_slides_bottom_navigation');

    $heroTagline = get_post_meta( get_the_ID(), 'hfusa-hero_slides_tagline', true);
?>
    <section id="fp-gi-section" class="fp-get-involved-section section full-height-fold b-lazy" style="<?php echo (get_the_post_thumbnail_url()) ? 'background-image:url('.get_the_post_thumbnail_url().');' : 'background: none;'; ?>">
      <div class="hf-overlay"></div>
      <div class="hero-text-wrapper">
        <div class="container">
          <div class="row vertical-middle w-100">
            <div class="col">
              <div class="hero-text  p-0">
                <?php if(!empty($heroTagline)) { ?>
                <h4 class="hf-tagline text-center"><?php echo $heroTagline; ?></h4>
                <?php } ?>
                <h1 class="hf-headline text-center"><?php echo get_the_title(); ?></h1>
                <div class="clearfix"></div>
                <p class="hf-desc text-center"><?php echo get_the_content(); ?></p>
                <div class="clearfix"></div>
              </div>

              <?php if(!empty($slides_buttons[0]) && is_array($slides_buttons[0]) && !empty($slides_buttons[0][0]['label'])){ ?>
                <div class="hero-btns">
                  <?php
                  foreach($slides_buttons[0] as $array){
                  ?>
                  <a href="<?php echo $array['url']; ?>" class="btn btn-default hero-btn" target="_blank"><?php echo $array['label']; ?></a>
                  <?php } ?>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>

      </div>
      <?php if(!empty($bottom_nav[0]) && is_array($bottom_nav[0]) && !empty($bottom_nav[0][0]['label'])){ ?>
      <div class="below-fold-bottom-navigation">
        <div class="about-navigation">
          <ul>
            <?php

            foreach($bottom_nav[0] as $array){
              $nav_icon_id = (is_array($array['nav_icon'][0])) ? $array['nav_icon'][0][0] : $array['nav_icon'][0];
              $url = '';
              if(is_array($array['nav_page'])) {
                if($array['nav_page'][0] != '' && $array['nav_page'][0] != 'Select Page') {
                  $url = get_permalink($array['nav_page'][0]);
                }
              } else {
                if(!empty($array['nav_page'])) {
                  $url = get_permalink($array['nav_page']);
                }
              }
              
              if(!empty($array['custom_link'])) {
                $url = $array['custom_link'];
              }
            ?>
            <li><a href="<?php echo $url; ?>"><img src="<?php echo wp_get_attachment_url($nav_icon_id); ?>" alt=""><span><?php echo $array['label']; ?></span></a></li>
            <?php
            }
            ?>
          </ul>
        </div>
      </div>
    <?php } ?>
    </section>
<?php
  endwhile;
}

?>

</div>
<div class="clearfix"></div>
<?php
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
<div class="footer-icon">
  <i class="fa fa-angle-down"></i>
  <i class="fa fa-angle-up"></i>
</div>
<footer  class="home-footer">
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

