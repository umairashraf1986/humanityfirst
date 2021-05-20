<?php
    /*
    Plugin Name: HFUSA Custom forms
    Plugin URI: http://usa.humanityfirst.org
    Description: A custom plugin for HFUSA forms
    Version: 1.0
    Author: Oracular
    Author URI: http://oracular.com
    License: GPL2
    */

    /* action hook trigged after the submission of the ninja form */

    add_action( 'ninja_forms_after_submission', 'cf_ninja_forms_after_submission' );

    function cf_ninja_forms_after_submission( $form_data ){

        /* ninja form id, agaisnt which the submission is made from frontend */
        $form_id = $form_data['form_id'];

        /*form fields by keys , defined in the ninja form builder screen*/

        $fields_by_key = isset($form_data['fields_by_key']) ? $form_data['fields_by_key'] : '';

        if(!empty($fields_by_key) && is_array($fields_by_key)){

            $insertionData = array();
            foreach ($fields_by_key as $key => $data) {

                $type  = isset($data["type"]) ? $data["type"] : '';
                $value  = isset($data["value"]) ? $data["value"] : '';
                $label  = isset($data["label"]) ? $data["label"] : '';

                /* json encode if the data type is array */
                if($type == 'listcheckbox'){
                    $value = !empty($value) ? json_encode($value) : '';
                }else if ($type == 'file_upload'){
                    $value = reset($value);
                }

                if($label=="Gender"){
                    if($value == 'm'){
                        $value = 'Male';
                    }elseif($value == 'f'){
                        $value = 'Female';
                    }
                }

                if(cf_include_field($type) == true){
                    $insertionData[$key] =  $value;
                }
            }


            $title = getFormTitle($form_id);

            if($title == 'Contact Us'){
                $mappedData = getMappedData($insertionData,'contact');
                hfInsertFormData('contact',$mappedData);
            }else if($title == 'Write Story Form'){
                $mappedData = getMappedData($insertionData,'write_story');
                hfInsertFormData('write_story',$mappedData);
            }else if ($title == 'Apply for Job Form'){
                $mappedData = getMappedData($insertionData,'apply_for_job');
                hfInsertFormData('apply_for_job',$mappedData);
            }else if ($title == 'Become A Sponsor'){
                $mappedData = getMappedData($insertionData,'become_sponsor');
                hfInsertFormData('become_sponsor',$mappedData);
            }else if ($title == 'Volunteer Form'){
                $mappedDataVolunteer = getMappedData($insertionData,'volunteer');
                $volunteer_id = hfInsertFormData('volunteer',$mappedDataVolunteer);
                $mappedDataAddress = getMappedData($insertionData,'address');
                $address_id = hfInsertFormData('address',$mappedDataAddress);

                if($volunteer_id && $address_id){
                    $volunteer_address = array(
                        'volunteer_id' => $volunteer_id,
                        'address_id' => $address_id
                    );
                    hfInsertFormData('volunteer_address',$volunteer_address);
                }
            }

        }
    }

    function cf_include_field($type=''){
        /*field types to exclude from the submission data*/
        $excludeTypes = array('submit','password','passwordconfirm');

        if(in_array($type, $excludeTypes))
            return false;
        else
            return true;
    }

    function hfInsertFormData($tbl_name='',$mappedData = array()){
       global $wpdb;
       $table = $wpdb->prefix . $tbl_name;
       $new_insert_record = $wpdb->insert( 
        $table, 
        $mappedData
    );

       if($new_insert_record==false){
        return false; 
    }

    return $wpdb->insert_id;;
}
function hfUpdateFormData($tbl_name='',$mappedData = array(),$where_formate){
    global $wpdb;
    $table = $wpdb->prefix . $tbl_name;
    $wpdb->update( 
        $table, 
        $mappedData,
        $where_formate
    );
}

function getMappedData($insertionData=array(),$table=''){
    global $wpdb;
    $mappedData = array();
    $mappingArray = array();

    
    $mappingArray  =   getTableMappedFields($table);

    foreach ($insertionData as $key => $value) {
        if(array_key_exists($key, $mappingArray)){
            $mappedData[$mappingArray[$key]]  = $value;
        }
    }

    return $mappedData;
}

function hfIsJson($str) {
    $json = json_decode($str);
    return $json && $str != $json;
}

function getTableMappedFields($table=''){

    /* 
        Add  mapping array here, where keys are the ninja form keys, 
        and values are the fields in the mysql tables
    */

        $mappingArray = array();

        if($table == 'contact'){

            $mappingArray = array(
                'contact_name'=>'name',
                'contact_email'=>'email',
                'contact_subject'=>'subject',
                'contact_message'=>'message'
            );

        }else if ($table == 'write_story'){

            $mappingArray = array(
                'hf_author_name'=>'author_name',
                'hf_author_email'=>'author_email',
                'hf_story_title'=>'story_title',
                'hf_story_content'=>'content',
                'hf_story_image'=>'image'
            );    

        }else if ($table == 'apply_for_job'){

            $mappingArray = array(
                'job_email'=>'email',
                'job_firstname'=>'first_name',
                'job_lastname'=>'last_name',
                'job_phone'=>'phone',
                'job_title'=>'job_title',
                'job_cover_letter'=>'cover_letter',
                'job_resume'=>'resume_file'
            );    

        }else if ($table == 'become_sponsor'){

            $mappingArray = array(
                'sponsor_email'=>'email',
                'sponsor_firstname'=>'first_name',
                'sponsor_lastname'=>'last_name',
                'sponsor_phone'=>'phone',
                'sponsor_company_name'=>'company',
                'sponsor_comments'=>'comments'
            );    

        }else if ($table == 'volunteer'){

            $mappingArray = array(
                'volunteer_email'=>'email',
                'volunteer_firstname'=>'first_name',
                'volunteer_middle_name'=>'middle_name',
                'volunteer_lastname'=>'last_name',
                'volunteer_organization'=>'organization',
                'volunteer_gender'=>'gender',
                'volunteer_reference'=>'referred_by',
                'volunteer_willing_hours'=>'willing_hours',
                'volunteer_schedule'=>'schedule',
                'volunteer_profession'=>'profession',
                'volunteer_interested_in_work'=>'work_interested_in',
                'volunteer_other'=>'other',
                'volunteer_comments'=>'comments'
            );    

        }else if ($table == 'address'){

            $mappingArray = array(
                'volunteer_address'=>'address',
                'volunteer_city'=>'city',
                'volunteer_liststate'=>'state',
                'volunteer_zip'=>'zip',
                'volunteer_country'=>'country',
                'volunteer_phone'=>'phone'
            );    

        }

        return $mappingArray;
    }

    function getFormTitle($form_id=''){
        global $wpdb;
        $title = $wpdb->get_var( "SELECT `title` FROM {$wpdb->prefix}nf3_forms WHERE id={$form_id}" );
        return $title;
    }


    function getFormTableName($title=''){

        $formTableNames =   array(
            'contact'=>'Contact Us',
            'write_story'=>'Write Story Form',
            'apply_for_job'=>'Apply for Job Form',
            'become_sponsor'=>'Become A Sponsor',
            'volunteer'=>'Volunteer Form',
        );

        $key = array_search($title, $formTableNames);
        return $key;
    }

    function getFormSubmissionsCount($form_id=''){
        global $wpdb;
        $count = 0;
        $title = getFormTitle($form_id);
        $tableName = getFormTableName($title);

        if(!empty($tableName)){
            $tableName = $wpdb->prefix.$tableName;
            $count = $wpdb->get_var( "SELECT COUNT(*) FROM {$tableName}" );
        }
        return $count;
    }



    /* Register a custom menu page. */
    function cfs_register_menu_page(){
        add_menu_page( 
            __( 'Form Submissions', 'textdomain' ),
            'Form Submissions',
            'manage_options',
            'cfspage',
            'csf_menu_page',
            'dashicons-list-view',
            100
        ); 
    }
    add_action( 'admin_menu', 'cfs_register_menu_page' );

    /*  Display a custom menu page */
    function csf_menu_page(){

        global $wpdb;


        if(!empty($_GET['sub_id']) && !empty($_GET['form_id'])){
            $form_id = $_GET['form_id'];
            $sub_id = $_GET['sub_id'];
            $title = getFormTitle($form_id);
            $tableName = getFormTableName($title);


            if(!empty($tableName)){
              $primary_key = '';

              if($tableName=='volunteer'){
                  $primary_key = 'volunteer_id';
              }elseif ($tableName=='write_story') {
                  $primary_key = 'story_id';
              }elseif ($tableName=='apply_for_job') {
                  $primary_key = 'application_id';
              }elseif ($tableName=='become_sponsor') {
                  $primary_key = 'sponsor_id';
              }elseif ($tableName=='contact') {
                  $primary_key = 'contact_id';
              }  

              $results = $wpdb->get_row( "SELECT * FROM {$wpdb->prefix}{$tableName} WHERE {$primary_key}={$sub_id}", ARRAY_A );
              if($tableName=='volunteer'){
                $volunteer_address = $wpdb->get_results( "SELECT address_id FROM {$wpdb->prefix}volunteer_address WHERE volunteer_id={$sub_id}", ARRAY_A );
                foreach ($volunteer_address as $key => $value) {
                    $address_id = $value["address_id"];
                    $address_details = $wpdb->get_results( "SELECT address,city,state,phone,zip,country FROM {$wpdb->prefix}address WHERE address_id={$address_id}", ARRAY_A );
                    foreach ($address_details as $address_detail) {
                        $results = array_merge($results,$address_detail);
                    }
                }
            }

            if(!empty($results) && is_array($results)){
                ?>

                <div style="height: 20px;"></div>
                <a href="<?php echo admin_url(); ?>/admin.php?page=cfspage&form_id=<?php echo $form_id;?>">Back</a>
                <table width="100%" class="" style="background-color: #ffffff; margin-top: 15px;max-width: 800px;" cellpadding="10" cellspacing="0">
                    <thead style="background-color: #cccccc;">
                        <tr>
                            <th align="left">Field</th>
                            <th align="left">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($results as $key => $result) {
                            echo '<tr>
                            <td align="left" style="border : 1px solid #eeeeee;"><strong>'.ucfirst(str_replace("_", " ", $key)).'</strong></td>
                            <td align="left" style="border : 1px solid #eeeeee;">';
                            if(hfIsJson($result)){
                                $result = json_decode($result);
                                echo implode (", ", $result);
                            }else if($key=='created_at'){
                                echo date("j<\s\up>S</\s\up> M Y", strtotime($result));
                            }else{
                                echo !empty($result) ? $result : '-';
                            }
                            echo '</td>
                            </tr>';
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            }
        }

    }else if(!empty($_GET['form_id'])){
        $form_id = $_GET['form_id'];
        $title = getFormTitle($form_id);
        $tableName = getFormTableName($title);
        if(!empty($tableName)){

          if($tableName=='volunteer'){
              $primary_key = 'volunteer_id';
          }elseif ($tableName=='write_story') {
              $primary_key = 'story_id';
          }elseif ($tableName=='apply_for_job') {
              $primary_key = 'application_id';
          }elseif ($tableName=='become_sponsor') {
              $primary_key = 'sponsor_id';
          }elseif ($tableName=='contact') {
              $primary_key = 'contact_id';
          } 

          $items_per_page = 20;
          $page = isset( $_GET['cpage'] ) ? abs( (int) $_GET['cpage'] ) : 1;
          $offset = ( $page * $items_per_page ) - $items_per_page;
          $table_name=$wpdb->prefix.$tableName;
          $query = 'SELECT * FROM '.$table_name.' ORDER BY '.$primary_key.' DESC';
          $total_query = "SELECT COUNT(1) FROM (${query}) AS combined_table";
          $total = $wpdb->get_var( $total_query );

          $results = $wpdb->get_results( $query.'  LIMIT '. $offset.', '. $items_per_page, ARRAY_N);

/*          echo '<pre>';
          print_r($results);
          echo '</pre>';*/

          $mappingArray  =   getTableMappedFields($tableName);
          ?>
          <div style="height: 20px;"></div>
          <a href="<?php echo admin_url(); ?>/admin.php?page=cfspage">Back</a>
          <h2>Form Submissions</h2>
          <table class="wp-list-table widefat fixed striped posts" style="width: 98%;">
            <thead>
                <tr>
                    <th width="50">Sr#</th>
                    <?php
                    $columns=0;
                    foreach ($mappingArray as $key => $value) {
                        if($columns<=3){
                            echo '<th>'.ucfirst(str_replace("_", " ", $value)).'</th>';
                            $columns++;
                        }
                    }
                    ?>
                    <th>Submission Date</th>
                    <th width="50">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    if(!empty($results)){
                        $sr=$items_per_page*($page-1);
                        foreach ($results as $key => $tableRow) {

                            $publishDate = end($tableRow);

                            echo '<tr>';
                            for($i=0;$i<(count($tableRow)-1);$i++){
                                if($i<5){
                                    if($i==0){
                                        echo '<td>'.++$sr.'</td>';
                                    }else{
                                        echo '<td>';
                                        echo !empty($tableRow[$i]) ? $tableRow[$i] : '-';
                                        echo '</td>';
                                    }
                                }
                            }

                        if(!empty($publishDate)){
                            echo '<td>'.date("j<\s\up>S</\s\up> M Y", strtotime($publishDate)).'</td>';
                        }else{
                            echo '<td>-</td>';
                        }

                         echo '<td><a href="'.admin_url().'/admin.php?page=cfspage&form_id='.$form_id.'&sub_id='.$tableRow[0].'">View</a></td>';
                         echo '</tr>';
                     }
                 }else{
                    echo '<td colspan="7">No record found!</td>';
                }
                ?>
            </tbody>
        </table>

        <div class="tablenav">
            <div class="tablenav-pages"  style="float: left;">
                <span class="pagination-links">
                    <?php
                    echo paginate_links( array(
                        'base' => add_query_arg( 'cpage', '%#%' ),
                        'format' => '',
                        'prev_text' => __('&laquo;'),
                        'next_text' => __('&raquo;'),
                        'total' => ceil($total / $items_per_page),
                        'current' => $page
                    ));
                    ?>
                </span>
            </div>
        </div>

        <?php

    }else{
        echo '<p>Database table not found.</p>';
    }

}else{

    $forms = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}nf3_forms", OBJECT );

    ?>
    <h2>Form Details</h2>
    <table class="wp-list-table widefat fixed striped posts" style="width: 98%;">
        <thead>
            <tr>
                <th width="10%">Sr#</th>
                <th width="50%">Form Title</th>
                <th width="20%">Date Created</th>
                <th width="10%">Submissions</th>
                <th width="10%">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($forms) && is_array($forms)){
                $i=0;
                foreach ($forms as $form) {
                    $formId = isset($form->id) ? $form->id : '';
                    $subCount = getFormSubmissionsCount($formId);
                    ?>
                    <tr>
                        <td><?php echo ++$i; ?></td>
                        <td><?php echo $form->title; ?></td>
                        <td><?php 

                        $created_at = $form->created_at;
                        $newDate = date("j<\s\up>S</\s\up> M Y", strtotime($created_at));

                        echo $newDate; ?></td>
                        <td><?php echo $subCount; ?></td>
                        <td><a href="<?php echo admin_url(); ?>/admin.php?page=cfspage&form_id=<?php echo $form->id; ?>">View</a></td>
                    </tr>
                    <?php 
                }
            } ?>
        </tbody>
    </table>
    <?php
}
}


add_action( 'rest_insert_user', 'hf_custom_forms_registration_save', 900, 3 );

function hf_custom_forms_registration_save( $user,$request,$creating ) {


    $user_id = $user->ID;
    $user_email = $user->user_email;
    global $profile_fields;
    global $wpdb;

    $params = $request->get_body_params();
    $insertionData = array();

    if(isset($params["roles"]) && is_array($params["roles"]) && in_array('volunteer', $params["roles"])){


        $insertionData['volunteer_email'] = $user_email;

        if($creating==true){

            foreach($params as $key=>$value){
                if(!empty($value) && is_array($value)){
                    $insertionData[$key] = json_encode($value);
                }else{
                    $insertionData[$key] = $value;
                }
            }

            if(!isset($params['volunteer_firstname'])){
                $insertionData['volunteer_firstname'] = isset($params['first_name']) ? $params['first_name'] : '';
            }

            if(!isset($params['volunteer_lastname'])){
                $insertionData['volunteer_lastname'] = isset($params['last_name']) ? $params['last_name'] : '';
            }


            $mappedDataVolunteer = getMappedData($insertionData,'volunteer');
            $volunteer_id = hfInsertFormData('volunteer',$mappedDataVolunteer);
            $mappedDataAddress = getMappedData($insertionData,'address');
            $address_id = hfInsertFormData('address',$mappedDataAddress);

            if($volunteer_id && $address_id){
                $volunteer_address = array(
                    'volunteer_id' => $volunteer_id,
                    'address_id' => $address_id
                );
                hfInsertFormData('volunteer_address',$volunteer_address);
            }

        }else{

            $profile_fields['volunteer_firstname'] =  'Volunteer First Name';
            $profile_fields['volunteer_lastname'] =  'Volunteer Last Name';

            /* get all already present values in case of update*/
            foreach($profile_fields as $key=>$value){
                $meta_value =  get_user_meta($user_id,$key,true);
                if(!empty($meta_value) && is_array($meta_value)){
                    $insertionData[$key] = json_encode($meta_value);
                }else{
                    $insertionData[$key] = get_user_meta($user_id,$key,true);
                }
            }

            if(empty($insertionData['volunteer_firstname'])){
                $first_name = isset($params['first_name']) ? $params['first_name'] : '';
                if(empty($first_name)){
                    $first_name = get_user_meta($user_id,'first_name',true);
                }
                $insertionData['volunteer_firstname'] = $first_name;
            }

            if(empty($insertionData['volunteer_lastname'])){
                $last_name = isset($params['last_name']) ? $params['last_name'] : '';
                if(empty($last_name)){
                    $last_name = get_user_meta($user_id,'last_name',true);
                }
                $insertionData['volunteer_lastname'] = $last_name;
            }

            /*override the vlaues that are newly updated */
            foreach($params as $key=>$value){
                if(!empty($value) && is_array($value)){
                    $insertionData[$key] = json_encode($value);
                }else{
                    $insertionData[$key] = $value;
                }
            }

            $volunteer_id = $wpdb->get_var( "SELECT `volunteer_id` FROM {$wpdb->prefix}volunteer WHERE `email`='{$user_email}' ORDER BY `volunteer_id` DESC LIMIT 1" );
            if(!empty($volunteer_id)){
                $mappedDataVolunteer = getMappedData($insertionData,'volunteer');
                hfUpdateFormData('volunteer',$mappedDataVolunteer,array('volunteer_id'=>$volunteer_id));
                $address_ids = $wpdb->get_results( "SELECT `address_id` FROM {$wpdb->prefix}volunteer_address WHERE `volunteer_id`={$volunteer_id}" );
                $mappedDataAddress = getMappedData($insertionData,'address');
                if($address_ids && is_array($address_ids)){
                    foreach ($address_ids as $key => $value) {
                        if(!empty($value->address_id)){
                            $address_id = $value->address_id;
                            hfUpdateFormData('address',$mappedDataAddress,array('address_id'=>$address_id));
                        }
                    }
                }                 
            }else{

                $mappedDataVolunteer = getMappedData($insertionData,'volunteer');
                $volunteer_id = hfInsertFormData('volunteer',$mappedDataVolunteer);
                $mappedDataAddress = getMappedData($insertionData,'address');
                $address_id = hfInsertFormData('address',$mappedDataAddress);

                if($volunteer_id && $address_id){
                    $volunteer_address = array(
                        'volunteer_id' => $volunteer_id,
                        'address_id' => $address_id
                    );
                    hfInsertFormData('volunteer_address',$volunteer_address);
                }
            }
        }
    }
}

function hfIsValidTimeStamp($timestamp)
{
    return ((string) (int) $timestamp === $timestamp) 
    && ($timestamp <= PHP_INT_MAX)
    && ($timestamp >= ~PHP_INT_MAX);
}