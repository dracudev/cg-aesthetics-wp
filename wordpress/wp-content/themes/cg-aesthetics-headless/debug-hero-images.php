<?php
/**
 * Debug Script for Hero Images
 * 
 * Add this temporarily to functions.php or run it via wp-cli to debug
 * DO NOT leave this in production!
 */

// Add this as an admin notice to see what's happening
function cg_aesthetics_debug_hero_images() {
    if (!current_user_can('manage_options')) {
        return;
    }
    
    // Query for site_setting posts
    $args = array(
        'post_type' => 'site_setting',
        'posts_per_page' => 10,
        'post_status' => array('publish', 'draft', 'pending'),
    );
    $query = new WP_Query($args);
    
    echo '<div class="notice notice-info is-dismissible" style="padding: 20px; white-space: pre-wrap; font-family: monospace; background: #f0f0f1; border-left: 4px solid #2271b1;">';
    echo '<strong>Site Settings Debug Info:</strong><br><br>';
    
    if ($query->have_posts()) {
        echo "Found {$query->found_posts} Site Settings post(s):\n\n";
        
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            
            echo "Post ID: {$post_id}\n";
            echo "Title: " . get_the_title() . "\n";
            echo "Status: " . get_post_status() . "\n";
            echo "Date: " . get_the_date() . "\n\n";
            
            // Check for hero images
            $home_hero = get_field('home_hero_image', $post_id);
            $services_hero = get_field('services_hero_image', $post_id);
            $about_hero = get_field('about_hero_image', $post_id);
            $contact_hero = get_field('contact_hero_image', $post_id);
            $founder = get_field('founder_image', $post_id);
            
            echo "Hero Images:\n";
            echo "  - Homepage: " . ($home_hero ? '✓ Uploaded (' . $home_hero['url'] . ')' : '✗ Empty') . "\n";
            
            if ($home_hero) {
                echo "\nHomepage Hero RAW DATA:\n";
                echo "Type: " . gettype($home_hero) . "\n";
                if (is_array($home_hero)) {
                    echo "Keys: " . implode(', ', array_keys($home_hero)) . "\n";
                    echo "ID: " . (isset($home_hero['ID']) ? $home_hero['ID'] : 'NOT SET') . "\n";
                    echo "id: " . (isset($home_hero['id']) ? $home_hero['id'] : 'NOT SET') . "\n";
                }
                print_r($home_hero);
            }
            
            echo "\n  - Services: " . ($services_hero ? '✓ Uploaded (' . $services_hero['url'] . ')' : '✗ Empty') . "\n";
            echo "  - About: " . ($about_hero ? '✓ Uploaded (' . $about_hero['url'] . ')' : '✗ Empty') . "\n";
            echo "  - Contact: " . ($contact_hero ? '✓ Uploaded (' . $contact_hero['url'] . ')' : '✗ Empty') . "\n";
            echo "  - Founder: " . ($founder ? '✓ Uploaded (' . $founder['url'] . ')' : '✗ Empty') . "\n";
            echo "\n" . str_repeat('-', 80) . "\n\n";
        }
        wp_reset_postdata();
    } else {
        echo "❌ No Site Settings posts found!\n\n";
        echo "INSTRUCTIONS:\n";
        echo "1. Go to WordPress Admin\n";
        echo "2. Click 'Site Settings' in the left sidebar\n";
        echo "3. Click 'Add New'\n";
        echo "4. Give it a title like 'Hero Images'\n";
        echo "5. Upload at least one image\n";
        echo "6. Click 'Publish' (not Save Draft!)\n";
    }
    
    // Test GraphQL query
    echo "\n" . str_repeat('=', 80) . "\n\n";
    echo "Testing GraphQL Query:\n\n";
    
    if (function_exists('graphql')) {
        $graphql_query = '
            query GetHeroImages {
                siteHeroImages {
                    heroImages {
                        homeHeroImage {
                            sourceUrl
                        }
                    }
                }
            }
        ';
        
        $result = graphql(array('query' => $graphql_query));
        
        if (isset($result['errors'])) {
            echo "GraphQL Errors:\n";
            print_r($result['errors']);
        } else {
            echo "GraphQL Response:\n";
            print_r($result['data']);
        }
    } else {
        echo "GraphQL not available\n";
    }
    
    echo '</div>';
}
add_action('admin_notices', 'cg_aesthetics_debug_hero_images');
