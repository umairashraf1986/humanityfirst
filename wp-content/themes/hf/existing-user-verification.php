<?php
/*
*
* Template Name: Existing User Verification (REST API)
*
*/


if(isset($_POST['email'])) {

	$response['status'] = '';
	$response['message'] = '';

	// this returns the user ID and other info from the user name
	$user = get_user_by('email', $_POST['email']);

	// if the email doesn't exist
	if(empty( $user )) {
		$response['status'] = 'fail';
		$response['message'] = 'User does not exist';
		echo json_encode($response);
		exit;
	} else {
		$response['status'] = 'success';
		$response['message'] = 'User exists';
		$response['userID'] = $user->ID;
	}

} else {
	$response['status'] = 'fail';
	$response['message'] = 'Email is required';
}

echo json_encode($response);

?>
