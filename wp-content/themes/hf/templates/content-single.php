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

<!--====  blog detail  ====-->

<section class="blog-content page-wrapper blog-detail-page padd-two-sixty-four" style="background-color: #FFFFFF;">
  <div class="container">
    <div class="row rtl-display">
      <div class="col-md-12 col-lg-8 col-sm-12 float-left">
        <?php while (have_posts()) : the_post(); ?>

          <div class="blog-post <?php post_class(); ?>">
            <!--            <div class="col-md-7 col-xs-12 float-left">-->
              <!--              <div class="row">-->
                <!--                <h6 class="underlined-heading capital">--><?php //the_title(); ?><!--</h6> -->
                <!--              </div>-->
                <!--            </div>-->
                <div class="blog-container">
                 <?php 
                 /* show featured image section only if post thumbnail is present*/
                 if(has_post_thumbnail(get_the_ID())){?>
                  <!-- <div class="blog-feature">
                    <img alt="<?php the_title(); ?>" src="<?php echo get_the_post_thumbnail_url(); ?>" />
                  </div> -->
                <?php } ?>
                <?php get_template_part('templates/entry-meta'); ?>
                <div class="text-paragraph">
                  <?php the_content(); ?>
                </div>

                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>

            </div>

            <?php comments_template('/templates/comments.php'); ?>

          <?php endwhile; ?>

        </div>


        <div class="col-lg-4 col-md-12 col-sm-12 float-right">
          <div class="blog-sidebar">
            <?php

            $get_post_cat = get_post_class( get_the_ID());

            if (in_array('category-stories', $get_post_cat, true)) { ?>

              <div class="write-your-story-btn">
                <a href="<?php echo home_url('/write-your-story'); ?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>WRITE YOUR STORY</a>
              </div>
            <?php } ?>
            <div class="sb-search">
             <form method="GET" action="<?php echo site_url(); ?>">
              <input type="text" name="s" placeholder="Search">
              <input type="submit" name="" value="">
            </form>
          </div>
          <?php 
          $catSlug='blog';
          $postsLabel="Posts";
          if (in_array('category-stories', $get_post_cat, true)) {
            $postsLabel="Stories";
            $catSlug='stories';
          }else if (in_array('category-news', $get_post_cat, true)){
            $postsLabel="News";
            $catSlug='news';
          }

          $category = get_term_by('slug', $catSlug, 'category');
          $category_id=isset($category->term_id) ? $category->term_id : 0;
          ?>
          <div class="sidebar-links">
            <?php
            $args = array(
              'numberposts' => 5,
              'category' => $category_id,
            );

            $recent_posts = wp_get_recent_posts($args);
            if($recent_posts && is_array($recent_posts)){
              ?>
              <h4>Recent <?php echo $postsLabel; ?></h4>
              <ul class="disk-list">
                <?php
                foreach( $recent_posts as $recent ){
                  echo '<li><a href="'. get_permalink($recent["ID"]) . '">' .$recent["post_title"].'</a> </li>';
                }
                ?>
              </ul>
              <?php
            }
            wp_reset_query();
            ?>
          </div>
          <div class="sidebar-links">
            <?php
            $args = array(
              'post_type' => 'post',
              'posts_per_page' => 5,
              'tax_query' => array(
                'relation' => 'AND',
                array(
                  'taxonomy' => 'category',
                  'field'    => 'slug',
                  'terms'    => array( 'featured' ),
                ),
                array(
                  'taxonomy' => 'category',
                  'field'    => 'slug',
                  'terms'    => array( $catSlug ),
                )
              )
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) {
              ?>
              <h4>Featured <?php echo $postsLabel; ?></h4>
              <ul class="disk-list">
                <?php
                while ( $the_query->have_posts() ) {
                  $the_query->the_post();
                  ?>
                  <li><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></li>
                  <?php
                }
                ?>
              </ul>
              <?php
              wp_reset_postdata();
            } 
            ?>
          </div>
          <div class="sidebar-links">
            <?php
            $args = array(
              'post_type' => 'post',
              'posts_per_page' => 5,
              'tax_query' => array(
                'relation' => 'AND',
                array(
                  'taxonomy' => 'category',
                  'field'    => 'slug',
                  'terms'    => array( 'popular' ),
                ),
                array(
                  'taxonomy' => 'category',
                  'field'    => 'slug',
                  'terms'    => array( $catSlug ),
                )
              )
            );
            $the_query = new WP_Query( $args );
            if ( $the_query->have_posts() ) {
              ?>
              <h4>Popular <?php echo $postsLabel; ?></h4>
              <ul class="disk-list">
                <?php
                while ( $the_query->have_posts() ) {
                  $the_query->the_post();
                  ?>
                  <li><a href="<?php the_permalink(); ?>"><?php the_title() ?></a></li>
                  <?php
                }
                ?>
              </ul>
              <?php
              wp_reset_postdata();
            } 
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="clearfix"></div>

<!--====  end of blog detail ====-->
