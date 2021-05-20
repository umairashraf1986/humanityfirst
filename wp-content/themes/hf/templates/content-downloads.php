<?php use Roots\Sage\Titles; ?>
<!--==================================
= Hero Section =
=================================== -->

<section class="inner-page-title-section about-us-page" <?php echo hf_header_bg_img(); ?>>

  <div class="iptc-content filter-head-block">
    <h1><?= Titles\title(); ?></h1>
    <?php bootstrap_breadcrumb(); ?>
  </div>

  <div class="overlay"></div>
</section>
<div class="clearfix"></div>
<!--====  End of Hero Section  ====-->

<section class="blog-content page-wrapper">

  <div class="hf-grid-layout hf-gl-news">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <?php
          $category_names = "";
          $categoryClasses = "";
          $terms = get_terms('downloads_category');
          if ( $terms && !is_wp_error( $terms ) ) { ?>
            <div class="hf-gl-header">
              <ul class="hf-filter hf-news-filter">
                <li><a href="#!" data-filter="*">All</a></li>
                <?php
                foreach($terms as $category){
                  $category_names .= " ".$category->name;
                  $categoryClasses .= " ".$category->slug;
                  ?>
                  
                  <li><a href="#!" data-filter=".<?php echo $category->slug;?>" class="<?php echo $category->slug; ?>"><?php echo $category->name; ?></a></li>
                  
                  <?php
                }
                ?>
              </ul>
            </div>
            <?php
          } 
          ?>
        </div>
      </div>
      <div class="row hf-gl-row hf-filter-grid">
        <?php 
        $loop = new WP_Query(
         array( 
          'post_type' => 'hf_downloads', 
          'posts_per_page' => -1,
          'meta_query' => array(
            array(
              'key'     => 'hfusa-download_file',
              'compare' => 'EXISTS'
            )
          )
        )  
       );
        if ( $loop->have_posts() ) {
         while ( $loop->have_posts() ) : $loop->the_post(); ?>
          <?php
          $postId=get_the_ID();
          $theFile= get_post_meta( $postId, 'hfusa-download_file',true );
          $file_name = basename( $theFile );
          $file_extension = pathinfo($file_name);
          $extension=isset($file_extension["extension"]) ? $file_extension["extension"] : '';
          $category_names = "";
          $categoryClasses = "";
          $categories = wp_get_post_terms($postId, 'downloads_category', array("fields" => "all"));

          if(!empty($categories) && is_array($categories)){
            foreach($categories as $category){
              $category_names .= $category->name;
              $categoryClasses .= " ".$category->slug;
            }
          }
          ?>
          <div class="col-lg-3 col-md-6 col-sm-12 hf-grid-item <?php echo $categoryClasses; ?>">

            <div class="hf-gl-item">
              <div class="hf-gl-wrapper">
                <div class="hf-gl-item-cat">
                  <?php 
                  if(in_category('Featured')){ ?>

                    <span class="featured-tag"><i class="fa fa-bookmark-o"></i> Featured</span>

                  <?php } elseif(in_category('Popular')) { ?>

                    <span class="popular-tag"><i class="fa fa-bolt"></i> Popular</span>

                  <?php }
                  ?>

                </div>
                <?php if(trim($post->post_content) != "") {?>
                  <div class="hf-gl-item-text">
                    <?php the_content(); ?>
                  </div>
                <?php } ?>
                <?php

                $file_type = 'File';

                if(in_array($extension, array('png', 'gif', 'tiff', 'jpeg', 'jpg','bmp','svg'))){
                  $icon = '<i class="fa fa-file-image-o" aria-hidden="true"></i> ';
                  $file_type = 'Image File';
                }else if($extension=='docx' || $extension=='doc'){
                  $icon = '<i class="fa fa-file-word-o" aria-hidden="true"></i> ';
                  $file_type = 'Microsoft Word Document';
                }else if($extension=='pdf'){
                  $icon = '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> ';
                  $file_type = 'PDF';
                } else {
                  $icon = '<i class="fa fa-file-o" aria-hidden="true"></i>';
                  $file_type = 'File';
                }
                ?>
                <?php if(has_post_thumbnail(get_the_ID())){ ?>
                  <div class="hf-gl-item-img">
                    <a href="<?php echo get_permalink( $postId ) . '?attachment_post_id='.$postId.'&download_file=1'; ?>" rel="nofollow">
                      <img src="<?php echo get_the_post_thumbnail_url(); ?>" alt="<?php the_title(); ?>" />
                    </a>
                  </div>
                <?php } else { ?>
                  <div class="hf-gl-item-img">
                    <a href="<?php echo get_permalink( $postId ) . '?attachment_post_id='.$postId.'&download_file=1'; ?>" rel="nofollow" class="default-img">
                      <?php echo $icon; ?>
                    </a>
                  </div>
                  <?php
                } ?>
                <h2 class="hf-gl-item-heading float-left">
                  <span><?php the_title(); ?></span>
                </h2>
                <div class="hf-downloads-meta" style="border-bottom-left-radius: 5px; border-bottom-right-radius: 5px;">
                  <span class="file-type float-left"><?php echo $file_type; ?></span>
                  <?php
                  echo '<a href="' . get_permalink( $postId ) . '?attachment_post_id='.$postId.'&download_file=1" rel="nofollow" class="download-icon float-right">';
                  echo '<i class="fa fa-download" aria-hidden="true"></i>';
                  echo '</a>';
                  ?>
                </div>
              </div>
            </div>

          </div>

        <?php endwhile; wp_reset_query();

      }else{
        echo '<div class="col-sm-12">';
        echo 'Sorry, no download resource found.';
        echo '</div>';
      }
      ?>
    </div>
  </div>
</div>

</section>