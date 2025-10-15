<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?> - Administration</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 600px;
            background: white;
            padding: 3rem;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            text-align: center;
        }
        h1 {
            color: #667eea;
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }
        .subtitle {
            color: #666;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }
        .notice {
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 1rem;
            margin: 2rem 0;
            text-align: left;
            border-radius: 4px;
        }
        .notice strong {
            color: #667eea;
        }
        .buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }
        .btn {
            display: inline-block;
            padding: 1rem 2rem;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 1rem;
        }
        .btn-primary {
            background: #667eea;
            color: white;
        }
        .btn-primary:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }
        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }
        .btn-secondary:hover {
            background: #f0f4ff;
            transform: translateY(-2px);
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-top: 2rem;
            text-align: left;
        }
        .info-item {
            background: #f8f9fa;
            padding: 1rem;
            border-radius: 8px;
        }
        .info-item strong {
            display: block;
            color: #667eea;
            margin-bottom: 0.5rem;
        }
        .info-item span {
            color: #666;
            font-size: 0.9rem;
        }
        @media (max-width: 600px) {
            .info-grid {
                grid-template-columns: 1fr;
            }
            .container {
                margin: 1rem;
                padding: 2rem;
            }
        }
    </style>
    <?php wp_head(); ?>
</head>
<body>
    <div class="container">
        <h1>✨ <?php bloginfo('name'); ?></h1>
        <p class="subtitle">Système de gestion de contenu headless</p>
        
        <div class="notice">
            <strong>💡 Note importante :</strong><br>
            Ceci est la zone d'administration. Le site web public est accessible via le lien "Voir le site" ci-dessous.
        </div>

        <div class="buttons">
            <?php 
            $frontend_url = defined('FRONTEND_URL') ? FRONTEND_URL : 'http://localhost:4321';
            ?>
            <a href="<?php echo esc_url($frontend_url); ?>" class="btn btn-primary" target="_blank">
                🌐 Voir le site web →
            </a>
            <a href="<?php echo esc_url(admin_url()); ?>" class="btn btn-secondary">
                ⚙️ Accéder à l'administration
            </a>
        </div>

        <div class="info-grid">
            <div class="info-item">
                <strong>Services</strong>
                <span><?php 
                    $services_count = wp_count_posts('spa_service');
                    echo $services_count ? $services_count->publish : '0';
                ?> services publiés</span>
            </div>
            <div class="info-item">
                <strong>API GraphQL</strong>
                <span><a href="<?php echo esc_url(home_url('/graphql')); ?>" target="_blank">Accéder à l'API</a></span>
            </div>
            <div class="info-item">
                <strong>Membres d'équipe</strong>
                <span><?php 
                    $team_count = wp_count_posts('team_member');
                    echo $team_count ? $team_count->publish : '0';
                ?> membres</span>
            </div>
            <div class="info-item">
                <strong>Témoignages</strong>
                <span><?php 
                    $testimonials_count = wp_count_posts('testimonial');
                    echo $testimonials_count ? $testimonials_count->publish : '0';
                ?> témoignages</span>
            </div>
        </div>
    </div>
    <?php wp_footer(); ?>
</body>
</html>
