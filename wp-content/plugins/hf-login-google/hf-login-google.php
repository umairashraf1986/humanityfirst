<?php
/*
Plugin Name: Humanity First Login with Google
Plugin URI: http://dev.smart-is.com/humanityfirst
Description: Plugin to Login User with Google in HF theme.
Version: 1.0.0
Author: Oracular
Author URI: http://oracular.com
Text Domain: sage
*/
require_once 'src/Google_Client.php';
require_once 'src/contrib/Google_Oauth2Service.php';

function ajax_google_login() {

    if(isset($_GET['domain'])) {
        $domain = $_GET['domain'];
    } else {
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
        if($_SERVER['HTTP_HOST'] == "localhost") {
          $domain = $protocol."://".$_SERVER['HTTP_HOST']."/wpHF";
        } elseif($_SERVER['HTTP_HOST'] == "dev.smart-is.com" || $_SERVER['HTTP_HOST'] == "dev-beta.smart-is.com") {
          $domain = $protocol."://".$_SERVER['HTTP_HOST']."/humanityfirst";
        } else {
          $domain = $protocol."://".$_SERVER['HTTP_HOST'];
        }
    }

    $hf_gplus_client_id = get_option( 'hf_gplus_client_id' );
    $hf_gplus_client_secret = get_option( 'hf_gplus_client_secret' );
    $hf_gplus_developer_key = get_option( 'hf_gplus_developer_key' );

    $client = new Google_Client();
    $client->setApplicationName("Google UserInfo for Humanity First Application");
    // Visit https://code.google.com/apis/console?api=plus to generate your
    // oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
    $client->setClientId($hf_gplus_client_id);
    // $client->setClientId('504451023217-58oj48ul7voijdd4tuari70slt8im5oh.apps.googleusercontent.com');
    $client->setClientSecret($hf_gplus_client_secret);
    // $client->setClientSecret('Psho6JmiLg5x4hXUHW3a1yhB');
    $client->setRedirectUri($domain.'/google-login');
    $client->setDeveloperKey($hf_gplus_developer_key);
    // $client->setDeveloperKey('AIzaSyAbDprEDuR2AN8Yrer1LCW_fNMfyYssBVc');
    $oauth2 = new Google_Oauth2Service($client);

    if (isset($_GET['code'])) {
        $client->authenticate($_GET['code']);
        $_SESSION['token'] = $client->getAccessToken();
//        $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
//        header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
//        return;
//        echo $redirect;
//        die();
    }

    if (isset($_SESSION['token'])) {
        $client->setAccessToken($_SESSION['token']);
    }

    if ($client->getAccessToken()) {
        // The access token may have been updated lazily.
        $_SESSION['token'] = $client->getAccessToken();
        $_SESSION['LOGGED_IN_BY'] = 'Google';

        $user = $oauth2->userinfo->get();

        $user_pass = wp_generate_password();

        $g_id = $user['id'];
        $g_email = $user['email'];
        $g_name = $user['name'];

        if(!email_exists($g_email)) {

            $new_user_id = wp_insert_user(array(
              'user_login'      => $g_email,
              'user_pass'       => $user_pass,
              'user_email'      => $g_email,
              'display_name'    => $g_name,
              'user_registered' => date('Y-m-d H:i:s'),
              'role'            => 'subscriber'
            )
            );
            if($new_user_id) {
                // send an email to the admin alerting them of the registration
                wp_new_user_notification($new_user_id);

                // log the new user in
                wp_set_auth_cookie($new_user_id);
                wp_set_current_user($new_user_id, $g_email);
                $user = get_user_by('login', $g_email);
                do_action('wp_login', $g_email, $user);
            }
        } else {
            // log user in
            $user = get_user_by('login', $g_email);
            wp_set_auth_cookie($user->ID);
            wp_set_current_user($user->ID, $g_email);
            do_action('wp_login', $g_email, $user);
        }

//        echo "<pre>";
//        print_r($user);
//        echo "</pre>";

        // These fields are currently filtered through the PHP sanitize filters.
        // See http://www.php.net/manual/en/filter.filters.sanitize.php
//        $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
//        $img = filter_var($user['picture'], FILTER_VALIDATE_URL);
//        $personMarkup = "$email<div><img src='$img?sz=50'></div>";

        echo $domain;
    } else {
        $authUrl = $client->createAuthUrl();
        echo $authUrl;
    }
    die();
}

add_action( 'wp_ajax_google_login_action', 'ajax_google_login' ); // ajax for logged in users
add_action( 'wp_ajax_nopriv_google_login_action', 'ajax_google_login' ); // ajax for not logged in users

//add_action('wp_logout', 'end_google_session');
//add_action('wp_login', 'end_google_session');
add_action('end_session_action', 'end_google_session');

function end_google_session() {

    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';
    if($_SERVER['HTTP_HOST'] == "localhost") {
      $domain = $protocol."://".$_SERVER['HTTP_HOST']."/wpHF";
    } elseif($_SERVER['HTTP_HOST'] == "dev.smart-is.com" || $_SERVER['HTTP_HOST'] == "dev-beta.smart-is.com") {
      $domain = $protocol."://".$_SERVER['HTTP_HOST']."/humanityfirst";
    } else {
      $domain = $protocol."://".$_SERVER['HTTP_HOST'];
    }

    $hf_gplus_client_id = get_option( 'hf_gplus_client_id' );
    $hf_gplus_client_secret = get_option( 'hf_gplus_client_secret' );
    $hf_gplus_developer_key = get_option( 'hf_gplus_developer_key' );

    $client = new Google_Client();
    $client->setApplicationName("Google UserInfo for Humanity First Application");
    // Visit https://code.google.com/apis/console?api=plus to generate your
    // oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
    $client->setClientId($hf_gplus_client_id);
    $client->setClientSecret($hf_gplus_client_secret);
    $client->setRedirectUri($domain);
    $client->setDeveloperKey($hf_gplus_developer_key);

    unset($_SESSION['token']);
    $_SESSION['LOGGED_IN_BY'] = NULL;
    unset($_SESSION['LOGGED_IN_BY']);
    session_destroy();
    $client->revokeToken();
    wp_destroy_current_session();

    if(isset($_POST['logoutUrl'])) {
        echo $_POST['logoutUrl'];
        die();
    }
}

add_action( 'wp_ajax_end_google_session_action', 'end_google_session' ); // ajax for logged in users
add_action( 'wp_ajax_nopriv_end_google_session_action', 'end_google_session' ); // ajax for not logged in users

?>