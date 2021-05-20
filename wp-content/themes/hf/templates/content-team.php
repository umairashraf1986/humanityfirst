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

<!--==============================
=            Team            =
===============================-->

<section class="blog-content page-wrapper">
    <div class="hf-grid-layout container-fluid">
        <div class="row rtl-display">
            <div class="col-12 float-left">

                <div class="row">
                    <div class="col-12 ">
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- <div class="row">

					<div class="col">

						<div class="generic-slider text-center">
							<?php $loop = new WP_Query(array('post_type' => 'amp_members', 'posts_per_page' => -1)); ?>
							<?php while ($loop->have_posts()) : $loop->the_post(); ?>





								<div class="owp-block clearfix">
									<div class="owp-block-inner">
										<div class="owp-block-image">
											<a href="<?php the_permalink(); ?>">
												<img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"/>
											</a>
										</div>
										<div class="owp-block-title">
											<a href="<?php the_permalink(); ?>"><h4><?php the_title(); ?></h4></a>
											<h6><small><?php echo rwmb_meta('amp-member_designation'); ?></small></h6>
										</div>
										<div class="owp-block-desc"><?php the_excerpt(); ?></div>
									</div>
								</div>
							<?php endwhile;
                wp_reset_query(); ?>
						</div>

					</div>

				</div> -->
                <div class="row hf-gl-row">

                    <?php $loop = new WP_Query(array('post_type' => 'hf_members', 'posts_per_page' => -1,
                        'order' => 'ASC',
                        'orderby' => 'meta_value title',
                        'meta_query' => array(
                            'relation' => 'OR',
                            array('key' => 'hfusa-member_position', 'compare' => 'NOT EXISTS'),
                            array('key' => 'hfusa-member_position', 'compare' => 'EXISTS')
                        )));
                    $sortTitleArr = array();
                    ?>
                    <?php while ($loop->have_posts()) : $loop->the_post(); ?>
                        <?php
                        $member_designation = rwmb_meta('hfusa-member_designation');
                        $sortOrder = get_post_meta(get_the_ID(), 'hfusa-member_position', true);
                        if($sortOrder != ''  && $sortOrder > 0) {
                            ?>
                            <div class="col-lg-3 col-md-6 col-sm-12 Event<?php echo $category_names; ?> col-team">

                                <div class="hf-gl-item">
                                    <div class="hf-gl-wrapper" style="padding-top: 20px;">
                                        <div class="hf-gl-item-img" style="max-width: 150px; margin: 0 auto;">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?php echo get_the_post_thumbnail_url(); ?>"
                                                     alt="<?php the_title(); ?>" style="border-radius: 0;"/>
                                            </a>
                                        </div>
                                        <h2 class="hf-gl-item-heading text-center">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        <div class="clearfix"></div>
                                        <h3 class="member-designation text-center"><?php echo $member_designation; ?></h3>
                                        <div class="hf-gl-item-text text-center">
                                            <?php the_excerpt(); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }else{
                            $sortTitleArr[] = '<div class="col-lg-3 col-md-6 col-sm-12 Event<?php echo $category_names; ?> col-team">

                                <div class="hf-gl-item">
                                    <div class="hf-gl-wrapper" style="padding-top: 20px;">
                                        <div class="hf-gl-item-img" style="max-width: 150px; margin: 0 auto;">
                                            <a href="'.get_the_permalink().'">
                                                <img src="'.get_the_post_thumbnail_url().'"
                                                     alt="'.get_the_title().'" style="border-radius: 0;"/>
                                            </a>
                                        </div>
                                        <h2 class="hf-gl-item-heading text-center">
                                            <a href="'.get_the_permalink().'">'.get_the_title().'</a>
                                        </h2>
                                        <div class="clearfix"></div>
                                        <h3 class="member-designation text-center">'.$member_designation.'</h3>
                                        <div class="hf-gl-item-text text-center">
                                            '.get_the_excerpt().'
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                    endwhile;
                    wp_reset_query(); ?>
                    <?php
                    if(!empty($sortTitleArr)){
                        foreach ($sortTitleArr as $key => $value){
                            echo $value;
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="clearfix"></div>

<!--====  End of Team  ====-->
