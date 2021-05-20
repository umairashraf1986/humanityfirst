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
  <div class="inner-page-wrapper">
    <div class="page-title-section">
      <div class="container">
        <div class="row">

          <div class="col">
            <div class="row">
              <div class="col-12">
                <div class="pn-menu">
                  <ul>
                    <li><a class="pnm-photo-gallery" href="#!"><span>photo gallery</span></a>
					</li>
					<li><a class="pnm-videos" href="#!"><span>videos</span></a>
					</li>
					<li><a class="pnm-faqs" href="#!"><span>faqs</span></a>
					</li>
					<li><a class="pnm-downloads" href="#!"><span>downloads</span></a>
					</li>
                  </ul>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<!--====================================
=            resources page            =
=====================================-->

<section class="resources-main-container">
	<div class="container">
		<h4 class="resources-cont-title">Helpful Resources</h4>
		<p class="text-paragraph">Had Replenish, wherein let first after sea make. Darkness blessed years place and place face darkness fifth dry very. Fish, two the stars won't great said lights gathering they're made in darkness light be them whose evening have two subdue and itself given own moving.</p>

	</div>
</section>
<div class="clearfix"></div>

<section class="rscs-photo-gallery">
	<div class="container">
		<h3>photo gallery</h3>
		<div class="photo-gallery-list">
			<div class="pg-light-box">
				<ul>
					<?php $loop = new WP_Query( array( 'post_type' => 'hf_photos', 'posts_per_page' => -1 ) ); ?>
			        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			        <li style="margin-bottom: 30px;"><img alt="<?php the_title(); ?>" src="<?php echo get_the_post_thumbnail_url(); ?>" /><a href="<?php echo get_the_post_thumbnail_url(); ?>" class="open-image" target="_blank"><i class="fa fa-plus" aria-hidden="true"></i></a></li>
			        <?php endwhile; wp_reset_query(); ?>
				</ul>
				<!-- <div class="controls-g">
					<a href="#!" class="float-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
					<a href="#!" class="float-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
				</div> -->
			</div>
		</div>
	</div>
</section>


<section class="rscs-video">
	<div class="container">
		<h3>video gallery</h3>
		<div class="photo-gallery-list">
			<div class="pg-light-box">
				<ul>
					<?php $loop = new WP_Query( array( 'post_type' => 'hf_videos', 'posts_per_page' => -1 ) ); ?>
		          	<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
			          	<li style="margin-bottom: 30px;">
			            	<iframe width="230" height="130" src="https://www.youtube.com/embed/<?php the_title(); ?>?rel=0" frameborder="0" allowfullscreen></iframe>
			          	</li>
		          	<?php endwhile; wp_reset_query(); ?>
				</ul>
				<!-- <div class="controls-g">
					<a href="#!" class="float-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
					<a href="#!" class="float-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
				</div> -->
			</div>
		</div>
	</div>
</section>

<section class="rscs-faqs">
	<div class="container">
		<h3>FAQs</h3>
		<div class="photo-gallery-list">
			<div class="pg-light-box">
				<ul>
					<?php $loop = new WP_Query( array( 'post_type' => 'hf_questions', 'posts_per_page' => -1 ) ); ?>
      				<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<li>
						<div href="#!" class="rscs-faq-box">
							<a href=""><h6><?php the_title(); ?></h6></a>
							<div class="rscs-text-paragraph">
								<?php the_excerpt(); ?>
							</div>
						</div>
					</li>
					<?php endwhile; wp_reset_query(); ?>
				</ul>
				<!-- <div class="controls-g">
					<a href="#!" class="float-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
					<a href="#!" class="float-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
				</div> -->
			</div>
		</div>
	</div>
</section>


<section class="rscs-downloads">
	<div class="container">
		<h3>Downloads</h3>
		<div class="photo-gallery-list">
			<div class="pg-light-box">
				<ul>
					<?php $loop = new WP_Query( array( 'post_type' => 'hf_downloads', 'posts_per_page' => -1 ) ); ?>
          			<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
					<li>
						<div href="#!" class="rscs-dwld-box">
							<a href=""><h6><?php the_title(); ?></h6></a>
							<div class="download-btn">
								<a href="#"><i class="fa fa-download" aria-hidden="true"></i> <span>downloads</span></a>
							</div>
						</div>
					</li>
					<?php endwhile; wp_reset_query(); ?>
				</ul>
				<!-- <div class="controls-g">
					<a href="#!" class="float-left"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
					<a href="#!" class="float-right"><i class="fa fa-chevron-right" aria-hidden="true"></i></a>
				</div> -->
			</div>
		</div>
	</div>
</section>

<!--====  End of resources page  ====-->
