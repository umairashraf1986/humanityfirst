<?php
/*
Plugin Name: HFUSA Custom Push Notifications
Plugin URI: http://usa.humanityfirst.org
Description: A custom plugin to send push notifications
Version: 2.3.21
Author: Oracular
Author URI: http://www.oracular.com
License: GPL2
*/
// Server file
class PushNotifications {
	// (Android)API access key from Google API's Console.
	private static $API_ACCESS_KEY = 'AAAA-yIZ-aU:APA91bG-tTynBnmR22XLxldru2R3veuWJ03bT5QFPBK-Y3011kEpmejkc41FqVGdLnqX7j8MHE8ptiiJhiUJOjUXE_OvIkMVGg6nKpeKISOFYu5CMA60xjvZnN65MjC11m0p3q_AlE2q';
	// (iOS) Private key's passphrase.
	private static $passphrase = '123';
	// (Windows Phone 8) The name of our push channel.
    private static $channelName = "joashp";
	
	// Change the above three vriables as per your app.
	public function __construct() {
		exit('Init function is not allowed');
	}
	
    // Sends Push notification for Android users
	public static function android($data, $reg_id) {
	     $url = 'https://fcm.googleapis.com/fcm/send';
	     $message = array
	     (
	         'title' => $data['mtitle'],
	         'body' => $data['mdesc'],
	         'subtitle' => '',
	         'tickerText' => '',
	         'msgcnt' => 1,
	         'vibrate' => 1,
	         'type' => $data['mtype'],
	         'id' => $data['mid']
	     );

	     $headers = array(
	         'Content-Type:application/json',
	         'Authorization:key='.self::$API_ACCESS_KEY
	     );
	     $fields = array(
	         'data' => $message,
	         'to' => $reg_id,
	     );
	     return self::useCurl($url, $headers, $fields);
	}
	
	// Sends Push's toast notification for Windows Phone 8 users
	public static function WP($data, $uri) {
		$delay = 2;
		$msg =  "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
		        "<wp:Notification xmlns:wp=\"WPNotification\">" .
		            "<wp:Toast>" .
		                "<wp:Text1>".htmlspecialchars($data['mtitle'])."</wp:Text1>" .
		                "<wp:Text2>".htmlspecialchars($data['mdesc'])."</wp:Text2>" .
		            "</wp:Toast>" .
		        "</wp:Notification>";
		
		$sendedheaders =  array(
		    'Content-Type: text/xml',
		    'Accept: application/*',
		    'X-WindowsPhone-Target: toast',
		    "X-NotificationClass: $delay"
		);
		
		$response = $this->useCurl($uri, $sendedheaders, $msg);
		
		$result = array();
		foreach(explode("\n", $response) as $line) {
		    $tab = explode(":", $line, 2);
		    if (count($tab) == 2)
		        $result[$tab[0]] = trim($tab[1]);
		}
		
		return $result;
	}
	
    // Sends Push notification for iOS users
	public static function iOS($data, $devicetoken) {
		$deviceToken = $devicetoken;
		$ctx = stream_context_create();
		// hf-apns-dev-certificate.pem is your certificate file
		stream_context_set_option($ctx, 'ssl', 'local_cert', plugin_dir_path( __FILE__ ).'hf-apns-dev-certificate.pem');
		stream_context_set_option($ctx, 'ssl', 'passphrase', self::$passphrase);
		// Open a connection to the APNS server
		$fp = stream_socket_client(
			'ssl://gateway.sandbox.push.apple.com:2195', $err,
			$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp)
			exit("Failed to connect: $err $errstr" . PHP_EOL);
		// Create the payload body
		$body['aps'] = array(
			'alert' => array(
			    'title' => $data['mtitle'],
                'body' => $data['mdesc'],
                'type' => $data['mtype'],
                'id' => $data['mid']
			 ),
			'sound' => 'default'
		);
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		
		// Close the connection to the server
		fclose($fp);
		if (!$result)
			return 'Message not delivered' . PHP_EOL;
		else
			return 'Message successfully delivered' . PHP_EOL;
	}
	
	// Curl 
	private static function useCurl($url, $headers , $fields) {
    	$ch = curl_init();
        if ($url) {
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($fields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
            }
            // Execute post
            $result = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            // Close connection
            curl_close($ch);
       		//checking the response code we get from fcm for debugging purposes
            echo "http response " . $httpcode;
       		//checking the status/result of the push notif for debugging purposes
            return $result;
        }

    }
    
}
?>