<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section">
	<div class="iptc-content">
		<h1><?= Titles\title(); ?></h1>
		<?php bootstrap_breadcrumb(); ?>
	</div>
	<div class="overlay"></div>
</section>
<div class="clearfix"></div>
<div class="page-content">
	<section class="blog-content page-wrapper blog-detail-page category-page">
		<?php get_template_part('templates/page', 'header'); ?>
		<div class="container">
			<div class="row rtl-display">
				<div class="col-12 float-left">
					<?php if (!have_posts()) : ?>
						<div class="alert alert-warning">
							<?php _e('Sorry, no results were found.', 'sage'); ?>
						</div>
						<?php get_search_form(); ?>
					<?php endif; ?>
					<?php while (have_posts()) : the_post(); ?>
								<?php get_template_part('templates/content', get_post_type() != 'post' ? get_post_type() : get_post_format()); ?>
							<?php endwhile; ?>
					<?php the_posts_navigation(); ?>
				</div>
			</div>
		</div>
	</section>
</div>
<div class="clearfix"></div>