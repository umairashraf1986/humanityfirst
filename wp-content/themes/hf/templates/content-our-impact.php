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
                    <li><a class="pnm-oi-knw-for-life" href="<?php echo home_url('/hf_impacts/knowledge-for-life/'); ?>"><span>Knowledge for life</span></a>
                    </li>
                    <li><a class="pnm-oi-global-health" href="<?php echo home_url('/hf_impacts/global-health/'); ?>"><span>global health</span></a>
                    </li>
                    <li><a class="pnm-oi-learn-a-skilli" href="<?php echo home_url('/hf_impacts/learn-a-skill/'); ?>"><span>learn a skill</span></a>
                    </li>
                    <li><a class="pnm-oi-disaster-relief" href="<?php echo home_url('/hf_impacts/disaster-relief/'); ?>"><span>disaster relief</span></a>
                    </li>
                    <li><a class="pnm-oi-water-for-life" href="<?php echo home_url('/hf_impacts/water-for-life/'); ?>"><span>water for life</span></a>
                    </li>
                    <li><a class="pnm-oi-feed-hungry" href="<?php echo home_url('/hf_impacts/feed-the-hungry-in-america/'); ?>"><span>feed the hungary<br/> in america</span></a>
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
<!-- <section class="inner-page-navigation">
  <div class="container">
    <div class="row">
      <div class="pn-menu">
        <ul>
          <li><a class="pnm-oi-knw-for-life" href="<?php echo home_url('/hf_impacts/knowledge-for-life/'); ?>"><span>Knowledge for life</span></a>
          </li>
          <li><a class="pnm-oi-global-health" href="<?php echo home_url('/hf_impacts/global-health/'); ?>"><span>global health</span></a>
          </li>
          <li><a class="pnm-oi-learn-a-skilli" href="<?php echo home_url('/hf_impacts/learn-a-skill/'); ?>"><span>learn a skill</span></a>
          </li>
          <li><a class="pnm-oi-disaster-relief" href="<?php echo home_url('/hf_impacts/disaster-relief/'); ?>"><span>disaster relief</span></a>
          </li>
          <li><a class="pnm-oi-water-for-life" href="<?php echo home_url('/hf_impacts/water-for-life/'); ?>"><span>water for life</span></a>
          </li>
          <li><a class="pnm-oi-feed-hungry" href="<?php echo home_url('/hf_impacts/feed-the-hungry-in-america/'); ?>"><span>feed the hungary<br/> in america</span></a>
          </li>


        </ul>
      </div>
    </div>
  </div>
</section> -->
<div class="clearfix"></div>

<div class="container">
  <div class="our-impact-content" style="padding: 50px 0 0 0;">
    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; wp_reset_query(); ?>
  </div>
</div>

<div class="page-content">

<!--====================================
=              our Impact             =
=====================================-->
<section class="our-impact-container-main">
  <div class="container">

    <div class="row rtl-display">
      <div class="col-12 float-left">
        <div class="events-main-inner">
          <div class="row">

            <?php $loop = new WP_Query( array( 'post_type' => 'hf_impacts', 'posts_per_page' => -1 ) ); ?>
            <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>

              <div class="col-6 float-left">


                <div class="clearfix"></div>
                <div class="upcoming-events">
                  <div class="upcoming-event-inner">
                    <div class="upcoming-event">


                      <a href="<?php the_permalink(); ?>">
                        <div class="ece-thumbnail">
                          <img alt="<?php the_title(); ?>" src="<?php echo get_the_post_thumbnail_url(); ?>" />
                        </div>
                      </a>
                      <div class="uce-details">

                        <div class="col-12 float-left">
                          <div class="row">
                            <h6 class="underlined-heading capital"><?php the_title(); ?></h6>
                          </div>
                        </div>

                        <div class="text-paragraph"><?php the_excerpt(); ?></div>
                        <!--a href="#!" class="btn-blue">BUY TICKETS</a-->
                        <a href="<?php the_permalink(); ?>" class="btn-blue-small float-left">case study</a>
                        <a href="<?php echo home_url('/donate'); ?>" class="btn-blue-small float-right">Donate now</a>
                      </div>
                    </div>
                    <div class="clearfix"></div> 

                  </div>
                </div>


                <div class="clearfix"></div>    
              </div>

            <?php endwhile; wp_reset_query(); ?>

          </div>

        </div>

      </div>



    </div>
  </div>
  <div class="clearfix"></div>
</section>

<section class="our-impact-stats">
  <div class="container">
    <div class="row rtl-display">
      <div class="d-flex justify-content-center">
        <div class="col-10 ">
          <div class="col-3 float-left">
            <div class="row">
              <div class="oi-stat-icon">
                <img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/btm-globe.png" />
              </div>
              <div class="stat-content">
                <h5>100</h5>
                <h6>GEOGRAPHIC REACH</h6>
              </div>
            </div>
          </div>
          <div class="col-3 float-left">
            <div class="row">
              <div class="oi-stat-icon">
                <img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/btm-schedule.png" />
              </div>
              <div class="stat-content">
                <h5>12</h5>
                <h6>years in <br />the field</h6>
              </div>
            </div>
          </div>
          <div class="col-3 float-left">
            <div class="row">
              <div class="oi-stat-icon">
                <img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/btm-team.png" />
              </div>
              <div class="stat-content">
                <h5>300</h5>
                <h6>lives <br /> impacted</h6>
              </div>
            </div>
          </div>
          <div class="col-3 float-left">
            <div class="row">
              <div class="oi-stat-icon">
                <img alt="" src="<?php echo get_template_directory_uri(); ?>/assets/images/btm-dollar.png" />
              </div>
              <div class="stat-content">
                <h5>$3m</h5>
                <h6>dorrals <br />raised</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</div>
<div class="clearfix"></div>
<!--====  end of Our Impsct  ====-->