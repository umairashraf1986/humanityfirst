<?php
/*
Plugin Name: Humanity First Login with Facebook
Plugin URI: http://dev.smart-is.com/humanityfirst
Description: Plugin to Login User with Facebook in HF theme.
Version: 1.0.0
Author: Oracular
Author URI: http://oracular.com
Text Domain: sage
*/

//Get the absolute path of the directory that contains the file, with trailing slash.
define('HF_LOGIN_FB_PATH', plugin_dir_path(__FILE__));
require_once HF_LOGIN_FB_PATH . 'autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;

function ajax_action_stuff() {

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



  $hf_fb_app_id = get_option( 'hf_fb_app_id' );
  $hf_fb_app_secret = get_option( 'hf_fb_app_secret' );

  // init app with app id and secret
  FacebookSession::setDefaultApplication( $hf_fb_app_id, $hf_fb_app_secret );
  // FacebookSession::setDefaultApplication( '132251130813937','e0b2ddaa694f44d82a521f012e62d883' );
  // login helper with redirect_uri
  $helper = new FacebookRedirectLoginHelper($domain.'/facebook-login' );

  try {
    $session = $helper->getSessionFromRedirect();
  } catch( FacebookRequestException $ex ) {
    // When Facebook returns an error
    echo $ex;
  } catch( Exception $ex ) {
    // When validation fails or other local issues
    echo $ex;
  }
  if (isset($session)) {
    // graph api request for user data
    $request = new FacebookRequest( $session, 'GET', '/me?fields=email,name,id,picture' );
    $response = $request->execute();
    // get response
    $graphObject = $response->getGraphObject();
//    var_dump($graphObject);
    $fpictureObj = $graphObject->getProperty('picture');
    $fpictureUrl = $fpictureObj->getProperty('url');
    //var_dump($fpicture);
    //exit;
    $fbid = $graphObject->getProperty('id');         // To Get Facebook ID
    $fbfullname = $graphObject->getProperty('name'); // To Get Facebook full name
    $femail = $graphObject->getProperty('email');    // To Get Facebook email ID

    /* ---- Session Variables -----*/
    $_SESSION['LOGGED_IN_BY'] = 'Facebook';
    $_SESSION['FBID'] = $fbid;
    $_SESSION['FULLNAME'] = $fbfullname;
    $_SESSION['EMAIL'] =  $femail;
    $_SESSION['PURL'] =  $fpictureUrl;
    $_SESSION['LOGOUT_URL'] =  $helper->getLogoutUrl($session, $domain);

    $user_pass = wp_generate_password();

    $redirect_url = $domain;

    if(!email_exists($femail)) {

      $new_user_id = wp_insert_user(array(
          'user_login'      => $femail,
          'user_pass'       => $user_pass,
          'user_email'      => $femail,
          'display_name'    => $fbfullname,
          'user_registered' => date('Y-m-d H:i:s'),
          'role'            => 'subscriber'
        )
      );
      if($new_user_id) {
        // send an email to the admin alerting them of the registration
        wp_new_user_notification($new_user_id);

        // log the new user in
        wp_set_auth_cookie( $new_user_id );
        wp_set_current_user($new_user_id, $femail);
        $user = get_user_by('login', $femail);
        do_action('wp_login', $femail, $user);

        // send the newly created user to the home page after logging them in
        //wp_redirect(home_url('/events')); exit;
//        if(isset($_SESSION['previous_url'])) {
//          $redirect_url = $_SESSION['previous_url'];
//          //wp_redirect($location);
//        }
//        unset($_SESSION['previous_url']);
//        exit();
      }
    } else {
        // log user in
        $user = get_user_by('login', $femail);
        wp_set_auth_cookie($user->ID);
        wp_set_current_user($user->ID, $femail);
        do_action('wp_login', $femail, $user);
    }

    echo $redirect_url;

  } else {
    $loginUrl = $helper->getLoginUrl(array('req_perms' => 'email'));
    echo $loginUrl;
  }
  
  die();

}
add_action( 'wp_ajax_fb_login_action', 'ajax_action_stuff' ); // ajax for logged in users
add_action( 'wp_ajax_nopriv_fb_login_action', 'ajax_action_stuff' ); // ajax for not logged in users

//add_action('wp_logout', 'end_session');
//add_action('wp_login', 'end_session');
add_action('end_session_action', 'end_session');

function end_session() {
    if(isset($_SESSION['LOGGED_IN_BY']) && $_SESSION['LOGGED_IN_BY'] == 'Facebook') {
        session_unset();
        $_SESSION['FBID'] = NULL;
        $_SESSION['FULLNAME'] = NULL;
        $_SESSION['EMAIL'] =  NULL;
        $_SESSION['PURL'] =  NULL;
        $_SESSION['LOGOUT_URL'] =  NULL;
        $_SESSION['LOGGED_IN_BY'] = NULL;
        unset($_SESSION['LOGGED_IN_BY']);
        session_destroy();
        wp_destroy_current_session();
    }
    echo $_POST['logoutUrl'];
    die();
}

add_action( 'wp_ajax_end_facebook_session_action', 'end_session' ); // ajax for logged in users
add_action( 'wp_ajax_nopriv_end_facebook_session_action', 'end_session' ); // ajax for not logged in users

?>
