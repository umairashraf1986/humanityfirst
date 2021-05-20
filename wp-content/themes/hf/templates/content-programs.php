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

<!--====================================
=             Our Work                 =
=====================================-->
<!--====  programs  ====-->
<section class="blog-content our-work-programs page-wrapper">
    <div class="container-fluid hf-grid-layout">
        <?php if(get_post()->post_content !== '') { ?>
        <div class="text-paragraph"><?php the_content(); ?></div>
        <?php } ?>
        <div class="row hf-gl-row">

            <?php
            $general_program = get_page_by_path('general', OBJECT, 'hf_programs');
            $general_program_id = !empty($general_program->ID) ? $general_program->ID : 0;
            $programs_loop = new WP_Query(
                array(
                    'post_type' => 'hf_programs',
                    'post__not_in' => array($general_program_id),
                    'posts_per_page' => -1,
                    'order' => 'ASC',
                    'orderby' => 'meta_value title',
                    'meta_query' => array(
                        'relation' => 'OR',
                        array('key' => 'hfusa-_position', 'compare' => 'NOT EXISTS'),
                        array('key' => 'hfusa-_position', 'compare' => 'EXISTS')
                    ),
                )
            );
            $sortTitleArr = array();
            ?>
            <?php if ($programs_loop->have_posts()) {
                while ($programs_loop->have_posts()) : $programs_loop->the_post(); ?>
                    <?php $color = rwmb_meta('hfusa-program_color');
                    $sortOrder = get_post_meta(get_the_ID(), 'hfusa-_position', true);
                    if ($sortOrder != '' && $sortOrder > 0) { ?>
                        <div class="col-lg-4 col-md-6 col-sm-12 col-xl-3 Event<?php echo $category_names; ?>">

                            <div class="hf-gl-item h-100"
                                 style="background: transparent; margin-bottom: 0; padding-bottom: 20px;">
                                <div class="hf-gl-wrapper h-100"
                                     style="background: <?php echo (!empty($color)) ? $color : '#0069b4'; ?>; border-radius: 5px;">
                                    <div class="hf-gl-item-img" style="position: relative; overflow: hidden; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                                        <a href="<?php the_permalink(); ?>">
                                            <img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>"/>

                                            <div class="owp-icon-container owp-icon-wrapper programs-hover-st2"
                                                 style="background: #000000;opacity:0.65; position: absolute; left: 0; right: 0; top: 0; bottom: 0; width: 100%; height: 100%;">
                                                <?php
                                                $attachImages = rwmb_meta('hfusa-program_logo', array('limit' => 1));
                                                $programImage = reset($attachImages);
                                                if (!empty($programImage['full_url'])) {
                                                    ?>
                                                    <img alt="" class="owp-icon"
                                                         src="<?php echo $programImage['full_url']; ?>"
                                                         style="object-fit: none;"/>
                                                <?php } ?>
                                            </div>
                                        </a>
                                    </div>
                                    <h2 class="hf-gl-item-heading" style="height: auto;color:#ffffff">
                                        <a href="<?php the_permalink(); ?>"
                                           style="color:#ffffff"><?php the_title(); ?></a>
                                    </h2>
                                    <div class="clearfix"></div>
                                    <div class="hf-gl-item-text"
                                         style="padding-top: 0; padding-left: 15px; color:#ffffff;">
                                        <?php the_excerpt(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php } else {
                        if (!empty($color)) {
                            $color;
                        } else {
                            $color = '#0069b4';
                        }

                        $attachImages = rwmb_meta('hfusa-program_logo', array('limit' => 1));
                        $programImage = reset($attachImages);
                        if (!empty($programImage['full_url'])) {
                            $img = '<img alt="" class="owp-icon"
                                                     src="' . $programImage['full_url'] . '"
                                                     style="object-fit: none;"/>';
                        }
                        $sortTitleArr[] = '<div class="col-lg-3 col-md-6 col-sm-12" >
                                <div class="hf-gl-item h-100"
                                 style="background: transparent; margin-bottom: 0; padding-bottom: 20px;">
                                    <div class="hf-gl-wrapper h-100"
                                     style="background: ' . $color . '; border-radius: 5px;">
                                        <div class="hf-gl-item-img" style="position: relative; overflow: hidden; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                                            <a href="' . get_the_permalink() . '">
                                                <img src="' . get_the_post_thumbnail_url() . '"
                                                     alt="' . get_the_title() . '"/>
                                                     <div class="owp-icon-container owp-icon-wrapper programs-hover-st2"
                                                 style="background: #000000;opacity:0.65; position: absolute; left: 0; right: 0; top: 0; bottom: 0; width: 100%; height: 100%;">
                                                 '.$img.'
                                                 </div>
                                            </a>
                                        </div>
                                        <h2 class="hf-gl-item-heading" style="height: auto;color:#ffffff">
                                            <a href="' . get_the_permalink() . '" style="color:#ffffff">' . get_the_title() . '</a>
                                        </h2>
                                        <div class="clearfix"></div>
                                        <div class="hf-gl-item-text" style="padding-top: 0; padding-left: 15px; color:#ffffff;">
                                            ' . get_the_excerpt() . '
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }
                endwhile;
            }
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
<!--====  end of programs  ====-->


<!--====  End of Our Work  ====-->
