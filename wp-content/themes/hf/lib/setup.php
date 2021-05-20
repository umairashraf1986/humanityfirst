<?php
namespace Roots\Sage\Setup;

use Roots\Sage\Assets;

/**
 * Theme setup
 */
function setup() {
  // Enable features from Soil when plugin is activated
  // https://roots.io/plugins/soil/
  add_theme_support('soil-clean-up');
  add_theme_support('soil-nav-walker');
  add_theme_support('soil-nice-search');
  add_theme_support('soil-jquery-cdn');
  add_theme_support('soil-relative-urls');

  // Make theme available for translation
  // Community translations can be found at https://github.com/roots/sage-translations
  load_theme_textdomain('sage', get_template_directory() . '/lang');

  // Enable plugins to manage the document title
  // http://codex.wordpress.org/Function_Reference/add_theme_support#Title_Tag
  add_theme_support('title-tag');

  // Register wp_nav_menu() menus
  // http://codex.wordpress.org/Function_Reference/register_nav_menus
  register_nav_menus([
    'primary_navigation' => __('Primary Navigation', 'sage'),
    'footer_navigation' => __('Footer Navigation', 'sage')
  ]);

  // Enable post thumbnails
  // http://codex.wordpress.org/Post_Thumbnails
  // http://codex.wordpress.org/Function_Reference/set_post_thumbnail_size
  // http://codex.wordpress.org/Function_Reference/add_image_size
  add_theme_support('post-thumbnails');

  // Enable post formats
  // http://codex.wordpress.org/Post_Formats
  add_theme_support('post-formats', ['aside', 'gallery', 'link', 'image', 'quote', 'video', 'audio']);

  // Enable HTML5 markup support
  // http://codex.wordpress.org/Function_Reference/add_theme_support#HTML5
  add_theme_support('html5', ['caption', 'comment-form', 'comment-list', 'gallery', 'search-form']);

  // Use main stylesheet for visual editor
  // To add custom styles edit /assets/styles/layouts/_tinymce.scss
  add_editor_style(Assets\asset_path('styles/main.css'));
}
add_action('after_setup_theme', __NAMESPACE__ . '\\setup');

/**
 * Register sidebars
 */
function widgets_init() {
  register_sidebar([
    'name'          => __('Primary', 'sage'),
    'id'            => 'sidebar-primary',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);

  register_sidebar([
    'name'          => __('Footer', 'sage'),
    'id'            => 'sidebar-footer',
    'before_widget' => '<section class="widget %1$s %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => '<h3>',
    'after_title'   => '</h3>'
  ]);
}
add_action('widgets_init', __NAMESPACE__ . '\\widgets_init');

/**
 * Determine which pages should NOT display the sidebar
 */
function display_sidebar() {
  static $display;

  isset($display) || $display = !in_array(true, [
    // The sidebar will NOT be displayed if ANY of the following return true.
    // @link https://codex.wordpress.org/Conditional_Tags
    is_404(),
    is_front_page(),
    is_page_template('template-custom.php'),
  ]);

  return apply_filters('sage/display_sidebar', $display);
}

/**
 * Theme assets
 */
function assets() {

  wp_enqueue_style('hf-jqueryui-datepicker-style', get_stylesheet_directory_uri().'/bower_components/jqueryui-datepicker/datepicker.css', false, null);
  wp_enqueue_style('hf-custom-scrollbar-style', get_stylesheet_directory_uri().'/assets/styles/components/jquery.mCustomScrollbar.min.css', false, null);


  my_enqueuer('sage/css', 'dist/styles/main.css', 'style');

  // Google Fonts
/*  wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css?family=Raleway:100,400,700,800', false, null);
*/
if (is_single() && comments_open() && get_option('thread_comments')) {
  wp_enqueue_script('comment-reply');
}

  // wp_enqueue_script( 'hf-stripe-script', 'https://js.stripe.com/v3/', array('jquery'), null, true );

  // wp_enqueue_script( 'hf-paypal-script', 'https://www.paypalobjects.com/api/checkout.js', array('jquery'), null, true );

  // wp_enqueue_script( 'hf-stripe-checkout-script', 'https://checkout.stripe.com/checkout.js', array('jquery'), null, true );

 /* wp_enqueue_script( 'hf-fullpage', get_stylesheet_directory_uri() . '/node_modules/fullpage.js/dist/jquery.fullpage.js', array('jquery'), null, true );

  wp_enqueue_script( 'hf-slick-slider-js', get_stylesheet_directory_uri() . '/bower_components/slick-carousel/slick/slick.min.js', array('jquery'), null, true );

  wp_enqueue_script( 'hf-jqueryui-datepicker-script', get_stylesheet_directory_uri().'/bower_components/jqueryui-datepicker/datepicker.js', array('jquery'), null, true );

  wp_enqueue_script( 'hf-jquery-validation-script', get_stylesheet_directory_uri().'/node_modules/jquery-validation/dist/jquery.validate.min.js', array('jquery'), null, true );*/
  
  wp_enqueue_script( 'add-to-calendar-scripts', 'https://addevent.com/libs/atc/1.6.1/atc.min.js', array('jquery'), true );

  wp_enqueue_script( 'hf-jqueryui-datepicker-script', get_stylesheet_directory_uri().'/bower_components/jqueryui-datepicker/datepicker.js', array('jquery'), null, true );

  wp_enqueue_script( 'highmaps-js', get_stylesheet_directory_uri().'/assets/scripts/highmaps.js', array('jquery'), null, true );
  wp_enqueue_script( 'us-all-js', get_stylesheet_directory_uri().'/assets/scripts/us-all.js', array('jquery'), null, true );
  wp_enqueue_script( 'custom-scroll-js', get_stylesheet_directory_uri().'/assets/scripts/jquery.mCustomScrollbar.concat.min.js', array('jquery'), null, false );
  my_enqueuer('custom-js', 'assets/scripts/custom.js', 'script', ['jquery']);

  my_enqueuer('sage/js', 'dist/scripts/main.js', 'script', ['jquery']);

  $isFrontend = 0;

  if (strpos($_SERVER['SCRIPT_FILENAME'], 'wp-admin') !== false || strpos($_SERVER['SCRIPT_FILENAME'], 'wp-login.php') !== false || strpos($_SERVER['SCRIPT_FILENAME'], 'wp-cron.php') !== false) {

  } else {
    $isFrontend = 1;
    $parse_uri = explode( 'index.php', $_SERVER['SCRIPT_FILENAME'] );
    require_once( $parse_uri[0] . 'wp-load.php' );
  }

  if($isFrontend) {
    $args = array(
      'post_type' => 'hf_hero_slides',
      'posts_per_page' => -1
    );
    $slides_loop = new \WP_Query($args);
    $numOfSlides = $slides_loop->post_count;

    wp_localize_script( 'sage/js', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'numOfSlides' => $numOfSlides ) ); // setting ajaxurl
  } else {
    wp_localize_script( 'sage/js', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // setting ajaxurl
    wp_localize_script( 'custom-js', 'ajax_object', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) ); // setting ajaxurl
  }
}
add_action('wp_enqueue_scripts', __NAMESPACE__ . '\\assets', 100);
