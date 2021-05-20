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

<!--====  Sponsors  ====-->
<!-- <section class="about-us-sponsors sponsors-page-wrapper page-wrapper">
    <div class="container">
        <div class="text-paragraph"><?php the_content(); ?></div>
        <div class="row">
            <div class="col-md-12 col-sm-12">
                <?php
$args = array(
    'taxonomy' => 'sponsor_category',
    'hide_empty' => true,
);

$cats = get_categories($args);

$cat_count = 1;
if ($cats && !empty($cats)) :
    foreach ($cats as $cat) :
        ?>
                        <div class="tab-pane-sponsors">
                            <h3><?php echo $cat->name; ?></h3>
                            <?php

        $args = array(
            'post_type' => 'hf_sponsors',
            'tax_query' => array(
                array(
                    'taxonomy' => 'sponsor_category',
                    'field' => 'slug',
                    'terms' => $cat->slug,
                ),
            ),
        );
        $query = new WP_Query($args);

        if ($query->have_posts()) {
            echo '<ul class="sponsor-img-cnt">';
            while ($query->have_posts()) {
                $query->the_post();
                echo '<li class="col-sm-3 sponsor-img">';
                the_post_thumbnail('medium');
                echo '</li>';
            }
            echo '</ul>';
            /* Restore original Post Data */
            wp_reset_postdata();
        }
        ?>
                        </div>
                        <?php
        $cat_count++;
    endforeach;
endif;
?>
            </div>
        </div>
    </div>
</section> -->

<section class="blog-content our-work-programs page-wrapper">
    <div class="container-fluid hf-grid-layout">
        <div class="text-paragraph"><?php the_content(); ?></div>
        <div class="row hf-gl-row hf-grid-layout">

            <?php $loop = new WP_Query(array(
                'post_type' => 'hf_sponsors',
                'meta_query' => array(
                    'relation' => 'OR',
                    array('key' => 'hfusa-_position', 'compare' => 'NOT EXISTS'),
                    array('key' => 'hfusa-_position', 'compare' => 'EXISTS')
                ),
                'posts_per_page' => -1,
                'order' => 'ASC',
                'orderby' => 'meta_value title',
            ));
            $sortTitleArr = array();
            ?>
            <?php while ($loop->have_posts()) : $loop->the_post();
                $sortOrder = get_post_meta(get_the_ID(), 'hfusa-_position', true);
                if ($sortOrder != '' && $sortOrder > 0) {
                    ?>
                    <div class="col-lg-3 col-md-6 col-sm-12">
                        <div class="hf-gl-item h-100">
                            <div class="hf-gl-wrapper h-100">
                                <div class="hf-gl-item-img">
                                    <a href="<?php the_permalink(); ?>">
                                        <img src="<?php echo get_the_post_thumbnail_url(); ?>"
                                             alt="<?php the_title(); ?>"
                                             style="object-fit: contain;"/>
                                    </a>
                                </div>
                                <h2 class="hf-gl-item-heading" style="height: auto;">
                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                </h2>
                                <div class="clearfix"></div>
                                <div class="hf-gl-item-text" style="padding-top: 0; padding-left: 15px;">
                                    <?php the_excerpt(); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                } else {
                    $sortTitleArr[] = '<div class="col-lg-3 col-md-6 col-sm-12" >
                                <div class="hf-gl-item h-100" style="background: transparent; margin-bottom: 0; border-radius: 0; padding-bottom: 20px;">
                                    <div class="hf-gl-wrapper h-100"
                             style="background: white; border-radius: 5px; overflow: hidden;">
                                        <div class="hf-gl-item-img">
                                            <a href="' . get_the_permalink() . '">
                                                <img src="' . get_the_post_thumbnail_url() . '"
                                                     alt="' . get_the_title() . '" style="object-fit: contain;"/>
                                            </a>
                                        </div>
                                        <h2 class="hf-gl-item-heading" style="height: auto;">
                                            <a href="' . get_the_permalink() . '">' . get_the_title() . '</a>
                                        </h2>
                                        <div class="clearfix"></div>
                                        <div class="hf-gl-item-text" style="padding-top: 0; padding-left: 15px;">
                                            ' . get_the_excerpt() . '
                                        </div>
                                    </div>
                                </div>
                            </div>';
                }
            endwhile;
            wp_reset_query(); ?>
            <?php
            if (!empty($sortTitleArr)) {
                foreach ($sortTitleArr as $key => $value) {
                    echo $value;
                }
            }
            ?>
        </div>
    </div>
</section>

<div class="clearfix"></div>
<!--====  end of Sponsors  ====-->
