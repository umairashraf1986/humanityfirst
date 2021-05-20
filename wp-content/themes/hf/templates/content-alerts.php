<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section about-us-page alerts-sub-header" <?php echo hf_header_bg_img(); ?>>

  <div class="iptc-content">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<section class="blog-content page-wrapper">

  <div class="hf-grid-layout hf-gl-events">
    <div class="container-fluid">
      <div class="row hf-gl-row">

        <?php $i = 0;  $loop = new WP_Query( array( 'post_type' => 'hf_alerts', 'posts_per_page' => -1 ) ); ?>
        <?php if( $loop->have_posts() ) { ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <?php
            $i++;
            $category_names = "";
            $categories = wp_get_post_terms(get_the_ID(), 'events_category', array("fields" => "all"));

            foreach($categories as $category){
              $category_names .= " ".$category->name;
            }
            ?>
            <div class="col-lg-3 col-md-6 col-sm-12 Event<?php echo $category_names; ?>">

              <div class="hf-gl-item h-100">
                <div class="hf-gl-wrapper h-100">
                  <?php $alert_img =  get_the_post_thumbnail_url();
                  if( !empty($alert_img) ) {
                    ?>
                    <div class="hf-gl-item-img" style="overflow: hidden; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                      <a href="<?php the_permalink(); ?>">
                        <img src="<?php echo $alert_img; ?>" alt="<?php the_title(); ?>"/>
                      </a>
                    </div>
                  <?php } ?>
                  <h2 class="hf-gl-item-heading">
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                  </h2>
                  <div class="hf-gl-item-cat event-info">

                    <span class="event-date"><i class="fa fa-clock-o"></i> <?php echo get_the_date(); ?></span>

                  </div>
                  <div class="clearfix"></div>
                  <div class="hf-gl-item-text">
                    <?php the_excerpt(); ?>
                  </div>
                  <div class="hf-gl-item-event-buttons">
                    <a href="<?php the_permalink(); ?>" class="event-more-info w-100" style="border-bottom-right-radius: 5px; color: #ffffff; background-color: #0069b4;">
                      <i class="fa fa-file-text"></i> Read More
                    </a>
                  </div>
                </div>

              </div>
            </div>

            <?php if( $i%4 == 0 ) {?>
              <div class="clearfix d-none d-lg-block d-xl-block"></div>
            <?php } ?>
          <?php endwhile; wp_reset_query(); ?>
        <?php } else { ?>
          <p class="text-center w-100">Currently there are no alerts...</p>
        <?php } ?>
      </div>
    </div>
  </div>

</section>
<div class="clearfix"></div>