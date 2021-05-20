<?php use Roots\Sage\Titles;

$program_id = get_the_ID();
$color = rwmb_meta('hfusa-program_color');
$attachImages = rwmb_meta('hfusa-program_icon', array('limit' => 1));
$programLogo = reset($attachImages);
?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section program-detail-page"
         style="background: <?php echo $color; ?>">

    <div class="iptc-content" style="display: flex; align-items: center; justify-content: center;">
        <div class="breadcrumb-container">
            <h1><?= Titles\title(); ?></h1>
            <?php bootstrap_breadcrumb(); ?>
        </div>
        <div class="logo-container">
            <?php if (isset($programLogo['full_url']) && $programLogo['full_url'] != '') { ?>
                <img alt="" src="<?php echo $programLogo['full_url']; ?>"/>
            <?php } ?>
        </div>
    </div>
    <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<?php


$donation_args = array(
    'posts_per_page' => -1,
    'post_type' => 'hf_donations',
    'meta_key' => 'hfusa-program_id',
    'meta_value' => $program_id
);
$donation_query = new WP_Query($donation_args);

$donation_posts = $donation_query->posts;
$target_amount = get_post_meta($program_id, 'hfusa-target_price', true);

$donations_sum = 0;
$pledges_sum = 0;

foreach ($donation_posts as $donation_post) {
    $get_donation_amount = get_post_meta($donation_post->ID, 'hfusa-donation_amount', true);

    $donation_type = get_post_meta($donation_post->ID, 'hfusa-donation_type', true);

    if ($donation_type == 'Donation') {
        $donations_sum += $get_donation_amount;
    } else {
        $pledges_sum += $get_donation_amount;
    }
}

$donationResponse = array("Donations" => $donations_sum, "Pledges" => $pledges_sum, "Target Funds" => $target_amount);
$donations = $donationResponse['Donations'];

?>

<!--====================================
=             PAGE                     =
=====================================-->
<section class="page-wrapper o-impact-geo-reach program-detail-page">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-8 col-sm-12">
                <div class="hero-container">
                    <?php
                    $programImages = rwmb_meta('hfusa-program_gallery', array('size' => 'thumbnail'));
                    if (!empty($programImages)) {
                        ?>
                        <div class="hero-img-wrapper">
                            <?php
                            foreach ($programImages as $programImage) { ?>

                                <div>
                                    <img src="<?php echo $programImage['full_url']; ?>" alt="" class="hero-img">
                                </div>

                            <?php }
                            ?>
                        </div>
                    <?php } ?>
                    <?php if (!empty($target_amount)) { ?>
                        <div id="stats_progress_bar" class="stats-progress-bar">
                            <div class="cssProgress">
                                <div class="progress1">
                                    <div class="cssProgress-bar"
                                         data-percent="<?php echo round($donations / $target_amount * 100); ?>"
                                         style="width: <?php echo round($donations / $target_amount * 100); ?>%;">
                                <span class="cssProgress-label">
                                    <?php
                                    $percentage = $donations / $target_amount * 100;
                                    echo number_format((float)$percentage, 2, '.', '');
                                    ?>%
                                </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="owpb-bottom-stats">
                            <div class="raised-fund">
                                <h6>raised <span>$<?php echo nice_number($donations); ?>/-</span></h6>
                            </div>
                            <div class="goal-fund">
                                <h6>goal <span>$<?php echo nice_number($target_amount); ?>/-</span></h6>
                            </div>
                        </div>
                    <?php } ?>
                    <ul class="list-unstyled hero-menu">
                        <li>
                            <a href="<?php echo home_url('/stories'); ?>" class="btn btn-hero-menu"><i
                                        class="fa fa-commenting-o" aria-hidden="true"></i> Stories</a>
                        </li>
                        <li>
                            <a href="<?php echo home_url('/photo-gallery'); ?>" class="btn btn-hero-menu"><i
                                        class="fa fa-picture-o" aria-hidden="true"></i> Pictures</a>
                        </li>
                        <?php
                        $product_loop = new WP_Query(array(
                            "post_type" => "product",
                            'meta_query' => array(
                                array(
                                    'key' => 'hfusa-related_programs',
                                    'value' => array($program_id),
                                    'compare' => 'IN',
                                ),
                            ),
                        ));
                        if ($product_loop->have_posts()) :
                            ?>
                            <li>
                                <a href="<?php echo home_url(); ?>/donate?program_id=<?php echo $program_id; ?>"
                                   class="btn btn-hero-menu"><i class="fa fa-heart-o" aria-hidden="true"></i> Donate</a>
                            </li>
                        <?php endif; ?>
                        <li>
                            <a href="<?php echo home_url('/become-a-volunteer'); ?>" class="btn btn-hero-menu"><i
                                        class="fa fa-hand-paper-o" aria-hidden="true"></i> Volunteer</a>
                        </li>
                    </ul>
                </div>

                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile;
                wp_reset_query(); ?>

                <?php $projects_loop = new WP_Query(array('post_type' => 'hf_projects', 'meta_key' => 'hfusa-project_program', 'meta_value' => get_the_ID(), 'posts_per_page' => -1)); ?>

                <?php if ($projects_loop->have_posts()) : ?>

                    <h3 class="projects-heading section-title">Projects</h3>

                    <div class="ow-projects-inside-program-slider">


                        <?php while ($projects_loop->have_posts()) : $projects_loop->the_post(); ?>

                            <div class="owp-block clearfix">
                                <div class="owp-block-inner">
                                    <div class="owp-block-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>"/>
                                        </a>
                                    </div>
                                    <div class="owp-block-title">
                                        <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                                    </div>
                                    <div class="owp-block-desc"><?php the_excerpt(); ?></div>
                                </div>
                            </div>

                        <?php endwhile;
                        wp_reset_query(); ?>

                    </div>

                <?php endif; ?>
                <?php $tumblrPost = new WP_Query(array('post_type' => 'post', 'category_name' => get_the_slug(), 'posts_per_page' => 3)); ?>

                <?php if ($tumblrPost->have_posts()) : ?>
                    <h3 class="projects-heading section-title">Tumblr Posts</h3>
                    <div class="ow-projects-inside-program-slider">


                        <?php while ($tumblrPost->have_posts()) : $tumblrPost->the_post(); ?>

                            <div class="owp-block clearfix">
                                <div class="owp-block-inner">
                                    <?php if (get_the_post_thumbnail_url() != '') { ?>
                                        <div class="owp-block-image tumblr-post-image"
                                             style="background: <?php echo (isset($color) && $color != '') ? $color : "#0069b4" ?>">
                                            <a href="<?php the_permalink(); ?>">
                                                <img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>"
                                                     style="object-fit: cover;"/>
                                            </a>
                                        </div>
                                    <?php } ?>
                                    <div class="owp-block-title">
                                        <a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
                                    </div>
                                    <div class="owp-block-desc"><?php the_excerpt(); ?></div>
                                </div>
                            </div>

                        <?php endwhile;
                        wp_reset_query(); ?>

                    </div>

                <?php endif; ?>
            </div>
            <div class="col-lg-4 col-md-12 col-sm-12">
                <div class="widgets">
                    <?php
                    $program_director = get_post_meta($program_id, 'hfusa-program_director', true);
                    if (!empty($program_director)) {
                        ?>
                        <div class="sidebar-styling widget" style="border: none;">
                            <?php
                            $featured_img_url = get_the_post_thumbnail_url($program_director, 'medium');
                            $program_director_name = get_the_title($program_director);
                            $program_director_link = get_the_permalink($program_director);
                            $member_email = get_post_meta($program_director, 'hfusa-member_email', true);
                            if (!empty($featured_img_url)) {
                                ?>
                                <div class="img-wrapper justify-content-center text-center">
                                    <div class="director-img-wrapper">
                                        <a href="<?php echo $program_director_link; ?>"><img
                                                    src="<?php echo $featured_img_url; ?>" alt="" class="director-img"></a>
                                    </div>
                                </div>
                            <?php }
                            if (!empty($program_director_name)) {
                                ?>
                                <a href="<?php echo $program_director_link; ?>"><h4
                                            class="text-center color-primary"><?php echo $program_director_name; ?></h4>
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

                    <?php /*
                    $product_loop = new WP_Query(array(
                        "post_type" => "product",
                        'meta_query' => array(
                            array(
                                'key' => 'hfusa-related_programs',
                                'value' => array($program_id),
                                'compare' => 'IN',
                            ),
                        ),
                    ));
                    if ($product_loop->have_posts()) :
                        ?>

                        <div class="widget d-none">

                            <div class="widget-content">

                                <div id="testimonials" class="featured-product-slider-cnt">

                                    <h4 class="text-center" style="color: grey;">Featured Products</h4>
                                    <div class="testimonials-list featured-product-slider">
                                        <?php
                                        while ($product_loop->have_posts()) : $product_loop->the_post();
                                            ?>

                                            <div class="featured-product-slide text-center">

                                                <?php
                                                woocommerce_template_loop_product_thumbnail();

                                                woocommerce_template_loop_product_link_open();

                                                do_action('woocommerce_shop_loop_item_title');

                                                woocommerce_template_loop_product_link_close();

                                                woocommerce_template_loop_price();
                                                ?>

                                            </div>
                                        <?php endwhile;
                                        wp_reset_query(); ?>
                                    </div>

                                </div>

                            </div>
                        </div>


                    <?php endif; */ ?>

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
                    $program_countries = get_post_meta(get_the_ID(), 'hfusa-program_countries');
                    if ($program_countries && is_array($program_countries)) {
                        ?>
                        <div class="widget">
                            <h2 class="widget-title">Countries</h2>
                            <ul class="disk-list">
                                <?php
                                foreach ($program_countries as $country_id) {
                                    ?>
                                    <li>
                                        <a href="<?php the_permalink($country_id); ?>"><?php echo get_the_title($country_id); ?></a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    <?php }
                    ?>
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
                    <?php
                    $resources_loop = new WP_Query(
                        array(
                            'post_type' => 'hf_downloads',
                            'posts_per_page' => -1,
                            'meta_query' => array(
                                'relation' => 'AND',
                                array(
                                    'key' => 'hfusa-download_programs',
                                    'value' => get_the_ID()
                                ),
                                array(
                                    'key' => 'hfusa-download_file',
                                    'compare' => 'EXISTS'
                                )
                            )
                        )
                    );

                    if ($resources_loop->have_posts()) :
                        ?>
                        <div class="widget">
                            <h2 class="widget-title">Resources</h2>
                            <ul class="disk-list">
                                <?php while ($resources_loop->have_posts()) : $resources_loop->the_post();
                                    $postId = get_the_ID();
                                    $theFile = get_post_meta($postId, 'hfusa-download_file', true);
                                    if ($theFile) {
                                        ?>
                                        <li>
                                            <a href="<?php the_permalink(); ?>?attachment_post_id=<?php echo $postId ?>&download_file=1"
                                               rel="nofollow"><?php the_title(); ?></a></li>
                                        <?php
                                    }
                                endwhile;
                                wp_reset_query(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <?php

                    $program_questions = get_post_meta(get_the_ID(), 'hfusa-program_questions');
                    if ($program_questions && is_array($program_questions)) {
                        ?>
                        <div class="widget">
                            <h2 class="widget-title">FAQs</h2>
                            <ul class="disk-list">
                                <?php
                                foreach ($program_questions as $key => $id) {
                                    ?>
                                    <li>
                                        <a href="<?php echo esc_url(add_query_arg('faq', $id, home_url('/faqs/'))); ?>"><?php echo get_the_title($id); ?></a>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
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
