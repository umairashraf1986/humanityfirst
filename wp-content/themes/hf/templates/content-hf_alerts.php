<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section alert-detail-page" <?php echo hf_header_bg_img(); ?>>

  <div class="iptc-content">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<?php while (have_posts()) : the_post(); ?>

  <div class="clearfix"></div>


    <!--====================================
    =             alert detail             =
    =====================================-->
    <!--====  alert intro  ====-->

    <section class="alert-detail-content page-wrapper">
      <div class="container">
        <div class="row rtl-display">
          <div class="col-lg-12 col-md-12 col-sm-12 float-left">
            <div class="alert-post">
              <div class="alert-container">
                <div class="text-paragraph">
                  <?php the_content(); ?>
                </div>
                <div class="clearfix"></div>


                <div class="clearfix"></div>
              </div>
              <div class="clearfix"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <div class="clearfix"></div>
  <?php endwhile; ?>