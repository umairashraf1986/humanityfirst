<?php


/********************************************
* Functionality for Donations page admin "
********************************************/


add_action( 'admin_menu', 'hf_donations_register_ref_page' );

function hf_donations_register_ref_page() {
    add_submenu_page(
        'edit.php?post_type=hf_donations',
        __( 'Statistics', 'hf' ),
        __( 'Statistics', 'hf' ),
        'manage_options',
        'hf-donations',
        'hf_donations_page_callback'
    );
}

function hf_high_charts_scripts($hook) {

    if (  $hook != 'hf_donations_page_hf-donations') {
        return;
    }

    wp_enqueue_script( 'highcharts-script', get_stylesheet_directory_uri().'/assets/scripts/highcharts.js' );
    wp_enqueue_script( 'highcharts-exporting', get_stylesheet_directory_uri().'/assets/scripts/exporting.js');
}

add_action( 'admin_enqueue_scripts', 'hf_high_charts_scripts' );


function hf_donations_page_callback() { 

    $generaLProgramId='';   
    $args = array(
      'name'        => 'general',
      'post_type'   => 'hf_programs',
      'post_status' => 'publish',
      'numberposts' => 1
  );
    $program_posts = get_posts($args);
    if( $program_posts ) :
      $generaLProgramId=isset($program_posts[0]->ID) ? $program_posts[0]->ID : '';
  endif;
  ?>

  <style>
  div#wpfooter {
    display: none;
} 
span.page-numbers.current {
    border: 1px solid #ddd;
    background-color: #f7f7f7;
    padding: 2px 10px 4px;
    line-height: 21px;
    display: inline-block;
    font-size: 15px;
    font-weight: bold;
}
.donation-tabs ul {
    margin: 0;
}
.donation-tabs li {
    display: inline-block;
    margin: 0;
}
.donation-tabs li a {
    display: block;
    font-weight: bold;
    background-color: #ddd;
    text-decoration: none;
    padding: 12px 20px;
}
.donation-tabs li a.current-tab {
    background-color: #fff;
    cursor: default;
    pointer-events: none;
}
</style>

<?php
if(isset($_GET['program_id']) && !empty($_GET['program_id'])){
    $program_id = $_GET['program_id'];
    $compareArray=array($program_id);
    if($program_id==$generaLProgramId){
        $compareArray[]='';
    }

    $tab=isset($_GET['tab']) && !empty($_GET['tab']) ? $_GET['tab'] : 'donation';

    ?>

    <div class="wrap">

        <a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations">Back</a>

        <h1><?php echo get_the_title($program_id); ?> Donations</h1>

        <div class="donation-tabs">
            <ul>
                <li>
                    <a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations&program_id=<?php echo $program_id; ?>&tab=donation" class="<?php

                    if($tab=='donation'){
                        echo 'current-tab';
                    }

                    ?>">Donations</a>
                </li>
                <li>
                    <a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations&program_id=<?php echo $program_id; ?>&tab=pledge" class="<?php

                    if($tab=='pledge'){
                        echo 'current-tab';
                    }

                    ?>">Pledges</a>
                </li>
            </ul>
        </div>

        <?php
        if($tab=='pledge'){
            ?>



            <table class="wp-list-table widefat  striped posts" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Donation</th> 
                        <th>Amount</th> 
                        <th>Donor Name</th> 
                        <th>Email</th> 
                        <th>Phone</th> 
                        <th>City</th> 
                        <th>State</th> 
                        <th>Pledge Promise Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $paged = isset($_GET['paged']) ? $_GET['paged'] : 1;

                    $args = array(
                        'post_type' => 'hf_donations',
                        'posts_per_page' => -1,
                        'posts_per_page' => 10,
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key'     => 'hfusa-program_id',
                                'value'   => $compareArray,
                                'compare' => 'IN',
                            ),
                            array(
                                'key'     => 'hfusa-donation_type',
                                'value'   => "Pledge",
                                'compare' => '=',
                            )
                        ),
                        'paged' => $paged,
                    );



                    $the_query = new WP_Query( $args );

                    if ( $the_query->have_posts() ) { 

                        $i=1;
                        $i=$i+(($paged-1)*10);

                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            $postId=get_the_ID();
                            $donation_amount=get_post_meta( $postId, 'hfusa-donation_amount',true );
                            $donor_name=get_post_meta( $postId, 'hfusa-donor_name',true );
                            $donor_email=get_post_meta( $postId, 'hfusa-donor_email',true );
                            $donor_phone=get_post_meta( $postId, 'hfusa-donor_phone',true );
                            $donor_city=get_post_meta( $postId, 'hfusa-donor_city',true );
                            $donor_state=get_post_meta( $postId, 'hfusa-donor_state',true );
                            $pledge_promise_date=get_post_meta( $postId, 'hfusa-pledge_promise_date',true );
                            $title=get_the_title();

                            $program_name = get_the_title($program_id);

                            if(empty($program_name)){
                                $program_name = $program_name_meta;    
                            }
                            ?>
                            <tr>
                                <td><?php echo $i++;?></td>
                                <td><?php echo !empty($program_name) ? $program_name : "--"; ?></td>
                                <td><?php echo !empty($donation_amount) ? "$".number_format($donation_amount) : "--"; ?></td>
                                <td><?php echo !empty($donor_name) ? $donor_name : "--"; ?></td>
                                <td><?php echo !empty($donor_email) ? $donor_email : "--"; ?></td>
                                <td><?php echo !empty($donor_phone) ? $donor_phone : "--"; ?></td>
                                <td><?php echo !empty($donor_city) ? $donor_city : "--"; ?></td>
                                <td><?php echo !empty($donor_state) ? $donor_state : "--"; ?></td>
                                <td><?php 
                                if(!empty($pledge_promise_date) && (bool)strtotime($pledge_promise_date)){
                                    echo date("F jS, Y", strtotime($pledge_promise_date)); 
                                }else{
                                    echo '--';
                                }
                                ?></td>
                            </tr>
                            <?php
                        }
                        wp_reset_postdata();
                    }else{
                        echo '<tr><td colspan="9">No Record Found !</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <div class="tablenav">
                <div class="tablenav-pages"  style="float: left;">
                    <span class="pagination-links">
                        <?php
                        global $wp_query;
    $big = 999999999; // need an unlikely integer
    echo paginate_links( array(
        'format' => '?paged=%#%',
        'current' => max( 1, $paged ),
        'total' => $the_query->max_num_pages,
        'prev_text'          => __('«'),
        'next_text'          => __('»'),
    ));
    ?> 
</span>
</div>
</div>

<?php
}else{
    ?>


    <table class="wp-list-table widefat  striped posts" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Donation</th> 
                <th>Amount</th> 
                <th>Donor Name</th> 
                <th>Email</th> 
                <th>Phone</th> 
                <th>City</th> 
                <th>State</th> 
                <th>Date</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            $paged = isset($_GET['paged']) ? $_GET['paged'] : 1;

            $args = array(
                'post_type' => 'hf_donations',
                'posts_per_page' => -1,
                'posts_per_page' => 10,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key'     => 'hfusa-program_id',
                        'value'   => $compareArray,
                        'compare' => 'IN',
                    ),
                    array(
                        'key'     => 'hfusa-donation_type',
                        'value'   => "Donation",
                        'compare' => '=',
                    )
                ),
                'paged' => $paged,
            );



            $the_query = new WP_Query( $args );

            if ( $the_query->have_posts() ) { 

                $i=1;
                $i=$i+(($paged-1)*10);

                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $postId=get_the_ID();
                    $donation_amount=get_post_meta( $postId, 'hfusa-donation_amount',true );
                    $donor_name=get_post_meta( $postId, 'hfusa-donor_name',true );
                    $donor_email=get_post_meta( $postId, 'hfusa-donor_email',true );
                    $donor_phone=get_post_meta( $postId, 'hfusa-donor_phone',true );
                    $donor_city=get_post_meta( $postId, 'hfusa-donor_city',true );
                    $donor_state=get_post_meta( $postId, 'hfusa-donor_state',true );
                    $title=get_the_title();
                    ?>
                    <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo !empty($title) ? $title : "--"; ?></td>
                        <td><?php echo !empty($donation_amount) ? "$".number_format($donation_amount) : "--"; ?></td>
                        <td><?php echo !empty($donor_name) ? $donor_name : "--"; ?></td>
                        <td><?php echo !empty($donor_email) ? $donor_email : "--"; ?></td>
                        <td><?php echo !empty($donor_phone) ? $donor_phone : "--"; ?></td>
                        <td><?php echo !empty($donor_city) ? $donor_city : "--"; ?></td>
                        <td><?php echo !empty($donor_state) ? $donor_state : "--"; ?></td>
                        <td><?php echo get_the_date( 'F jS, Y', $postId );; ?></td>
                    </tr>
                    <?php
                }
                wp_reset_postdata();
            }else{

                echo '<tr><td colspan="9">No Record Found !</td></tr>';
            }

            ?>


        </tbody>
    </table>
    <div class="tablenav">
        <div class="tablenav-pages"  style="float: left;">
            <span class="pagination-links">
                <?php
                global $wp_query;
            $big = 999999999; // need an unlikely integer
            echo paginate_links( array(
                'format' => '?paged=%#%',
                'current' => max( 1, $paged ),
                'total' => $the_query->max_num_pages,
                'prev_text'          => __('«'),
                'next_text'          => __('»'),
            ));
            ?> 
        </span>
    </div>
</div>



<?php
}
?>




</div>
</div>
<?php
}else if(isset($_GET['campaign_id']) && !empty($_GET['campaign_id'])){



    $campaign_id = $_GET['campaign_id'];
    $compareArray=array($campaign_id);
    if($campaign_id==$generaLProgramId){
        $compareArray[]='';
    }

    $tab=isset($_GET['tab']) && !empty($_GET['tab']) ? $_GET['tab'] : 'donation';

    ?>

    <div class="wrap">

        <a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations">Back</a>

        <h1><?php echo get_the_title($program_id); ?> Donations</h1>

        <div class="donation-tabs">
            <ul>
                <li>
                    <a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations&campaign_id=<?php echo $campaign_id; ?>&tab=donation" class="<?php

                    if($tab=='donation'){
                        echo 'current-tab';
                    }

                    ?>">Donations</a>
                </li>
                <li>
                    <a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations&campaign_id=<?php echo $campaign_id; ?>&tab=pledge" class="<?php

                    if($tab=='pledge'){
                        echo 'current-tab';
                    }

                    ?>">Pledges</a>
                </li>
            </ul>
        </div>


        <?php
        if($tab=='pledge'){
            ?>

            <table class="wp-list-table widefat  striped posts" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Donation</th> 
                        <th>Amount</th> 
                        <th>Donor Name</th> 
                        <th>Email</th> 
                        <th>Phone</th> 
                        <th>City</th> 
                        <th>State</th> 
                        <th>Pledge Promise Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $paged = isset($_GET['paged']) ? $_GET['paged'] : 1;

                    $args = array(
                        'post_type' => 'hf_donations',
                        'posts_per_page' => -1,
                        'posts_per_page' => 10,
                        'meta_query' => array(
                            'relation' => 'AND',
                            array(
                                'key'     => 'hfusa-donation_campaign_id',
                                'value'   => $compareArray,
                                'compare' => 'IN',
                            ),
                            array(
                                'key'     => 'hfusa-donation_type',
                                'value'   => "Pledge",
                                'compare' => '=',
                            )
                        ),
                        'paged' => $paged,
                    );



                    $the_query = new WP_Query( $args );

                    if ( $the_query->have_posts() ) { 

                        $i=1;
                        $i=$i+(($paged-1)*10);

                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            $postId=get_the_ID();
                            $donation_amount=get_post_meta( $postId, 'hfusa-donation_amount',true );
                            $donor_name=get_post_meta( $postId, 'hfusa-donor_name',true );
                            $donor_email=get_post_meta( $postId, 'hfusa-donor_email',true );
                            $donor_phone=get_post_meta( $postId, 'hfusa-donor_phone',true );
                            $donor_city=get_post_meta( $postId, 'hfusa-donor_city',true );
                            $donor_state=get_post_meta( $postId, 'hfusa-donor_state',true );
                            $pledge_promise_date=get_post_meta( $postId, 'hfusa-pledge_promise_date',true );
                            $title=get_the_title();
                            ?>
                            <tr>
                                <td><?php echo $i++;?></td>
                                <td><?php echo !empty($title) ? $title : "--"; ?></td>
                                <td><?php echo !empty($donation_amount) ? "$".number_format($donation_amount) : "--"; ?></td>
                                <td><?php echo !empty($donor_name) ? $donor_name : "--"; ?></td>
                                <td><?php echo !empty($donor_email) ? $donor_email : "--"; ?></td>
                                <td><?php echo !empty($donor_phone) ? $donor_phone : "--"; ?></td>
                                <td><?php echo !empty($donor_city) ? $donor_city : "--"; ?></td>
                                <td><?php echo !empty($donor_state) ? $donor_state : "--"; ?></td>
                                <td><?php 
                                if(!empty($pledge_promise_date) && (bool)strtotime($pledge_promise_date)){
                                    echo date("F jS, Y", strtotime($pledge_promise_date)); 
                                }else{
                                    echo '--';
                                }
                                ?></td>
                            </tr>
                            <?php
                        }
                        wp_reset_postdata();
                    }else{
                        echo '<tr><td colspan="9">No Record Found !</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
            <div class="tablenav">
                <div class="tablenav-pages"  style="float: left;">
                    <span class="pagination-links">
                        <?php
                        global $wp_query;
$big = 999999999; // need an unlikely integer
echo paginate_links( array(
    'format' => '?paged=%#%',
    'current' => max( 1, $paged ),
    'total' => $the_query->max_num_pages,
    'prev_text'          => __('«'),
    'next_text'          => __('»'),
));
?> 
</span>
</div>
</div>

<?php
}else{
    ?>


    <table class="wp-list-table widefat  striped posts" cellspacing="0">
        <thead>
            <tr>
                <th>#</th>
                <th>Program</th> 
                <th>Amount</th> 
                <th>Donor Name</th> 
                <th>Email</th> 
                <th>Phone</th> 
                <th>City</th> 
                <th>State</th> 
                <th>Date</th> 
            </tr>
        </thead>
        <tbody>
            <?php
            $paged = isset($_GET['paged']) ? $_GET['paged'] : 1;

            $args = array(
                'post_type' => 'hf_donations',
                'posts_per_page' => -1,
                'posts_per_page' => 10,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key'     => 'hfusa-donation_campaign_id',
                        'value'   => $compareArray,
                        'compare' => 'IN',
                    ),
                    array(
                        'key'     => 'hfusa-donation_type',
                        'value'   => "Donation",
                        'compare' => '=',
                    )
                ),
                'paged' => $paged,
            );



            $the_query = new WP_Query( $args );

            if ( $the_query->have_posts() ) { 

                $i=1;
                $i=$i+(($paged-1)*10);

                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $postId=get_the_ID();
                    $donation_amount=get_post_meta( $postId, 'hfusa-donation_amount',true );
                    $program_id=get_post_meta( $postId, 'hfusa-program_id',true );
                    $program_name_meta=get_post_meta( $postId, 'hfusa-program_name',true );
                    $donor_name=get_post_meta( $postId, 'hfusa-donor_name',true );
                    $donor_email=get_post_meta( $postId, 'hfusa-donor_email',true );
                    $donor_phone=get_post_meta( $postId, 'hfusa-donor_phone',true );
                    $donor_city=get_post_meta( $postId, 'hfusa-donor_city',true );
                    $donor_state=get_post_meta( $postId, 'hfusa-donor_state',true );

                    $program_name = get_the_title($program_id);

                    if(empty($program_name)){
                        $program_name = $program_name_meta;    
                    }
                    ?>
                    <tr>
                        <td><?php echo $i++;?></td>
                        <td><?php echo !empty($program_name) ? $program_name : "--"; ?></td>
                        <td><?php echo !empty($donation_amount) ? "$".number_format($donation_amount) : "--"; ?></td>
                        <td><?php echo !empty($donor_name) ? $donor_name : "--"; ?></td>
                        <td><?php echo !empty($donor_email) ? $donor_email : "--"; ?></td>
                        <td><?php echo !empty($donor_phone) ? $donor_phone : "--"; ?></td>
                        <td><?php echo !empty($donor_city) ? $donor_city : "--"; ?></td>
                        <td><?php echo !empty($donor_state) ? $donor_state : "--"; ?></td>
                        <td><?php echo get_the_date( 'F jS, Y', $postId );; ?></td>
                    </tr>
                    <?php
                }
                wp_reset_postdata();
            }else{

                echo '<tr><td colspan="9">No Record Found !</td></tr>';
            }

            ?>


        </tbody>
    </table>
    <div class="tablenav">
        <div class="tablenav-pages"  style="float: left;">
            <span class="pagination-links">
                <?php
                global $wp_query;
            $big = 999999999; // need an unlikely integer
            echo paginate_links( array(
                'format' => '?paged=%#%',
                'current' => max( 1, $paged ),
                'total' => $the_query->max_num_pages,
                'prev_text'          => __('«'),
                'next_text'          => __('»'),
            ));
            ?> 
        </span>
    </div>
</div>



<?php
}
?>


</div>
</div>

<?php

}else{


    $tab=isset($_GET['tab']) && !empty($_GET['tab']) ? $_GET['tab'] : 'programs';
    ?>
    <div class="wrap">
        <h1>Donations</h1>

        <div class="donation-tabs">
            <ul>
                <li>
                    <a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations&tab=programs" class="<?php
                    if($tab=='programs'){
                        echo 'current-tab';
                    }
                    ?>">Programs</a>
                </li>
                <li>
                    <a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations&tab=campaigns" class="<?php
                    if($tab=='campaigns'){
                        echo 'current-tab';
                    }
                    ?>">Campaigns</a>
                </li>
            </ul>
        </div><!-- end .donation-tabs -->


        <?php if($tab=='campaigns'){

            $args = array(
                'post_type' => 'hf_donations',
                'posts_per_page' => -1,
                'meta_query' => array(
                    'relation' => 'AND',
                    array(
                        'key'     => 'hfusa-donation_campaign_id',
                        'compare' => 'EXISTS',
                    )
                ),
            );

            $the_query = new WP_Query( $args );
            $programsDetails=array();
/*            echo '<pre>';
            print_r($the_query->posts);
            echo '</pre>';*/

            if ( $the_query->have_posts() ) {
                while ( $the_query->have_posts() ) {
                    $the_query->the_post();
                    $postId=get_the_ID();
                    $campaign_id=get_post_meta( $postId, 'hfusa-donation_campaign_id',true );
                    $donation_amount=get_post_meta( $postId, 'hfusa-donation_amount',true );
                    $program_id=get_post_meta( $postId, 'hfusa-program_id',true );
                    $program_name_meta=get_post_meta( $postId, 'hfusa-program_name',true );
                    $donation_for=get_post_meta( $postId, 'hfusa-donation_for',true );
                    $donation_for=get_post_meta( $postId, 'hfusa-donation_for',true );
                    $donation_type=get_post_meta( $postId, 'hfusa-donation_type',true );
                    $donation_type=strtolower($donation_type);
                    $donation_amount=(!empty($donation_amount) && is_numeric($donation_amount)) ? $donation_amount : 0;
                    $programsDetails[$campaign_id][$donation_type] +=$donation_amount;
                    $programsDetails[$campaign_id]['name'] = get_the_title($campaign_id);
                }
                wp_reset_postdata();
            } 
       /*     echo '<pre>';
            print_r($programsDetails);
            echo '</pre>';*/

            $programsNamesList='';
            $programsDonationList='';
            $programsPledgeList='';

            $donationPercentage = array();
            $i=0;
            foreach ($programsDetails as $key => $value) {
                $name=$value["name"];
                $donation=isset($value["donation"]) ? $value["donation"] : 0;
                $pledge=isset($value["pledge"]) ? $value["pledge"] : 0;
                $programsNamesList .="'".$name."',";
                $programsDonationList .=$donation.",";
                $programsPledgeList .=$pledge.",";


                $donationPercentage[$i]["name"]=$name;
                $donationPercentage[$i]["y"]=$donation+$pledge;

                if($name=='General'){
                    $donationPercentage[$i]["sliced"]=true;
                    $donationPercentage[$i]["selected"]=true;
                }
                $i++;
            }

            $donationPercentageJson=json_encode($donationPercentage);

            ?>
            <div id="hf-donations-barchart" style="min-width: 310px; height:400px; margin: 0 auto;"></div>
            <br />
            <div>
                <div id="hf-donations-piechart" style="width: 49%; height: 400px;float: left; margin-right: 1%;"></div>



                <div style="width: 49%; height: 400px;float: left;background-color: #fff; margin-left: 1%;">

                    <div style="padding: 0 15px;">
                        <h3>Campaigns Donations Record</h3>
                        <table class="wp-list-table widefat fixed striped posts" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="50%">Campaign Name</th> 
                                    <th width="18%">Donations</th>
                                    <th width="18%">Pledges</th> 
                                    <th width="14%">Actions</th> 
                                </tr>
                            </thead>
                            <tbody>

                                <?php

                                $paged = isset($_GET['paged']) ? $_GET['paged'] : 1;

                                $args = array(
                                    'post_type' => 'hf_campaigns',
                                    'posts_per_page' => 10,
                                    'paged' => $paged
                                );

                                $the_query = new WP_Query( $args );

                                if ( $the_query->have_posts() ) {
                                    while ( $the_query->have_posts() ) {
                                        $the_query->the_post();
                                        $postId=get_the_ID();
                                        $donation=isset($programsDetails[$postId]['donation']) ? $programsDetails[$postId]['donation'] : 0;
                                        $pledge=isset($programsDetails[$postId]['pledge']) ? $programsDetails[$postId]['pledge'] : 0;
                                        ?>
                                        <tr>
                                            <td><a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations&campaign_id=<?php echo $postId; ?>"><?php the_title(); ?></a></td>
                                            <td>$<?php echo number_format($donation); ?></td>
                                            <td>$<?php echo number_format($pledge); ?></td>
                                            <td><a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations&campaign_id=<?php echo $postId; ?>">View</a></td>
                                        </tr>
                                        <?php
                                    }
                                    wp_reset_postdata();
                                }else{

                                    echo '<tr><td colspan="4">No Record Found !</td></tr>';
                                }

                                ?>

                            </tbody>
                        </table>

                        <div class="tablenav-pages">
                            <span class="pagination-links">
                                <?php
                                global $wp_query;
                            $big = 999999999; // need an unlikely integer
                            echo paginate_links( array(
                                'format' => '?paged=%#%',
                                'current' => max( 1, $paged ),
                                'total' => $the_query->max_num_pages
                            ));
                            ?> 
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <script type="text/javascript">


            Highcharts.setOptions({
                lang: {
                    decimalPoint: '.',
                    thousandsSep: ','
                }
            });

            Highcharts.chart('hf-donations-barchart', {
                chart: {
                    type: 'column'
                },
                title: {
                    text: 'Donations Record'
                },
                subtitle: {
                    text: 'Record for the Donations'
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: [<?php echo $programsNamesList; ?>],
                    crosshair: true
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Amount in US Dollars'
                    }
                },
                tooltip: {
                    headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0"><b>${point.y:,.0f}</b></td></tr>',
                    footerFormat: '</table>',
                    shared: true,
                    useHTML: true
                },
                plotOptions: {
                    column: {
                        pointPadding: 0.2,
                        borderWidth: 0,
                        dataLabels: {
                            enabled: true,
                            format: '$ {point.y:,.0f}'
                        }
                    }
                },
                series: [ 
                {
                    name: 'Donations',
                    data: [<?php echo $programsDonationList; ?>]
                },
                {
                    name: 'Pledges',
                    data: [<?php echo $programsPledgeList; ?>]
                }

                ]
            });
        </script> 


        <script type="text/javascript">

            Highcharts.chart('hf-donations-piechart', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Percentage of donations for each Campaign'
                },
                tooltip: {
                    pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
                },
                plotOptions: {
                    pie: {
                        allowPointSelect: true,
                        cursor: 'pointer',
                        dataLabels: {
                            enabled: true,
                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                            style: {
                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                            }
                        }
                    }
                },
                credits: {
                    enabled: false
                },
                series: [{
                    name: 'Donations',
                    colorByPoint: true,
                    data: <?php echo $donationPercentageJson; ?>
                }]
            });
        </script>





    <?php } else{

      $args = array(
        'post_type' => 'hf_donations',
        'posts_per_page' => -1
    );

      $the_query = new WP_Query( $args );
      $programsArr=array();

      if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $postId=get_the_ID();
            $program_id=get_post_meta( $postId, 'hfusa-program_id',true );
            $donation_amount=get_post_meta( $postId, 'hfusa-donation_amount',true );
            $donation_for=get_post_meta( $postId, 'hfusa-donation_for',true );
            $donation_type=get_post_meta( $postId, 'hfusa-donation_type',true );
            $donation_type=strtolower($donation_type);


            $donation_amount=(!empty($donation_amount) && is_numeric($donation_amount)) ? $donation_amount : 0;


            if(!isset($programsArr[$generaLProgramId][$donation_type])) {
              $programsArr[$generaLProgramId][$donation_type] = 0;
          }

          if(!isset($programsArr[$program_id][$donation_type])) {
              $programsArr[$program_id][$donation_type] = 0;
          }


          if(strtolower($donation_for)=='general'){
            $programsArr[$generaLProgramId][$donation_type] +=$donation_amount;
        }else{
            /* if the program id is empty , consider the donation as General*/
            if(empty($program_id)){
                $programsArr[$generaLProgramId][$donation_type] +=$donation_amount;
            }else{
                $programsArr[$program_id][$donation_type] +=$donation_amount;
            }
        }

    }
    wp_reset_postdata();
} 

/*

echo '<pre>';
print_r($programsArr);
echo '</pre>';*/



$args = array(
    'post_type' => 'hf_programs',
    'posts_per_page' => -1
);

$the_query = new WP_Query( $args );
$programsDetails=array();

if ( $the_query->have_posts() ) {
    while ( $the_query->have_posts() ) {
        $the_query->the_post();
        $postId=get_the_ID();
        $programsDetails[$postId]['name']=get_the_title();
        $programsDetails[$postId]['donation']=isset($programsArr[$postId]['donation']) ? $programsArr[$postId]['donation'] : 0;
        $programsDetails[$postId]['pledge']=isset($programsArr[$postId]['pledge']) ? $programsArr[$postId]['pledge'] : 0;
    }
    wp_reset_postdata();
}


/*
echo '<pre>';
print_r($programsDetails);
echo '</pre>';*/

$programsNamesList='';
$programsDonationList='';
$programsPledgeList='';

$donationPercentage = array();
$i=0;
foreach ($programsDetails as $key => $value) {
   $name=$value["name"];
   $donation=isset($value["donation"]) ? $value["donation"] : 0;
   $pledge=isset($value["pledge"]) ? $value["pledge"] : 0;
   $programsNamesList .="'".$name."',";
   $programsDonationList .=$donation.",";
   $programsPledgeList .=$pledge.",";


   $donationPercentage[$i]["name"]=$name;
   $donationPercentage[$i]["y"]=$donation+$pledge;

   if($name=='General'){
    $donationPercentage[$i]["sliced"]=true;
    $donationPercentage[$i]["selected"]=true;
}
$i++;
}

$donationPercentageJson=json_encode($donationPercentage);



?>


<div id="hf-donations-barchart" style="min-width: 310px; height:400px; margin: 0 auto;"></div>
<br />
<div>

    <div id="hf-donations-piechart" style="width: 49%; height: 400px;float: left; margin-right: 1%;"></div>


    <div style="width: 49%; height: 400px;float: left;background-color: #fff; margin-left: 1%;">

        <div style="padding: 0 15px;">
            <h3>Programs Donations Record</h3>
            <table class="wp-list-table widefat fixed striped posts" cellspacing="0">
                <thead>
                    <tr>
                        <th width="50%">Program Name</th> 
                        <th width="18%">Donations</th>
                        <th width="18%">Pledges</th> 
                        <th width="14%">Actions</th> 
                    </tr>
                </thead>
                <tbody>

                    <?php

                    $paged = isset($_GET['paged']) ? $_GET['paged'] : 1;

                    $args = array(
                        'post_type' => 'hf_programs',
                        'posts_per_page' => 10,
                        'paged' => $paged
                    );

                    $the_query = new WP_Query( $args );

                    if ( $the_query->have_posts() ) {
                        while ( $the_query->have_posts() ) {
                            $the_query->the_post();
                            $postId=get_the_ID();
                            $donation=isset($programsArr[$postId]['donation']) ? $programsArr[$postId]['donation'] : 0;
                            $pledge=isset($programsArr[$postId]['pledge']) ? $programsArr[$postId]['pledge'] : 0;
                            ?>
                            <tr>
                                <td><a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations&program_id=<?php echo $postId; ?>"><?php the_title(); ?></a></td>
                                <td>$<?php echo number_format($donation); ?></td>
                                <td>$<?php echo number_format($pledge); ?></td>
                                <td><a href="<?php echo get_admin_url(); ?>/edit.php?post_type=hf_donations&page=hf-donations&program_id=<?php echo $postId; ?>">View</a></td>
                            </tr>
                            <?php
                        }
                        wp_reset_postdata();
                    }else{

                        echo '<tr><td>No Record Found !</td></tr>';
                    }

                    ?>




                </tbody>
            </table>

            <div class="tablenav-pages">
                <span class="pagination-links">
                    <?php
                    global $wp_query;
            $big = 999999999; // need an unlikely integer
            echo paginate_links( array(
                'format' => '?paged=%#%',
                'current' => max( 1, $paged ),
                'total' => $the_query->max_num_pages
            ));
            ?> 
        </span>
    </div>

</div>
</div>
</div>

<script type="text/javascript">


    Highcharts.setOptions({
        lang: {
          decimalPoint: '.',
          thousandsSep: ','
      }
  });

    Highcharts.chart('hf-donations-barchart', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Donations Record'
        },
        subtitle: {
            text: 'Record for the Donations'
        },
        credits: {
            enabled: false
        },
        xAxis: {
            categories: [<?php echo $programsNamesList; ?>],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Amount in US Dollars'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>${point.y:,.0f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '$ {point.y:,.0f}'
                }
            }
        },
        series: [ 
        {
            name: 'Donations',
            data: [<?php echo $programsDonationList; ?>]
        },
        {
            name: 'Pledges',
            data: [<?php echo $programsPledgeList; ?>]
        }

        ]
    });
</script> 

<script type="text/javascript">

    Highcharts.chart('hf-donations-piechart', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Percentage of donations for each Program'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Donations',
            colorByPoint: true,
            data: <?php echo $donationPercentageJson; ?>
        }]
    });
</script>

<?php } ?>


</div>


<?php

}


}


?>