<?php
/**
 * SEO Configuration and Enhancements
 * 
 * This file handles SEO-related functionality including:
 * - Image optimization settings
 * - Yoast SEO GraphQL integration
 * - Meta tags configuration
 * - Structured data preparation
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Register Yoast SEO data to GraphQL
 */
function cg_aesthetics_register_yoast_to_graphql() {
    if (!function_exists('register_graphql_field')) {
        return;
    }

    // Register SEO object type
    register_graphql_object_type('SEO', [
        'description' => 'Yoast SEO data',
        'fields' => [
            'title' => ['type' => 'String'],
            'metaDesc' => ['type' => 'String'],
            'metaKeywords' => ['type' => 'String'],
            'canonical' => ['type' => 'String'],
            'opengraphTitle' => ['type' => 'String'],
            'opengraphDescription' => ['type' => 'String'],
            'opengraphImage' => [
                'type' => 'MediaItem',
                'description' => 'The open graph image'
            ],
            'twitterTitle' => ['type' => 'String'],
            'twitterDescription' => ['type' => 'String'],
            'twitterImage' => [
                'type' => 'MediaItem',
                'description' => 'The twitter card image'
            ],
            'focuskw' => ['type' => 'String'],
            'metaRobotsNoindex' => ['type' => 'String'],
            'metaRobotsNofollow' => ['type' => 'String'],
            'breadcrumbs' => [
                'type' => ['list_of' => 'Breadcrumb'],
            ],
            'schema' => ['type' => 'String'],
        ],
    ]);

    register_graphql_object_type('Breadcrumb', [
        'fields' => [
            'text' => ['type' => 'String'],
            'url' => ['type' => 'String'],
        ],
    ]);

    // Add SEO field to post types
    $post_types = ['Service', 'TeamMember', 'Testimonial', 'Page', 'Post'];
    
    foreach ($post_types as $post_type) {
        register_graphql_field($post_type, 'seo', [
            'type' => 'SEO',
            'description' => 'Yoast SEO metadata',
            'resolve' => function($post) {
                $seo_data = [];

                // Get Yoast SEO data if available
                if (class_exists('WPSEO_Meta')) {
                    $seo_data['title'] = WPSEO_Meta::get_value('title', $post->ID);
                    $seo_data['metaDesc'] = WPSEO_Meta::get_value('metadesc', $post->ID);
                    $seo_data['metaKeywords'] = WPSEO_Meta::get_value('metakeywords', $post->ID);
                    $seo_data['canonical'] = WPSEO_Meta::get_value('canonical', $post->ID);
                    $seo_data['opengraphTitle'] = WPSEO_Meta::get_value('opengraph-title', $post->ID);
                    $seo_data['opengraphDescription'] = WPSEO_Meta::get_value('opengraph-description', $post->ID);
                    $seo_data['twitterTitle'] = WPSEO_Meta::get_value('twitter-title', $post->ID);
                    $seo_data['twitterDescription'] = WPSEO_Meta::get_value('twitter-description', $post->ID);
                    $seo_data['focuskw'] = WPSEO_Meta::get_value('focuskw', $post->ID);
                    $seo_data['metaRobotsNoindex'] = WPSEO_Meta::get_value('meta-robots-noindex', $post->ID);
                    $seo_data['metaRobotsNofollow'] = WPSEO_Meta::get_value('meta-robots-nofollow', $post->ID);

                    // Get OpenGraph image
                    $og_image_id = WPSEO_Meta::get_value('opengraph-image-id', $post->ID);
                    if ($og_image_id) {
                        $seo_data['opengraphImage'] = get_post($og_image_id);
                    }

                    // Get Twitter image
                    $twitter_image_id = WPSEO_Meta::get_value('twitter-image-id', $post->ID);
                    if ($twitter_image_id) {
                        $seo_data['twitterImage'] = get_post($twitter_image_id);
                    }

                    // Get breadcrumbs
                    if (function_exists('yoast_breadcrumb')) {
                        $breadcrumbs = [];
                        // This is a simplified version - Yoast breadcrumbs need special handling
                        $seo_data['breadcrumbs'] = $breadcrumbs;
                    }
                }

                // Fallbacks to WordPress defaults
                if (empty($seo_data['title'])) {
                    $seo_data['title'] = get_the_title($post->ID);
                }
                if (empty($seo_data['metaDesc'])) {
                    $seo_data['metaDesc'] = get_the_excerpt($post->ID);
                }

                return $seo_data;
            },
        ]);
    }

    // Add global SEO settings
    register_graphql_field('RootQuery', 'seoSettings', [
        'type' => 'SEO',
        'description' => 'Global SEO settings',
        'resolve' => function() {
            $seo_data = [];
            
            if (class_exists('WPSEO_Options')) {
                $options = WPSEO_Options::get_all();
                $seo_data['title'] = get_option('wpseo_titles') ? $options['title-home-wpseo'] : get_bloginfo('name');
                $seo_data['metaDesc'] = get_option('wpseo_titles') ? $options['metadesc-home-wpseo'] : get_bloginfo('description');
                $seo_data['opengraphImage'] = null; // Can be enhanced
                $seo_data['twitterImage'] = null; // Can be enhanced
            }
            
            return $seo_data;
        },
    ]);
}
add_action('graphql_register_types', 'cg_aesthetics_register_yoast_to_graphql');

/**
 * Image Optimization Settings
 */
function cg_aesthetics_image_optimization() {
    // Enable WebP support
    add_filter('wp_image_editors', function($editors) {
        return ['WP_Image_Editor_GD', 'WP_Image_Editor_Imagick'];
    });

    // Add additional image sizes for optimization
    add_image_size('hero-large', 1920, 1080, true);
    add_image_size('hero-medium', 1280, 720, true);
    add_image_size('hero-small', 768, 432, true);
    add_image_size('card-large', 800, 600, true);
    add_image_size('card-medium', 600, 450, true);
    add_image_size('card-small', 400, 300, true);
    add_image_size('thumbnail-large', 300, 300, true);
    add_image_size('thumbnail-medium', 200, 200, true);
    add_image_size('thumbnail-small', 100, 100, true);

    // Make custom image sizes selectable in admin
    add_filter('image_size_names_choose', function($sizes) {
        return array_merge($sizes, [
            'hero-large' => __('Hero Large (1920x1080)', 'cg-aesthetics'),
            'hero-medium' => __('Hero Medium (1280x720)', 'cg-aesthetics'),
            'card-large' => __('Card Large (800x600)', 'cg-aesthetics'),
            'card-medium' => __('Card Medium (600x450)', 'cg-aesthetics'),
        ]);
    });
}
add_action('after_setup_theme', 'cg_aesthetics_image_optimization');

/**
 * Optimize image quality
 */
function cg_aesthetics_image_quality($quality, $mime_type) {
    // Set JPEG quality to 85% for better optimization
    if ($mime_type === 'image/jpeg') {
        return 85;
    }
    return $quality;
}
add_filter('wp_editor_set_quality', 'cg_aesthetics_image_quality', 10, 2);
add_filter('jpeg_quality', function() { return 85; });

/**
 * Add image metadata for SEO
 */
function cg_aesthetics_image_metadata($metadata, $attachment_id) {
    // Ensure alt text is set
    $alt_text = get_post_meta($attachment_id, '_wp_attachment_image_alt', true);
    if (empty($alt_text)) {
        $post = get_post($attachment_id);
        $alt_text = $post->post_title;
        update_post_meta($attachment_id, '_wp_attachment_image_alt', $alt_text);
    }
    
    return $metadata;
}
add_filter('wp_update_attachment_metadata', 'cg_aesthetics_image_metadata', 10, 2);

/**
 * Schema.org structured data support
 * This prepares data that can be used by the frontend
 */
function cg_aesthetics_get_schema_org_data($post_id, $post_type) {
    $schema = [];
    
    switch ($post_type) {
        case 'spa_service':
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'Service',
                'name' => get_the_title($post_id),
                'description' => get_the_excerpt($post_id),
                'provider' => [
                    '@type' => 'LocalBusiness',
                    'name' => get_bloginfo('name'),
                ],
            ];
            
            $price = get_field('service_price', $post_id);
            if ($price) {
                $schema['offers'] = [
                    '@type' => 'Offer',
                    'price' => $price,
                    'priceCurrency' => 'USD', // Change as needed
                ];
            }
            break;
            
        case 'team_member':
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'Person',
                'name' => get_the_title($post_id),
                'jobTitle' => get_field('position', $post_id),
                'description' => get_field('bio_short', $post_id),
            ];
            break;
            
        case 'testimonial':
            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'Review',
                'author' => [
                    '@type' => 'Person',
                    'name' => get_field('client_name', $post_id),
                ],
                'reviewBody' => get_field('review_text', $post_id),
                'reviewRating' => [
                    '@type' => 'Rating',
                    'ratingValue' => get_field('rating', $post_id),
                    'bestRating' => 5,
                ],
            ];
            break;
    }
    
    return json_encode($schema);
}

/**
 * Add schema to GraphQL
 */
add_action('graphql_register_types', function() {
    if (!function_exists('register_graphql_field')) {
        return;
    }

    // Add schema field to Service
    register_graphql_field('Service', 'schemaOrg', [
        'type' => 'String',
        'description' => 'Schema.org structured data JSON',
        'resolve' => function($post) {
            return cg_aesthetics_get_schema_org_data($post->ID, 'spa_service');
        },
    ]);

    // Add schema field to TeamMember
    register_graphql_field('TeamMember', 'schemaOrg', [
        'type' => 'String',
        'description' => 'Schema.org structured data JSON',
        'resolve' => function($post) {
            return cg_aesthetics_get_schema_org_data($post->ID, 'team_member');
        },
    ]);

    // Add schema field to Testimonial
    register_graphql_field('Testimonial', 'schemaOrg', [
        'type' => 'String',
        'description' => 'Schema.org structured data JSON',
        'resolve' => function($post) {
            return cg_aesthetics_get_schema_org_data($post->ID, 'testimonial');
        },
    ]);
});

/**
 * Optimize REST API responses for headless
 */
function cg_aesthetics_rest_api_optimization() {
    // Remove unnecessary REST API fields
    add_filter('rest_prepare_post', function($response, $post, $request) {
        // Keep only necessary fields for headless
        return $response;
    }, 10, 3);
}
add_action('rest_api_init', 'cg_aesthetics_rest_api_optimization');

/**
 * Add sitemap customization
 */
function cg_aesthetics_customize_sitemap() {
    // Ensure Yoast includes custom post types
    add_filter('wpseo_sitemap_exclude_post_type', function($exclude, $post_type) {
        // Include our custom post types in sitemap
        if (in_array($post_type, ['spa_service', 'team_member', 'testimonial'])) {
            return false;
        }
        return $exclude;
    }, 10, 2);
}
add_action('init', 'cg_aesthetics_customize_sitemap');

/**
 * Remove unnecessary WordPress meta tags for headless
 */
function cg_aesthetics_remove_unnecessary_headers() {
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
}
add_action('init', 'cg_aesthetics_remove_unnecessary_headers');
