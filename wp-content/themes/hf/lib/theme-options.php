<?php

add_action( 'tf_create_options', 'hfusa_create_options' );
function hfusa_create_options() {

    /**
     * Initiating Titan Framework
     */
    $titan = TitanFramework::getInstance( 'sage' );

    /**
     * Hero Section
     */
    $section = $titan->createThemeCustomizerSection( array(
        'name' => __( 'Hero Section', 'sage' ),
    ) );

    // Tagline
    $section->createOption( array(
        'name' => 'Tagline',
        'id' => 'hf_hero_tagline',
        'type' => 'text',
        'desc' => 'This field is for tagline above heading.'
    ) );

    // Heading
    $section->createOption( array(
        'name' => 'Heading',
        'id' => 'hf_hero_heading',
        'type' => 'text',
        'desc' => 'This field is for heading below tagline.'
    ) );

    // Description
    $section->createOption( array(
        'name' => 'Description',
        'id' => 'hf_hero_description',
        'type' => 'textarea',
        'desc' => 'This field is for description below heading.'
    ) );

    // Video Upload
    $section->createOption( array(
        'name' => 'Video Upload',
        'id' => 'hf_hero_video',
        'type' => 'file',
        'label' => 'Choose File',
        'desc' => 'This field is for hero section video.'
    ) );

    /**
     * About Us Section
     */
    $section = $titan->createThemeCustomizerSection( array(
        'name' => __( 'About Us Section', 'sage' ),
    ) );

    // Title
    $section->createOption( array(
        'name' => 'Title',
        'id' => 'hf_about_title',
        'type' => 'text',
        'desc' => 'This field is for About section Title.'
    ) );

    // Text
    $section->createOption( array(
        'name' => 'Text',
        'id' => 'hf_about_text',
        'type' => 'text',
        'desc' => 'This field is for About section text.'
    ) );

    // Background Image
    $section->createOption( array(
        'name' => 'Background Image',
        'id' => 'hf_about_bg_img',
        'type' => 'upload',
        'desc' => 'This field is for background image on About Us slide.'
    ) );


    /**
     * Our Work Section
     */
    $section = $titan->createThemeCustomizerSection( array(
        'name' => __( 'Our Work Section', 'sage' ),
    ) );

    // Title
    $section->createOption( array(
        'name' => 'Title',
        'id' => 'hf_ow_title',
        'type' => 'text',
        'desc' => 'This field is for Our Work section Title.'
    ) );

    // Text
    $section->createOption( array(
        'name' => 'Text',
        'id' => 'hf_ow_text',
        'type' => 'text',
        'desc' => 'This field is for Our Work section text.'
    ) );

    // Background Image
    $section->createOption( array(
        'name' => 'Background Image',
        'id' => 'hf_ow_bg_img',
        'type' => 'upload',
        'desc' => 'This field is for background image on Our Work slide.'
    ) );

    /**
     * Our Impact Section
     */
    $section = $titan->createThemeCustomizerSection( array(
        'name' => __( 'Our Impact Section', 'sage' ),
    ) );

    // Title
    $section->createOption( array(
        'name' => 'Title',
        'id' => 'hf_oi_title',
        'type' => 'text',
        'desc' => 'This field is for Our Impact section Title.'
    ) );

    // Text
    $section->createOption( array(
        'name' => 'Text',
        'id' => 'hf_oi_text',
        'type' => 'text',
        'desc' => 'This field is for Our Impact section text.'
    ) );

    // Background Image
    $section->createOption( array(
        'name' => 'Background Image',
        'id' => 'hf_oi_bg_img',
        'type' => 'upload',
        'desc' => 'This field is for background image on Our Impact slide.'
    ) );

    /**
     * Current Happenings Section
     */
    $section = $titan->createThemeCustomizerSection( array(
        'name' => __( 'Current Happenings Section', 'sage' ),
    ) );

    // Title
    $section->createOption( array(
        'name' => 'Title',
        'id' => 'hf_ch_title',
        'type' => 'text',
        'desc' => 'This field is for Current Happenings section Title.'
    ) );

    // Text
    $section->createOption( array(
        'name' => 'Text',
        'id' => 'hf_ch_text',
        'type' => 'text',
        'desc' => 'This field is for Current Happenings section text.'
    ) );

    // Background Image
    $section->createOption( array(
        'name' => 'Background Image',
        'id' => 'hf_ch_bg_img',
        'type' => 'upload',
        'desc' => 'This field is for background image on Current Happenings slide.'
    ) );

    /**
     * Multimedia Section
     */
    $section = $titan->createThemeCustomizerSection( array(
        'name' => __( 'Multimedia Section', 'sage' ),
    ) );

    // Title
    $section->createOption( array(
        'name' => 'Title',
        'id' => 'hf_resources_title',
        'type' => 'text',
        'desc' => 'This field is for Multimedia section Title.'
    ) );

    // Text
    $section->createOption( array(
        'name' => 'Text',
        'id' => 'hf_resources_text',
        'type' => 'text',
        'desc' => 'This field is for Multimedia section text.'
    ) );

    // Background Image
    $section->createOption( array(
        'name' => 'Background Image',
        'id' => 'hf_resources_bg_img',
        'type' => 'upload',
        'desc' => 'This field is for background image on Multimedia slide.'
    ) );

    /**
     * Get Involved Section
     */
    $section = $titan->createThemeCustomizerSection( array(
        'name' => __( 'Get Involved Section', 'sage' ),
    ) );

    // Title
    $section->createOption( array(
        'name' => 'Title',
        'id' => 'hf_gi_title',
        'type' => 'text',
        'desc' => 'This field is for Get Involved section Title.'
    ) );

    // Text
    $section->createOption( array(
        'name' => 'Text',
        'id' => 'hf_gi_text',
        'type' => 'text',
        'desc' => 'This field is for Get Involved section text.'
    ) );

    // Background Image
    $section->createOption( array(
        'name' => 'Background Image',
        'id' => 'hf_gi_bg_img',
        'type' => 'upload',
        'desc' => 'This field is for background image on Get Involved slide.'
    ) );

    /**
     * Footer Section
     */

    // Contact Us Sub Section
    $contact_section = $titan->createThemeCustomizerSection( array(
        'name' => __( 'Contact Us Section', 'sage' ),
        'panel' => __( 'Footer Section', 'sage' ),
    ) );

    // Text
    $contact_section->createOption( array(
        'name' => 'Heading',
        'id' => 'hf_footer_contact_heading',
        'type' => 'text',
        'desc' => 'This field is for Contact Us heading in the footer area.'
    ) );

    // Textarea
    $contact_section->createOption( array(
        'name' => 'Description',
        'id' => 'hf_footer_desc_heading',
        'type' => 'textarea',
        'desc' => 'This field is for Contact Us description in the footer area.'
    ) );

    // About Us Sub Section
    $about_section = $titan->createThemeCustomizerSection( array(
        'name' => __( 'About Information Section', 'sage' ),
        'panel' => __( 'Footer Section', 'sage' ),
    ) );

    // Text
    $about_section->createOption( array(
        'name' => 'Description',
        'id' => 'hf_about_desc',
        'type' => 'textarea',
        'desc' => 'This field is for description in the footer area.'
    ) );

    // Text
    $about_section->createOption( array(
        'name' => 'Phone',
        'id' => 'hf_about_phone',
        'type' => 'text',
        'desc' => 'This field is for phone in the footer area.'
    ) );

    // Text
    $about_section->createOption( array(
        'name' => 'Email',
        'id' => 'hf_about_email',
        'type' => 'text',
        'desc' => 'This field is for email in the footer area.'
    ) );

    // Text
    $about_section->createOption( array(
        'name' => 'Address',
        'id' => 'hf_about_address',
        'type' => 'textarea',
        'desc' => 'This field is for address in the footer area.'
    ) );

    // Follow Us Sub Section
    $follow_us_section = $titan->createThemeCustomizerSection( array(
        'name' => __( 'Follow Us Section', 'sage' ),
        'panel' => __( 'Footer Section', 'sage' ),
    ) );

    // Text
    $follow_us_section->createOption( array(
        'name' => 'Facebook Link',
        'id' => 'hf_follow_fb',
        'type' => 'text',
        'desc' => 'This field is for Facebook link in the footer area.'
    ) );

    // Text
    $follow_us_section->createOption( array(
        'name' => 'Twitter Link',
        'id' => 'hf_follow_twitter',
        'type' => 'text',
        'desc' => 'This field is for Twitter link in the footer area.'
    ) );

    // Text
    $follow_us_section->createOption( array(
        'name' => 'Google Plus Link',
        'id' => 'hf_follow_google_plus',
        'type' => 'text',
        'desc' => 'This field is for Google+ link in the footer area.'
    ) );

    // Text
    $follow_us_section->createOption( array(
        'name' => 'Email Link',
        'id' => 'hf_follow_email',
        'type' => 'text',
        'desc' => 'This field is for Email link in the footer area.'
    ) );

    // Copyright Sub Section
    $copyright_section = $titan->createThemeCustomizerSection( array(
        'name' => __( 'Copyright Section', 'sage' ),
        'panel' => __( 'Footer Section', 'sage' ),
    ) );

    // Text
    $copyright_section->createOption( array(
        'name' => 'Copyright Text',
        'id' => 'hf_footer_copyright_text',
        'type' => 'text',
        'desc' => 'This field is for copyright text in the footer area.'
    ) );

}