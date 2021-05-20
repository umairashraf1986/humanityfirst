<?php
/*
*
* Template Name: Login Verification (REST API)
*
*/

if(isset($_POST['email']) && isset($_POST['password'])) {

	$response['status'] = '';
	$response['message'] = '';

	// this returns the user ID and other info from the user name
	$user = get_user_by('email', $_POST['email']);

	// if the email doesn't exist
	if(empty( $user )) {
		$response['status'] = 'fail';
		$response['message'] = 'Invalid email';
		echo json_encode($response);
		exit;
	}

	// if no password was entered
	if(!isset($_POST['password']) || $_POST['password'] == '') {
		$response['status'] = 'fail';
		$response['message'] = 'Please enter a password';
		echo json_encode($response);
		exit;
	}

	// check the user's email with their password
	if(!empty( $user )) {
		if(!wp_check_password($_POST['password'], $user->data->user_pass, $user->ID)) {
			// if the password is incorrect for the specified user
			$response['status'] = 'fail';
			$response['message'] = 'Incorrect password';
		} else {
			$response['status'] = 'success';
			$response['message'] = 'Logged in successfully';
			$response['userid'] = $user->ID;
		}
	}



} else if(!isset($_POST['email'])) {
	$response['status'] = 'fail';
	$response['message'] = 'Email is required';
} else if(!isset($_POST['password'])) {
	$response['status'] = 'fail';
	$response['message'] = 'Password is required';
}

echo json_encode($response);

?>