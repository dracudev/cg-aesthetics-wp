<?php
/**
 * Script to populate service benefits for all services
 * Run this file once to add benefits to all services
 */

// Load WordPress
require_once(__DIR__ . '/../../../wp-load.php');

// Define benefits for each service type
$service_benefits = [
    // Massage Services
    'Massage relaxant' => [
        'Réduit le stress et l\'anxiété',
        'Améliore la circulation sanguine',
        'Soulage les tensions musculaires',
        'Favorise un sommeil réparateur',
        'Procure une sensation de bien-être profond',
        'Renforce le système immunitaire',
    ],
    'Massage réducteur' => [
        'Réduit l\'apparence de la cellulite',
        'Améliore la circulation lymphatique',
        'Raffermit et tonifie la peau',
        'Favorise l\'élimination des toxines',
        'Améliore la silhouette',
        'Aide à la perte de centimètres',
    ],
    'Massage aux pierres chaudes' => [
        'Détente musculaire profonde',
        'Amélioration de la circulation',
        'Réduction du stress et de l\'anxiété',
        'Soulagement des douleurs chroniques',
        'Équilibre énergétique du corps',
        'Favorise la relaxation mentale',
    ],
    'Drainage lymphatique' => [
        'Réduit la rétention d\'eau',
        'Améliore le système immunitaire',
        'Favorise l\'élimination des toxines',
        'Réduit les gonflements et œdèmes',
        'Améliore la qualité de la peau',
        'Sensation de légèreté instantanée',
    ],
    
    // Facial Treatments
    'Microneedling' => [
        'Stimule la production de collagène',
        'Réduit les rides et ridules',
        'Améliore la texture de la peau',
        'Atténue les cicatrices d\'acné',
        'Raffermit et rajeunit le visage',
        'Réduit les pores dilatés',
    ],
    'BB Glow' => [
        'Unifie le teint instantanément',
        'Couvre les imperfections naturellement',
        'Hydrate et nourrit la peau',
        'Effet maquillage longue durée',
        'Stimule la régénération cellulaire',
        'Réduit l\'apparence des taches pigmentaires',
    ],
    'Hydrafacial' => [
        'Nettoyage en profondeur des pores',
        'Hydratation intense de la peau',
        'Éclat immédiat du teint',
        'Réduit les signes de vieillissement',
        'Améliore la texture cutanée',
        'Convient à tous les types de peau',
    ],
    'Nettoyage du visage simple' => [
        'Élimine les impuretés et points noirs',
        'Purifie la peau en profondeur',
        'Équilibre la production de sébum',
        'Prévient l\'apparition d\'imperfections',
        'Laisse la peau fraîche et éclatante',
        'Resserre les pores visiblement',
    ],
    
    // Body Treatments
    'Cavitation' => [
        'Réduit les amas graisseux localisés',
        'Affine la silhouette',
        'Améliore l\'aspect de la cellulite',
        'Résultats visibles dès les premières séances',
        'Traitement non invasif et indolore',
        'Alternative naturelle à la liposuccion',
    ],
    'Pressothérapie' => [
        'Améliore la circulation sanguine',
        'Réduit la cellulite et la rétention d\'eau',
        'Sensation de jambes légères',
        'Favorise la récupération musculaire',
        'Détente et bien-être immédiat',
        'Prévient les varices et jambes lourdes',
    ],
    'Radiofréquence' => [
        'Raffermit et tonifie la peau',
        'Réduit les rides et le relâchement cutané',
        'Stimule la production de collagène',
        'Améliore l\'élasticité de la peau',
        'Résultats progressifs et naturels',
        'Effet lifting sans chirurgie',
    ],
    'Exfoliation corporelle' => [
        'Élimine les cellules mortes',
        'Peau douce et lisse instantanément',
        'Améliore l\'absorption des soins',
        'Stimule la régénération cellulaire',
        'Prépare la peau au bronzage',
        'Unifie le teint du corps',
    ],
];

echo "Starting to populate service benefits...\n\n";

// Get all services
$args = [
    'post_type' => 'spa_service',
    'posts_per_page' => -1,
    'post_status' => 'publish',
];

$services = get_posts($args);

$updated_count = 0;
$skipped_count = 0;

foreach ($services as $service) {
    $service_title = $service->post_title;
    echo "Processing: {$service_title} (ID: {$service->ID})\n";
    
    // Check if benefits already exist
    $existing_benefits = get_field('service_benefits', $service->ID);
    
    if (!empty($existing_benefits) && is_array($existing_benefits)) {
        echo "  ℹ️  Has " . count($existing_benefits) . " benefits - will update to 6\n";
    }
    
    // Get benefits for this service
    if (isset($service_benefits[$service_title])) {
        $benefits = $service_benefits[$service_title];
        
        // Format benefits for ACF repeater
        $formatted_benefits = [];
        foreach ($benefits as $benefit) {
            $formatted_benefits[] = [
                'benefit_text' => $benefit,
            ];
        }
        
        // Update the field
        $result = update_field('service_benefits', $formatted_benefits, $service->ID);
        
        if ($result) {
            echo "  ✅ Added " . count($benefits) . " benefits\n";
            $updated_count++;
        } else {
            echo "  ❌ Failed to update\n";
        }
    } else {
        echo "  ⚠️  No benefits defined for this service\n";
    }
    
    echo "\n";
}

echo "\n=== Summary ===\n";
echo "Total services: " . count($services) . "\n";
echo "Updated: {$updated_count}\n";
echo "Skipped (already had benefits): {$skipped_count}\n";
echo "Not defined: " . (count($services) - $updated_count - $skipped_count) . "\n";
echo "\n✨ Done!\n";
