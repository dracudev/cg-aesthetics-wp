<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?> - Headless CMS</title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <div class="headless-notice">
        <h1>🚀 Beauty Studio Headless WordPress</h1>
        <p>This is a headless WordPress installation. Content is served via GraphQL API.</p>
        
        <h2>GraphQL Endpoint</h2>
        <p><strong>GraphQL IDE:</strong> <a href="<?php echo esc_url(home_url('/graphql')); ?>"><?php echo esc_url(home_url('/graphql')); ?></a></p>
        
        <h2>Admin Access</h2>
        <p><strong>WordPress Admin:</strong> <a href="<?php echo esc_url(admin_url()); ?>"><?php echo esc_url(admin_url()); ?></a></p>
        
        <h2>Content Types Available</h2>
        <ul>
            <li>Services (spa_service)</li>
            <li>Team Members (team_member)</li>
            <li>Testimonials (testimonial)</li>
            <li>Service Categories (taxonomy)</li>
        </ul>
        
        <h2>Frontend Application</h2>
        <p>The frontend is built with Astro and served separately.</p>
        <p>Refer to the <code>PROJECT_SCOPE.md</code> for complete documentation.</p>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
