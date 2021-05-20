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
=             PAGE                     =
=====================================-->
<section class="page-wrapper be-a-sponsor">
	<div class="container">
		<?php the_content(); ?>
	</div>
</section>
<!--====  End of PAGE  ====-->