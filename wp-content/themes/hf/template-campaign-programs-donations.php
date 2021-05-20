<?php
/*
*
* Template Name: Campaign Programs Donations (REST API)
*
*/

$response = array();

if(isset($_GET['campaign_id']) && $_GET['campaign_id'] != '') {

    $campaign_id = $_GET['campaign_id'];

    $post_status = get_post_status( $campaign_id );

    $post_type = get_post_type( $campaign_id );

    if ( $post_status == "publish" && $post_type == "hf_campaigns") {

        $campaign_programs = get_post_meta( $campaign_id, 'hfusa-campaign_programs' );

        if(!empty($campaign_programs) && is_array($campaign_programs)){

            $program_donations = array();

            foreach ($campaign_programs as $program_id) {

                $post_status = get_post_status( $program_id );

                $post_type = get_post_type( $program_id );

                if ( $post_status == "publish" && $post_type == "hf_programs") {

                    $donation_args = array(
                        'posts_per_page'   => -1,
                        'post_type'        => 'hf_donations',
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key'     => 'hfusa-program_id',
                                'value'   => $program_id,
                                'compare' => '=',
                            ),
                            array(
                                'key'     => 'hfusa-donation_campaign_id',
                                'value'   => $campaign_id,
                                'compare' => '=',
                            ),
                        ),
                    );
                    $donation_query = new WP_Query( $donation_args );

                    $donation_posts = $donation_query->posts;

                    $target_amount = get_post_meta( $program_id, 'hfusa-target_price', true );

                    $donations_sum = 0;
                    $pledges_sum = 0;

                    foreach($donation_posts as $donation_post) {

                        $get_donation_amount = get_post_meta( $donation_post->ID, 'hfusa-donation_amount', true);

                        $donation_type = get_post_meta($donation_post->ID, 'hfusa-donation_type', true);

                        if( $donation_type == 'Donation' ) {

                            $donations_sum += $get_donation_amount;

                        } else {

                            $pledges_sum += $get_donation_amount;
                        }
                    }

                    $donationResponse = array( "Program ID" => $program_id, "Donations" => $donations_sum, "Pledges" => $pledges_sum, "Target Funds" => $target_amount );

                    $program_donations[] = $donationResponse;

                }      
            }

            $response = array("status" => "success", "data" => $program_donations);
        }

    } else {

        $response = array("status" => "fail", "message" => "Campaign ID doesn't exist");

    }

} else {
    $response = array("status" => "fail", "message" => "Campaign ID is required");
}

header('Content-Type: application/json');
echo json_encode($response, JSON_PRETTY_PRINT);
exit;