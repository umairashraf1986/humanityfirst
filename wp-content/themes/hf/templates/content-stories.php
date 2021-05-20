<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>

  <div class="iptc-content filter-head-block">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<!--====================================
=              our Impact             =
=====================================-->
<section class="stories-container-main page-wrapper stories-container-adjustments">
  <div class="">
    <div class="col-12">
      <div class="hf-gl-header">
        <ul class="hf-filter hf-news-filter">
          <li><a href="#!" id="all-link-stories">All</a></li>
          <li><a href="#!" id="featured-link"><i class="fa fa-bookmark-o"></i> Featured</a></li>
          <li><a href="#!" id="popular-link"><i class="fa fa-bolt"></i> Popular</a></li>
        </ul>
      </div>
    </div>
  </div>
  <div class="container-fluid blog-content">

    <div class="rtl-display">
      <div class="col-12 float-left">
        <div class="events-main-inner">

          <div class="row hf-gl-row hf-gl-layout hf-grid-layout">
            <?php $i = 0; $loop = new WP_Query(array('post_type' => 'post', 'category_name' => 'stories', 'posts_per_page' => -1)); ?>
            <?php while ($loop->have_posts()) : $loop->the_post(); ?>
              <?php
              $i++;
              $category_names = "";
              foreach ((get_the_category()) as $category) {
                $category_names .= " " . $category->name;
              }
              ?>
              <div class="col-lg-3 col-md-4 col-sm-12<?php echo $category_names; ?>">

                <div class="hf-gl-item h-100" style="margin-bottom: 0; padding-bottom: 20px;">
                  <div class="hf-gl-wrapper h-100" style="display: flex; flex-direction: column;">
                    <div class="hf-gl-item-cat">
                      <?php
                      if (in_category('Featured')) { ?>

                        <span class="featured-tag"><i class="fa fa-bookmark-o"></i> Featured</span>
                        <span class="post-on"><i class="fa fa-clock-o"></i> <?php echo get_the_date(); ?></span>

                      <?php } elseif (in_category('Popular')) { ?>

                        <span class="popular-tag"><i class="fa fa-bolt"></i> Popular</span>
                        <span class="post-on"><i class="fa fa-clock-o"></i> <?php echo get_the_date(); ?></span>

                      <?php } else { ?>

                        <span class="post-on"><i class="fa fa-clock-o"></i> <?php echo get_the_date(); ?></span>

                      <?php }
                      ?>

                    </div>
                    <div class="hf-gl-item-text">
                      <?php the_excerpt(); ?>
                    </div>
                    <?php $story_img =  get_the_post_thumbnail_url();
                    if( !empty($story_img) ) {
                      ?>
                      <div class="hf-gl-item-img" style="margin-top: auto;">
                        <a href="<?php the_permalink(); ?>">
                          <img src="<?php echo $story_img; ?>" alt="<?php the_title(); ?>"/>
                        </a>
                      </div>
                    <?php } ?>
                    <h2 class="hf-gl-item-heading" style="margin-top: 0;">
                      <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>
                    <div class="hf-gl-item-meta" style="margin-top: 0;">
                      <span class="post-by"><i class="fa fa-user-circle"></i> <?php echo get_the_author(); ?></span>
                      <div class="share-post-div">

                        <a href="#!" id="open-share-list" class="open-share-list"> <span class="post-share"><i class="fa fa-share-alt"></i></span></a>

                        <div id="share-icons-list" class="share-icons-list">
                          <ul class="social-list">
                            <li>
                              <a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="facebook" target="_blank"><span class="social-border"></span><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            </li>
                            <li>
                              <a href="https://twitter.com/home?status=<?php the_permalink(); ?>" class="twitter" target="_blank"><span class="social-border"></span><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            </li>
                            <li>
                              <a href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>&summary=&source=" class="linkedin" target="_blank"><span class="social-border"></span><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <?php if( $i%4 == 0 ) {?>
                <div class="clearfix d-none d-lg-block d-xl-block"></div>
              <?php } ?>
            <?php endwhile;
            wp_reset_query(); ?>

          </div>


          <!--  <div class="row">

            <?php // $loop = new WP_Query( array( 'post_type' => 'post', 'category_name' => 'stories', 'posts_per_page' => 8 ) ); ?>
            <?php // while ( $loop->have_posts() ) : $loop->the_post(); ?>

              <div class="col-lg-3 col-md-4 col-sm-12 float-left">

                <div class="clearfix"></div>
                <div class="upcoming-events">
                  <div class="upcoming-event-inner">
                    <div class="upcoming-event">


                      <a href="<?php // the_permalink(); ?>">
                        <div class="ece-thumbnail">
                          <img alt="<?php // the_title(); ?>" src="<?php // echo get_the_post_thumbnail_url(); ?>" />
                        </div>
                      </a>
                      <h4 class="story-title">
                        <a href="<?php // the_permalink(); ?>"><?php // the_title(); ?></a>
                      </h4>
                      <div class="uce-details">
                        
                        <a href="<?php // the_permalink(); ?>" class="btn-blue-small float-left">case study</a>
                        <a href="<?php // echo home_url('/donate'); ?>" class="btn-blue-small float-right">Donate now</a> 
                      </div>
                    </div>
                    <div class="clearfix"></div> 

                  </div>
                </div>


                <div class="clearfix"></div>    
              </div>

            <?php // endwhile; wp_reset_query(); ?>

          </div> -->

        </div>

      </div>


    </div>
  </div>
  <div class="clearfix"></div>
</section>
