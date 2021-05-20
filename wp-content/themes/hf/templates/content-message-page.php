<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section program-detail-page" <?php echo hf_header_bg_img(); ?>>

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
            <div class="col-md-12 col-lg-8 col-sm-12">

                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile;
                wp_reset_query(); ?>

            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="widgets">
                    <?php
                    $director = get_post_meta(get_the_ID(), 'hfusa-director', true);
                    if (!empty($director)) {
                        ?>
                        <div class="sidebar-styling widget" style="border: none;">
                            <?php
                            $featured_img_url = get_the_post_thumbnail_url($director, 'medium');
                            $director_name = get_the_title($director);
                            $director_link = get_the_permalink($director);
                            $member_email = get_post_meta($director, 'hfusa-member_email', true);
                            if (!empty($featured_img_url)) {
                                ?>
                                <div class="img-wrapper justify-content-center text-center">
                                    <div class="director-img-wrapper">
                                        <a href="<?php echo $director_link; ?>"><img
                                                    src="<?php echo $featured_img_url; ?>" alt="" class="director-img"></a>
                                    </div>
                                </div>
                            <?php }
                            if (!empty($director_name)) {
                                ?>
                                <a href="<?php echo $director_link; ?>"><h4
                                            class="text-center color-primary"><?php echo $director_name; ?></h4>
                                </a>
                            <?php }
                            if (!empty($member_email)) {
                                ?>
                                <div class="text-center">
                                    <a href="mailto:<?php echo $member_email; ?>" class="btn btn-blue"><i
                                                class="fa fa-envelope-o" aria-hidden="true"></i> Contact</a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php }
                    $chairman = get_post_meta(get_the_ID(), 'hfusa-chairman', true);
                    if (!empty($chairman)) {
                    ?>
                    <div class="sidebar-styling widget" style="border: none;">
                        <?php
                        $featured_img_url = get_the_post_thumbnail_url($chairman, 'medium');
                        $chairman_name = get_the_title($chairman);
                        $chairman_link = get_the_permalink($chairman);
                        $member_email = get_post_meta($chairman, 'hfusa-member_email', true);
                        if (!empty($featured_img_url)) {
                            ?>
                            <div class="img-wrapper justify-content-center text-center">
                                <div class="director-img-wrapper">
                                    <a href="<?php echo $chairman_link; ?>"><img
                                                src="<?php echo $featured_img_url; ?>" alt="" class="director-img"></a>
                                </div>
                            </div>
                        <?php }
                        if (!empty($chairman_name)) {
                            ?>
                            <a href="<?php echo $chairman_link; ?>"><h4
                                        class="text-center color-primary"><?php echo $chairman_name; ?></h4>
                            </a>
                        <?php }
                        if (!empty($member_email)) {
                            ?>
                            <div class="text-center">
                                <a href="mailto:<?php echo $member_email; ?>" class="btn btn-blue"><i
                                            class="fa fa-envelope-o" aria-hidden="true"></i> Contact</a>
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
                                                        <div class="testimonial-user clearfix">
                                                            <div class="testimonial-user-image"><img
                                                                        src="<?php echo $testimonial_post_thumbnail_url; ?>"
                                                                        alt="<?php echo $testimonial_title; ?>"></div>
                                                            <div class="testimonial-user-name"><?php echo $testimonial_title; ?></div>
                                                            <div class="testimonial-caret"><i
                                                                        class="fa fa-caret-down"></i></div>
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
                                            <?php echo $quote_content; ?>
                                        </p>

                                        <div class="blog-post-actions">
                                            <hr>
                                            <p class="blog-post-bottom pull-left">

                                                <?php echo $quote_author_name; ?> <em>
                                                    <small> - <?php echo $quote_author_designation; ?></small>
                                                </em>
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
                </div>
            </div>
        </div>
    </div>
</section>
<!--====  End of PAGE  ====-->
