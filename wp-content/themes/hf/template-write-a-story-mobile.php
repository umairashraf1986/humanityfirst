<?php
/*
*
* Template Name: Write a Story from Mobile (REST API)
*
*/


$final_arr=array();

if( empty($_POST['authoremail']) ) {
	$final_arr = array("success" => "false", "message" => "Author email is required");
} else if( empty($_POST['authorname']) ) {
	$final_arr = array("success" => "false", "message" => "Author name is required");
} else if(  empty($_POST['storytitle']) ) {
	$final_arr = array("success" => "false", "message" => "Story title is required");
} else if(  empty($_POST['storycontent']) ) {
	$final_arr = array("success" => "false", "message" => "Story content is required");
}else{

	global $wpdb;
	$authoremail = $_POST["authoremail"];
	$authorname = $_POST["authorname"];
	$storytitle = $_POST["storytitle"];
	$storycontent = $_POST["storycontent"];
	$storyimage = !empty($_FILES['storyimage']['tmp_name']) ? true : false;
	$idStories = get_category_by_slug('stories'); 
	$stories = isset($idStories->term_id) ? $idStories->term_id : '';

	$my_post_story = array(
		'post_title'    => wp_strip_all_tags( $storytitle ),
		'post_content'  => $storycontent,
		'post_status'   => 'draft',
		'post_author'   => 1,
		'post_category' => array( $stories )
	);

	$post_id = wp_insert_post( $my_post_story );

	if(!empty($post_id) && $storyimage==true){

		require_once( ABSPATH . 'wp-admin/includes/image.php' );
		require_once( ABSPATH . 'wp-admin/includes/file.php' );
		require_once( ABSPATH . 'wp-admin/includes/media.php' );

		$attachment_id = media_handle_upload( 'storyimage',$post_id );
		if(!empty($attachment_id)){
			set_post_thumbnail( $post_id, $attachment_id );
		}
	}

	if(!empty($post_id)){
		$final_arr = array("success" => "true", "message" => "Story saved successfully.");

		$htmlString='<table>
		<tr>
		<td valign="top">Author Name:</td>
		<td>'.$authorname.'</td>
		</tr>
		<tr>
		<td valign="top">Author Email:</td>
		<td>'.$authoremail.'</td>
		</tr>
		<tr>
		<td valign="top">Story Title:</td>
		<td>'.$storytitle.'</td>
		</tr>
		<tr>
		<td valign="top">Story:</td>
		<td>'.$storycontent.'</td>
		</tr>
		</table>';

		$qry = "SELECT {$wpdb->prefix}nf3_action_meta.value FROM {$wpdb->prefix}nf3_action_meta INNER JOIN {$wpdb->prefix}nf3_actions ON {$wpdb->prefix}nf3_actions.id = {$wpdb->prefix}nf3_action_meta.parent_id WHERE {$wpdb->prefix}nf3_actions.parent_id=3 AND {$wpdb->prefix}nf3_actions.type='email' AND {$wpdb->prefix}nf3_action_meta.key='email_subject'";

		$email_subject = $wpdb->get_var( $qry );

		if( empty($email_subject) ) {
			$email_subject = "New Story Submission";
		}

		$admin_email = get_option( 'admin_email' ); 
		$headers = array('Content-Type: text/html; charset=UTF-8'); 
		$emailSent=wp_mail($admin_email, $email_subject, $htmlString, $headers);
		if($emailSent){
			error_log('mail sent');
		}else{
			error_log('mail not sent');
		}

	}else{
		$final_arr = array("success" => "false", "message" => "Error");
	}


	$sub = array(     
		'post_title'    => wp_strip_all_tags( $storytitle ),
		'post_content'  => $storycontent,
		'post_type' => 'nf_sub',
		'post_status' => 'publish',
		'post_author'   => 1
	);

	$sub_id = wp_insert_post( $sub );
	update_post_meta( $sub_id, '_form_id', 3 ); 
	$tableFormMeta=$wpdb->prefix.'nf3_form_meta';
	$last_seq_num = $wpdb->get_var("SELECT value FROM $tableFormMeta WHERE {$wpdb->prefix}nf3_form_meta.key = '_seq_num' AND parent_id = 3 ");
	if($last_seq_num){
		update_post_meta( $sub_id, '_seq_num', $last_seq_num ); 
		$last_seq_num = $last_seq_num +1;		
		$rrr=$wpdb->update( 
			$tableFormMeta, 
			array( 
				'value' => $last_seq_num,	
			), 
			array(
				'key' => '_seq_num',
				'parent_id' => 3 
			) 			
		);
	}

	$insertionData = array();

	foreach( $_POST as $key=>$val ){
		$form_field_key='';
		if($key=="authoremail" &&  !empty($val)){
			$form_field_key='hf_author_email';
		}else if($key=="authorname" &&  !empty($val)){
			$form_field_key='hf_author_name';
		}else if($key=="storytitle" &&  !empty($val)){
			$form_field_key='hf_story_title';
		}else if($key=="storycontent" &&  !empty($val)){
			$form_field_key='hf_story_content';
		}

		if(!empty($form_field_key)){
			$field_id = $wpdb->get_var( "SELECT id FROM {$wpdb->prefix}nf3_fields where {$wpdb->prefix}nf3_fields.key='".$form_field_key."'" );			
			update_post_meta( $sub_id, '_field_'.$field_id, $val ); 
			$insertionData[$form_field_key] =  $val;	
		}


	}

	if(!empty($_FILES['storyimage']['tmp_name'])){		
		$field_id = $wpdb->get_var( "SELECT id FROM {$wpdb->prefix}nf3_fields where {$wpdb->prefix}nf3_fields.key='hf_story_image'" );	
		$attachmentUrl= wp_get_attachment_url( $attachment_id );
		$attachmentArray=array();
		$attachmentArray[$attachment_id] = $attachmentUrl;
		update_post_meta( $sub_id, '_field_'.$field_id, $attachmentArray ); 
		$insertionData['hf_story_image'] =  $attachmentUrl;	
	}	

	$mappedData = getMappedData($insertionData,'write_story');
	hfInsertFormData('write_story',$mappedData);
}

header('Content-Type: application/json');
echo json_encode($final_arr, JSON_PRETTY_PRINT);
exit;
?>