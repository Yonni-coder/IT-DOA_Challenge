<?php
/**
 * Custom Fields pour le Custom Post Type Annonce
 * À placer dans : inc/annonce-custom-fields.php
 */

// Enregistrer le Custom Post Type "Annonce"
function create_annonce_post_type() {
    $labels = array(
        'name' => 'Annonces',
        'singular_name' => 'Annonce',
        'menu_name' => 'Annonces',
        'add_new' => 'Ajouter une annonce',
        'add_new_item' => 'Ajouter une nouvelle annonce',
        'edit_item' => 'Modifier l\'annonce',
        'new_item' => 'Nouvelle annonce',
        'view_item' => 'Voir l\'annonce',
        'search_items' => 'Rechercher des annonces',
        'not_found' => 'Aucune annonce trouvée',
        'not_found_in_trash' => 'Aucune annonce dans la corbeille',
    );

    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'annonce'),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-megaphone',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'show_in_rest' => true, // Active Gutenberg
    );

    register_post_type('annonce', $args);
}
add_action('init', 'create_annonce_post_type');

// Enregistrer les meta fields pour Gutenberg
function register_annonce_meta_fields() {
    // Date de début
    register_post_meta('annonce', '_annonce_date_debut', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Date de fin
    register_post_meta('annonce', '_annonce_date_fin', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Type d'annonce
    register_post_meta('annonce', '_annonce_type', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Lieu
    register_post_meta('annonce', '_annonce_lieu', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Contact
    register_post_meta('annonce', '_annonce_contact', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // Email
    register_post_meta('annonce', '_annonce_email', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_email',
    ));

    // Téléphone
    register_post_meta('annonce', '_annonce_telephone', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'sanitize_text_field',
    ));

    // URL externe
    register_post_meta('annonce', '_annonce_url', array(
        'type' => 'string',
        'single' => true,
        'show_in_rest' => true,
        'sanitize_callback' => 'esc_url_raw',
    ));
}
add_action('init', 'register_annonce_meta_fields');

// Ajouter les meta boxes pour l'interface d'administration
function add_annonce_meta_boxes() {
    add_meta_box(
        'annonce_details',
        'Détails de l\'annonce',
        'render_annonce_meta_box',
        'annonce',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'add_annonce_meta_boxes');

// Afficher le formulaire dans la meta box
function render_annonce_meta_box($post) {
    // Nonce pour la sécurité
    wp_nonce_field('save_annonce_meta', 'annonce_meta_nonce');

    // Récupérer les valeurs existantes
    $date_debut = get_post_meta($post->ID, '_annonce_date_debut', true);
    $date_fin = get_post_meta($post->ID, '_annonce_date_fin', true);
    $type = get_post_meta($post->ID, '_annonce_type', true);
    $lieu = get_post_meta($post->ID, '_annonce_lieu', true);
    $contact = get_post_meta($post->ID, '_annonce_contact', true);
    $email = get_post_meta($post->ID, '_annonce_email', true);
    $telephone = get_post_meta($post->ID, '_annonce_telephone', true);
    $url = get_post_meta($post->ID, '_annonce_url', true);
    ?>

    <style>
        .annonce-meta-field {
            margin-bottom: 20px;
            padding: 15px;
            background: #f9f9f9;
            border-left: 4px solid #2271b1;
            border-radius: 4px;
        }
        .annonce-meta-field label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #1d2327;
            font-size: 14px;
        }
        .annonce-meta-field input[type="text"],
        .annonce-meta-field input[type="date"],
        .annonce-meta-field input[type="email"],
        .annonce-meta-field input[type="tel"],
        .annonce-meta-field input[type="url"],
        .annonce-meta-field select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        .annonce-meta-field input:focus,
        .annonce-meta-field select:focus {
            border-color: #2271b1;
            outline: none;
            box-shadow: 0 0 0 1px #2271b1;
        }
        .annonce-meta-field small {
            display: block;
            margin-top: 5px;
            color: #666;
            font-style: italic;
        }
        .annonce-meta-required {
            color: #d63638;
        }
        .annonce-meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
    </style>

    <div class="annonce-meta-field">
        <label for="annonce_type">
            Type d'annonce <span class="annonce-meta-required">*</span>
        </label>
        <select name="annonce_type" id="annonce_type" required>
            <option value="">-- Sélectionner un type --</option>
            <option value="emploi" <?php selected($type, 'emploi'); ?>>💼 Offre d'emploi</option>
            <option value="stage" <?php selected($type, 'stage'); ?>>🎓 Stage</option>
            <option value="benevolat" <?php selected($type, 'benevolat'); ?>>🤝 Bénévolat</option>
            <option value="vente" <?php selected($type, 'vente'); ?>>🏷️ Vente</option>
            <option value="location" <?php selected($type, 'location'); ?>>🏠 Location</option>
            <option value="service" <?php selected($type, 'service'); ?>>🔧 Service</option>
            <option value="autre" <?php selected($type, 'autre'); ?>>📌 Autre</option>
        </select>
    </div>

    <div class="annonce-meta-grid">
        <div class="annonce-meta-field">
            <label for="annonce_date_debut">
                📅 Date de début
            </label>
            <input type="date" name="annonce_date_debut" id="annonce_date_debut" 
                   value="<?php echo esc_attr($date_debut); ?>">
            <small>Date de publication de l'annonce</small>
        </div>

        <div class="annonce-meta-field">
            <label for="annonce_date_fin">
                ⏰ Date de fin (expiration) <span class="annonce-meta-required">*</span>
            </label>
            <input type="date" name="annonce_date_fin" id="annonce_date_fin" 
                   value="<?php echo esc_attr($date_fin); ?>" required>
            <small>L'annonce sera archivée automatiquement après cette date</small>
        </div>
    </div>

    <div class="annonce-meta-field">
        <label for="annonce_lieu">
            📍 Lieu
        </label>
        <input type="text" name="annonce_lieu" id="annonce_lieu" 
               value="<?php echo esc_attr($lieu); ?>" 
               placeholder="Ex: Paris, France ou Antananarivo, Madagascar">
    </div>

    <div class="annonce-meta-field">
        <label for="annonce_contact">
            👤 Nom du contact
        </label>
        <input type="text" name="annonce_contact" id="annonce_contact" 
               value="<?php echo esc_attr($contact); ?>" 
               placeholder="Ex: Jean Dupont">
    </div>

    <div class="annonce-meta-grid">
        <div class="annonce-meta-field">
            <label for="annonce_email">
                📧 Email de contact
            </label>
            <input type="email" name="annonce_email" id="annonce_email" 
                   value="<?php echo esc_attr($email); ?>" 
                   placeholder="contact@exemple.com">
        </div>

        <div class="annonce-meta-field">
            <label for="annonce_telephone">
                📞 Téléphone
            </label>
            <input type="tel" name="annonce_telephone" id="annonce_telephone" 
                   value="<?php echo esc_attr($telephone); ?>" 
                   placeholder="+261 34 12 345 67">
        </div>
    </div>

    <div class="annonce-meta-field">
        <label for="annonce_url">
            🔗 URL externe (lien vers plus d'infos)
        </label>
        <input type="url" name="annonce_url" id="annonce_url" 
               value="<?php echo esc_attr($url); ?>" 
               placeholder="https://exemple.com/annonce">
        <small>Lien vers une page externe avec plus de détails</small>
    </div>

    <?php
}

// Sauvegarder les meta données
function save_annonce_meta($post_id) {
    // Vérifier le nonce
    if (!isset($_POST['annonce_meta_nonce']) || 
        !wp_verify_nonce($_POST['annonce_meta_nonce'], 'save_annonce_meta')) {
        return;
    }

    // Vérifier l'autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    // Vérifier les permissions
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sauvegarder chaque champ
    $fields = array(
        'annonce_date_debut' => '_annonce_date_debut',
        'annonce_date_fin' => '_annonce_date_fin',
        'annonce_type' => '_annonce_type',
        'annonce_lieu' => '_annonce_lieu',
        'annonce_contact' => '_annonce_contact',
        'annonce_email' => '_annonce_email',
        'annonce_telephone' => '_annonce_telephone',
        'annonce_url' => '_annonce_url',
    );

    foreach ($fields as $field_name => $meta_key) {
        if (isset($_POST[$field_name])) {
            $value = $_POST[$field_name];
            
            // Sanitizer selon le type de champ
            if ($field_name === 'annonce_email') {
                $value = sanitize_email($value);
            } elseif ($field_name === 'annonce_url') {
                $value = esc_url_raw($value);
            } else {
                $value = sanitize_text_field($value);
            }
            
            update_post_meta($post_id, $meta_key, $value);
        }
    }
}
add_action('save_post_annonce', 'save_annonce_meta');

// Ajouter des colonnes personnalisées dans la liste des annonces
function add_annonce_columns($columns) {
    $new_columns = array();
    
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        
        if ($key === 'title') {
            $new_columns['annonce_type'] = 'Type';
            $new_columns['annonce_lieu'] = 'Lieu';
            $new_columns['annonce_date_fin'] = 'Date de fin';
            $new_columns['annonce_status'] = 'Statut';
        }
    }
    
    return $new_columns;
}
add_filter('manage_annonce_posts_columns', 'add_annonce_columns');

// Afficher le contenu des colonnes personnalisées
function display_annonce_columns($column, $post_id) {
    switch ($column) {
        case 'annonce_type':
            $type = get_post_meta($post_id, '_annonce_type', true);
            $types = array(
                'emploi' => '💼 Emploi',
                'stage' => '🎓 Stage',
                'benevolat' => '🤝 Bénévolat',
                'vente' => '🏷️ Vente',
                'location' => '🏠 Location',
                'service' => '🔧 Service',
                'autre' => '📌 Autre'
            );
            echo isset($types[$type]) ? $types[$type] : '—';
            break;
            
        case 'annonce_lieu':
            $lieu = get_post_meta($post_id, '_annonce_lieu', true);
            echo $lieu ? '📍 ' . esc_html($lieu) : '—';
            break;
            
        case 'annonce_date_fin':
            $date_fin = get_post_meta($post_id, '_annonce_date_fin', true);
            if ($date_fin) {
                $timestamp = strtotime($date_fin);
                echo '📅 ' . wp_date('j F Y', $timestamp);
            } else {
                echo '—';
            }
            break;
            
        case 'annonce_status':
            $date_fin = get_post_meta($post_id, '_annonce_date_fin', true);
            $today = current_time('Y-m-d');
            
            if ($date_fin) {
                if ($date_fin >= $today) {
                    echo '<span style="color: #10b981; font-weight: bold;">✓ Active</span>';
                } else {
                    echo '<span style="color: #dc2626; font-weight: bold;">✗ Expirée</span>';
                }
            } else {
                echo '—';
            }
            break;
    }
}
add_action('manage_annonce_posts_custom_column', 'display_annonce_columns', 10, 2);

// Rendre les colonnes triables
function make_annonce_columns_sortable($columns) {
    $columns['annonce_type'] = 'annonce_type';
    $columns['annonce_date_fin'] = 'annonce_date_fin';
    return $columns;
}
add_filter('manage_edit-annonce_sortable_columns', 'make_annonce_columns_sortable');