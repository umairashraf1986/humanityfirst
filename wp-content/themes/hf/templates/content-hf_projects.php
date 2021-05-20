<?php use Roots\Sage\Titles; ?>
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

<?php
$project_id = get_the_ID();

$post_status = get_post_status($project_id);

$post_type = get_post_type($project_id);

if ($post_status == "publish" && $post_type == "hf_projects") {

    $donation_args = array(
        'posts_per_page' => -1,
        'post_type' => 'hf_donations',
        'meta_key' => 'hfusa-project_id',
        'meta_value' => $project_id
    );
    $donation_query = new WP_Query($donation_args);

    $donation_posts = $donation_query->posts;

//echo '<pre>';
//print_r($cc_query->posts);
//echo '</pre>';

    $target_amount = get_post_meta($project_id, 'hfusa-target_price', true);

    $donations_sum = 0;
    $pledges_sum = 0;

    foreach ($donation_posts as $donation_post) {

        //echo $donation_post->ID;
        //echo $donation_post->post_title;

        $get_donation_amount = get_post_meta($donation_post->ID, 'hfusa-donation_amount', true);

        $donation_type = get_post_meta($donation_post->ID, 'hfusa-donation_type', true);

        //echo $get_donation_amount . '<br>';

        if ($donation_type == 'Donation') {

            $donations_sum += $get_donation_amount;

        } else {

            $pledges_sum += $get_donation_amount;
        }
    }

//print_r($donationAmounts);

    $donationResponse = array("Donations" => $donations_sum, "Pledges" => $pledges_sum, "Target Funds" => $target_amount);

//    echo "<pre>";
//    print_r($donationResponse);
//    echo "</pre>";

    $donations = $donationResponse['Donations'];
}

?>
<div class="page-content">

    <!--====================================
    =       Current Happenings             =
    =====================================-->
    <section class="project-detail-container page-wrapper o-impact-geo-reach padd-two-sixty-four">
        <div class="container">
            <div class="row rtl-display">
                <div class="col-md-12 col-lg-8 col-sm-12 float-left">
                    <div class="proj-detail-cont">
                        <div class="hero-container">
                            <?php
                            $projectImages = rwmb_meta('hfusa-project_gallery', array('size' => 'thumbnail'));
                            if (!empty($projectImages)) {
                                ?>
                                <div class="hero-img-wrapper">
                                    <?php
                                    foreach ($projectImages as $projectImage) { ?>

                                        <div>
                                            <img src="<?php echo $projectImage['full_url']; ?>" alt="" class="hero-img">
                                        </div>

                                    <?php }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                        <?php while (have_posts()) : the_post(); ?>
                            <div class="text-paragraph"><?php the_content(); ?></div>
                        <?php endwhile;
                        wp_reset_query(); ?>
                    </div>
                </div>

                <div class="col-lg-4 col-md-12 col-sm-12 float-right">
                    <div class="widgets">
                        <?php
                        $program_id = get_post_meta($project_id, 'hfusa-project_program', true);
                        $attachImages = rwmb_meta( 'hfusa-program_logo', array( 'limit' => 1 ), $program_id );
                        $programImage = reset( $attachImages );
                        if(!empty($programImage['full_url'])){
                            ?>
                            <div class="sidebar-styling widget" style="border: none;">
                                <div class="img-wrapper justify-content-center text-center">
                                    <div class="director-img-wrapper">

                                        <img src="<?php echo $programImage['full_url']; ?>" alt="" class="director-img">
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                        <?php
                        $project_director = get_post_meta( $project_id, 'hfusa-project_director', true);
                        if(!empty($project_director)){
                            ?>
                            <div class="sidebar-styling widget" style="border: none;">
                                <?php                        
                                $featured_img_url = get_the_post_thumbnail_url($project_director,'medium');
                                $project_director_name = get_the_title( $project_director );
                                $project_director_link = get_the_permalink( $project_director );
                                $member_email = get_post_meta( $project_director, 'hfusa-member_email', true);
                                if(!empty($featured_img_url)){
                                    ?>
                                    <div class="img-wrapper justify-content-center text-center">                           
                                        <div class="director-img-wrapper">  
                                            <a href="<?php echo $project_director_link; ?>"><img src="<?php echo $featured_img_url;?>" alt="" class="director-img" style="filter: invert(0);"></a>
                                        </div>
                                    </div>
                                <?php } 
                                if(!empty($project_director_name)){
                                    ?>
                                    <a href="<?php echo $project_director_link; ?>"><h4 class="text-center color-primary"><?php echo $project_director_name; ?></h4></a>
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
                                                            <div class="testimonial-user clearfix">
                                                                <div class="testimonial-user-image"><img
                                                                            src="<?php echo $testimonial_post_thumbnail_url; ?>"
                                                                            alt="<?php echo $testimonial_title; ?>">
                                                                </div>
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
                        $project_countries= get_post_meta( get_the_ID(), 'hfusa-project_countries' );
                        if($project_countries && is_array($project_countries)) {
                            ?>
                            <div class="widget">
                                <h2 class="widget-title">Countries</h2>
                                <ul class="disk-list">
                                    <?php
                                    foreach($project_countries as $country_id){
                                        ?>
                                        <li>
                                            <a href="<?php the_permalink($country_id); ?>"><?php echo get_the_title($country_id); ?></a>
                                        </li>
                                    <?php  } ?>
                                </ul>
                            </div>
                        <?php }
                        ?>
                        <?php
                        $resources_loop = new WP_Query(array(
                            "post_type" => "hf_downloads",
                            "meta_key" => 'hfusa-download_projects',
                            "meta_value" => get_the_ID(),
                            "posts_per_page" => -1
                        ));
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

                        $project_questions = get_post_meta(get_the_ID(), 'hfusa-project_questions');
                        if ($project_questions && is_array($project_questions)) {
                            ?>
                            <div class="widget">
                                <h2 class="widget-title">FAQs</h2>
                                <ul class="disk-list">
                                    <?php
                                    foreach ($project_questions as $key => $id) {
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
            <div class="clearfix"></div>
    </section>
</div>
<div class="clearfix"></div>
<!--====  end of Current Happenings  ====-->
