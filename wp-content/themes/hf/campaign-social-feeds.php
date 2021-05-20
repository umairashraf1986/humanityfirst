<?php

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );

// $hfloginpath = '../../plugins/hf-login-facebook/autoload.php';
// require_once $hfloginpath;

// use Facebook\FacebookSession;
// use Facebook\FacebookRedirectLoginHelper;
// use Facebook\FacebookRequest;
// use Facebook\FacebookResponse;
// use Facebook\FacebookSDKException;
// use Facebook\FacebookRequestException;
// use Facebook\FacebookAuthorizationException;
// use Facebook\GraphObject;
// use Facebook\Entities\AccessToken;
// use Facebook\HttpClients\FacebookCurlHttpClient;
// use Facebook\HttpClients\FacebookHttpable;

// if(!empty($_POST['load_th_feeds']) && $_POST['load_th_feeds']=='fb_feeds'){

//   $htmlString = ' ';

//   $hf_fb_app_id = get_option( 'hf_fb_app_id' );
//   $hf_fb_app_secret = get_option( 'hf_fb_app_secret' );

//     // init app with app id and secret
//   FacebookSession::setDefaultApplication( $hf_fb_app_id, $hf_fb_app_secret );
//   // FacebookSession::setDefaultApplication( '132251130813937','e0b2ddaa694f44d82a521f012e62d883' );
//   $session = FacebookSession::newAppSession();

//   try {
//     $session->validate();
//   } catch (FacebookRequestException $ex) {
//         // Session not valid, Graph API returned an exception with the reason.
//         //error_log($ex->getMessage());
//   } catch (\Exception $ex) {
//         // Graph API returned info, but it may mismatch the current app or have expired.
//         //error_log($ex->getMessage());
//   }

//   if (isset($session)) {

//     $nextpagesResults = '';

//     if(!empty($_POST['after_id']) && $_POST['after_id'] != 'undefined'){
//       $nextpagesResults = "&after=".$_POST['after_id'];
//     }


//     $telethonEventID = isset($_POST['post_id']) ? $_POST['post_id'] : '';
//     $telethonFBPage  = get_post_meta( $telethonEventID, 'hfusa-telethon_fb_page',true );

//     $request = (new FacebookRequest(
//       $session, 'GET', '/'.$telethonFBPage.'/feed?fields=id,message,link,full_picture&limit=10'.$nextpagesResults
//     ))->execute();
//     $data = $request->getGraphObject()->getPropertyAsArray("data");
//     $paging = $request->getGraphObject()->getProperty("paging");
//     $cursors = $paging->getProperty("cursors");
//     $after = $cursors->getProperty("after");

//     if($data && is_array($data)){
//       foreach ($data as $post){
//         $postId = $post->getProperty('id');
//         $message = $post->getProperty('message');
//         $link = $post->getProperty('link');
//         $picture = $post->getProperty('full_picture');
//         $postMessage = strlen($message) > 180 ? substr($message,0,180)."..." : $message;
//         $htmlString .='<div class="hf-social-feed">
//         <div class="feed-data">';
//         if(!empty($picture)){
//          $htmlString .='<img src="'.$picture.'" >';
//          $htmlString .='<div class="clearfix"></div>';
//          $htmlString .='<div></div>';
//        }
//        $htmlString .=$postMessage;   
//        $htmlString .=' <a href="'.$link.'" target="_blank">view</a>                 
//        </div>
//        </div>';
//      }

//      $htmlString .='<div class="facebook-after-id" data-feed-after-id="'.$after.'"></div>';

//    }
//  }
//  echo $htmlString;
//  exit;
// }

if(!empty($_POST['load_th_feeds']) && $_POST['load_th_feeds']=='twitter_feeds'){


  $hf_twitter_oauth_access_token = get_option( 'hf_twitter_oauth_access_token' );
  $hf_twitter_oauth_access_token_secret = get_option( 'hf_twitter_oauth_access_token_secret' );
  $hf_twitter_consumer_key = get_option( 'hf_twitter_consumer_key' );
  $hf_twitter_consumer_secret = get_option( 'hf_twitter_consumer_secret' );

  require_once('twitter-api-php-master/TwitterAPIExchange.php');

  $settings = array(
    'oauth_access_token' => $hf_twitter_oauth_access_token,
    'oauth_access_token_secret' => $hf_twitter_oauth_access_token_secret,
    'consumer_key' => $hf_twitter_consumer_key,
    'consumer_secret' => $hf_twitter_consumer_secret
  );

  $htmlString = ' ';

  $nextpagesResults = '';

  if(!empty($_POST['max_id'])){
    $nextpagesResults = "&max_id=".$_POST['max_id'];
  }

  $campaignID = isset($_POST['post_id']) ? $_POST['post_id'] : '';
  $twitterHashtag  = get_post_meta( $campaignID, 'hfusa-campaign_twitter_feed',true );

  if (strpos($twitterHashtag, '#') === false) {
    $twitterHashtag = '#'.$twitterHashtag;
  }

  $url = 'https://api.twitter.com/1.1/search/tweets.json';
  $getfield = '?q='.$twitterHashtag.' AND -filter:retweets AND -filter:replies&count=10&result_type=mixed&include_entities=true&tweet_mode=extended'.$nextpagesResults;
  $requestMethod = 'GET';
  $twitter = new TwitterAPIExchange($settings);
  $response = $twitter->setGetfield($getfield)->buildOauth($url, $requestMethod)->performRequest();
  $response = json_decode($response);
  
  if(!empty($response->statuses) && is_array($response->statuses)){

    foreach ($response->statuses as $post){
      $link = '';
      $message = $post->full_text;
      $picture = isset($post->retweeted_status->entities->media[0]->media_url) ? $post->retweeted_status->entities->media[0]->media_url : '';
      $postMessage = strlen($message) > 180 ? substr($message,0,180)."..." : $message;
      if(isset($post->retweeted_status->entities->media[0]->sizes->small)){
        $picture    =   $picture.':small';
        $id_str = $post->id_str;
        $screen_name = $post->user->screen_name;
        $link = 'https://twitter.com/'.$screen_name.'/status/'.$id_str;
      }
      $htmlString .='<div class="hf-social-feed">
      <div class="feed-data">';
      if(!empty($picture)){
       $htmlString .='<img src="'.$picture.'" >';
       $htmlString .='<div class="clearfix"></div>';
       $htmlString .='<div></div>';
     }
     $htmlString .=$postMessage;  
     if(!empty($link)){
      $htmlString .='<a href="'.$link.'" target="_blank">view</a>'; 
    }                              
    $htmlString .='</div>
    </div>';
  }

  $next_results= isset($response->search_metadata->next_results) ? $response->search_metadata->next_results : '';
  $next_results = parse_url($next_results);
  parse_str($next_results['query'], $datamaxid);
  $max_id = isset($datamaxid['max_id'])  ? $datamaxid['max_id'] :'';
  $htmlString .='<div class="twitter-max-id" data-feed-max-id="'.$max_id.'"></div>';
}
echo $htmlString;
exit;
}

?>