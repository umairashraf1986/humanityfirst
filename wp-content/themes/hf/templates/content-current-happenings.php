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
                    <li><a href="<?php echo home_url('/news'); ?>" class="pnm-latest-news"><span>News</span></a></li>
                    <li><a href="<?php echo home_url('/events'); ?>" class="pnm-latest-events"><span>Events</span></a></li>
                    <li><a href="<?php echo home_url('/message-board'); ?>" class="pnm-message-board"><span>Message Board</span></a></li>
                    <li><a href="<?php echo home_url('/blog'); ?>" class="pnm-blog"><span>Blog</span></a></li>
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
							<li><a href="<?php echo home_url('/news'); ?>" class="pnm-latest-news"><span>News</span></a></li>
							<li><a href="<?php echo home_url('/events'); ?>" class="pnm-latest-events"><span>Events</span></a></li>
							<li><a href="<?php echo home_url('/message-board'); ?>" class="pnm-message-board"><span>Message Board</span></a></li>
              <li><a href="<?php echo home_url('/blog'); ?>" class="pnm-blog"><span>Blog</span></a></li>
						</ul>
					</div>
				</div>
			</div>
		</section>
		<div class="clearfix"></div>
		<div class="page-content"> -->

	<!--====================================
  =       Current Happenings             =
  =====================================-->
  <section class="current-happenings-main">
  	<div class="container">
  		<h4 class="about-us-cont-title text-center">Current Happenings</h4>
  		<div class="row rtl-display">
  			<div class="col-6 float-left">

  				<div class="col-7 float-left">
  					<div class="row">
  						<h6 class="underlined-heading capital">Upcoming events</h6>
  					</div>
  				</div>
  				<div class="col-5 float-right" style="display: none;">
  					<div class="row rtl-display">
  						<div class="sort-buttons float-right">
  							<a href="#!" class="sort-button-up"><i class="fa fa-chevron-up" aria-hidden="true"></i><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
  							<a href="#!" class="sort-button-down"><i class="fa fa-chevron-down" aria-hidden="true"></i><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
  						</div>
  					</div>
  					<div class="clearfix"></div>
  				</div>
  				<div class="clearfix"></div>
  				<div class="upcoming-events">
  					<div class="upcoming-event-inner">
            <?php $events_loop = new WP_Query( array( 'post_type' => 'hf_events', 'posts_per_page' => 3 ) ); ?>
            <?php while ( $events_loop->have_posts() ) : $events_loop->the_post(); ?>
                <?php $event_date = rwmb_meta('hfusa-event_date'); ?>
  						<div class="upcoming-event">
  							<div class="col-5 float-left">
  								<div class="row">
  									<a href="<?php echo home_url();?>/telethon">
  										<div class="ece-thumbnail">
  											<img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>" />
  											<div class="uce-date-overlay">
  												<h6><?php echo date('F jS, Y', strtotime($event_date));?></h6>
  											</div>
  										</div>
  									</a>
  								</div>
  							</div>
  							<div class="col-7 float-right">
  								<div class="row rtl-display">
  									<div class="uce-details">
  										<a href="<?php echo home_url();?>/telethon"><h5><?php the_title(); ?></h5></a>
  										<div class="time-venue">
  											<div class="tv-time">
  												<i class="fa fa-clock-o" aria-hidden="true"></i>
  												<h6><?php echo date('F jS, Y', strtotime($event_date));?></h6>
  											</div>
  											<div class="tv-location">
  												<i class="fa fa-map-marker" aria-hidden="true"></i>
                          <?php $event_location = rwmb_meta('hfusa-event_location'); ?>
  												<h6><?php echo $event_location; ?></h6>
  											</div>
  										</div>
  										<div class="text-paragraph">
  											<?php the_excerpt(); ?>
  										</div>
  										<a href="<?php echo home_url();?>/telethon" class="btn-blue">View Details</a>
  									</div>
  								</div>
  							</div>
  						</div>
  						<div class="clearfix"></div>  
            <?php endwhile; wp_reset_query(); ?>
  						<a href="<?php echo home_url(); ?>/events" class="gray-link float-right">see all events</a>
  					</div>
  				</div>
  				<div class="clearfix"></div>  	
  			</div>
  			<div class="col-6 float-right">
  				<div class="col-7 float-left">
  					<div class="row">
  						<h6 class="underlined-heading capital">news And Blog</h6>
  					</div>
  				</div>
  				<div class="col-5 float-right" style="display: none;">
  					<div class="row rtl-display">
  						<div class="sort-buttons float-right">
  							<a href="#!" class="sort-button-up"><i class="fa fa-chevron-up" aria-hidden="true"></i><i class="fa fa-chevron-up" aria-hidden="true"></i></a>
  							<a href="#!" class="sort-button-down"><i class="fa fa-chevron-down" aria-hidden="true"></i><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
  						</div>
  					</div>
  					<div class="clearfix"></div>
  				</div>
  				<div class="clearfix"></div>
  				<div class="news-portal">
  					<div class="news-portal-inner">
  						<div class="ch-news">
  							<div class="ch-news-inner">
  								<img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/reliefinsyriya.jpg" />
  								<a href="#!" class="ch-news-block">
  									<div class="chn-title-desc">
  										<h5>Disaster relief in syria</h5>
  										<div class="date-comments">
  											<div class="np-date">
  												<i class="fa fa-clock-o" aria-hidden="true"></i>
  												<h6>9:00 AM - 10:00 AM</h6>
  											</div>
  											<div class="np-comments">
  												<i class="fa fa-map-marker" aria-hidden="true"></i>
  												<h6>CHELSEA PEARL</h6>
  											</div>
  										</div>
  									</div>
  								</a>
  							</div>
  						</div>

  						<div class="ch-news">
  							<div class="ch-news-inner">
  								<img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/reliefinsyriya.jpg" />
  								<a href="#!" class="ch-news-block">
  									<div class="chn-title-desc">
  										<h5>Disaster relief in syria</h5>
  										<div class="date-comments">
  											<div class="np-date">
  												<i class="fa fa-clock-o" aria-hidden="true"></i>
  												<h6>9:00 AM - 10:00 AM</h6>
  											</div>
  											<div class="np-comments">
  												<i class="fa fa-map-marker" aria-hidden="true"></i>
  												<h6>CHELSEA PEARL</h6>
  											</div>
  										</div>
  									</div>
  								</a>
  							</div>
  						</div>

  						<div class="ch-news">
  							<div class="ch-news-inner">
  								<img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/reliefinsyriya.jpg" />
  								<a href="#!" class="ch-news-block">
  									<div class="chn-title-desc">
  										<h5>Disaster relief in syria</h5>
  										<div class="date-comments">
  											<div class="np-date">
  												<i class="fa fa-clock-o" aria-hidden="true"></i>
  												<h6>9:00 AM - 10:00 AM</h6>
  											</div>
  											<div class="np-comments">
  												<i class="fa fa-map-marker" aria-hidden="true"></i>
  												<h6>CHELSEA PEARL</h6>
  											</div>
  										</div>
  									</div>
  								</a>
  							</div>
  						</div>
  					</div>
  					<div class="bottom-links float-right">
  						<a href="#!" class="gray-link ">see all News</a> |
  						<a href="#!" class="gray-link ">see Blog</a>
  					</div>
  				</div>
  				<div class="clearfix"></div>  	
  			</div>
  		</div>
  	</div>
  	<div class="clearfix"></div>
  </section>
</div>
  <!--====  end of Current Happenings  ====-->