<div class="blog-credits">
	<div class="blc-data">
		<i class="fa fa-user-circle" aria-hidden="true"></i>
		<h6>Post by <?= get_the_author(); ?> <span>|</span></h6>
	</div>
	<div class="blc-data">
		<i class="fa fa-clock-o" aria-hidden="true"></i>
		<h6>on <?= get_the_date(); ?> <span>|</span></h6>
	</div>
	<div class="blc-data">
		<i class="fa fa-map-marker" aria-hidden="true"></i>
		<h6>
			<span class="label-categoty-meta">in</span> 
			<i class="float-right">
				<ul class="post-categories">
					<?php
					$post_terms = wp_get_post_categories( $post->ID );
					$i = 1;
					if(!empty($post_terms) && is_array($post_terms)){
						$count = count($post_terms);
						foreach ($post_terms as $post_term) {
							$term = get_term_by('id', $post_term, 'category');
							$termName = isset($term->name) ? $term->name : '';
							?>
							<li><a href="<?php echo get_term_link($post_term); ?>" rel="category tag"><?php echo $termName; ?></a></li><?php
							if($i < $count){echo ',&nbsp;';}
							$i++;
						}
					}
					?>
				</ul>
			</i>
		</h6>
	</div>
</div>