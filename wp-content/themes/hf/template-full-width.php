<?php use Roots\Sage\Titles; ?>
<?php
/**
Template Name: Full Width
*/
?>

<!--===================================
=            Title Section            =
====================================-->

<section class="inner-page-title-section event-detail-page" <?php echo hf_header_bg_img(); ?>>

	<div class="iptc-content">
		<h1><?= Titles\title(); ?></h1>
		<?php bootstrap_breadcrumb(); ?>
	</div>

	<div class="overlay"></div>
</section>
<div class="clearfix"></div>

<!--====  End of Title Section  ====-->

<?php the_content(); ?>