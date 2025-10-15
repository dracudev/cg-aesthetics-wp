<?php
/*
Template Name: Booking Page (Iframe Optimized)
Description: Minimal template for embedding booking forms in iframes
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?> <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        /* Hide ALL WordPress navigation and admin elements */
        #wpadminbar,
        .admin-bar,
        header,
        nav,
        .site-header,
        .main-navigation,
        .entry-header,
        .entry-title,
        .page-header,
        footer,
        .site-footer {
            display: none !important;
            visibility: hidden !important;
            height: 0 !important;
            overflow: hidden !important;
        }
        
        html {
            margin-top: 0 !important;
            padding: 0 !important;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: transparent !important;
            color: #333;
            padding: 0 !important;
            margin: 0 !important;
        }
        
        body.admin-bar {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }
        
        /* Ultra-minimal wrapper - just for the booking form */
        .booking-form-only {
            width: 100%;
            max-width: 100%;
            margin: 0;
            padding: 1rem;
            background: transparent;
        }
        
        /* Remove all extra spacing from Amelia */
        .amelia-booking-wrapper {
            padding: 0;
            margin: 0;
            background: transparent;
        }
        
        /* Ensure Amelia form takes full width and is centered */
        #amelia-container,
        .amelia-app-booking,
        .el-form {
            width: 100% !important;
            max-width: 800px !important;
            margin: 0 auto !important;
        }
        
        /* Responsive: reduce padding on mobile */
        @media (max-width: 768px) {
            .booking-form-only {
                padding: 0.5rem;
            }
        }
    </style>
</head>
<body <?php body_class('booking-iframe-body'); ?>>
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div class="booking-form-only">
            <div class="amelia-booking-wrapper">
                <?php the_content(); ?>
            </div>
        </div>
    <?php endwhile; endif; ?>
    <?php wp_footer(); ?>
    
    <script>
        // Aggressively remove WordPress admin and navigation elements
        document.addEventListener('DOMContentLoaded', function() {
            // Remove admin bar and any navigation elements
            const unwantedSelectors = [
                '#wpadminbar',
                'header',
                'nav',
                '.site-header',
                '.main-navigation',
                '.entry-header',
                '.entry-title',
                'footer',
                '.site-footer'
            ];
            
            unwantedSelectors.forEach(selector => {
                const elements = document.querySelectorAll(selector);
                elements.forEach(el => el.remove());
            });
            
            // Remove admin-bar class from body
            document.body.classList.remove('admin-bar');
            
            // Ensure body has no top margin
            document.body.style.marginTop = '0';
            document.body.style.paddingTop = '0';
            document.documentElement.style.marginTop = '0';
            
            // Send height to parent iframe for auto-resizing
            function sendHeight() {
                const height = document.body.scrollHeight;
                window.parent.postMessage({
                    type: 'ameliaHeight',
                    height: height
                }, '*');
            }
            
            // Send initial height
            setTimeout(sendHeight, 500);
            
            // Send height when Amelia loads/changes
            const observer = new MutationObserver(sendHeight);
            observer.observe(document.body, {
                childList: true,
                subtree: true,
                attributes: true
            });
            
            // Send height on window resize
            window.addEventListener('resize', sendHeight);
            
            // Check for height changes every 2 seconds (fallback)
            setInterval(sendHeight, 2000);
        });
    </script>
</body>
</html>
