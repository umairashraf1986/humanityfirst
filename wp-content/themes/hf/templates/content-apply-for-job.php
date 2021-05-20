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
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<section class="page-wrapper be-a-sponsor">
  <div class="container">
  	<?php
  	if( is_user_logged_in() ) {
  		$current_user = wp_get_current_user();

  		global $wpdb;

		$qry = "SELECT posts.post_author, postmeta.post_id, postmeta.meta_key, postmeta.meta_value FROM {$wpdb->prefix}posts as posts INNER JOIN {$wpdb->prefix}postmeta as postmeta ON posts.ID=postmeta.post_id WHERE posts.post_type='nf_sub' AND posts.post_author = {$current_user->ID} AND (postmeta.meta_key='_form_id' AND postmeta.meta_value='4')";

		$results = $wpdb->get_results($qry, ARRAY_A);

		$qry = "SELECT id FROM {$wpdb->prefix}nf3_fields WHERE label='Job Title' AND parent_id=4";

		$field_id = $wpdb->get_var($qry);

		$final_arr = [];

		for($i=0;$i<count($results);$i++) {
			$qry = "SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=".$results[$i]['post_id']." AND meta_key='_field_{$field_id}'";
			
			$job_id = $wpdb->get_var($qry);

			if(is_numeric($job_id)) {
				$final_arr[] = array('user_id' => $results[$i]['post_author'], 'job_id' => $job_id);
			}
		}

		$job_post = get_page_by_title($_GET['job_title'], OBJECT, 'hf_jobs');

		$flag = false;

		foreach ($final_arr as $key => $value) {

			if(in_array($job_post->ID, $value)) {
				$flag = true;
				break;
			}
		}

  		if($flag) {
  			echo "You already have applied for this job. Go to <a href='".home_url('careers')."'>Jobs</a>!";
  		} else {
  			echo do_shortcode('[ninja_form id=4]');
  		}
  	} else {
  		echo "You must <a href='".home_url('member-login')."'>Login</a> to apply for the job.";
  	}
  	?>
  </div>
</section>