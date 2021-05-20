<?php use Roots\Sage\Titles;?>
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

<?php

    $program_id = get_the_ID();

    $donation_args = array(
        'posts_per_page'   => -1,
        'post_type'        => 'hf_donations',
        'meta_key'         => 'hfusa-program_id',
        'meta_value'       => $program_id
    );
    $donation_query = new WP_Query( $donation_args );

    $donation_posts = $donation_query->posts;

    //echo '<pre>';
    //print_r($cc_query->posts);
    //echo '</pre>';

    $target_amount = get_post_meta( $program_id, 'hfusa-target_price', true );

    $donations_sum = 0;
    $pledges_sum = 0;

    foreach($donation_posts as $donation_post) {

        //echo $donation_post->ID;
        //echo $donation_post->post_title;

        $get_donation_amount = get_post_meta( $donation_post->ID, 'hfusa-donation_amount', true);

        $donation_type = get_post_meta($donation_post->ID, 'hfusa-donation_type', true);

        //echo $get_donation_amount . '<br>';

        if( $donation_type == 'Donation' ) {

            $donations_sum += $get_donation_amount;

        } else {

            $pledges_sum += $get_donation_amount;
        }
    }

    //print_r($donationAmounts);

    $donationResponse = array( "Donations" => $donations_sum, "Pledges" => $pledges_sum, "Target Funds" => $target_amount );

//    header('Content-Type: application/json');
//    echo json_encode($p_array, JSON_PRETTY_PRINT);
    // echo "<pre>";
    // print_r($donationResponse);
    // echo "</pre>";

    //print_r($dAmounts);

    $donations = $donationResponse['Donations'];

?>

<!--====================================
=             PAGE                     =
=====================================-->
<section class="page-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">

                <?php while (have_posts()) : the_post(); ?>
                    <?php the_content(); ?>
                <?php endwhile; wp_reset_query(); ?>

                <?php $projects_loop = new WP_Query( array( 'post_type' => 'hf_projects', 'meta_key' => 'hfusa-project_program', 'meta_value' => get_the_ID(), 'posts_per_page' => -1 ) ); ?>

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
        </div>
    </div>
</section>
<!--====  End of PAGE  ====-->
