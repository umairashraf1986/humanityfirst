<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section about-us-page">
  
  <div class="iptc-content">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->
<!--====================================
=             PAGE                     =
=====================================-->
<section class="rscs-photo-gallery page-wrapper">
  <div class="container">
    <div class="photo-gallery-list">
      <div class="pg-light-box">
       <div class="alert alert-warning">
		  <?php _e('Sorry, but the page you were trying to view does not exist.', 'sage'); ?>
		</div>

		<?php get_search_form(); ?>
      </div>
    </div>
  </div>
</section>