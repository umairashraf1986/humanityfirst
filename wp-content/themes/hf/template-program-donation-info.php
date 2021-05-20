<?php
/*
*
* Template Name: Program Donation Information (REST API)
*
*/

if(isset($_GET['program_id']) && $_GET['program_id'] != '') {

    $program_id = $_GET['program_id'];

    $post_status = get_post_status( $program_id );

    $post_type = get_post_type( $program_id );

    if ( $post_status == "publish" && $post_type == "hf_programs") {

        $donation_args = array(
            'posts_per_page'   => -1,
            'post_type'        => 'hf_donations',
            'meta_key'         => 'hfusa-program_id',
            'meta_value'       => $program_id
        );
        $donation_query = new WP_Query( $donation_args );

        $donation_posts = $donation_query->posts;

        //echo '<pre>';
        //print_r($cc_query->posts);
        //echo '</pre>';

        $target_amount = get_post_meta( $program_id, 'hfusa-target_price', true );

        $donations_sum = 0;
        $pledges_sum = 0;

        foreach($donation_posts as $donation_post) {

            //echo $donation_post->ID;
            //echo $donation_post->post_title;

            $get_donation_amount = get_post_meta( $donation_post->ID, 'hfusa-donation_amount', true);

            $donation_type = get_post_meta($donation_post->ID, 'hfusa-donation_type', true);

            //echo $get_donation_amount . '<br>';

            if( $donation_type == 'Donation' ) {

                $donations_sum += $get_donation_amount;

            } else {

                $pledges_sum += $get_donation_amount;
            }
        }

        //print_r($donationAmounts);

        $donationResponse = array( "Donations" => $donations_sum, "Pledges" => $pledges_sum, "Target Funds" => $target_amount );

        header('Content-Type: application/json');
        echo json_encode($donationResponse, JSON_PRETTY_PRINT);

    } else {

        echo "Program with this ID doesn't exist.";

    }

} else {

    $donation_args = array(
        'posts_per_page' => -1,
        'post_type' => 'hf_donations'
    );
    $donation_query = new WP_Query($donation_args);

    $donation_posts = $donation_query->posts;

    $p_args = array(
        'posts_per_page' => -1,
        'post_type' => 'hf_programs'
    );
    $p_query = new WP_Query($p_args);

    $p_posts = $p_query->posts;

    foreach ($p_posts as $p_post) {

        $donations_sum = 0;
        $pledges_sum = 0;

        $p_target_amount = get_post_meta($p_post->ID, 'hfusa-target_price', true);

        foreach ($donation_posts as $donation_post) {

            $program_id = get_post_meta($donation_post->ID, 'hfusa-program_id', true);

            if($program_id == $p_post->ID) {

                $donation_type = get_post_meta($donation_post->ID, 'hfusa-donation_type', true);

                $donation_amount = get_post_meta($donation_post->ID, 'hfusa-donation_amount', true);

                if( $donation_type == 'Donation' ) {

                    $donations_sum += $donation_amount;

                } else {

                    $pledges_sum += $donation_amount;
                }

            }

        }

        $p_array[] = array(
            'Program ID' => $p_post->ID,
            'Donations' => $donations_sum,
            'Pledges' => $pledges_sum,
            'Target Funds' => $p_target_amount
        );
    }

    header('Content-Type: application/json');
    echo json_encode($p_array, JSON_PRETTY_PRINT);
    //print_r($p_array);

    //print_r($dAmounts);

}

