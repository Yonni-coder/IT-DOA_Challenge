<?php
/**
 * Fonctions pour la gestion de la newsletter
 */

// Créer la table pour les abonnés à la newsletter
function mada_create_newsletter_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        email varchar(255) NOT NULL UNIQUE,
        status varchar(20) DEFAULT 'active',
        ip_address varchar(100) DEFAULT NULL,
        date_subscribed datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        date_unsubscribed datetime DEFAULT NULL,
        token varchar(64) NOT NULL UNIQUE,
        PRIMARY KEY (id),
        KEY email (email),
        KEY status (status),
        KEY token (token)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_switch_theme', 'mada_create_newsletter_table');

// Générer un token unique
function mada_generate_newsletter_token() {
    return bin2hex(random_bytes(32));
}

// Traiter l'inscription à la newsletter
function mada_process_newsletter_subscription() {
    // Vérification de sécurité
    if (!isset($_POST['newsletter_nonce']) || !wp_verify_nonce($_POST['newsletter_nonce'], 'newsletter_action')) {
        wp_send_json_error('Erreur de sécurité');
    }

    // Vérifier l'email
    if (empty($_POST['email'])) {
        wp_send_json_error('Veuillez entrer une adresse email');
    }

    $email = sanitize_email($_POST['email']);
    
    if (!is_email($email)) {
        wp_send_json_error('Adresse email invalide');
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';

    // Vérifier si l'email existe déjà
    $existing = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE email = %s",
        $email
    ));

    if ($existing) {
        if ($existing->status === 'active') {
            wp_send_json_error('Cette adresse email est déjà inscrite à la newsletter');
        } else {
            // Réactiver l'abonnement
            $wpdb->update(
                $table_name,
                array(
                    'status' => 'active',
                    'date_subscribed' => current_time('mysql'),
                    'date_unsubscribed' => null
                ),
                array('email' => $email),
                array('%s', '%s', '%s'),
                array('%s')
            );
            wp_send_json_success('Votre abonnement a été réactivé avec succès !');
        }
    }

    // Générer un token pour le désabonnement
    $token = mada_generate_newsletter_token();

    // Insérer le nouvel abonné
    $inserted = $wpdb->insert(
        $table_name,
        array(
            'email' => $email,
            'status' => 'active',
            'ip_address' => $ip_address,
            'date_subscribed' => current_time('mysql'),
            'token' => $token
        ),
        array('%s', '%s', '%s', '%s', '%s')
    );

    if ($inserted) {
        // Envoyer un email de confirmation
        $subject = 'Confirmation d\'inscription à la newsletter';
        $unsubscribe_link = add_query_arg(
            array('action' => 'unsubscribe', 'token' => $token),
            home_url('/newsletter')
        );
        
        $message = sprintf(
            "Bonjour,\n\n" .
            "Merci de vous être inscrit(e) à notre newsletter !\n\n" .
            "Vous recevrez désormais nos dernières actualités et offres.\n\n" .
            "Si vous souhaitez vous désabonner, cliquez sur ce lien :\n%s\n\n" .
            "Cordialement,\n" .
            "L'équipe %s",
            $unsubscribe_link,
            get_bloginfo('name')
        );
        
        $headers = array(
            'Content-Type: text/plain; charset=UTF-8',
            'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>'
        );
        
        wp_mail($email, $subject, $message, $headers);
        
        // Notifier l'admin
        $admin_email = get_option('admin_email');
        $admin_subject = 'Nouvel abonné à la newsletter';
        $admin_message = sprintf(
            "Nouvel abonné à la newsletter:\n\n" .
            "Email: %s\n" .
            "Date: %s\n" .
            "IP: %s",
            $email,
            current_time('d/m/Y H:i:s'),
            $ip_address
        );
        
        wp_mail($admin_email, $admin_subject, $admin_message, $headers);
        
        wp_send_json_success('Merci ! Vous êtes maintenant inscrit(e) à notre newsletter.');
    } else {
        error_log('Failed to insert newsletter subscriber: ' . $wpdb->last_error);
        wp_send_json_error('Une erreur est survenue. Veuillez réessayer.');
    }
}
add_action('wp_ajax_nopriv_newsletter_subscribe', 'mada_process_newsletter_subscription');
add_action('wp_ajax_newsletter_subscribe', 'mada_process_newsletter_subscription');

// Traiter le désabonnement
function mada_process_newsletter_unsubscribe() {
    if (!isset($_GET['action']) || $_GET['action'] !== 'unsubscribe' || !isset($_GET['token'])) {
        return;
    }

    $token = sanitize_text_field($_GET['token']);
    
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    
    $subscriber = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM $table_name WHERE token = %s",
        $token
    ));
    
    if ($subscriber && $subscriber->status === 'active') {
        $wpdb->update(
            $table_name,
            array(
                'status' => 'unsubscribed',
                'date_unsubscribed' => current_time('mysql')
            ),
            array('token' => $token),
            array('%s', '%s'),
            array('%s')
        );
        
        wp_redirect(add_query_arg('newsletter', 'unsubscribed', home_url()));
        exit;
    }
    
    wp_redirect(add_query_arg('newsletter', 'invalid_token', home_url()));
    exit;
}
add_action('template_redirect', 'mada_process_newsletter_unsubscribe');

// Ajouter un menu pour gérer les abonnés
function mada_newsletter_admin_menu() {
    add_menu_page(
        'Newsletter',
        'Newsletter',
        'manage_options',
        'mada-newsletter',
        'mada_newsletter_admin_page',
        'dashicons-email-alt',
        30
    );
}
add_action('admin_menu', 'mada_newsletter_admin_menu');

// Page d'administration de la newsletter
function mada_newsletter_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    
    // Traiter l'export CSV
    if (isset($_GET['export']) && $_GET['export'] === 'csv') {
        check_admin_referer('export_newsletter');
        
        $subscribers = $wpdb->get_results("SELECT email, date_subscribed, status FROM $table_name ORDER BY date_subscribed DESC");
        
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=newsletter_subscribers_' . date('Y-m-d') . '.csv');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, array('Email', 'Date d\'inscription', 'Statut'));
        
        foreach ($subscribers as $sub) {
            fputcsv($output, array($sub->email, $sub->date_subscribed, $sub->status));
        }
        
        fclose($output);
        exit;
    }
    
    // Statistiques
    $total_subscribers = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'active'");
    $total_unsubscribed = $wpdb->get_var("SELECT COUNT(*) FROM $table_name WHERE status = 'unsubscribed'");
    $recent_subscribers = $wpdb->get_results(
        "SELECT * FROM $table_name ORDER BY date_subscribed DESC LIMIT 20"
    );
    
    ?>
    <div class="wrap">
        <h1>📧 Gestion de la Newsletter</h1>
        
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin: 20px 0;">
            <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px 0; color: #2271b1;">Abonnés actifs</h3>
                <p style="font-size: 32px; font-weight: bold; margin: 0;"><?php echo number_format($total_subscribers); ?></p>
            </div>
            
            <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px 0; color: #d63638;">Désabonnés</h3>
                <p style="font-size: 32px; font-weight: bold; margin: 0;"><?php echo number_format($total_unsubscribed); ?></p>
            </div>
            
            <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h3 style="margin: 0 0 10px 0; color: #00a32a;">Total</h3>
                <p style="font-size: 32px; font-weight: bold; margin: 0;"><?php echo number_format($total_subscribers + $total_unsubscribed); ?></p>
            </div>
        </div>
        
        <div style="margin: 20px 0;">
            <a href="<?php echo wp_nonce_url(add_query_arg('export', 'csv'), 'export_newsletter'); ?>" class="button button-primary">
                Exporter en CSV
            </a>
        </div>
        
        <h2>Abonnés récents</h2>
        <table class="wp-list-table widefat fixed striped">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Date d'inscription</th>
                    <th>Statut</th>
                    <th>IP</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($recent_subscribers): ?>
                    <?php foreach ($recent_subscribers as $sub): ?>
                        <tr>
                            <td><?php echo esc_html($sub->email); ?></td>
                            <td><?php echo esc_html($sub->date_subscribed); ?></td>
                            <td>
                                <span style="padding: 3px 8px; border-radius: 3px; font-size: 12px; 
                                    background: <?php echo $sub->status === 'active' ? '#00a32a' : '#d63638'; ?>; 
                                    color: white;">
                                    <?php echo $sub->status === 'active' ? 'Actif' : 'Désabonné'; ?>
                                </span>
                            </td>
                            <td><?php echo esc_html($sub->ip_address); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">Aucun abonné pour le moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}