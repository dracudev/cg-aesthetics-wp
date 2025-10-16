<?php
/**
 * CG Aesthetics Headless Theme Functions
 * 
 * This theme serves as a headless CMS backend for the CG Aesthetics Astro frontend.
 * It includes custom post types, taxonomies, and GraphQL configuration.
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Theme Setup
 */
function cg_aesthetics_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    
    // Add image sizes for services and team members
    add_image_size('service-thumbnail', 400, 300, true);
    add_image_size('service-hero', 1200, 600, true);
    add_image_size('team-member', 400, 400, true);
}
add_action('after_setup_theme', 'cg_aesthetics_setup');

/**
 * Disable unnecessary features for headless setup
 */
function cg_aesthetics_disable_features() {
    // Remove default post type (we'll use custom post types)
    // Uncomment if you don't need blog posts
    // add_filter('use_block_editor_for_post_type', '__return_false', 10);
}
add_action('init', 'cg_aesthetics_disable_features');

/**
 * Register Custom Post Type: Services
 */
function cg_aesthetics_register_services_cpt() {
    $labels = array(
        'name'                  => _x('Services', 'Post Type General Name', 'cg-aesthetics'),
        'singular_name'         => _x('Service', 'Post Type Singular Name', 'cg-aesthetics'),
        'menu_name'             => __('Services', 'cg-aesthetics'),
        'all_items'             => __('All Services', 'cg-aesthetics'),
        'add_new_item'          => __('Add New Service', 'cg-aesthetics'),
        'add_new'               => __('Add New', 'cg-aesthetics'),
        'edit_item'             => __('Edit Service', 'cg-aesthetics'),
        'update_item'           => __('Update Service', 'cg-aesthetics'),
        'view_item'             => __('View Service', 'cg-aesthetics'),
        'search_items'          => __('Search Services', 'cg-aesthetics'),
    );

    $args = array(
        'label'                 => __('Service', 'cg-aesthetics'),
        'labels'                => $labels,
        'supports'              => array('title', 'editor', 'excerpt', 'thumbnail'),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => 'dashicons-admin-appearance',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => true,
        'hierarchical'          => false,
        'exclude_from_search'   => false,
        'show_in_rest'          => true,
        'publicly_queryable'    => true,
        'capability_type'       => 'post',
        'show_in_graphql'       => true,
        'graphql_single_name'   => 'service',
        'graphql_plural_name'   => 'services',
    );

    register_post_type('spa_service', $args);
}
add_action('init', 'cg_aesthetics_register_services_cpt', 0);

/**
 * Register Custom Post Type: Team Members
 */
function cg_aesthetics_register_team_cpt() {
    $labels = array(
        'name'                  => _x('Team Members', 'Post Type General Name', 'cg-aesthetics'),
        'singular_name'         => _x('Team Member', 'Post Type Singular Name', 'cg-aesthetics'),
        'menu_name'             => __('Team', 'cg-aesthetics'),
        'all_items'             => __('All Team Members', 'cg-aesthetics'),
        'add_new_item'          => __('Add New Team Member', 'cg-aesthetics'),
        'add_new'               => __('Add New', 'cg-aesthetics'),
        'edit_item'             => __('Edit Team Member', 'cg-aesthetics'),
        'update_item'           => __('Update Team Member', 'cg-aesthetics'),
        'view_item'             => __('View Team Member', 'cg-aesthetics'),
        'search_items'          => __('Search Team Members', 'cg-aesthetics'),
    );

    $args = array(
        'label'                 => __('Team Member', 'cg-aesthetics'),
        'labels'                => $labels,
        'supports'              => array('title', 'thumbnail'),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 6,
        'menu_icon'             => 'dashicons-groups',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'hierarchical'          => false,
        'exclude_from_search'   => true,
        'show_in_rest'          => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_graphql'       => true,
        'graphql_single_name'   => 'teamMember',
        'graphql_plural_name'   => 'teamMembers',
    );

    register_post_type('team_member', $args);
}
add_action('init', 'cg_aesthetics_register_team_cpt', 0);

/**
 * Register Custom Post Type: Testimonials
 */
function cg_aesthetics_register_testimonials_cpt() {
    $labels = array(
        'name'                  => _x('Testimonials', 'Post Type General Name', 'cg-aesthetics'),
        'singular_name'         => _x('Testimonial', 'Post Type Singular Name', 'cg-aesthetics'),
        'menu_name'             => __('Testimonials', 'cg-aesthetics'),
        'all_items'             => __('All Testimonials', 'cg-aesthetics'),
        'add_new_item'          => __('Add New Testimonial', 'cg-aesthetics'),
        'add_new'               => __('Add New', 'cg-aesthetics'),
        'edit_item'             => __('Edit Testimonial', 'cg-aesthetics'),
        'update_item'           => __('Update Testimonial', 'cg-aesthetics'),
        'view_item'             => __('View Testimonial', 'cg-aesthetics'),
        'search_items'          => __('Search Testimonials', 'cg-aesthetics'),
    );

    $args = array(
        'label'                 => __('Testimonial', 'cg-aesthetics'),
        'labels'                => $labels,
        'supports'              => array('title'),
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 7,
        'menu_icon'             => 'dashicons-star-filled',
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => false,
        'can_export'            => true,
        'has_archive'           => false,
        'hierarchical'          => false,
        'exclude_from_search'   => true,
        'show_in_rest'          => true,
        'publicly_queryable'    => false,
        'capability_type'       => 'post',
        'show_in_graphql'       => true,
        'graphql_single_name'   => 'testimonial',
        'graphql_plural_name'   => 'testimonials',
    );

    register_post_type('testimonial', $args);
}
add_action('init', 'cg_aesthetics_register_testimonials_cpt', 0);

/**
 * Register Taxonomy: Service Categories
 */
function cg_aesthetics_register_service_categories() {
    $labels = array(
        'name'                       => _x('Service Categories', 'Taxonomy General Name', 'cg-aesthetics'),
        'singular_name'              => _x('Service Category', 'Taxonomy Singular Name', 'cg-aesthetics'),
        'menu_name'                  => __('Categories', 'cg-aesthetics'),
        'all_items'                  => __('All Categories', 'cg-aesthetics'),
        'parent_item'                => __('Parent Category', 'cg-aesthetics'),
        'parent_item_colon'          => __('Parent Category:', 'cg-aesthetics'),
        'new_item_name'              => __('New Category Name', 'cg-aesthetics'),
        'add_new_item'               => __('Add New Category', 'cg-aesthetics'),
        'edit_item'                  => __('Edit Category', 'cg-aesthetics'),
        'update_item'                => __('Update Category', 'cg-aesthetics'),
        'view_item'                  => __('View Category', 'cg-aesthetics'),
        'separate_items_with_commas' => __('Separate categories with commas', 'cg-aesthetics'),
        'add_or_remove_items'        => __('Add or remove categories', 'cg-aesthetics'),
        'choose_from_most_used'      => __('Choose from the most used', 'cg-aesthetics'),
        'popular_items'              => __('Popular Categories', 'cg-aesthetics'),
        'search_items'               => __('Search Categories', 'cg-aesthetics'),
        'not_found'                  => __('Not Found', 'cg-aesthetics'),
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
        'show_in_graphql'            => true,
        'graphql_single_name'        => 'serviceCategory',
        'graphql_plural_name'        => 'serviceCategories',
    );

    register_taxonomy('service_category', array('spa_service'), $args);
}
add_action('init', 'cg_aesthetics_register_service_categories', 0);

/**
 * Add CORS headers for GraphQL API
 */
function cg_aesthetics_add_cors_headers() {
    // Get the frontend URL from environment or set default
    $allowed_origin = defined('FRONTEND_URL') ? FRONTEND_URL : 'http://localhost:4321';
    
    header("Access-Control-Allow-Origin: {$allowed_origin}");
    header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
    header("Access-Control-Allow-Credentials: true");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
}
add_action('graphql_init', 'cg_aesthetics_add_cors_headers');

/**
 * Flush rewrite rules on theme activation
 */
function cg_aesthetics_activation() {
    cg_aesthetics_register_services_cpt();
    cg_aesthetics_register_team_cpt();
    cg_aesthetics_register_testimonials_cpt();
    cg_aesthetics_register_service_categories();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'cg_aesthetics_activation');

/**
 * Enqueue admin styles (optional)
 */
function cg_aesthetics_admin_styles() {
    wp_enqueue_style('cg-aesthetics-admin', get_template_directory_uri() . '/style.css');
}
add_action('admin_enqueue_scripts', 'cg_aesthetics_admin_styles');

/**
 * Disable admin bar on front-end for all users (headless theme)
 */
add_filter('show_admin_bar', '__return_false');

/**
 * Remove WordPress admin bar CSS
 */
function cg_aesthetics_remove_admin_bar_css() {
    remove_action('wp_head', '_admin_bar_bump_cb');
}
add_action('get_header', 'cg_aesthetics_remove_admin_bar_css');

/**
 * Load ACF Field Groups
 */
require_once get_template_directory() . '/acf-fields.php';

/**
 * Load SEO Configuration
 */
require_once get_template_directory() . '/seo-setup.php';

/**
 * Register ACF Fields to GraphQL Manually
 * Since WPGraphQL for ACF has compatibility issues, we register fields manually
 */
function cg_aesthetics_register_acf_to_graphql() {
    if (!function_exists('register_graphql_field') || !function_exists('get_field')) {
        return;
    }

    // Register Service Details fields
    register_graphql_object_type('ServiceDetails', [
        'description' => 'Service details from ACF',
        'fields' => [
            'serviceDescription' => ['type' => 'String'],
            'serviceDuration' => ['type' => 'Integer'],
            'servicePrice' => ['type' => 'String'],
            'featuredService' => ['type' => 'Boolean'],
            'bookableOnline' => ['type' => 'Boolean'],
            'bookingNotes' => ['type' => 'String'],
            'serviceBenefits' => [
                'type' => ['list_of' => 'ServiceBenefit'],
            ],
            'serviceGallery' => [
                'type' => ['list_of' => 'MediaItem'],
            ],
        ],
    ]);

    register_graphql_object_type('ServiceBenefit', [
        'fields' => [
            'benefitText' => ['type' => 'String'],
        ],
    ]);

    register_graphql_field('Service', 'serviceDetails', [
        'type' => 'ServiceDetails',
        'description' => 'ACF Service Details',
        'resolve' => function($post) {
            $benefits = get_field('service_benefits', $post->ID);
            $gallery = get_field('service_gallery', $post->ID);
            
            // Map benefits to the correct structure
            $formatted_benefits = [];
            if (is_array($benefits)) {
                foreach ($benefits as $benefit) {
                    $formatted_benefits[] = [
                        'benefitText' => isset($benefit['benefit_text']) ? $benefit['benefit_text'] : null,
                    ];
                }
            }
            
            return [
                'serviceDescription' => get_field('service_description', $post->ID),
                'serviceDuration' => (int) get_field('service_duration', $post->ID),
                'servicePrice' => get_field('service_price', $post->ID),
                'featuredService' => (bool) get_field('featured_service', $post->ID),
                'bookableOnline' => (bool) get_field('bookable_online', $post->ID),
                'bookingNotes' => get_field('booking_notes', $post->ID),
                'serviceBenefits' => $formatted_benefits,
                'serviceGallery' => is_array($gallery) ? $gallery : [],
            ];
        },
    ]);

    // Register Team Member Details fields
    register_graphql_object_type('TeamMemberDetails', [
        'description' => 'Team member details from ACF',
        'fields' => [
            'position' => ['type' => 'String'],
            'bioShort' => ['type' => 'String'],
            'bioFull' => ['type' => 'String'],
            'certifications' => ['type' => 'String'],
            'displayOrder' => ['type' => 'Integer'],
            'specialties' => [
                'type' => ['list_of' => 'Specialty'],
            ],
        ],
    ]);

    register_graphql_object_type('Specialty', [
        'fields' => [
            'specialtyName' => ['type' => 'String'],
        ],
    ]);

    register_graphql_field('TeamMember', 'teamMemberDetails', [
        'type' => 'TeamMemberDetails',
        'description' => 'ACF Team Member Details',
        'resolve' => function($post) {
            $specialties = get_field('specialties', $post->ID);
            
            return [
                'position' => get_field('position', $post->ID),
                'bioShort' => get_field('bio_short', $post->ID),
                'bioFull' => get_field('bio_full', $post->ID),
                'certifications' => get_field('certifications', $post->ID),
                'displayOrder' => (int) get_field('display_order', $post->ID),
                'specialties' => is_array($specialties) ? $specialties : [],
            ];
        },
    ]);

    // Register Testimonial Details fields
    register_graphql_object_type('TestimonialDetails', [
        'description' => 'Testimonial details from ACF',
        'fields' => [
            'clientName' => ['type' => 'String'],
            'reviewText' => ['type' => 'String'],
            'rating' => ['type' => 'Integer'],
            'featured' => ['type' => 'Boolean'],
            'dateSubmitted' => ['type' => 'String'],
            'clientPhoto' => ['type' => 'MediaItem'],
            'serviceRelated' => ['type' => 'Service'],
        ],
    ]);

    register_graphql_field('Testimonial', 'testimonialDetails', [
        'type' => 'TestimonialDetails',
        'description' => 'ACF Testimonial Details',
        'resolve' => function($post) {
            $client_photo = get_field('client_photo', $post->ID);
            $service_related = get_field('service_related', $post->ID);
            
            return [
                'clientName' => get_field('client_name', $post->ID),
                'reviewText' => get_field('review_text', $post->ID),
                'rating' => (int) get_field('rating', $post->ID),
                'featured' => (bool) get_field('featured', $post->ID),
                'dateSubmitted' => get_field('date_submitted', $post->ID),
                'clientPhoto' => $client_photo,
                'serviceRelated' => $service_related,
            ];
        },
    ]);
}
add_action('graphql_register_types', 'cg_aesthetics_register_acf_to_graphql');
