<?php
/*
*
* Template Name: Get all posts from Mobile (REST API)
*
*/



$final_arr = array();

$args = array(
	'post_type' => 'post',
	'posts_per_page'=>-1
);

if(!empty($_GET['category'])){

	$args['tax_query'] = array(
		array(
			'taxonomy' => 'category',
			'field'    => 'name',
			'terms'    => $_GET['category'],
		),
	);

}


$the_query = new WP_Query( $args );
$i=0;

if ( $the_query->have_posts() ) {

	$final_arr = array("success" => "true");

	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		$categories = get_the_category();
		$categoriesPost = array();

		if(!empty($categories) && is_array($categories)){
			foreach($categories as $category){
				$categoriesPost[] = isset($category->name) ? $category->name: '';
			}
		}

		$content = get_the_content();
		$content = apply_filters('the_content', $content);

		$final_arr['posts'][$i]['id'] = get_the_ID();
		$final_arr['posts'][$i]['date'] = get_the_date('c');
		$final_arr['posts'][$i]['title'] = get_the_title();
		$final_arr['posts'][$i]['content'] = $content;
		$final_arr['posts'][$i]['category'] = $categoriesPost;
		$final_arr['posts'][$i]['featured_media'] = get_post_thumbnail_id();

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