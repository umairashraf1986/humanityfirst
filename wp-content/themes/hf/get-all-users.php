<?php
/*
*
* Template Name: Get All Users (REST API)
*
*/

$users_array = [];
if(isset($_GET['id']) && !empty($_GET['id'])) {
    $user_id = $_GET['id'];

    $user_data = get_userdata($user_id);

    $user_role = implode(', ', $user_data->roles);

    $user_name = $user_data->display_name;

    $user_profile_image = get_user_meta($user_id, 'profile_image_url', true);

    $user_detail_response = array("ID" => $user_id, "Role" => $user_role, "Display Name" => $user_name, "Profile Image URL" => $user_profile_image);

    $users_array[] = $user_detail_response;
} else {
    $users = get_users( array( 'fields' => array( 'ID' ) ) );
    foreach($users as $user_id){

        $user_info = $user_id->ID;

        $get_user_data = get_userdata($user_info);

        $user_role = implode(', ', $get_user_data->roles);

        $user_name = $get_user_data->display_name;

        $user_profile_image = get_user_meta($user_info, 'profile_image_url', true);

        $user_detail_response = array("ID" => $user_info, "Role" => $user_role, "Display Name" => $user_name, "Profile Image URL" => $user_profile_image);

        $users_array[] = $user_detail_response;
    }
}

//echo '<pre>';
//print_r($users_array);
header('Content-Type: application/json');
echo json_encode($users_array,JSON_PRETTY_PRINT);
//echo '</pre>';
