<?php 
    /**
 * Ajouter les paramètres du footer au Customizer
 */
function footer_customizer_register($wp_customize) {
    
    // ==================== SECTION PRINCIPALE ====================
    $wp_customize->add_section('footer_section', array(
        'title'       => __('Footer - Informations', 'votre-theme'),
        'priority'    => 35,
    ));
    
    // Description de l'entreprise
    $wp_customize->add_setting('footer_description', array(
        'default'           => 'Votre partenaire digital à Madagascar depuis 2009.',
        'sanitize_callback' => 'sanitize_textarea_field',
        'transport'         => 'refresh',
    ));
    
    $wp_customize->add_control('footer_description', array(
        'label'       => __('Description', 'votre-theme'),
        'section'     => 'footer_section',
        'type'        => 'textarea',
    ));
    
    // ==================== RÉSEAUX SOCIAUX ====================
    $wp_customize->add_section('footer_social_section', array(
        'title'       => __('Footer - Réseaux Sociaux', 'votre-theme'),
        'priority'    => 36,
    ));
    
    // Facebook
    $wp_customize->add_setting('footer_facebook', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('footer_facebook', array(
        'label'       => __('URL Facebook', 'votre-theme'),
        'section'     => 'footer_social_section',
        'type'        => 'url',
    ));
    
    // LinkedIn
    $wp_customize->add_setting('footer_linkedin', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('footer_linkedin', array(
        'label'       => __('URL LinkedIn', 'votre-theme'),
        'section'     => 'footer_social_section',
        'type'        => 'url',
    ));
    
    // Twitter
    $wp_customize->add_setting('footer_twitter', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('footer_twitter', array(
        'label'       => __('URL Twitter', 'votre-theme'),
        'section'     => 'footer_social_section',
        'type'        => 'url',
    ));
    
    // Instagram
    $wp_customize->add_setting('footer_instagram', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control('footer_instagram', array(
        'label'       => __('URL Instagram', 'votre-theme'),
        'section'     => 'footer_social_section',
        'type'        => 'url',
    ));
    
    // ==================== CONTACT ====================
    $wp_customize->add_section('footer_contact_section', array(
        'title'       => __('Footer - Contact', 'votre-theme'),
        'priority'    => 37,
    ));
    
    // Adresse
    $wp_customize->add_setting('footer_address', array(
        'default'           => 'P893+25J Antsiranana, Madagascar',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_address', array(
        'label'       => __('Adresse', 'votre-theme'),
        'section'     => 'footer_contact_section',
        'type'        => 'text',
    ));
    
    // Email
    $wp_customize->add_setting('footer_email', array(
        'default'           => 'contact@mada-digital.net',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('footer_email', array(
        'label'       => __('Email', 'votre-theme'),
        'section'     => 'footer_contact_section',
        'type'        => 'email',
    ));
    
    // Téléphone
    $wp_customize->add_setting('footer_phone', array(
        'default'           => '+261 XX XX XXX XX',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_phone', array(
        'label'       => __('Téléphone', 'votre-theme'),
        'section'     => 'footer_contact_section',
        'type'        => 'text',
    ));
    
    // ==================== NEWSLETTER ====================
    $wp_customize->add_section('footer_newsletter_section', array(
        'title'       => __('Footer - Newsletter', 'votre-theme'),
        'priority'    => 38,
    ));
    
    // Titre Newsletter
    $wp_customize->add_setting('footer_newsletter_title', array(
        'default'           => 'Newsletter',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_newsletter_title', array(
        'label'       => __('Titre Newsletter', 'votre-theme'),
        'section'     => 'footer_newsletter_section',
        'type'        => 'text',
    ));
    
    // Description Newsletter
    $wp_customize->add_setting('footer_newsletter_text', array(
        'default'           => 'Inscrivez-vous pour recevoir nos dernières actualités.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('footer_newsletter_text', array(
        'label'       => __('Description Newsletter', 'votre-theme'),
        'section'     => 'footer_newsletter_section',
        'type'        => 'textarea',
    ));
    
    // ==================== COPYRIGHT ====================
    $wp_customize->add_section('footer_copyright_section', array(
        'title'       => __('Footer - Copyright', 'votre-theme'),
        'priority'    => 39,
    ));
    
    // Texte Copyright
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => 'MADA-Digital. Tous droits réservés.',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_copyright', array(
        'label'       => __('Texte Copyright', 'votre-theme'),
        'section'     => 'footer_copyright_section',
        'type'        => 'text',
        'description' => __('L\'année est ajoutée automatiquement', 'votre-theme'),
    ));
}
add_action('customize_register', 'footer_customizer_register');
?>