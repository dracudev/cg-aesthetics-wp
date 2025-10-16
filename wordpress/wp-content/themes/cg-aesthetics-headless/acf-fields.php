<?php
/**
 * ACF Field Groups Configuration
 * 
 * This file contains all Advanced Custom Fields configurations for the Beauty Studio project.
 * Import this via ACF Tools > Import or use ACF Local JSON.
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register ACF Field Group: Service Details
 */
if (function_exists('acf_add_local_field_group')) {
    
    // Service Details Field Group
    acf_add_local_field_group(array(
        'key' => 'group_service_details',
        'title' => 'Service Details',
        'fields' => array(
            array(
                'key' => 'field_service_description',
                'label' => 'Service Description',
                'name' => 'service_description',
                'type' => 'wysiwyg',
                'instructions' => 'Detailed description of the service',
                'required' => 1,
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_service_duration',
                'label' => 'Duration (minutes)',
                'name' => 'service_duration',
                'type' => 'number',
                'instructions' => 'Duration in minutes',
                'required' => 1,
                'min' => 15,
                'max' => 480,
                'step' => 15,
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_service_price',
                'label' => 'Price',
                'name' => 'service_price',
                'type' => 'text',
                'instructions' => 'Price (e.g., "$99" or "$99-150")',
                'required' => 1,
                'placeholder' => '$99',
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_featured_service',
                'label' => 'Featured Service',
                'name' => 'featured_service',
                'type' => 'true_false',
                'instructions' => 'Display on homepage?',
                'default_value' => 0,
                'ui' => 1,
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_service_benefits',
                'label' => 'Benefits',
                'name' => 'service_benefits',
                'type' => 'textarea',
                'instructions' => 'List of service benefits (one per line)',
                'placeholder' => "Réduit le stress et l'anxiété\nAméliore la circulation sanguine\nSoulage les tensions musculaires",
                'rows' => 8,
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_service_gallery',
                'label' => 'Service Gallery',
                'name' => 'service_gallery',
                'type' => 'gallery',
                'instructions' => 'Additional images for the service',
                'return_format' => 'array',
                'library' => 'all',
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_bookable_online',
                'label' => 'Bookable Online',
                'name' => 'bookable_online',
                'type' => 'true_false',
                'instructions' => 'Can this service be booked online?',
                'default_value' => 1,
                'ui' => 1,
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_booking_notes',
                'label' => 'Booking Notes',
                'name' => 'booking_notes',
                'type' => 'textarea',
                'instructions' => 'Special instructions for booking',
                'rows' => 3,
                'show_in_graphql' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'spa_service',
                ),
            ),
        ),
        'show_in_graphql' => 1,
        'graphql_field_name' => 'serviceDetails',
    ));

    // Team Member Details Field Group
    acf_add_local_field_group(array(
        'key' => 'group_team_member_details',
        'title' => 'Team Member Details',
        'fields' => array(
            array(
                'key' => 'field_member_position',
                'label' => 'Position',
                'name' => 'position',
                'type' => 'text',
                'instructions' => 'Job title or position',
                'required' => 1,
                'placeholder' => 'e.g., Lead Massage Therapist',
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_member_bio_short',
                'label' => 'Short Bio',
                'name' => 'bio_short',
                'type' => 'textarea',
                'instructions' => 'Brief bio (max 150 characters)',
                'required' => 1,
                'rows' => 3,
                'maxlength' => 150,
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_member_bio_full',
                'label' => 'Full Bio',
                'name' => 'bio_full',
                'type' => 'wysiwyg',
                'instructions' => 'Detailed biography',
                'required' => 1,
                'tabs' => 'all',
                'toolbar' => 'basic',
                'media_upload' => 0,
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_member_specialties',
                'label' => 'Specialties',
                'name' => 'specialties',
                'type' => 'repeater',
                'instructions' => 'Areas of expertise',
                'layout' => 'table',
                'button_label' => 'Add Specialty',
                'show_in_graphql' => 1,
                'sub_fields' => array(
                    array(
                        'key' => 'field_specialty_name',
                        'label' => 'Specialty',
                        'name' => 'specialty_name',
                        'type' => 'text',
                        'show_in_graphql' => 1,
                    ),
                ),
            ),
            array(
                'key' => 'field_member_certifications',
                'label' => 'Certifications',
                'name' => 'certifications',
                'type' => 'textarea',
                'instructions' => 'Professional certifications and qualifications',
                'rows' => 4,
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_member_display_order',
                'label' => 'Display Order',
                'name' => 'display_order',
                'type' => 'number',
                'instructions' => 'Order in team listing (lower numbers first)',
                'default_value' => 10,
                'min' => 1,
                'show_in_graphql' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'team_member',
                ),
            ),
        ),
        'show_in_graphql' => 1,
        'graphql_field_name' => 'teamMemberDetails',
    ));

    // Testimonial Details Field Group
    acf_add_local_field_group(array(
        'key' => 'group_testimonial_details',
        'title' => 'Testimonial Details',
        'fields' => array(
            array(
                'key' => 'field_testimonial_client_name',
                'label' => 'Client Name',
                'name' => 'client_name',
                'type' => 'text',
                'instructions' => 'Name to display (can be first name only)',
                'required' => 1,
                'placeholder' => 'e.g., Sarah M.',
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_testimonial_review_text',
                'label' => 'Review',
                'name' => 'review_text',
                'type' => 'textarea',
                'instructions' => 'The testimonial text',
                'required' => 1,
                'rows' => 5,
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_testimonial_rating',
                'label' => 'Rating',
                'name' => 'rating',
                'type' => 'number',
                'instructions' => 'Star rating (1-5)',
                'required' => 1,
                'default_value' => 5,
                'min' => 1,
                'max' => 5,
                'step' => 1,
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_testimonial_client_photo',
                'label' => 'Client Photo',
                'name' => 'client_photo',
                'type' => 'image',
                'instructions' => 'Optional photo of the client',
                'return_format' => 'array',
                'preview_size' => 'thumbnail',
                'library' => 'all',
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_testimonial_service_related',
                'label' => 'Related Service',
                'name' => 'service_related',
                'type' => 'post_object',
                'instructions' => 'Which service is this testimonial about?',
                'post_type' => array('spa_service'),
                'return_format' => 'object',
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_testimonial_featured',
                'label' => 'Featured',
                'name' => 'featured',
                'type' => 'true_false',
                'instructions' => 'Display on homepage?',
                'default_value' => 0,
                'ui' => 1,
                'show_in_graphql' => 1,
            ),
            array(
                'key' => 'field_testimonial_date_submitted',
                'label' => 'Date Submitted',
                'name' => 'date_submitted',
                'type' => 'date_picker',
                'instructions' => 'When was this review received?',
                'display_format' => 'F j, Y',
                'return_format' => 'Y-m-d',
                'show_in_graphql' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'testimonial',
                ),
            ),
        ),
        'show_in_graphql' => 1,
        'graphql_field_name' => 'testimonialDetails',
    ));
}
