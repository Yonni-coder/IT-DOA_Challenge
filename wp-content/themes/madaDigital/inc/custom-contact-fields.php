<?php 

/**
 * Ajouter les paramètres de contact au Customizer
 */
function contact_customizer_register($wp_customize) {
    
    // ==================== SECTION CONTACT ====================
    $wp_customize->add_section('contact_section', array(
        'title'       => __('Page Contact'),
        'priority'    => 40,
    ));
    
    // Adresse
    $wp_customize->add_setting('contact_address', array(
        'default'           => 'P893+25J Antsiranana, Madagascar',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_address', array(
        'label'       => __('Adresse'),
        'section'     => 'contact_section',
        'type'        => 'text',
    ));
    
    // Email
    $wp_customize->add_setting('contact_email', array(
        'default'           => 'contact@mada-digital.net',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('contact_email', array(
        'label'       => __('Email'),
        'section'     => 'contact_section',
        'type'        => 'email',
    ));
    
    // Téléphone
    $wp_customize->add_setting('contact_phone', array(
        'default'           => '+261 XX XX XXX XX',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_phone', array(
        'label'       => __('Téléphone'),
        'section'     => 'contact_section',
        'type'        => 'text',
    ));
    
    // Horaires
    $wp_customize->add_setting('contact_hours', array(
        'default'           => 'Lundi - Vendredi: 8h00 - 17h00',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_hours', array(
        'label'       => __('Horaires'),
        'section'     => 'contact_section',
        'type'        => 'text',
    ));
    
    // Latitude pour la carte
    $wp_customize->add_setting('contact_latitude', array(
        'default'           => '-12.2797',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_latitude', array(
        'label'       => __('Latitude'),
        'section'     => 'contact_section',
        'type'        => 'text',
        'description' => __('Latitude pour Google Maps (ex: -12.2797)'),
    ));
    
    // Longitude pour la carte
    $wp_customize->add_setting('contact_longitude', array(
        'default'           => '49.2919',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('contact_longitude', array(
        'label'       => __('Longitude'),
        'section'     => 'contact_section',
        'type'        => 'text',
        'description' => __('Longitude pour Google Maps (ex: 49.2919)'),
    ));
    
    // Clé API Google Maps
    $wp_customize->add_setting('google_maps_api_key', array(
        'default'           => '',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('google_maps_api_key', array(
        'label'       => __('Clé API Google Maps', 'votre-theme'),
        'section'     => 'contact_section',
        'type'        => 'text',
        'description' => __('Obtenez votre clé sur https://console.cloud.google.com'),
    ));
}
add_action('customize_register', 'contact_customizer_register');

function configure_smtp($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp.gmail.com'; // ou smtp de votre hébergeur
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 587;
    $phpmailer->Username   = 'tinognyyonni@gmail.com'; // Remplacez par votre email
    $phpmailer->Password   = 'ebjy uabn jhkg oimc'; // Mot de passe d'application Gmail
    $phpmailer->SMTPSecure = 'tls';
    $phpmailer->From       = 'tinognyyonni@gmail.com'; // Même email que Username
    $phpmailer->FromName   = 'MADA Digital';
}
add_action('phpmailer_init', 'configure_smtp');

/**
 * Traiter le formulaire de contact
 */
function handle_contact_form() {
    // Vérifier le nonce
    if (!isset($_POST['contact_nonce']) || !wp_verify_nonce($_POST['contact_nonce'], 'contact_form_submit')) {
        wp_send_json_error(['message' => 'Erreur de sécurité']);
    }
    
    // Récupérer et nettoyer les données
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    
    // Validation
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        wp_send_json_error(['message' => 'Tous les champs sont requis']);
    }
    
    if (!is_email($email)) {
        wp_send_json_error(['message' => 'Email invalide']);
    }
    
    // Préparer l'email à l'administrateur
    $admin_email = get_option('admin_email'); // ou 'votre-email@gmail.com'
    $email_subject = "[Contact Site] " . $subject;
    
    // Message en HTML
    $email_message = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: #0066cc; color: white; padding: 20px; text-align: center; }
            .content { background: #f9f9f9; padding: 20px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #555; }
            .value { color: #333; }
            .footer { text-align: center; padding: 20px; color: #777; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Nouveau message de contact</h2>
            </div>
            <div class='content'>
                <div class='field'>
                    <span class='label'>Nom:</span>
                    <div class='value'>" . esc_html($name) . "</div>
                </div>
                <div class='field'>
                    <span class='label'>Email:</span>
                    <div class='value'>" . esc_html($email) . "</div>
                </div>
                <div class='field'>
                    <span class='label'>Sujet:</span>
                    <div class='value'>" . esc_html($subject) . "</div>
                </div>
                <div class='field'>
                    <span class='label'>Message:</span>
                    <div class='value'>" . nl2br(esc_html($message)) . "</div>
                </div>
            </div>
            <div class='footer'>
                <p>Ce message a été envoyé depuis le formulaire de contact de " . get_bloginfo('name') . "</p>
                <p>Pour répondre, utilisez l'adresse: " . esc_html($email) . "</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    // Headers pour l'email admin
    $headers = array(
        'Content-Type: text/html; charset=UTF-8',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );
    
    // Envoyer l'email à l'admin
    $sent = wp_mail($admin_email, $email_subject, $email_message, $headers);
    
    // Envoyer un email de confirmation au client
    if ($sent) {
        $client_subject = "Confirmation de réception - " . $subject;
        $client_message = "
        <html>
        <head>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: #0066cc; color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>Merci pour votre message !</h2>
                </div>
                <div class='content'>
                    <p>Bonjour " . esc_html($name) . ",</p>
                    <p>Nous avons bien reçu votre message et nous vous remercions de nous avoir contactés.</p>
                    <p>Notre équipe reviendra vers vous dans les plus brefs délais.</p>
                    <p><strong>Récapitulatif de votre message:</strong></p>
                    <p><strong>Sujet:</strong> " . esc_html($subject) . "</p>
                    <p><strong>Message:</strong><br>" . nl2br(esc_html($message)) . "</p>
                    <hr>
                    <p>Cordialement,<br>L'équipe " . get_bloginfo('name') . "</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        $client_headers = array(
            'Content-Type: text/html; charset=UTF-8'
        );
        
        wp_mail($email, $client_subject, $client_message, $client_headers);
    }
    
    // Logger pour débogage (optionnel)
    if (!$sent) {
        error_log('Erreur envoi email contact - To: ' . $admin_email . ' - From: ' . $email);
    }
    
    if ($sent) {
        wp_send_json_success(['message' => 'Message envoyé avec succès! Un email de confirmation vous a été envoyé.']);
    } else {
        wp_send_json_error(['message' => 'Erreur lors de l\'envoi du message. Veuillez réessayer.']);
    }
}
add_action('wp_ajax_contact_form_submit', 'handle_contact_form');
add_action('wp_ajax_nopriv_contact_form_submit', 'handle_contact_form');

/**
 * Fonction de test d'email (À supprimer après test)
 */
function test_smtp_email() {
    if (isset($_GET['test_smtp']) && current_user_can('manage_options')) {
        $to = get_option('admin_email');
        $subject = 'Test SMTP WordPress';
        $message = '<h1>Email de test</h1><p>Si vous recevez cet email, la configuration SMTP fonctionne correctement!</p>';
        $headers = array('Content-Type: text/html; charset=UTF-8');
        
        $sent = wp_mail($to, $subject, $message, $headers);
        
        if ($sent) {
            wp_die('✅ Email envoyé avec succès à ' . $to . '<br><br><a href="' . admin_url() . '">Retour au tableau de bord</a>');
        } else {
            wp_die('❌ Échec de l\'envoi. Vérifiez votre configuration SMTP.<br><br><a href="' . admin_url() . '">Retour au tableau de bord</a>');
        }
    }
}
add_action('init', 'test_smtp_email');

?>