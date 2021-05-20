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

  <section class="blog-content our-work-programs page-wrapper">
    <div class="container-fluid hf-grid-layout">
      <div class="text-paragraph"><?php the_content(); ?></div>
      <div class="row hf-gl-row">

        <?php $loop = new WP_Query(
                array(
                    'post_type' => 'hf_glbl_sites',
                    'posts_per_page' => -1,
                    'order' => 'ASC',
                    'orderby' => 'meta_value title',
                    'meta_query' => array(
                        'relation' => 'OR',
                        array('key' => 'hfusa-_position', 'compare' => 'NOT EXISTS'),
                        array('key' => 'hfusa-_position', 'compare' => 'EXISTS')
                    )
                )
        ); $sortTitleArr = array();
        ?>
          <?php while ($loop->have_posts()) : $loop->the_post();
          $sortOrder = get_post_meta(get_the_ID(), 'hfusa-_position', true);
          if ($sortOrder != '' && $sortOrder > 0) {
              ?>
              <div class="col-lg-4 col-md-6 col-sm-12 col-xl-3">
                  <div class="hf-gl-item">
                      <div class="hf-gl-wrapper">
                          <div class="hf-gl-item-img" style="overflow: hidden; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                              <a href="<?php the_permalink(); ?>">
                                  <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"
                                       style="object-fit: contain; margin: 0 auto; display: block; height: auto;"/>
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
          }else{
              $sortTitleArr[] = '<div class="col-lg-3 col-md-6 col-sm-12" >
                                <div class="hf-gl-item">
                                    <div class="hf-gl-wrapper">
                                        <div class="hf-gl-item-img">
                                            <a href="' . get_the_permalink() . '">
                                                <img src="' . get_the_post_thumbnail_url() . '"
                                                     alt="' . get_the_title() . '" style="object-fit: contain; border: 1px solid #ccc; margin: 0 auto; display: block; width: auto;"/>
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
  <!--====  End of Partners  ====-->
