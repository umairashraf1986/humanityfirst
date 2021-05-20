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

<style type="text/css">
  @import url('https://fonts.googleapis.com/css?family=Hind:300,400');
  @import url('https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css');

  .accordion a.job_title {
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

  .accordion a.job_title:hover,
  .accordion a.job_title:hover::after {
    cursor: pointer;
    color: #03b5d2;
  }

  .accordion a.job_title:hover::after {
    border: 1px solid #03b5d2;
  }

  .accordion a.job_title.active {
    color: #03b5d2;
    border-bottom: 1px solid #03b5d2;
  }

  .accordion a.job_title::after {
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

  .accordion a.job_title.active::after {
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

  .nf-before-form-content,
  .nf-after-form-content {
    display: none;
  }

  ul.job-meta {
    list-style: none;
    padding: 0;
  }

  ul.job-meta > li {
    display: inline-block;
    padding: 7px 15px;
    border-radius: 5px;
    border: 1px solid #ccc;
    margin-right: 10px;
    margin-bottom: 10px;
    font-size: 12px;
  }
</style>

<section class="rscs-photo-gallery page-wrapper">

  <div class="container">
    <h3>Jobs Available</h3>
    <?php $loop = new WP_Query(array('post_type' => 'hf_jobs', 'posts_per_page' => -1)); ?>
    <?php if($loop->have_posts()) { $count = 0; ?>
    <div class="accordion">
        <?php while ($loop->have_posts()) : $loop->the_post(); ?>
          <?php
          $skill_ids = rwmb_meta('hfusa-job_skills');
          if (count($skill_ids) > 0) {
            $skills = [];
            foreach ($skill_ids as $skill_id) {
              $skills[] = get_the_title($skill_id);
            }
          }
          if( rwmb_meta('hfusa-job_end_date') >= time() || empty(rwmb_meta('hfusa-job_end_date'))) {
            $count++;
            ?>
            <div class="accordion-item">
              <a class="job_title"><?php the_title(); ?></a>
              <div class="content">
                <ul class="job-meta">
                  <li>
                    <strong><i class="fa fa-clock-o" aria-hidden="true"></i> Job
                      Type:</strong> <?php echo rwmb_meta('hfusa-job_type'); ?>
                    </li>
                    <li>
                      <strong><i class="fa fa-clock-o" aria-hidden="true"></i> Job
                        Shift:</strong> <?php echo rwmb_meta('hfusa-job_shift'); ?>
                      </li>
                      <li>
                        <strong><i class="fa fa-list-ol" aria-hidden="true"></i>
                          Positions:</strong> <?php echo rwmb_meta('hfusa-job_positions'); ?>
                        </li>
                        <li>
                          <strong><i class="fa fa-file-text-o" aria-hidden="true"></i> Minimum
                            Experience:</strong> <?php echo rwmb_meta('hfusa-job_experience') . " Years"; ?>
                          </li>
                          <li>
                            <strong><i class="fa fa-map-marker"></i>
                              Location:</strong> <?php echo rwmb_meta('hfusa-job_location'); ?>
                            </li>
                            <li>
                              <strong><i class="fa fa-calendar"></i> Posted:</strong> <?php echo get_the_date('F jS, Y'); ?>
                            </li>
                            <?php if( rwmb_meta('hfusa-job_end_date') >= time() ) { ?>
                              <li>
                                <strong><i class="fa fa-calendar"></i> Apply
                                  Before:</strong> <?php echo date('F jS, Y', rwmb_meta('hfusa-job_end_date')); ?>
                                </li>
                                <?php
                              }
                              if (count($skill_ids) > 0) { ?>
                                <li>
                                  <strong><i class="fa fa-window-restore"></i> Skills
                                    Required:</strong> <?php echo implode(", ", $skills); ?>
                                  </li>
                                <?php } ?>
                              </ul>


                              <?php the_content(); ?>
                              <a href="<?php echo home_url(); ?>/apply-for-job?job_title=<?php echo the_title(); ?>"
                               class="btn btn-green">Apply</a>
                             </div>
                           </div>

                         <?php }
                       endwhile;
                       wp_reset_query();
                       if($count == 0) { ?>
                        <div class="text-center" style="font-size: 16px;">Currently there are no openings</div>
                       <?php }
                       ?>
                     </div>
                   <?php } else { ?>
                      <div class="text-center" style="font-size: 16px;">Currently there are no openings</div>
                   <?php } ?>
                   </div>

                 </section>