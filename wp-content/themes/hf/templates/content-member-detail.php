<?php use Roots\Sage\Titles; ?>
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
<section class="page-wrapper member-detail-page o-impact-geo-reach">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-8 col-sm-12">

        <div class="page-cover">
          <?php while (have_posts()) : the_post(); ?>
            <div class="row">
              <div class="col-12 cover-image">
                <?php
                $getCoverImage = rwmb_meta('hfusa-member_cover', array('limit' => 1));
                if (!empty($getCoverImage)) {
                  $coverImage = reset($getCoverImage);
                }
                ?>
                <?php

                if (empty($getCoverImage)) {

                  $coverImageSrc = get_stylesheet_directory_uri() . '/assets/images/temp-cover.jpg';

                } else {

                  $coverImageSrc = $coverImage['full_url'];

                }

                ?>
                <img src="<?php echo $coverImageSrc; ?>" alt="<?php the_title(); ?>">
              </div>
            </div>
            <div class="row">
              <div class="col-lg-4 col-md-4 col-sm-12 page-name">
                <h3><?php echo rwmb_meta( 'hfusa-member_designation' ); ?></h3>
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 page-image">
                <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>">
              </div>
              <div class="col-lg-4 col-md-4 col-sm-12 page-contact">
                <ul>
                  <!--<li><a href="mailto:<?php /*echo rwmb_meta('hfusa-member_email'); */?>"><i class="fa fa-envelope-o"></i>
                      Email</a></li>-->
                  <?php if(rwmb_meta('hfusa-member_website') !== ''): ?>
                  <li><a href="<?php echo rwmb_meta('hfusa-member_website'); ?>" target="_blank"><i
                              class="fa fa-link"></i> Visit</a></li>
                  <?php endif;?>
                </ul>
              </div>
            </div>
            <div class="row">
              <div class="col-12">

                <?php the_content(); ?>

              </div>
            </div>
          <?php endwhile;
          wp_reset_query(); ?>
        </div>

      </div>
      <div class="col-lg-4 col-md-12 col-sm-12">
        <div class="widgets">

          <div class="widget">
            <div class="widget-content">
              <ul class="detail-page-social">
                <?php

                if (rwmb_meta('hfusa-member_facebook') != "") {
                  echo '<li><a href="'.rwmb_meta('hfusa-member_facebook').'" target="_blank" class="icon-facebook"><i class="fa fa-facebook"></i></a></li>';
                }
                if (rwmb_meta('hfusa-member_twitter') != "") {
                  echo '<li><a href="'.rwmb_meta('hfusa-member_twitter').'" target="_blank" class="icon-twitter"><i class="fa fa-twitter"></i></a></li>';
                }
                if (rwmb_meta('hfusa-member_linkedin') != "") {
                  echo '<li><a href="'.rwmb_meta('hfusa-member_linkedin').'" target="_blank" class="icon-linkedin"><i class="fa fa-linkedin"></i></a></li>';
                }
                if (rwmb_meta('hfusa-member_google_plus') != "") {
                  echo '<li><a href="'.rwmb_meta('hfusa-member_google_plus').'" target="_blank" class="icon-google-plus"><i class="fa fa-google-plus"></i></a></li>';
                }
                if (rwmb_meta('hfusa-member_email') != "") {
                  echo '<li><a href="mailto:'.rwmb_meta('hfusa-member_email').'" class="icon-email"><i class="fa fa-envelope-o"></i></a></li>';
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
          $loop = new WP_Query(
           array( 
            'post_type' => 'hf_countries', 
            'posts_per_page' => -1,
            'meta_query' => array(
              array(
                'key'     => 'hfusa-program_director',
                'value' => get_the_ID()
              )
            )
          )  
         ); 

          if($loop->have_posts()) :
            ?>
            <div class="widget">
              <h2 class="widget-title">Countries</h2>
              <ul class="disk-list">
                <?php while($loop->have_posts()) : $loop->the_post();
                $postId=get_the_ID();
                 ?>
                 <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                 <?php 
               endwhile; wp_reset_query(); ?>
             </ul>
           </div>
         <?php endif; ?>
          <?php
          $loop = new WP_Query(
           array( 
            'post_type' => 'hf_programs', 
            'posts_per_page' => -1,
            'meta_query' => array(
              array(
                'key'     => 'hfusa-program_director',
                'value' => get_the_ID()
              )
            )
          )  
         ); 

          if($loop->have_posts()) :
            ?>
            <div class="widget">
              <h2 class="widget-title">Programs</h2>
              <ul class="disk-list">
                <?php while($loop->have_posts()) : $loop->the_post();
                $postId=get_the_ID();
                 ?>
                 <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                 <?php 
               endwhile; wp_reset_query(); ?>
             </ul>
           </div>
         <?php endif; ?>

        </div>
      </div>
    </div>
  </div>
</section>
<!--====  End of PAGE  ====-->
