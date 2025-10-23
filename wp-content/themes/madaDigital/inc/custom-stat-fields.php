<?php

/**
 * Ajouter les paramètres des statistiques au Customizer
 */
function stats_customizer_register($wp_customize) {
    // Ajouter une section pour les statistiques
    $wp_customize->add_section('stats_section', array(
        'title'       => __('Statistiques', 'votre-theme'),
        'description' => __('Modifier les statistiques affichées sur la page d\'accueil', 'votre-theme'),
        'priority'    => 30,
    ));
    
    // Années d'expérience
    $wp_customize->add_setting('stat_experience', array(
        'default'           => '15',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('stat_experience', array(
        'label'       => __('Années d\'expérience', 'votre-theme'),
        'section'     => 'stats_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'step' => 1,
        ),
    ));
    
    // Projets réalisés
    $wp_customize->add_setting('stat_projets', array(
        'default'           => '200',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('stat_projets', array(
        'label'       => __('Projets réalisés', 'votre-theme'),
        'section'     => 'stats_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'step' => 1,
        ),
    ));
    
    // Clients satisfaits
    $wp_customize->add_setting('stat_clients', array(
        'default'           => '50',
        'sanitize_callback' => 'absint',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('stat_clients', array(
        'label'       => __('Clients satisfaits', 'votre-theme'),
        'section'     => 'stats_section',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'step' => 1,
        ),
    ));
    
    // Support disponible
    $wp_customize->add_setting('stat_support', array(
        'default'           => '24/7',
        'sanitize_callback' => 'sanitize_text_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('stat_support', array(
        'label'       => __('Support disponible', 'votre-theme'),
        'section'     => 'stats_section',
        'type'        => 'text',
        'description' => __('Ex: 24/7, Lun-Ven, etc.', 'votre-theme'),
    ));
}
add_action('customize_register', 'stats_customizer_register');