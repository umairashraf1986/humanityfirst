<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>

  <div class="iptc-content filter-head-block ">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->
<!--====================================
=                 NEWS                 =
=====================================-->
<!--====  News  ====-->

<section class="blog-content page-wrapper">

  <div class="hf-grid-layout hf-gl-news">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="hf-gl-header">
            <ul class="hf-filter hf-news-filter">
              <li><a href="#!" id="all-link-news">All</a></li>
              <li><a href="#!" id="featured-link"><i class="fa fa-bookmark-o"></i> Featured</a></li>
              <li><a href="#!" id="popular-link"><i class="fa fa-bolt"></i> Popular</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="row hf-gl-row">

        <?php $loop = new WP_Query(array('post_type' => 'post', 'category_name' => 'news', 'posts_per_page' => -1)); ?>
        <?php if($loop->have_posts()) { ?>
        <?php while ($loop->have_posts()) : $loop->the_post(); ?>
          <?php
          $category_names = "";
          foreach ((get_the_category()) as $category) {
            $category_names .= " " . $category->name;
          }
          ?>
          <div class="col-lg-3 col-md-6 col-sm-12<?php echo $category_names; ?>">
            <div class="hf-gl-item h-100">
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
                <?php if(has_post_thumbnail(get_the_ID())){ ?>
                  <div class="hf-gl-item-img" style="margin-top: auto;">
                    <a href="<?php the_permalink(); ?>">
                      <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"/>
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

        <?php endwhile;
        wp_reset_query(); ?>
        <?php } else { ?>
          <div class="col-sm-12">
            <p class="text-center">There are no news to show right now.</p>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>

</section>
<div class="clearfix"></div>

<!--====  end of News  ====-->