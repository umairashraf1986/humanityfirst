<?php
/*
*
* Template Name: Project Working Hours for Mobile (REST API)
*
*/
global $wpdb;

$final_arr=array();

$userid = (!empty($_POST['userid']) && trim($_POST['userid'] !='')) ? $_POST['userid']  : '';
$projectid = (!empty($_POST['projectid']) && trim($_POST['projectid'] !='')) ? $_POST['projectid']  : '';
$hoursworked = (!empty($_POST['hoursworked']) && trim($_POST['hoursworked'] !='')) ? $_POST['hoursworked']  : '';
$startdate = (!empty($_POST['startdate']) && trim($_POST['startdate'] !='')) ? $_POST['startdate']  : '';
$enddate = (!empty($_POST['enddate']) && trim($_POST['enddate'] !='')) ? $_POST['enddate']  : '';

if( empty($userid) ) {
	$final_arr = array("success" => "false", "message" => "User ID is required");
} else if( empty($projectid) ) {
	$final_arr = array("success" => "false", "message" => "Project ID is required");
} else if(  empty($hoursworked) ) {
	$final_arr = array("success" => "false", "message" => "Hours Worked is required");
}  else if(  empty($startdate) ) {
	$final_arr = array("success" => "false", "message" => "Start Date is required");
}  else if(  empty($enddate) ) {
	$final_arr = array("success" => "false", "message" => "End Date is required");
} else{
	

	$startdate = str_replace("-","/",$startdate);
	$enddate = str_replace("-","/",$enddate);
	$startdateFormated = date("Y-m-d", strtotime($startdate));
	$enddateFormated = date("Y-m-d", strtotime($enddate));

	$id = $wpdb->get_var( $wpdb->prepare(
		"SELECT id FROM {$wpdb->prefix}hours_worked WHERE project_id=%d  AND user_id=%d AND start_date=%s AND end_date=%s LIMIT 1"
		,$projectid,$userid,$startdateFormated,$enddateFormated ) );

	if(!empty($id)){
		$wpdb->update( $wpdb->prefix . 'hours_worked', array( 'user_id' => $userid,'project_id' => $projectid,'hours_worked' => $hoursworked  ), array( 'id' => $id ) );
		$final_arr = array("success" => "true", "message" => "Record updated successfully.");
	}else{

		$wpdb->query( 
			$wpdb->prepare( 
				"INSERT INTO {$wpdb->prefix}hours_worked (user_id, project_id, hours_worked, start_date, end_date) 
				VALUES ( %d, %d, %s, %s, %s)",$userid,$projectid,$hoursworked,$startdateFormated,$enddateFormated
			)
		);

		$final_arr = array("success" => "true", "message" => "Record inserted successfully.");
	}

}

header('Content-Type: application/json');
echo json_encode($final_arr, JSON_PRETTY_PRINT);
exit;
?>