<?php
/**
 * Options d'administration pour le thème
 */

// Menu principal des options
function mada_theme_options_menu() {
    add_menu_page(
        'Options du Thème',
        'Mada Digital',
        'manage_options',
        'mada-theme-options',
        'mada_contact_options_page',
        'dashicons-admin-generic',
        25
    );
    
    add_submenu_page(
        'mada-theme-options',
        'Informations de Contact',
        'Contact',
        'manage_options',
        'mada-theme-options',
        'mada_contact_options_page'
    );
    
    add_submenu_page(
        'mada-theme-options',
        'Options du Footer',
        'Footer',
        'manage_options',
        'mada-footer-options',
        'mada_footer_options_page'
    );
    
    add_submenu_page(
        'mada-theme-options',
        'Réseaux Sociaux',
        'Réseaux Sociaux',
        'manage_options',
        'mada-social-options',
        'mada_social_options_page'
    );
}
add_action('admin_menu', 'mada_theme_options_menu');

// Page des options de contact
function mada_contact_options_page() {
    if (isset($_POST['save_contact_info'])) {
        check_admin_referer('save_contact_info');
        
        // Sauvegarder les informations de contact
        update_option('contact_address', sanitize_text_field($_POST['contact_address']));
        update_option('contact_email', sanitize_email($_POST['contact_email']));
        update_option('contact_phone', sanitize_text_field($_POST['contact_phone']));
        update_option('contact_hours', sanitize_textarea_field($_POST['contact_hours']));
        
        // Traiter les coordonnées GPS
        $gps_input = sanitize_text_field($_POST['contact_gps']);
        $coordinates = mada_parse_gps_coordinates($gps_input);
        
        if ($coordinates !== false) {
            update_option('contact_latitude', $coordinates[0]);
            update_option('contact_longitude', $coordinates[1]);
            update_option('contact_gps_dms', $gps_input);
            echo '<div class="notice notice-success"><p>✅ Informations de contact mises à jour avec succès !</p></div>';
        } else {
            echo '<div class="notice notice-error"><p>❌ Format de coordonnées GPS non reconnu.</p></div>';
        }
        
        // Configuration SMTP
        update_option('smtp_enabled', isset($_POST['smtp_enabled']) ? 1 : 0);
        update_option('smtp_host', sanitize_text_field($_POST['smtp_host']));
        update_option('smtp_port', sanitize_text_field($_POST['smtp_port']));
        update_option('smtp_username', sanitize_text_field($_POST['smtp_username']));
        update_option('smtp_encryption', sanitize_text_field($_POST['smtp_encryption']));
        
        if (!empty($_POST['smtp_password'])) {
            update_option('smtp_password', $_POST['smtp_password']);
        }
    }
    
    $address = get_option('contact_address', 'P893+25J Antsiranana, Madagascar');
    $email = get_option('contact_email', get_option('admin_email'));
    $phone = get_option('contact_phone', '+261 XX XX XXX XX');
    $hours = get_option('contact_hours', 'Lundi - Vendredi: 8h00 - 17h00');
    $gps_dms = get_option('contact_gps_dms', '12°16\'56.7"S 49°18\'10.4"E');
    $latitude = get_option('contact_latitude', '-12.282417');
    $longitude = get_option('contact_longitude', '49.302889');
    
    $smtp_enabled = get_option('smtp_enabled', false);
    $smtp_host = get_option('smtp_host', '');
    $smtp_port = get_option('smtp_port', '587');
    $smtp_username = get_option('smtp_username', '');
    $smtp_encryption = get_option('smtp_encryption', 'tls');
    ?>
    <div class="wrap">
        <h1>📞 Informations de Contact</h1>
        
        <form method="post" style="max-width: 900px;">
            <?php wp_nonce_field('save_contact_info'); ?>
            
            <div style="background: #fff; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="margin-top: 0;">📍 Localisation</h2>
                
                <table class="form-table">
                    <tr>
                        <th><label for="contact_address">Adresse complète</label></th>
                        <td>
                            <input type="text" name="contact_address" id="contact_address" 
                                   value="<?php echo esc_attr($address); ?>" class="regular-text" style="width: 100%;">
                            <p class="description">L'adresse affichée sur la page contact</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="contact_gps">Coordonnées GPS</label></th>
                        <td>
                            <input type="text" name="contact_gps" id="contact_gps" 
                                   value="<?php echo esc_attr($gps_dms); ?>" class="regular-text" style="width: 100%;">
                            <p class="description">Formats acceptés: DMS (12°16'56.7"S 49°18'10.4"E) ou décimal (-12.282417, 49.302889)</p>
                            <div style="margin-top: 10px; padding: 10px; background: #f0f0f1; border-radius: 4px;">
                                <strong>Coordonnées décimales actuelles:</strong><br>
                                Latitude: <code><?php echo esc_html($latitude); ?></code><br>
                                Longitude: <code><?php echo esc_html($longitude); ?></code>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div style="background: #fff; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="margin-top: 0;">📧 Contact</h2>
                
                <table class="form-table">
                    <tr>
                        <th><label for="contact_email">Email de réception</label></th>
                        <td>
                            <input type="email" name="contact_email" id="contact_email" 
                                   value="<?php echo esc_attr($email); ?>" class="regular-text" style="width: 100%;">
                            <p class="description">Email où seront envoyés les messages du formulaire</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="contact_phone">Téléphone</label></th>
                        <td>
                            <input type="text" name="contact_phone" id="contact_phone" 
                                   value="<?php echo esc_attr($phone); ?>" class="regular-text" style="width: 100%;">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="contact_hours">Horaires</label></th>
                        <td>
                            <textarea name="contact_hours" id="contact_hours" rows="3" 
                                      class="large-text"><?php echo esc_textarea($hours); ?></textarea>
                        </td>
                    </tr>
                </table>
            </div>
            
            <div style="background: #fff; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <h2 style="margin-top: 0;">📮 Configuration SMTP (Optionnel)</h2>
                <p>Si l'envoi d'emails ne fonctionne pas avec la configuration par défaut, configurez un serveur SMTP.</p>
                
                <table class="form-table">
                    <tr>
                        <th><label for="smtp_enabled">Activer SMTP</label></th>
                        <td>
                            <input type="checkbox" name="smtp_enabled" id="smtp_enabled" 
                                   <?php checked($smtp_enabled, 1); ?>>
                            <label for="smtp_enabled">Utiliser la configuration SMTP ci-dessous</label>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="smtp_host">Serveur SMTP</label></th>
                        <td>
                            <input type="text" name="smtp_host" id="smtp_host" 
                                   value="<?php echo esc_attr($smtp_host); ?>" class="regular-text" 
                                   placeholder="smtp.gmail.com">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="smtp_port">Port</label></th>
                        <td>
                            <input type="text" name="smtp_port" id="smtp_port" 
                                   value="<?php echo esc_attr($smtp_port); ?>" class="small-text">
                            <p class="description">587 pour TLS, 465 pour SSL</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="smtp_encryption">Chiffrement</label></th>
                        <td>
                            <select name="smtp_encryption" id="smtp_encryption">
                                <option value="tls" <?php selected($smtp_encryption, 'tls'); ?>>TLS</option>
                                <option value="ssl" <?php selected($smtp_encryption, 'ssl'); ?>>SSL</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="smtp_username">Nom d'utilisateur</label></th>
                        <td>
                            <input type="text" name="smtp_username" id="smtp_username" 
                                   value="<?php echo esc_attr($smtp_username); ?>" class="regular-text">
                        </td>
                    </tr>
                    <tr>
                        <th><label for="smtp_password">Mot de passe</label></th>
                        <td>
                            <input type="password" name="smtp_password" id="smtp_password" 
                                   class="regular-text" placeholder="Laisser vide pour ne pas modifier">
                            <p class="description">Le mot de passe ne s'affiche pas pour des raisons de sécurité</p>
                        </td>
                    </tr>
                </table>
                
                <button type="button" id="test_email" class="button">📧 Tester l'envoi d'email</button>
                <span id="test_email_result" style="margin-left: 10px;"></span>
            </div>
            
            <?php submit_button('💾 Enregistrer', 'primary', 'save_contact_info', true, 
                              array('style' => 'font-size: 16px; height: auto; padding: 10px 30px;')); ?>
        </form>
        
        <div style="background: #fff; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); max-width: 900px;">
            <h2>📊 Messages reçus récemment</h2>
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'contact_messages';
            $messages = $wpdb->get_results("SELECT * FROM $table_name ORDER BY date_submitted DESC LIMIT 10");
            
            if ($messages): ?>
                <table class="wp-list-table widefat fixed striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Sujet</th>
                            <th>Extrait</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($messages as $msg): ?>
                            <tr>
                                <td><?php echo esc_html(date('d/m/Y H:i', strtotime($msg->date_submitted))); ?></td>
                                <td><?php echo esc_html($msg->name); ?></td>
                                <td><?php echo esc_html($msg->email); ?></td>
                                <td><?php echo esc_html($msg->subject); ?></td>
                                <td><?php echo esc_html(wp_trim_words($msg->message, 10)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucun message reçu pour le moment.</p>
            <?php endif; ?>
        </div>
    </div>
    
    <script>
    jQuery(document).ready(function($) {
        $('#test_email').on('click', function() {
            var button = $(this);
            var result = $('#test_email_result');
            
            button.prop('disabled', true);
            result.html('<span style="color: blue;">⏳ Envoi en cours...</span>');
            
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    action: 'test_email_config',
                    nonce: '<?php echo wp_create_nonce("test_email_nonce"); ?>'
                },
                success: function(response) {
                    if (response.success) {
                        result.html('<span style="color: green;">✅ ' + response.data + '</span>');
                    } else {
                        result.html('<span style="color: red;">❌ ' + response.data + '</span>');
                    }
                },
                error: function() {
                    result.html('<span style="color: red;">❌ Erreur de connexion</span>');
                },
                complete: function() {
                    button.prop('disabled', false);
                    setTimeout(function() { result.html(''); }, 5000);
                }
            });
        });
    });
    </script>
    <?php
}

// Page des options du footer
function mada_footer_options_page() {
    if (isset($_POST['save_footer_options'])) {
        check_admin_referer('save_footer_options');
        
        update_option('footer_description', sanitize_textarea_field($_POST['footer_description']));
        update_option('footer_copyright', sanitize_text_field($_POST['footer_copyright']));
        update_option('footer_show_newsletter', isset($_POST['footer_show_newsletter']) ? 1 : 0);
        
        echo '<div class="notice notice-success"><p>✅ Options du footer mises à jour !</p></div>';
    }
    
    $footer_description = get_option('footer_description', 'Votre partenaire digital à Madagascar depuis 2009.');
    $footer_copyright = get_option('footer_copyright', 'MADA-Digital. Tous droits réservés.');
    $footer_show_newsletter = get_option('footer_show_newsletter', 1);
    ?>
    <div class="wrap">
        <h1>🎨 Options du Footer</h1>
        
        <form method="post" style="max-width: 900px;">
            <?php wp_nonce_field('save_footer_options'); ?>
            
            <div style="background: #fff; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <table class="form-table">
                    <tr>
                        <th><label for="footer_description">Description</label></th>
                        <td>
                            <textarea name="footer_description" id="footer_description" rows="3" 
                                      class="large-text"><?php echo esc_textarea($footer_description); ?></textarea>
                            <p class="description">Texte affiché sous le logo dans le footer</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="footer_copyright">Copyright</label></th>
                        <td>
                            <input type="text" name="footer_copyright" id="footer_copyright" 
                                   value="<?php echo esc_attr($footer_copyright); ?>" class="regular-text" style="width: 100%;">
                            <p class="description">Texte de copyright (l'année sera ajoutée automatiquement)</p>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="footer_show_newsletter">Newsletter</label></th>
                        <td>
                            <input type="checkbox" name="footer_show_newsletter" id="footer_show_newsletter" 
                                   <?php checked($footer_show_newsletter, 1); ?>>
                            <label for="footer_show_newsletter">Afficher le formulaire de newsletter dans le footer</label>
                        </td>
                    </tr>
                </table>
            </div>
            
            <?php submit_button('💾 Enregistrer', 'primary', 'save_footer_options'); ?>
        </form>
    </div>
    <?php
}

// Page des réseaux sociaux
function mada_social_options_page() {
    if (isset($_POST['save_social_options'])) {
        check_admin_referer('save_social_options');
        
        $social_networks = array('facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'tiktok');
        
        foreach ($social_networks as $network) {
            $url = sanitize_text_field($_POST['social_' . $network]);
            update_option('social_' . $network, $url);
        }
        
        echo '<div class="notice notice-success"><p>✅ Réseaux sociaux mis à jour !</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>🌐 Réseaux Sociaux</h1>
        
        <form method="post" style="max-width: 900px;">
            <?php wp_nonce_field('save_social_options'); ?>
            
            <div style="background: #fff; padding: 20px; margin: 20px 0; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                <table class="form-table">
                    <?php
                    $networks = array(
                        'facebook' => array('icon' => 'fab fa-facebook-f', 'label' => 'Facebook'),
                        'twitter' => array('icon' => 'fab fa-twitter', 'label' => 'Twitter / X'),
                        'linkedin' => array('icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'),
                        'instagram' => array('icon' => 'fab fa-instagram', 'label' => 'Instagram'),
                        'youtube' => array('icon' => 'fab fa-youtube', 'label' => 'YouTube'),
                        'tiktok' => array('icon' => 'fab fa-tiktok', 'label' => 'TikTok')
                    );
                    
                    foreach ($networks as $key => $network):
                        $value = get_option('social_' . $key, '');
                    ?>
                        <tr>
                            <th>
                                <label for="social_<?php echo $key; ?>">
                                    <i class="<?php echo $network['icon']; ?>"></i> <?php echo $network['label']; ?>
                                </label>
                            </th>
                            <td>
                                <input type="url" name="social_<?php echo $key; ?>" id="social_<?php echo $key; ?>" 
                                       value="<?php echo esc_url($value); ?>" class="regular-text" style="width: 100%;" 
                                       placeholder="https://<?php echo $key; ?>.com/votre-page">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                
                <p class="description">Laissez vide pour ne pas afficher un réseau social. Les liens s'ouvriront dans un nouvel onglet.</p>
            </div>
            
            <?php submit_button('💾 Enregistrer', 'primary', 'save_social_options'); ?>
        </form>
    </div>
    <?php
}