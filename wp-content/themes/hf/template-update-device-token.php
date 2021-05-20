<?php
/*
*
* Template Name: Update Device Token (REST API)
*
*/

global $wpdb;

if(isset($_POST['user_id']) && isset($_POST['device_token']) && isset($_POST['device_type'])) {

	$device_type = $_POST['device_type'];

	$column_name = "";
	if($device_type == "android") {
		$column_name = "android_token";
	} else {
		$column_name = "ios_token";
	}

	$user_id = $wpdb->get_var("SELECT user_id FROM {$wpdb->prefix}user_device_info WHERE `user_id`={$_POST['user_id']}");

	if($user_id) {

		$result = $wpdb->update(
					$wpdb->prefix."user_device_info", 
					array( 
						$column_name => $_POST['device_token'] 
					), 
					array( 'user_id' => $user_id )
				);

		if($result === false) {
			$final_arr = array("success" => "false", "message" => "could not update token");
		} else {
			$final_arr = array("success" => "true", "message" => "token updated");
		}

	} else {

		$result = $wpdb->insert(
					$wpdb->prefix."user_device_info", 
					array( 
						'user_id' => $_POST['user_id'], 
						$column_name => $_POST['device_token']
					)
				);

		if($result === false) {
			$final_arr = array("success" => "false", "message" => "could not insert token");
		} else {
			$final_arr = array("success" => "true", "message" => "token inserted");
		}

	}

} else {
	$final_arr = array("success" => "false", "message" => "parameters missing");
}

header('Content-Type: application/json');

echo json_encode($final_arr, JSON_PRETTY_PRINT);
?>