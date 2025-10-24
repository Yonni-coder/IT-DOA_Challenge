<?php
/**
 * Fonctions pour la gestion du formulaire de contact
 */

// Créer la table pour stocker les messages
function mada_create_contact_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_messages';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        subject varchar(255) NOT NULL,
        message text NOT NULL,
        ip_address varchar(100) DEFAULT NULL,
        date_submitted datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        status varchar(20) DEFAULT 'unread',
        PRIMARY KEY (id),
        KEY status (status),
        KEY date_submitted (date_submitted)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'mada_create_contact_table');

// Conversion DMS vers décimal
function mada_dms_to_decimal($degrees, $minutes, $seconds, $direction) {
    $decimal = $degrees + ($minutes / 60) + ($seconds / 3600);
    if ($direction == 'S' || $direction == 'W') {
        $decimal = $decimal * -1;
    }
    return $decimal;
}

// Parser les coordonnées GPS
function mada_parse_gps_coordinates($gps_input) {
    $gps_input = trim($gps_input);
    
    // Format DMS: 12°16'56.7"S 49°18'10.4"E
    if (preg_match('/(\d+)°\s*(\d+)\'\s*([\d.]+)"\s*([NS])\s+(\d+)°\s*(\d+)\'\s*([\d.]+)"\s*([EW])/i', $gps_input, $matches)) {
        $latitude = mada_dms_to_decimal(
            intval($matches[1]), 
            intval($matches[2]), 
            floatval($matches[3]), 
            strtoupper($matches[4])
        );
        $longitude = mada_dms_to_decimal(
            intval($matches[5]), 
            intval($matches[6]), 
            floatval($matches[7]), 
            strtoupper($matches[8])
        );
        return array($latitude, $longitude);
    }
    
    // Format décimal avec virgule: -18.91308049165631, 47.54225654900117
    if (preg_match('/^\s*(-?\d+\.?\d*)\s*,\s*(-?\d+\.?\d*)\s*$/', $gps_input, $matches)) {
        return array(floatval($matches[1]), floatval($matches[2]));
    }
    
    // Format décimal avec espace
    $coords = preg_split('/\s+/', trim($gps_input));
    if (count($coords) == 2 && is_numeric($coords[0]) && is_numeric($coords[1])) {
        return array(floatval($coords[0]), floatval($coords[1]));
    }
    
    // Format avec point-virgule
    if (strpos($gps_input, ';') !== false) {
        $coords = explode(';', $gps_input);
        if (count($coords) == 2 && is_numeric(trim($coords[0])) && is_numeric(trim($coords[1]))) {
            return array(floatval(trim($coords[0])), floatval(trim($coords[1])));
        }
    }
    
    return false;
}

// Récupérer les coordonnées GPS
function get_contact_coordinates() {
    $latitude = get_option('contact_latitude', '-12.282417');
    $longitude = get_option('contact_longitude', '49.302889');
    
    return array(
        'lat' => floatval($latitude),
        'lng' => floatval($longitude),
        'address' => get_option('contact_address', 'P893+25J Antsiranana, Madagascar'),
        'dms' => get_option('contact_gps_dms', '12°16\'56.7"S 49°18\'10.4"E')
    );
}

// Traiter le formulaire de contact
function mada_process_contact_form() {
    // Vérification de sécurité
    if (!isset($_POST['contact_form_nonce']) || !wp_verify_nonce($_POST['contact_form_nonce'], 'contact_form_action')) {
        wp_redirect(add_query_arg('contact', 'security_error', wp_get_referer()));
        exit;
    }

    // Vérifier les champs requis
    $required_fields = ['name', 'email', 'subject', 'message'];
    foreach ($required_fields as $field) {
        if (empty($_POST[$field])) {
            wp_redirect(add_query_arg('contact', 'missing_fields', wp_get_referer()));
            exit;
        }
    }

    // Récupérer et valider les données
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $subject = sanitize_text_field($_POST['subject']);
    $message = sanitize_textarea_field($_POST['message']);
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

    // Validation email
    if (!is_email($email)) {
        wp_redirect(add_query_arg('contact', 'invalid_email', wp_get_referer()));
        exit;
    }

    // Sauvegarder dans la base de données
    global $wpdb;
    $table_name = $wpdb->prefix . 'contact_messages';
    
    $db_saved = $wpdb->insert(
        $table_name,
        array(
            'name' => $name,
            'email' => $email,
            'subject' => $subject,
            'message' => $message,
            'ip_address' => $ip_address,
            'date_submitted' => current_time('mysql'),
            'status' => 'unread'
        ),
        array('%s', '%s', '%s', '%s', '%s', '%s', '%s')
    );

    // Préparer l'email
    $to = get_option('contact_email', get_option('admin_email'));
    $email_subject = sprintf('[%s] Nouveau message: %s', get_bloginfo('name'), $subject);
    
    $email_body = sprintf(
        "Nouveau message reçu depuis le formulaire de contact\n\n" .
        "Nom: %s\n" .
        "Email: %s\n" .
        "Sujet: %s\n\n" .
        "Message:\n%s\n\n" .
        "---\n" .
        "Envoyé depuis: %s\n" .
        "IP: %s\n" .
        "Date: %s",
        $name,
        $email,
        $subject,
        $message,
        get_site_url(),
        $ip_address,
        current_time('d/m/Y H:i:s')
    );
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>',
        'Reply-To: ' . $name . ' <' . $email . '>'
    );

    // Logger pour débogage
    error_log(sprintf(
        'Contact form submission - To: %s, From: %s (%s)',
        $to,
        $name,
        $email
    ));

    // Envoyer l'email
    $sent = wp_mail($to, $email_subject, $email_body, $headers);
    
    if ($sent) {
        error_log('Contact form email sent successfully');
        
        // Envoyer un email de confirmation au visiteur
        $confirmation_subject = 'Confirmation de réception de votre message';
        $confirmation_body = sprintf(
            "Bonjour %s,\n\n" .
            "Nous avons bien reçu votre message et nous vous remercions de nous avoir contactés.\n" .
            "Notre équipe vous répondra dans les plus brefs délais.\n\n" .
            "Récapitulatif de votre message:\n" .
            "Sujet: %s\n" .
            "Message: %s\n\n" .
            "Cordialement,\n" .
            "L'équipe %s",
            $name,
            $subject,
            $message,
            get_bloginfo('name')
        );
        
        wp_mail($email, $confirmation_subject, $confirmation_body, $headers);
        
        wp_redirect(add_query_arg('contact', 'success', wp_get_referer()));
    } else {
        error_log('Contact form email failed to send');
        // Même si l'email échoue, le message est sauvegardé en BDD
        wp_redirect(add_query_arg('contact', $db_saved ? 'partial_success' : 'error', wp_get_referer()));
    }
    
    exit;
}
add_action('admin_post_nopriv_submit_contact_form', 'mada_process_contact_form');
add_action('admin_post_submit_contact_form', 'mada_process_contact_form');

// Configuration SMTP
function mada_configure_smtp($phpmailer) {
    $smtp_enabled = get_option('smtp_enabled', false);
    
    if (!$smtp_enabled) {
        return;
    }
    
    $smtp_host = get_option('smtp_host', '');
    $smtp_port = get_option('smtp_port', '587');
    $smtp_username = get_option('smtp_username', '');
    $smtp_password = get_option('smtp_password', '');
    $smtp_encryption = get_option('smtp_encryption', 'tls');
    
    if (!empty($smtp_host) && !empty($smtp_username)) {
        $phpmailer->isSMTP();
        $phpmailer->Host = $smtp_host;
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = intval($smtp_port);
        $phpmailer->Username = $smtp_username;
        $phpmailer->Password = $smtp_password;
        $phpmailer->SMTPSecure = $smtp_encryption;
        $phpmailer->From = $smtp_username;
        $phpmailer->FromName = get_bloginfo('name');
        
        // Options SSL (à utiliser avec prudence en production)
        $phpmailer->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        // Activer le débogage (à désactiver en production)
        if (defined('WP_DEBUG') && WP_DEBUG) {
            $phpmailer->SMTPDebug = 2;
            $phpmailer->Debugoutput = function($str, $level) {
                error_log("SMTP Debug level $level: $str");
            };
        }
    }
}
add_action('phpmailer_init', 'mada_configure_smtp');

// Test de configuration email
function mada_test_email_config() {
    check_ajax_referer('test_email_nonce', 'nonce');
    
    if (!current_user_can('manage_options')) {
        wp_send_json_error('Permission refusée');
    }
    
    $to = get_option('contact_email', get_option('admin_email'));
    $subject = 'Test de configuration email - ' . get_bloginfo('name');
    $message = sprintf(
        "Ceci est un email de test pour vérifier la configuration.\n\n" .
        "Site: %s\n" .
        "URL: %s\n" .
        "Date: %s\n\n" .
        "Si vous recevez cet email, la configuration fonctionne correctement.",
        get_bloginfo('name'),
        get_site_url(),
        current_time('d/m/Y H:i:s')
    );
    
    $headers = array(
        'Content-Type: text/plain; charset=UTF-8',
        'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
    );
    
    $sent = wp_mail($to, $subject, $message, $headers);
    
    if ($sent) {
        wp_send_json_success('Email de test envoyé avec succès à ' . $to);
    } else {
        wp_send_json_error('Échec de l\'envoi de l\'email de test. Vérifiez les logs du serveur.');
    }
}
add_action('wp_ajax_test_email_config', 'mada_test_email_config');