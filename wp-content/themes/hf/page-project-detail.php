<?php while (have_posts()) : the_post(); ?>
  <?php get_template_part('templates/page', 'inner-header'); ?>
  <?php get_template_part('templates/content', 'project-detail'); ?>
<?php endwhile; ?>
