<?php
/*
*
* Template Name: Get Working Hours for Mobile (REST API)
*
*/
global $wpdb;

$final_arr = array();

$qry = "SELECT * FROM {$wpdb->prefix}hours_worked";

if( !empty($_POST['userid']) && trim($_POST['userid']) != '' ) {
	$userid = $_POST['userid'];
	$qry .= " WHERE user_id = {$userid}";
}

$results = $wpdb->get_results( $qry, ARRAY_A );

if( $results ) {

	foreach ($results as $result) {
		$project_name = get_the_title( $result['project_id'] );
		$final_arr[] = array(
			'user_id' => (!empty($userid)) ? $userid : $result['user_id'],
			'project_id' => $result['project_id'],
			'project_name' => $project_name,
			'start_date' => date("m-d-Y", strtotime($result['start_date'])),
			'end_date' => date("m-d-Y", strtotime($result['end_date'])),
			'hours_worked' => $result['hours_worked']
		);
	}
}

header('Content-Type: application/json');
echo json_encode($final_arr, JSON_PRETTY_PRINT);
exit;
?>