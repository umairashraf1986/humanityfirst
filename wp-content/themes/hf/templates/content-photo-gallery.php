<?php use Roots\Sage\Titles; ?>
<style type="text/css">
  .media_full {
    z-index: 99999;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
  }
  .prev {
    position: absolute;
    top: 50%;
    left: 0;
    width: 100px;
    height: auto;
    background-color: transparent;
    color: #FFFFFF;
    font-size: 2em;
    font-weight: bold;
    border: none;
    cursor: pointer;
    transform: translateY(-50%);
  }
  .next {
    position: absolute;
    top: 50%;
    right: 0;
    width: 100px;
    height: auto;
    background-color: transparent;
    color: #FFFFFF;
    font-size: 2em;
    font-weight: bold;
    border: none;
    transform: translateY(-50%);
    cursor: pointer;
  }
  .view_close {
    position: fixed;
    top: 0;
    right: 0;
    width: 100px;
    height: 70px;
    font-size: 2em;
    color: #FFFFFF;
    background-color: transparent;
    box-shadow: none;
    border: none;
    cursor: pointer;
  }
  .img_view {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left:0;
    width: auto;
    height: 100%;
  }
  .img_view img {
    display: block;
    margin: 0 auto;
    max-height: calc(100% - 20px);
    max-width: calc(100% - 200px);
    top: 50%;
    position: relative;
    transform: translateY(-50%);
  }
  .hf-gl-item {
    cursor: pointer;
  }
  .hf-gl-item-heading {
    color: white;
  }
  .media_full .img-desc {
    width: 100%;
    height: auto;
    position: fixed;
    bottom: 0;
    left: 0;
    text-align: center;
    background-color: rgba(0,0,0,0.7);
    color: white;
    padding: 10px;
  }
  .media_full .img-desc p {
    margin-bottom: 0.5rem;
  }
</style>
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

<?php

if( isset( $_GET['album_id'] ) && $_GET['album_id'] != "" ) {

  ?>

  <section class="blog-content page-wrapper">

    <div class="hf-grid-layout hf-gl-events">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 w-100">
            <h3 class="text-center inner-page-heading">Photos for <?php echo get_the_title($_GET['album_id']); ?></h3>
          </div>
        </div>
        
        <div class="row hf-gl-row">

          <?php $loop = new WP_Query( array( 'post_type' => 'hf_photos', 'meta_key' => 'hfusa-select_album', 'meta_value' => $_GET['album_id'], 'posts_per_page' => -1 ) ); 



          if ( $loop->have_posts() ) : 

           while ( $loop->have_posts() ) : $loop->the_post(); ?>
             <div class="col-lg-3 col-md-4 col-sm-12 img-col">

              <div class="hf-gl-item">
                <div class="hf-gl-wrapper">
                  <div class="hf-gl-item-img" style="overflow: hidden; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    <!-- <a href="#<?php echo get_the_ID(); ?>"> -->
                      <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="hf_gallery_thumb" />
                    <!-- </a> -->
                  </div>
                  <h2 class="hf-gl-item-heading" style="border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;"><?php the_title(); ?></h2>
                  <?php if( '' !== get_post()->post_content ) { ?>
                    <div class="img-desc hidden"><?php the_content(); ?></div>
                  <?php } ?>
                </div>
              </div>

              <!-- a href="#_" class="hf_gallery_lightbox" id="<?php echo get_the_ID(); ?>">
                <div class="hf_gallery_lightbox_cnt">
                  <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>"/>
                  <?php if( '' !== get_post()->post_content ) { ?>
                    <div class="img-desc"><?php the_content(); ?></div>
                  <?php } ?>
                  <span class="close-gallery-light-box"><i class="fa fa-close" aria-hidden="true"></i></span>
                </div>
              </a> -->

            </div>
          <?php endwhile; ?>

          <div class="media_full" style="display: none;">
            <div class="img_view">
              <img id="img" src="" alt="" />
            </div>
            <div class="img-desc"></div>
            <button class="prev" id="prev" type="button"><i class="fa fa-chevron-left" aria-hidden="true"></i></button>
            <button class="next" id="next" type="button"><i class="fa fa-chevron-right" aria-hidden="true"></i></button>
            <button class="view_close" type="button"><i class="fa fa-times" aria-hidden="true"></i></button>
          </div>

        <?php else :
         echo esc_html_e( 'Sorry, no photos found in this album.' );
       endif;
       wp_reset_query(); ?>

     </div>
   </div>
 </div>
</section>
<div class="clearfix"></div>
<?php

} else {

  ?>


  <section class="blog-content page-wrapper">

    <div class="hf-grid-layout hf-gl-events">
      <div class="container">
        <div class="row">
          <div class="col-xs-12 w-100">
            <h3 class="text-center">Albums</h3>
          </div>
        </div>
        
        <div class="row hf-gl-row">

          <?php $loop = new WP_Query( array( 'post_type' => 'hf_albums', 'posts_per_page' => -1 ) ); ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
            <div class="col-lg-3 col-md-4 col-sm-12">

              <div class="hf-gl-item">
                <div class="hf-gl-wrapper">
                  <div class="hf-gl-item-img" style="overflow: hidden; border-top-left-radius: 5px; border-top-right-radius: 5px;">
                    <a href="<?php echo home_url()."/photo-gallery?album_id=".get_the_ID(); ?>">
                      <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" class="hf_gallery_thumb" />
                    </a>
                  </div>
                  <h2 class="hf-gl-item-heading" style="border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                    <a href="<?php echo home_url()."/photo-gallery?album_id=".get_the_ID(); ?>"><?php the_title(); ?></a>
                  </h2>
                </div>
              </div>

            </div>

          <?php endwhile; wp_reset_query(); ?>

        </div>
      </div>
    </div>

  </section>
  <div class="clearfix"></div>

  <?php

}

?>