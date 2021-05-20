<?php
/*
   Plugin Name: HFUSA Custom Meta Boxes
   Plugin URI: http://usa.humanityfirst.org
   Description: A custom plugin for creating Metaboxes for HFUSA
   Version: 1.0
   Author: Oracular
   Author URI: http://oracular.com
   License: GPL2
   */
   /* TEMP METABOXES */

   /*----------  METABOXES FOR PROGRAMS  ----------*/
   function hf_programs_metaboxes( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'programs_fields',
        'title' => esc_html__( 'Program Fields', 'sage' ),
        'post_types' => array( 'hf_programs' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . '_position',
                'type' => 'text',
                'name' => esc_html__( 'Sort Order', 'sage' )
            ),
            array(
                'id' => $prefix . 'target_price',
                'type' => 'text',
                'name' => esc_html__( 'Target Price', 'sage' ),
            ),
            array(
                'id' => $prefix . 'end_date',
                'type' => 'date',
                'name' => esc_html__( 'End Date', 'sage' ),
                'timestamp' => true,
            ),
            array(
                'id' => $prefix . 'program_location',
                'type' => 'text',
                'name' => esc_html__( 'Program Location', 'sage' ),
            ),
            array(
                'id' => $prefix . 'program_gallery',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Program Gallery', 'sage' ),
                'max_file_uploads' => '15',
                'force_delete' => false,
            ),
            array(
                'id' => $prefix . 'program_logo',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Program Logo', 'sage' ),
                'max_file_uploads' => '1',
                'force_delete' => false,
            ),
            array(
                'id' => $prefix . 'program_icon',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Program Icon', 'sage' ),
                'max_file_uploads' => '1',
                'force_delete' => false,
            ),
            array(
                'id' => $prefix . 'program_color',
                'type' => 'color',
                'name' => esc_html__( 'Program Color', 'sage' ),
                'alpha_channel' => true,
            ),
            array(
                'id' => $prefix . 'program_countries',
                'type' => 'post',
                'name' => esc_html__( 'Select Countries', 'sage' ),
                'post_type' => 'hf_countries',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Countries', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'program_director',
                'type' => 'post',
                'name' => esc_html__( 'Select Director', 'sage' ),
                'post_type' => 'hf_members',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Director', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'program_questions',
                'type' => 'post',
                'name' => esc_html__( 'Select Questions', 'sage' ),
                'post_type' => 'hf_questions',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Questions', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'page_testimonials',
                'type' => 'post',
                'name' => esc_html__( 'Select Testimonials', 'sage' ),
                'post_type' => 'hf_testimonials',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Testimonials', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'page_quotes',
                'type' => 'post',
                'name' => esc_html__( 'Select Quotes', 'sage' ),
                'post_type' => 'hf_quotes',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Quotes', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_programs_metaboxes' );

/*----------  METABOXES FOR PROJECTS  ----------*/
function project_metaboxes( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'project_fields',
        'title' => esc_html__( 'Project Fields', 'sage' ),
        'post_types' => array( 'hf_projects' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . '_position',
                'type' => 'text',
                'name' => esc_html__( 'Sort Order', 'sage' )
            ),
            array(
                'id' => $prefix . 'project_director',
                'type' => 'post',
                'name' => esc_html__( 'Select Director', 'sage' ),
                'post_type' => 'hf_members',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Director', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'project_gallery',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Project Gallery', 'sage' ),
                'max_file_uploads' => '15',
                'force_delete' => false,
            ),
            array(
                'id' => $prefix . 'project_program',
                'type' => 'post',
                'name' => esc_html__( 'Program', 'sage' ),
                'post_type' => 'hf_programs',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Program', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'project_countries',
                'type' => 'post',
                'name' => esc_html__( 'Select Countries', 'sage' ),
                'post_type' => 'hf_countries',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Countries', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'project_questions',
                'type' => 'post',
                'name' => esc_html__( 'Select Questions', 'sage' ),
                'post_type' => 'hf_questions',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Questions', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'page_testimonials',
                'type' => 'post',
                'name' => esc_html__( 'Select Testimonials', 'sage' ),
                'post_type' => 'hf_testimonials',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Testimonials', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'page_quotes',
                'type' => 'post',
                'name' => esc_html__( 'Select Quotes', 'sage' ),
                'post_type' => 'hf_quotes',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Quotes', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'project_metaboxes' );

// Metaboxes for Sponsors
function hf_sponsors_fields( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'sponsors_fields',
        'title' => esc_html__( 'Sponsors Fields', 'sage' ),
        'post_types' => array( 'hf_sponsors'),
        'context' => 'side',
        'priority' => 'default',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . '_position',
                'type' => 'text',
                'name' => esc_html__( 'Sort Order', 'sage' )
            ),
            array(
              'id' => $prefix . 'sponsor_event',
              'type' => 'post',
              'name' => esc_html__( 'Event', 'sage' ),
              'post_type' => 'hf_events',
              'field_type' => 'select',
              'placeholder' => esc_html__( 'Select Event', 'sage' ),
            ),
            array(
                'id' => $prefix . 'sponsor_email',
                'type' => 'textsss',
                'name' => esc_html__( 'Email', 'sage' ),
            ),
            array(
              'id' => $prefix . 'sponsor_phone',
              'type' => 'textsss',
              'name' => esc_html__( 'Phone', 'sage' ),
            ),
            array(
              'id' => $prefix . 'sponsor_company',
              'type' => 'textsss',
              'name' => esc_html__( 'Company Name', 'sage' ),
            ),
            array(
                'id' => $prefix . 'sponsor_location',
                'type' => 'text',
                'name' => esc_html__( 'Location', 'sage' ),
            ),
            array(
                'id' => $prefix . 'sponsor_website',
                'type' => 'url',
                'name' => esc_html__( 'Website', 'sage' ),
            ),
            array(
                'id' => $prefix . 'sponsor_linkedin',
                'type' => 'text',
                'name' => esc_html__( 'LinkedIn', 'sage' ),
            ),
            array(
                'id' => $prefix . 'sponsor_twitter',
                'type' => 'textsss',
                'name' => esc_html__( 'Twitter', 'sage' ),
            ),
            array(
                'id' => $prefix . 'sponsor_facebook',
                'type' => 'textsss',
                'name' => esc_html__( 'Facebook', 'sage' ),
            ),
            array(
                'id' => $prefix . 'sponsor_youtube',
                'type' => 'textsss',
                'name' => esc_html__( 'Youtube', 'sage' ),
            ),

        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_sponsors_fields' );

// Metaboxes for Sponsors
function hf_sponsors_other_fields( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'sponsors_other_fields',
        'title' => esc_html__( 'Testimonials / Quotes', 'sage' ),
        'post_types' => array( 'hf_sponsors'),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'page_testimonials',
                'type' => 'post',
                'name' => esc_html__( 'Select Testimonials', 'sage' ),
                'post_type' => 'hf_testimonials',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Testimonials', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            ),
            array(
                'id' => $prefix . 'page_quotes',
                'type' => 'post',
                'name' => esc_html__( 'Select Quotes', 'sage' ),
                'post_type' => 'hf_quotes',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Quotes', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_sponsors_other_fields' );

// Metaboxes for Donation
function hf_donation_fields( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'donation_fields',
        'title' => esc_html__( 'Donation Fields', 'sage' ),
        'post_types' => array( 'hf_donations' ),
        'context' => 'side',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'donation_type',
                'name' => esc_html__( 'Donation Type', 'sage' ),
                'type' => 'radio',
                'placeholder' => '',
                'options' => array(
                    'Donation' => 'Donation',
                    'Pledge' => 'Pledge',
                ),
                'inline' => true,
            ),
            array(
                'id' => $prefix . 'donation_for',
                'name' => esc_html__( 'Donation For', 'sage' ),
                'type' => 'radio',
                'placeholder' => '',
                'options' => array(
                    'General' => 'General',
                    'Program' => 'Program',
                ),
                'inline' => true,
            ),
            array(
                'id' => $prefix . 'donation_amount',
                'type' => 'number',
                'name' => esc_html__( 'Donation Amount', 'sage' ),
            ),
            array(
                'id' => $prefix . 'program_id',
                'type' => 'text',
                'name' => esc_html__( 'Program ID', 'sage' ),
            ),
            array(
                'id' => $prefix . 'event_id',
                'type' => 'text',
                'name' => esc_html__( 'Event ID', 'sage' ),
            ),
            array(
                'id' => $prefix . 'event_name',
                'type' => 'text',
                'name' => esc_html__( 'Event Name', 'sage' ),
            ),
            array(
                'id' => $prefix . 'program_name',
                'type' => 'text',
                'name' => esc_html__( 'Program Name', 'sage' ),
            ),
            array(
                'id' => $prefix . 'donor_id',
                'type' => 'text',
                'name' => esc_html__( 'Donor ID', 'sage' ),
            ),
            array(
                'id' => $prefix . 'donor_name',
                'type' => 'text',
                'name' => esc_html__( 'Donor Name', 'sage' ),
            ),
            array(
                'id' => $prefix . 'donor_email',
                'type' => 'text',
                'name' => esc_html__( 'Donor Email', 'sage' ),
            ),
            array(
                'id' => $prefix . 'donor_phone',
                'type' => 'text',
                'name' => esc_html__( 'Donor Phone', 'sage' ),
            ),
            array(
                'id' => $prefix . 'donor_city',
                'type' => 'text',
                'name' => esc_html__( 'Donor City', 'sage' ),
            ),
            array(
                'id' => $prefix . 'donor_state',
                'type' => 'text',
                'name' => esc_html__( 'Donor State', 'sage' ),
            ),
            array(
                'id' => $prefix . 'pledge_promise_date',
                'type' => 'text',
                'name' => esc_html__( 'Pledge Promise Date', 'sage' ),
            ),
            array(
                'id' => $prefix . 'donation_campaign_id',
                'type' => 'text',
                'name' => esc_html__( 'Campaign ID', 'sage' ),
            ),
            array(
                'id' => $prefix . 'donation_order_id',
                'type' => 'text',
                'name' => esc_html__( 'Order ID', 'sage' ),
            ),
            array(
                'id' => $prefix . 'transaction_ref_code',
                'type' => 'text',
                'name' => esc_html__( 'Ref Code', 'sage' ),
            ),
            array(
                'id' => $prefix . 'pledge_recurrence',
                'type' => 'text',
                'name' => esc_html__( 'Pledge Recurrence', 'sage' ),
            ),
            array(
                'id' => $prefix . 'pledge_recursive_amount',
                'type' => 'text',
                'name' => esc_html__( 'Pledge Recursive Amount', 'sage' ),
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_donation_fields' );

// Metaboxes for Event
function hf_event_metaboxes( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'events_fields',
        'title' => esc_html__( 'Events Fields', 'sage' ),
        'post_types' => array( 'hf_events' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'event_date',
                'type' => 'date',
                'name' => esc_html__( 'Event Start Date', 'sage' ),
                'timestamp' => false,
            ),
            array(
                'id' => $prefix . 'event_end_date',
                'type' => 'date',
                'name' => esc_html__( 'Event End Date', 'sage' ),
                'timestamp' => false,
            ),
            array(
                'id' => $prefix . 'event_start_time',
                'type' => 'time',
                'name' => esc_html__( 'Event Start Time', 'sage' ),
                'timestamp' => false,
            ),
            array(
                'id' => $prefix . 'event_end_time',
                'type' => 'time',
                'name' => esc_html__( 'Event End Time', 'sage' ),
                'timestamp' => false,
            ),
            array(
                'id' => $prefix . 'event_has_not_location',
                'name' => esc_html__( '', 'sage' ),
                'type' => 'checkbox',
                'desc' => esc_html__( 'This event does not have a physical location.', 'sage' ),
            ),
            array(
                'id' => $prefix . 'event_location',
                'type' => 'text',
                'name' => esc_html__( 'Event Location', 'sage' ),
                'hidden' => array( 'hfusa-event_has_not_location', true )
            ),
            array(
                'id' => $prefix . 'event_map',
                'type' => 'map',
                'name' => esc_html__( 'Map', 'sage' ),
                'std' => '43.78444,-88.787868,10',
                'address_field' => $prefix . 'event_location',
                'api_key' => 'AIzaSyAbDprEDuR2AN8Yrer1LCW_fNMfyYssBVc',
                'hidden' => array( 'hfusa-event_has_not_location', true )
            ),
            array(
                'id' => $prefix . 'venue_gallery',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Venue Images', 'sage' ),
            ),
            array(
                'id' => $prefix . 'event_price',
                'type' => 'number',
                'name' => esc_html__( 'Ticket Price', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'event_tickets_available',
                'type' => 'number',
                'name' => esc_html__( 'Total Tickets', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'event_sponsors',
                'type' => 'post',
                'name' => esc_html__( 'Select Sponsors', 'sage' ),
                'post_type' => 'hf_sponsors',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Sponsors', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'event_speakers',
                'type' => 'post',
                'name' => esc_html__( 'Select Hosts', 'sage' ),
                'post_type' => 'hf_speakers',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Speakers', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'event_guests',
                'type' => 'post',
                'name' => esc_html__( 'Select Special Guests', 'sage' ),
                'post_type' => 'hf_speakers',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Special Guests', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'remaining_spaces',
                'type' => 'text',
                'name' => esc_html__( 'Remaining Spaces', 'sage' ),
                'attributes' => array(
                    'style' => 'width: 235px;pointer-events: none;background: rgba(204, 204, 204, 1);',
                    'class'  => 'disabled',
                    'readonly'  => 'readonly',
                )
            ),
            array(
                'id' => $prefix . 'event_campaigns',
                'type' => 'post',
                'name' => esc_html__( 'Select Campaign', 'sage' ),
                'post_type' => 'hf_campaigns',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Campaign', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'event_gallery',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Event Gallery', 'sage' ),
            ),
            array(
                'id' => $prefix . 'donate_button_url',
                'type' => 'text',
                'name' => esc_html__( 'Donate Button URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'register_button_url',
                'type' => 'text',
                'name' => esc_html__( 'Register Button URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'sponsor_button_url',
                'type' => 'text',
                'name' => esc_html__( 'Sponsor Button URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'contact_us_button_url',
                'type' => 'text',
                'name' => esc_html__( 'Contact Us Button URL', 'sage' ),
            ),
        ),
    );
    $meta_boxes[] = array(
        'id' => 'background_fields',
        'title' => esc_html__('Event Sections Background Fields', 'sage'),
        'post_types' => array('hf_events'),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'intro_background',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Intro section background image', 'sage' ),
                'force_delete' => false,
                'max_file_uploads' => '1',
            ),
            array(
                'id' => $prefix . 'map_background',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Map section background image', 'sage' ),
                'force_delete' => false,
                'max_file_uploads' => '1',
            ),
            array(
                'id' => $prefix . 'feed_background',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Feed section background image', 'sage' ),
                'force_delete' => false,
                'max_file_uploads' => '1',
            ),
        ),
    );
    $meta_boxes[] = array(
        'id' => 'headings_fields',
        'title' => esc_html__('Event Headings Fields', 'sage'),
        'post_types' => array('hf_events'),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'top_teams_heading',
                'name' => esc_html__('Top Teams Section', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage'),
                'std' => 'Top Teams'
            ),
            array(
                'id' => $prefix . 'top_individuals_heading',
                'name' => esc_html__('Top Individuals Section', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage'),
                'std' => 'Top Individuals'
            ),
            array(
                'id' => $prefix . 'agenda_heading',
                'name' => esc_html__('Agenda Section Heading', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage')
            ),
            array(
                'id' => $prefix . 'sponsors_heading',
                'name' => esc_html__('Sponsors Section Heading', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage')
            ),
            array(
                'id' => $prefix . 'hosts_heading',
                'name' => esc_html__('Hosts Section Heading', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage')
            ),
            array(
                'id' => $prefix . 'guests_heading',
                'name' => esc_html__('Guests Section Heading', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage')
            ),
            array(
                'id' => $prefix . 'youtube_comments_heading',
                'name' => esc_html__('YouTube Comments Section Heading', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage')
            ),
            array(
                'id' => $prefix . 'twitter_feed_heading',
                'name' => esc_html__('Twitter Feed Section Heading', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage')
            ),

        ),
    );

return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_event_metaboxes' );



// Fields for Speakers
function speaker_fields( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'speaker_fields',
        'title' => esc_html__( 'Speaker Fields', 'sage' ),
        'post_types' => array( 'hf_speakers' ),
        'context' => 'side',
        'priority' => 'default',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'speaker_designation',
                'type' => 'text',
                'name' => esc_html__( 'Designation', 'sage' ),
            ),
            array(
                'id' => $prefix . 'speaker_email',
                'type' => 'text',
                'name' => esc_html__( 'Email', 'sage' ),
            ),
            array(
                'id' => $prefix . 'speaker_website',
                'type' => 'text',
                'name' => esc_html__( 'Website', 'sage' ),
            ),
            array(
                'id' => $prefix . 'speaker_phone',
                'type' => 'text',
                'name' => esc_html__( 'Phone', 'sage' ),
            ),
            array(
                'id' => $prefix . 'speaker_facebook',
                'type' => 'text',
                'name' => esc_html__( 'Facebook', 'sage' ),
            ),
            array(
                'id' => $prefix . 'speaker_twitter',
                'type' => 'text',
                'name' => esc_html__( 'Twitter', 'sage' ),
            ),
            array(
                'id' => $prefix . 'speaker_linkedin',
                'type' => 'text',
                'name' => esc_html__( 'LinkedIn', 'sage' ),
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'speaker_fields' );

// Metaboxes for Team Members
function hf_members_fields( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'members_fields',
        'title' => esc_html__( 'Team Members Fields', 'sage' ),
        'post_types' => array( 'hf_members'),
        'context' => 'side',
        'priority' => 'default',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'member_position',
                'type' => 'text',
                'name' => esc_html__( 'Sort Order', 'sage' )
            ),
            array(
                'id' => $prefix . 'member_designation',
                'type' => 'text',
                'name' => esc_html__( 'Member Designation', 'sage' ),
            ),
            array(
                'id' => $prefix . 'member_email',
                'type' => 'text',
                'name' => esc_html__( 'Member Email', 'sage' ),
            ),
            array(
                'id' => $prefix . 'member_website',
                'type' => 'text',
                'name' => esc_html__( 'Member Website', 'sage' ),
            ),
            array(
                'id' => $prefix . 'member_facebook',
                'type' => 'url',
                'name' => esc_html__( 'Facebook', 'sage' ),
            ),
            array(
                'id' => $prefix . 'member_twitter',
                'type' => 'url',
                'name' => esc_html__( 'Twitter', 'sage' ),
            ),
            array(
                'id' => $prefix . 'member_linkedin',
                'type' => 'url',
                'name' => esc_html__( 'LinkedIn', 'sage' ),
            ),
            array(
                'id' => $prefix . 'member_cover',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Member Cover Image', 'sage' ),
                'force_delete' => false,
                'max_file_uploads' => '1',
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_members_fields' );

// Metaboxes for Team Members
function hf_members_other_fields( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'members_other_fields',
        'title' => esc_html__( 'Testimonials / Quotes', 'sage' ),
        'post_types' => array( 'hf_members'),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'page_testimonials',
                'type' => 'post',
                'name' => esc_html__( 'Select Testimonials', 'sage' ),
                'post_type' => 'hf_testimonials',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Testimonials', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            ),
            array(
                'id' => $prefix . 'page_quotes',
                'type' => 'post',
                'name' => esc_html__( 'Select Quotes', 'sage' ),
                'post_type' => 'hf_quotes',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Quotes', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_members_other_fields' );

/*----------  METABOXES FOR JOBS  ----------*/
function hf_jobs_metaboxes( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'jobs_fields',
        'title' => esc_html__( 'Job Fields', 'sage' ),
        'post_types' => array( 'hf_jobs' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'job_type',
                'name' => esc_html__( 'Job Type', 'sage' ),
                'type' => 'select',
                'placeholder' => esc_html__( 'Select Job Type', 'sage' ),
                'options' => array(
                    'Full Time' => 'Full Time',
                    'Part Time' => 'Part Time',
                    'Volunteer' => 'Volunteer'
                ),
            ),
            array(
                'id' => $prefix . 'job_shift',
                'name' => esc_html__( 'Job Shift', 'sage' ),
                'type' => 'select',
                'placeholder' => esc_html__( 'Select Job Shift', 'sage' ),
                'options' => array(
                    'Morning Shift' => 'Morning Shift',
                    'Evening Shift' => 'Evening Shift',
                    'Night Shift' => 'Night Shift',
                    'Not Applicable' => 'Not Applicable'
                ),
            ),
            array(
                'id' => $prefix . 'job_positions',
                'type' => 'number',
                'name' => esc_html__( 'Job Positions', 'sage' ),
                'min' => '1',
            ),
            array(
                'id' => $prefix . 'job_experience',
                'type' => 'number',
                'name' => esc_html__( 'Job Experience', 'sage' ),
                'placeholder' => esc_html__( 'Experience In Years', 'sage' ),
                'min' => '1',
            ),
            array(
                'id' => $prefix . 'job_location',
                'type' => 'text',
                'name' => esc_html__( 'Job Location', 'sage' ),
            ),
            array(
                'id' => $prefix . 'job_end_date',
                'type' => 'date',
                'name' => esc_html__( 'End Date', 'sage' ),
                'timestamp' => true,
            ),
            array(
                'id' => $prefix . 'job_skills',
                'type' => 'post',
                'name' => esc_html__( 'Select Skills', 'sage' ),
                'post_type' => 'hf_skills',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Skills', 'sage' ),
                'multiple' => true,
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_jobs_metaboxes' );

/*----------  METABOXES FOR PHOTOS  ----------*/
function hf_photos_metaboxes( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'photos_fields',
        'title' => esc_html__( 'Photos Fields', 'sage' ),
        'post_types' => array( 'hf_photos' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'select_album',
                'type' => 'post',
                'name' => esc_html__( 'Select Album', 'sage' ),
                'post_type' => 'hf_albums',
                'field_type' => 'select_advanced',
                'multiple' => true,
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_photos_metaboxes' );

/*----------  METABOXES FOR COUNTRIES  ----------*/
function hf_countries_metaboxes( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'countries_fields',
        'title' => esc_html__( 'Country Fields', 'sage' ),
        'post_types' => array( 'hf_countries' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . '_position',
                'type' => 'text',
                'name' => esc_html__( 'Sort Order', 'sage' )
            ),
            array(
                'id' => $prefix . 'active_in_country_date',
                'type' => 'date',
                'name' => esc_html__( 'Humanity First Active in this Country from', 'sage' ),
                'timestamp' => true,
                'js_options' => array(
                    'changeYear' => true,
                ),
            ),
            array(
                'id' => $prefix . 'program_director',
                'type' => 'post',
                'name' => esc_html__( 'Select Director', 'sage' ),
                'post_type' => 'hf_members',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Director', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'page_testimonials',
                'type' => 'post',
                'name' => esc_html__( 'Select Testimonials', 'sage' ),
                'post_type' => 'hf_testimonials',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Testimonials', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'page_quotes',
                'type' => 'post',
                'name' => esc_html__( 'Select Quotes', 'sage' ),
                'post_type' => 'hf_quotes',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Quotes', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'country_gallery',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Gallery Images', 'sage' ),
                'max_file_uploads' => '15',
                'force_delete' => false,
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_countries_metaboxes' );

// Metaboxes for Partners
function hf_partners_fields( $meta_boxes ) {
  $prefix = 'hfusa-';

  $meta_boxes[] = array(
      'id' => 'partners_fields',
      'title' => esc_html__( 'Partners Fields', 'sage' ),
      'post_types' => array( 'hf_partners'),
      'context' => 'side',
      'priority' => 'default',
      'autosave' => true,
      'fields' => array(
          array(
              'id' => $prefix . '_position',
              'type' => 'text',
              'name' => esc_html__( 'Sort Order', 'sage' )
          ),
          array(
              'id' => $prefix . 'partner_email',
              'type' => 'text',
              'name' => esc_html__( 'Partner Email', 'sage' ),
          ),
          array(
              'id' => $prefix . 'partner_website',
              'type' => 'text',
              'name' => esc_html__( 'Partner Website', 'sage' ),
          ),
          array(
              'id' => $prefix . 'partner_facebook',
              'type' => 'url',
              'name' => esc_html__( 'Facebook', 'sage' ),
          ),
          array(
              'id' => $prefix . 'partner_twitter',
              'type' => 'url',
              'name' => esc_html__( 'Twitter', 'sage' ),
          ),
          array(
              'id' => $prefix . 'partner_linkedin',
              'type' => 'url',
              'name' => esc_html__( 'LinkedIn', 'sage' ),
          ),
      ),
  );

  return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_partners_fields' );

// Metaboxes for Partners
function hf_partners_other_fields( $meta_boxes ) {
  $prefix = 'hfusa-';

  $meta_boxes[] = array(
      'id' => 'partners_other_fields',
      'title' => esc_html__( 'Testimonials / Quotes', 'sage' ),
      'post_types' => array( 'hf_partners'),
      'context' => 'advanced',
      'priority' => 'default',
      'autosave' => true,
      'fields' => array(
        array(
            'id' => $prefix . 'page_testimonials',
            'type' => 'post',
            'name' => esc_html__( 'Select Testimonials', 'sage' ),
            'post_type' => 'hf_testimonials',
            'field_type' => 'select',
            'placeholder' => esc_html__( 'Select Testimonials', 'sage' ),
            'multiple' => true,
            'attributes' => array(
                'style' => 'width: 220px;',
            )
        ),
        array(
            'id' => $prefix . 'page_quotes',
            'type' => 'post',
            'name' => esc_html__( 'Select Quotes', 'sage' ),
            'post_type' => 'hf_quotes',
            'field_type' => 'select',
            'placeholder' => esc_html__( 'Select Quotes', 'sage' ),
            'multiple' => true,
            'attributes' => array(
                'style' => 'width: 220px;',
            )
        )
    ),
  );

  return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_partners_other_fields' );

// Metabox for Donwloads fields.

function downloads_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'download_fields',
        'title' => esc_html__( 'Downloads Fields', 'sage' ),
        'post_types' => array( 'hf_downloads' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => false,
        'fields' => array(
            array(
                'id' => $prefix . 'download_file',
                'type' => 'file_input',
                'name' => esc_html__( 'Download File', 'sage' ),
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            ),
            array(
                'id' => $prefix . 'download_programs',
                'type' => 'post',
                'name' => esc_html__( 'Select Programs', 'sage' ),
                'post_type' => 'hf_programs',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Programs', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            ),
            array(
                'id' => $prefix . 'download_regions',
                'type' => 'post',
                'name' => esc_html__( 'Select Geographical Regions', 'sage' ),
                'post_type' => 'hf_countries',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select regions', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            ),
            array(
                'id' => $prefix . 'download_projects',
                'type' => 'post',
                'name' => esc_html__( 'Select Projects', 'sage' ),
                'post_type' => 'hf_projects',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Projects', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'downloads_meta_box' );

// Metaboxes for Global Sites
function hf_glbl_sites_other_fields( $meta_boxes ) {
  $prefix = 'hfusa-';

  $meta_boxes[] = array(
      'id' => 'glbl_sites_other_fields',
      'title' => esc_html__( 'Other Options', 'sage' ),
      'post_types' => array( 'hf_glbl_sites'),
      'context' => 'advanced',
      'priority' => 'default',
      'autosave' => true,
      'fields' => array(
          array(
              'id' => $prefix . '_position',
              'type' => 'text',
              'name' => esc_html__( 'Sort Order', 'sage' )
          ),
        array(
            'id' => $prefix . 'glbl_website',
            'type' => 'text',
            'name' => esc_html__( 'Enter Website URL', 'sage' ),
            'attributes' => array(
                'style' => 'width: 220px;',
            )
        ),
        array(
            'id' => $prefix . 'page_testimonials',
            'type' => 'post',
            'name' => esc_html__( 'Select Testimonials', 'sage' ),
            'post_type' => 'hf_testimonials',
            'field_type' => 'select',
            'placeholder' => esc_html__( 'Select Testimonials', 'sage' ),
            'multiple' => true,
            'attributes' => array(
                'style' => 'width: 220px;',
            )
        ),
        array(
            'id' => $prefix . 'page_quotes',
            'type' => 'post',
            'name' => esc_html__( 'Select Quotes', 'sage' ),
            'post_type' => 'hf_quotes',
            'field_type' => 'select',
            'placeholder' => esc_html__( 'Select Quotes', 'sage' ),
            'multiple' => true,
            'attributes' => array(
                'style' => 'width: 220px;',
            )
        )
    ),
  );

  return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_glbl_sites_other_fields' );

// Metabox for Pages Geographic Reach, Years in the Field, Lives Impacted and Dollars Raised
// function our_impacts_sub_pages_meta_box( $meta_boxes ) {
//     $prefix = 'hfusa-';

//     $meta_boxes[] = array(
//         'id' => 'our_impacts_fields',
//         'title' => esc_html__( 'Impact', 'sage' ),
//         'post_types' => array( 'page' ),
//         'context' => 'advanced',
//         'priority' => 'default',
//         'autosave' => false,
//         'fields' => array(
//             array(
//                 'id' => $prefix . 'impact_label',
//                 'type' => 'text',
//                 'name' => esc_html__( 'Title', 'sage' ),
//                 'placeholder' => esc_html__( 'Enter lable of impact', 'sage' ),
//                 'attributes' => array(
//                     'style' => 'width: 220px;',
//                 )
//             ),
//             array(
//                 'id' => $prefix . 'impact_figure',
//                 'type' => 'number',
//                 'name' => esc_html__( 'Description', 'sage' ),
//                 'placeholder' => esc_html__( 'Enter figure in number', 'sage' ),
//                 'attributes' => array(
//                     'style' => 'width: 220px;',
//                 )
//             )
//         ),
//     );

//     return $meta_boxes;
// }
// add_filter( 'rwmb_meta_boxes', 'our_impacts_sub_pages_meta_box' );

// Metabox of Testimonials for Pages
function testimonials_pages_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'testimonials_fields',
        'title' => esc_html__( 'Testimonials', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id' => $prefix . 'page_testimonials',
                'type' => 'post',
                'name' => esc_html__( 'Select Testimonials', 'sage' ),
                'post_type' => 'hf_testimonials',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Testimonials', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'testimonials_pages_meta_box' );

// Metabox of Testimonials for Pages
function director_pages_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'director_fields',
        'title' => esc_html__( 'Director', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'visible' => array( 'page_template', 'template-message-page.php' ),
        'fields' => array(
            array(
                'id' => $prefix . 'director',
                'type' => 'post',
                'name' => esc_html__( 'Select Director', 'sage' ),
                'post_type' => 'hf_members',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Director', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'director_pages_meta_box' );

// Metabox of Testimonials for Pages
function chairman_pages_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'chairman_fields',
        'title' => esc_html__( 'Chairman', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'visible' => array( 'page_template', 'template-message-page.php' ),
        'fields' => array(
            array(
                'id' => $prefix . 'chairman',
                'type' => 'post',
                'name' => esc_html__( 'Select Chairman', 'sage' ),
                'post_type' => 'hf_members',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Chairman', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'chairman_pages_meta_box' );

// Metabox of Quotes for Pages
function quotes_pages_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'quotes_fields',
        'title' => esc_html__( 'Quotes', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id' => $prefix . 'page_quotes',
                'type' => 'post',
                'name' => esc_html__( 'Select Quotes', 'sage' ),
                'post_type' => 'hf_quotes',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Quotes', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'quotes_pages_meta_box' );

// Metaboxes for Quotes CPT
function quotes_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'quotes_fields',
        'title' => esc_html__( 'Quote Author Details', 'sage' ),
        'post_types' => array( 'hf_quotes' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id' => $prefix . 'quote_author_name',
                'type' => 'text',
                'name' => esc_html__( 'Author Name', 'sage' ),
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            ),
            array(
                'id' => $prefix . 'quote_author_designation',
                'type' => 'text',
                'name' => esc_html__( 'Author Designation', 'sage' ),
                'attributes' => array(
                    'style' => 'width: 220px;',
                )
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'quotes_meta_box' );


// Metaboxes for Coupons  CPT
function coupons_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'coupon_fields',
        'title' => esc_html__( 'Coupon Details', 'sage' ),
        'post_types' => array( 'hf_coupons' ),
        'context' => 'normal',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id' => $prefix . 'coupon_code',
                'type' => 'text',
                'name' => esc_html__( 'Coupon Code', 'sage' ),
                'attributes' => array(
                    'style' => 'width: 235px;',
                    'required'  => true,
                )
            ),
            array(
                'id' => $prefix . 'discount_percentage',
                'type' => 'text',
                'name' => esc_html__( 'Discount Percentage', 'sage' ),
                'attributes' => array(
                    'style' => 'width: 235px;',
                    'required'  => true,
                )
            ),
            array(
                'id' => $prefix . 'coupon_start_date',
                'type' => 'date',
                'name' => esc_html__( 'Start Date', 'sage' ),
                'timestamp' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'coupon_end_date',
                'type' => 'date',
                'name' => esc_html__( 'End Date', 'sage' ),
                'timestamp' => true,
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'coupon_events',
                'type' => 'post',
                'name' => esc_html__( 'Select Events', 'sage' ),
                'post_type' => 'hf_events',
                'field_type' => 'select',
                'placeholder' => esc_html__( 'Select Events', 'sage' ),
                'multiple' => true,
                'attributes' => array(
                    'style' => 'width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'maximum_uses',
                'type' => 'text',
                'name' => esc_html__( 'Maximum Uses', 'sage' ),
                'attributes' => array(
                    'style' => 'width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'used_coupons',
                'type' => 'text',
                'name' => esc_html__( 'Number of used coupons', 'sage' ),
                'attributes' => array(
                    'style' => 'width: 235px;pointer-events: none;background: rgba(204, 204, 204, 1);',
                    'class'  => 'disabled',
                    'readonly'  => 'readonly',
                )
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'coupons_meta_box' );

// Metabox of Impacts for Pages
function impacts_pages_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';
    $meta_boxes[] = array(
        'title' => esc_html__( 'Impacts', 'sage' ),
        'post_types' => array( 'page','hf_members', 'hf_sponsors', 'hf_partners', 'hf_glbl_sites', 'hf_programs', 'hf_countries', 'hf_projects' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id'     => 'page_impact_details',
                // Group field
                'type'   => 'group',
                // Clone whole group?
                'clone'  => true,
                // Drag and drop clones to reorder them?
                'sort_clone' => true,
                // Sub-fields
                'fields' => array(
                    array(
                        'name' => 'Label',
                        'id'   => 'title',
                        'type' => 'text',
                    ),
                    array(
                        'name' => 'Figure',
                        'id'   => 'description',
                        'type' => 'text',
                    ),
                    array(
                        'name'    => 'Icon',
                        'id'      => 'icon',
                        'type'    => 'image_advanced',
                        'max_file_uploads'     => 1
                    ),
                ),
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'impacts_pages_meta_box' );

function hf_hidden_icon_field_filter( $field_html, $field, $meta  ) {

    $htmlString = '<div style="display:none;">';
    $htmlString .= $field_html;
    $htmlString .= '</div>';

    return $htmlString;
}
add_filter( 'rwmb_hfusa-hidden_icon_field_wrapper_html', 'hf_hidden_icon_field_filter', 10, 3);

function events_agendas_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'title'  => 'Agenda Items',
        'post_types' => array('hf_events'),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id'     => 'events_agendas_meta_box_container',
                // Group field
                'type'   => 'group',
                // Clone whole group?
                'clone'  => true,
                // Drag and drop clones to reorder them?
                'sort_clone' => true,
                // Sub-fields
                'fields' => array(
                    array(
                        'name' => 'Agenda Title',
                        'id'   => 'agenda_title',
                        'type' => 'text',
                    ),
                    array(
                        'name' => 'Start Time',
                        'id'   => 'start_time',
                        'type' => 'time',
                    ),
                    array(
                        'name' => 'End Time',
                        'id'   => 'end_time',
                        'type' => 'time',
                    ),
                    array(
                        'name'    => 'Description',
                        'id'      => 'desc',
                        'type'    => 'textarea'
                    ),
                    array(
                        'id' => 'presenter_post',
                        'type' => 'post',
                        'name' => esc_html__('Presenters', 'sage'),
                        'post_type' => 'hf_presenters',
                        'field_type' => 'select',
                        'multiple' => true,
                    ),
                    array(
                        'name'    => 'Sponsors',
                        'id'      => 'hf_sponsor_logo',
                        'type'    => 'image_advanced',
                        'max_file_uploads'     => 5
                    ),
                ),
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'events_agendas_meta_box' );

function hero_slides_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'hero_slides_meta_box_container',
        'title' => esc_html__( 'Hero Tagline', 'sage' ),
        'post_types' => array( 'hf_hero_slides' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id' => $prefix . 'hero_slides_tagline',
                'type' => 'textarea',
                'name' => esc_html__( 'Tagline above heading', 'sage' ),
                'attributes' => array(
                    'style' => 'width: 220px;',
                    'class' => 'rwmb-time ',
                ),
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hero_slides_meta_box' );

function hero_slides_buttons_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';
    $meta_boxes[] = array(
        'title' => esc_html__( 'Buttons', 'sage' ),
        'post_types' => array( 'hf_hero_slides' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id'     => 'hero_slides_buttons',
                // Group field
                'type'   => 'group',
                // Clone whole group?
                'clone'  => true,
                // Drag and drop clones to reorder them?
                'sort_clone' => true,
                // Sub-fields
                'fields' => array(
                    array(
                        'name' => 'Label',
                        'id'   => 'label',
                        'type' => 'text',
                    ),
                    array(
                        'name' => 'URL',
                        'id'   => 'url',
                        'type' => 'text',
                    )
                ),
            ),
        ),
    );
    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hero_slides_buttons_meta_box' );


function hf_hero_slides_buttons_filter( $field_html, $field, $meta  ) {

    $htmlString= '<style>
    .rwmb-clone {
        border-bottom: 1px solid #cccccc;
        padding-bottom: 12px;
    }
    .rwmb-clone.rwmb-fieldset_text-clone:nth-last-child(2) {
        border: none;
    }
    </style>';
    $htmlString .= ' <div class="rwmb-input">';

    $postId=get_the_ID();
    $hero_slides_buttons = get_post_meta( get_the_ID(), 'hfusa-hero_slides_buttons' );
    $i=0;
    if(!empty($hero_slides_buttons[0]) && is_array($hero_slides_buttons[0])){

       foreach($hero_slides_buttons[0] as $array){

        $htmlString .= '<div class="rwmb-clone rwmb-fieldset_text-clone">
        <fieldset>
        <legend></legend>';

        foreach($array as $meta_key=>$meta_value){
            $class="rwmb-fieldset_text";

         $label=str_replace('_', ' ', $meta_key);
         $htmlString .= '<label style="display: inline-block;margin-bottom: 5px;"><span style="min-width: 100px;display: inline-block;">'.ucwords($label).'</span> <input class="'.$class.'" name="hfusa-hero_slides_buttons['.$i.']['.$meta_key.']" size="30" style="min-width: 220px;" type="text" value="'.$meta_value.'"></label><br>';

        }

         $htmlString .= '</fieldset>
         <a class="rwmb-button remove-clone" href="#"><i class="dashicons dashicons-minus"></i></a>
         </div>';

        $i++;
    }
}else if(!empty($field["options"]) && is_array($field["options"])){

   $htmlString .= '<div class="rwmb-clone rwmb-fieldset_text-clone new-meta-fields-fieldset">
   <fieldset>
   <legend></legend>';

   foreach($field["options"] as $key=>$option){
    $class="rwmb-fieldset_text"; 

   
   $htmlString .= '<label style="display: inline-block;margin-bottom: 5px;"><span style="min-width: 100px;display: inline-block;">'.$option.'</span>  <input class="'.$class.'" name="hfusa-hero_slides_buttons['.$i.']['.$key.']" size="30" style="min-width: 220px;" type="text"></label><br>';

    }

$htmlString .= '</fieldset><a class="rwmb-button remove-clone" href="#"><i class="dashicons dashicons-minus"></i></div>';

}else{
  return $field_html;
}

$htmlString .= '<a class="rwmb-button button-primary add-clone" href="#">Add More</a>
</div>';

return $htmlString;
}
add_filter( 'rwmb_hfusa-hero_slides_buttons_wrapper_html', 'hf_hero_slides_buttons_filter', 10, 3);

function hero_slides_bottom_navigation_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';
    $meta_boxes[] = array(
        'title' => esc_html__( 'Bottom Navigation', 'sage' ),
        'post_types' => array( 'hf_hero_slides' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id'     => 'hero_slides_bottom_navigation',
                // Group field
                'type'   => 'group',
                // Clone whole group?
                'clone'  => true,
                // Drag and drop clones to reorder them?
                'sort_clone' => true,
                // Sub-fields
                'fields' => array(
                    array(
                        'name' => 'Label',
                        'id'   => 'label',
                        'type' => 'text',
                    ),
                    array(
                        'name' => 'Page',
                        'id'   => 'nav_page',
                        'type' => 'post',
                        'post_type'   => 'page',
                        // Placeholder, inherited from `select_advanced` field.
                        'placeholder' => 'Select a page',

                        // Query arguments. See https://codex.wordpress.org/Class_Reference/WP_Query
                        'query_args'  => array(
                            'post_status'    => 'publish',
                            'posts_per_page' => - 1,
                        ),
                    ),
                    array(
                        'name' => 'Custom Link',
                        'id'   => 'custom_link',
                        'type' => 'text',
                    ),
                    array(
                        'name'    => 'Icon',
                        'id'      => 'nav_icon',
                        'type'    => 'image_advanced',
                        'max_file_uploads'     => 1
                    ),
                ),
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hero_slides_bottom_navigation_meta_box' );

function telethon_additional_fields_meta_box( $meta_boxes ) {

    if ( ! hf_telethon_post_page() ) {
        return $meta_boxes;
    }

    $prefix = 'hfusa-';
    $meta_boxes[] = array(
        'id' => 'telethon_additional_fields',
        'title' => esc_html__( 'Additional Fields', 'sage' ),
        'post_types' => array( 'hf_events' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id' => $prefix . 'telethon_logo',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Page Header Logo', 'sage' ),
                'force_delete' => false,
                'max_file_uploads' => '1'
            ),
            array(
                'id' => $prefix . 'telethon_footer_logo',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Page Footer Logo', 'sage' ),
                'force_delete' => false,
                'max_file_uploads' => '1'
            ),
            array(
                'id' => $prefix . 'telethon_fb_page',
                'type' => 'text',
                'name' => esc_html__( 'Facebook Feed (Page Name)', 'sage' ),
                'placeholder' => esc_html__( 'Enter Facebook Page Name', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'telethon_twitter_page',
                'type' => 'text',
                'name' => esc_html__( 'Twitter Feed (#hashtag)', 'sage' ),
                'placeholder' => esc_html__( 'Enter Twitter #hashtag ', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'telethon_video_url',
                'type' => 'text',
                'name' => esc_html__( 'Youtube Video Link', 'sage' ),
                'placeholder' => esc_html__( 'Enter Youtube Video Link', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'telethon_gallery',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Telethon Gallery', 'sage' ),
            ),
            array(
                'id' => $prefix . 'telethon_history',
                'name' => esc_html__( 'History', 'sage' ),
                'type' => 'wysiwyg',
            ),
            array(
                'id' => $prefix . 'telethon_donate_url',
                'type' => 'text',
                'name' => esc_html__( 'Donate Button URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'telethon_fundraiser_url',
                'type' => 'text',
                'name' => esc_html__( 'Fundraiser Button URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'telethon_campaign_url',
                'type' => 'text',
                'name' => esc_html__( 'Campaign Button URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'telethon_link_pinterest',
                'type' => 'text',
                'name' => esc_html__( 'Pinterest URL', 'sage' ),
                'placeholder' => esc_html__( 'Enter URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'telethon_link_fb',
                'type' => 'text',
                'name' => esc_html__( 'Facebook URL', 'sage' ),
                'placeholder' => esc_html__( 'Enter URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'telethon_link_twitter',
                'type' => 'text',
                'name' => esc_html__( 'Twitter URL', 'sage' ),
                'placeholder' => esc_html__( 'Enter URL', 'sage' ),
            )
        ),
    );
    $meta_boxes[] = array(
        'id' => 'telethon_sections_color',
        'title' => esc_html__( 'Sections Background Color', 'sage' ),
        'post_types' => array( 'hf_events' ),
        'context' => 'advanced',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id' => $prefix . 'top_nav_color',
                'type' => 'color',
                'name' => esc_html__( 'Sticky Navigation', 'sage' ),
            ),
            array(
                'id' => $prefix . 'stats_bar_color',
                'type' => 'color',
                'name' => esc_html__( 'Stats Bar', 'sage' ),
            ),
            array(
                'id' => $prefix . 'progress_bar_color',
                'type' => 'color',
                'name' => esc_html__( 'Progress Bar', 'sage' ),
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'telethon_additional_fields_meta_box' );

function hf_telethon_post_page() {
    if ( ! is_admin() ) {
        return true;
    }
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        return true;
    }
    if ( isset( $_GET['post'] ) ) {
        $post_id = intval( $_GET['post'] );
    } elseif ( isset( $_POST['post_ID'] ) ) {
        $post_id = intval( $_POST['post_ID'] );
    } else { $post_id = false;
    }
    $post_id = (int) $post_id;

    $checked_templates = array( 'template-telethon.php' );
    $template = get_post_meta( $post_id, '_wp_page_template', true );
    if ( in_array( $template, $checked_templates ) ) {
        return true;
    }
    return false;
}

// Metabox of Videos Post type
function hf_videos_metaboxes( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'videos_fields',
        'title' => esc_html__( 'Video Details', 'sage' ),
        'post_types' => array( 'hf_videos' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'youtube_video_url',
                'type' => 'text',
                'name' => esc_html__( 'Youtube Video Link', 'sage' ),
                'attributes' => array(
                    'style' => 'width: 80%;max-width:500px;',
                )
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_videos_metaboxes' );




/*----------  METABOXES FOR PROJECTS  ----------*/
function campaigns_metaboxes( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'campaigns_fields',
        'title' => esc_html__( 'Campaigns Fields', 'sage' ),
        'post_types' => array( 'hf_campaigns' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'classy_campaign_id',
                'type' => 'text',
                'name' => esc_html__( 'Classy Campaign ID', 'sage' ),
                'placeholder' => esc_html__( 'Enter Your Classy Campaign ID', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'campaign_event_id',
                'type' => 'post',
                'name' => esc_html__( 'Select Event', 'sage' ),
                'placeholder' => esc_html__( 'Select Event', 'sage' ),
                'post_type' => 'hf_events',
                'field_type' => 'select',
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'campaign_twitter_feed',
                'type' => 'text',
                'name' => esc_html__( 'Twitter Feed (#hashtag)', 'sage' ),
                'placeholder' => esc_html__( 'Enter Twitter #hashtag ', 'sage' ),
                'attributes' => array(
                    'style' => 'min-width: 235px;',
                )
            ),
            array(
                'id' => $prefix . 'campaign_donate_url',
                'type' => 'text',
                'name' => esc_html__( 'Donate Button URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'campaign_fundraiser_url',
                'type' => 'text',
                'name' => esc_html__( 'Fundraiser Button URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'campaign_link_pinterest',
                'type' => 'text',
                'name' => esc_html__( 'Pinterest URL', 'sage' ),
                'placeholder' => esc_html__( 'Enter URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'campaign_link_fb',
                'type' => 'text',
                'name' => esc_html__( 'Facebook URL', 'sage' ),
                'placeholder' => esc_html__( 'Enter URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'campaign_link_twitter',
                'type' => 'text',
                'name' => esc_html__( 'Twitter URL', 'sage' ),
                'placeholder' => esc_html__( 'Enter URL', 'sage' ),
            ),
            array(
                'id' => $prefix . 'campaign_gallery',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Campaign Gallery', 'sage' ),
            ),
        ),
    );
    $meta_boxes[] = array(
        'id' => 'campaign_heading_fields',
        'title' => esc_html__('Campaign Heading Fields', 'sage'),
        'post_types' => array('hf_campaigns'),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id' => $prefix . 'top_five_states_heading',
                'name' => esc_html__('Top 5 States Section', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage'),
                'std' => 'Top 5 States'
            ),
            array(
                'id' => $prefix . 'donations_collected_heading',
                'name' => esc_html__('Donation Collected Section', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage'),
                'std' => 'Donations Collected'
            ),
            array(
                'id' => $prefix . 'top_teams_heading',
                'name' => esc_html__('Top Teams Section', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage'),
                'std' => 'Top Teams'
            ),
            array(
                'id' => $prefix . 'top_individuals_heading',
                'name' => esc_html__('Top Individuals Section', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage'),
                'std' => 'Top Individuals'
            ),
            array(
                'id' => $prefix . 'campaign_activity_heading',
                'name' => esc_html__('Campaign Activity Section', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage'),
                'std' => 'Campaign Activity'
            ),
            array(
                'id' => $prefix . 'twitter_feed_heading',
                'name' => esc_html__('Twitter Feed Section', 'sage'),
                'type' => 'text',
                'placeholder' => esc_html__('Heading', 'sage'),
                'std' => 'Twitter Feed'
            ),
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'campaigns_metaboxes' );


// Metabox for header background image
function header_background_image_meta_box( $meta_boxes ) {
    $prefix = 'hfusa-';

    $meta_boxes[] = array(
        'id' => 'header_background_image_fields',
        'title' => esc_html__( 'Header Background', 'sage' ),
        'post_types' => array( 'page','post','hf_events','hf_members', 'hf_sponsors', 'hf_partners', 'hf_glbl_sites', 'hf_countries', 'hf_projects', 'hf_alerts', 'product', 'hf_campaigns' ),
        'context' => 'side',
        'priority' => 'default',
        'autosave' => false,
        'fields' => array(
            array(
                'id' => $prefix . 'header_background_image',
                'type' => 'image_advanced',
                'name' => esc_html__( 'Background Image', 'sage' ),
                'force_delete' => false,
                'max_file_uploads' => '1'
            ),
            array(
                'id' => $prefix . 'background_focus',
                'name' => esc_html__( 'Vertical Position', 'sage' ),
                'type' => 'select',
                'options' => array(
                    'center' => 'Center',
                    'top' => 'Top',
                    'bottom' => 'Bottom',
                ),
                'std' => 'center',
            )
        ),
    );

    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'header_background_image_meta_box' );

function hf_products_meta_box( $meta_boxes ) {
 $prefix = 'hfusa-';


 $meta_boxes[] = array(
    'id' => 'programs_fields',
    'title' => esc_html__( 'Program Fields', 'sage' ),
    'post_types' => array( 'product' ),
    'context' => 'advanced',
    'priority' => 'high',
    'autosave' => true,
    'fields' => array(
        array(
            'id' => $prefix . 'related_programs',
            'type' => 'post',
            'name' => esc_html__( 'Select Programs', 'sage' ),
            'post_type' => 'hf_programs',
            'field_type' => 'select',
            'placeholder' => esc_html__( 'Select Programs', 'sage' ),
            'attributes' => array(
                'style' => 'min-width: 235px;',
            )
        )
    )
);

 return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_products_meta_box' );

function hf_donate_page_meta_box( $meta_boxes ) {
    if(! hf_check_page_template(array('template-donate.php'))){
        return $meta_boxes;
    }

    $prefix = 'hfusa-';
    $meta_boxes[] = array(
        'id' => 'donate_fields_header',
        'title' => esc_html__( 'Donate Button in Header', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id'     => 'donate_button_header',
                'type'   => 'text',
                'name'   => esc_html__( 'Button URL', 'sage' )
            )
        )

    );
    $meta_boxes[] = array(
        'id' => 'donate_fields',
        'title' => esc_html__( 'Donate Page Buttons', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'fields' => array(
            array(
                'id'     => 'donate_page_button_fields',
                // Group field
                'type'   => 'group',
                // Clone whole group?
                'clone'  => true,
                // Drag and drop clones to reorder them?
                'sort_clone' => true,
                // Sub-fields
                'fields' => array(
                    array(
                        'id' => $prefix . 'donate_label',
                        'type' => 'text',
                        'name' => esc_html__( 'Button Label', 'sage' ),
                        'placeholder' => esc_html__( 'Donate', 'sage' )
                    ),
                    array(
                        'id' => $prefix . 'donate_url',
                        'type' => 'text',
                        'name' => esc_html__( 'Button URL', 'sage' )
                    )
                )
            )
        )

    );
    return $meta_boxes;
}
add_filter( 'rwmb_meta_boxes', 'hf_donate_page_meta_box' );

/*
 * Name: hf_check_page_template
 * Desc: Used to check Page template
 * Param: $templates array
 * Param: $postIDs array
 */

function hf_check_page_template($templates, $postIDs=array()){
    if ( ! is_admin() ) {
        return true;
    }
    if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
        return true;
    }

    if ( isset( $_GET['post'] ) ) {
        $post_id = intval( $_GET['post'] );
    } elseif ( isset( $_POST['post_ID'] ) ) {
        $post_id = intval( $_POST['post_ID'] );
    } else { $post_id = false;
    }
    $post_id = (int) $post_id;
    if (!empty($postIDs) && in_array( $post_id, $postIDs ) ) {
        return true;
    }

    $checked_templates = $templates;
    $template = get_post_meta( $post_id, '_wp_page_template', true );
    if ( in_array( $template, $checked_templates ) ) {
        return true;
    }
    return false;
}

function hf_covid_19_template_meta_boxes( $meta_boxes ) {

    $prefix = 'hfusa-';
    $meta_boxes[] = array(
        'id' => 'top_buttons',
        'title' => esc_html__( 'Top Buttons', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'visible' => array(
            'when' => array(
               array( 'page_template', 'template-covid-19.php' ),
               array( 'page_template', 'template-covid-19-v2.php' )
            ),
            'relation' => 'or'
        ),
        'fields' => array(
            array(
                'id'     => 'top_buttons_fields',
                // Group field
                'type'   => 'group',
                // Clone whole group?
                'clone'  => true,
                // Drag and drop clones to reorder them?
                'sort_clone' => true,
                // Sub-fields
                'fields' => array(
                    array(
                        'id' => $prefix . 'top_button_label',
                        'type' => 'text',
                        'name' => esc_html__( 'Button Label', 'sage' ),
                        'placeholder' => esc_html__( 'Enter button label', 'sage' )
                    ),
                    array(
                        'id' => $prefix . 'top_button_url',
                        'type' => 'text',
                        'name' => esc_html__( 'Button URL', 'sage' ),
                        'placeholder' => esc_html__( 'Enter button URL', 'sage' )
                    ),
                    array(
                        'id' => $prefix . 'top_button_target',
                        'type' => 'checkbox',
                        'name' => esc_html__( '', 'sage' ),
                        'desc' => esc_html__( 'Open in new tab', 'sage' ),
                    )
                )
            )
        )
    );
    $meta_boxes[] = array(
        'id' => 'left_buttons',
        'title' => esc_html__( 'Left Buttons (Map Area)', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'visible' => array(
            'when' => array(
               array( 'page_template', 'template-covid-19.php' ),
               array( 'page_template', 'template-covid-19-v2.php' )
            ),
            'relation' => 'or'
        ),
        'fields' => array(
            array(
                'id'     => 'left_buttons_fields',
                // Group field
                'type'   => 'group',
                // Clone whole group?
                'clone'  => true,
                // Drag and drop clones to reorder them?
                'sort_clone' => true,
                // Sub-fields
                'fields' => array(
                    array(
                        'id' => $prefix . 'left_button_label',
                        'type' => 'text',
                        'name' => esc_html__( 'Button Label', 'sage' ),
                        'placeholder' => esc_html__( 'Enter button label', 'sage' )
                    ),
                    array(
                        'id' => $prefix . 'left_button_url',
                        'type' => 'text',
                        'name' => esc_html__( 'Button URL', 'sage' ),
                        'placeholder' => esc_html__( 'Enter button URL', 'sage' )
                    ),
                    array(
                        'id' => $prefix . 'left_button_target',
                        'type' => 'checkbox',
                        'name' => esc_html__( '', 'sage' ),
                        'desc' => esc_html__( 'Open in new tab', 'sage' ),
                    )
                )
            )
        )
    );
    $meta_boxes[] = array(
        'id' => 'right_stats',
        'title' => esc_html__( 'COVID Stats (Map Area)', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'visible' => array(
            'when' => array(
               array( 'page_template', 'template-covid-19.php' ),
               array( 'page_template', 'template-covid-19-v2.php' )
            ),
            'relation' => 'or'
        ),
        'fields' => array(
            array(
                'id'     => 'stats_covid',
                // Group field
                'type'   => 'group',
                // Clone whole group?
                'clone'  => true,
                // Drag and drop clones to reorder them?
                'sort_clone' => true,
                // Sub-fields
                'fields' => array(
                    array(
                        'id' => $prefix . 'stat_label',
                        'type' => 'text',
                        'name' => esc_html__( 'Stat Label', 'sage' ),
                        'placeholder' => esc_html__( 'Enter stat label', 'sage' )
                    ),
                    array(
                        'id' => $prefix . 'stat_figure',
                        'type' => 'text',
                        'name' => esc_html__( 'Stat Figure', 'sage' ),
                        'placeholder' => esc_html__( 'Enter stat figure', 'sage' )
                    ),
                    array(
                        'id' => $prefix . 'stat_color',
                        'type' => 'color',
                        'name' => esc_html__( 'Pick stat box color', 'sage' ),
                    )
                )
            )
        )
    );
    $meta_boxes[] = array(
        'id' => 'headings',
        'title' => esc_html__( 'Headings', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'visible' => array(
            'when' => array(
               array( 'page_template', 'template-covid-19.php' ),
               array( 'page_template', 'template-covid-19-v2.php' )
            ),
            'relation' => 'or'
        ),
        'fields' => array(
            array(
                'id' => $prefix . 'left_buttons_heading',
                'type' => 'text',
                'name' => esc_html__( 'Left Buttons Heading', 'sage' ),
                'placeholder' => esc_html__( 'Enter heading text', 'sage' ),
            ),
            array(
                'id' => $prefix . 'situation_heading',
                'type' => 'text',
                'name' => esc_html__( 'US Situation Heading', 'sage' ),
                'placeholder' => esc_html__( 'Enter heading text', 'sage' ),
                'std' => 'US Situation Update'
            ),
            array(
                'id' => $prefix . 'summary_heading',
                'type' => 'text',
                'name' => esc_html__( 'Engagement Summary Heading', 'sage' ),
                'placeholder' => esc_html__( 'Enter heading text', 'sage' ),
                'std' => 'HFUSA - Engagement Summary'
            ),
        )
    );
    $meta_boxes[] = array(
        'id' => 'disclaimers',
        'title' => esc_html__( 'Disclaimers', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'visible' => array(
            'when' => array(
               array( 'page_template', 'template-covid-19.php' ),
               array( 'page_template', 'template-covid-19-v2.php' )
            ),
            'relation' => 'or'
        ),
        'fields' => array(
            array(
                'id' => $prefix . 'map_disclaimer',
                'type' => 'wysiwyg',
                'name' => esc_html__( 'Map Disclaimer', 'sage' ),
                'placeholder' => esc_html__( 'Enter disclaimer text', 'sage' ),
                'options' => array(
                    'textarea_rows' => 5,
                ),
            ),
            array(
                'id' => $prefix . 'update_disclaimer',
                'type' => 'wysiwyg',
                'name' => esc_html__( 'Situation Update Disclaimer', 'sage' ),
                'placeholder' => esc_html__( 'Enter disclaimer text', 'sage' ),
                'options' => array(
                    'textarea_rows' => 5,
                ),
            ),
        )
    );
    $meta_boxes[] = array(
        'id' => 'summary_actions',
        'title' => esc_html__( 'Engagement Summary Actions', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'visible' => array(
            'when' => array(
               array( 'page_template', 'template-covid-19.php' ),
               array( 'page_template', 'template-covid-19-v2.php' )
            ),
            'relation' => 'or'
        ),
        'fields' => array(
            array(
                'id'     => 'bottom_actions',
                // Group field
                'type'   => 'group',
                // Clone whole group?
                'clone'  => true,
                // Drag and drop clones to reorder them?
                'sort_clone' => true,
                // Sub-fields
                'fields' => array(
                    array(
                        'id' => $prefix . 'action_label',
                        'type' => 'text',
                        'name' => esc_html__( 'Action Box Label', 'sage' ),
                        'placeholder' => esc_html__( 'Enter box label', 'sage' )
                    ),
                    array(
                        'id' => $prefix . 'action_url',
                        'type' => 'text',
                        'name' => esc_html__( 'Action Box URL', 'sage' ),
                        'placeholder' => esc_html__( 'Enter box URL', 'sage' )
                    ),
                    array(
                        'id' => $prefix . 'action_icon',
                        'type' => 'image_advanced',
                        'name' => esc_html__( 'Action Box Icon', 'metabox-online-generator' ),
                        'max_file_uploads' => '1',
                    ),
                    array(
                        'id' => $prefix . 'action_color',
                        'type' => 'color',
                        'name' => esc_html__( 'Pick action box color', 'sage' ),
                    ),
                    array(
                        'id' => $prefix . 'action_target',
                        'type' => 'checkbox',
                        'name' => esc_html__( '', 'sage' ),
                        'desc' => esc_html__( 'Open in new tab', 'sage' ),
                    ),
                )
            )
        )
    );
    $meta_boxes[] = array(
        'id' => 'slider',
        'title' => esc_html__( 'Wonder Slider Shortcode', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'visible' => array(
            'when' => array(
               array( 'page_template', 'template-covid-19.php' ),
               array( 'page_template', 'template-covid-19-v2.php' )
            ),
            'relation' => 'or'
        ),
        'fields' => array(
            array(
                'id' => $prefix . 'slider_shortcode',
                'type' => 'text',
                'name' => esc_html__( 'Slider Shortcode', 'sage' ),
                'placeholder' => esc_html__( 'Enter shortcode', 'sage' )
            ),
        )
    );
    $meta_boxes[] = array(
        'id' => 'below_slider',
        'title' => esc_html__( 'Below Slider Actions', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'visible' => array(
            'when' => array(
               array( 'page_template', 'template-covid-19.php' ),
               array( 'page_template', 'template-covid-19-v2.php' )
            ),
            'relation' => 'or'
        ),
        'fields' => array(
            array(
                'id'     => 'below_slider_actions',
                // Group field
                'type'   => 'group',
                // Clone whole group?
                'clone'  => true,
                // Drag and drop clones to reorder them?
                'sort_clone' => true,
                // Sub-fields
                'fields' => array(
                    array(
                        'id' => $prefix . 'below_action_label',
                        'type' => 'text',
                        'name' => esc_html__( 'Action Box Label', 'sage' ),
                        'placeholder' => esc_html__( 'Enter box label', 'sage' )
                    ),
                    array(
                        'id' => $prefix . 'below_action_url',
                        'type' => 'text',
                        'name' => esc_html__( 'Action Box URL', 'sage' ),
                        'placeholder' => esc_html__( 'Enter box URL', 'sage' )
                    ),
                    array(
                        'id' => $prefix . 'below_action_icon',
                        'type' => 'image_advanced',
                        'name' => esc_html__( 'Action Box Icon', 'metabox-online-generator' ),
                        'max_file_uploads' => '1',
                    ),
                    array(
                        'id' => $prefix . 'below_action_color',
                        'type' => 'color',
                        'name' => esc_html__( 'Pick action box color', 'sage' ),
                    ),
                    array(
                        'id' => $prefix . 'below_action_target',
                        'type' => 'checkbox',
                        'name' => esc_html__( '', 'sage' ),
                        'desc' => esc_html__( 'Open in new tab', 'sage' ),
                    ),
                )
            )
        )
    );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'hf_covid_19_template_meta_boxes' );

function hf_google_places_template_meta_boxes( $meta_boxes ) {

    $prefix = 'hfusa-';
    $meta_boxes[] = array(
        'id' => 'config_fields',
        'title' => esc_html__( 'Page Configuration Fields', 'sage' ),
        'post_types' => array( 'page' ),
        'context' => 'advanced',
        'priority' => 'high',
        'autosave' => true,
        'visible' => array( 'page_template', 'template-google-places-search.php' ),
        'fields' => array(
            array(
                'id' => $prefix . 'intro_page',
                'type' => 'wysiwyg',
                'name' => esc_html__( 'Page Introduction', 'sage' ),
                'placeholder' => esc_html__( 'Enter text', 'sage' ),
                'options' => array(
                    'textarea_rows' => 5,
                ),
            ),
            array(
                'id' => $prefix . 'search_item',
                'type' => 'text',
                'name' => esc_html__( 'Search Item', 'sage' ),
                'placeholder' => esc_html__( 'Enter search item', 'sage' ),
            ),
            array(
                'id' => $prefix . 'search_item_property',
                'type' => 'checkbox',
                'name' => esc_html__( '', 'sage' ),
                'desc' => esc_html__( 'Disable Field', 'sage' ),
            ),
            array(
                'id'     => 'search_options',
                // Group field
                'type'   => 'group',
                // Clone whole group?
                'clone'  => true,
                // Drag and drop clones to reorder them?
                'sort_clone' => true,
                // Sub-fields
                'fields' => array(
                    array(
                        'id' => $prefix . 'search_option',
                        'type' => 'text',
                        'name' => esc_html__( 'Search Option', 'sage' ),
                        'placeholder' => esc_html__( 'Enter search option', 'sage' )
                    ),
                )
            ),
            array(
                'id' => $prefix . 'return_button_label',
                'type' => 'text',
                'name' => esc_html__( 'Return Button Label', 'sage' ),
                'placeholder' => esc_html__( 'Enter label', 'sage' ),
            ),
            array(
                'id' => $prefix . 'return_button_url',
                'type' => 'text',
                'name' => esc_html__( 'Return Button URL', 'sage' ),
                'placeholder' => esc_html__( 'Enter URL', 'sage' ),
            ),
        )
    );
    return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'hf_google_places_template_meta_boxes' );