 <?php
 $parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
 require_once( $parse_uri[0] . 'wp-load.php' );

 header('Cache-Control: no-cache');
 header("Content-Type: text/event-stream\n\n");

 $eventID = 0;
 $donationIDLatest = 0;
 $campaignID = 0;

 if ( $post = get_page_by_path( 'telethon', OBJECT, 'hf_events' ) ){
 	$eventID = $post->ID;
 	$campaignID	=	get_post_meta( $eventID, 'hfusa-event_campaigns',true );
 }
 
 if(!empty($campaignID)){
 	$args = array(
 		'posts_per_page'=>1,
 		'post_type' => 'hf_donations',
 		'meta_query' => array(
 			'relation' => 'AND',
 			array(
 				'key'     => 'hfusa-donation_campaign_id',
 				'value'   => $campaignID,
 				'compare' => '=',
 			),
 			array(
 				'key'     => 'hfusa-donation_type',
 				'value'   => 'Donation',
 				'compare' => '=',
 			)
 		),
 	);
 	$the_query = new WP_Query( $args );
 	if ( $the_query->have_posts() ) {
 		while ( $the_query->have_posts() ) {
 			$the_query->the_post();
 			$donationIDLatest = get_the_ID();
 		}
 	}
 }

 echo "event: ping\n";
 $time = date('r');
 echo 'data: ' . $donationIDLatest;
 echo "\n\n";
 ob_end_flush();
 flush();
 sleep(15);
 ?>