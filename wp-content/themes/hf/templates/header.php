<?php use Roots\Sage\Titles; ?>

<?php
$args = array(
  'post_type' => array('hf_campaigns', 'hf_events', 'hf_alerts'),
  'tax_query' => array(
    'relation' => 'OR',
    array(
      'taxonomy' => 'campaign_category',
      'field'    => 'slug',
      'terms'    => 'featured',
    ),
    array(
      'taxonomy' => 'events_category',
      'field'    => 'slug',
      'terms'    => 'featured',
    ),
    array(
      'taxonomy' => 'alerts_category',
      'field'    => 'slug',
      'terms'    => 'featured',
    ),
  ),
  'posts_per_page' => -1
);
$campaigns_loop = new WP_Query( $args );
$GLOBALS['campaigns'] = $campaigns_loop->have_posts();
if($campaigns_loop->have_posts()) {
  ?>
  <!-- Featured Campaigns -->
  <div class="featured-campaigns-ticker">
    <div class="row">
      <div class="col">
        <div class="featured-campaign-wrapper">
          <div class="featured-campaign-slider">
            <?php
            $events = array();
            $campaigns = array();
            $alerts = array();
            while($campaigns_loop->have_posts()) :
              $campaigns_loop->the_post();
              if(get_post_type() == 'hf_events') {
                $events[] = "<a href=".get_the_permalink()." class=\"featured-campaign-link\">".get_the_title()."</a>";
              }
              if(get_post_type() == 'hf_alerts') {
                $alerts[] = "<a href=".get_the_permalink()." class=\"featured-campaign-link\">".get_the_title()."</a>";
              }
              if(get_post_type() == 'hf_campaigns') {
                $campaigns[] = "<a href=".get_the_permalink()." class=\"featured-campaign-link\">".get_the_title()."</a>";
              }
              ?>
            <?php endwhile; ?>
            <?php
            if($alerts) {
              $alertStr = '<b>Alerts:</b> ';
              foreach ($alerts as $alert) {
                $alertStr .= $alert." ";
              }
              echo $alertStr;
            }
            if($events) {
              $eventStr = '<b>Events:</b> ';
              foreach ($events as $event) {
                $eventStr .= $event." ";
              }
              echo $eventStr;
            }
            if($campaigns) {
              $campaignStr = '<b>Campaigns:</b> ';
              foreach ($campaigns as $campaign) {
                $campaignStr .= $campaign." ";
              }
              echo $campaignStr;
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php } ?>


<?php 

if($campaigns_loop->have_posts()) {
  $campaignSliderClass = 'with-campaign-slider';
} else {
  $campaignSliderClass = '';
}

?>
<!--=============================
Header
============================= -->
<header class="header" id="header" <?php if($campaigns_loop->have_posts()) echo "style= 'top: 34px;'"; ?>>
  <div class="top-nav-bar">
    <div class="container">
      <div class="row">
        <div class="col">
          <nav class="navbar top-navigation navbar-light navbar-fixed navbar-expand-md bg-faded justify-content-center">
            <div class="col">
              <a class="navbar-brand d-flex mr-auto float-left" href="<?php echo home_url(); ?>"></a>
              <button class="navbar-toggler float-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            </div>
            <div class="collapse navbar-collapse float-right" id="navbarSupportedContent">
              <?php
              wp_nav_menu( array(
                'theme_location'  => 'primary',
                'menu'            => 'primary-menu',
                'container'       => 'div',
                'container_class' => '',
                'container_id'    => '',
                'menu_class'      => 'navbar-nav',
                'menu_id'         => '',
                'echo'            => true,
                'fallback_cb'     => 'wp_page_menu',
                'before'          => '',
                'after'           => '',
                'link_before'     => '',
                'link_after'      => '',
                'items_wrap'      => '<ul id = "%1$s" class = "%2$s '.$campaignSliderClass.'">%3$s</ul>',
                'depth'           => 0,
                'walker'          => new My_Walker_Nav_Menu(),
              ) );
              ?>
              <div class="nav-right-buttons float-right menudevider">
                <div class="dropdown float-right">
                  <a class="menu-icon dropdown-toggle d-none d-md-inline" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#!" title="Login/Logout">
                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                  </a>
                  <div class="dropdown-menu <?php if($campaigns_loop->have_posts()) echo 'with-campaign-slider';?>" aria-labelledby="dropdownMenuButton">
                    <?php
                    $registration_enabled = get_option('users_can_register');

                    if ($registration_enabled && !is_user_logged_in()) {
                      ?>
                      <a class="dropdown-item" href="<?php echo home_url(); ?>/member-login"><i
                        class="fa fa-sign-in" aria-hidden="true"></i> login</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo home_url(); ?>/member-register"><i
                          class="fa fa-user-plus" aria-hidden="true"></i> Signup</a>
                      <?php
                    }
                    ?>
                    <?php
                    if ($registration_enabled && is_user_logged_in()) {
                      if( isset($_SESSION['LOGGED_IN_BY']) ) {
                        if( $_SESSION['LOGGED_IN_BY'] == 'Facebook' ) {
                    ?>
                      <a class="dropdown-item logout-link" name="facebook-logout" href="<?php echo wp_logout_url(home_url()); ?>"><i
                        class="fa fa-power-off" aria-hidden="true"></i> Logout</a>

                    <?php
                      } elseif( $_SESSION['LOGGED_IN_BY'] == 'Google' ) {
                    ?>
                        <a class="dropdown-item logout-link" name="google-logout" href="<?php echo wp_logout_url(home_url()); ?>"><i
                          class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
                          <?php
                        }
                      } else {
                    ?>

                      <a class="dropdown-item" href="<?php echo home_url('member-account'); ?>"><i
                        class="fa fa-user" aria-hidden="true"></i> Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo wp_logout_url(home_url()); ?>"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>

                    <?php
                      }
                    }
                    ?>
                  </div>
                </div>
                <div class="mobile-options-menu d-md-none">
                  <?php
                  $registration_enabled = get_option('users_can_register');

                  if ($registration_enabled && !is_user_logged_in()) {
                    ?>
                    <a class="dropdown-item" href="<?php echo home_url(); ?>/member-login"><i class="fa fa-sign-in" aria-hidden="true"></i> login</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="<?php echo home_url(); ?>/member-register"><i class="fa fa-user-plus" aria-hidden="true"></i>
                    Signup</a>
                    <?php
                  }
                  ?>
                  <?php
                  if ($registration_enabled && is_user_logged_in()) {
                    ?>
                    <a class="dropdown-item" href="<?php echo wp_logout_url(home_url()); ?>"><i class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
                    <?php
                  }
                  ?>
                </div>
                <div class="search-icon float-right">
                  <a href="#" title="Search"><i class="fa fa-search"></i></a>
                  <div class="hf-search-form">
                    <form action="<?php echo home_url('/'); ?>">
                      <input autocomplete="off" placeholder="Search.." type="text" name="s" value="<?php echo get_search_query() ?>">
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </nav>
          <div class="nav-right-buttons float-right d-md-none">
            <?php
            wp_nav_menu( array(
              'theme_location'  => 'primary',
              'menu'            => 'primary-menu',
              'container'       => 'div',
              'container_class' => '',
              'container_id'    => '',
              'menu_class'      => 'navbar-nav-responsive',
              'menu_id'         => '',
              'echo'            => true,
              'fallback_cb'     => 'wp_page_menu',
              'before'          => '',
              'after'           => '',
              'link_before'     => '',
              'link_after'      => '',
              'items_wrap'      => '<ul id = "%1$s" class = "%2$s">%3$s</ul>',
              'depth'           => 0,
              'walker'          => '',
            ) );
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</header>
<?php /*
<header class="header" id="header" <?php if($campaigns_loop->have_posts()) echo "style= 'top: 34px;'"; ?>>
  <!-- Nav Bar -->
  <div class="top-nav-bar">
    <div class="container">
      <div class="row">
        <div class="col">
          <nav class="navbar top-navigation navbar-light navbar-fixed navbar-expand-md bg-faded justify-content-center">
            <div class="col">
              <a class="navbar-brand d-flex mr-auto float-left" href="<?php echo home_url(); ?>"></a>
              <button class="navbar-toggler float-right" type="button" data-toggle="collapse"
              data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
              aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse float-right" id="navbarSupportedContent">
            <ul class="navbar-nav">
              <li><a class="nav-link forAboutSlide" href="<?php echo home_url('/about-us'); ?>"
               id="navbarDropdownMenuLink1">about us</a>
               <div class="dropdown-menu <?php if($campaigns_loop->have_posts()) echo 'with-campaign-slider';?>" aria-labelledby="navbarDropdownMenuLink1">
                <div class="container">
                  <div class="header-large">
                    <div class="large-header-navigation about-navigation">
                      <ul>
                        <li><a href="<?php echo home_url('/history'); ?>"><span
                          class="sprite-icons hn-history"></span><span>History</span></a></li>
                          <li><a href="<?php echo home_url('/mission'); ?>"><span
                            class="sprite-icons hn-mission"></span><span>Mission</span></a></li>
                            <li><a href="<?php echo home_url('/team'); ?>"><span
                              class="sprite-icons hn-team"></span><span>Team</span></a></li>
                              <!-- <li><a href="<?php echo home_url('/stories'); ?>"><span
                                class="sprite-icons hn-stories"></span><span>Stories</span></a></li> -->
                                <li><a href="<?php echo home_url('/faqs'); ?>"><span
                                  class="hn-faqs sprite-icons"></span><span style="text-transform: none !important;">FAQs</span></a></li>
                                  <li><a href="<?php echo home_url('/sponsors'); ?>"><span
                                    class="sprite-icons hn-sponsors"></span><span>Sponsors</span></a></li>
                                    <li><a href="<?php echo home_url('/partners'); ?>"><span
                                      class="sprite-icons hn-partners"></span><span>Partners</span></a></li>
                                      <li><a href="<?php echo home_url('/global-sites'); ?>"><span
                                        class="sprite-icons hn-i-sites"></span><span>Global sites</span></a></li>
                                        <li><a href="<?php echo home_url('/message-from-chairman'); ?>"><span
                                          class="sprite-icons hn-i-chairman"></span><span>Message From Chairman</span></a></li>
                                          <li><a href="<?php echo home_url('/message-from-director'); ?>"><span
                                            class="sprite-icons hn-i-director"></span><span>Message From Director</span></a></li>
                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </li>
                                <li><a class="nav-link forWorkSlide" href="<?php echo home_url('/our-work'); ?>"
                                 id="navbarDropdownMenuLink2" aria-haspopup="true" aria-expanded="false">Our work</a>
                                 <div class="dropdown-menu <?php if($campaigns_loop->have_posts()) echo 'with-campaign-slider';?>" aria-labelledby="navbarDropdownMenuLink2">
                                  <div class="container">
                                    <div class="header-large">
                                      <div class="large-header-navigation what-we-do-navigation">
                                        <ul>
                                          <li><a href="<?php echo home_url('/programs'); ?>"><span
                                            class="hn-our-programs sprite-icons "></span><span>Our programs</span></a></li>
                                            <li><a href="<?php echo home_url('/geographic-regions'); ?>"><span
                                              class="hn-geo-regions sprite-icons"></span><span>Geographic regions</span></a>
                                            </li>
                                            <li><a href="<?php echo home_url('/projects'); ?>"><span
                                              class="hn-our-projects sprite-icons"></span><span>Our Projects</span></a></li>
                                            </ul>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </li>
                                  <li><a class="nav-link forImpactSlide" href="<?php echo home_url('/our-impact'); ?>"
                                   id="navbarDropdownMenuLink3">Our Impact</a>
                                   <div class="dropdown-menu <?php if($campaigns_loop->have_posts()) echo 'with-campaign-slider';?>" aria-labelledby="navbarDropdownMenuLink3">
                                    <div class="container">
                                      <div class="header-large">
                                        <div class="large-header-navigation our-impact-navigation">
                                          <ul>
                                            <li><a href="<?php echo home_url('/geographic-reach'); ?>"><span
                                              class="hn-geo-reach sprite-icons"></span><span>Geographic reach</span></a></li>
                                              <li><a href="<?php echo home_url('/years-in-the-field'); ?>"><span
                                                class="hn-yit-field sprite-icons"></span><span>Years in the field</span></a>
                                              </li>
                                              <li><a href="<?php echo home_url('/our-impact/lives-impacted'); ?>"><span
                                                class="hn-lives-impact sprite-icons"></span><span>Lives Impacted</span></a></li>
                                          <!-- <li><a href="<?php echo home_url('/dollars-raised'); ?>"><span
                                            class="hn-dollars-raised sprite-icons"></span><span>Dollars Raised</span></a>
                                          </li> -->
                                        </ul>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </li>
                              <li><a class="nav-link forHappeningSlide" href="<?php echo home_url('/current-happenings'); ?>"
                               id="navbarDropdownMenuLink4" aria-haspopup="true" aria-expanded="false">Current happenings</a>
                               <div class="dropdown-menu <?php if($campaigns_loop->have_posts()) echo 'with-campaign-slider';?>" aria-labelledby="navbarDropdownMenuLink4">
                                <div class="container">
                                  <div class="header-large">
                                    <div class="large-header-navigation in-the-news-navigation">

                                      <ul>
                                        <li><a href="<?php echo home_url('/news'); ?>"><span
                                          class="hn-latest-news sprite-icons"></span><span>Latest News</span></a></li>
                                          <li><a href="<?php echo home_url('/events'); ?>"><span
                                            class="hn-latest-events sprite-icons"></span><span>Events</span></a></li>
                                            <li><a href="<?php echo home_url('/campaigns'); ?>"><span
                                              class="hn-latest-campaigns sprite-icons"></span><span>Campaigns</span></a></li>
                                              <li><a href="<?php echo home_url('/message-board'); ?>"><span
                                                class="hn-message-board sprite-icons"></span><span>Message Board</span></a></li>
                                                <li><a href="<?php echo home_url('/blog'); ?>"><span
                                                  class="hn-blog sprite-icons"></span><span>Blog</span></a></li>
                                                  <li><a href="<?php echo home_url('/stories'); ?>"><span
                                                    class="sprite-icons hn-stories"></span><span>Stories</span></a></li>
                                                    <li><a href="<?php echo home_url('/alerts'); ?>"><span
                                                      class="hn-alert sprite-icons"></span><span>Alerts</span></a></li>
                                                    </ul>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </li>
                                          <li><a class="nav-link forResourcesSlide" href="<?php echo home_url('/multimedia'); ?>"
                                           id="navbarDropdownMenuLink5" aria-haspopup="true" aria-expanded="false">Multimedia</a>
                                           <div class="dropdown-menu <?php if($campaigns_loop->have_posts()) echo 'with-campaign-slider';?>" aria-labelledby="navbarDropdownMenuLink5">
                                            <div class="container">
                                              <div class="header-large">
                                                <div class="large-header-navigation helpful-resources-navigation">

                                                  <ul>
                                                    <li><a href="<?php echo home_url('/photo-gallery'); ?>"><span
                                                      class="hn-photo-gallery sprite-icons"></span><span>photo gallery</span></a></li>
                                                      <li><a href="<?php echo home_url('/videos'); ?>"><span
                                                        class="hn-videos sprite-icons"></span><span>videos</span></a></li>
                                                    <!-- <li><a href="<?php echo home_url('/faqs'); ?>"><span
                                                      class="hn-faqs sprite-icons"></span><span>FAQs</span></a></li> -->
                                                      <li><a href="<?php echo home_url('/downloads'); ?>"><span
                                                        class="hn-downloads sprite-icons"></span><span>downloads</span></a></li>
                                                      </ul>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </li>

                                            <li><a class="nav-link forInvolvedSlide" href="<?php echo home_url('/get-involved'); ?>"
                                             id="navbarDropdownMenuLink6" aria-haspopup="true" aria-expanded="false">get involved</a>
                                             <div class="dropdown-menu <?php if($campaigns_loop->have_posts()) echo 'with-campaign-slider';?>" aria-labelledby="navbarDropdownMenuLink6">
                                              <div class="container">
                                                <div class="header-large">
                                                  <div class="large-header-navigation get-involved-navigation">

                                                    <ul>

                                                      <li><a href="<?php echo home_url('/become-a-volunteer'); ?>"><span
                                                        class="hn-be-a-volunteer sprite-icons"></span><span>Become a volunteer</span></a>
                                                      </li>
                                                      <?php
                                                        $page = get_page_by_path( 'donate' );
                                                        $donate_url = get_post_meta($page->ID, 'hfusa-donate_button_header', true);
                                                      ?>
                                                      <li><a href="<?php echo (!empty($donate_url)) ? $donate_url : home_url( 'donate' ); ?>" target="_blank"><span
                                                        class="hn-donate sprite-icons"></span><span>donate</span></a>
                                                      </li>
                                                      <li><a href="<?php echo home_url('/become-a-sponsor'); ?>"><span
                                                        class="hn-be-a-sponser sprite-icons"></span><span>Become a Sponsor</span></a>
                                                      </li>
                                                    </ul>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </li>
                                          <li class="cart-link-menu d-none"><a href="<?php echo home_url('/cart'); ?>">Cart</a>
                                          </li>
                                        </ul>
                                        <div class="nav-right-buttons float-right menudevider">
                                          <?php
                                            $page = get_page_by_path( 'donate' );
                                            $donate_url = get_post_meta($page->ID, 'hfusa-donate_button_header', true);
                                          ?>
                                          <a href="<?php echo (!empty($donate_url)) ? $donate_url : home_url( 'donate' ); ?>" class="btn-blue d-none d-md-inline" target="_blank">donate</a>
                                          <a href="<?php echo home_url('/become-a-volunteer'); ?>"
                                           class="btn-blue d-none d-md-inline">Volunteer</a>

                                           <div class="dropdown float-right">
                                            <a class="menu-icon dropdown-toggle d-none d-md-inline" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#!" title="Login/Logout"><i class="fa fa-user-circle" aria-hidden="true"></i></a>
                                            <a class="menu-icon dropdown-toggle-cart d-none" id="dropdownMenuCart" href="#!">
                                              <i class="fa fa-shopping-cart" aria-hidden="true">
                                                <?php // if(WC()->cart->get_cart_contents_count()){ ?>
                                                  <span class="cart-qty" id="hf-cart-counter">
                                                    <?php // echo WC()->cart->get_cart_contents_count(); ?>
                                                  </span>
                                                  <?php //} ?>
                                                </i>
                                              </a>
                                              <div class="dropdown-menu <?php if($campaigns_loop->have_posts()) echo 'with-campaign-slider';?>" aria-labelledby="dropdownMenuButton">
                                                <?php

                                                // check to make sure user registration is enabled
                                                $registration_enabled = get_option('users_can_register');

                                                if ($registration_enabled && !is_user_logged_in()) {
                                                  ?>
                                                  <a class="dropdown-item" href="<?php echo home_url(); ?>/member-login"><i
                                                    class="fa fa-sign-in" aria-hidden="true"></i> login</a>
                                                    <div class="dropdown-divider"></div>
                                                    <a class="dropdown-item" href="<?php echo home_url(); ?>/member-register"><i
                                                      class="fa fa-user-plus" aria-hidden="true"></i> Signup</a>
                                                      <?php
                                                    }
                                                    ?>
                                                    <?php
                                                    if ($registration_enabled && is_user_logged_in()) {
                                                      if( isset($_SESSION['LOGGED_IN_BY']) ) {
                                                        if( $_SESSION['LOGGED_IN_BY'] == 'Facebook' ) {
                                                          ?>
                                                          <a class="dropdown-item logout-link" name="facebook-logout" href="<?php echo wp_logout_url(home_url()); ?>"><i
                                                            class="fa fa-power-off" aria-hidden="true"></i> Logout</a>

                                                            <?php
                                                          } elseif( $_SESSION['LOGGED_IN_BY'] == 'Google' ) {
                                                            ?>
                                                            <a class="dropdown-item logout-link" name="google-logout" href="<?php echo wp_logout_url(home_url()); ?>"><i
                                                              class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
                                                              <?php
                                                            }
                                                          } else {
                                                            ?>

                                                        <a class="dropdown-item" href="<?php echo home_url('member-account'); ?>"><i
                                                            class="fa fa-user" aria-hidden="true"></i> Profile</a>
                                                        <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="<?php echo wp_logout_url(home_url()); ?>"><i
                                                              class="fa fa-power-off" aria-hidden="true"></i> Logout</a>

                                                              <?php
                                                            }
                                                          }
                                                          ?>
                                                        </div>


                                                      </div>
                                                      <div class="mobile-options-menu d-md-none">
                                                        <?php

                                                        // check to make sure user registration is enabled
                                                        $registration_enabled = get_option('users_can_register');

                                                        if ($registration_enabled && !is_user_logged_in()) {
                                                          ?>
                                                          <a class="dropdown-item" href="<?php echo home_url(); ?>/member-login"><i
                                                            class="fa fa-sign-in" aria-hidden="true"></i> login</a>
                                                            <div class="dropdown-divider"></div>
                                                            <a class="dropdown-item" href="<?php echo home_url(); ?>/member-register"><i class="fa fa-user-plus"
                                                             aria-hidden="true"></i>
                                                           Signup</a>
                                                           <?php
                                                         }
                                                         ?>
                                                         <?php
                                                         if ($registration_enabled && is_user_logged_in()) {
                                                          ?>
                                                          <a class="dropdown-item" href="<?php echo wp_logout_url(home_url()); ?>"><i
                                                            class="fa fa-power-off" aria-hidden="true"></i> Logout</a>
                                                            <?php
                                                          }
                                                          ?>
                                                        </div>
                                                        <div class="search-icon float-right">
                                                          <a href="#" title="Search"><i class="fa fa-search"></i></a>
                                                          <div class="hf-search-form">
                                                            <form action="<?php echo home_url('/'); ?>">
                                                              <input autocomplete="off" placeholder="Search.." type="text" name="s" value="<?php echo get_search_query() ?>">
                                                            </form>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                  </nav>
                                                  <div class="nav-right-buttons float-right d-md-none">
                                                    <?php
                                                      $page = get_page_by_path( 'donate' );
                                                      $donate_url = get_post_meta($page->ID, 'hfusa-donate_button_header', true);
                                                    ?>
                                                    <a href="<?php echo (!empty($donate_url)) ? $donate_url : home_url( 'donate' ); ?>" class="btn-blue pull-left-btn" target="_blank">donate</a>
                                                    <a href="<?php echo home_url('/become-a-volunteer'); ?>" class="btn-blue pull-right-btn">Volunteer</a>
                                                  </div>
                                                  <div class="hf-mini-cart-cnt d-none">
                                                    <div class="widget_shopping_cart_content">
                                                      <?php // woocommerce_mini_cart(); ?>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <!-- ./Nav Bar -->
                                          </header>
                                          */?>
                                          <!--====  End of Header  ====-->

                                          <!-- Featured Sidebar -->
                                          <div class="featured-sidebar-campaigns fs-events fs-closed">
                                            <div class="featured-sidebar-inner" style="height: calc(100vh - 40px);">

                                              <?php 
                                              $loop = new WP_Query(
                                                array(
                                                  'post_type' => 'hf_campaigns',
                                                  'posts_per_page' => 4,
                                                )
                                              ); 
                                              ?>
                                              <?php while ($loop->have_posts()) : $loop->the_post();

                                                $postId=get_the_ID();

                                                ?>

                                                <!-- FS Item -->
                                                <div class="fs-item">
                                                  <div class="fs-item-img">
                                                    <a href="<?php the_permalink(); ?>">
                                                      <img src="<?php echo get_the_post_thumbnail_url($postId,'hf-custom-size-1'); ?>" alt="<?php the_title(); ?>"/>
                                                    </a>
                                                  </div>
                                                  <h3>
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                  </h3>
                                                </div>
                                                <!-- ./FS Item -->

                                              <?php endwhile; ?>
                                              <a href="<?php echo home_url('/campaigns'); ?>" class="view-all-events"><i class="fa fa-calendar" aria-hidden="true"></i> View All Campaigns</a>

                                              <?php wp_reset_query(); ?>

                                            </div>

                                            <div class="hf-cssload-thecube events-preloader">
                                              <div class="hf-cssload-cube cssload-c1"></div>
                                              <div class="hf-cssload-cube cssload-c2"></div>
                                              <div class="hf-cssload-cube cssload-c4"></div>
                                              <div class="hf-cssload-cube cssload-c3"></div>
                                            </div>
                                            <a href="#!" class="fs-trigger-campaigns"><i class="fa fa-bullhorn"></i> Campaigns</a>
                                          </div>

                                          <!-- Featured Sidebar -->
                                          <div class="featured-sidebar fs-events fs-closed">
                                            <div class="featured-sidebar-inner" id="hf-events-wrap" style="height: calc(100vh - 40px);">

                                              <?php 
                                              $loop = new WP_Query(
                                                array(
                                                  'post_type' => 'hf_events',
                                                  'posts_per_page' => 4,
                                                  'order'     => 'DESC',
                                                  'meta_key' => 'hfusa-event_date',
                                                  'orderby'   => 'meta_value'
                                                )
                                              ); 
                                              ?>
                                              <?php while ($loop->have_posts()) : $loop->the_post();

                                                $postId=get_the_ID();

                                                ?>

                                                <!-- FS Item -->
                                                <div class="fs-item">
                                                  <div class="fs-item-img">
                                                    <a href="<?php the_permalink(); ?>">
                                                      <img src="<?php echo get_the_post_thumbnail_url($postId,'hf-custom-size-1'); ?>" alt="<?php the_title(); ?>"/>
                                                    </a>
                                                  </div>
                                                  <h3>
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                  </h3>
                                                </div>
                                                <!-- ./FS Item -->

                                              <?php endwhile; ?>
                                              <a href="<?php echo home_url('/events'); ?>" class="view-all-events"><i class="fa fa-calendar" aria-hidden="true"></i> View All Events</a>

                                              <?php wp_reset_query(); ?>

                                            </div>

                                            <div class="hf-cssload-thecube events-preloader">
                                              <div class="hf-cssload-cube cssload-c1"></div>
                                              <div class="hf-cssload-cube cssload-c2"></div>
                                              <div class="hf-cssload-cube cssload-c4"></div>
                                              <div class="hf-cssload-cube cssload-c3"></div>
                                            </div>
                                            <a href="#!" class="fs-trigger"><i class="fa fa-calendar"></i> Events</a>
                                          </div>

                                          <?php
                                          $loop = new WP_Query(array('post_type' => 'hf_alerts', 'posts_per_page' => 10 ));
                                          if ( $loop->have_posts() ) {
                                            ?>

                                            <div class="featured-sidebar-alerts fs-events fs-closed">
                                              <div class="featured-sidebar-alerts-inner">


                                                <?php while ($loop->have_posts()) : $loop->the_post();

                                                  $postId=get_the_ID();

                                                  ?>

                                                  <!-- FS Item -->
                                                  <div class="fs-item">
                                                    <div class="alert-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></div>
                                                    <div class="alert-content"><?php the_excerpt(); ?></div>
                                                  </div>
                                                  <!-- ./FS Item -->

                                                <?php endwhile;
                                                ?>

                                                <a href="<?php echo home_url('/alerts'); ?>" class="view-all-alerts"><i class="fa fa-bell" aria-hidden="true"></i> View All Alerts</a>
                                                <?php
                                                wp_reset_query();
                                                ?>

                                              </div>
                                              <a href="#!" class="fs-trigger-alerts"><i class="fa fa-bell-o"></i> Alerts</a>
                                            </div>

                                          <?php } ?>

                                          <!-- ./Featured Sidebar -->

                                          <div class="fs-overlay"></div>
                                          <div class="fs-overlay-alerts"></div>
                                          <div class="fs-overlay-campaigns"></div>
