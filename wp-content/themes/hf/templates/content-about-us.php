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
                    <li><a class="pnm-history" href="<?php echo home_url('/history'); ?>"><span>history</span></a>
                    </li>
                    <li><a class="pnm-mission" href="<?php echo home_url('/mission'); ?>"><span>mission</span></a>
                    </li>
                    <li><a class="pnm-team" href="<?php echo home_url('/team'); ?>"><span>team</span></a>
                    </li>
                    <li><a class="pnm-stories" href="<?php echo home_url('/stories'); ?>"><span>stories</span></a>
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

<!-- 		<section class="inner-page-navigation">
			<div class="container">
				<div class="row">
					<div class="pn-menu">
						<ul>
							<li><a class="pnm-history" href="<?php echo home_url('/history'); ?>"><span>history</span></a>
							</li>
							<li><a class="pnm-mission" href="<?php echo home_url('/mission'); ?>"><span>mission</span></a>
							</li>
							<li><a class="pnm-team" href="<?php echo home_url('/team'); ?>"><span>team</span></a>
							</li>
              <li><a class="pnm-stories" href="<?php echo home_url('/stories'); ?>"><span>stories</span></a>
              </li>
						</ul>
					</div>
				</div>
			</div>
		</section> -->
		<div class="clearfix"></div>
		

	<!--====================================
  =             about us                 =
  =====================================-->
  <!--====  about us  ====-->
  <section class="about-us-content">
  	<div class="container">
      <?php while (have_posts()) : the_post(); ?>
  		<!-- <h4 class="about-us-cont-title"><?php // the_title(); ?></h4> -->
  		<div class="text-paragraph"><?php the_content(); ?></div>
      <?php endwhile; wp_reset_query(); ?>
  		<div class="row">
  			<div class="col-12 history-col">
          <?php $loop = new WP_Query( array( 'post_type' => 'page', 'name' => 'history', 'posts_per_page' => 1 ) ); ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
  				<h6 class="underlined-heading"><?php the_title(); ?></h6>
          <img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>" />
  				<div class="text-paragraph">
  					<?php echo the_excerpt(); ?>
  				</div>
  				<div class="clearfix"></div>
  				<a href="<?php the_permalink(); ?>" class="arrow-blue-btn float-right">Full History</a>
          <?php endwhile; wp_reset_query(); ?>

        </div>
        <div class="col-12 team-col">

          <?php $loop = new WP_Query( array( 'post_type' => 'page', 'name' => 'team', 'posts_per_page' => 1 ) ); ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
  				<div class="au-btm-btn-container">
            <h6 class="underlined-heading"><?php the_title(); ?></h6>
            <a href="<?php the_permalink(); ?>">
  					 <img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>" />
            </a>
            <div class="text-paragraph">
              <?php echo the_excerpt(); ?>
            </div>
  				</div>
          <div class="clearfix"></div>
          <a href="<?php the_permalink(); ?>" class="arrow-blue-btn float-right">All Team</a>
          <?php endwhile; wp_reset_query(); ?>

  			</div>
  			<div class="col-12 mission-col">
          <?php $loop = new WP_Query( array( 'post_type' => 'page', 'name' => 'mission', 'posts_per_page' => 1 ) ); ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
  				<h6 class="underlined-heading"><?php the_title(); ?></h6>
          <img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>" />
          <div class="text-paragraph">
            <?php echo the_excerpt(); ?>
          </div>
          <div class="clearfix"></div>
  				<a href="<?php the_permalink(); ?>" class="arrow-blue-btn float-right">Full Mission</a>
          <?php endwhile; wp_reset_query(); ?>
      
        </div>
        <div class="col-12 stories-col">

  				<?php $loop = new WP_Query( array( 'post_type' => 'page', 'name' => 'stories', 'posts_per_page' => 1 ) ); ?>
          <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
          <div class="au-btm-btn-container">
            <h6 class="underlined-heading"><?php the_title(); ?></h6>
            <a href="<?php the_permalink(); ?>">
             <img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>" />
            </a>
            <div class="text-paragraph">
              <?php echo the_excerpt(); ?>
            </div>
            <a href="<?php the_permalink(); ?>" class="arrow-blue-btn float-right">All Stories</a>
          </div>
          <?php endwhile; wp_reset_query(); ?>

  			</div>
  		</div>
  	</div>
  </section>
<div class="clearfix"></div>

  <!--====  end of about us  ====-->


<section class="get-involved-page" style="padding: 0;">
  <div class="container">
    <div class="row">
      <div class="col">

        <div class="gi-blocks">
          <div class="gi-block">

            <ul>

              <li>
                <a href="<?php echo home_url('/sponsors'); ?>" class="hn-be-a-volunteer"><span>Sponsors</span>
                  <span class="proj-details">
                    <span class="pjd-inner">
                      <h1>Sponsors</h1>
                      <p>Blessed dry created their beast, god whose form the the creeping creature.</p>
                      <span class="plus-link"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                    </span>
                  </span>
                </a>

              </li>
              <li><a href="<?php echo home_url('/partners'); ?>" class="hn-be-a-sponser"><span>Partners</span>

                <span class="proj-details">
                  <span class="pjd-inner">
                    <h1>Partners</h1>
                    <p>Blessed dry created their beast, god whose form the the creeping creature.</p>
                    <span class="plus-link"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                  </span>
                </span>
              </a></li>
              <li><a href="<?php echo home_url('/international-sites'); ?>" class="hn-donate"><span>International Sites</span>
                <span class="proj-details">
                  <span class="pjd-inner">
                    <h1>International Sites</h1>
                    <p>Blessed dry created their beast, god whose form the the creeping creature.</p>
                    <span class="plus-link"><i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                  </span>
                </span>
              </a></li>
            </ul>
          </div>

        </div>

      </div>
    </div>
  </section>