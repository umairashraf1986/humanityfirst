<?php
/*
*
* Template Name: Donation Test
*
*/
?>
<style>
    #paypal-button {
        margin-top: 50px;
        background: transparent;
        border: none;
        padding: 0;
    }
    .main-wrapper {
        padding-top: 80px;
    }
    #stripe-button {
        width: 250px;
        border-radius: 6px;
        box-shadow: none;
        background: #009bc1;
        color: #FFF;
        font-weight: bold;
        font-size: 18px;
        border: none;
        padding: 3px 0;
    }
    #pledge-form {
        display: none;
    }
</style>

<?php

    $project_id = $_GET['project_id'];
    $project_name = $_GET['project_name'];

    $current_user = wp_get_current_user();

//    echo "<pre>";
//    print_r($current_user);
//    echo "</pre>";
//    exit;

?>
<form action="<?php echo get_stylesheet_directory_uri() . '/charge-stripe.php'; ?>" id="donation_form" method="post">
    <div class="container">
        <div class="form-check">
            <label for="donation_amount">Donation Amount</label>
            <div class="input-group">
                <span class="input-group-addon">$</span>
                <input type="text" class="form-control" name="amount" id="donation_amount" value="50">
                <span class="input-group-addon">.00</span>
            </div>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="donation_group" id="donate_radio" value="donate" checked>
                Donate
            </label>
        </div>
        <div class="form-check form-check-inline">
            <label class="form-check-label">
                <input class="form-check-input" type="radio" name="donation_group" id="pledge_radio" value="pledge">
                Pledge
            </label>
        </div>
        <input type="hidden" name="projectID" id="project_id" value="<?php echo $project_id;?>">
        <input type="hidden" name="projectName" id="project_name" value="<?php echo $project_name;?>">
        <input type="hidden" name="donorID" id="donor_id" value="<?php echo $current_user->ID; ?>">
        <input type="hidden" name="donorName" id="donor_name" value="<?php echo $current_user->display_name; ?>">
        <input type="hidden" name="donorEmail" id="donor_email" value="<?php echo get_user_meta($current_user->ID, 'phone_number', true); ?>">
        <input type="hidden" name="donorPhone" id="donor_phone" value="<?php echo get_user_meta($current_user->ID, 'get_user_email', true); ?>">
        <input type="hidden" name="donationFor" value="project">
        <input type="hidden" name="donationType" value="donation">
        <input type="hidden" name="donationState" value="Connecticut">
        <input type="hidden" name="platform" value="web">
        <div id="donation-btns">
            <button id="paypal-button"></button>
            <br>
            <button id="stripe-button" type="submit">Stripe</button>
        </div>
        <br>
        <div id="pledge-form">
            <label for="pledge_promise_date">Pledge Promise Date</label>
            <input type="text" name="pledge_promise_date" id="pledge_promise_date">
            <button class="btn btn-blue" id="pledge-btn">Pledge</button>
        </div>
    </div>
</form>
