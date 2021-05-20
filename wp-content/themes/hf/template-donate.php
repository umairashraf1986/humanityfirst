<?php
/*
 * Template Name: Donate
 */

use Roots\Sage\Titles;
?>
<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>

    <div class="iptc-content">
        <h1><?= Titles\title(); ?></h1>
        <?php bootstrap_breadcrumb(); ?>
    </div>

    <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<section class="page-wrapper donate-page">
    <div class="container">
        <?php while (have_posts()) : the_post(); ?>
        <div class="row">
            <div class="col-lg-9 col-md-8 col-sm-12">
                <div class="text-paragraph"><?php the_content(); ?></div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-12">
                <?php
                $group_value = rwmb_meta( 'donate_page_button_fields' );
                if(!empty($group_value)){
                    foreach ($group_value as $key => $value) {
                        $btnLabel = isset($value['hfusa-donate_label'])? $value['hfusa-donate_label'] : 'Donate Now';
                        if(isset($value['hfusa-donate_url'])){
                            echo '<a class="btn btn-primary col-lg-12 col-md-12 col-sm-12" href="'.$value['hfusa-donate_url'].'" target="_blank">'.$btnLabel.'</a>';
                        }
                    }
                }
                ?>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>
