<?php
/*
*
* Template Name: Apply for Job from Mobile (REST API)
*
*/
global $wpdb;

if( !isset($_POST['user_id']) || empty($_POST['user_id']) ) {
	$final_arr = array("success" => "false", "message" => "User ID is required");
} elseif( !isset($_POST['job_id'])  || empty($_POST['job_id']) ) {
	$final_arr = array("success" => "false", "message" => "Job ID is required");
} elseif( !isset($_POST['job_firstname'])  || empty($_POST['job_firstname']) ) {
	$final_arr = array("success" => "false", "message" => "First name is required");
} elseif( !isset($_POST['job_lastname'])  || empty($_POST['job_lastname']) ) {
	$final_arr = array("success" => "false", "message" => "Last name is required");
} elseif( !isset($_POST['job_email'])  || empty($_POST['job_email']) ) {
	$final_arr = array("success" => "false", "message" => "Email is required");
} elseif( !isset($_POST['job_cover_letter'])  || empty($_POST['job_cover_letter']) ) {
	$final_arr = array("success" => "false", "message" => "Cover letter is required");
} elseif( !isset($_FILES['fileToUpload']['tmp_name']) || !file_exists($_FILES['fileToUpload']['tmp_name']) || !is_uploaded_file($_FILES['fileToUpload']['tmp_name']) ) {
	$final_arr = array("success" => "false", "message" => "File is required");
} else {
	$_POST['job_title'] = get_the_title($_POST['job_id']);
	$insertionData = array();
	$upload_dir = wp_upload_dir();
	$target_dir = $upload_dir['basedir']."/ninja-forms/4/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$filename = pathinfo($target_file, PATHINFO_FILENAME);
	$uploadOk = 1;
	$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$uniquesavename = time().uniqid(rand());
	$target_file = $target_dir . $filename . "-" . $uniquesavename . "." . $fileType;
	
	// Check if file already exists
	if (file_exists($target_file)) {
		$final_arr = array("success" => "false", "message" => "File already exists");
		$uploadOk = 0;
	}
	// Check file size
	// if ($_FILES["fileToUpload"]["size"] > 500000) {
	//     echo "Sorry, your file is too large.";
	//     $uploadOk = 0;
	// }
	// Allow certain file formats
	if($fileType != "pdf" && $fileType != "doc" && $fileType != "docx" ) {
		$final_arr = array("success" => "false", "message" => "only PDF, DOC & DOCX files are allowed");
		$uploadOk = 0;
	}
	// Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
		$final_arr = array("success" => "false", "message" => "your file was not uploaded.");
	// if everything is ok, try to upload file
	} else {
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

			$date = date("Y-m-d H:i:s");

			$qry = "SELECT posts.post_author, postmeta.post_id, postmeta.meta_key, postmeta.meta_value FROM {$wpdb->prefix}posts as posts INNER JOIN {$wpdb->prefix}postmeta as postmeta ON posts.ID=postmeta.post_id WHERE posts.post_type='nf_sub' AND (postmeta.meta_key='_form_id' AND postmeta.meta_value='4')";

			$results = $wpdb->get_results($qry, ARRAY_A);

			$final_arr = [];

			$user_id = $_POST['user_id'];
			$comment_status = $ping_status = 'closed';

			$result = $wpdb->insert(
				$wpdb->prefix."posts",
				array( 
					'post_author' => $user_id,
					'post_type' => 'nf_sub',
					'comment_status' => $comment_status,
					'ping_status' => $ping_status,
					'post_date' => $date,
					'post_date_gmt' => $date,
					'post_modified' => $date,
					'post_modified_gmt' => $date
				)
			);

			if($result !== false) {

				$post_id = $wpdb->insert_id;

				$result = $wpdb->update(
					$wpdb->prefix."posts", 
					array( 
						'post_name' => $post_id,
						'guid' => home_url()."/nf_sub/".$post_id."/"
					), 
					array( 'ID' => $post_id )
				);

				if($result === false) {
					$final_arr = array("success" => "false", "message" => "could not update submission");
				} else {

					$qry = "SELECT * FROM {$wpdb->prefix}nf3_fields WHERE `parent_id`=4";

					$fields = $wpdb->get_results($qry, ARRAY_A);

					foreach( $_POST as $key=>$val ){

						if(!empty($val)){
							$field_id = $wpdb->get_var( "SELECT id FROM {$wpdb->prefix}nf3_fields where {$wpdb->prefix}nf3_fields.key='".$key."'" );
							update_post_meta( $post_id, '_field_'.$field_id, $val );
						}
						$insertionData[$key] =  $val;
					}


					$insertionData["job_phone"] = !empty($_POST["job_phone"]) ? $_POST["job_phone"] : '';


					$field_id = $wpdb->get_var( "SELECT id FROM {$wpdb->prefix}nf3_fields where {$wpdb->prefix}nf3_fields.key='job_resume' AND {$wpdb->prefix}nf3_fields.parent_id=4" );
					if( !empty($field_id) ) {
						$file_path = array();
						$file_path['job_resume'] = home_url()."/wp-content/uploads/ninja-forms/4/".$filename . "-" . $uniquesavename . "." . $fileType;
						update_post_meta( $post_id, '_field_'.$field_id, $file_path );
						$insertionData["job_resume"] = $file_path['job_resume'];				}

						update_post_meta( $post_id, '_form_id', 4 );

						$tableFormMeta=$wpdb->prefix.'nf3_form_meta';
						$last_seq_num = $wpdb->get_var("SELECT value FROM $tableFormMeta WHERE {$wpdb->prefix}nf3_form_meta.key = '_seq_num' AND parent_id = 4 ");
						if($last_seq_num){
							update_post_meta( $post_id, '_seq_num', $last_seq_num ); 
							$last_seq_num = $last_seq_num +1;		
							$rrr=$wpdb->update( 
								$tableFormMeta, 
								array(
									'value' => $last_seq_num,	
								),
								array(
									'key' => '_seq_num',
									'parent_id' => 4
								) 			
							);
						}

						$mappedData = getMappedData($insertionData,'apply_for_job');
						hfInsertFormData('apply_for_job',$mappedData);

						$final_arr = array("success" => "true", "message" => "submission updated");
					}
					
				// $final_arr = array("success" => "true", "message" => "applied for job successfully!");
				} else {
					$final_arr = array("success" => "false", "message" => "request failed!");
				}
			} else {
				$final_arr = array("success" => "false", "message" => "Sorry, there was an error uploading your file");
			}
		}
	}

	header('Content-Type: application/json');

	echo json_encode($final_arr, JSON_PRETTY_PRINT);
	?>