<?php
/*
*
* Template Name: Event Details (REST API)
*
*/

$final_arr = array();

$args = array(
	'post_type' => 'hf_events',
	'posts_per_page'=>-1
);

if(!empty($_GET['id'])){
	$args['p'] =  $_GET['id'];
}


function hfCompareByValue($a, $b) {
	if(!isset($a["start_time"]) || !isset($b["start_time"])){
		return false;
	}
	return $a["start_time"] > $b["start_time"];
}


$the_query = new WP_Query( $args );
$index=0;

if ( $the_query->have_posts() ) {

	$final_arr = array("success" => "true");

	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$eventID = get_the_ID();
		$content = get_the_content();
		$content = strip_shortcodes( $content );
		$mapDetails = array();

		$event_date = rwmb_meta('hfusa-event_date');
		$event_start_time = rwmb_meta('hfusa-event_start_time');
		$event_end_time = rwmb_meta('hfusa-event_end_time');
		$event_location = rwmb_meta('hfusa-event_location');
		$ticket_price = rwmb_meta('hfusa-event_price');
		$total_tickets = rwmb_meta('hfusa-event_tickets_available');
		$event_sponsors = rwmb_meta('hfusa-event_sponsors');
		$event_speakers = rwmb_meta('hfusa-event_speakers');
		$remaining_tickets = rwmb_meta('hfusa-remaining_spaces');
		$event_campaign = rwmb_meta('hfusa-event_campaigns');
		$video_id = rwmb_meta('hfusa-telethon_video_id');
		$event_map = rwmb_get_value( 'hfusa-event_map' );

		if(!empty($event_map['latitude']) && !empty($event_map['longitude'])){
			$mapDetails[0]['latitude'] = $event_map['latitude'];
			$mapDetails[0]['longitude'] = $event_map['longitude'];
		}


		$sponsors = array();
		if(!empty($event_sponsors) && is_array($event_sponsors)){
			$i=0;
			foreach($event_sponsors as $event_sponsor){
				$sponsors[$i]['id'] = $event_sponsor;
				$sponsors[$i]['sponsor_name'] = get_the_title( $event_sponsor );
				$sponsors[$i]['media_id'] = get_post_thumbnail_id($event_sponsor);
				$sponsors[$i]['full_url'] = get_the_post_thumbnail_url($event_sponsor);
				$i++;
			}
		}

		$speakers = array();
		if(!empty($event_speakers) && is_array($event_speakers)){
			$i=0;
			foreach($event_speakers as $event_speaker){
				$speakers[$i]['id'] = $event_speaker;
				$speakers[$i]['speaker_name'] = get_the_title( $event_speaker );
				$speakers[$i]['media_id'] = get_post_thumbnail_id($event_speaker);
				$speakers[$i]['full_url'] = get_the_post_thumbnail_url($event_speaker);
				$i++;
			}
		}

		$campaignDetails =array();
		if(!empty($event_campaign)){
			$campaign_programs=get_post_meta( $event_campaign, 'hfusa-campaign_programs' );
			$start_date=get_post_meta( $event_campaign, 'hfusa-start_date',true );
			$end_date=get_post_meta( $event_campaign, 'hfusa-end_date',true );
			$target_price=get_post_meta( $event_campaign, 'hfusa-target_price',true );
			$campaignDetails[0]['campaign_id'] = $event_campaign;
			$campaignDetails[0]['start_date'] = $start_date;
			$campaignDetails[0]['end_date'] = $end_date;
			$campaignDetails[0]['target_price'] = $target_price;

			$rpIndex=0;
			if(!empty($campaign_programs) && is_array($campaign_programs)){
				foreach ($campaign_programs as $campaign_program) {
					$campaignDetails[0]['related_programs'][$rpIndex]['id'] = $campaign_program;
					$campaignDetails[0]['related_programs'][$rpIndex]['program_name'] = get_the_title($campaign_program);
					$rpIndex++;
				}
			}else{
				$campaignDetails[0]['related_programs'] = array();
			}
		}


		$event_agendas=get_post_meta( $eventID, 'hfusa-agandas_details' );
		$sortedArr=array();
		$is_empty = true;

		if(!empty($event_agendas[0]) && is_array($event_agendas[0])){
			$i=0;
			foreach($event_agendas[0] as $array){
				$sortedArr[$i]['agenda_title']= !empty($array['agenda_title']) ? $array['agenda_title'] : '';
				$sortedArr[$i]['start_time']= !empty($array['start_time']) ? $array['start_time'] : '';
				$sortedArr[$i]['end_time']= !empty($array['end_time']) ? $array['end_time'] : '';
				$i++;
			}
			usort($sortedArr, 'hfCompareByValue');
		}

		if($sortedArr && is_array($sortedArr)){
			foreach ($sortedArr as $subArr) {
				$agenda_title = !empty($subArr["agenda_title"]) ? $subArr["agenda_title"] : '';
				if( !empty($agenda_title) ) {
					$is_empty = false;
				}
			}
			
			if($is_empty === true) {
				$sortedArr = array();
			}
		}else{
			$sortedArr = array();
		}


		$final_arr['posts'][$index]['id'] = $eventID;
		$final_arr['posts'][$index]['date'] = get_the_date('c',$eventID);
		$final_arr['posts'][$index]['title'] = get_the_title($eventID);
		$final_arr['posts'][$index]['content'] = $content;
		$final_arr['posts'][$index]['event_date'] = $event_date;
		$final_arr['posts'][$index]['start_time'] = $event_start_time;
		$final_arr['posts'][$index]['end_time'] = $event_end_time;
		$final_arr['posts'][$index]['event_location'] = $event_location;
		$final_arr['posts'][$index]['ticket_price'] = $ticket_price;
		$final_arr['posts'][$index]['total_tickets'] = $total_tickets;
		$final_arr['posts'][$index]['remaining_tickets'] = $remaining_tickets;
		$final_arr['posts'][$index]['event_sponsors'] = $sponsors;
		$final_arr['posts'][$index]['event_speakers'] = $speakers;
		$final_arr['posts'][$index]['event_campaign'] = $campaignDetails;
		$final_arr['posts'][$index]['event_agendas'] = $sortedArr;
		$final_arr['posts'][$index]['video_id'] = $video_id;
		$final_arr['posts'][$index]['event_map'] = $mapDetails;
		$final_arr['posts'][$index]['featured_media'] = get_post_thumbnail_id($eventID);
		$index++;
	}
	wp_reset_postdata();
} else {

	$final_arr = array("success" => "false", "message" => "No record found!");

}

header('Content-Type: application/json');
echo json_encode($final_arr, JSON_PRETTY_PRINT);
exit;
?>