<div class="blog-post">
	<div class="blog-container">
		<article <?php post_class(); ?>>
			<header>
				<h2 class="entry-title underlined-heading capital"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<?php get_template_part('templates/entry-meta'); ?>
			</header>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div>
		</article>
	</div>
</div>
