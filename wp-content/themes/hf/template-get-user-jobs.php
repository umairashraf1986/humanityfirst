<?php
/*
*
* Template Name: Get User Jobs (REST API)
*
*/

global $wpdb;

if(isset($_POST['user_id']) && !empty($_POST['user_id'])) {
	$qry = "SELECT posts.post_author, postmeta.post_id, postmeta.meta_key, postmeta.meta_value FROM {$wpdb->prefix}posts as posts INNER JOIN {$wpdb->prefix}postmeta as postmeta ON posts.ID=postmeta.post_id WHERE posts.post_type='nf_sub' AND posts.post_author={$_POST['user_id']} AND posts.post_status='publish' AND (postmeta.meta_key='_form_id' AND postmeta.meta_value='4')";
} else {
	$qry = "SELECT posts.post_author, postmeta.post_id, postmeta.meta_key, postmeta.meta_value FROM {$wpdb->prefix}posts as posts INNER JOIN {$wpdb->prefix}postmeta as postmeta ON posts.ID=postmeta.post_id WHERE posts.post_type='nf_sub' AND posts.post_status='publish' AND (postmeta.meta_key='_form_id' AND postmeta.meta_value='4')";
}

$results = $wpdb->get_results($qry, ARRAY_A);

$qry = "SELECT id FROM {$wpdb->prefix}nf3_fields WHERE label='Job Title' AND parent_id=4";

$field_id = $wpdb->get_var($qry);

$final_arr = [];

for($i=0;$i<count($results);$i++) {
	$qry = "SELECT meta_value FROM {$wpdb->prefix}postmeta WHERE post_id=".$results[$i]['post_id']." AND meta_key='_field_{$field_id}'";
	
	$job_title = $wpdb->get_var($qry);

	$job = get_page_by_title( $job_title, OBJECT, 'hf_jobs' );

	$job_end_date = get_post_meta($job->ID, 'hfusa-job_end_date', true);

	if(is_numeric($job->ID)) {
		$final_arr[] = array(
						'user_id' => $results[$i]['post_author'], 
						'job_id' => "$job->ID",
						'job_title' => $job_title,
						'job_end_date' => $job_end_date
					);
	}
}

header('Content-Type: application/json');

echo json_encode($final_arr, JSON_PRETTY_PRINT);
?>