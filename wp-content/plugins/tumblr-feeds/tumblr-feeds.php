<?php
/*
   Plugin Name: Tumblr Feeds
   Plugin URI: http://usa.humanityfirst.org
   Description: A custom plugin for fetch Tumblr feeds
   Version: 1.0
   Author: M. Noman Rauf
   Author URI: http://oracular.com
   License: GPL2
   */
add_action('admin_menu', 'tumblr_feeds_menu');

function tumblr_feeds_menu()
{

    //create new top-level menu
    add_menu_page('Tumblr Feeds', 'Tumblr Feeds', 'administrator', __FILE__, 'tumblr_feeds_settings_page', 'dashicons-rss');

    //call register settings function
    add_action('admin_init', 'register_tumblr_feeds_plugin_settings');
}

function register_tumblr_feeds_plugin_settings()
{
    //register our settings
    register_setting('tumblr-feed-plugin-settings-group', '_consumer_key');
    register_setting('tumblr-feed-plugin-settings-group', '_consumer_secret');
    register_setting('tumblr-feed-plugin-settings-group', '_token');
    register_setting('tumblr-feed-plugin-settings-group', '_secret');
    register_setting('tumblr-feed-plugin-settings-group', '_blog_name');
    register_setting('tumblr-feed-plugin-settings-group', '_blog_category');
}

function tumblr_feeds_settings_page()
{
    ?>
    <div class="wrap">
        <h1>Tumblr Feeds Setting</h1>

        <form method="post" action="options.php">
            <?php settings_fields('tumblr-feed-plugin-settings-group'); ?>
            <?php do_settings_sections('tumblr-feed-plugin-settings-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">ConsumerKey</th>
                    <td><input style="width: 300px;" type="text" name="_consumer_key"
                               value="<?php echo esc_attr(get_option('_consumer_key')); ?>"/></td>
                </tr>

                <tr valign="top">
                    <th scope="row">ConsumerSecret</th>
                    <td><input style="width: 300px;" type="text" name="_consumer_secret"
                               value="<?php echo esc_attr(get_option('_consumer_secret')); ?>"/></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Token</th>
                    <td><input style="width: 300px;" type="text" name="_token"
                               value="<?php echo esc_attr(get_option('_token')); ?>"/></td>
                </tr>

                <tr valign="top">
                    <th scope="row">Secret</th>
                    <td><input style="width: 300px;" type="text" name="_secret"
                               value="<?php echo esc_attr(get_option('_secret')); ?>"/></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Tumblr Blog Name</th>
                    <td><input style="width: 300px;" type="text" name="_blog_name"
                               value="<?php echo esc_attr(get_option('_blog_name')); ?>" required/></td>
                </tr>
                <tr>
                    <th scope="row">Blog Category</th>
                    <td>
                        <select name="_blog_category" id="" required>
                            <option value="">Select Category</option>
                            <?php $categories = get_categories(array('type' => 'post', 'taxonomy' => 'category'));

                            foreach ($categories as $key => $val) {
                                echo "<option value='" . $val->slug . "'>" . $val->name . "</option>";
                            }
                            ?></select></td>
                </tr>

            </table>

            <?php submit_button(); ?>

        </form>
    </div>
    <div class="wrap">
        <h1>Import Feeds</h1>
        <form action="" method="post">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Start Date:</th>
                    <td><input type="date" name="start_date"></td>
                </tr>
                <tr valign="top">
                    <th scope="row">End Date:</th>
                    <td><input type="date" name="end_date"></td>
                </tr>
            </table>
            <?php submit_button('Import Feed'); ?>
        </form>

        <?php
        if (isset($_POST) && !empty($_POST)) {
            $startDate = (isset($_POST['start_date']) && $_POST['start_date'] != '') ? $_POST['start_date'] : '';
            $endDate = (isset($_POST['end_date']) && $_POST['end_date'] != '') ? $_POST['end_date'] : '';

            getTumblrFeeds($startDate, $endDate);
        }
        ?>
    </div>
    <?php
}

add_action('wp_ajax_get-tumblr-feeds', 'getTumblrFeeds');
add_action('wp_ajax_nopriv_get-tumblr-feeds', 'getTumblrFeeds');

function getTumblrFeeds($startDate = '', $endDate = '')
{
    require_once(dirname(__FILE__) . '/vendor/autoload.php');
    try {
        $consumerKey = get_option('_consumer_key', true);
        $consumerSecret = get_option('_consumer_secret', true);
        $token = get_option('_token', true);
        $secret = get_option('_secret', true);
        $client = new Tumblr\API\Client(
            $consumerKey,
            $consumerSecret,
            $token,
            $secret
        );

        $blogPosts = array();
        $category = array();
        $blogName = get_option('_blog_name');
        if ($blogName != '') {
            $blogInfo = $client->getBlogInfo($blogName);

            $category['cat_name'] = $blogInfo->blog->title;
            $category['category_nicename'] = $blogInfo->blog->name;
            $category['category_description'] = $blogInfo->blog->description;
            $category['category_parent'] = '';
            $totalPosts = $blogInfo->blog->posts;
            $limit = 50;
            $totalPages = $totalPosts / $limit;
            for ($page = 0; $page < $totalPages; $page++) {
                $offset = $page * $limit;
                $currentPage = $page + 1;
                $options = array('limit' => 50, 'offset' => $offset, 'page_number' => $currentPage);
                $blogData = $client->getBlogPosts($blogName, $options);
                $blogPosts = array_merge($blogPosts, $blogData->posts);
            }

            $idObj = get_category_by_slug('gift-of-sight');

            $_startDate = '';
            $_endDate = '';
            $response = array();

            foreach ($blogPosts as $key => $val) {
                $savePost = false;
                $timestamp = $val->timestamp;
                if ($startDate != '' && $endDate == '') {
                    $_startDate = strtotime($startDate);
                    if ($timestamp >= $_startDate) {
                        $savePost = true;
                    }
                } elseif ($endDate != '' && $startDate != '') {
                    $_startDate = strtotime($startDate);
                    $_endDate = strtotime($endDate);
                    if ($timestamp >= $_startDate && $timestamp <= $_endDate) {
                        $savePost = true;
                    }
                } else {
                    $savePost = true;
                }
                if ($savePost) {
                    echo "--- GET POST " . $val->id . "<br>";
                    $post = get_post_by_meta(array('meta_key' => '_tumblr_ID', 'meta_value' => $val->id));
                    if ($post == '') {
                        echo "--- SAVE POST " . $val->id . "<br>";
                        $postArray = array(
                            'post_author' => 1,
                            'post_date' => date('Y-m-d h:i:s', strtotime($val->date)),
                            'post_content' => ($val->body == '') ? $val->summary : $val->body,
                            'post_title' => ($val->title == '') ? $val->summary : $val->title,
                            'post_name' => $val->slug,
                            'post_category' => array($idObj->term_id),
                            'post_status' => 'publish'
                        );
                        $postID = wp_insert_post($postArray, $wp_error = false);
                        add_post_meta($postID, '_tumblr_ID', $val->id);
                        $response[] = $postID;
                    }
                }
            }
        } else {
            echo "Please enter your Tumblr blog url";
        }
        //wp_send_json(json_encode($response));
    } catch (Exception $e) {
        echo 'Message: ' . $e->getMessage();
    }
}

function get_post_by_meta($args = array())
{

    // Parse incoming $args into an array and merge it with $defaults - caste to object ##
    $args = ( object )wp_parse_args($args);

    // grab page - polylang will take take or language selection ##
    $args = array(
        'meta_query' => array(
            array(
                'key' => $args->meta_key,
                'value' => $args->meta_value
            )
        ),
        'post_type' => 'post',
        'posts_per_page' => '1'
    );

    // run query ##
    $posts = get_posts($args);

    // check results ##
    if (!$posts || is_wp_error($posts)) return false;

    // test it ##
    #pr( $posts[0] );

    // kick back results ##
    return $posts[0];

}

