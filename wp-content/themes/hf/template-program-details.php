<?php
/*
*
* Template Name: Program Details (REST API)
*
*/

$final_arr = array();

$args = array(
	'post_type' => 'hf_programs',
	'posts_per_page'=>-1
);

if(!empty($_GET['id'])){
	$args['p'] =  $_GET['id'];
}

$the_query = new WP_Query( $args );
$i=0;

if ( $the_query->have_posts() ) {

	$final_arr = array("success" => "true");

	while ( $the_query->have_posts() ) {
		$the_query->the_post();

		$programID = get_the_ID();

		$content = get_the_content();
		$content = strip_shortcodes( $content );

		$director_id = rwmb_meta('hfusa-program_director');
		$program_countries = rwmb_meta('hfusa-program_countries');
		$program_gallery = rwmb_meta('hfusa-program_gallery');
		$program_questions = rwmb_meta('hfusa-program_questions');
		$program_logo = rwmb_meta('hfusa-program_logo');

		$page_impact_details=get_post_meta( $programID, 'hfusa-page_impact_details' );

		$director = array();
		if(!empty($director_id)){

			$program_director_name = get_the_title( $director_id );
			$program_director_image = get_the_post_thumbnail_url( $director_id );
			$program_director_media = get_post_thumbnail_id( $director_id );
			$member_email=get_post_meta( $director_id,'hfusa-member_email',true );

			$director[0]['id'] = $director_id;
			$director[0]['program_director_name'] = $program_director_name;
			$director[0]['program_director_email'] = $member_email;
			$director[0]['program_director_image'] = $program_director_image;
			$director[0]['media_id'] = $program_director_media;
		}

		$countries = array();
		if(!empty($program_countries) && is_array($program_countries)){
			$cIndex=0;
			foreach($program_countries as $program_country){
				$countries[$cIndex]['id'] = $program_country;
				$countries[$cIndex]['country_name'] = get_the_title( $program_country );
				$countries[$cIndex]['country_image'] = get_the_post_thumbnail_url( $program_country );
				$countries[$cIndex]['media_id'] = get_post_thumbnail_id( $program_country );
				$cIndex++;
			}
		}


		$questions = array();
		if(!empty($program_questions) && is_array($program_questions)){
			$qIndex=0;
			foreach($program_questions as $program_question){
				$questions[$qIndex]['id'] = $program_question;
				$questions[$qIndex]['question'] = get_the_title( $program_question );
				$content_post = get_post($program_question);
				$content = $content_post->post_content;
				$content = apply_filters('the_content', $content);
				$content = str_replace(']]>', ']]&gt;', $content);
				$questions[$qIndex]['answer'] = $content;
				$qIndex++;
			}
		}


		$impacts = array();
		if(!empty($page_impact_details) && is_array($page_impact_details)){
			$page_impact_details = reset($page_impact_details);
			$impactIndex = 0;
			foreach ($page_impact_details as $key => $value) {
				$label = isset($value["label"]) ? $value["label"] : '';
				$figure = isset($value["figure"]) ? $value["figure"] : '';
				$icon = isset($value["icon"][0]) ? $value["icon"][0] : '';
				if(!empty($icon) && is_array($icon)){
					$icon = reset($icon);
				}
				if(isset($icon[0]) && is_array($icon[0])){
					$icon = $icon[0];
				}

				$image_attributes = wp_get_attachment_image_src( $icon );
				$media_url = '';
				if ( $image_attributes ) {
					$media_url = $image_attributes[0];
				}

				if(!empty($label) || !empty($figure) || !empty($icon)){
					$impacts[$impactIndex]['label'] = $label;
					$impacts[$impactIndex]['figure'] = $figure;
					$impacts[$impactIndex]['media_id'] = $icon;
					$impacts[$impactIndex]['media_url'] = $media_url;
					$impactIndex++;
				}
			}
		}


		$gallery = array();
		if(!empty($program_gallery) && is_array($program_gallery)){
			$galleryIndex = 0;
			foreach ($program_gallery as $image_details) {
				$gallery[$galleryIndex]['media_id'] = $image_details['ID'];
				$gallery[$galleryIndex]['media_url'] = $image_details['url'];
				$gallery[$galleryIndex]['full_url'] = $image_details['full_url'];
				$galleryIndex++;
			}
		}

		$logo = array();
		if(!empty($program_logo) && is_array($program_logo)){
			$program_logo = reset($program_logo);
			$logo[0]['media_id'] = $program_logo['ID'];
			$logo[0]['full_url'] = $program_logo['full_url'];
		}

		$projects = array();
		$projects_loop = new WP_Query(array(
			"post_type" => "hf_projects",
			"meta_key" => 'hfusa-project_program',
			"meta_value" => $programID,
			"posts_per_page" => -1
		));
		$projectIndex = 0;

		if ($projects_loop->have_posts()) :
			while ($projects_loop->have_posts()) : $projects_loop->the_post(); 
				$projects[$projectIndex]['id'] = get_the_ID();
				$projects[$projectIndex]['project_title'] = get_the_title(get_the_ID());
				$projects[$projectIndex]['media_id'] = get_post_thumbnail_id();
				$projects[$projectIndex]['media_url'] = get_the_post_thumbnail_url(get_the_ID(),'medium');
				$projects[$projectIndex]['full_url'] = get_the_post_thumbnail_url(get_the_ID());
				$projectIndex++;
			endwhile;
			wp_reset_query();
		endif; 


		$final_arr['posts'][$i]['id'] = $programID;
		$final_arr['posts'][$i]['date'] = get_the_date('c',$programID);
		$final_arr['posts'][$i]['title'] = get_the_title($programID);
		$final_arr['posts'][$i]['content'] = $content;
		$final_arr['posts'][$i]['program_logo'] = $logo;
		$final_arr['posts'][$i]['program_director'] = $director;
		$final_arr['posts'][$i]['program_countries'] = $countries;
		$final_arr['posts'][$i]['program_projects'] = $projects;
		$final_arr['posts'][$i]['program_questions'] = $questions;
		$final_arr['posts'][$i]['program_impacts'] = $impacts;
		$final_arr['posts'][$i]['program_gallery'] = $gallery;
		$final_arr['posts'][$i]['featured_media'] = get_post_thumbnail_id($programID);

		$i++;
	}
	wp_reset_postdata();
} else {

	$final_arr = array("success" => "false", "message" => "No record found!");

}

header('Content-Type: application/json');
echo json_encode($final_arr, JSON_PRETTY_PRINT);
exit;
?>