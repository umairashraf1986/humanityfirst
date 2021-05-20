<?php use Roots\Sage\Titles; ?>

<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>
  
  <div class="iptc-content">
    <h1>Response</h1>
  </div>

  <div class="overlay"></div>
</section>
  <div class="page-wrapper">
    <div class="page-title-section">
      <div class="container">
        <div class="row align-items-center h-100 mt-4 mb-4">
          <div class="col-12">
              <?php
                // echo "<pre>";
                // print_r($_POST);
                // echo "</pre>";
                if(isset($_GET['success']) && $_GET['success']) {
                  if($_GET['type'] == 'Donation') {
                    $message = "Successfully charged $".$_GET['amount']." as ".$_GET['type']."<br><br>Thank You!";
                  } else {
                    $message = "Successfully recorded ".$_GET['type']." for $".$_GET['amount']."<br><br>Thank You!";
                  }
                  
                } else {
                  $message = $_GET['message'];
                }
              ?>
              <h2 class="text-center"><?php echo $message; ?></h2>
          </div>
        </div>
      </div>
    </div>
  </div>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->