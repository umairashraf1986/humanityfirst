<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->



<?php 

$faq=isset($_GET['faq']) ? $_GET['faq'] : '';

?>

<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>
  
  <div class="iptc-content">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<style type="text/css">
  @import url('https://fonts.googleapis.com/css?family=Hind:300,400');
  @import url('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');

  .accordion a {
    position: relative;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
    width: 100%;
    padding: 1rem 3rem 1rem 1rem;
    color: #7288a2;
    font-size: 1.15rem;
    font-weight: 400;
    border-bottom: 1px solid #e5e5e5;
    line-height: 1.2;
  }

  .accordion a:hover,
  .accordion a:hover::after {
    cursor: pointer;
    color: #03b5d2;
  }

  .accordion a:hover::after {
    border: 1px solid #03b5d2;
  }

  .accordion a.active {
    color: #03b5d2;
    border-bottom: 1px solid #03b5d2;
  }

  .accordion a::after {
    font-family: 'Ionicons';
    content: '\f218';
    position: absolute;
    float: right;
    right: 1rem;
    font-size: 1rem;
    color: #7288a2;
    padding: 5px;
    width: 30px;
    height: 30px;
    -webkit-border-radius: 50%;
    -moz-border-radius: 50%;
    border-radius: 50%;
    border: 1px solid #7288a2;
    text-align: center;
  }

  .accordion a.active::after {
    font-family: 'Ionicons';
    content: '\f209';
    color: #03b5d2;
    border: 1px solid #03b5d2;
  }

  .accordion .content {
    opacity: 0;
    padding: 0 1rem;
    max-height: 0;
    border-bottom: 1px solid #e5e5e5;
    overflow: hidden;
    clear: both;
    -webkit-transition: all 0.2s ease 0.15s;
    -o-transition: all 0.2s ease 0.15s;
    transition: all 0.2s ease 0.15s;
  }

  .accordion .content p {
    font-size: 1rem;
    font-weight: 300;
  }

  .accordion .content.active {
    opacity: 1;
    padding: 1rem;
    max-height: 100%;
    -webkit-transition: all 0.35s ease 0.15s;
    -o-transition: all 0.35s ease 0.15s;
    transition: all 0.35s ease 0.15s;
  }
</style>

<section class="rscs-photo-gallery page-wrapper">




  <div class="container">
    <!-- <h3>Frequently Asked Questions</h3> -->
    <div class="accordion">
      <?php $loop = new WP_Query( array( 'post_type' => 'hf_questions', 'posts_per_page' => -1 ) ); ?>
      <?php while ( $loop->have_posts() ) : $loop->the_post();

$postId=get_the_ID();
?>

      <div class="accordion-item" id="faq-<?php echo $postId; ?>">
        <a class="<?php echo $faq==$postId ? 'active' : ''; ?>"><?php the_title(); ?></a>
        <div class="content <?php echo $faq==$postId ? 'active' : ''; ?>">
          <?php the_content(); ?>
        </div>
      </div>
      
      <?php endwhile; wp_reset_query(); ?>
    </div>
  </div>

</section>
  <?php
if(!empty($faq)){
   ?>
<script type="text/javascript">
  jQuery(document).ready(function( $ ) {  
    jQuery('html, body').animate({
      scrollTop: jQuery('#faq-'+<?php echo $faq; ?>).offset().top -200 
    }, 'fast');  
  });
</script>
<?php  } ?>