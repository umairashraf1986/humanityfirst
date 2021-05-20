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
<section class="page-wrapper <?php echo !empty($_GET['post_type']) && $_GET['post_type'] == 'product' ? 'woocommerce' : '';?>">
	<div class="container">
		<?php 
		if (!have_posts()) : 
			?>
			<div class="alert alert-warning">
				<?php _e('Sorry, no results were found.', 'sage'); ?>
			</div>
			<?php get_search_form(); ?>
			<?php 
		endif;

		if (!empty($_GET['post_type']) && $_GET['post_type'] == 'product') {
			echo '<div class="products shop-page-loop">';
			while ( have_posts() ) : ?>
				<?php the_post(); ?>
				<?php wc_get_template_part( 'content', 'product' ); ?>
				<?php 
			endwhile; 
			echo '</div>';
		}else{

			while (have_posts()) : the_post(); ?>
				<?php get_template_part('templates/content', 'search'); ?>
				<?php
			endwhile;
		}
		the_posts_navigation(); 
		?>		
	</div>
</section>
<!--====  End of PAGE  ====-->
