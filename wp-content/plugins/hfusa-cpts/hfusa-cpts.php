<?php
   /*
   Plugin Name: HFUSA Custom Post Types
   Plugin URI: http://usa.humanityfirst.org
   Description: A custom plugin for creating CPTs for HFUSA
   Version: 1.0
   Author: Oracular
   Author URI: http://oracular.com
   License: GPL2
   */

// Custom Post Type for HF Events
   function cpt_hf_events() {

   	$labels = array(
   		'name'                  => _x( 'Events', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Event', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Events', 'sage' ),
   		'name_admin_bar'        => __( 'Event', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Event', 'sage' ),
   		'description'           => __( 'CPT for HF Events', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-calendar-alt',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_events', $args );

   }
   add_action( 'init', 'cpt_hf_events', 0 );

// Custom Post Type for Programs
   function cpt_hf_programs() {

   	$labels = array(
   		'name'                  => _x( 'Programs', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Program', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Programs', 'sage' ),
   		'name_admin_bar'        => __( 'Program', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Program', 'sage' ),
   		'description'           => __( 'CPT for HF Programs', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-networking',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_programs', $args );

   }
   add_action( 'init', 'cpt_hf_programs', 0 );

// Custom Post Type for Projects
   function cpt_hf_projects() {

   	$labels = array(
   		'name'                  => _x( 'Projects', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Project', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Projects', 'sage' ),
   		'name_admin_bar'        => __( 'Project', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Project', 'sage' ),
   		'description'           => __( 'CPT for HF Projects', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-smiley',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_projects', $args );

   }
   add_action( 'init', 'cpt_hf_projects', 0 );

// Custom Post Type for Members
   function cpt_hf_members() {

   	$labels = array(
   		'name'                  => _x( 'Members', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Member', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Members', 'sage' ),
   		'name_admin_bar'        => __( 'Member', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Member', 'sage' ),
   		'description'           => __( 'CPT for HF Members', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-groups',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_members', $args );

   }
   add_action( 'init', 'cpt_hf_members', 0 );

// Custom Post Type for Sponsors
   function cpt_hf_sponsors() {

   	$labels = array(
   		'name'                  => _x( 'Sponsors', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Sponsor', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Sponsors', 'sage' ),
   		'name_admin_bar'        => __( 'Sponsor', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Sponsor', 'sage' ),
   		'description'           => __( 'CPT for HF Sponsors', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-heart',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_sponsors', $args );

   }
   add_action( 'init', 'cpt_hf_sponsors', 0 );

// Custom Post Type for Skills
   function cpt_hf_skills() {

   	$labels = array(
   		'name'                  => _x( 'Skills', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Skill', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Skills', 'sage' ),
   		'name_admin_bar'        => __( 'Skill', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Skill', 'sage' ),
   		'description'           => __( 'CPT for HF Skills', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-hammer',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_skills', $args );

   }
   add_action( 'init', 'cpt_hf_skills', 0 );

// Custom Post Type for Donations
   function cpt_hf_donations() {

   	$labels = array(
   		'name'                  => _x( 'Donations', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Donation', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Donations', 'sage' ),
   		'name_admin_bar'        => __( 'Donation', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Donation', 'sage' ),
   		'description'           => __( 'CPT for HF Donations', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-heart',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_donations', $args );

   }
   add_action( 'init', 'cpt_hf_donations', 0 );


//Custom Post Type for Speakers
   function cpt_hf_speakers() {

   	$labels = array(
   		'name'                  => _x( 'Speakers', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Speaker', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Speakers', 'sage' ),
   		'name_admin_bar'        => __( 'Speaker', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Speaker', 'sage' ),
   		'description'           => __( 'Custom post type for Speakers', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 5,
   		'menu_icon'             => 'dashicons-businessman',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_speakers', $args );

   }
   add_action( 'init', 'cpt_hf_speakers', 0 );

//Custom Post Type for Albums
   function cpt_hf_albums() {

   	$labels = array(
   		'name'                  => _x( 'Albums', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Album', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Albums', 'sage' ),
   		'name_admin_bar'        => __( 'Album', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Album', 'sage' ),
   		'description'           => __( 'Custom post type for Albums', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 5,
   		'menu_icon'             => 'dashicons-format-image',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_albums', $args );

   }
   add_action( 'init', 'cpt_hf_albums', 0 );

//Custom Post Type for Photos
   function cpt_hf_photos() {

   	$labels = array(
   		'name'                  => _x( 'Photos', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Photo', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Photos', 'sage' ),
   		'name_admin_bar'        => __( 'Photo', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Photo', 'sage' ),
   		'description'           => __( 'Custom post type for Photos', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 5,
   		'menu_icon'             => 'dashicons-images-alt',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_photos', $args );

   }
   add_action( 'init', 'cpt_hf_photos', 0 );

//Custom Post Type for Videos
   function cpt_hf_videos() {

   	$labels = array(
   		'name'                  => _x( 'Videos', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Video', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Videos', 'sage' ),
   		'name_admin_bar'        => __( 'Video', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Video', 'sage' ),
   		'description'           => __( 'Custom post type for Videos', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 5,
   		'menu_icon'             => 'dashicons-format-video',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_videos', $args );

   }
   add_action( 'init', 'cpt_hf_videos', 0 );

//Custom Post Type for Questions
   function cpt_hf_questions() {

   	$labels = array(
   		'name'                  => _x( 'Questions', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Question', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Questions', 'sage' ),
   		'name_admin_bar'        => __( 'Question', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Question', 'sage' ),
   		'description'           => __( 'Custom post type for Questions', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 5,
   		'menu_icon'             => 'dashicons-editor-help',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_questions', $args );

   }
   add_action( 'init', 'cpt_hf_questions', 0 );

//Custom Post Type for Downloads
   function cpt_hf_downloads() {

   	$labels = array(
   		'name'                  => _x( 'Downloads', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Download', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Downloads', 'sage' ),
   		'name_admin_bar'        => __( 'Download', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Download', 'sage' ),
   		'description'           => __( 'Custom post type for Downloads', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 5,
   		'menu_icon'             => 'dashicons-download',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_downloads', $args );

   }
   add_action( 'init', 'cpt_hf_downloads', 0 );

// Custom Post Type for HF Countries
   function cpt_hf_countries() {

   	$labels = array(
   		'name'                  => _x( 'Countries', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Country', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Countries', 'sage' ),
   		'name_admin_bar'        => __( 'Country', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Country', 'sage' ),
   		'description'           => __( 'CPT for HF Countries', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-flag',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_countries', $args );

   }
   add_action( 'init', 'cpt_hf_countries', 0 );

// Custom Post Type for Jobs
   function cpt_hf_jobs() {

   	$labels = array(
   		'name'                  => _x( 'Jobs', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Job', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Jobs', 'sage' ),
   		'name_admin_bar'        => __( 'Job', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Job', 'sage' ),
   		'description'           => __( 'CPT for HF Jobs', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-pressthis',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_jobs', $args );

   }
   add_action( 'init', 'cpt_hf_jobs', 0 );

// Custom Post Type for Testimonials
   function cpt_hf_testimonials() {

   	$labels = array(
   		'name'                  => _x( 'Testimonials', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Testimonial', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Testimonials', 'sage' ),
   		'name_admin_bar'        => __( 'Testimonial', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Testimonial', 'sage' ),
   		'description'           => __( 'CPT for HF Testimonials', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-format-status',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_testimonials', $args );

   }
   add_action( 'init', 'cpt_hf_testimonials', 0 );


// Custom Post Type for HF Partners
   function cpt_hf_partners() {

   	$labels = array(
   		'name'                  => _x( 'Partners', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Partner', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Partners', 'sage' ),
   		'name_admin_bar'        => __( 'Partner', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Partner', 'sage' ),
   		'description'           => __( 'CPT for HF Partners', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-image-filter',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_partners', $args );

   }
   add_action( 'init', 'cpt_hf_partners', 0 );


// Custom Post Type for HF Global-sites
   function cpt_hf_glbl_sites() {

   	$labels = array(
   		'name'                  => _x( 'Global Sites', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Global Site', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Global Sites', 'sage' ),
   		'name_admin_bar'        => __( 'Global Site', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Global Sites', 'sage' ),
   		'description'           => __( 'CPT for HF Global Sites', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-editor-kitchensink',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_glbl_sites', $args );

   }
   add_action( 'init', 'cpt_hf_glbl_sites', 0 );

// Custom Post Type for HF Quotes
   function cpt_hf_quotes() {

   	$labels = array(
   		'name'                  => _x( 'Quotes', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Quote', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Quotes', 'sage' ),
   		'name_admin_bar'        => __( 'Quote', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Quote', 'sage' ),
   		'description'           => __( 'CPT for HF Quotes', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-format-quote',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_quotes', $args );

   }
   add_action( 'init', 'cpt_hf_quotes', 0 );


// Custom Post Type for Coupons
   function cpt_hf_coupons() {

   	$labels = array(
   		'name'                  => _x( 'Coupons', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Coupon', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Coupons', 'sage' ),
   		'name_admin_bar'        => __( 'Coupon', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Coupon', 'sage' ),
   		'description'           => __( 'CPT for HF Coupons', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title',  ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-tickets-alt',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_coupons', $args );

   }
   add_action( 'init', 'cpt_hf_coupons', 0 );

// Custom Post Type for Alerts
   function cpt_hf_alerts() {

   	$labels = array(
   		'name'                  => _x( 'Alerts', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Alert', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Alerts', 'sage' ),
   		'name_admin_bar'        => __( 'Alert', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Alert', 'sage' ),
   		'description'           => __( 'CPT for HF Alerts', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-list-view',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_alerts', $args );

   }
   add_action( 'init', 'cpt_hf_alerts', 0 );



// Custom Post Type for HF Events
   function cpt_hf_campaigns() {

   	$labels = array(
   		'name'                  => _x( 'Campaigns', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Campaign', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Campaigns', 'sage' ),
   		'name_admin_bar'        => __( 'Campaign', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Campaign', 'sage' ),
   		'description'           => __( 'CPT for HF Campaigns', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 20,
   		'menu_icon'             => 'dashicons-megaphone',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_campaigns', $args );

   }
   add_action( 'init', 'cpt_hf_campaigns', 0 );


   function cpt_hf_presenters() {

   	$labels = array(
   		'name'                  => _x( 'Presenters', 'Post Type General Name', 'sage' ),
   		'singular_name'         => _x( 'Presenter', 'Post Type Singular Name', 'sage' ),
   		'menu_name'             => __( 'Presenters', 'sage' ),
   		'name_admin_bar'        => __( 'Presenter', 'sage' ),
   		'archives'              => __( 'Item Archives', 'sage' ),
   		'attributes'            => __( 'Item Attributes', 'sage' ),
   		'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
   		'all_items'             => __( 'All Items', 'sage' ),
   		'add_new_item'          => __( 'Add New Item', 'sage' ),
   		'add_new'               => __( 'Add New', 'sage' ),
   		'new_item'              => __( 'New Item', 'sage' ),
   		'edit_item'             => __( 'Edit Item', 'sage' ),
   		'update_item'           => __( 'Update Item', 'sage' ),
   		'view_item'             => __( 'View Item', 'sage' ),
   		'view_items'            => __( 'View Items', 'sage' ),
   		'search_items'          => __( 'Search Item', 'sage' ),
   		'not_found'             => __( 'Not found', 'sage' ),
   		'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
   		'featured_image'        => __( 'Featured Image', 'sage' ),
   		'set_featured_image'    => __( 'Set featured image', 'sage' ),
   		'remove_featured_image' => __( 'Remove featured image', 'sage' ),
   		'use_featured_image'    => __( 'Use as featured image', 'sage' ),
   		'insert_into_item'      => __( 'Insert into item', 'sage' ),
   		'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
   		'items_list'            => __( 'Items list', 'sage' ),
   		'items_list_navigation' => __( 'Items list navigation', 'sage' ),
   		'filter_items_list'     => __( 'Filter items list', 'sage' ),
   	);
   	$args = array(
   		'label'                 => __( 'Presenter', 'sage' ),
   		'description'           => __( 'Custom post type for presenters', 'sage' ),
   		'labels'                => $labels,
   		'supports'              => array( 'title', 'editor', 'thumbnail', ),
   		'hierarchical'          => false,
   		'public'                => true,
   		'show_ui'               => true,
   		'show_in_menu'          => true,
   		'menu_position'         => 4,
   		'menu_icon'             => 'dashicons-businessman',
   		'show_in_admin_bar'     => true,
   		'show_in_nav_menus'     => true,
   		'can_export'            => true,
   		'has_archive'           => true,
   		'exclude_from_search'   => false,
   		'publicly_queryable'    => true,
   		'capability_type'       => 'post',
   		'show_in_rest'          => true,
   	);
   	register_post_type( 'hf_presenters', $args );

   }

   add_action( 'init', 'cpt_hf_presenters', 0 );

   // Custom Post Type for HF Hero Slider
   function cpt_hf_hero_slider() {

      $labels = array(
         'name'                  => _x( 'Hero Slides', 'Post Type General Name', 'sage' ),
         'singular_name'         => _x( 'Hero Slide', 'Post Type Singular Name', 'sage' ),
         'menu_name'             => __( 'Hero Slides', 'sage' ),
         'name_admin_bar'        => __( 'Hero Slide', 'sage' ),
         'archives'              => __( 'Item Archives', 'sage' ),
         'attributes'            => __( 'Item Attributes', 'sage' ),
         'parent_item_colon'     => __( 'Parent Item:', 'sage' ),
         'all_items'             => __( 'All Items', 'sage' ),
         'add_new_item'          => __( 'Add New Item', 'sage' ),
         'add_new'               => __( 'Add New', 'sage' ),
         'new_item'              => __( 'New Item', 'sage' ),
         'edit_item'             => __( 'Edit Item', 'sage' ),
         'update_item'           => __( 'Update Item', 'sage' ),
         'view_item'             => __( 'View Item', 'sage' ),
         'view_items'            => __( 'View Items', 'sage' ),
         'search_items'          => __( 'Search Item', 'sage' ),
         'not_found'             => __( 'Not found', 'sage' ),
         'not_found_in_trash'    => __( 'Not found in Trash', 'sage' ),
         'featured_image'        => __( 'Featured Image', 'sage' ),
         'set_featured_image'    => __( 'Set featured image', 'sage' ),
         'remove_featured_image' => __( 'Remove featured image', 'sage' ),
         'use_featured_image'    => __( 'Use as featured image', 'sage' ),
         'insert_into_item'      => __( 'Insert into item', 'sage' ),
         'uploaded_to_this_item' => __( 'Uploaded to this item', 'sage' ),
         'items_list'            => __( 'Items list', 'sage' ),
         'items_list_navigation' => __( 'Items list navigation', 'sage' ),
         'filter_items_list'     => __( 'Filter items list', 'sage' ),
      );
      $args = array(
         'label'                 => __( 'Event', 'sage' ),
         'description'           => __( 'CPT for HF Hero Slider', 'sage' ),
         'labels'                => $labels,
         'supports'              => array( 'title', 'editor', 'thumbnail', ),
         'hierarchical'          => false,
         'public'                => true,
         'show_ui'               => true,
         'show_in_menu'          => true,
         'menu_position'         => 20,
         'menu_icon'             => 'dashicons-format-gallery',
         'show_in_admin_bar'     => true,
         'show_in_nav_menus'     => true,
         'can_export'            => true,
         'has_archive'           => true,
         'exclude_from_search'   => false,
         'publicly_queryable'    => true,
         'capability_type'       => 'post',
         'show_in_rest'          => true,
      );
      register_post_type( 'hf_hero_slides', $args );

   }
   add_action( 'init', 'cpt_hf_hero_slider', 0 );