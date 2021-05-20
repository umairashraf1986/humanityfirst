<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>
  
  <div class="iptc-content">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<section class="blog-content page-wrapper">

    <div class="hf-grid-layout hf-gl-events">
        <div class="container">            
          <div class="row hf-gl-row">
            <?php $loop = new WP_Query( array( 'post_type' => 'hf_videos', 'posts_per_page' => -1 ) ); ?>
            <?php while ( $loop->have_posts() ) : $loop->the_post(); 

              $youtube_video_url = get_post_meta( get_the_ID(), 'hfusa-youtube_video_url', true);

              preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $youtube_video_url, $match);

              $youtube_id = isset($match[1]) ? $match[1] : '';

              if(!empty($youtube_id)){

                ?>
                <div class="col-sm-12 col-md-4 col-lg-3">
                  <div class="hf-gl-item">
                    <div class="hf-gl-item-img">
                      <a href="<?php the_permalink(); ?>" class="video-thumbnail" id="<?php echo $youtube_id; ?>" data-toggle="modal" data-target="#youtube-video-modal">
                        <iframe width="230" height="130" style="width: 100%; height: 180px; margin-bottom:-6px; " src="https://www.youtube.com/embed/<?php echo $youtube_id; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
                      </a>
                    </div>
                  </div>
                </div>
                <?php 
              }
            endwhile; 
            wp_reset_query(); 
            ?>

          </div>
        </div>
    </div>

</section>
<div class="clearfix"></div>

<!-- Modal -->
<div class="modal fade video-popup-modal" id="youtube-video-modal" tabindex="-1" role="dialog" aria-labelledby="youtubeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-content-body"><img class="video-loader" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/loader.gif" ></div>
    </div>
  </div>
</div>
<script type="text/javascript">  
  jQuery(document).ready(function($){    
    $(".video-thumbnail").click(function(){
      var video_id = $(this).attr("id");
      $("#modal-content-body").html('<img class="video-loader" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/loader.gif" ><iframe width="100%" height="500"style="position: relative;z-index: 2;" src="https://www.youtube.com/embed/'+video_id+'?rel=0&autoplay=1" frameborder="0" allowfullscreen></iframe>');
    });
    $('#youtube-video-modal').on('hidden.bs.modal', function (e) {
      $("#modal-content-body").html('<img class="video-loader" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/loader.gif" >');
    });
  });
</script>