<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<script src="https://www.paypalobjects.com/api/checkout.js"></script>
<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>
  <div class="iptc-content">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
</div>

<div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->
<style>
#pledge-form {
    display: none;
}
</style>
<!--====================================
=             PAGE                     =
=====================================-->
<?php   
$campaign_id = isset($_GET['campaign_id']) ? $_GET['campaign_id'] : '';
?>
<section class="page-wrapper be-a-sponsor">
	<div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-12 col-sm-12">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
<script type="text/javascript" src="https://checkout.stripe.com/checkout.js"></script>
<!--====  End of PAGE  ====-->