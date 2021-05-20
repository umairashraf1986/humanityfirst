<?php 
/* Template Name: Years in the Field */
use Roots\Sage\Titles; ?>
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

<div class="page-content">

<!--==================================== 
=              our Impact             =
=====================================-->
<section class="page-wrapper o-impact-geo-reach">
  <div class="container">

    <div class="row rtl-display ">
      <div class="col-12 float-left">
        <div class="events-main-inner">
          <div class="row">

            <div class="col-lg-8 col-md-12 col-sm-12 float-left">
              <div class="upcoming-events">
                <?php the_content(); ?>
              </div>
              <div class="clearfix"></div>    
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12 float-left">
              <div class="widgets">
                <?php 
                  // $impact_label = rwmb_meta('hfusa-impact_label');
                  // $impact_figure = rwmb_meta('hfusa-impact_figure'); 
                ?>
                <!-- <div class="widget">
                  <div class="widget-content">
                    <div class="donation-target-status oi-geographic-reach ">
                      <div class="container">
                        <div class="row rtl-display " style="overflow: hidden;">
                          <div class="col-12 float-left stat-box">
                            <div class="row align-items-center">
                              <div class="col-lg-4 col-sm-4 col-md-6 st-left">
                                <div class="icon-container">
                                  <img src="<?php echo get_template_directory_uri();?>/assets/images/years-in-service.png" alt="Geographic Reached">
                                </div>
                              </div>
                              <div class="col-lg-8 col-sm-8 col-md-6 st-right">
                                <div class="dts-figures">
                                  <?php if( !empty($impact_figure) ) { ?>
                                  <h4><span><?php echo nice_number($impact_figure); ?></span></h4>
                                  <?php } ?>
                                  <h6><?php echo $impact_label; ?></h6>
                                </div>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
                <?php echo hf_impacts_widget_area(); ?>
                <div class="clearfix"></div>
                
                <?php
                  $quotes = rwmb_meta("hfusa-page_quotes");

                  if (count($quotes) > 0) {
                      foreach ($quotes as $quote_id) {
                        $quote_title = get_the_title($quote_id);
                        $quote_content = get_post_field('post_content', $quote_id);
                        $quote_author_name = rwmb_meta("hfusa-quote_author_name", null, $quote_id);
                        $quote_author_designation = rwmb_meta("hfusa-quote_author_designation", null, $quote_id);
                ?>
                  <div class="widget">
                  
                    <blockquote class="quote-box">
                        <p class="quotation-mark">
                            “
                        </p>
                        <p class="quote-text">
                            <?php echo $quote_content;?>
                        </p>

                        <div class="blog-post-actions"> <hr>
                            <p class="blog-post-bottom pull-left">
                                <?php echo $quote_author_name; ?> <em><small> - <?php echo $quote_author_designation; ?></small></em>
                            </p>
                        </div>
                    </blockquote>
                  </div>
                <?php
                      }
                  }
                ?>

                <?php
                  $testimonials = rwmb_meta("hfusa-page_testimonials");

                  if (count($testimonials) > 0) {
                ?>
                
                <div class="widget">
                  
                  <div class="widget-content">
                    
                    <div id="testimonials">                

                      <div class="testimonials-list">

                        <?php
                          foreach ($testimonials as $testimonial_id) {
                            $testimonial_title = get_the_title($testimonial_id);
                            $testimonial_excerpt = get_the_excerpt($testimonial_id);
                            $testimonial_post_thumbnail_url = get_the_post_thumbnail_url($testimonial_id);
                        ?>

                        <!-- Single Testimonial -->  
                        <div class="single-testimonial">
                          <div class="testimonial-holder">
                            <div class="testimonial-content"><?php the_excerpt(); ?></div>
                            <div class="row">
                              <div class="testimonial-user clearfix">
                                <div class="testimonial-user-image">
                                  <?php
                                  if(!$testimonial_post_thumbnail_url){
                                      $testimonial_post_thumbnail_url = get_template_directory_uri().'/assets/images/default-avatar.png';
                                  }
                                  ?>
                                  <img src="<?php echo $testimonial_post_thumbnail_url; ?>" alt="<?php echo $testimonial_title; ?>"></div>
                                <div class="testimonial-user-name"><?php echo $testimonial_title; ?></div>
                                <div class="testimonial-caret"><i class="fa fa-caret-down"></i></div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- End of Single Testimonial -->

                        <?php
                          }
                        ?>
                      </div>

                    </div>

                  </div>
                </div>
                
                <?php
                  }
                ?>

                <!-- <div class="widget">

                  <div class="t-map-statistics">
                    <div class="tms-header">
                      <h5>Countries covered till now</h5>
                    </div>
                    <div class="tms-body">
                      <div class="tms-list-item">
                        <div class="flag-container">
                          <img src="<?php echo get_template_directory_uri(); ?>/usa-states-flags/Hawaii.png" alt="">
                        </div>
                        <div class="country-details">
                          <h5>Country Name</h5>
                        </div>
                        <div class="tms-amount">
                          <h6>2 Year(s)</h6>
                        </div>
                      </div>
                      <div class="tms-list-item">
                        <div class="flag-container">
                          <img src="<?php echo get_template_directory_uri(); ?>/usa-states-flags/New Mexico.png" alt="">
                        </div>
                        <div class="country-details">
                          <h5>Country Name</h5>

                        </div>
                        <div class="tms-amount">
                          <h6>2.5 Year(s)</h6>
                        </div>
                      </div>
                      <div class="tms-list-item">
                        <div class="flag-container">
                          <img src="<?php echo get_template_directory_uri(); ?>/usa-states-flags/South Carolina.png" alt="">
                        </div>
                        <div class="country-details">
                          <h5>Country Name</h5>

                        </div>
                        <div class="tms-amount">
                          <h6>1 Year(s)</h6>
                        </div>
                      </div>
                      <div class="tms-list-item">
                        <div class="flag-container">
                          <img src="<?php echo get_template_directory_uri(); ?>/usa-states-flags/West Virginia.png" alt="">
                        </div>
                        <div class="country-details">
                          <h5>Country Name</h5>
                        </div>
                        <div class="tms-amount">
                          <h6>1 Year(s)</h6>
                        </div>
                      </div>
                      <div class="tms-list-item">
                        <div class="flag-container">
                          <img src="<?php echo get_template_directory_uri(); ?>/usa-states-flags/Colorado.png" alt="">
                        </div>
                        <div class="country-details">
                          <h5>Country Name</h5>
                        </div>
                        <div class="tms-amount">
                          <h6>3 Year(s)</h6>
                        </div>
                      </div>
                      <div class="tms-list-item">
                        <div class="flag-container">
                          <img src="<?php echo get_template_directory_uri(); ?>/usa-states-flags/Arkansas.png" alt="">
                        </div>
                        <div class="country-details">
                          <h5>Country Name</h5>
                        </div>
                        <div class="tms-amount">
                          <h6>1 Year(s)</h6>
                        </div>
                      </div>
                    </div>
                  </div>

                </div> -->




              </div>
            </div>

          </div>

        </div>



      </div>
    </div>
    <div class="clearfix"></div>
  </section>


</div>
<div class="clearfix"></div>
<!--====  end of Our Impsct  ====-->
