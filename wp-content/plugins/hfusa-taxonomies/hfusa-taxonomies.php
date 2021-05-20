<?php
/*
   Plugin Name: HFUSA Custom Taxonomies
   Plugin URI: http://usa.humanityfirst.org
   Description: A custom plugin for creating Taxonomies for HFUSA
   Version: 1.0
   Author: Oracular
   Author URI: http://oracular.com
   License: GPL2
   */


// Custom Taxonomy for Sponsors
function sponsor_category() {

    $labels = array(
        'name'                       => _x( 'Categories', 'Taxonomy General Name', 'sage' ),
        'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'sage' ),
        'menu_name'                  => __( 'Category', 'sage' ),
        'all_items'                  => __( 'All Items', 'sage' ),
        'parent_item'                => __( 'Parent Item', 'sage' ),
        'parent_item_colon'          => __( 'Parent Item:', 'sage' ),
        'new_item_name'              => __( 'New Item Name', 'sage' ),
        'add_new_item'               => __( 'Add New Item', 'sage' ),
        'edit_item'                  => __( 'Edit Item', 'sage' ),
        'update_item'                => __( 'Update Item', 'sage' ),
        'view_item'                  => __( 'View Item', 'sage' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sage' ),
        'popular_items'              => __( 'Popular Items', 'sage' ),
        'search_items'               => __( 'Search Items', 'sage' ),
        'not_found'                  => __( 'Not Found', 'sage' ),
        'no_terms'                   => __( 'No items', 'sage' ),
        'items_list'                 => __( 'Items list', 'sage' ),
        'items_list_navigation'      => __( 'Items list navigation', 'sage' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'sponsor_category', array( 'hf_sponsors' ), $args );

}
add_action( 'init', 'sponsor_category', 0 );

// Custom Taxonomy for Projects
function project_category() {

    $labels = array(
        'name'                       => _x( 'Categories', 'Taxonomy General Name', 'sage' ),
        'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'sage' ),
        'menu_name'                  => __( 'Categories', 'sage' ),
        'all_items'                  => __( 'All Items', 'sage' ),
        'parent_item'                => __( 'Parent Item', 'sage' ),
        'parent_item_colon'          => __( 'Parent Item:', 'sage' ),
        'new_item_name'              => __( 'New Item Name', 'sage' ),
        'add_new_item'               => __( 'Add New Item', 'sage' ),
        'edit_item'                  => __( 'Edit Item', 'sage' ),
        'update_item'                => __( 'Update Item', 'sage' ),
        'view_item'                  => __( 'View Item', 'sage' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sage' ),
        'popular_items'              => __( 'Popular Items', 'sage' ),
        'search_items'               => __( 'Search Items', 'sage' ),
        'not_found'                  => __( 'Not Found', 'sage' ),
        'no_terms'                   => __( 'No items', 'sage' ),
        'items_list'                 => __( 'Items list', 'sage' ),
        'items_list_navigation'      => __( 'Items list navigation', 'sage' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'project_category', array( 'hf_projects' ), $args );

}
add_action( 'init', 'project_category', 0 );

// Custom Taxonomy for Jobs
function job_category() {

    $labels = array(
        'name'                       => _x( 'Categories', 'Taxonomy General Name', 'sage' ),
        'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'sage' ),
        'menu_name'                  => __( 'Categories', 'sage' ),
        'all_items'                  => __( 'All Items', 'sage' ),
        'parent_item'                => __( 'Parent Item', 'sage' ),
        'parent_item_colon'          => __( 'Parent Item:', 'sage' ),
        'new_item_name'              => __( 'New Item Name', 'sage' ),
        'add_new_item'               => __( 'Add New Item', 'sage' ),
        'edit_item'                  => __( 'Edit Item', 'sage' ),
        'update_item'                => __( 'Update Item', 'sage' ),
        'view_item'                  => __( 'View Item', 'sage' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sage' ),
        'popular_items'              => __( 'Popular Items', 'sage' ),
        'search_items'               => __( 'Search Items', 'sage' ),
        'not_found'                  => __( 'Not Found', 'sage' ),
        'no_terms'                   => __( 'No items', 'sage' ),
        'items_list'                 => __( 'Items list', 'sage' ),
        'items_list_navigation'      => __( 'Items list navigation', 'sage' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'job_category', array( 'hf_jobs' ), $args );

}
add_action( 'init', 'job_category', 0 );

// Custom Taxonomy for Events
function events_category() {

    $labels = array(
        'name'                       => _x( 'Categories', 'Taxonomy General Name', 'sage' ),
        'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'sage' ),
        'menu_name'                  => __( 'Categories', 'sage' ),
        'all_items'                  => __( 'All Items', 'sage' ),
        'parent_item'                => __( 'Parent Item', 'sage' ),
        'parent_item_colon'          => __( 'Parent Item:', 'sage' ),
        'new_item_name'              => __( 'New Item Name', 'sage' ),
        'add_new_item'               => __( 'Add New Item', 'sage' ),
        'edit_item'                  => __( 'Edit Item', 'sage' ),
        'update_item'                => __( 'Update Item', 'sage' ),
        'view_item'                  => __( 'View Item', 'sage' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sage' ),
        'popular_items'              => __( 'Popular Items', 'sage' ),
        'search_items'               => __( 'Search Items', 'sage' ),
        'not_found'                  => __( 'Not Found', 'sage' ),
        'no_terms'                   => __( 'No items', 'sage' ),
        'items_list'                 => __( 'Items list', 'sage' ),
        'items_list_navigation'      => __( 'Items list navigation', 'sage' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'events_category', array( 'hf_events' ), $args );

}
add_action( 'init', 'events_category', 0 );

// Custom Taxonomy for Downloads
function downloads_category() {

    $labels = array(
        'name'                       => _x( 'Categories', 'Taxonomy General Name', 'sage' ),
        'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'sage' ),
        'menu_name'                  => __( 'Category', 'sage' ),
        'all_items'                  => __( 'All Items', 'sage' ),
        'parent_item'                => __( 'Parent Item', 'sage' ),
        'parent_item_colon'          => __( 'Parent Item:', 'sage' ),
        'new_item_name'              => __( 'New Item Name', 'sage' ),
        'add_new_item'               => __( 'Add New Item', 'sage' ),
        'edit_item'                  => __( 'Edit Item', 'sage' ),
        'update_item'                => __( 'Update Item', 'sage' ),
        'view_item'                  => __( 'View Item', 'sage' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sage' ),
        'popular_items'              => __( 'Popular Items', 'sage' ),
        'search_items'               => __( 'Search Items', 'sage' ),
        'not_found'                  => __( 'Not Found', 'sage' ),
        'no_terms'                   => __( 'No items', 'sage' ),
        'items_list'                 => __( 'Items list', 'sage' ),
        'items_list_navigation'      => __( 'Items list navigation', 'sage' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'downloads_category', array( 'hf_downloads' ), $args );

}
add_action( 'init', 'downloads_category', 0 );

// Adding Custom Taxonomy

add_action( 'init', 'sb_post_type_rest_support', 999 );
function sb_post_type_rest_support() {
    global $wp_post_types;
    //be sure to set this to the name of your post type!
    $post_type_name = 'sponsor_category';
    if( isset( $wp_post_types[ $post_type_name ] ) ) {
        $wp_post_types[$post_type_name]->show_in_rest = true;
        $wp_post_types[$post_type_name]->rest_base = $post_type_name;
        $wp_post_types[$post_type_name]->rest_controller_class = 'WP_REST_Posts_Controller';
    }
}

// Custom Taxonomy for Campaigns
function campaign_category() {

    $labels = array(
        'name'                       => _x( 'Categories', 'Taxonomy General Name', 'sage' ),
        'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'sage' ),
        'menu_name'                  => __( 'Categories', 'sage' ),
        'all_items'                  => __( 'All Items', 'sage' ),
        'parent_item'                => __( 'Parent Item', 'sage' ),
        'parent_item_colon'          => __( 'Parent Item:', 'sage' ),
        'new_item_name'              => __( 'New Item Name', 'sage' ),
        'add_new_item'               => __( 'Add New Item', 'sage' ),
        'edit_item'                  => __( 'Edit Item', 'sage' ),
        'update_item'                => __( 'Update Item', 'sage' ),
        'view_item'                  => __( 'View Item', 'sage' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sage' ),
        'popular_items'              => __( 'Popular Items', 'sage' ),
        'search_items'               => __( 'Search Items', 'sage' ),
        'not_found'                  => __( 'Not Found', 'sage' ),
        'no_terms'                   => __( 'No items', 'sage' ),
        'items_list'                 => __( 'Items list', 'sage' ),
        'items_list_navigation'      => __( 'Items list navigation', 'sage' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'campaign_category', array( 'hf_campaigns' ), $args );

}
add_action( 'init', 'campaign_category', 0 );

// Custom Taxonomy for Alerts
function alerts_category() {

    $labels = array(
        'name'                       => _x( 'Categories', 'Taxonomy General Name', 'sage' ),
        'singular_name'              => _x( 'Category', 'Taxonomy Singular Name', 'sage' ),
        'menu_name'                  => __( 'Categories', 'sage' ),
        'all_items'                  => __( 'All Items', 'sage' ),
        'parent_item'                => __( 'Parent Item', 'sage' ),
        'parent_item_colon'          => __( 'Parent Item:', 'sage' ),
        'new_item_name'              => __( 'New Item Name', 'sage' ),
        'add_new_item'               => __( 'Add New Item', 'sage' ),
        'edit_item'                  => __( 'Edit Item', 'sage' ),
        'update_item'                => __( 'Update Item', 'sage' ),
        'view_item'                  => __( 'View Item', 'sage' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'sage' ),
        'add_or_remove_items'        => __( 'Add or remove items', 'sage' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'sage' ),
        'popular_items'              => __( 'Popular Items', 'sage' ),
        'search_items'               => __( 'Search Items', 'sage' ),
        'not_found'                  => __( 'Not Found', 'sage' ),
        'no_terms'                   => __( 'No items', 'sage' ),
        'items_list'                 => __( 'Items list', 'sage' ),
        'items_list_navigation'      => __( 'Items list navigation', 'sage' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => false,
        'show_in_rest'               => true,
    );
    register_taxonomy( 'alerts_category', array( 'hf_alerts' ), $args );

}
add_action( 'init', 'alerts_category', 0 );
?>