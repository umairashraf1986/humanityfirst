<?php use Roots\Sage\Titles;?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section program-detail-page">

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
<section class="page-wrapper member-detail-page">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8 col-sm-12">
        <div class="text-paragraph"><?php the_content(); ?></div>
      </div>
      <div class="col-lg-4 col-md-12 col-sm-12">
        <div class="widgets">
          <div class="sidebar-styling widget" style="border: none;">
            <div class="img-wrapper justify-content-center text-center">
              <div class="director-img-wrapper">
                <img alt="" class="director-img" src="<?php echo get_the_post_thumbnail_url(); ?>"/>
              </div>
            </div>
            <h4 class="text-center color-primary"></h4>

            <?php
              $sponsor_website = rwmb_meta('hfusa-sponsor_website');
              if ($sponsor_website != "") {
                echo '<div class="text-center"><a href="'. $sponsor_website .'" target="_blank" class="btn btn-blue"><i class="fa fa-globe" aria-hidden="true"></i> Visit their website</a></div>';
              }
            ?>



          </div>

          <div class="widget">
            <div class="widget-content">
              <ul class="detail-page-social">
                <?php

                if (rwmb_meta('hfusa-sponsor_facebook') != "") {
                  echo '<li><a href="'.rwmb_meta('hfusa-sponsor_facebook').'" target="_blank" class="icon-facebook"><i class="fa fa-facebook"></i></a></li>';
                }
                if (rwmb_meta('hfusa-sponsor_twitter') != "") {
                  echo '<li><a href="'.rwmb_meta('hfusa-sponsor_twitter').'" target="_blank" class="icon-twitter"><i class="fa fa-twitter"></i></a></li>';
                }
                if (rwmb_meta('hfusa-sponsor_linkedin') != "") {
                  echo '<li><a href="'.rwmb_meta('hfusa-sponsor_linkedin').'" target="_blank" class="icon-linkedin"><i class="fa fa-linkedin"></i></a></li>';
                }
                if (rwmb_meta('hfusa-sponsor_google_plus') != "") {
                  echo '<li><a href="'.rwmb_meta('hfusa-sponsor_youtube').'" target="_blank" class="icon-google-plus"><i class="fa fa-youtube-play"></i></a></li>';
                }
                if (rwmb_meta('hfusa-sponsor_email') != "") {
                  echo '<li><a href="mailto:'.rwmb_meta('hfusa-sponsor_email').'" class="icon-email"><i class="fa fa-envelope-o"></i></a></li>';
                }
                ?>
              </ul>

            </div>
          </div>

          <?php
           echo hf_impacts_widget_area();
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
                      $testimonial_excerpt = hf_get_the_excerpt($testimonial_id);
                      $testimonial_post_thumbnail_url = get_the_post_thumbnail_url($testimonial_id);
                  ?>

                  <!-- Single Testimonial -->  
                  <div class="single-testimonial">
                    <div class="testimonial-holder">
                      <div class="testimonial-content"><?php echo $testimonial_excerpt; ?></div>
                      <div class="row">
                        <div class="testimonial-user clearfix">
                          <div class="testimonial-user-image"><img src="<?php echo $testimonial_post_thumbnail_url; ?>" alt="<?php echo $testimonial_title; ?>"></div>
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
            <?php
            $quotes = rwmb_meta("hfusa-page_quotes");

            if (count($quotes) > 0) {
                ?>
              <div class="quotes-list">

                  <?php
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
                  ?>
              </div>
                <?php
            }
            ?>
          <?php
          $news_loop = new WP_Query(array("post_type" => "post", "posts_per_page" => 5, "category_name" => "news"));
          if ($news_loop->have_posts()) :
            ?>
            <!-- <div class="widget">
                        <h2 class="widget-title">News</h2>
                        <ul class="disk-list">
                            <?php while ($news_loop->have_posts()) : $news_loop->the_post() ?>
                                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                            <?php endwhile;
            wp_reset_query(); ?>
                        </ul>
                    </div> -->
          <?php endif; ?>


          <?php
          $countries_loop = new WP_Query(array(
              "post_type" => "hf_programs",
              "meta_key" => 'hfusa-project_program',
              "meta_value" => get_the_ID(),
              "posts_per_page" => -1
          ));
          if ($countries_loop->have_posts()) :
            ?>
            <div class="widget">
              <h2 class="widget-title">Projects</h2>
              <ul class="disk-list">
                <?php while ($countries_loop->have_posts()) : $countries_loop->the_post(); ?>
                  <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile;
                wp_reset_query(); ?>
              </ul>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!--====  End of PAGE  ====-->
