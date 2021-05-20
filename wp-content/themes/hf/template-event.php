<?php use Roots\Sage\Titles; ?>
<?php
/**
Template Name: Elementor Event
Template Post Type: hf_events
*/
?>
<!--==================================
=           Telethon Page            =
===================================-->
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section event-detail-page" <?php echo hf_header_bg_img(); ?>>

	<div class="iptc-content">
		<h1><?= Titles\title(); ?></h1>
		<?php bootstrap_breadcrumb(); ?>
	</div>

	<div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<?php the_content(); ?>