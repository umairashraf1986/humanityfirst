<?php
/*
*
* Template Name: Donations by State (REST API)
*
*/

if(isset($_GET['campaign_id']) && $_GET['campaign_id'] != '') {

    $campaign_id = $_GET['campaign_id'];

    $campaign_name = get_the_title( $campaign_id );

    $post_status = get_post_status( $campaign_id );

    $post_type = get_post_type( $campaign_id );

    if ( $post_status == "publish" && $post_type == "hf_campaigns") {

        // All Donations with States
        $donation_args = array(
            'posts_per_page'   => -1,
            'post_type'        => 'hf_donations',
            'meta_key'         => 'hfusa-donation_campaign_id',
            'meta_value'       => $campaign_id
        );
        $donation_query = new WP_Query( $donation_args );

        $donation_posts = $donation_query->posts;

        $donation_response = [];

        foreach($donation_posts as $donation_post) {

            //echo $donation_post->post_title;

            $donation_amount = get_post_meta($donation_post->ID, 'hfusa-donation_amount', true);

            $state_name = get_post_meta($donation_post->ID, 'hfusa-donor_state', true);

            $donation_type = get_post_meta($donation_post->ID, 'hfusa-donation_type', true);

            if(empty($donation_response)) {

                if ($donation_type == 'Donation') {

                    $donation = $donation_amount;
                    $pledge = 0;

                } else {

                    $donation = 0;
                    $pledge = $donation_amount;

                }

                $donation_response[] = array(
                    'state_name' => ucwords(strtolower($state_name)),
                    'campaign_id' => $campaign_id,
                    'campaign_name' => $campaign_name,
                    'donations' => $donation,
                    'pledges' => $pledge
                );

            } else {

                $flag = false;

                for($i=0; $i<count($donation_response); $i++) {

                    if(strtolower($state_name) == strtolower($donation_response[$i]['state_name'])) {

                        $flag = true;

                        if ($donation_type == 'Donation') {

                            $donation_response[$i]['donations'] += $donation_amount;

                        } else {

                            $donation_response[$i]['pledges'] += $donation_amount;

                        }

                    }

                }

                if(!$flag){

                    if ($donation_type == 'Donation') {

                        $donation = $donation_amount;
                        $pledge = 0;

                    } else {

                        $donation = 0;
                        $pledge = $donation_amount;

                    }

                    $donation_response[] = array(
                        'state_name' => ucwords(strtolower($state_name)),
                        'campaign_id' => $campaign_id,
                        'campaign_name' => $campaign_name,
                        'donations' => $donation,
                        'pledges' => $pledge
                    );

                }

            }
        }

    } else {
        $donation_response = array("status" => "fail", "message" => "Campaign ID doesn't exist");
    }

} else {
    $donation_response = array("status" => "fail", "message" => "Campaign ID is required");
}

//echo "<pre>";
//print_r($donation_response);
//echo "</pre>";

header('Content-Type: application/json');
echo json_encode($donation_response, JSON_PRETTY_PRINT);