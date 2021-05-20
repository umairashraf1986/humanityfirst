<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section program-detail-page"  <?php echo hf_header_bg_img(); ?>>
  
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
<section class="page-wrapper o-impact-geo-reach">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-sm-12">
                <?php
                    $countryImages = rwmb_meta( 'hfusa-country_gallery', array( 'size' => 'thumbnail' ) );
                    if( !empty($countryImages) ) {
                ?>
                <div class="hero-container">
                    <div class="hero-img-wrapper">
                        <?php
                        foreach ( $countryImages as $countryImage ) { ?>

                            <div>
                                <img src="<?php echo $countryImage['full_url']; ?>" alt="" class="hero-img">
                            </div>

                        <?php }
                        ?>
                    </div>
                </div>
                <?php } ?>
                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; wp_reset_query(); ?>


                <?php $projects_loop = new WP_Query( array( 'post_type' => 'hf_projects', 'meta_key' => 'hfusa-project_countries', 'meta_value' => get_the_ID(), 'posts_per_page' => -1 ) ); ?>

                <?php if($projects_loop->have_posts()) : ?>

                <h3 class="projects-heading section-title">Projects</h3>

                <div class="ow-projects-inside-program-slider">

                    
                    <?php while ( $projects_loop->have_posts() ) : $projects_loop->the_post(); ?>
                                    
                        <div class="owp-block clearfix">
                            <div class="owp-block-inner">
                                <div class="owp-block-image">
                                    <a href="<?php the_permalink(); ?>">
                                      <img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>"/>
                                    </a>
                                </div>
                                <div class="owp-block-title">
                                    <a href="<?php the_permalink(); ?>">    <h4><?php the_title(); ?></h4></a>
                                </div>
                                <div class="owp-block-desc"><?php the_excerpt(); ?></div>
                            </div>
                        </div>

                    <?php endwhile; wp_reset_query(); ?>

                </div>

                <?php endif; ?>

            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="widgets">
                     <?php
                    $program_director = get_post_meta( get_the_ID(), 'hfusa-program_director', true);
                    if(!empty($program_director)){
                    ?>
                    <div class="sidebar-styling widget" style="border: none;">
                        <?php                        
                        $featured_img_url = get_the_post_thumbnail_url($program_director,'medium');
                        $program_director_name = get_the_title( $program_director );
                        $program_director_link = get_the_permalink( $program_director );
                        $member_email = get_post_meta( $program_director, 'hfusa-member_email', true);
                        if(!empty($featured_img_url)){
                            ?>
                            <div class="img-wrapper justify-content-center text-center">                           
                                <div class="director-img-wrapper">  
                                    <a href="<?php echo $program_director_link; ?>"><img src="<?php echo $featured_img_url;?>" alt="" class="director-img"></a>
                                </div>
                            </div>
                            <?php } 
                            if(!empty($program_director_name)){
                                ?>
                               <a href="<?php echo $program_director_link; ?>"><h4 class="text-center color-primary"><?php echo $program_director_name; ?></h4></a>
                            <?php } 
                            if(!empty($member_email)){
                                ?>
                                <div class="text-center">
                                    <a href="mailto:<?php echo $member_email; ?>" class="btn btn-blue"><i class="fa fa-envelope-o" aria-hidden="true"></i> Contact</a>
                                </div>
                            <?php } ?>
                    </div>
                    <?php } ?>
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

                                            </div>
                                        </div>
                                      <div class="testimonial-user clearfix">
                                        <div class="testimonial-user-image"><img src="<?php echo $testimonial_post_thumbnail_url; ?>" alt="<?php echo $testimonial_title; ?>"></div>
                                        <div class="testimonial-user-name"><?php echo $testimonial_title; ?></div>
                                        <div class="testimonial-caret"><i class="fa fa-caret-down"></i></div>
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

                                <div class="blog-post-actions"><hr>
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
                        $active_since_date = rwmb_meta( 'hfusa-active_in_country_date' ); 
                        if( $active_since_date != "" ) {
                    ?>

                    <div class="widget">
                        <h2 class="widget-title">Active Since</h2>
                        <p><?php echo date('F jS, Y', $active_since_date); ?></p>
                    </div>

                    <?php } ?>
                    
                    <?php
                        $programs_loop = new WP_Query( array(
                                                "post_type" => "hf_programs",
                                                "meta_key" => 'hfusa-program_countries',
                                                "meta_value" => get_the_ID(),
                                                "posts_per_page" => -1
                        ));
                        if($programs_loop->have_posts()) :
                    ?>
                    <div class="widget">
                        <h2 class="widget-title">Programs</h2>
                        <ul class="disk-list">
                            <?php while($programs_loop->have_posts()) : $programs_loop->the_post(); ?>
                                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                            <?php endwhile; wp_reset_query(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php
                    $resources_loop = new WP_Query(
                       array( 
                          'post_type' => 'hf_downloads', 
                          'posts_per_page' => -1,
                          'meta_query' => array(
                            'relation' => 'AND',
                            array(
                              'key'     => 'hfusa-download_regions',
                              'value' => get_the_ID()
                          ),
                            array(
                              'key'     => 'hfusa-download_file',
                              'compare' => 'EXISTS'
                          )
                        )
                      )  
                   ); 

                    if($resources_loop->have_posts()) :
                        ?>
                    <div class="widget">
                        <h2 class="widget-title">Resources</h2>
                        <ul class="disk-list">
                            <?php while($resources_loop->have_posts()) : $resources_loop->the_post();
                            $postId=get_the_ID();
                            $theFile= get_post_meta( $postId, 'hfusa-download_file',true );
                            if($theFile){
                             ?>
                                <li><a href="<?php the_permalink(); ?>?attachment_post_id=<?php echo $postId ?>&download_file=1"  rel="nofollow"><?php the_title(); ?></a></li>
                            <?php 
                            }
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
