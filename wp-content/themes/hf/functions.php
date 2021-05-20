<?php
/**
 * Sage includes
 *
 * The $sage_includes array determines the code library included in your theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 *
 * Please note that missing files will produce a fatal error.
 *
 * @link https://github.com/roots/sage/pull/1042
 */


if (!session_id()) {
    session_start();
}


$sage_includes = [
    'lib/assets.php',                     // Scripts and stylesheets
    'lib/extras.php',                     // Custom functions
    'lib/setup.php',                      // Theme setup
    'lib/titles.php',                     // Page titles
    'lib/wrapper.php',                    // Theme wrapper class
    'lib/customizer.php',                 // Theme customizer
    'lib/titan-framework-checker.php',    // Titan Framework
    'lib/theme-options.php',              // Theme Options,
    'lib/bootstrap-navwalker.php',        // Bootstrap Navwalker
    'lib/bootstrap-breadcrumb.php'        // Bootstrap Breadcrumb
];

foreach ($sage_includes as $file) {
    if (!$filepath = locate_template($file)) {
        trigger_error(sprintf(__('Error locating %s for inclusion', 'sage'), $file), E_USER_ERROR);
    }

    require_once $filepath;
}
unset($file, $filepath);


$hf_us_state_abbrevs_names = array(
    'AL' => 'ALABAMA',
    'AK' => 'ALASKA',
    'AS' => 'AMERICAN SAMOA',
    'AZ' => 'ARIZONA',
    'AR' => 'ARKANSAS',
    'CA' => 'CALIFORNIA',
    'CO' => 'COLORADO',
    'CT' => 'CONNECTICUT',
    'DE' => 'DELAWARE',
    'DC' => 'DISTRICT OF COLUMBIA',
    'FM' => 'FEDERATED STATES OF MICRONESIA',
    'FL' => 'FLORIDA',
    'GA' => 'GEORGIA',
    'GU' => 'GUAM GU',
    'HI' => 'HAWAII',
    'ID' => 'IDAHO',
    'IL' => 'ILLINOIS',
    'IN' => 'INDIANA',
    'IA' => 'IOWA',
    'KS' => 'KANSAS',
    'KY' => 'KENTUCKY',
    'LA' => 'LOUISIANA',
    'ME' => 'MAINE',
    'MH' => 'MARSHALL ISLANDS',
    'MD' => 'MARYLAND',
    'MA' => 'MASSACHUSETTS',
    'MI' => 'MICHIGAN',
    'MN' => 'MINNESOTA',
    'MS' => 'MISSISSIPPI',
    'MO' => 'MISSOURI',
    'MT' => 'MONTANA',
    'NE' => 'NEBRASKA',
    'NV' => 'NEVADA',
    'NH' => 'NEW HAMPSHIRE',
    'NJ' => 'NEW JERSEY',
    'NM' => 'NEW MEXICO',
    'NY' => 'NEW YORK',
    'NC' => 'NORTH CAROLINA',
    'ND' => 'NORTH DAKOTA',
    'MP' => 'NORTHERN MARIANA ISLANDS',
    'OH' => 'OHIO',
    'OK' => 'OKLAHOMA',
    'OR' => 'OREGON',
    'PW' => 'PALAU',
    'PA' => 'PENNSYLVANIA',
    'PR' => 'PUERTO RICO',
    'RI' => 'RHODE ISLAND',
    'SC' => 'SOUTH CAROLINA',
    'SD' => 'SOUTH DAKOTA',
    'TN' => 'TENNESSEE',
    'TX' => 'TEXAS',
    'UT' => 'UTAH',
    'VT' => 'VERMONT',
    'VI' => 'VIRGIN ISLANDS',
    'VA' => 'VIRGINIA',
    'WA' => 'WASHINGTON',
    'WV' => 'WEST VIRGINIA',
    'WI' => 'WISCONSIN',
    'WY' => 'WYOMING'
);

include_once('donations-statistics.php');
include_once('events-booking.php');
include_once('projects-working-hours.php');
include_once('hf-site-options.php');

function add_menuclass($ulclass)
{
    return preg_replace('/<a /', '<a class="nav-link"', $ulclass);
}

add_filter('wp_nav_menu', 'add_menuclass');


// TEMP FUNCTIONALITY

/*----------  ADDING VOLUNTEER ROLE  ----------*/
add_role('volunteer', 'Volunteer', array('read' => true, 'edit_posts' => false, 'delete_posts' => false));
/*----------  ADDING GUEST ROLE  ----------*/
add_role('guest', 'Guest', array('read' => true, 'edit_posts' => false, 'delete_posts' => false));

/*----------  WORKING FIELDS FOR USERS  ----------*/
function add_contact_methods($profile_fields, $user)
{
    // Add Extra Fields
    $profile_fields['profile_image_url'] = 'Profile Image URL <br>';
    $profile_fields['phone_number'] = 'Phone Number <br>';
    $profile_fields['hf_user_company'] = 'Company <br>';
    $profile_fields['hf_user_role'] = 'Role <br>';
    $profile_fields['get_user_email'] = 'Get User Email <br>';
    $profile_fields['user_location'] = 'User Location <br>';
    $profile_fields['skills_list'] = 'Skills List <br>';
    $profile_fields['facebook_url'] = 'Facebook URL<br>';
    $profile_fields['twitter_url'] = 'Twitter URL<br>';
    $profile_fields['linkedin_url'] = 'LinkedIn URL<br>';
    $profile_fields['user_register_type'] = 'User Register Type<br>';

    return $profile_fields;
}

add_filter('user_contactmethods', 'add_contact_methods', 10, 2);

$profile_fields = array(
    'volunteer_middle_name' => 'Volunteer Middle Name',
    'volunteer_organization' => 'Volunteer Organization',
    'volunteer_address' => 'Volunteer Address',
    'volunteer_city' => 'Volunteer City',
    'volunteer_liststate' => 'Volunteer State',
    'volunteer_zip' => 'Volunteer Zip',
    'volunteer_country' => 'Volunteer Country',
    'volunteer_phone' => 'Volunteer Phone',
    'volunteer_gender' => 'Volunteer Gender',
    'volunteer_willing_hours' => 'Volunteer Willing Work Hours',
    'volunteer_schedule' => 'Volunteer Schedule',
    'volunteer_profession' => 'Volunteer Profession',
    'volunteer_interested_in_work' => 'Volunteer Interested In',
    'volunteer_other' => 'Volunteer Interested In Other',
    'volunteer_comments' => 'Volunteer Comments',
    'volunteer_availability' => 'Volunteer Availability',
    'volunteer_availability_time' => 'Volunteer Availability Time',
    'volunteer_detail' => 'Volunteer Detail'
);

//displaying the volunteer fields
add_action('show_user_profile', 'my_show_extra_profile_fields');
add_action('edit_user_profile', 'my_show_extra_profile_fields');

function my_show_extra_profile_fields($user)
{
    global $profile_fields, $wpdb;
    ?>
    <h3>Extra Volunteer Information</h3>
    <table class="form-table">
        <tbody>
        <?php
        foreach ($profile_fields as $field_key => $field_value) { ?>

            <tr>
                <th><label for="<?php echo $field_key; ?>"><?php echo $field_value; ?></label></th>
                <?php
                if ($field_key == 'volunteer_address') { ?>
                    <td><textarea name="<?php echo $field_key; ?>" id="<?php echo $field_key; ?>" cols="30"
                                  rows="10"><?php echo get_user_meta($user->ID, $field_key, true); ?></textarea></td>
                    <?php
                } else if ($field_key == 'volunteer_interested_in_work') {
                    $qry = "SELECT {$wpdb->prefix}nf3_field_meta.value FROM {$wpdb->prefix}nf3_field_meta INNER JOIN {$wpdb->prefix}nf3_fields ON {$wpdb->prefix}nf3_fields.id = {$wpdb->prefix}nf3_field_meta.parent_id WHERE {$wpdb->prefix}nf3_fields.key = '{$field_key}' AND {$wpdb->prefix}nf3_field_meta.key='options'";

                    $field_options = $wpdb->get_var($qry);

                    $options = unserialize($field_options);

                    $selected_options = get_user_meta($user->ID, $field_key, true);
                    ?>
                    <td>
                        <table>
                            <tbody>
                            <?php
                            foreach ($options as $option_key => $option_value) {
                                $checked = false;
                                if (!empty($selected_options) && is_array($selected_options) && in_array($option_value['value'], $selected_options)) {
                                    $checked = true;
                                }
                                ?>
                                <tr>
                                    <td style="padding: 5px;">
                                        <label>
                                            <input name="<?php echo $field_key ?>[]" type="checkbox"
                                                   value="<?php echo $option_value['value'] ?>" <?php echo ($checked) ? 'checked=checked' : ''; ?>><?php echo $option_value['value'] ?>
                                        </label>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                    </td>
                    <?php
                } else { ?>
                    <td><input id="<?php echo $field_key; ?>" class="regular-text" type="text"
                               name="<?php echo $field_key; ?>"
                               value="<?php echo get_user_meta($user->ID, $field_key, true); ?>"/></td>
                    <?php
                }
                ?>
            </tr>

        <?php } ?>
        </tbody>
    </table>
    <?php
}

//saving the field
add_action('personal_options_update', 'my_save_extra_profile_fields');
add_action('edit_user_profile_update', 'my_save_extra_profile_fields');

function my_save_extra_profile_fields($user_id)
{
    global $profile_fields, $wpdb;

    if (!current_user_can('edit_user', $user_id))
        return false;

    $profile_fields['volunteer_email'] = 'email';

    $sub_id = get_user_meta($user_id, 'nf_sub_id', true);

    foreach ($profile_fields as $key => $value) {
        $field_id = $wpdb->get_var("SELECT id FROM {$wpdb->prefix}nf3_fields where {$wpdb->prefix}nf3_fields.key='{$key}'");

        if (!empty($field_id)) {
            if ($key == 'volunteer_email') {
                update_post_meta($sub_id, '_field_' . $field_id, $_POST['email']);
                update_user_meta($user_id, $key, $_POST[$key]);
            } else if ($key == 'volunteer_interested_in_work' && !isset($_POST[$key])) {
                $_POST[$key] = '';
                update_post_meta($sub_id, '_field_' . $field_id, $_POST[$key]);
                update_user_meta($user_id, $key, $_POST[$key]);
            } else {
                update_post_meta($sub_id, '_field_' . $field_id, $_POST[$key]);
                update_user_meta($user_id, $key, $_POST[$key]);
            }
        }
    }
}


function hfusa_add_user_data()
{
    $user_fields = array('profile_image_url',
        'phone_number',
        'hf_user_company',
        'hf_user_role',
        'get_user_email',
        'user_location',
        'skills_list',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'user_register_type',
        'volunteer_availability',
        'volunteer_availability_time',
        'volunteer_detail'
    );
    foreach ($user_fields as $user_field) {
        if ($user_field == 'hf_user_role') {
            register_rest_field('user',
                $user_field,
                array(
                    'get_callback' => 'rest_get_user_roles',
                    'update_callback' => 'rest_update_user_roles',
                    'schema' => null,
                )
            );
        } else {
            register_rest_field('user',
                $user_field,
                array(
                    'get_callback' => 'rest_get_user_field',
                    'update_callback' => 'rest_update_user_field',
                    'schema' => null,
                )
            );
        }
    }

    $volunteer_fields = array('volunteer_middle_name',
        'volunteer_organization',
        'volunteer_address',
        'volunteer_city',
        'volunteer_liststate',
        'volunteer_zip',
        'volunteer_country',
        'volunteer_phone',
        'volunteer_gender',
        'volunteer_reference',
        'volunteer_willing_hours',
        'volunteer_schedule',
        'volunteer_profession',
        'volunteer_interested_in_work',
        'volunteer_other',
        'volunteer_comments'
    );
    foreach ($volunteer_fields as $volunteer_field) {
        register_rest_field('user',
            $volunteer_field,
            array(
                'get_callback' => 'rest_get_volunteer_field',
                'update_callback' => 'rest_update_volunteer_field',
                'schema' => null,
            )
        );
    }
}

add_action('rest_api_init', 'hfusa_add_user_data');

function rest_get_user_field($user, $field_name, $request)
{
    return get_user_meta($user['id'], $field_name, true);
}

function rest_update_user_field($value, $object, $field_name)
{
    update_user_meta($object->data->ID, $field_name, $value);
    return true;
}

// Get user roles
function rest_get_user_roles($user, $field_name, $request)
{
    $user_data = get_userdata($user['id']);
    return implode(', ', $user_data->roles);
}

// Update user roles
function rest_update_user_roles($value, $object, $field_name)
{
    $user = new WP_User($object->data->ID);
    $user->set_role($value);
    update_user_meta($object->data->ID, 'roles', $value);
    return true;
}

// Get volunteer data
function rest_get_volunteer_field($user, $field_name, $request)
{
    $volunteer_data = get_user_meta($user['id'], $field_name, true);
    if ($field_name == 'volunteer_interested_in_work' && empty($volunteer_data)) {
        return [];
    } else {
        return $volunteer_data;
    }
}

// Update volunteer data
function rest_update_volunteer_field($value, $object, $field_name)
{
    $user = new WP_User($object->data->ID);
    update_user_meta($object->data->ID, $field_name, $value);
    return true;
}

add_action('init', 'start_session', 1);

function start_session()
{
    if (!session_id()) {
        session_start();
    }
}

function add_donation()
{
    $program_id = $_POST['program_id'];
    $program_name = $_POST['program_name'];
    $donor_id = $_POST['donor_id'];
    $donor_name = $_POST['donor_name'];
    $donor_email = $_POST['donor_email'];
    $donor_phone = $_POST['donor_phone'];
    $donation_amount = $_POST['donation_amount'];
    $donation_type = $_POST['donation_type'];
    $pledge_promise_date = $_POST['pledge_promise_date'];
    $campaign_id = $_POST['campaign_id'];

    if ($donation_type == 'donation') {
        $donation_type = 'Donation';
    } else {
        $donation_type = 'Pledge';
    }

    if ($program_name == 'General') {
        $donation_for = 'General';
    } else {
        $donation_for = 'Program';
    }

    $post_id = wp_insert_post(array(
        'post_title' => $donor_id . '-' . $program_id,
        'post_type' => 'hf_donations',
        'post_status' => 'publish',
        'meta_input' => array(
            'hfusa-donation_type' => $donation_type,
            'hfusa-donation_for' => $donation_for,
            'hfusa-donation_amount' => $donation_amount,
            'hfusa-program_id' => $program_id,
            'hfusa-program_name' => $program_name,
            'hfusa-donor_id' => $donor_id,
            'hfusa-donor_name' => $donor_name,
            'hfusa-donor_email' => $donor_email,
            'hfusa-donor_phone' => $donor_phone,
            'hfusa-pledge_promise_date' => $pledge_promise_date,
            'hfusa-donation_campaign_id' => $campaign_id
        ),
    ));

    echo home_url() . '/checkout-response/?success=true&type=' . $donation_type . '&amount=' . $donation_amount;
    die();
}

add_action('wp_ajax_add_donation_action', 'add_donation'); // ajax for logged in users
add_action('wp_ajax_nopriv_add_donation_action', 'add_donation'); // ajax for not logged in users

// Register New User
function register_new_member()
{
    if (isset($_POST["mode"]) && $_POST['mode'] == 'register_user') {

        $formData = $_POST['form_data'];
        $vars = [];
        for ($i = 0; $i < count($formData); $i++) {
            $vars[$formData[$i]['name']] = $formData[$i]['value'];
        }

        $user_email = $vars["user_email"];
        $user_first = $vars["user_first"];
        $user_last = $vars["user_last"];
        $company = $vars["user_company"];
        $role = $vars["user_role"];
        $user_pass = $vars["password"];
        $pass_confirm = $vars["password_again"];
        $event_type = $_POST["event_type"];
        $element_id = $_POST["element_id"];
        $captcha = $vars["g-recaptcha-response"];

        validate_email($user_email, 'user_email', 'email-error');

        validate_empty_field($user_first, 'user_first', 'fn-error', 'First Name is required!');

        validate_empty_field($user_last, 'user_last', 'ln-error', 'Last Name is required!');

        validate_empty_field($company, 'user_company', 'company-error', 'Company is required!');

        validate_empty_field($role, 'user_role', 'role-error', 'Role is required!');

        validate_password($user_pass, 'password', $pass_confirm, 'password_again', 'pass-error', 'rp-error');


        if ($event_type == 'click') {

            // calling google recaptcha api.
            $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6LejGTIUAAAAAC_rmp-aNxPQvqaLo8YlLArtmWXZ&response=" . urlencode($captcha) . "&remoteip=" . urlencode($_SERVER['REMOTE_ADDR']));

            $response = json_decode($response);

            if ($response->success) {

                // only create the user in if there are no errors
                $new_user_id = wp_insert_user(array(
                        'user_login' => $user_email,
                        'user_pass' => $user_pass,
                        'user_email' => $user_email,
                        'first_name' => $user_first,
                        'last_name' => $user_last,
                        'user_registered' => date('Y-m-d H:i:s'),
                        'role' => 'subscriber'
                    )
                );
                if ($new_user_id) {
                    update_user_meta($new_user_id, 'hf_user_role', $role);
                    update_user_meta($new_user_id, 'hf_user_company', $company);
                    // send an email to the admin and user (both) alerting them of the registration
                    wp_new_user_notification($new_user_id, null, 'both');

                    // log the new user in
//                    wp_setcookie($user_email, $user_pass, true);
//                    wp_set_current_user($new_user_id, $user_email);
//                    do_action('wp_login', $user_email);

                    $obj = new stdClass();
                    $obj->success = true;

                    // send the newly created user to the home page after logging them in
                    $obj->location = home_url('/member-login?registered=true');

                    $jsonObj = json_encode($obj);
                    echo $jsonObj;
                    die();
                }
            } else {
                $obj = new stdClass();
                $obj->success = false;
                $obj->errorCode = 'recaptcha-error';
                $obj->error = 'Captcha is required!';
            }

        }

        // $obj = new stdClass();
        // $obj->success = true;

        $jsonObj = json_encode($obj);
        echo $jsonObj;
        // echo $response->success;

        die();
    }
}

add_action('wp_ajax_register_action', 'register_new_member'); // ajax for logged in users
add_action('wp_ajax_nopriv_register_action', 'register_new_member'); // ajax for not logged in users

function validate_email($val, $id, $errorCode)
{

    $obj = new stdClass();
    $obj->success = false;
    $obj->fieldId = "";
    $obj->errorCode = "";
    $obj->error = "";

    validate_empty_field($val, $id, $errorCode, 'Email is required!');

    if (!is_email($val)) {
        $obj->fieldId = $id;
        $obj->errorCode = $errorCode;
        $obj->error = 'Invalid Email!';

        $jsonObj = json_encode($obj);
        echo $jsonObj;
        die();
    } elseif (email_exists($val)) {
        $obj->fieldId = $id;
        $obj->errorCode = $errorCode;
        $obj->error = 'Email already registered!';

        $jsonObj = json_encode($obj);
        echo $jsonObj;
        die();
    }

    return true;
}

function validate_password($passVal, $passId, $rpVal, $rpId, $passErrorCode, $rpErrorCode)
{
    $obj = new stdClass();
    $obj->success = false;
    $obj->fieldId = "";
    $obj->errorCode = "";
    $obj->error = "";

    validate_empty_field($passVal, $passId, $passErrorCode, 'Password is required!');

    validate_empty_field($rpVal, $rpId, $rpErrorCode, 'Repeat Password is required!');

    if ($passVal != $rpVal) {
        $obj->fieldId = $rpId;
        $obj->errorCode = $rpErrorCode;
        $obj->error = 'Passwords do not match!';

        $jsonObj = json_encode($obj);
        echo $jsonObj;
        die();
    }

    return true;
}

function validate_empty_field($val, $id, $errorCode, $msg)
{

    $obj = new stdClass();
    $obj->success = false;
    $obj->fieldId = "";
    $obj->errorCode = "";
    $obj->error = "";

    if (empty($val)) {
        $obj->fieldId = $id;
        $obj->errorCode = $errorCode;
        $obj->error = $msg;

        $jsonObj = json_encode($obj);
        echo $jsonObj;
        die();
    }

    return true;
}

/********************************************
 * SHOW ALL JOBS IN FIELD WITH KEY "JOB_TITLE"
 ********************************************/
add_filter('ninja_forms_render_options', function ($options, $settings) {
    if ($settings['key'] == 'job_title') {
        if (isset($_GET['job_title']) && !empty($_GET['job_title'])) {
            $job_title = $_GET['job_title'];
        } else {
            $job_title = "";
        }
        $args = array(
            'post_type' => 'hf_jobs',
            'orderby' => 'menu_order',
            'order' => 'ASC',
            'posts_per_page' => -1,
            'post_status' => 'publish'
        );
        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            global $post;
            while ($the_query->have_posts()) {
                $the_query->the_post();
                if ($job_title == get_the_title()) {
                    $selected = 1;
                } else {
                    $selected = 0;
                }
                $options[] = array('label' => get_the_title(), 'value' => get_the_title(), 'selected' => $selected);
            }
            wp_reset_postdata();
        }
    }
    return $options;
}, 10, 2);

function nice_number($n)
{
    // first strip any formatting;
    $n = (0 + str_replace(",", "", $n));

    // is this a number?
    if (!is_numeric($n)) return false;

    // now filter it;
    if ($n >= 1000000000000) return round(($n / 1000000000000), 2) . ' <span>T</span>';
    elseif ($n >= 1000000000) return round(($n / 1000000000), 2) . ' <span>B</span>';
    elseif ($n >= 1000000) return round(($n / 1000000), 2) . ' <span>M</span>';
    elseif ($n >= 1000) return round(($n / 1000), 2) . ' <span>K</span>';

    return number_format($n);
}

add_action('rest_api_init', function () {
    $job_fields = array('hfusa-job_type',
        'hfusa-job_shift',
        'hfusa-job_positions',
        'hfusa-job_experience',
        'hfusa-job_location',
        'hfusa-job_end_date',
        'skills_list'
    );
    foreach ($job_fields as $job_field) {
        register_rest_field('hf_jobs',
            $job_field,
            array(
                'get_callback' => 'slug_get_post_meta_cb',
                'update_callback' => 'slug_update_post_meta_cb',
                'schema' => null,
            )
        );
    }
});


function slug_get_post_meta_cb($object, $field_name, $request)
{
    return get_post_meta($object['id'], $field_name, true);
}

function slug_update_post_meta_cb($value, $object, $field_name)
{
    return update_post_meta($object['id'], $field_name, $value);
}

// Disable Admin toolbar when viewing site
add_filter('show_admin_bar', '__return_false');


add_action('transition_post_status', 'custom_push_notification', 10, 3);
function custom_push_notification($new_status, $old_status, $post)
{

    // If this isn't a 'programs' and 'projects' post, don't update it.
    if ("hf_programs" != $post->post_type && "hf_projects" != $post->post_type) return;

    if ('publish' !== $new_status)
        return;

    if ('publish' !== $old_status) {
        $cpt_type = ($post->post_type == "hf_programs") ? 'program' : 'project';

        // Message payload
        $msg_payload = array(
            'mtitle' => $post->post_title,
            'mdesc' => 'New ' . $cpt_type . ' added',
            'mtype' => $cpt_type,
            'mid' => $post->ID
        );


        global $wpdb;
        $qry = "SELECT * FROM {$wpdb->prefix}user_device_info";
        $results = $wpdb->get_results($qry, ARRAY_A);


        if ($results && is_array($results)) {
            foreach ($results as $result) {
                $regId = !empty($result['android_token']) ? $result['android_token'] : '';
                $deviceToken = !empty($result['ios_token']) ? $result['ios_token'] : '';

                if (!empty($regId)) {
                    PushNotifications::android($msg_payload, $regId);
                }
                if (!empty($deviceToken)) {
                    PushNotifications::iOS($msg_payload, $deviceToken);
                }
            }
        }
    }
}

//Schedule an action if it's not already scheduled
if (!wp_next_scheduled('wp_custom_cron_push_notifications')) {
    wp_schedule_event(time(), 'daily', 'wp_custom_cron_push_notifications');
}

///Cron hook to fetch Classy transactions
add_action('wp_custom_fetch_classy_transactions', 'fetch_classy_transactions_cron_function');

//create your function, that runs on cron
function fetch_classy_transactions_cron_function()
{
    include_once('framework/classy-php-sdk/vendor/autoload.php');

    $start_time = 'Start Time: '.date('d/m/Y h:i:s a', time());
    $campaignArr = array();
    $no_of_donations_inserted = 0;
    $no_of_pledges_inserted = 0;
    $no_of_rows_updated = 0;
    error_log($start_time);

    global $wpdb;

    $table = $wpdb->prefix.'hf_classy_donations';

    $client = new \Classy\Client([
        'client_id' => 'ngVpuzzCKcldwe2x',
        'client_secret' => 'QwtBc22E4F068HyU',
        'version' => '2.0' // version of the API to be used
    ]);

    $session = $client->newAppSession();

    $args = array(
        'post_type' => 'hf_campaigns',
        'posts_per_page' => -1
    );
    $loop = new WP_Query($args);
    if($loop->have_posts()) {
        while($loop->have_posts()) : $loop->the_post();
            $classyCampaignID = get_post_meta( get_the_ID(), 'hfusa-classy_campaign_id', true );
            error_log($classyCampaignID);
            if(!empty($classyCampaignID)) {
                // Get transactions information regarding the campaign #247445
                try {
                    $campaign_transactions = $client->get('/campaigns/'.$classyCampaignID.'/transactions?with=supporter', $session);
                } catch (\Classy\Exceptions\APIResponseException $e) {
                    // Get the HTTP response code
                    $code = $e->getCode();
                    error_log($code);
                    // Get the response content
                    $content = $e->getResponseData();
                    error_log($content);
                    // Get the response headers
                    $headers = $e->getResponseHeaders();
                    error_log($headers);
                }

                $current_page = $campaign_transactions->current_page;

                $prev_page = 0;

                if(get_option('classy_current_page_campaign_'.$classyCampaignID) !== false && get_option('classy_current_page_campaign_'.$classyCampaignID) != 0) {
                    $next_page = $prev_page = get_option('classy_current_page_campaign_'.$classyCampaignID);
                } else {
                    $last_page = $next_page = $campaign_transactions->last_page;
                }

                $maxTransactionID = $wpdb->get_var("SELECT MAX(transaction_id) FROM $table WHERE classy_id=$classyCampaignID");

                while ($current_page > 0) {
                    // Get transactions information regarding the campaign #247445
                    try {
                        $campaign_transactions = $client->get('/campaigns/'.$classyCampaignID.'/transactions?with=supporter&page=' . $next_page, $session);
                    } catch (\Classy\Exceptions\APIResponseException $e) {
                        // Get the HTTP response code
                        $code = $e->getCode();
                        error_log($code);
                        // Get the response content
                        $content = $e->getResponseData();
                        error_log($content);
                        // Get the response headers
                        $headers = $e->getResponseHeaders();
                        error_log($headers);
                    }
                    $current_page = $campaign_transactions->current_page;
                    update_option('classy_current_page_campaign_'.$classyCampaignID, $current_page);

                    $endLoop = false;

                    foreach (array_reverse($campaign_transactions->data) as $transaction) {

                        $trans_id = $transaction->id;

                        if($maxTransactionID === null || ($maxTransactionID < $trans_id || $prev_page != 0)) {

                            if($transaction->payment_method == 'Offline') {
                                $result = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}hf_classy_donations WHERE transaction_id=$trans_id", ARRAY_A);
                                if($result === null) {
                                    // Get transactions information regarding offline transaction
                                    try {
                                        $offline_transaction = $client->get('transactions/'.$trans_id.'?with=offline_payment_info,supporter', $session);
                                    } catch (\Classy\Exceptions\APIResponseException $e) {
                                        // Get the HTTP response code
                                        $code = $e->getCode();
                                        $code = $e->getCode();
                                        error_log($code);
                                        // Get the response content
                                        $content = $e->getResponseData();
                                        error_log($content);
                                        // Get the response headers
                                        $headers = $e->getResponseHeaders();
                                        error_log($headers);
                                    }
                                    if(!empty($offline_transaction->offline_payment_info)) {
                                        if($offline_transaction->offline_payment_info->payment_type == 'pledge') {
                                            
                                            $wpdb->insert(
                                                $table, 
                                                array( 
                                                    'classy_id' => $classyCampaignID,
                                                    'transaction_id' => $trans_id,
                                                    'donation_type' => 'Pledge',
                                                    'donation_amount' => $transaction->donation_gross_amount,
                                                    'donor_name' => $transaction->member_name,
                                                    'donor_email' => $transaction->member_email_address,
                                                    'donor_phone' => $transaction->member_phone,
                                                    'donor_state' => $transaction->billing_state,
                                                    'member_id' => $transaction->member_id,
                                                    'fundraising_team_id' => $transaction->fundraising_team_id,
                                                    'fundraising_page_id' => $transaction->fundraising_page_id,
                                                    'recurring_donation_plan_id' => $transaction->recurring_donation_plan_id,
                                                    'supporter_id' => $transaction->supporter_id,
                                                    'supporter_first_name' => $transaction->supporter->first_name,
                                                    'supporter_last_name' => $transaction->supporter->last_name,
                                                    'supporter_email' => $transaction->supporter->email_address,
                                                    'supporter_state' => $transaction->supporter->state,
                                                    'supporter_phone' => $transaction->supporter->phone,
                                                    'status' => $transaction->status,
                                                    'source' => 'CLASSY',
                                                    'created_at' => $transaction->updated_at,
                                                )
                                            );
                                            $no_of_pledges_inserted += 1;
                                        }
                                    }
                                }
                            } else {
                                $result = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}hf_classy_donations WHERE classy_id=$classyCampaignID AND transaction_id=$trans_id", ARRAY_A);
                                if($result === null) {
                                    $wpdb->insert(
                                        $table, 
                                        array( 
                                            'classy_id' => $classyCampaignID,
                                            'transaction_id' => $trans_id,
                                            'donation_type' => 'Donation',
                                            'donation_amount' => $transaction->donation_gross_amount,
                                            'donor_name' => $transaction->member_name,
                                            'donor_email' => $transaction->member_email_address,
                                            'donor_phone' => $transaction->member_phone,
                                            'donor_state' => $transaction->billing_state,
                                            'is_anonymous' => $transaction->is_anonymous,
                                            'member_id' => $transaction->member_id,
                                            'fundraising_team_id' => $transaction->fundraising_team_id,
                                            'fundraising_page_id' => $transaction->fundraising_page_id,
                                            'recurring_donation_plan_id' => $transaction->recurring_donation_plan_id,
                                            'supporter_id' => $transaction->supporter_id,
                                            'supporter_first_name' => $transaction->supporter->first_name,
                                            'supporter_last_name' => $transaction->supporter->last_name,
                                            'supporter_email' => $transaction->supporter->email_address,
                                            'supporter_state' => $transaction->supporter->state,
                                            'supporter_phone' => $transaction->supporter->phone,
                                            'status' => $transaction->status,
                                            'source' => 'CLASSY',
                                            'created_at' => $transaction->updated_at,
                                        )
                                    );
                                    $no_of_donations_inserted += 1;
                                } else {
                                    if($result['status'] != $transaction->status) {
                                        $wpdb->update(
                                            $table, 
                                            array( 
                                                'donation_amount' => $transaction->donation_gross_amount,
                                                'donor_name' => $transaction->member_name,
                                                'donor_email' => $transaction->member_email_address,
                                                'donor_phone' => $transaction->member_phone,
                                                'donor_state' => $transaction->billing_state,
                                                'is_anonymous' => $transaction->is_anonymous,
                                                'member_id' => $transaction->member_id,
                                                'fundraising_team_id' => $transaction->fundraising_team_id,
                                                'fundraising_page_id' => $transaction->fundraising_page_id,
                                                'recurring_donation_plan_id' => $transaction->recurring_donation_plan_id,
                                                'supporter_id' => $transaction->supporter_id,
                                                'supporter_first_name' => $transaction->supporter->first_name,
                                                'supporter_last_name' => $transaction->supporter->last_name,
                                                'supporter_email' => $transaction->supporter->email_address,
                                                'supporter_state' => $transaction->supporter->state,
                                                'supporter_phone' => $transaction->supporter->phone,
                                                'status' => $transaction->status,
                                                'created_at' => $transaction->updated_at,
                                            ),
                                            array( 'transaction_id' => $trans_id )
                                        );
                                        $no_of_rows_updated += 1;
                                    }
                                }
                            }
                        } else {
                            $endLoop = true;
                            update_option('classy_current_page_campaign_'.$classyCampaignID, 0);
                            break;
                        }                        
                    }
                    if($endLoop) {
                        break;
                    }

                    $next_page = $current_page = $current_page - 1;
                    update_option('classy_current_page_campaign_'.$classyCampaignID, $current_page);
                }
            }
            $campaignArr[] = array(
                'campaign_id' => $classyCampaignID,
                'no_of_donations_inserted' => $no_of_donations_inserted,
                'no_of_pledges_inserted' => $no_of_pledges_inserted,
                'no_of_rows_updated' => $no_of_rows_updated
            );
        endwhile;
    }
}

///Hook into that action that'll fire daily
add_action('wp_custom_cron_push_notifications', 'push_notifications_cron_function');

//create your function, that runs on cron
/*function push_notifications_cron_function()
{
    // update_option( 'cron_job', 'ran again', '', 'yes' );

    global $wpdb;

    $donations_loop = new WP_Query(array('post_type' => 'hf_donations', 'posts_per_page' => -1));

    if ($donations_loop->have_posts()) :

        while ($donations_loop->have_posts()) : $donations_loop->the_post();

            $donation_type = rwmb_meta('hfusa-donation_type');
            $donation_for = rwmb_meta('hfusa-donation_for');
            $donation_amount = rwmb_meta('hfusa-donation_amount');
            $donor_id = rwmb_meta('hfusa-donor_id');
            $pledge_promise_date = rwmb_meta('hfusa-pledge_promise_date');
            $program_id = rwmb_meta('hfusa-program_id');
            $program_name = get_the_title($program_id);

            if ($donation_type == 'Pledge') {

                if ($pledge_promise_date != "") {
                    $promise_date = $pledge_promise_date . "T00:00";

                    $today = new DateTime(); // This object represents current date/time
                    $today->setTime(0, 0, 0); // reset time part, to prevent partial comparison

                    $match_date = DateTime::createFromFormat("m/d/Y\\TH:i", $promise_date);
                    $match_date->setTime(0, 0, 0); // reset time part, to prevent partial comparison

                    $diff = $today->diff($match_date);
                    $diffDays = (integer)$diff->format("%R%a"); // Extract days count in interval

                    switch ($diffDays) {
                        case 0:

                            $qry = "SELECT * FROM {$wpdb->prefix}user_device_info WHERE `user_id`={$donor_id}";
                            $result = $wpdb->get_row($qry, ARRAY_A);

                            if ($result !== null) {

                                // Message payload
                                $msg_payload = array(
                                    'mtitle' => 'Pledge Reminder for ' . $program_name,
                                    'mdesc' => 'Your pledge of $' . $donation_amount . ' for program "' . $program_name . '" is scheduled today',
                                    'mtype' => 'pledge',
                                    'mid' => get_the_ID()
                                );


                                // For Android
                                $regId = $result['android_token'];
                                // For iOS
                                // $deviceToken = '123f865812ee6d6a8a57e1a5165a82f7e5136ebb5ca33a4e59de276bc8cd9345';

                                $deviceToken = $result['ios_token'];
                                // For WP8
                                // $uri = 'http://s.notify.live.net/u/1/sin/HmQAAAD1XJMXfQ8SR0b580NcxIoD6G7hIYP9oHvjjpMC2etA7U_xy_xtSAh8tWx7Dul2AZlHqoYzsSQ8jQRQ-pQLAtKW/d2luZG93c3Bob25lZGVmYXVsdA/EKTs2gmt5BG_GB8lKdN_Rg/WuhpYBv02fAmB7tjUfF7DG9aUL4';

                                PushNotifications::android($msg_payload, $regId);

                                // PushNotifications::WP($msg_payload, $uri);

                                PushNotifications::iOS($msg_payload, $deviceToken);

                            }
                            break;
                        case -1:
                            echo "//Yesterday";
                            break;
                        case +1:

                            $qry = "SELECT * FROM {$wpdb->prefix}user_device_info WHERE `user_id`={$donor_id}";

                            $result = $wpdb->get_row($qry, ARRAY_A);

                            if ($result !== null) {

                                // Message payload
                                $msg_payload = array(
                                    'mtitle' => 'Pledge Reminder for ' . $program_name,
                                    'mdesc' => 'Your pledge of $' . $donation_amount . ' for program "' . $program_name . '" is scheduled tomorrow',
                                    'mtype' => 'pledge',
                                    'mid' => get_the_ID()
                                );

                                // For Android
                                $regId = $result['android_token'];
                                // For iOS
                                // $deviceToken = '123f865812ee6d6a8a57e1a5165a82f7e5136ebb5ca33a4e59de276bc8cd9345';

                                // $deviceToken = 'cc038cc41a989627f32ff8eda04336e9613148571ca8bbd41b8e806c4dadaa18';

                                $deviceToken = $result['ios_token'];
                                // For WP8
                                // $uri = 'http://s.notify.live.net/u/1/sin/HmQAAAD1XJMXfQ8SR0b580NcxIoD6G7hIYP9oHvjjpMC2etA7U_xy_xtSAh8tWx7Dul2AZlHqoYzsSQ8jQRQ-pQLAtKW/d2luZG93c3Bob25lZGVmYXVsdA/EKTs2gmt5BG_GB8lKdN_Rg/WuhpYBv02fAmB7tjUfF7DG9aUL4';

                                PushNotifications::android($msg_payload, $regId);

                                // PushNotifications::WP($msg_payload, $uri);

                                PushNotifications::iOS($msg_payload, $deviceToken);
                            }
                            break;
                        default:
                            echo "//Sometime";
                    }
                }
            }

        endwhile;
        wp_reset_postdata();
    endif;
}*/

add_action('wp_get_us_states_covid_data', 'get_us_states_covid_data');

function get_us_states_covid_data() {
    global $wpdb;

    global $hf_us_state_abbrevs_names;

    $start_time = date('Y-m-d H:i:s');
    $total_processed = 0;
    $total_updated = 0;

    error_log("CRON JOB CALLED");
    $arg = array ( 'method' => 'GET');
    foreach ($hf_us_state_abbrevs_names as $code => $fullName) {
        $result = wp_remote_request ( 'https://covidtracking.com/api/v1/states/'.strtolower($code).'/current.json' , $arg );
        if($result['response']['code'] == 200) {
            $body = wp_remote_retrieve_body($result);
            $body = json_decode($body, true);
            // ob_start();
            // echo '<pre>';
            // print_r($body);
            // echo '</pre>';
            // $objectdata = ob_get_contents();
            // ob_end_clean();
            // error_log($objectdata);
            // error_log("Confirmed: ".$body['positive']." Deaths: ".$body['death']);
            $stateFullName = ucwords(strtolower($fullName));
            $result = $wpdb->get_var("SELECT lastUpdateEt FROM {$wpdb->prefix}hf_covid_19_records WHERE `state`='{$stateFullName}' AND  (`lastUpdateEt`<>'".$body['lastUpdateEt']."' OR `lastUpdateEt` IS NULL)");
            // error_log("SELECT lastUpdateEt FROM {$wpdb->prefix}hf_covid_19_records WHERE `state`='{$stateFullName}' AND (`lastUpdateEt`<>'".$body['lastUpdateEt']."' OR `lastUpdateEt` IS NULL)");
            // error_log("DB: ".$result." API: ".$body['lastUpdateEt']);


            if(!empty($result) || is_null($result)) {
                $wpdb->update( 
                    $wpdb->prefix.'hf_covid_19_records', 
                    array( 
                        'totalTestResults' => $body['totalTestResults'],
                        'positive' => $body['positive'],
                        'negative' => $body['negative'],
                        'death' => $body['death'],
                        'hospitalized' => $body['hospitalized'],
                        'modified_at' => date('Y-m-d H:i:s'),
                        'lastUpdateEt' => $body['lastUpdateEt']
                    ), 
                    array( 'state' => $fullName )
                );
                $wpdb->insert(
                    $wpdb->prefix.'hf_covid_19_cumulative_records', 
                    array(
                        'state' => $stateFullName,
                        'totalTestResults' => $body['totalTestResults'],
                        'positive' => $body['positive'],
                        'negative' => $body['negative'],
                        'death' => $body['death'],
                        'hospitalized' => $body['hospitalized'],
                        'lastUpdateEt' => $body['lastUpdateEt']
                    )
                );
                $total_updated++;
            }
        }   
    }

    $end_time = date('Y-m-d H:i:s');

    $wpdb->insert( 
        $wpdb->prefix.'hf_covid_19_cron_log', 
        array( 
            'start_time' => $start_time,
            'end_time' => $end_time,
            'total_processed' => $total_processed,
            'total_updated' => $total_updated,
        ),
    );
}


function hf_download_file()
{
    if (isset($_GET["attachment_post_id"]) && isset($_GET['download_file'])) {
        hf_send_file_save();
    }
}

add_action('init', 'hf_download_file');


// Send the file to download
function hf_send_file_save()
{
    //get filedata
    $postId = $_GET['attachment_post_id'];
    $theFile = get_post_meta($postId, 'hfusa-download_file', true);


    if (!$theFile) {
        return;
    }
    //clean the fileurl
    $file_url = stripslashes(trim($theFile));
    //get filename
    $file_name = basename($theFile);
    //get fileextension

    $file_extension = pathinfo($file_name);
    //security check
    $fileName = strtolower($file_url);

    $whitelist = apply_filters("ibenic_allowed_file_types", array('png', 'gif', 'tiff', 'jpeg', 'jpg', 'bmp', 'svg', 'pdf', 'docx', 'doc'));


    $fileType = explode('.', $fileName);

    $fileType = end($fileType);


    if (!in_array($fileType, $whitelist)) {
        exit('Invalid file!');
    }
    if (strpos($file_url, '.php') == true) {
        die("Invalid file!");
    }

    $file_new_name = $file_name;
    $content_type = "";
    //check filetype
    switch ($file_extension['extension']) {
        case "png":
            $content_type = "image/png";
            break;
        case "gif":
            $content_type = "image/gif";
            break;
        case "tiff":
            $content_type = "image/tiff";
            break;
        case "jpeg":
        case "jpg":
            $content_type = "image/jpg";
            break;
        default:
            $content_type = "application/force-download";
    }

    $content_type = apply_filters("ibenic_content_type", $content_type, $file_extension['extension']);

    header("Expires: 0");
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header('Cache-Control: pre-check=0, post-check=0, max-age=0', false);
    header("Pragma: no-cache");
    header("Content-type: {$content_type}");
    header("Content-Disposition:attachment; filename={$file_new_name}");
    header("Content-Type: application/force-download");

    readfile("{$file_url}");
    exit();
}


function hf_get_attachment_id_from_url($attachment_url = '')
{

    global $wpdb;
    $attachment_id = false;

    // If there is no url, return.
    if ('' == $attachment_url)
        return;

    // Get the upload directory paths
    $upload_dir_paths = wp_upload_dir();

    // Make sure the upload path base directory exists in the attachment URL, to verify that we're working with a media library image
    if (false !== strpos($attachment_url, $upload_dir_paths['baseurl'])) {

        // If this is the URL of an auto-generated thumbnail, get the URL of the original image
        $attachment_url = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $attachment_url);

        // Remove the upload path base directory from the attachment URL
        $attachment_url = str_replace($upload_dir_paths['baseurl'] . '/', '', $attachment_url);

        // Finally, run a custom database query to get the attachment ID from the modified attachment URL
        $attachment_id = $wpdb->get_var($wpdb->prepare("SELECT wposts.ID FROM $wpdb->posts wposts, $wpdb->postmeta wpostmeta WHERE wposts.ID = wpostmeta.post_id AND wpostmeta.meta_key = '_wp_attached_file' AND wpostmeta.meta_value = '%s' AND wposts.post_type = 'attachment'", $attachment_url));

    }

    return $attachment_id;
}

function hf_get_the_excerpt($post_id)
{
    global $post;
    $save_post = $post;
    $post = get_post($post_id);
    setup_postdata($post);
    $output = get_the_excerpt($post);
    wp_reset_postdata();
    $post = $save_post;
    return $output;
}

// Order admin panel menu items
function custom_menu_order($menu_ord)
{
    if (!$menu_ord) return true;

    return array(
        'index.php', // Dashboard
        'separator1', // First separator
        'edit.php', // Posts
        'edit-comments.php', // Comments
        'edit.php?post_type=page', // Pages
        'edit.php?post_type=hf_hero_slides', // Hero Slider
        'edit.php?post_type=hf_events', // Events
        'edit.php?post_type=hf_campaigns', // Videos
        'edit.php?post_type=hf_speakers', // Speakers
        'edit.php?post_type=hf_coupons', // Coupons
        'edit.php?post_type=hf_programs', // Programs
        'edit.php?post_type=product', // Programs
        'edit.php?post_type=hf_projects', // Projects
        'edit.php?post_type=hf_countries', // Countries
        'edit.php?post_type=hf_donations', // Donations
        'edit.php?post_type=hf_members', // Members
        'edit.php?post_type=hf_sponsors', // Sponsors
        'edit.php?post_type=hf_partners', // Partners
        'edit.php?post_type=hf_glbl_sites', // Global Sites
        'edit.php?post_type=hf_albums', // Albums
        'edit.php?post_type=hf_photos', // Photos
        'edit.php?post_type=hf_videos', // Videos
        'upload.php', // Media
        'edit.php?post_type=hf_jobs', // Jobs
        'edit.php?post_type=hf_skills', // Skills
        'edit.php?post_type=hf_questions', // FAQs
        'edit.php?post_type=hf_downloads', // Downloads
        'edit.php?post_type=hf_testimonials', // Testimonials
        'edit.php?post_type=hf_quotes', // Quotes
        'edit.php?post_type=hf_alerts', // Alerts
        'separator1', // First separator
        'admin.php?page=wpcf7', // Contact Form 7
        'admin.php?page=ninja-forms', // Ninja Forms
        'separator2', // Second separator
        'themes.php', // Appearance
        'plugins.php', // Plugins
        'users.php', // Users
        'tools.php', // Tools
        'options-general.php', // Settings
        'separator-last', // Last separator
    );
}

add_filter('custom_menu_order', 'custom_menu_order'); // Activate custom_menu_order
add_filter('menu_order', 'custom_menu_order');

function hfSearchfilter($query)
{

    if ($query->is_search && !is_admin()) {
        if (!empty($_GET['post_type']) && $_GET['post_type'] == 'product') {
            $query->set('post_type', array('product'));
        } else {
            $query->set('post_type', array('post'));
        }
    }

    return $query;
}

add_filter('pre_get_posts', 'hfSearchfilter');

add_image_size('hf-custom-size-1', 350, 280, true);


// add_action('phpmailer_init', 'mailer_config', 10, 1);
// function mailer_config(PHPMailer $mailer)
// {
//     $mailer->IsSMTP();
//     $mailer->Host = "localhost"; // your SMTP server
//     $mailer->Port = 25;
//     $mailer->SMTPDebug = 0; // write 0 if you don't want to see client/server communication in page
//     $mailer->CharSet = "utf-8";
// }

add_filter('wp_mail_from', 'hf_wp_mail_from');
function hf_wp_mail_from($content_type)
{
    return 'info@us.humanityfirst.org';
}

add_filter('wp_mail_from_name', 'hf_wp_mail_from_name');
function hf_wp_mail_from_name($name)
{
    return 'Humanity First';
}

/* 
 * Change Meta Box visibility according to Page Template
 */

add_action('admin_head', 'wpse_50092_script_enqueuer');

function wpse_50092_script_enqueuer()
{
    global $current_screen;
    if ('page' != $current_screen->id) return;

    echo <<<HTML
    <script type="text/javascript">
    jQuery(document).ready( function($) {

            /**
             * Adjust visibility of the meta box at startup
            */
        //     if( $('#page_template').val() == 'template-geographic-reach.php' ||
        //         $('#page_template').val() == 'template-lives-impacted.php' ||
        //         $('#page_template').val() == 'template-years-in-the-field.php' ||
        //         $('#page_template').val() == 'template-dollars-raised.php'
        //         ) {
        //         // show the meta box
        //         $('#impacts_fields').hide();
        //     $('#our_impacts_fields').show();
        // } else {
        //         // hide your meta box
        //     $('#impacts_fields').show();
        //     $('#our_impacts_fields').hide();
        // }

            // Debug only
            // - outputs the template filename
            // - checking for console existance to avoid js errors in non-compliant browsers
        if (typeof console == "object") 
            console.log ('default value = ' + $('#page_template').val());

            /**
             * Live adjustment of the meta box visibility
            */
            // $('#page_template').live('change', function(){
            //     if( $(this).val() == 'template-geographic-reach.php' ||
            //         $(this).val() == 'template-lives-impacted.php' ||
            //         $(this).val() == 'template-years-in-the-field.php' ||
            //         $(this).val() == 'template-dollars-raised.php'
            //         ) {
            //         // show the meta box
            //         $('#impacts_fields').hide();
            //     $('#our_impacts_fields').show();
            // } else {
            //         // hide your meta box
            //     $('#impacts_fields').show();
            //     $('#our_impacts_fields').hide();
            // }

                // Debug only
                // if (typeof console == "object") 
                //     console.log ('live change value = ' + $(this).val());
            // });                 
        });    
    </script>
HTML;
}

// Story Form submission callback
add_action('hf_ninja_forms_processing', 'hf_ninja_forms_processing_callback');

function hf_ninja_forms_processing_callback($form_data)
{
    $story_title = '';
    $story_content = '';
    $idStories = get_category_by_slug('stories');
    $stories = isset($idStories->term_id) ? $idStories->term_id : '';
    $thumbID = '';

    $form_fields = $form_data['fields'];
    foreach ($form_fields as $field) {
        $field_key = $field['key'];
        $field_value = $field['value'];

        if ($field_key == 'hf_story_title') {
            $story_title = $field_value;
        }

        if ($field_key == 'hf_story_content') {
            $story_content = $field_value;
        }

        if ($field_key == 'hf_story_image') {
            $thumbID = isset($field['files'][0]['data']['attachment_id']) ? $field['files'][0]['data']['attachment_id'] : '';
        }

    }

    $my_post_story = array(
        'post_title' => wp_strip_all_tags($story_title),
        'post_content' => $story_content,
        'post_status' => 'draft',
        'post_author' => 1,
        'post_category' => array($stories)
    );

    $post_id = wp_insert_post($my_post_story);
    if (!empty($thumbID)) {
        set_post_thumbnail($post_id, $thumbID);
    }
}

// Register Volunteer after Volunteer form submission
add_action('ninja_forms_after_submission', 'my_ninja_forms_after_submission');
function my_ninja_forms_after_submission($form_data)
{

    if ($form_data['form_id'] != 2) return;

    foreach ($form_data['fields'] as $field) {
        if ($field['key'] == 'volunteer_email') {
            $volunteer_email = $field['value'];
        } else if ($field['key'] == 'volunteer_firstname') {
            $volunteer_firstname = $field['value'];
        } else if ($field['key'] == 'volunteer_lastname') {
            $volunteer_lastname = $field['value'];
        } else if ($field['key'] == 'volunteer_password') {
            $volunteer_password = $field['value'];
        }
    }

    // create new user with role as volunteer
    $new_user_id = wp_insert_user(array(
            'user_login' => $volunteer_email,
            'user_pass' => $volunteer_password,
            'user_email' => $volunteer_email,
            'first_name' => $volunteer_firstname,
            'last_name' => $volunteer_lastname,
            'user_registered' => date('Y-m-d H:i:s'),
            'role' => 'volunteer'
        )
    );

    foreach ($form_data['fields'] as $field) {
        if ($field['key'] != 'volunteer_email' &&
            $field['key'] != 'volunteer_firstname' &&
            $field['key'] != 'volunteer_lastname' &&
            $field['key'] != 'volunteer_password' &&
            $field['key'] != 'volunteer_password_confirm'
        ) {

            update_user_meta($new_user_id, $field['key'], $field['value']);
        }
    }

    update_user_meta($new_user_id, 'nf_sub_id', $form_data['actions']['save']['sub_id']);
}

add_filter('rest_user_query', 'prefix_remove_has_published_posts_from_wp_api_user_query', 10, 2);
/**
 * Removes `has_published_posts` from the query args so even users who have not
 * published content are returned by the request.
 *
 * @see https://developer.wordpress.org/reference/classes/wp_user_query/
 *
 * @param array $prepared_args Array of arguments for WP_User_Query.
 * @param WP_REST_Request $request The current request.
 *
 * @return array
 */
function prefix_remove_has_published_posts_from_wp_api_user_query($prepared_args, $request)
{
    unset($prepared_args['has_published_posts']);

    return $prepared_args;
}


function totalTelethonDonations($campaignID = '', $type = '', $formatted = true)
{

    global $wpdb;

    if($type == 'Donation') {
        $totalDonations = $wpdb->get_var("SELECT SUM(donation_amount) as total FROM {$wpdb->prefix}hf_classy_donations WHERE donation_type='$type' AND classy_id=$campaignID AND status='success'");
    } else {
        $totalDonations = $wpdb->get_var("SELECT SUM(donation_amount) as total FROM {$wpdb->prefix}hf_classy_donations WHERE donation_type='$type' AND classy_id=$campaignID");
    }

    $totalDonations = !empty($totalDonations) ? $totalDonations : 0;
    
    if ($formatted == true) {
        return nice_number($totalDonations);
    }
    return $totalDonations;
}


function hf_load_telethon_donations()
{
    $campaignID = !empty($_POST['telethon_campaign']) ? $_POST['telethon_campaign'] : '';
    $latestDonation = !empty($_POST['latest_donation']) ? $_POST['latest_donation'] : 0;
    global $hf_us_state_abbrevs_names;

    if (!empty($campaignID)) {
        $stylesheetDirectory = get_stylesheet_directory_uri();

        $post_ids = range($latestDonation + 1, $latestDonation + 20);

        $idLatestDonation = 0;
        $response = array();
        $latestDonations = '';
        $args = array(
            'posts_per_page' => -1,
            'post_type' => 'hf_donations',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => 'hfusa-donation_campaign_id',
                    'value' => $campaignID,
                    'compare' => '=',
                ),
                array(
                    'key' => 'hfusa-donation_type',
                    'value' => 'Donation',
                    'compare' => '=',
                )
            ),
        );

        if ($latestDonation > 0) {
            $args['post__in'] = $post_ids;
        }

        $the_query = new WP_Query($args);
        if ($the_query->have_posts()) {
            $i = 0;
            while ($the_query->have_posts()) {
                $the_query->the_post();
                $donationID = get_the_ID();
                if ($i == 0) {
                    $idLatestDonation = $donationID;
                }
                $donor_name = get_post_meta($donationID, 'hfusa-donor_name', true);
                $donation_amount = get_post_meta($donationID, 'hfusa-donation_amount', true);
                $donor_state = get_post_meta($donationID, 'hfusa-donor_state', true);
                $doantionDate = '';
                $doantionDate = get_the_date('M d, Y | h:i A', $donationID);

                $latestDonations .= '<div class="tms-list-item">';

                $donor_state = strtoupper($donor_state);
                $key = array_search($donor_state, $hf_us_state_abbrevs_names);
                if ($key == false) {
                    $key = $donor_state;
                }
                $flagURLPng = $stylesheetDirectory . '/assets/images/us-states/' . strtolower($key) . '.png';
                $flagURLJpg = $stylesheetDirectory . '/assets/images/us-states/' . strtolower($key) . '.jpg';

                if (@getimagesize($flagURLPng)) {
                    $flagFile = $flagURLPng;
                } else if (@getimagesize($flagURLJpg)) {
                    $flagFile = $flagURLJpg;
                } else {
                    $flagFile = $stylesheetDirectory . '/assets/images/us-states/dummy-flag.jpg';
                }
                if (!empty($flagFile)) {

                    $latestDonations .= '<div class="flag-container">
                    <img src="' . $flagFile . '">
                    </div>';
                }
                $latestDonations .= '<div class="country-details">
                <h5>' . $donor_name . '</h5>';
                if (!empty($doantionDate)) {
                    $latestDonations .= '<h6>
                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                    ' . $doantionDate . '
                    </h6>';
                }
                $latestDonations .= '</div>
                <div class="tms-amount">
                <h6>$' . $donation_amount . '</h6>
                </div>
                </div>';
                $i++;
            }
            $donationsData = hf_state_donattions($campaignID);
            $response["latest_donations"] = $latestDonations;
            $response["latest_donation_id"] = $idLatestDonation;
            $response["total_donations_amount"] = totalTelethonDonations($campaignID, 'Donation', true);
            $response["data_donation"] = $donationsData;
            wp_reset_postdata();
        } else {
            $response["latest_donation_id"] = end($post_ids);
        }

    }

    echo json_encode($response);
    exit;
}

add_action('wp_ajax_hf_load_telethon_donations', 'hf_load_telethon_donations');
add_action('wp_ajax_nopriv_hf_load_telethon_donations', 'hf_load_telethon_donations');


function hf_state_donattions($campaignID = '')
{

    global $hf_us_state_abbrevs_names;

    $donationsData = array();
    if (!empty($campaignID)) {

        global $wpdb;

        $donations = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}hf_classy_donations WHERE classy_id=$campaignID AND (status='success' OR donation_type='Pledge')", ARRAY_A);

        if ($wpdb->num_rows > 0) {
            foreach ($donations as $donation) {
                $donationID = $donation['id'];
                $donation_amount = $donation['donation_amount'];
                $donor_state = $donation['donor_state'];
                $stateKey = strtoupper($donor_state);
                $donor_state = isset($hf_us_state_abbrevs_names[$stateKey]) ? $hf_us_state_abbrevs_names[$stateKey] : $donor_state;
                $donation_type = $donation['donation_type'];
                $donor_state = strtolower($donor_state);
                $donor_state = str_replace(" ", "-", $donor_state);
                $previousAmount = isset($donationsData[$donor_state][$donation_type]) ? $donationsData[$donor_state][$donation_type] : 0;
                $donationsData[$donor_state][$donation_type] = $previousAmount + $donation_amount;
            }
        }
    }
    return json_encode($donationsData);
}

function hf_covid_19_state_records()
{

    global $hf_us_state_abbrevs_names;

    $recordsData = array();

    global $wpdb;

    $records = $wpdb->get_results("SELECT DISTINCT state, SUM(totalTestResults) as total, SUM(positive) as positive, SUM(negative) as negative, SUM(death) as deaths, hospitalized, lastUpdateEt FROM {$wpdb->prefix}hf_covid_19_records GROUP BY state", ARRAY_A);

    if ($wpdb->num_rows > 0) {
        foreach ($records as $record) {
            $state = $record['state'];
            $stateKey = strtoupper($state);
            $state = isset($hf_us_state_abbrevs_names[$stateKey]) ? $hf_us_state_abbrevs_names[$stateKey] : $state;
            $state = strtolower($state);
            $state = str_replace(" ", "-", $state);
            $recordsData[$state]['total'] = $record['total'];
            $recordsData[$state]['positive'] = $record['positive'];
            $recordsData[$state]['negative'] = $record['negative'];
            $recordsData[$state]['deaths'] = $record['deaths'];
            $recordsData[$state]['hospitalized'] = $record['hospitalized'];
            $recordsData[$state]['lastUpdateEt'] = str_replace(" ", "-", $record['lastUpdateEt']);
        }
    }

    return json_encode($recordsData);
}

function hf_impacts_widget_area()
{

    $htmlString = '';
    $page_impact_details = get_post_meta(get_the_ID(), 'hfusa-page_impact_details');
    $newData = array();
    foreach($page_impact_details[0] as $key => $val){
        if(is_array($val['icon'])){
            $icon = array($val['icon'][0][0]);
        }
        $newData[] = array('title'=> $val['label'], 'description'=> $val['figure'],'icon'=>$icon);
    }
    update_post_meta(get_the_ID(), 'page_impact_details', $newData);
    $page_impact_details = get_post_meta(get_the_ID(), 'page_impact_details');
    $statBox = false;

    if (!empty($page_impact_details) && is_array($page_impact_details)) {
        $page_impact_details = reset($page_impact_details);

        $htmlString .= '<div class="widget">
        <div class="widget-content">
        <div class="donation-target-status history-impacts oi-geographic-reach">
        <div class="container">
        <div class="row rtl-display d-flex align-items-center" style="overflow: hidden;">';

        foreach ($page_impact_details as $key => $value) {
            $title = isset($value["title"]) ? $value["title"] : '';
            $description = isset($value["description"]) ? $value["description"] : '';
            $icon = isset($value["icon"][0]) ? $value["icon"][0] : '';
            if (!empty($icon) && is_array($icon)) {
                $icon = reset($icon);
            }

            if (isset($icon[0]) && is_array($icon[0])) {
                $icon = $icon[0];
            }

            if (!empty($title)) {

                $htmlString .= '<div class="col-12 float-left stat-box">
                <div class="row rtl-display d-flex align-items-center">';
                $image_attributes = wp_get_attachment_image_src($icon);
                if ($image_attributes) {
                    $htmlString .= '<div class="col-lg-4 col-sm-2 col-md-2 st-left float-left w-auto">
                <div class="icon-container"><img src="' . $image_attributes[0] . '" /></div>
                </div>';
                    $textClasses = "col-lg-8 col-sm-10 col-md-6";
                } else {
                    $textClasses = "col-sm-12 pl-4";
                }
                $htmlString .= '<div class="' . $textClasses . ' st-right float-left w-flex">';
                if (!empty($description)) {
                    $htmlString .= '<div class="dts-figures"><h4 class=""><span>' . $description . '</span></h4>';
                } else {
                    $htmlString .= '<div class="dts-figures" >';
                }
                $htmlString .= '<h6 class="mr-3">' . $title . '</h6>
                </div>
                </div>
                </div>
                </div>';

                $statBox = true;
            }
        }
        $htmlString .= '</div>
        </div>
        </div>
        </div>
        </div>';

        if ($statBox == false) {
            return;
        }

    }
    return $htmlString;
}

function hf_validate_already_registered_user()
{
    $user_email = $_POST['user_email'];
    if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
        if (email_exists($user_email)) {
            echo true;
        } else {
            echo false;
        }
    } else {
        echo false;
    }
    exit;
}

add_action('wp_ajax_validate_already_registered_user', 'hf_validate_already_registered_user');
add_action('wp_ajax_nopriv_validate_already_registered_user', 'hf_validate_already_registered_user');

// Volunteer form update from Admin panel
add_action('save_post', 'ninja_forms_save_callback', 10, 2);

function ninja_forms_save_callback($nf_sub_id, $nf_sub)
{
    global $pagenow, $wpdb;

    if (!isset ($_POST['nf_edit_sub']) || $_POST['nf_edit_sub'] != 1)
        return $nf_sub_id;

    // verify if this is an auto save routine.
    // If it is our form has not been submitted, so we dont want to do anything
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return $nf_sub_id;

    if ($pagenow != 'post.php')
        return $nf_sub_id;

    if ($nf_sub->post_type != 'nf_sub')
        return $nf_sub_id;

    /* Get the post type object. */
    $post_type = get_post_type_object($nf_sub->post_type);

    /* Check if the current user has permission to edit the post. */
    if (!current_user_can($post_type->cap->edit_post, $nf_sub_id))
        return $nf_sub_id;

    $field_id_email = $wpdb->get_var("SELECT id FROM {$wpdb->prefix}nf3_fields where {$wpdb->prefix}nf3_fields.key='volunteer_email'");

    // ob_start();
    // echo '<pre>';
    // print_r($sub);
    // echo '</pre>';
    // $objectdata = ob_get_contents();
    // ob_end_clean();

    $field_keys = array();

    if (!empty($field_id_email) && !empty($_POST['fields'][$field_id_email])) {
        if (!empty($_SESSION['previous_user_email'])) {
            $user_email = $_SESSION['previous_user_email'];
            $new_user_email = $_POST['fields'][$field_id_email];
        } else {
            $user_email = $new_user_email = $_POST['fields'][$field_id_email];
        }

        $user = get_user_by('email', $user_email);
        $user_id = $user->ID;

        foreach ($_POST['fields'] as $field_id => $user_value) {
            $user_value = apply_filters('nf_edit_sub_user_value', $user_value, $field_id, $nf_sub_id);

            $field_key = $wpdb->get_var("SELECT `key` FROM {$wpdb->prefix}nf3_fields where {$wpdb->prefix}nf3_fields.id={$field_id}");

            if ($field_key == 'volunteer_firstname') {
                $field_key = 'first_name';
            } else if ($field_key == 'volunteer_lastname') {
                $field_key = 'last_name';
            }

            update_user_meta($user_id, $field_key, $user_value);
        }

        $args = array(
            "ID" => $user_id,
            "user_email" => esc_attr($new_user_email)
        );
        $user_id = wp_update_user($args);
    } else {
        return $nf_sub_id;
    }
}

function nf_before_volunteer_update($data, $postarr)
{
    global $wpdb;

    if ($data['post_type'] != 'nf_sub') return $data;

    $field_id_email = $wpdb->get_var("SELECT id FROM {$wpdb->prefix}nf3_fields where {$wpdb->prefix}nf3_fields.key='volunteer_email'");
    if (!empty($postarr['ID'])) {
        $user_email = get_post_meta($postarr['ID'], '_field_' . $field_id_email, true);
        $_SESSION['previous_user_email'] = $user_email;
    }
    return $data;
}

add_filter('wp_insert_post_data', 'nf_before_volunteer_update', '99', 2);

// function hf_dequeue_styles_chat_plugin()
// {

//     $page_template = basename(get_page_template());

//     if (!is_singular('hf_events') && $page_template != 'template-telethon.php') {

//         wp_dequeue_style('wplc-style');
//         wp_deregister_style('wplc-style');

//         wp_dequeue_style('wplc-theme-modern');
//         wp_deregister_style('wplc-theme-modern');

//         wp_dequeue_style('wplc-theme-position');
//         wp_deregister_style('wplc-theme-position');

//         wp_dequeue_style('wplc-gif-integration-user');
//         wp_deregister_style('wplc-gif-integration-user');

//         wp_dequeue_style('wplc-gutenberg-template-styles-user');
//         wp_deregister_style('wplc-gutenberg-template-styles-user');

//         wp_dequeue_style('wplc-admin-style-emoji');
//         wp_deregister_style('wplc-admin-style-emoji');

//     }
// }

// add_action('wp_print_styles', 'hf_dequeue_styles_chat_plugin', 999);

// function hf_dequeue_scripts_chat_plugin()
// {

//     $page_template = basename(get_page_template());

//     if (!is_singular('hf_events') && $page_template != 'template-telethon.php') {

//         wp_deregister_script('wplc-user-script');
//         wp_deregister_script('wplc-server-script');
//         wp_deregister_script('wplc-node-server-script');

//     }
// }

// add_action('wp_print_scripts', 'hf_dequeue_scripts_chat_plugin', 999);


// Inserting/Updating donations/pledges in Custom Tables
function manage_donations_custom($post_id, $post, $update)
{

    $post_type = get_post_type($post_id);

    // If this isn't a 'hf_donations' post, don't update it.
    if ("hf_donations" != $post_type) return;

    global $wpdb;

    // If this is just a revision, update the donation.
    if (wp_is_post_revision($post_id)) {
        $donation_type = get_post_meta($post_id, 'hfusa-donation_type', true);
        $donation_for = get_post_meta($post_id, 'hfusa-donation_for', true);
        $donation_amount = get_post_meta($post_id, 'hfusa-donation_amount', true);
        $program_id = get_post_meta($post_id, 'hfusa-program_id', true);
        $program_name = get_post_meta($post_id, 'hfusa-program_name', true);
        $donor_id = get_post_meta($post_id, 'hfusa-donor_id', true);
        $donor_name = get_post_meta($post_id, 'hfusa-donor_name', true);
        $donor_email = get_post_meta($post_id, 'hfusa-donor_email', true);
        $donor_phone = get_post_meta($post_id, 'hfusa-donor_phone', true);
        $donation_type = get_post_meta($post_id, 'hfusa-donation_type', true);
        $pledge_promise_date = get_post_meta($post_id, 'hfusa-pledge_promise_date', true);

        // Updating donation in custom database table
        $wpdb->update(
            $wpdb->prefix . 'hf_donations',
            array(
                'donation_type' => $donation_type,
                'donation_for' => $donation_for,
                'donation_amount' => $donation_amount,
                'program_id' => $program_id,
                'program_name' => $program_name,
                'donor_id' => $donor_id,
                'donor_name' => $donor_name,
                'donor_email' => $donor_email,
                'donor_phone' => $donor_phone,
                'pledge_promise_date' => $pledge_promise_date,
            ),
            array('wp_post_id' => $post_id)
        );
    } else {
        $donation_type = get_post_meta($post_id, 'hfusa-donation_type', true);
        $donation_for = get_post_meta($post_id, 'hfusa-donation_for', true);
        $donation_amount = get_post_meta($post_id, 'hfusa-donation_amount', true);
        $program_id = get_post_meta($post_id, 'hfusa-program_id', true);
        $program_name = get_post_meta($post_id, 'hfusa-program_name', true);
        $donor_id = get_post_meta($post_id, 'hfusa-donor_id', true);
        $donor_name = get_post_meta($post_id, 'hfusa-donor_name', true);
        $donor_email = get_post_meta($post_id, 'hfusa-donor_email', true);
        $donor_phone = get_post_meta($post_id, 'hfusa-donor_phone', true);
        $donor_state = get_post_meta($post_id, 'hfusa-donor_state', true);
        $donation_type = get_post_meta($post_id, 'hfusa-donation_type', true);
        $pledge_promise_date = get_post_meta($post_id, 'hfusa-pledge_promise_date', true);
        $event_id = (!empty(get_post_meta($post_id, 'hfusa-event_id', true))) ? get_post_meta($post_id, 'hfusa-event_id', true) : '';

        // Recording donation in custom database table
        $wpdb->insert(
            $wpdb->prefix . 'hf_donations',
            array(
                'wp_post_id' => $post_id,
                'donation_type' => $donation_type,
                'donation_for' => $donation_for,
                'donation_amount' => $donation_amount,
                'event_id' => $event_id,
                'program_id' => $program_id,
                'program_name' => $program_name,
                'donor_id' => $donor_id,
                'donor_name' => $donor_name,
                'donor_email' => $donor_email,
                'donor_phone' => $donor_phone,
                'donor_state' => $donor_state,
                'pledge_promise_date' => $pledge_promise_date,
                'created_at' => get_the_date('Y-m-d H:i:s', $post_id),
            )
        );
    }
}

add_action('save_post', 'manage_donations_custom', 10, 3);

// Updating pledges in Custom Tables
// function update_ninja_pledge_form($post_id, $post, $update)
// {
//     $post_type = get_post_type($post_id);

//     // If this isn't a 'ninja form' post, don't update it.
//     if ("nf_sub" != $post_type) return;

//     global $wpdb;

//     $result = $wpdb->get_results("SELECT {$wpdb->prefix}nf3_forms.id as form_id, {$wpdb->prefix}nf3_fields.* FROM {$wpdb->prefix}postmeta INNER JOIN {$wpdb->prefix}nf3_forms ON {$wpdb->prefix}postmeta.meta_value={$wpdb->prefix}nf3_forms.id INNER JOIN {$wpdb->prefix}nf3_fields ON {$wpdb->prefix}nf3_fields.parent_id={$wpdb->prefix}nf3_forms.id WHERE {$wpdb->prefix}postmeta.post_id=$post_id AND {$wpdb->prefix}postmeta.meta_key='_form_id' AND {$wpdb->prefix}nf3_fields.type NOT IN ('recaptcha', 'submit')", ARRAY_A);

//     $email_field_id = 0;
//     $event_id_field_id = 0;
//     $fields = array();
//     for($i=0; $i<count($result); $i++) {
//         if($result[$i]['key'] == 'email') {
//             $email_field_id = $result[$i]['id'];
//         } else if($result[$i]['key'] == 'event_id') {
//             $event_id_field_id = $result[$i]['id'];
//         }
//         if($result[$i]['type'] != 'hidden') {
//             $fields[$result[$i]['key']] = $result[$i]['id'];
//         }
//     }

//     $event_id = $_POST['fields'][$event_id_field_id];
//     $campaignID = get_post_meta($event_id, 'hfusa-event_campaigns', true);
//     $classyCampaignID = get_post_meta($campaignID, 'hfusa-classy_campaign_id', true);

//     $email = $_POST['fields'][$email_field_id];

//     $result = $wpdb->get_row("SELECT * FROM {$wpdb->prefix}hf_classy_donations WHERE classy_id=$classyCampaignID AND donation_type = 'Pledge' AND donor_email = '".$email."' AND transaction_id=0");

//     if($result !== null) {
//         $table = $wpdb->prefix.'hf_classy_donations';

//         $wpdb->update( 
//             $table, 
//             array( 
//                 'first_name' => $_POST['fields'][$fields['first_name']],
//                 'middle_name' => $_POST['fields'][$fields['middle_name']],
//                 'last_name' => $_POST['fields'][$fields['last_name']],
//                 'donor_phone' => $_POST['fields'][$fields['phone']],
//                 'address' => $_POST['fields'][$fields['address']],
//                 'donor_city' => $_POST['fields'][$fields['city']],
//                 'donor_state' => $_POST['fields'][$fields['state']],
//                 'donor_zip' => $_POST['fields'][$fields['zip']],
//                 'donation_amount' => $_POST['fields'][$fields['pledge_amount']],
//                 'pledge_promise_date' => $_POST['fields'][$fields['planned_payment_date']],
//                 'hf_ambassador' => $_POST['fields'][$fields['humanity_first_ambassador']],
//             ), 
//             array( 'ID' => $result->id )
//         );
//     }
// }

// add_action('save_post', 'update_ninja_pledge_form', 10, 3);

add_action('wp_footer', 'hf_ninja_forms_callback_scripts', 500);
function hf_ninja_forms_callback_scripts()
{
    ?>
    <script type="text/javascript">
        if (typeof Marionette !== 'undefined') {
            var hfNFSubmitController = Marionette.Object.extend({
                initialize: function () {
                    this.listenTo(Backbone.Radio.channel('forms'), 'submit:response', this.actionSubmit);
                },
                actionSubmit: function (response) {
                    var height_title_section = jQuery('.inner-page-title-section').height();
                    var height_header_section = jQuery('#header').height();
                    var offset = parseInt(height_title_section) + parseInt(height_header_section) + parseInt(20);
                    jQuery('html, body').animate({
                        scrollTop: jQuery(".ninja-form-fixed-header-gap").offset().top - (offset)
                    }, 0);
                },
            });

            jQuery(document).ready(function ($) {
                if (jQuery(".ninja-form-fixed-header-gap").length > 0) {
                    new hfNFSubmitController();
                }
            });


            // Create a new object for custom validation of a custom field.
            var hfEmailValidationNinjaForms = Marionette.Object.extend({
                initialize: function () {
                    // On the Form Submission's field validaiton...
                    var submitChannel = Backbone.Radio.channel('submit');
                    this.listenTo(submitChannel, 'validate:field', this.validateRequired);

                    // on the Field's model value change...
                    var fieldsChannel = Backbone.Radio.channel('fields');
                    this.listenTo(fieldsChannel, 'change:modelValue', this.validateRequired);
                },

                validateRequired: function (model) {

                    var modelID = model.get('id');

                    if (modelID == 15) {
                        var field_value = model.get('value');
                        var errorID = 'custom-field-error';
                        var errorMessage = 'Email already registered!';

                        if (field_value) {
                            jQuery.post(ajax_object.ajaxurl, {
                                action: 'validate_already_registered_user',
                                user_email: field_value
                            }, function (data) {
                                if (data) {
                                    Backbone.Radio.channel('fields').request('add:error', modelID, errorID, errorMessage);
                                } else {
                                    Backbone.Radio.channel('fields').request('remove:error', modelID, errorID);
                                }
                            });

                        } else {
                            Backbone.Radio.channel('fields').request('remove:error', modelID, errorID);
                        }
                    }
                }
            });

            // On Document Ready...
            jQuery(document).ready(function ($) {
                new hfEmailValidationNinjaForms();
            });
        }
    </script>
    <?php
}

add_filter('rest_prepare_hf_events', 'filter_events_api_response', 999, 3);

function filter_events_api_response($response, $post, $request)
{

    if (isset($response->data['meta_box']['hfusa-agandas_details'])) {
        $agenda_items = $response->data['meta_box']['hfusa-agandas_details'];

        if (count($agenda_items) == 1) {
            if (empty($agenda_item[0]['agenda_title']) && empty($agenda_item[0]['start_time']) && empty($agenda_item[0]['end_time'])) {
                $response->data['meta_box']['hfusa-agandas_details'] = [];
            }
        }
    }

    return $response;
}


function hf_header_bg_img()
{

    $backgroundImageID = get_post_meta(get_the_ID(), 'hfusa-header_background_image', true);

    if (!empty($backgroundImageID)) {
        $backgroundPosition = get_post_meta(get_the_ID(), 'hfusa-background_focus', true);
        if (empty($backgroundPosition)) {
            $backgroundPosition = 'center';
        }
        $backgroundImage = wp_get_attachment_url($backgroundImageID);
        $backgroundImageRule = ' style="background-image: url(' . "'" . $backgroundImage . "'" . '); background-position:' . $backgroundPosition . '" ';
    } else {
        $backgroundImageRule = '';
    }

    return $backgroundImageRule;
}

/*woocommerce*/

/* filter to remove the coupons functionality */

// function hf_filter_woocommerce_coupons_enabled($coupon)
// {
//     return false;
// }

// ;

// add_filter('woocommerce_coupons_enabled', 'hf_filter_woocommerce_coupons_enabled', 10, 1);


// function filter_woocommerce_form_field_args($args, $key, $value)
// {

//     $args['input_class'][] = 'form-control';
//     return $args;

// }

// ;

// add_filter('woocommerce_form_field_args', 'filter_woocommerce_form_field_args', 10, 3);

// function hf_filter_woocommerce_checkout_fields($fields)
// {

//     $fields['order']['order_comments']['label'] = 'Comments';
//     $fields['order']['order_comments']['placeholder'] = 'Comments';
//     return $fields;
// }

// ;

// add_filter('woocommerce_checkout_fields', 'hf_filter_woocommerce_checkout_fields');

// function hf_title_order_received($title, $id)
// {
//     if (is_order_received_page() && get_the_ID() === $id) {
//         $title = "Payment Received!";
//     }

//     return $title;
// }

// add_filter('the_title', 'hf_title_order_received', 10, 2);

// function hf_subscriptions_custom_price_string($pricestring)
// {
//     $newprice = str_replace('every day for 1 day', 'Once', $pricestring);
//     return $newprice;
// }

// add_filter('woocommerce_subscriptions_product_price_string', 'hf_subscriptions_custom_price_string');

// function hf_subscriptions_custom_price_string_second($pricestring)
// {
//     $newprice = str_replace('/ day', 'Once', $pricestring);
//     return $newprice;
// }

// add_filter('woocommerce_subscriptions_product_price_string', 'hf_subscriptions_custom_price_string_second');


// function hf_subscriptions_custom_price_string_third($pricestring)
// {
//     $newprice = str_replace('for 1 day', 'Once', $pricestring);
//     return $newprice;
// }

// add_filter('woocommerce_subscriptions_product_price_string', 'hf_subscriptions_custom_price_string_third');


// function hf_filter_products_api_response_product($response, $post, $request)
// {

//     $product_id = $post->get_id();

//     $relatedPrograms = get_post_meta($product_id, 'hfusa-related_programs');

//     $relatedProgramsArr = array();
//     if (!empty($relatedPrograms) && is_array($relatedPrograms)) {

//         foreach ($relatedPrograms as $program_id) {
//             $relatedProgramsArr[] = array(
//                 'program_id' => $program_id,
//                 'program_name' => get_the_title($program_id),
//             );
//         }
//     }

//     $response->data['meta_box']['related_programs'] = $relatedProgramsArr;
//     return $response;
// }

// add_filter('woocommerce_rest_prepare_product_object', 'hf_filter_products_api_response_product', 999, 3);

// add_filter('woocommerce_placeholder_img_src', 'hf_custom_woocommerce_placeholder_img_src');

// function hf_custom_woocommerce_placeholder_img_src($src)
// {
//     $stylesheet_directory = get_stylesheet_directory_uri();
//     $src = $stylesheet_directory . '/assets/images/placeholder_wc_img.jpg';
//     return $src;
// }

// add_filter('woocommerce_add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');

// function woocommerce_header_add_to_cart_fragment($fragments)
// {
//     $fragments['hf_cart_total'] = WC()->cart->get_cart_contents_count();
//     return $fragments;
// }

// function hf_wpdocs_comment_form_defaults($defaults)
// {
//     $defaults['comment_notes_before'] = __('');
//     return $defaults;
// }

// add_filter('comment_form_defaults', 'hf_wpdocs_comment_form_defaults');


// function hf_filter_woocommerce_product_tabs($woocommerce_default_product_tabs)
// {

//     if (!empty($woocommerce_default_product_tabs['additional_information'])) {
//         $woocommerce_default_product_tabs['additional_information']['title'] = 'Add a review';
//     }
//     return $woocommerce_default_product_tabs;
// }

// ;

// add_filter('woocommerce_product_tabs', 'hf_filter_woocommerce_product_tabs', 10, 1);

// function hf_filter_woocommerce_product_description_heading($var)
// {
//     return '';
// }

// ;

// add_filter('woocommerce_product_description_heading', 'hf_filter_woocommerce_product_description_heading', 10, 1);

/*
function hf_before_add_to_cart_button()
{
    global $product;
    ?>
    div class="clearfix"></div>
    <div class="product_comment_field">
       <label for="product_comment">Comment: </label>
       <textarea name="product_comment" id="product_comment"
                 placeholder="Make this donation in someone else's honour"></textarea>
   </div>
    <?php
}
*/

// add_action('woocommerce_before_add_to_cart_button', 'hf_before_add_to_cart_button', 10);

// function hf_add_comment_to_cart_item($cart_item_data, $product_id, $variation_id)
// {

//     $comment = filter_input(INPUT_POST, 'product_comment');

//     if (empty($comment)) {
//         return $cart_item_data;
//     }

//     $cart_item_data['product_comment'] = $comment;

//     return $cart_item_data;
// }

// add_filter('woocommerce_add_cart_item_data', 'hf_add_comment_to_cart_item', 10, 3);

// function hf_display_comment_text_cart($item_data, $cart_item)
// {

//     if (empty($cart_item['product_comment'])) {
//         return $item_data;
//     }

//     $item_data[] = array(
//         'key' => 'Comment',
//         'value' => wc_clean($cart_item['product_comment']),
//         'display' => '',
//     );

//     return $item_data;
// }

// add_filter('woocommerce_get_item_data', 'hf_display_comment_text_cart', 10, 2);

// function hf_add_comment_text_to_order_items($item, $cart_item_key, $values, $order)
// {
//     if (empty($values['product_comment'])) {
//         return;
//     }

//     $item->add_meta_data('Comment', $values['product_comment']);
// }

// add_action('woocommerce_checkout_create_order_line_item', 'hf_add_comment_text_to_order_items', 10, 4);

// add_filter('woocommerce_get_cart_item_from_session', function ($cart_item, $values) {

//     if (!empty($_POST['product_comment'][$cart_item['key']])) {
//         $cart_item['product_comment'] = $_POST['product_comment'][$cart_item['key']];
//     }

//     return $cart_item;
// }, 11, 2);

// function action_woocommerce_order_status_processing($order_id)
// {

//     $order = wc_get_order($order_id);

//     $order_data = $order->get_data();

//     $order_status = $order_data['status'];

//     $order_currency = $order_data['currency'];

//     $order_total = $order_data['total'];

//     $order_payment_method = $order_data['payment_method'];

//     $order_billing_email = $order_data['billing']['email'];

//     $order_billing_first_name = $order_data['billing']['first_name'];

//     $order_billing_last_name = $order_data['billing']['last_name'];

//     $order_billing_city = $order_data['billing']['city'];

//     $order_billing_state = $order_data['billing']['state'];

//     $order_billing_postcode = $order_data['billing']['postcode'];

//     $order_billing_country = $order_data['billing']['country'];

//     global $hf_us_state_abbrevs_names;

//     if ($order_status == 'processing') {

//         $client = new \Classy\Client([
//             'client_id' => 'ngVpuzzCKcldwe2x',
//             'client_secret' => 'QwtBc22E4F068HyU',
//             'version' => '2.0' // version of the API to be used
//         ]);

//         $session = $client->newAppSession();

//         // Post offline transaction on Classy
//         try {
//             $items = array(
//                 array(
//                     "campaign_id" => 59013,
//                     "raw_final_price" => $order_total,
//                     "raw_currency_code" => $order_currency,
//                 )
//             );
//             $options = array(
//                 "member_email_address" => $order_billing_email,
//                 "items" => $items,
//                 "billing_city" => $order_billing_city,
//                 "billing_state" => $order_billing_state,
//                 "billing_country" => $order_billing_country,
//                 "billing_first_name" => $order_billing_first_name,
//                 "billing_last_name" => $order_billing_last_name,
//             );

//             $post_transaction = $client->post('/campaigns/59013/transactions?auto_allocate=false', $session, $options);

//         } catch (\Classy\Exceptions\APIResponseException $e) {
//             // Get the HTTP response code
//             $code = $e->getCode();
//             // Get the response content
//             $content = $e->getResponseData();
//             // Get the response headers
//             $headers = $e->getResponseHeaders();
//         }

//         $line_items = $order->get_items();

//         $user_login = '';
//         $user_email = '';
//         $user_firstname = '';
//         $user_lastname = '';
//         $display_name = '';
//         $phone_number = '';
//         $user_state = '';
//         $donation_campaign = isset($_SESSION['donation_campaign']) ? $_SESSION['donation_campaign'] : '';

//         if (is_user_logged_in()) {
//             $current_user = wp_get_current_user();
//             $user_login = $current_user->user_login;
//             $user_email = $current_user->user_email;
//             $user_firstname = $current_user->user_firstname;
//             $user_lastname = $current_user->user_lastname;
//             $display_name = $current_user->display_name;
//             $user_ID = $current_user->ID;
//             $phone_number = get_user_meta($user_ID, 'phone_number', true);
//             $user_state = get_user_meta($user_ID, 'volunteer_liststate', true);

//             if (empty($user_state)) {
//                 $user_state = get_user_meta($user_ID, 'billing_state', true);
//                 if (!empty($user_state)) {
//                     $user_state = isset($hf_us_state_abbrevs_names[$user_state]) ? $hf_us_state_abbrevs_names[$user_state] : '';
//                 }
//             }
//         }


//         foreach ($line_items as $item_id => $item_data) {

//             $product = $item_data->get_product();
//             $product_id = $product->get_id();
//             $related_program = get_post_meta($product_id, 'hfusa-related_programs', true);
//             $terms = get_the_terms($product_id, 'product_cat');

//             $donation = false;
//             foreach ($terms as $term) {
//                 if ($term->slug == 'donation') {
//                     $donation = true;
//                 }
//             }

//             if ($donation == true) {
//                 $donation_for = 'General';
//                 $programName = '';
//                 if (!empty($related_program)) {
//                     $donation_for = 'Program';
//                     $programName = get_the_title($related_program);
//                 }

//                 $item_total = $item_data->get_total();

//                 wp_insert_post(
//                     array(
//                         'post_title' => $user_ID . '-' . $related_program,
//                         'post_type' => 'hf_donations',
//                         'post_status' => 'publish',
//                         'meta_input' => array(
//                             'hfusa-donation_type' => 'Donation',
//                             'hfusa-donation_for' => $donation_for,
//                             'hfusa-donation_amount' => $item_total,
//                             'hfusa-program_id' => $related_program,
//                             'hfusa-program_name' => $programName,
//                             'hfusa-donation_campaign_id' => $donation_campaign,
//                             'hfusa-donor_id' => $user_ID,
//                             'hfusa-donor_name' => $user_firstname . ' ' . $user_lastname,
//                             'hfusa-donor_email' => $user_email,
//                             'hfusa-donor_phone' => $phone_number,
//                             'hfusa-donor_state' => $user_state,
//                             'hfusa-donation_order_id' => $order_id
//                         )
//                     )
//                 );
//             }
//         }
//     }
// }

// ;

// add_action('woocommerce_order_status_processing', 'action_woocommerce_order_status_processing', 10, 1);


// /* Filter the products based on the progrma id on the Donate page */

// add_action('woocommerce_product_query', 'filter_products_by_program_id');

// function filter_products_by_program_id($q)
// {

//     if (is_shop() && !empty($_GET['program_id'])) {
//         $program_id = $_GET['program_id'];
//         $meta_query = $q->get('meta_query');

//         $meta_query[] = array(
//             'key' => 'hfusa-related_programs',
//             'value' => array($program_id),
//             'compare' => 'IN',
//         );

//         $q->set('meta_query', $meta_query);
//     }
// }


// function hf_filter_woocommerce_catalog_orderby($array)
// {
//     $array = array(
//         'menu_order' => 'Default sorting',
//         'popularity' => 'Popularity',
//         'rating' => 'Average rating',
//         'date' => 'Newness',
//         'price' => 'Low to high',
//         'price-desc' => 'High to low'
//     );
//     return $array;
// }

// ;


// add_filter('woocommerce_catalog_orderby', 'hf_filter_woocommerce_catalog_orderby', 10, 1);

// function hf_product_categories_args($args)
// {

//     $default_term_id = get_option('default_product_cat');
//     $args['exclude'] = array($default_term_id);
//     $args['hide_empty'] = true;

//     return $args;
// }

// add_filter('woocommerce_product_categories_widget_dropdown_args', 'hf_product_categories_args', 10, 1);

// function prefix_wc_rest_prepare_order_object($response, $object, $request)
// {

//     $line_items = $response->data['line_items'];

//     for ($i = 0; $i < count($line_items); $i++) {
//         $product_id = $line_items[$i]['product_id'];
//         $image_url = get_the_post_thumbnail_url($product_id);
//         $response->data['line_items'][$i]['media_url'] = $image_url;
//     }

//     return $response;
// }

// add_filter('woocommerce_rest_prepare_shop_order_object', 'prefix_wc_rest_prepare_order_object', 10, 3);

function hf_check_campaign_donation()
{
    if (!empty($_GET['campaign_id'])) {
        $_SESSION['donation_campaign'] = $_GET['campaign_id'];
    }
}

add_action('init', 'hf_check_campaign_donation');


add_action('rest_api_init', 'hf_api_hook_for_donation');
function hf_api_hook_for_donation()
{

    register_rest_route(
        'wp/v2/', '/add-donation/',
        array(
            'methods' => 'POST',
            'callback' => 'hf_add_donation_record',
            'permission_callback' => 'hf_add_donation_permissions'
        )
    );

    register_rest_route(
        'wp/v2/', '/hf-get-donations/',
        array(
            'methods' => 'GET',
            'callback' => 'hf_get_donations',
            'permission_callback' => 'hf_get_donations_permissions'
        )
    );

    register_rest_route(
        'wp/v2/', '/hf-get-donations-count/',
        array(
            'methods' => 'GET',
            'callback' => 'hf_get_donations_count',
            'permission_callback' => 'hf_get_donations_permissions'
        )
    );

    register_rest_route(
        'wp/v2/', '/hf-add-donation/',
        array(
            'methods' => 'POST',
            'callback' => 'hf_add_donation',
            'permission_callback' => 'hf_add_donation_permissions'
        )
    );

    register_rest_route(
        'wp/v2/', '/hf-update-donation/',
        array(
            'methods' => 'PUT',
            'callback' => 'hf_update_donation',
            'permission_callback' => 'hf_update_donation_permissions'
        )
    );

    register_rest_route(
        'wp/v2/', '/hf-cancel-donation/',
        array(
            'methods' => 'PUT',
            'callback' => 'hf_cancel_donation',
            'permission_callback' => 'hf_update_donation_permissions'
        )
    );

    register_rest_route(
        'wp/v2/', '/hf-update-pledge/',
        array(
            'methods' => 'PUT',
            'callback' => 'hf_update_pledge',
            'permission_callback' => 'hf_update_pledge_permissions'
        )
    );
}

function hf_add_donation_permissions($request)
{

    $authorizationCode = $request->get_header('authorization');
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    $user = wp_authenticate($username, $password);

    if (is_wp_error($user) || !user_can($user, 'publish_posts')) {

        return new WP_Error('rest_forbidden_context', __('Sorry, you are not allowed to perform this operation.'), array('status' => rest_authorization_required_code()));
    }

    return true;
}

function hf_update_donation_permissions($request)
{

    $authorizationCode = $request->get_header('authorization');
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    $user = wp_authenticate($username, $password);

    if (is_wp_error($user) || !user_can($user, 'publish_posts')) {

        return new WP_Error('rest_forbidden_context', __('Sorry, you are not allowed to perform this operation.'), array('status' => rest_authorization_required_code()));
    }

    return true;
}


function hf_add_donation_record(WP_REST_Request $request)
{


    $output = array("success" => "false", "ref_code" => "");

    if (empty($_POST['donation_type'])) {
        $output["message"] = "Donation type is required.";
    } else if (empty($_POST['donation_amount'])) {
        $output["message"] = "Donation amount is required.";
    } else if (empty($_POST['firstname'])) {
        $output["message"] = "First name is required.";
    } else if (empty($_POST['lastname'])) {
        $output["message"] = "Last name is required.";
    } else if (empty($_POST['email'])) {
        $output["message"] = "Email is required.";
    } else if (empty($_POST['phone'])) {
        $output["message"] = "Phone is required.";
    } else if (empty($_POST['state'])) {
        $output["message"] = "State is required.";
    } else if (strtolower($_POST['donation_type']) == 'pledge' && empty($_POST['pledge_promise_date'])) {
        $output["message"] = "Pledge date is required.";
    } else if (strtolower($_POST['donation_type']) != 'donation' && strtolower($_POST['donation_type']) != 'pledge') {
        $output["message"] = "Donation type is not correct.";
    } else {


        $authorizationCode = $request->get_header('authorization');
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        $user = wp_authenticate($username, $password);

        $userID = isset($user->ID) ? $user->ID : '';

        $donation_method = '';
        $card_number = '';
        $exp_month = '';
        $exp_year = '';
        $cvc = '';
        $ref_code = '';
        $last4 = '';

        $the_slug = 'telethon';
        $args = array(
            'name' => $the_slug,
            'post_type' => 'hf_campaigns',
            'post_status' => 'publish',
            'numberposts' => 1
        );

        $my_posts = get_posts($args);
        $campaign_id = (!empty($my_posts) && !empty($my_posts[0]->ID)) ? $my_posts[0]->ID : '';
        $donation_type = ucfirst($_POST['donation_type']);
        $donation_amount = $_POST['donation_amount'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $state = $_POST['state'];
        $ref_code = !empty($_POST['ref_code']) ? $_POST['ref_code'] : '';
        $pledge_promise_date = !empty($_POST['pledge_promise_date']) ? $_POST['pledge_promise_date'] : '';
        $pledge_total = !empty($_POST['pledge_total']) ? $_POST['pledge_total'] : '';
        $rec_period = !empty($_POST['rec_period']) ? $_POST['rec_period'] : '';

        $donation_title = $firstname . ' ' . $lastname . ' ' . $donation_amount . ' ' . $ref_code;
        $donation_title = sanitize_title($donation_title);

        if (!empty($_POST['donation_method']) && $_POST['donation_method'] == 'credit_card') {

            $donation_method = 'credit_card';

            if (empty($_POST['card_number'])) {
                $output["message"] = "Card number is required.";
                return $output;
            } else if (empty($_POST['exp_month'])) {
                $output["message"] = "Card's expiry month is required.";
                return $output;
            } else if (empty($_POST['exp_year'])) {
                $output["message"] = "Card's expiry year is required.";
                return $output;
            } else if (empty($_POST['cvc'])) {
                $output["message"] = "Card's security code is required.";
                return $output;
            }

            $card_number = $_POST['card_number'];
            $exp_month = $_POST['exp_month'];
            $exp_year = $_POST['exp_year'];
            $cvc = $_POST['cvc'];

            try {

                require_once('framework/stripe/init.php');

                $hf_stripe_secret = get_option('hf_stripe_secret');

                \Stripe\Stripe::setApiKey($hf_stripe_secret);

                $token = \Stripe\Token::create(
                    array(
                        "card" => array(
                            'number' => $card_number,
                            'cvc' => $cvc,
                            'exp_month' => $exp_month,
                            'exp_year' => $exp_year
                        )
                    )
                );

                $charge = \Stripe\Charge::create(
                    array(
                        "amount" => $donation_amount * 100,
                        "currency" => 'usd',
                        "description" => '',
                        "card" => $token,
                    )
                );

                $ref_code = $charge->id;
                $last4 = isset($charge->source->last4) ? $charge->source->last4 : '';

            } catch (Exception $e) {
                $body = $e->getJsonBody();
                $output["message"] = $body['error']['message'];
                return $output;
            }

        }

        if (!empty($_POST['donation_method']) && $_POST['donation_method'] == 'credit_card' && $donation_type == 'Donation') {
            
            include_once('framework/classy-php-sdk/vendor/autoload.php');

            $client = new \Classy\Client([
                'client_id' => 'ngVpuzzCKcldwe2x',
                'client_secret' => 'QwtBc22E4F068HyU',
                'version' => '2.0' // version of the API to be used
            ]);

            $session = $client->newAppSession();

            try {
                $items = array(
                    array(
                        "campaign_id" => 59013,
                        "raw_final_price" => $donation_amount,
                        "raw_currency_code" => "USD",
                    )
                );
                $options = array(
                    "member_email_address" => $email,
                    "items" => $items,
                    "billing_state" => $state,
                    "billing_first_name" => $firstname,
                    "billing_last_name" => $lastname
                );
                $post_transaction = $client->post('/campaigns/59013/transactions?auto_allocate=false', $session, $options);
            } catch (\Classy\Exceptions\APIResponseException $e) {
                // Get the HTTP response code
                // $code = $e->getCode();
                // Get the response content
                // $content = $e->getResponseData();
                // Get the response headers
                // $headers = $e->getResponseHeaders();
            }
        }

        if (!empty($_POST['post_id'])) {

            $post_id = $_POST['post_id'];

            $donation_id = wp_update_post(
                array(
                    'ID' => $post_id,
                    'post_title' => $donation_title,
                    'post_type' => 'hf_donations',
                    'meta_input' => array(
                        'hfusa-donation_type' => $donation_type,
                        'hfusa-donation_for' => 'General',
                        'hfusa-donation_amount' => $donation_amount,
                        'hfusa-donation_campaign_id' => $campaign_id,
                        'hfusa-donor_name' => $firstname . ' ' . $lastname,
                        'hfusa-donor_email' => $email,
                        'hfusa-donor_phone' => $phone,
                        'hfusa-donor_state' => $state,
                        'hfusa-pledge_promise_date' => $pledge_promise_date,
                        'hfusa-transaction_ref_code' => $ref_code,
                        'hfusa-pledge_recurrence' => $rec_period,
                        'hfusa-pledge_recursive_amount' => $pledge_total
                    )
                )
            );

        } else {

            $donation_id = wp_insert_post(
                array(
                    'post_author' => $userID,
                    'post_title' => $donation_title,
                    'post_type' => 'hf_donations',
                    'post_status' => 'publish',
                    'meta_input' => array(
                        'hfusa-donation_type' => $donation_type,
                        'hfusa-donation_for' => 'General',
                        'hfusa-donation_amount' => $donation_amount,
                        'hfusa-program_id' => '',
                        'hfusa-program_name' => '',
                        'hfusa-donation_campaign_id' => $campaign_id,
                        'hfusa-donor_id' => '',
                        'hfusa-donor_name' => $firstname . ' ' . $lastname,
                        'hfusa-donor_email' => $email,
                        'hfusa-donor_phone' => $phone,
                        'hfusa-donor_state' => $state,
                        'hfusa-donation_order_id' => '',
                        'hfusa-pledge_promise_date' => $pledge_promise_date,
                        'hfusa-transaction_ref_code' => $ref_code,
                        'hfusa-pledge_recurrence' => $rec_period,
                        'hfusa-pledge_recursive_amount' => $pledge_total
                    )
                )
            );
        }


        if (!empty($_POST['donation_method']) && $_POST['donation_method'] == 'credit_card') {

            $donorInfo = array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'city' => '',
                'state' => $state,
                'zip' => '',
                'address' => '',
                'campaign_id' => $campaign_id,
                'donation_amount' => $donation_amount,
                'last4' => $last4,

            );

            hf_stripe_payment_mail($donorInfo);

        } else if (!empty($_POST['donation_type']) && $_POST['donation_type'] == 'pledge') {

            $donorInfo = array(
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'donation_amount' => $donation_amount
            );

            hf_pledge_promise_mail($donorInfo);
        }

        $output["success"] = true;
        $output["ref_code"] = $ref_code;
        $output["post_id"] = $donation_id;
        $output["message"] = "Donation recorded successfully.";
    }
    return $output;
}

function hf_get_donations_permissions($request)
{
    $authorizationCode = $request->get_header('authorization');
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    $user = wp_authenticate($username, $password); 

    if (is_wp_error($user) || !current_user_can( 'read' )) {

        return new WP_Error('rest_forbidden_context', __('Sorry, you are not allowed to perform this operation.'), array('status' => rest_authorization_required_code()));
    }

    return true;
}

function hf_update_pledge_permissions($request)
{
    $authorizationCode = $request->get_header('authorization');
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    $user = wp_authenticate($username, $password); 

    if (is_wp_error($user) || !current_user_can( 'edit_posts' )) {

        return new WP_Error('rest_forbidden_context', __('Sorry, you are not allowed to perform this operation.'), array('status' => rest_authorization_required_code()));
    }

    return true;
}

function hf_update_pledge(WP_REST_Request $request) {
    $data = array("success" => true, "status" => 200);

    if(empty($_GET['hfdms_transaction_id'])) {
        $data['status'] = 400;
        $data['success'] = false;
        $data['message'] = "Transaction ID is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );

        // Add a custom status code
        $response->set_status( 400 );

        return $response;
    } elseif(empty($_GET['status'])) {
        $data['status'] = 400;
        $data['success'] = false;
        $data['message'] = "Status parameter is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );

        // Add a custom status code
        $response->set_status( 400 );

        return $response;
    } else {
        global $wpdb;
        if($_GET['status'] == 'update') {
            $pledge_promise_date = "";
            $donation_amount = "";
            if(!empty($_GET['pledge_promise_date'])) {
                $pledge_promise_date = $_GET['pledge_promise_date'];
            }
            if(!empty($_GET['donation_amount'])) {
                $donation_amount = $_GET['donation_amount'];
            }

            $where_clause = (!empty($_GET['pledge_promise_date'])) ? "pledge_promise_date = '".$_GET['pledge_promise_date']."'" : "";
            if(!empty($where_clause)) {
                $where_clause .= (!empty($_GET['donation_amount'])) ? ", donation_amount = ".$_GET['donation_amount'] : "";
            } else {
                $where_clause = (!empty($_GET['donation_amount'])) ? "donation_amount = ".$_GET['donation_amount'] : "";
            }


            $result = $wpdb->query("UPDATE {$wpdb->prefix}hf_classy_donations SET $where_clause WHERE hfdms_transaction_id = '".$_GET['hfdms_transaction_id']."'");
            $data['message'] = "Pledge updated successfully.";
        } elseif($_GET['status'] == 'cancel') {
            $wpdb->update( 
                $wpdb->prefix.'hf_classy_donations', 
                array( 
                    'donation_type' => 'PCancel',
                ), 
                array( 'hfdms_transaction_id' => $_GET['hfdms_transaction_id'] ),
            );
            $data['message'] = "Pledge cancelled successfully.";
        } elseif($_GET['status'] == 'paid') {
            if(!empty($_GET['donation_amount'])) {
                $wpdb->update( 
                    $wpdb->prefix.'hf_classy_donations', 
                    array( 
                        'donation_type' => 'Paid',
                        'donation_amount' => $_GET['donation_amount'],
                    ), 
                    array( 'hfdms_transaction_id' => $_GET['hfdms_transaction_id'] ),
                );
            } else {
                $wpdb->update( 
                    $wpdb->prefix.'hf_classy_donations', 
                    array( 
                        'donation_type' => 'Paid',
                    ), 
                    array( 'hfdms_transaction_id' => $_GET['hfdms_transaction_id'] ),
                );
            }
            $data['message'] = "Pledge paid successfully.";
        }
    }
    // Create the response object
    $response = new WP_REST_Response( $data );

    // Add a custom status code
    $response->set_status( 200 );

    return $response;
}

function hf_get_donations(WP_REST_Request $request) {

    $data = array("success" => true, "status" => 200);

    if(empty($_GET['max_id'])) {
        $data['status'] = 400;
        $data['success'] = false;
        $data['message'] = "Maximum donation ID is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );

        // Add a custom status code
        $response->set_status( 400 );

        return $response;
    } else {
        global $wpdb;
        $results = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}hf_classy_donations WHERE id > ".$_GET['max_id']." AND (source != 'HFDMS' OR source IS NULL OR source = 'CLASSY' OR source = 'WEB')", ARRAY_A);
        $data['results'] = $results;
    }

    // Create the response object
    $response = new WP_REST_Response( $data );

    // Add a custom status code
    $response->set_status( 200 );

    return $response;
}

function hf_get_donations_count(WP_REST_Request $request) {

    $data = array("success" => true, "status" => 200);

    if(empty($_GET['max_id'])) {
        $data['status'] = 400;
        $data['success'] = false;
        $data['message'] = "Maximum donation ID is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );

        // Add a custom status code
        $response->set_status( 400 );

        return $response;
    } else {
        global $wpdb;
        $count = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}hf_classy_donations WHERE id > ".$_GET['max_id']." AND (source != 'HFDMS' OR source IS NULL OR source = 'CLASSY' OR source = 'WEB')");
        $data['count'] = $count;
    }

    // Create the response object
    $response = new WP_REST_Response( $data );

    // Add a custom status code
    $response->set_status( 200 );

    return $response;
}

function hf_add_donation(WP_REST_Request $request) {
    $data = array("success" => false, "status" => 400);

    if(empty($_POST['campaign_id'])) {
        $data["message"] = "Campaign ID is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } elseif (empty($_POST['donation_type'])) {
        $data["message"] = "Donation type is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } else if (empty($_POST['donation_amount'])) {
        $data["message"] = "Donation amount is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } else if (empty($_POST['firstname'])) {
        $data["message"] = "First name is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } else if (empty($_POST['lastname'])) {
        $data["message"] = "Last name is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } else if (empty($_POST['email'])) {
        $data["message"] = "Email is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } else if (empty($_POST['phone'])) {
        $data["message"] = "Phone is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } else if (empty($_POST['state'])) {
        $data["message"] = "State is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } else if (strtolower($_POST['donation_type']) == 'pledge' && empty($_POST['pledge_promise_date'])) {
        $data["message"] = "Pledge promise date is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } else if (strtolower($_POST['donation_type']) == 'donation' && empty($_POST['donation_id'])) {
        $data["message"] = "Donation ID is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } else if (strtolower($_POST['donation_type']) == 'pledge' && empty($_POST['pledge_id'])) {
        $data["message"] = "Pledge ID is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } else if (strtolower($_POST['donation_type']) == 'pledge' && empty($_POST['pledge_id'])) {
        $data["message"] = "Pledge ID is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );
        $response->set_status( 400 );
    } else {
        $hfdms_transaction_id = '';
        if(strtolower($_POST['donation_type']) == 'donation') {
            $hfdms_transaction_id = $_POST['donation_id'];
            $status = 'success';
        } elseif(strtolower($_POST['donation_type']) == 'pledge') {
            $hfdms_transaction_id = $_POST['pledge_id'];
            $status = null;
        }
        global $wpdb;
        $result = $wpdb->insert( 
            $wpdb->prefix.'hf_classy_donations', 
            array( 
                'classy_id' => $_POST['campaign_id'],
                'donation_type' => $_POST['donation_type'],
                'donation_amount' => $_POST['donation_amount'],
                'first_name' => $_POST['firstname'],
                'last_name' => $_POST['lastname'],
                'donor_name' => $_POST['firstname']." ".$_POST['lastname'],
                'donor_email' => $_POST['email'],
                'donor_phone' => $_POST['phone'],
                'donor_state' => $_POST['state'],
                'pledge_promise_date' => $_POST['pledge_promise_date'],
                'hfdms_transaction_id' => $hfdms_transaction_id,
                'source' => 'HFDMS',
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
            ),
        );

        if($result) {
            $data["success"] = true;
            $data["status"] = 200;
            $data["message"] = "Donation added successfully.";
            // Create the response object
            $response = new WP_REST_Response( $data );
            // Add a custom status code
            $response->set_status( 200 );
        } else {
            $data["message"] = "Donation could not be added.";
            // Create the response object
            $response = new WP_REST_Response( $data );
            // Add a custom status code
            $response->set_status( 400 );
        }
    }

    return $response;
}

function hf_update_donation(WP_REST_Request $request) {
    $data = array("success" => true, "status" => 200);

    if(empty($_GET['hfdms_transaction_id'])) {
        $data['status'] = 400;
        $data['success'] = false;
        $data['message'] = "Transaction ID is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );

        // Add a custom status code
        $response->set_status( 400 );

        return $response;
    } else {
        global $wpdb;
        $donation_amount = "";
        if(!empty($_GET['hfdms_transaction_id'])) {
            $hfdms_transaction_id = $_GET['hfdms_transaction_id'];
        }
        if(!empty($_GET['donation_amount'])) {
            $donation_amount = $_GET['donation_amount'];
        }

        $result = $wpdb->query("UPDATE {$wpdb->prefix}hf_classy_donations SET donation_amount=$donation_amount WHERE hfdms_transaction_id = '".$_GET['hfdms_transaction_id']."'");
        $data['message'] = "Donation updated successfully.";
    }
    // Create the response object
    $response = new WP_REST_Response( $data );

    // Add a custom status code
    $response->set_status( 200 );

    return $response;
}

function hf_cancel_donation(WP_REST_Request $request) {
    $data = array("success" => true, "status" => 200);

    if(empty($_GET['hfdms_transaction_id'])) {
        $data['status'] = 400;
        $data['success'] = false;
        $data['message'] = "Transaction ID is required.";
        // Create the response object
        $response = new WP_REST_Response( $data );

        // Add a custom status code
        $response->set_status( 400 );

        return $response;
    } else {
        global $wpdb;
        if(!empty($_GET['hfdms_transaction_id'])) {
            $hfdms_transaction_id = $_GET['hfdms_transaction_id'];
        }
        $wpdb->update( 
            $wpdb->prefix.'hf_classy_donations', 
            array( 
                'donation_type' => 'DCancel',
            ), 
            array( 'hfdms_transaction_id' => $hfdms_transaction_id ),
        );
        $data['message'] = "Donation cancelled successfully.";
    }
    // Create the response object
    $response = new WP_REST_Response( $data );

    // Add a custom status code
    $response->set_status( 200 );

    return $response;
}

function action_add_pledge_record()
{


    $the_slug = 'telethon';
    $args = array(
        'name' => $the_slug,
        'post_type' => 'hf_campaigns',
        'post_status' => 'publish',
        'numberposts' => 1
    );

    $my_posts = get_posts($args);
    $campaign_id = (!empty($my_posts) && !empty($my_posts[0]->ID)) ? $my_posts[0]->ID : '';

    $user_email = !empty($_POST['user_email']) ? $_POST['user_email'] : '';
    $user_first_name = !empty($_POST['user_first_name']) ? $_POST['user_first_name'] : '';
    $user_last_name = !empty($_POST['user_last_name']) ? $_POST['user_last_name'] : '';
    $user_middle_name = !empty($_POST['user_middle_name']) ? $_POST['user_middle_name'] : ' ';
    $user_phone = !empty($_POST['user_phone']) ? $_POST['user_phone'] : '';
    $user_city = !empty($_POST['user_city']) ? $_POST['user_city'] : '';
    $user_state = !empty($_POST['user_state']) ? $_POST['user_state'] : '';
    $pledge_amount = !empty($_POST['pledge_amount']) ? $_POST['pledge_amount'] : '';
    $pledge_recurrence = !empty($_POST['pledge_recurrence']) ? $_POST['pledge_recurrence'] : '';
    $pledge_recursive_amount = !empty($_POST['pledge_recursive_amount']) ? $_POST['pledge_recursive_amount'] : '';

    $user_name = $user_first_name . $user_middle_name . $user_last_name;

    if (!empty($user_middle_name)) {
        $user_name = $user_first_name . ' ' . $user_middle_name . ' ' . $user_last_name;
    }

    wp_insert_post(
        array(
            'post_title' => $user_name . '-' . $pledge_amount,
            'post_type' => 'hf_donations',
            'post_status' => 'publish',
            'meta_input' => array(
                'hfusa-donation_type' => 'Pledge',
                'hfusa-donation_for' => 'General',
                'hfusa-donation_amount' => $pledge_amount,
                'hfusa-donation_campaign_id' => $campaign_id,
                'hfusa-donor_name' => $user_name,
                'hfusa-donor_email' => $user_email,
                'hfusa-donor_phone' => $user_phone,
                'hfusa-donor_city' => $user_city,
                'hfusa-donor_state' => $user_state,
                'hfusa-pledge_recurrence' => $pledge_recurrence,
                'hfusa-pledge_recursive_amount' => $pledge_recursive_amount
            )
        )
    );


    $donorInfo = array(
        'firstname' => $user_first_name,
        'lastname' => $user_middle_name . $user_last_name,
        'email' => $user_email,
        'donation_amount' => $pledge_amount
    );

    hf_pledge_promise_mail($donorInfo);
}

add_action('wp_ajax_action_add_pledge_record', 'action_add_pledge_record');
add_action('wp_ajax_nopriv_action_add_pledge_record', 'action_add_pledge_record');


/*****************/


add_action('rest_api_init', 'hf_api_hook_for_donations');
function hf_api_hook_for_donations()
{

    register_rest_route(
        'wp/v2/', '/add-donations/',
        array(
            'methods' => 'POST',
            'callback' => 'hf_add_donations_record',
            'permission_callback' => 'hf_add_donations_permissions'
        )
    );
}

function hf_add_donations_permissions($request)
{

    $authorizationCode = $request->get_header('authorization');
    $username = $_SERVER['PHP_AUTH_USER'];
    $password = $_SERVER['PHP_AUTH_PW'];
    $user = wp_authenticate($username, $password);

    if (is_wp_error($user) || !user_can($user, 'publish_posts')) {

        return new WP_Error('rest_forbidden_context', __('Sorry, you are not allowed to perform this operation.'), array('status' => rest_authorization_required_code()));
    }

    return true;
}


function hf_add_donations_record(WP_REST_Request $request)
{


    $output = array("success" => "false", "ref_code" => "");

    if (empty($_POST['donation_type'])) {
        $output["message"] = "Donation type is required.";
    } else if (empty($_POST['donation_amount'])) {
        $output["message"] = "Donation amount is required.";
    } else if (empty($_POST['firstname'])) {
        $output["message"] = "First name is required.";
    } else if (empty($_POST['lastname'])) {
        $output["message"] = "Last name is required.";
    } else if (empty($_POST['email'])) {
        $output["message"] = "Email is required.";
    } else if (empty($_POST['phone'])) {
        $output["message"] = "Phone is required.";
    } else if (empty($_POST['state'])) {
        $output["message"] = "State is required.";
    } else if (strtolower($_POST['donation_type']) == 'pledge' && empty($_POST['pledge_promise_date'])) {
        $output["message"] = "Pledge date is required.";
    } else if (strtolower($_POST['donation_type']) != 'donation' && strtolower($_POST['donation_type']) != 'pledge') {
        $output["message"] = "Donation type is not correct.";
    } else {


        $authorizationCode = $request->get_header('authorization');
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        $user = wp_authenticate($username, $password);

        $userID = isset($user->ID) ? $user->ID : '';

        $donation_method = '';
        $card_number = '';
        $exp_month = '';
        $exp_year = '';
        $cvc = '';
        $ref_code = '';

        $the_slug = 'telethon';
        $args = array(
            'name' => $the_slug,
            'post_type' => 'hf_campaigns',
            'post_status' => 'publish',
            'numberposts' => 1
        );

        $my_posts = get_posts($args);
        $campaign_id = (!empty($my_posts) && !empty($my_posts[0]->ID)) ? $my_posts[0]->ID : '';
        $donation_type = ucfirst($_POST['donation_type']);
        $donation_amount = $_POST['donation_amount'];
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $state = $_POST['state'];
        $ref_code = !empty($_POST['ref_code']) ? $_POST['ref_code'] : '';
        $pledge_promise_date = !empty($_POST['pledge_promise_date']) ? $_POST['pledge_promise_date'] : '';
        $pledge_total = !empty($_POST['pledge_total']) ? $_POST['pledge_total'] : '';
        $rec_period = !empty($_POST['rec_period']) ? $_POST['rec_period'] : '';

        $donation_title = $firstname . ' ' . $lastname . ' ' . $donation_amount . ' ' . $ref_code;
        $donation_title = sanitize_title($donation_title);

        $billing_email = '';
        $oldDonationID = '';
        $customerID = '';
        $last4 = '';

        if (!empty($_POST['donation_method']) && $_POST['donation_method'] == 'credit_card') {

            $donation_method = 'credit_card';

            if (empty($_POST['card_number'])) {
                $output["message"] = "Card number is required.";
                return $output;
            } else if (empty($_POST['exp_month'])) {
                $output["message"] = "Card's expiry month is required.";
                return $output;
            } else if (empty($_POST['exp_year'])) {
                $output["message"] = "Card's expiry year is required.";
                return $output;
            } else if (empty($_POST['cvc'])) {
                $output["message"] = "Card's security code is required.";
                return $output;
            } else if (empty($_POST['billing_firstname'])) {
                $output["message"] = "Billing first name is required.";
                return $output;
            } else if (empty($_POST['billing_lastname'])) {
                $output["message"] = "Billing last name is required.";
                return $output;
            } else if (empty($_POST['billing_email'])) {
                $output["message"] = "Billing email is required.";
                return $output;
            }

            $card_number = $_POST['card_number'];
            $exp_month = $_POST['exp_month'];
            $exp_year = $_POST['exp_year'];
            $cvc = $_POST['cvc'];
            $billing_firstname = $_POST['billing_firstname'];
            $billing_lastname = $_POST['billing_lastname'];
            $billing_email = $_POST['billing_email'];
            $billing_city = !empty($_POST['billing_city']) ? $_POST['billing_city'] : '';
            $billing_state = !empty($_POST['billing_state']) ? $_POST['billing_state'] : '';
            $billing_zip = !empty($_POST['billing_zip']) ? $_POST['billing_zip'] : '';
            $billing_address = !empty($_POST['billing_address']) ? $_POST['billing_address'] : '';


            $args = array(
                'post_type' => 'hf_donations',
                'posts_per_page' => 1,
                'meta_query' => array(
                    array(
                        'key' => 'hfusa-donor_billing_email',
                        'value' => $billing_email,
                        'compare' => '=',
                    )
                )
            );

            $the_query = new WP_Query($args);

            if ($the_query->have_posts()) {
                while ($the_query->have_posts()) {
                    $the_query->the_post();
                    $oldDonationID = get_the_ID();
                    $customerID = get_post_meta($oldDonationID, 'hfusa-customer_id', true);
                }
                wp_reset_postdata();
            }

            $errorCode = '';
            $chargingExistingCustomerId = false;
            $chargingError = false;

            try {

                require_once('framework/stripe/init.php');

                $hf_stripe_secret = get_option('hf_stripe_secret');

                \Stripe\Stripe::setApiKey($hf_stripe_secret);

                $token = \Stripe\Token::create(
                    array(
                        "card" => array(
                            'number' => $card_number,
                            'cvc' => $cvc,
                            'exp_month' => $exp_month,
                            'exp_year' => $exp_year
                        )
                    )
                );

                if (!empty($customerID)) {

                    $chargingExistingCustomerId = true;

                    $charge = \Stripe\Charge::create(
                        array(
                            "customer" => $customerID,
                            "amount" => $donation_amount * 100,
                            "currency" => 'usd',
                            "description" => ''
                        )
                    );

                } else {

                    $user_info = array(
                        "City" => $billing_city,
                        "State" => $billing_state,
                        "Zip Code" => $billing_zip,
                        "Address" => $billing_address,
                    );

                    $customer = \Stripe\Customer::create(
                        array(
                            'email' => $billing_email,
                            'source' => $token,
                            'description' => $billing_firstname . ' ' . $billing_lastname,
                            'metadata' => $user_info
                        )
                    );

                    $customerID = $customer->id;

                    $charge = \Stripe\Charge::create(
                        array(
                            "customer" => $customer->id,
                            "amount" => $donation_amount * 100,
                            "currency" => 'usd',
                            "description" => ''
                        )
                    );
                }

                $ref_code = $charge->id;
                $last4 = isset($charge->source->last4) ? $charge->source->last4 : '';


            } catch (Exception $e) {
                $body = $e->getJsonBody();
                $output["message"] = $body['error']['message'];
                $errorCode = $body['error']['code'];
                $chargingError = true;
                if ($chargingExistingCustomerId == false) {
                    return $output;
                }
            }

            if ($errorCode == 'resource_missing' && $chargingExistingCustomerId == true) {

                try {

                    $user_info = array(
                        "City" => $billing_city,
                        "State" => $billing_state,
                        "Zip Code" => $billing_zip,
                        "Address" => $billing_address,
                    );

                    $customer = \Stripe\Customer::create(
                        array(
                            'email' => $billing_email,
                            'source' => $token,
                            'description' => $billing_firstname . ' ' . $billing_lastname,
                            'metadata' => $user_info
                        )
                    );

                    $customerID = $customer->id;

                    $charge = \Stripe\Charge::create(
                        array(
                            "customer" => $customer->id,
                            "amount" => $donation_amount * 100,
                            "currency" => 'usd',
                            "description" => ''
                        )
                    );

                    $ref_code = $charge->id;
                    $last4 = isset($charge->source->last4) ? $charge->source->last4 : '';


                } catch (Exception $e) {
                    $body = $e->getJsonBody();
                    $output["message"] = $body['error']['message'];
                    return $output;
                }

            } else if ($chargingExistingCustomerId == true && $chargingError == true) {
                return $output;
            }

        }

        if (!empty($_POST['donation_method']) && $_POST['donation_method'] == 'credit_card' && $donation_type == 'Donation') {
            
            include_once('framework/classy-php-sdk/vendor/autoload.php');

            $client = new \Classy\Client([
                'client_id' => 'ngVpuzzCKcldwe2x',
                'client_secret' => 'QwtBc22E4F068HyU',
                'version' => '2.0' // version of the API to be used
            ]);

            $session = $client->newAppSession();

            try {
                $items = array(
                    array(
                        "campaign_id" => 59013,
                        "raw_final_price" => $donation_amount,
                        "raw_currency_code" => "USD",
                    )
                );
                $options = array(
                    "member_email_address" => $billing_email,
                    "items" => $items,
                    "billing_city" => $billing_city,
                    "billing_state" => $billing_state,
                    "billing_postal_code" => $billing_zip,
                    "billing_address1" => $billing_address,
                    "billing_first_name" => $billing_firstname,
                    "billing_last_name" => $billing_lastname
                );
                $post_transaction = $client->post('/campaigns/59013/transactions?auto_allocate=false', $session, $options);
            } catch (\Classy\Exceptions\APIResponseException $e) {
                // Get the HTTP response code
                // $code = $e->getCode();
                // Get the response content
                // $content = $e->getResponseData();
                // echo "<pre>";
                // print_r($content);
                // // Get the response headers
                // $headers = $e->getResponseHeaders();
                // print_r($headers);
            }
        }

        if (!empty($_POST['post_id'])) {

            $post_id = $_POST['post_id'];

            $donation_id = wp_update_post(
                array(
                    'ID' => $post_id,
                    'post_title' => $donation_title,
                    'post_type' => 'hf_donations',
                    'meta_input' => array(
                        'hfusa-donation_type' => $donation_type,
                        'hfusa-donation_for' => 'General',
                        'hfusa-donation_amount' => $donation_amount,
                        'hfusa-donation_campaign_id' => $campaign_id,
                        'hfusa-donor_name' => $firstname . ' ' . $lastname,
                        'hfusa-donor_email' => $email,
                        'hfusa-donor_phone' => $phone,
                        'hfusa-donor_state' => $state,
                        'hfusa-pledge_promise_date' => $pledge_promise_date,
                        'hfusa-transaction_ref_code' => $ref_code,
                        'hfusa-donor_billing_email' => $billing_email,
                        'hfusa-customer_id' => $customerID,
                        'hfusa-pledge_recurrence' => $rec_period,
                        'hfusa-pledge_recursive_amount' => $pledge_total
                    )
                )
            );
        } else {

            $donation_id = wp_insert_post(
                array(
                    'post_author' => $userID,
                    'post_title' => $donation_title,
                    'post_type' => 'hf_donations',
                    'post_status' => 'publish',
                    'meta_input' => array(
                        'hfusa-donation_type' => $donation_type,
                        'hfusa-donation_for' => 'General',
                        'hfusa-donation_amount' => $donation_amount,
                        'hfusa-program_id' => '',
                        'hfusa-program_name' => '',
                        'hfusa-donation_campaign_id' => $campaign_id,
                        'hfusa-donor_id' => '',
                        'hfusa-donor_name' => $firstname . ' ' . $lastname,
                        'hfusa-donor_email' => $email,
                        'hfusa-donor_phone' => $phone,
                        'hfusa-donor_state' => $state,
                        'hfusa-donation_order_id' => '',
                        'hfusa-pledge_promise_date' => $pledge_promise_date,
                        'hfusa-transaction_ref_code' => $ref_code,
                        'hfusa-donor_billing_email' => $billing_email,
                        'hfusa-customer_id' => $customerID,
                        'hfusa-pledge_recurrence' => $rec_period,
                        'hfusa-pledge_recursive_amount' => $pledge_total
                    )
                )
            );

        }


        $output["success"] = true;
        $output["post_id"] = $donation_id;
        $output["ref_code"] = $ref_code;
        $output["message"] = "Donation recorded successfully.";

    }

    if (!empty($_POST['donation_method']) && $_POST['donation_method'] == 'credit_card') {

        $donorInfo = array(
            'firstname' => $billing_firstname,
            'lastname' => $billing_lastname,
            'email' => $billing_email,
            'city' => $billing_city,
            'state' => $billing_state,
            'zip' => $billing_zip,
            'address' => $billing_address,
            'campaign_id' => $campaign_id,
            'donation_amount' => $donation_amount,
            'last4' => $last4,

        );

        hf_stripe_payment_mail($donorInfo);

    } else if (!empty($_POST['donation_type']) && $_POST['donation_type'] == 'pledge') {

        $donorInfo = array(
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => $email,
            'donation_amount' => $donation_amount
        );

        hf_pledge_promise_mail($donorInfo);
    }

    return $output;
}


function hf_stripe_payment_mail($donorInfo)
{

    $campaign_id = $donorInfo['campaign_id'];
    $firstname = $donorInfo['firstname'];
    $lastname = $donorInfo['lastname'];
    $address = $donorInfo['address'];
    $city = $donorInfo['city'];
    $state = $donorInfo['state'];
    $zip = $donorInfo['zip'];
    $last4 = $donorInfo['last4'];
    $donation_amount = $donorInfo['donation_amount'];
    $sendTo = $donorInfo['email'];

    /* $campaignTitle = get_the_title( $campaign_id );
    $start_date = get_post_meta( $campaign_id, 'hfusa-start_date', true );*/
    $date = date("Y-m-d");
    $mailBody = '';
    $mailBody .= '<p>Dear ' . $firstname . ' ' . $lastname . '</p>';
    $mailBody .= '<p>Thank you for donating to Humanity First "6th Annual Live Telethon" held on December 1, 2018.</p>';
    $mailBody .= '<p>This confirms the receipt of $' . $donation_amount . ' made by credit card XXXX-XXXX-XXXX-' . $last4 . ' on ' . $date . '.</p>';
    $mailBody .= '<p>We have the following billing address noted:</p>';
    $mailBody .= '<p>' . $address;
    $mailBody .= '<br>' . $city . ', ' . $state . ', ' . $zip . '</p>';
    $mailBody .= '<p>For tax purposes, please keep this written acknowledgment of your donation to Humanity First, USA. Humanity First, USA is a leading Disaster Relief and Human Development Organization registered with the IRS under the Internal Revenue Code, section 501(c)(3), EIN# 20-0464012.</p>';
    $mailBody .= '<p>No goods or services were provided in exchange for this donation.</p>';
    $mailBody .= '<p>Thank you again for your contribution, and if you would like further information about our organization, please visit our website at <a href="http://usa.humanityfirst.org">http://usa.humanityfirst.org</a>.</p>';
    $headers = array('Content-Type: text/html; charset=UTF-8');
    $emailSent = wp_mail($sendTo, 'Payment Confirmation', $mailBody, $headers);
}


function hf_pledge_promise_mail($donorInfo)
{

    $firstname = $donorInfo['firstname'];
    $lastname = $donorInfo['lastname'];
    $donation_amount = $donorInfo['donation_amount'];
    $sendTo = $donorInfo['email'];
    $eventID = $donorInfo['event_id'];
    $eventName = get_the_title($eventID);

    $mailBody = '';
    $mailBody .= '<p>Dear ' . $firstname . ' ' . $lastname . '</p>';
    $mailBody .= '<p>Thank you for registering your pledge of $' . $donation_amount . ' to support Humanity First USA\'s '.$eventName.'.</p>';
    $mailBody .= '<p>The support from donors like you, allows Humanity First USA to offer assistance and help to the needy.  We look forward to receiving your donation. If you have any questions, please reach us at <a href="mailto:info@us.humanityfirst.org">info@us.humanityfirst.org</a>.</p>';

    $mailBody .= '<p>Sincerely,</p>';
    $mailBody .= '<p>Humanity First USA</p>';

    $headers = array('Content-Type: text/html; charset=UTF-8');
    $emailSent = wp_mail($sendTo, 'Payment Confirmation', $mailBody, $headers);
}

function hf_load_more_events()
{

    $offset = isset($_POST['offset']) ? $_POST['offset'] : 0;
    $loop = new WP_Query(
        array(
            'post_type' => 'hf_events',
            'post_status' => 'publish',
            'posts_per_page' => 3,
            'order' => 'ASC',
            'meta_key' => 'hfusa-event_date',
            'orderby' => 'meta_value',
            'offset' => $offset
        )
    );

    ob_start();

    while ($loop->have_posts()) : $loop->the_post();
        $postId = get_the_ID();
        ?>
        <!-- FS Item -->
        <div class="fs-item">
            <div class="fs-item-img">
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php echo get_the_post_thumbnail_url($postId, 'hf-custom-size-1'); ?>"
                         alt="<?php the_title(); ?>"/>
                </a>
            </div>
            <h3>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
            </h3>
        </div>
        <!-- ./FS Item -->
    <?php
    endwhile;
    echo ob_get_clean();
    exit;
}

add_action('wp_ajax_hf_load_more_events', 'hf_load_more_events');
add_action('wp_ajax_nopriv_hf_load_more_events', 'hf_load_more_events');
if (!function_exists("get_the_slug")) {
    /**
     * Returns the page or post slug.
     *
     * @param int|WP_Post|null $id (Optional) Post ID or post object. Defaults to global $post.
     * @return string
     */
    function get_the_slug($id = null)
    {
        $post = get_post($id);
        if (!empty($post)) return $post->post_name;
        return ''; // No global $post var or matching ID available.
    }

    /**
     * Display the page or post slug
     *
     * Uses get_the_slug() and applies 'the_slug' filter.
     *
     * @param int|WP_Post|null $id (Optional) Post ID or post object. Defaults to global $post.
     */
    function the_slug($id = null)
    {
        echo apply_filters('the_slug', get_the_slug($id));
    }
}
function loadMoreBlogPosts()
{
    $offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
    $posts = new WP_Query(
        array(
            'post_type' => 'post',
            'post_status' => 'publish',
            'posts_per_page' => 28,
            'offset' => $offset,
            'category_name' => array('blog', 'gift-of-sight')
        )
    );
    $html = '';
    while ($posts->have_posts()) : $posts->the_post();
        $category_names = "";
        foreach ((get_the_category()) as $category) {
            $category_names .= " " . $category->slug;
        }
        $html .= '<div class="hf-grid-item col-lg-3 col-md-6 col-sm-12' . $category_names . '">
                        <div class="hf-gl-item">
                            <div class="hf-gl-wrapper" style="display: flex; flex-direction: column;">
                                <div class="hf-gl-item-cat">';
        if (in_category('Featured')) {
            $html .= '<span class="post-on blog-date"><i class="fa fa-clock-o"></i> ' . get_the_date() . '</span>
                                                    <span class="featured-tag"><i class="fa fa-bookmark-o"></i> Featured</span>';

        } elseif (in_category('Popular')) {
            $html .= '<span class="post-on blog-date"><i class="fa fa-clock-o"></i> ' . get_the_date() . '</span>
                                                    <span class="popular-tag"><i class="fa fa-bolt"></i> Popular</span>';

        } else {
            $html .= '<span class="post-on"><i
                                                    class="fa fa-clock-o"></i> ' . get_the_date() . '</span>';

        }
        $tumblrID = get_post_meta(get_the_ID(), '_tumblr_ID', true);

        if ($tumblrID != '') {
            $html .= '<span class="tumblr-post"><i class="fa fa-tumblr-square"></i></span>';
        }

        $html .= '</div>
                                <div class="hf-gl-item-text">
                                    ' . get_the_excerpt() . '
                                </div>';
        if (has_post_thumbnail(get_the_ID())) {
            $html .= '<div class="hf-gl-item-img" style="margin-top: auto;">
                                        <a href="' . get_the_permalink() . '">
                                            <img src="' . get_the_post_thumbnail_url() . '"
                                                 alt="' . get_the_title() . '"/>
                                        </a>
                                    </div>';
        }
        $html .= '<h2 class="hf-gl-item-heading" style="margin-top: 0;">
                                    <a href="' . get_the_permalink() . '">' . get_the_title() . '</a>
                                </h2>
                                <div class="hf-gl-item-meta" style="margin-top: 0;">
                                    <span class="post-by"><i
                                                class="fa fa-user-circle"></i>' . get_the_author() . '</span>
                                    <div class="share-post-div">
                                        <a href="#!" id="open-share-list" class="open-share-list"> <span
                                                    class="post-share"><i class="fa fa-share-alt"></i></span></a>
                                        <div id="share-icons-list" class="share-icons-list">
                                            <ul class="social-list">
                                                <li>
                                                    <a href="https://www.facebook.com/sharer/sharer.php?u=' . get_the_permalink() . '"
                                                       class="facebook" target="_blank"><span
                                                                class="social-border"></span><i class="fa fa-facebook"
                                                                                                aria-hidden="true"></i></a>
                                                </li>
                                                <li>
                                                    <a href="https://twitter.com/home?status=' . get_the_permalink() . '"
                                                       class="twitter" target="_blank"><span
                                                                class="social-border"></span><i class="fa fa-twitter"
                                                                                                aria-hidden="true"></i></a>
                                                </li>
                                                <li>
                                                    <a href="https://www.linkedin.com/shareArticle?mini=true&url=' . get_the_permalink() . '&title=' . get_the_title() . '&summary=&source="
                                                       class="linkedin" target="_blank"><span
                                                                class="social-border"></span><i class="fa fa-linkedin"
                                                                                                aria-hidden="true"></i></a>
                                                </li>
                                                <li>
                                                    <a href="https://plus.google.com/share?url=' . get_the_permalink() . '"
                                                       class="google-plus" target="_blank"><span
                                                                class="social-border"></span><i
                                                                class="fa fa-google-plus" aria-hidden="true"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>';
    endwhile;
    wp_send_json(array('response' => $html));
    wp_die();
}

add_action('wp_ajax_get-blog-posts', 'loadMoreBlogPosts');
add_action('wp_ajax_nopriv_get-blog-posts', 'loadMoreBlogPosts');


/******************************************
 * SHOW ALL ROOMS IN FIELD WITH KEY "ROOMS"
 ******************************************/
add_filter( 'ninja_forms_render_options', function($options,$settings){
  if( $settings['key'] == 'package' ){
    $taxonomies = get_terms( array(
      'taxonomy' => 'sponsor_category',
      'meta_key' => 'weightage',
      'orderby' => 'meta_value',
      'order' => 'DESC',
      'hide_empty' => false
    ) );

    if ( !empty($taxonomies) ) :
      foreach ($taxonomies as $category) {
        $price = get_field('weightage',$category);
        $options[] = array('label' => $category->name.' ( $'.$price.' )', 'value' => $category->term_id);
      }

      endif;
  }
  return $options;
},10,2);

/**
 * @tag my_ninja_forms_processing
 * @callback my_ninja_forms_processing_callback
 */
add_action( 'become_event_sponsor_processing', 'become_event_sponsor_processing_callback' );
/**
 * @param $form_data array
 * @return void
 */
function become_event_sponsor_processing_callback( $form_data ){
  $form_id       = $form_data[ 'form_id' ];
  $form_fields   =  $form_data[ 'fields' ];

 $email = '';
 $firstName = '';
 $lastName = '';
 $phone = '';
 $package = '';
 $content = '';
 $eventID = '';
 $companyName = '';
  $featuredImage='';
  foreach( $form_fields as $field ){
        if($field['key'] == 'email'){
          $email = $field['value'];
        }
        if($field['key'] == 'first_name'){
          $firstName = $field['value'];
        }
        if($field['key'] == 'last_name'){
          $lastName = $field['value'];
        }
        if($field['key'] == 'package'){
          $package = $field['value'];
        }
        if($field['key'] == 'company_name'){
          $companyName = $field['value'];
        }
        if($field['key'] == 'phone'){
          $phone = $field['value'];
        }
        if($field['key'] == 'text'){
          $content = $field['value'];
        }
        if($field['key'] == 'event_id'){
          $eventID = $field['value'];
        }
        if($field['key'] == 'logo'){
          $featuredImage = $field['files'][0]['data']['attachment_id'];
        }
  }
  $args = array(
    'post_title'    => wp_strip_all_tags( $firstName .' '. $lastName ),
    'post_content'  => $content,
    'post_status'   => 'draft',
    'post_type' => 'hf_sponsors'
  );
  $sponsorID = wp_insert_post($args);
  $taxonomy = 'sponsor_category';
  $termObj  = get_term_by( 'id', $package, $taxonomy);
  wp_set_object_terms($sponsorID, $termObj->slug, $taxonomy);
  set_post_thumbnail($sponsorID, $featuredImage);
  update_post_meta($sponsorID, 'hfusa-sponsor_email', $email);
  update_post_meta($sponsorID, 'hfusa-sponsor_phone', $phone);
  update_post_meta($sponsorID, 'hfusa-sponsor_company', $companyName);
  update_post_meta($sponsorID, 'hfusa-sponsor_event', $eventID);
}

/**
 * @tag my_ninja_forms_processing
 * @callback my_ninja_forms_processing_callback
 */
add_action( 'pledge_form_processing', 'pledge_form_processing_callback' );
/**
 * @param $form_data array
 * @return void
 */
function pledge_form_processing_callback( $form_data ){

    $form_id       = $form_data[ 'form_id' ];
    $form_fields   =  $form_data[ 'fields' ];

    $email = '';
    $firstName = '';
    $middleName = '';
    $lastName = '';
    $phone = '';
    $address = '';
    $city = '';
    $state = '';
    $zip = '';
    $pledge_amount = '';
    $pledge_promise_date = '';
    $humanity_first_ambassador = '';
    $eventID = '';
    foreach( $form_fields as $field ){
        if($field['key'] == 'email'){
          $email = $field['value'];
        }
        if($field['key'] == 'first_name'){
          $firstName = $field['value'];
        }
        if($field['key'] == 'middle_name'){
          $middleName = $field['value'];
        }
        if($field['key'] == 'last_name'){
          $lastName = $field['value'];
        }
        if($field['key'] == 'phone'){
          $phone = $field['value'];
        }
        if($field['key'] == 'address'){
          $address = $field['value'];
        }
        if($field['key'] == 'city'){
          $city = $field['value'];
        }
        if($field['key'] == 'state'){
          $state = $field['value'];
        }
        if($field['key'] == 'zip'){
          $zip = $field['value'];
        }
        if($field['key'] == 'pledge_amount'){
          $pledge_amount = $field['value'];
        }
        if($field['key'] == 'planned_payment_date'){
          $pledge_promise_date = $field['value'];
        }
        if($field['key'] == 'humanity_first_ambassador'){
          $humanity_first_ambassador = $field['value'];
        }
        if($field['key'] == 'event_id'){
          $eventID = $field['value'];
        }
    }

    $user_name = $firstName . " ". $middleName . " ". $lastName;

    $campaignID = get_post_meta($eventID, 'hfusa-event_campaigns', true);
    $classyCampaignID = get_post_meta($campaignID, 'hfusa-classy_campaign_id', true);

    global $wpdb;

    $table = $wpdb->prefix.'hf_classy_donations';

    $wpdb->insert(
        $table, 
        array( 
            'classy_id' => $classyCampaignID,
            'donation_type' => 'Pledge',
            'donation_amount' => $pledge_amount,
            'donor_name' => $user_name,
            'donor_email' => $email,
            'donor_phone' => $phone,
            'address' => $address,
            'donor_state' => $state,
            'hf_ambassador' => $humanity_first_ambassador,
            'pledge_promise_date' => $pledge_promise_date,
            'source' => 'WEB',
            'created_at' => date('Y-m-d H:i:s'),
        )
    );

    $donorInfo = array(
        'firstname' => $firstName,
        'lastname' => $lastName,
        'email' => $email,
        'donation_amount' => $pledge_amount,
        'event_id' => $eventID
    );

    hf_pledge_promise_mail($donorInfo);
}

class My_Walker_Nav_Menu extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n<div class='dropdown-menu'><div class='container'><div class='header-large'><div class='large-header-navigation'>$indent<ul>\n";
    }

    function end_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul></div></div></div></div>\n";
    }
}

function atg_menu_classes($classes, $item, $args) {
    if($args->theme_location == 'primary' && $args->walker->has_children) {
        if($item->title == 'About Us') {
            $classes[] = 'forAboutSlide';
        } else if($item->title == 'Our Work') {
            $classes[] = 'forWorkSlide';
        } else if($item->title == 'Our Impact') {
            $classes[] = 'forImpactSlide';
        } else if($item->title == 'Current Happenings') {
            $classes[] = 'forHappeningSlide';
        } else if($item->title == 'Multimedia') {
            $classes[] = 'forResourcesSlide';
        } else if($item->title == 'Get Involved') {
            $classes[] = 'forInvolvedSlide';
        }
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'atg_menu_classes', 1, 3);

function get_google_places() {

    require('google-places-php-sdk/vendor/autoload.php');

    $client = new \GooglePlaces\Client('AIzaSyCmymtMMWazm6fELKK3rBWAtzHd4yL3TEs');

    $files = glob(get_stylesheet_directory().'/google-places-images/*'); // get all file names
    foreach($files as $file){ // iterate files
      if(is_file($file))
        unlink($file); // delete file
    }

    if(isset($_POST['search'])) {
        // find all movie theaters in this zip code
        $places = $client->placeSearch('textsearch')->setOptions([
            'query' => $_POST['search']
        ])->request();

        $htmlString = "<div class='mt-3'>";
        if(!empty($places)) {

            foreach ($places as $place) {
                $img = '';
                if(isset($place['photos'])) {
                    $photoId = $place['photos'][0]['photo_reference'];
                    $photo = $client->placePhotos($photoId,[450,450])->request();
                    $img = $photo->save(get_stylesheet_directory().'/google-places-images');
                }
                $htmlString .= "<article class='place-wrapper' id='".$place['place_id']."'>";
                $htmlString .= "<div class='info-wrapper'>";
                $htmlString .= "<div class='name'>".$place['name']."</div>";
                $fraction = $place['rating'] - floor($place['rating']);
                $number = $place['rating'] - $fraction;
                $stars = '';
                $count = 0;
                while($number) {
                    $stars .= "<i class='fa fa-star'></i>";
                    $count++;
                    $number--;
                }
                if(round($fraction, 2) > 0.20 && round($fraction, 2) < 0.80) {
                    $stars .= "<i class='fa fa-star-half-o'></i>";
                    $count++;
                } elseif(round($fraction, 2) > 0.70) {
                    $stars .= "<i class='fa fa-star'></i>";
                    $count++;
                }
                $diff = 5 - $count;
                while ($diff) {
                    $stars .= "<i class='fa fa-star-o'></i>";
                    $diff--;
                }
                $htmlString .= "<div class='rating'><span>".$place['rating']."</span><span class='stars'>".$stars."</span> <span>(".$place['user_ratings_total'].")</span></div>";
                $htmlString .= "<div class='address'>".$place['formatted_address']."</div>";
                $htmlString .= "</div>";
                $htmlString .= "<div class='image'>";
                if($img != '') {
                    $htmlString .= "<img src='".get_stylesheet_directory_uri()."/google-places-images/".$img."'>";
                }
                $htmlString .= "</div>";
                $htmlString .= "</article>";
            }
        } else {
            $htmlString .= "<div class='text-center'><em>No results found!</em></div>";
        }
        $htmlString .= "</div>";
        echo json_encode($htmlString);

    } elseif (isset($_POST['placeId'])) {
        $placeId  = $_POST['placeId'];
        $placeDetails = $client->placeDetails($placeId)->request();
        echo json_encode($placeDetails);
    }
    exit;
}

add_action('wp_ajax_get_google_places', 'get_google_places');
add_action('wp_ajax_nopriv_get_google_places', 'get_google_places');

function get_speaker_details() {
    $response = array();
    if(isset($_POST['speakerID'])) {
        $stylesheetDirectory = get_stylesheet_directory_uri();
        $id = $_POST['speakerID'];
        $avatar = get_the_post_thumbnail_url($id);
        if( empty($avatar) ) {
            $avatar = $stylesheetDirectory.'/assets/images/default-avatar.png';
        }
        $response['avatar'] = $avatar;
        $response['title'] = get_the_title($id);
        $response['designation'] = get_post_meta($id, 'hfusa-speaker_designation', true);
        $post_data = get_post($id);
        $content = apply_filters('the_content', $post_data->post_content);
        $response['bio'] = $content;
    }
    echo json_encode($response);
    exit;
}

add_action('wp_ajax_get_speaker_details', 'get_speaker_details');
add_action('wp_ajax_nopriv_get_speaker_details', 'get_speaker_details');

function covidmap_function() {

    global $hf_us_state_abbrevs_names;

    global $wpdb;

    $arrayCodes = array();
    $i=0;
    foreach ($hf_us_state_abbrevs_names as $key => $value) {
        $value = strtolower($value);
        $value = str_replace(" ", "-", $value);
        $arrayCodes[$i]["code"] = strtolower($key);
        $arrayCodes[$i]["total"] = "--";
        $arrayCodes[$i]["positive"] = "--";
        $arrayCodes[$i]["value"] = 0;
        $arrayCodes[$i]["negative"] = "--";
        $arrayCodes[$i]["deaths"] = "--";
        $arrayCodes[$i]["hospitalized"] = "--";
        $arrayCodes[$i]["lastUpdateEt"] = "--";
        $arrayCodes[$i]["name"] = $value;
        $i++;
    }

    $recordsData = hf_covid_19_state_records();

    wp_localize_script( 'sage/js', 'covid_object', array( 'arrayCodes' => json_encode($arrayCodes), 'recordsData' => $recordsData ) );

    $disclaimer = "";

    $lastUpdated = $wpdb->get_var("SELECT start_time FROM {$wpdb->prefix}hf_covid_19_cron_log ORDER BY id DESC LIMIT 1");

    if(!empty($lastUpdated)) {
        $disclaimer .= "<p>Data source may be updated more regularly. For most current data, visit <a href='https://coronavirus.jhu.edu/map.html' target='_blank' rel='noopener'>JHU</a></p>";
        $disclaimer .= "<p>Website data was last updated at: ".date('m/d/Y H:i:s', strtotime($lastUpdated))." GMT</p>";
    }

    $string = "<div class='interactive-map-container mb-5'><div id='container-maps' class='states-map-inner'></div><div class='disclaimer'>$disclaimer</div></div>";
    return $string;
}

add_shortcode('COVIDMAP', 'covidmap_function');

function covidtable_function() {
    global $wpdb;
    $top_states = $wpdb->get_results("SELECT `state`, `positive`, `death`, `hospitalized` FROM {$wpdb->prefix}hf_covid_19_records GROUP BY `state` ORDER BY positive DESC LIMIT 10", ARRAY_A);

    $string = "<div class='table-responsive'><table class='table table-sm'><caption>Top 10 most affected States</caption><thead><tr><th>State</th><th class='text-center'>Positive</th><th class='text-center'>Deaths</th><th class='text-center'>Hospitalized</th></tr></thead><tbody>";
                            
    foreach ($top_states as $top_state) {

        $string .= "<tr><td>";
        $string .= $top_state['state'];
        $string .= "</td><td class='text-center'>";
        $string .= number_format($top_state['positive']);
        $string .= "</td><td class='text-center'>";
        $string .= number_format($top_state['death']);
        $string .= "</td><td class='text-center'>";

        if(is_null($top_state['hospitalized'])) {
            $string .= "-";
        } else {
            $string .= number_format($top_state['hospitalized']);
        }

        $string .= "</td></tr>";
    }

    $string .= "</tbody></table></div>";

    return $string;
}

add_shortcode('COVIDTABLE', 'covidtable_function');

function covidstats_function() {
    global $wpdb;
    $results = $wpdb->get_results("SELECT SUM(totalTestResults) as total, SUM(positive) as positive, SUM(negative) as negative, SUM(death) as death FROM {$wpdb->prefix}hf_covid_19_records", ARRAY_A);
    $results = reset($results);

    $string .= "<section class='covid-map-section p-0'><div class='right-stats-wrapper h-100'><div class='row justify-content-center'><div class='col-12'><div class='right-stat' style='background: #6c757d;'><div class='figure'>";
    $string .= number_format($results['total']);
    $string .= "</div><div class='caption'>Total Test Results</div></div><div class='right-stats-wrapper h-100'><div class='row justify-content-center'><div class='col-12'><div class='right-stat' style='background: #ffc107;'><div class='figure'>";
    $string .= number_format($results['positive']);
    $string .= "</div><div class='caption'>Positive</div></div><div class='right-stats-wrapper h-100'><div class='row justify-content-center'><div class='col-12'><div class='right-stat' style='background: #3fa332;'><div class='figure'>";
    $string .= number_format($results['negative']);
    $string .= "</div><div class='caption'>Negative</div></div><div class='right-stats-wrapper h-100'><div class='row justify-content-center'><div class='col-12'><div class='right-stat' style='background: #dc3545;'><div class='figure'>";
    $string .= number_format($results['death']);
    $string .= "</div><div class='caption'>Deaths</div></div></div><div class='disclaimer'></div></div></div></section>";

    return $string;
}

add_shortcode('COVIDSTATS', 'covidstats_function');

function telethon_stats() {
    $telethonEventID = 15288;
    $event_sponsors=get_post_meta( $telethonEventID, 'hfusa-event_sponsors' );
    $event_speakers=get_post_meta( $telethonEventID, 'hfusa-event_speakers' );
    $event_guests=get_post_meta( $telethonEventID, 'hfusa-event_guests' );

    $campaignID = get_post_meta( $telethonEventID, 'hfusa-event_campaigns',true );
    $classyCampaignID = get_post_meta( $campaignID, 'hfusa-classy_campaign_id',true );

    $pledged = totalTelethonDonations($classyCampaignID,'Pledge',true);
    $donated = totalTelethonDonations($classyCampaignID,'Donation',true);

    // Classy API
    require_once 'framework/classy-php-sdk/vendor/autoload.php';

    $client = new \Classy\Client([
        'client_id'     => 'ngVpuzzCKcldwe2x',
        'client_secret' => 'QwtBc22E4F068HyU',
        'version'       => '2.0' // version of the API to be used
    ]);

    $session = $client->newAppSession();


    // Get information regarding campaign
    try {
        $campaign_overview = $client->get('/campaigns/'.$classyCampaignID.'/overview', $session);
    } catch (\Classy\Exceptions\APIResponseException $e) {
        // Get the HTTP response code
        $code = $e->getCode();
        // echo $code;
        // Get the response content
        $content = $e->getResponseData();
        // echo $content;
        // Get the response headers
        $headers = $e->getResponseHeaders();
        // echo $headers;
    }
    // Get information regarding campaign
    try {
        $campaign_data = $client->get('/campaigns/'.$classyCampaignID, $session);
    } catch (\Classy\Exceptions\APIResponseException $e) {
        // Get the HTTP response code
        $code = $e->getCode();
        // echo $code;
        // Get the response content
        $content = $e->getResponseData();
        // echo $content;
        // Get the response headers
        $headers = $e->getResponseHeaders();
        // echo $headers;
    }

    ob_start();
    ?>
    <section class="t-map-section">
        <div class="th-bottom-large-navgation" >
            <div id="statistics" class="donation-target-status donation-target-status-telethon" style="<?php echo (!empty(get_post_meta( $telethonEventID, 'hfusa-stats_bar_color' ))) ? 'background-color: '.get_post_meta( $telethonEventID, 'hfusa-stats_bar_color', true ) : ''; ?>">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 mb-3 mb-md-0 text-left">
                            <div class="d-inline-block telethon-hero-boxes-icons">
                                <div class="icon-container float-left">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-bullseye.png" alt="" />
                                </div>
                                <div class="dts-figures float-left">
                                    <h4>USD<span><?php echo nice_number($campaign_data->goal); ?></span></h4>
                                    <h6>TARGET</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-3 mb-md-0 text-left">
                            <div class="d-inline-block telethon-hero-boxes-icons">
                                <div class="icon-container float-left">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-donation.png" alt="" />
                                </div>
                                <div class="dts-figures float-left">
                                    <h4>USD<span class="donations-collected">
                                        <?php echo nice_number($campaign_overview->donations_amount); ?></span>
                                    </h4>
                                    <h6>DONATIONS</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 text-right">
                            <div class="d-inline-block telethon-hero-boxes-icons">
                                <div class="icon-container float-left">
                                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/dts-pledged.png" alt="" />
                                </div>
                                <div class="dts-figures float-left">
                                    <h4>USD<span id=""><?php echo $pledged; ?></span></h4>
                                    <h6 class="text-left">PLEDGED</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="total-donations" style="<?php echo (!empty(get_post_meta( $telethonEventID, 'hfusa-progress_bar_color' ))) ? 'background-color: '.get_post_meta( $telethonEventID, 'hfusa-progress_bar_color', true ) : ''; ?>">
            <div class="container">
                <div class="figures">
                    <?php $totalCollected = $campaign_overview->donations_amount + totalTelethonDonations($classyCampaignID,'Pledge',false); ?>
                    <div class="float-left">$<?php echo number_format($totalCollected); ?> Raised</div>
                    <div class="float-right text-right">$<?php echo nice_number($campaign_data->goal); ?> Goal</div>
                </div>
                <div class="clearfix"></div>
                <div class="progress-bar">
                    <div class="scrolling-bar" style="width: <?php echo (($totalCollected / $campaign_data->goal) * 100).'%'; ?>"></div>
                </div>
            </div>
        </div>
    </section>
    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode('TELETHON_STATS', 'telethon_stats');

function campaign_stats() {
    global $hf_us_state_abbrevs_names;

    $campaignID = 15286;

    $stylesheetDirectory = get_stylesheet_directory_uri();
    $classyCampaignID = get_post_meta( $campaignID, 'hfusa-classy_campaign_id', true );

    $pledged = totalTelethonDonations($classyCampaignID,'Pledge',false);

    // Classy API
    require_once 'framework/classy-php-sdk/vendor/autoload.php';

    $client = new \Classy\Client([
      'client_id'     => 'ngVpuzzCKcldwe2x',
      'client_secret' => 'QwtBc22E4F068HyU',
      'version'       => '2.0' // version of the API to be used
    ]);

    $session = $client->newAppSession();


    // Get information regarding campaign
    try {
      $campaign_overview = $client->get('/campaigns/'.$classyCampaignID.'/overview', $session);
    } catch (\Classy\Exceptions\APIResponseException $e) {
        // Get the HTTP response code
      $code = $e->getCode();
        // echo $code;
        // Get the response content
      $content = $e->getResponseData();
        // echo $content;
        // Get the response headers
      $headers = $e->getResponseHeaders();
        // echo $headers;
    }
    try {
      $campaign_data = $client->get('/campaigns/'.$classyCampaignID, $session);
    } catch (\Classy\Exceptions\APIResponseException $e) {
        // Get the HTTP response code
      $code = $e->getCode();
        // echo $code;
        // Get the response content
      $content = $e->getResponseData();
        // echo $content;
        // Get the response headers
      $headers = $e->getResponseHeaders();
        // echo $headers;
    }

    $totalCollected = $campaign_overview->total_gross_amount + totalTelethonDonations($classyCampaignID,'Pledge',false);

    global $wpdb;
    $top_states_donations = $wpdb->get_results("SELECT DISTINCT `donor_state`, SUM(`donation_amount`) as total FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success' AND `donor_state` IS NOT NULL GROUP BY `donor_state` ORDER BY total DESC LIMIT 5", ARRAY_A);
    for ($i=0; $i<count($top_states_donations); $i++) {
      $pledge_total = $wpdb->get_var("SELECT SUM(`donation_amount`) FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Pledge' AND `donor_state`='".$top_states_donations[$i]['donor_state']."'");
      if(empty($pledge_total)) {
        $pledge_total = 0;
      }
      $top_states_donations[$i]['pledge_total'] = $pledge_total;
    }
    $avg_donation = $wpdb->get_var("SELECT AVG(`donation_amount`) as average_donation FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success'");
    $highest_donation = $wpdb->get_var("SELECT `donation_amount` FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success' ORDER BY `donation_amount` DESC LIMIT 1");

    $states = array();
    $values = array();
    $pledge_values = array();
    foreach ($top_states_donations as $top_state) {
      $states[] = $top_state['donor_state'];
      $values[] = $top_state['total'];
      $pledge_values[] = $top_state['pledge_total'];
    }

    ob_start();
    ?>
    <input type="hidden" name="isCampaignStats" id="isCampaignStats" value="true">
    <input type="hidden" name="states" id="states" value='<?php echo json_encode($states); ?>'>
    <input type="hidden" name="values" id="values" value='<?php echo json_encode($values); ?>'>
    <input type="hidden" name="pledge_values" id="pledge_values" value='<?php echo json_encode($pledge_values); ?>'>
    <input type="hidden" name="totalCollected" id="totalCollected" value="<?php echo nice_number($totalCollected); ?>">
    <input type="hidden" name="totalDonations" id="totalDonations" value="<?php echo nice_number($campaign_overview->total_gross_amount); ?>">
    <input type="hidden" name="percent_donations" id="percent_donations" value="<?php echo ($campaign_overview->total_gross_amount / $campaign_data->goal) * 100; ?>">
    <input type="hidden" name="percent_pledges" id="percent_pledges" value="<?php echo ($pledged / $campaign_data->goal) * 100; ?>">
    <input type="hidden" name="percent_total" id="percent_total" value="<?php echo ($totalCollected / $campaign_data->goal) * 100; ?>">
    <input type="hidden" name="goal" id="goal" value="<?php echo nice_number($campaign_data->goal); ?>">
    <!--Donation Stats Box Section Start-->
    <section id="stats" class="stats-section features-area item-full text-center cell-items default-padding mb-5">
      <div class="container">
        <div class="row features-items">
          <div class="col-lg-3 col-md-6 col-sm-12 equal-height">
            <div class="item">
              <div class="icon">
                <i class="fa fa-usd"></i>
              </div>
              <div class="info">
                <h3>$<?php echo nice_number($totalCollected); ?></h3>
                <p>Total Raised</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12 equal-height">
            <div class="item">
              <div class="icon">
                <i class="fa fa-university"></i>
              </div>
              <div class="info">
                <h3><?php echo $campaign_overview->transactions_count; ?></h3>
                <p>Total Transactions</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12 equal-height">
            <div class="item">
              <div class="icon">
                <i class="fa fa-bar-chart"></i>
              </div>
              <div class="info">
                <h3>$<?php echo number_format($avg_donation, 2); ?></h3>
                <p>Avg. Donation Amount</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-12 equal-height">
            <div class="item">
              <div class="icon">
                <i class="fa fa-line-chart"></i>
              </div>
              <div class="info">
                <h3>$<?php echo nice_number(str_replace('.00', '', $highest_donation)); ?></h3>
                <p>Highest Donation Amount</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--Donation Stats Box Section End-->
    <!--============================
    =            Graphs            =
    =============================-->

    <div class="section" id="graphs">
      <div class="container">
        <div class="row">
          <div class="col-lg-6 col-md-12">
            <?php $states_heading = rwmb_meta('hfusa-top_five_states_heading', '', $campaignID); ?>
            <h1 class="underlined-heading capital"><?php echo (!empty($states_heading)) ? $states_heading : 'Top 5 States'; ?></h1>
            <div id="chart"></div>
          </div>
          <div class="col-lg-6 col-md-12">
            <?php $donations_heading = rwmb_meta('hfusa-donations_collected_heading', '', $campaignID); ?>
            <h1 class="underlined-heading capital"><?php echo (!empty($donations_heading)) ? $donations_heading : 'Donations Collected'; ?></h1>
            <div id="radialChart"></div>
          </div>
        </div>
      </div>
    </div>

    <!--====  End of Graphs  ====-->

    <input type="hidden" name="hf_us_state_abbrevs_names" id="hf_us_state_abbrevs_names" value='<?php echo json_encode($hf_us_state_abbrevs_names); ?>'>

    <?php
    $content = ob_get_contents();
    ob_end_clean();
    return $content;
}

add_shortcode('CAMPAIGN_STATS', 'campaign_stats');

function fetch_top_fundraisers() {
    global $wpdb;

    $classyCampaignID = $_POST['classyCampaignID'];
    $telethonEventID = $_POST['telethonEventID'];

    $content = '';

    $is_teams = false;
    $is_pages = false;

    $top_fundraiser_teams = $wpdb->get_results("SELECT DISTINCT `fundraising_team_id`, SUM(`donation_amount`) as total FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success' AND `fundraising_team_id` IS NOT NULL GROUP BY `fundraising_team_id` ORDER BY total DESC", ARRAY_A);
    $top_fundraiser_pages = $wpdb->get_results("SELECT DISTINCT `fundraising_page_id`, SUM(`donation_amount`) as total FROM {$wpdb->prefix}hf_classy_donations WHERE `classy_id`=$classyCampaignID AND `donation_type`='Donation' AND `status`='success' AND `fundraising_page_id` IS NOT NULL GROUP BY `fundraising_page_id` ORDER BY total DESC", ARRAY_A);

    if($top_fundraiser_teams) {
        $is_teams = true;
    }
    if($top_fundraiser_pages) {
        $is_pages = true;
    }

    if($is_teams || $is_pages) {

        // Classy API
        require_once 'framework/classy-php-sdk/vendor/autoload.php';

        $client = new \Classy\Client([
            'client_id'     => 'ngVpuzzCKcldwe2x',
            'client_secret' => 'QwtBc22E4F068HyU',
            'version'       => '2.0' // version of the API to be used
        ]);

        $session = $client->newAppSession();
        ob_start();
    ?>

    <div class="th-bottom-large-navgation" >
        <div class="container">
            <div class="row">
                <?php if($is_teams) { ?>
                <div class="col-lg-6 col-md-12 col-sm-12 mb-md-3">
                    <div class="top-teams">
                        <h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_teams_heading', '' , $telethonEventID); ?></h1>
                        <div class="th-content pl-0 mt-4 mCustomScrollbar" style="max-height: 500px;">
                            <?php
                            foreach($top_fundraiser_teams as $fundraiser) {
                                // Get fundraising team
                                try {
                                    $fundraising_team = $client->get('/fundraising-teams/'.$fundraiser['fundraising_team_id'], $session);
                                    // $second_last_page = (int)$campaign_transactions->last_page - 1;
                                    // $campaign_transactions = $client->get('/campaigns/132309/transactions?page='.$campaign_transactions->last_page, $session);
                                } catch (\Classy\Exceptions\APIResponseException $e) {
                                    // Get the HTTP response code
                                    $code = $e->getCode();
                                    echo $code;
                                    // Get the response content
                                    $content = $e->getResponseData();
                                    echo $content;
                                    // Get the response headers
                                    $headers = $e->getResponseHeaders();
                                    echo $headers;
                                }
                                // Get fundraising team
                                try {
                                    $fundraising_team_pages = $client->get('/fundraising-teams/'.$fundraiser['fundraising_team_id'].'/fundraising-pages', $session);
                                    // $second_last_page = (int)$campaign_transactions->last_page - 1;
                                    // $campaign_transactions = $client->get('/campaigns/132309/transactions?page='.$campaign_transactions->last_page, $session);
                                } catch (\Classy\Exceptions\APIResponseException $e) {
                                    // Get the HTTP response code
                                    $code = $e->getCode();
                                    echo $code;
                                    // Get the response content
                                    $content = $e->getResponseData();
                                    echo $content;
                                    // Get the response headers
                                    $headers = $e->getResponseHeaders();
                                    echo $headers;
                                }
                            ?>
                            <div class="item-wrapper">
                                <div class="img-wrapper">
                                    <img src="<?php echo (!empty($fundraising_team->logo_url)) ? $fundraising_team->logo_url : get_stylesheet_directory_uri()."/assets/images/team_default_image.webp"; ?>" alt="">
                                </div>
                                <div class="info-wrapper">
                                    <div class="item-name"><b><?php echo $fundraising_team->name; ?></b></div>
                                    <div class="item-progress-bar">
                                        <?php
                                        $percentage = ($fundraiser['total'] / $fundraising_team->goal) * 100;
                                        ?>
                                        <div class="item-progress" style="width: <?php echo $percentage; ?>%"></div>
                                    </div>
                                    <div class="item-stats"><?php echo '<b>$'.number_format($fundraiser['total'])."</b> raised (".number_format($percentage, 2)."%) ".$fundraising_team_pages->total." members"; ?></div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } else { ?>
                <div class="col-lg-6 col-md-12 col-sm-12 mb-md-3">
                    <h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_teams_heading', '', $telethonEventID); ?></h1>
                    <div class="th-content pl-0 mt-4 mCustomScrollbar" style="max-height: 500px;">
                        <p>No teams to show.</p>
                    </div>
                </div>
                <?php } ?>
                <?php if($is_pages) { ?>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_individuals_heading', '', $telethonEventID); ?></h1>
                    <div class="th-content pl-0 mt-4 mCustomScrollbar" style="max-height: 500px;">
                        <?php
                        foreach($top_fundraiser_pages as $fundraiser) {
                            // Get fundraising team
                            try {
                                $fundraising_page = $client->get('/fundraising-pages/'.$fundraiser['fundraising_page_id'], $session);
                                // $second_last_page = (int)$campaign_transactions->last_page - 1;
                                // $campaign_transactions = $client->get('/campaigns/132309/transactions?page='.$campaign_transactions->last_page, $session);
                            } catch (\Classy\Exceptions\APIResponseException $e) {
                                // Get the HTTP response code
                                $code = $e->getCode();
                                echo $code;
                                // Get the response content
                                $content = $e->getResponseData();
                                echo $content;
                                // Get the response headers
                                $headers = $e->getResponseHeaders();
                                echo $headers;
                            }
                        ?>
                        <div class="item-wrapper">
                            <div class="img-wrapper">
                                <img src="<?php echo $fundraising_page->logo_url; ?>" alt="">
                            </div>
                            <div class="info-wrapper">
                                <div class="item-name"><b><?php echo $fundraising_page->alias; ?></b></div>
                                <div class="item-progress-bar">
                                    <?php
                                    $percentage = ($fundraiser['total'] / $fundraising_page->goal) * 100;
                                    ?>
                                    <div class="item-progress" style="width: <?php echo $percentage; ?>%"></div>
                                </div>
                                <div class="item-stats"><?php echo '<b>$'.number_format($fundraiser['total'])."</b> raised (".number_format($percentage, 2)."%)"; ?></div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
                <?php } else { ?>
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <h1 class="underlined-heading capital"><?php echo rwmb_meta('hfusa-top_individuals_heading', '', $telethonEventID); ?></h1>
                    <div class="th-content pl-0 mt-4 mCustomScrollbar" style="max-height: 500px;">
                        <p>No individuals to show.</p>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>

    <?php

        $content = ob_get_contents();
        ob_end_clean();
    }

    $obj = new stdClass();
    $obj->top_teams = $top_fundraiser_teams;
    $obj->top_pages = $top_fundraiser_pages;
    $obj->content = $content;

    echo json_encode($obj);
    die();
}

add_action('wp_ajax_fetch_top_fundraisers', 'fetch_top_fundraisers'); // ajax for logged in users
add_action('wp_ajax_nopriv_fetch_top_fundraisers', 'fetch_top_fundraisers'); // ajax for not logged in users

function my_enqueuer($my_handle, $relpath, $type='script', $my_deps=array()) {
    $uri = get_theme_file_uri($relpath);
    $vsn = filemtime(get_theme_file_path($relpath));
    if($type == 'script') wp_enqueue_script($my_handle, $uri, $my_deps, $vsn, true);
    else if($type == 'style') wp_enqueue_style($my_handle, $uri, $my_deps, $vsn);      
}

/**
 * Filter the excerpt "read more" string.
 *
 * @param string $more "Read more" excerpt string.
 * @return string (Maybe) modified "read more" excerpt string.
 */
function wpdocs_excerpt_more( $more ) {
    return '...';
}
add_filter( 'excerpt_more', 'wpdocs_excerpt_more' );