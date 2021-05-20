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
                    <li><a class="pnm-programs" href="<?php echo home_url('/programs'); ?>"><span>programs</span></a>
                    </li>
                    <li><a class="pnm-geographical-regions" href="<?php echo home_url('/geographic-regions'); ?>"><span>geographic regions</span></a>
                    </li>
                    <li><a class="pnm-projects" href="<?php echo home_url('/projects'); ?>"><span>projects</span></a>
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

<?php
if(isset($_GET['project_id']) && $_GET['project_id'] != '') {

    $project_id = $_GET['project_id'];

    $post_status = get_post_status( $project_id );

    $post_type = get_post_type( $project_id );

    if ( $post_status == "publish" && $post_type == "hf_projects") {

        $donation_args = array(
            'posts_per_page'   => -1,
            'post_type'        => 'hf_donations',
            'meta_key'         => 'hfusa-project_id',
            'meta_value'       => $project_id
        );
        $donation_query = new WP_Query( $donation_args );

        $donation_posts = $donation_query->posts;

        //echo '<pre>';
        //print_r($cc_query->posts);
        //echo '</pre>';

        $target_amount = get_post_meta( $project_id, 'hfusa-target_price', true );

        $donations_sum = 0;
        $pledges_sum = 0;

        foreach($donation_posts as $donation_post) {

            //echo $donation_post->ID;
            //echo $donation_post->post_title;

            $get_donation_amount = get_post_meta( $donation_post->ID, 'hfusa-donation_amount', true);

            $donation_type = get_post_meta($donation_post->ID, 'hfusa-donation_type', true);

            //echo $get_donation_amount . '<br>';

            if( $donation_type == 'Donation' ) {

                $donations_sum += $get_donation_amount;

            } else {

                $pledges_sum += $get_donation_amount;
            }
        }

        //print_r($donationAmounts);

        $donationResponse = array( "Donations" => $donations_sum, "Pledges" => $pledges_sum, "Target Funds" => $target_amount );

        header('Content-Type: application/json');
        echo json_encode($donationResponse, JSON_PRETTY_PRINT);


    } else {

        echo "Project with this ID doesn't exist.";

    }

} else {

    $donation_args = array(
        'posts_per_page' => -1,
        'post_type' => 'hf_donations'
    );
    $donation_query = new WP_Query($donation_args);

    $donation_posts = $donation_query->posts;

    $p_args = array(
        'posts_per_page' => -1,
        'post_type' => 'hf_projects'
    );
    $p_query = new WP_Query($p_args);

    $p_posts = $p_query->posts;

    foreach ($p_posts as $p_post) {

        $donations_sum = 0;
        $pledges_sum = 0;

        $p_target_amount = get_post_meta($p_post->ID, 'hfusa-target_price', true);

        foreach ($donation_posts as $donation_post) {

            $project_id = get_post_meta($donation_post->ID, 'hfusa-project_id', true);

            if($project_id == $p_post->ID) {

                $donation_type = get_post_meta($donation_post->ID, 'hfusa-donation_type', true);

                $donation_amount = get_post_meta($donation_post->ID, 'hfusa-donation_amount', true);

                if( $donation_type == 'Donation' ) {

                    $donations_sum += $donation_amount;

                } else {

                    $pledges_sum += $donation_amount;
                }

            }

        }

        $p_array[] = array(
            'Project ID' => $p_post->ID,
            'Donations' => $donations_sum,
            'Pledges' => $pledges_sum,
            'Target Funds' => $p_target_amount
        );
    }

//    header('Content-Type: application/json');
//    echo json_encode($p_array, JSON_PRETTY_PRINT);
//    echo "<pre>";
//    print_r($p_array);
//    echo "</pre>";

    //print_r($dAmounts);

}
?>

<!-- <section class="inner-page-navigation">
	<div class="container">
		<div class="row">
			<div class="pn-menu">
				<ul>
					<li><a class="pnm-programs" href="<?php echo home_url('/programs'); ?>"><span>programs</span></a>
					</li>
					<li><a class="pnm-geographical-regions" href="<?php echo home_url('/geographical-regions'); ?>"><span>geographical regions</span></a>
					</li>
					<li><a class="pnm-projects" href="<?php echo home_url('/projects'); ?>"><span>projects</span></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</section>
<div class="clearfix"></div> -->


	<!--====================================
  =             Our Work                 =
  =====================================-->
  <!--====  programs  ====-->
  <section class="our-work-programs page-wrapper">
  	<div class="container">
      <?php $loop = new WP_Query( array( 'post_type' => 'page', 'name' => 'programs', 'posts_per_page' => 1 ) ); ?>
      <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
    		<h4 class="our-work-cont-title"><?php the_title(); ?></h4>
    		<div class="text-paragraph"><?php the_excerpt(); ?></div>
      <?php endwhile; wp_reset_query(); ?>
  		<div class="row">

        <?php $loop = new WP_Query( array( 'post_type' => 'hf_programs', 'posts_per_page' => 3 ) ); ?>
        <?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
  			<div class="col-4">
  				<div class="row">
  					<div class="content-grid">
  						<div class="content-wrapper">
  							<a href="<?php the_permalink(); ?>" class="ow-links">
  								<div class="ow-prog-images">
  									  <img alt="" class="partners-cat-icon" src="<?php echo get_the_post_thumbnail_url(); ?>"/>
  									<div class="owp-icon-container">
                      <?php
                        $attachImages = rwmb_meta( 'hfusa-program_logo', array( 'limit' => 1 ) );
                        $programImage = reset( $attachImages );
                      ?>
                      <img alt="" class="owp-icon" src="<?php echo $programImage['full_url']; ?>"/>
  									</div>
  								</div>
  							</a>
  							<div class="ow-program-content">
  								<a href="<?php the_permalink(); ?>" class="ow-links"><h4 class="ow-prog-title blue-heading"><?php // the_title(); ?></h4></a>
  								<div class="text-paragraph"><?php // the_excerpt(); ?></div>
  								<!-- <a href="<?php the_permalink(); ?>" class="button-blue">View Details</a> -->
  							</div>
  						</div>
  					</div>
  				</div>
  			</div>
        <?php endwhile; wp_reset_query(); ?>

  		</div>
  	</div>
  </section>
<div class="clearfix"></div>
<!--====  end of programs  ====-->

<!-- GEOGRAPHIC REGIONS -->
<?php $loop = new WP_Query( array( 'post_type' => 'page', 'name' => 'geographic-regions', 'posts_per_page' => 1 ) ); ?>
<?php while ( $loop->have_posts() ) : $loop->the_post(); ?>
<?php the_content(); ?>
<?php endwhile; wp_reset_query(); ?>
<div class="clearfix"></div>
<!-- End of GEOGRAPHIC REGIONS -->


  <section class="our-work-projects">
    <div class="container">
      <div class="row">
        <div class="col">
          <div class="col-12">
            <div class="col">
              <h4 class="our-work-cont-title"><?php the_title(); ?></h4>
              <div class="text-paragraph"><?php the_excerpt(); ?></div>
            </div>
          </div>
          <div class="clearfix"></div>


            <div class="ow-projects-blocks">

              <?php $projects_loop = new WP_Query( array( 'post_type' => 'hf_projects', 'posts_per_page' => -1 ) ); ?>
              <?php while ( $projects_loop->have_posts() ) : $projects_loop->the_post(); ?>

                  <?php

                  $target_amount = rwmb_meta('hfusa-target_price');

                  for($i=0; $i<count($p_array); $i++) {
                      if($p_array[$i]['Project ID'] == get_the_ID()) {
                          $donations = $p_array[$i]['Donations'];
                          break;
                      }
                  }

                  ?>

              <div class="col-4 float-left">
                
                <div class="owp-block">
                  <div class="owp-block-inner">
                    <div class="owp-block-image">
                      <a href="<?php the_permalink(); ?>">
                        <img alt="" src="<?php echo get_the_post_thumbnail_url(); ?>"/>
                      </a>
                    </div>
                    <div class="owp-block-title">
                    <a href="<?php the_permalink(); ?>">  <h4><?php the_title(); ?></h4></a>
                    </div>
                    <div class="owp-block-desc"><?php the_excerpt(); ?></div>
                    <div id="stats_progress_bar" class="stats-progress-bar">
                      <div class="cssProgress">
                        <div class="progress1">
                          <div class="cssProgress-bar" data-percent="<?php echo round($donations / $target_amount * 100); ?>" style="width: <?php echo round($donations / $target_amount * 100); ?>%;">
                            <span class="cssProgress-label"><?php echo round($donations / $target_amount * 100); ?>%</span>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="owpb-bottom-stats">
                      <div class="raised-fund">
                        <h6>raised <span><?php echo $donations;?>/-</span></h6>
                      </div>
                      <div class="goal-fund">
                        <h6>goal <span>$<?php echo $target_amount; ?></span></h6>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                
              </div>

              <?php endwhile; wp_reset_query(); ?>


            </div>


        </div>
      </div>
    </section>

    <div class="clearfix"></div>


	<!--====  End of Our Work  ====-->