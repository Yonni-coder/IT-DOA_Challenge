<?php
// Enregistrer les champs personnalisés pour Gutenberg (REST API)

// ============================================
// SERVICES
// ============================================

// Meta fields pour les services
function mdc_register_service_meta() {
    register_post_meta('service', '_service_icon', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'sanitize_callback' => 'wp_kses_post',
        'auth_callback' => function() {
            return current_user_can('edit_posts');
        }
    ]);
}
add_action('init', 'mdc_register_service_meta');

// Ajouter la metabox pour les services
function mdc_add_service_metabox() {
    add_meta_box(
        'mdc_service_meta',
        'Icône du service',
        'mdc_service_meta_callback',
        'service',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'mdc_add_service_metabox');

// Callback pour services
function mdc_service_meta_callback($post) {
    wp_nonce_field('mdc_save_service_meta', 'mdc_service_nonce');
    $icon = get_post_meta($post->ID, '_service_icon', true);
    
    // Liste d'icônes prédéfinies
    $icons = [
        'code' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>',
        'globe' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>',
        'shield' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>',
        'server' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01"/></svg>',
        'mobile' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>',
        'cloud' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>',
        'chart' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>',
        'camera' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>',
        'lock' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>',
        'lightning' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>',
        'desktop' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>',
        'database' => '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"/></svg>',
    ];
    ?>
    <style>
        .icon-selector {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 15px 0;
        }
        .icon-option {
            border: 2px solid #ddd;
            padding: 15px;
            cursor: pointer;
            text-align: center;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .icon-option:hover {
            border-color: #2271b1;
            background: #f0f6fc;
        }
        .icon-option.selected {
            border-color: #2271b1;
            background: #f0f6fc;
            box-shadow: 0 0 0 1px #2271b1;
        }
        .icon-option svg {
            width: 40px;
            height: 40px;
            stroke: #2271b1;
        }
        .icon-option-name {
            margin-top: 8px;
            font-size: 11px;
            color: #666;
            text-transform: capitalize;
        }
        .custom-icon-area {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
    </style>
    
    <p><strong>Choisissez une icône :</strong></p>
    <div class="icon-selector">
        <?php foreach ($icons as $key => $svg) : ?>
            <div class="icon-option <?php echo ($icon === $svg) ? 'selected' : ''; ?>" 
                 data-icon="<?php echo esc_attr($svg); ?>"
                 onclick="selectIcon(this)">
                <?php echo $svg; ?>
                <div class="icon-option-name"><?php echo $key; ?></div>
            </div>
        <?php endforeach; ?>
    </div>
    
    <input type="hidden" name="service_icon" id="service_icon_input" value="<?php echo esc_attr($icon); ?>">
    
    <div class="custom-icon-area">
        <details>
            <summary style="cursor: pointer; color: #2271b1; font-weight: 600;">💡 Ou utilisez un SVG personnalisé</summary>
            <p style="margin-top: 10px;">
                <textarea id="custom_icon_input" rows="5" style="width: 100%; font-family: monospace; font-size: 12px;" placeholder="Collez votre code SVG ici..."><?php echo esc_textarea($icon); ?></textarea>
                <button type="button" onclick="useCustomIcon()" class="button" style="margin-top: 10px;">Utiliser ce SVG</button>
            </p>
        </details>
    </div>
    
    <script>
        function selectIcon(element) {
            document.querySelectorAll('.icon-option').forEach(el => {
                el.classList.remove('selected');
            });
            
            element.classList.add('selected');
            
            const iconSvg = element.getAttribute('data-icon');
            document.getElementById('service_icon_input').value = iconSvg;
            document.getElementById('custom_icon_input').value = iconSvg;
        }
        
        function useCustomIcon() {
            const customSvg = document.getElementById('custom_icon_input').value;
            document.getElementById('service_icon_input').value = customSvg;
            
            document.querySelectorAll('.icon-option').forEach(el => {
                el.classList.remove('selected');
            });
            
            alert('Icône personnalisée enregistrée ! N\'oubliez pas de publier/mettre à jour.');
        }
    </script>
    <?php
}

// Sauvegarder l'icône des services
function mdc_save_service_meta($post_id) {
    // Vérifications de sécurité
    if (!isset($_POST['mdc_service_nonce']) || !wp_verify_nonce($_POST['mdc_service_nonce'], 'mdc_save_service_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    
    // Sauvegarder l'icône
    if (isset($_POST['service_icon'])) {
        update_post_meta($post_id, '_service_icon', wp_kses_post($_POST['service_icon']));
    }
}
add_action('save_post_service', 'mdc_save_service_meta');


// ============================================
// TÉMOIGNAGES
// ============================================

function mdc_register_testimonial_meta() {
    register_post_meta('testimonial', '_testimonial_poste', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    register_post_meta('testimonial', '_testimonial_entreprise', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
}
add_action('init', 'mdc_register_testimonial_meta');

function mdc_add_testimonial_metabox() {
    add_meta_box(
        'mdc_testimonial_meta',
        'Informations du client',
        'mdc_testimonial_meta_callback',
        'testimonial',
        'side',
        'default'
    );
}
add_action('add_meta_boxes', 'mdc_add_testimonial_metabox');

function mdc_testimonial_meta_callback($post) {
    wp_nonce_field('mdc_save_testimonial_meta', 'mdc_testimonial_nonce');
    $poste = get_post_meta($post->ID, '_testimonial_poste', true);
    $entreprise = get_post_meta($post->ID, '_testimonial_entreprise', true);
    ?>
    <p>
        <label><strong>Poste :</strong></label><br>
        <input type="text" name="testimonial_poste" value="<?php echo esc_attr($poste); ?>" style="width: 100%;" placeholder="Ex: Directeur">
    </p>
    <p>
        <label><strong>Entreprise :</strong></label><br>
        <input type="text" name="testimonial_entreprise" value="<?php echo esc_attr($entreprise); ?>" style="width: 100%;" placeholder="Ex: Entreprise XYZ">
    </p>
    <?php
}

function mdc_save_testimonial_meta($post_id) {
    if (!isset($_POST['mdc_testimonial_nonce']) || !wp_verify_nonce($_POST['mdc_testimonial_nonce'], 'mdc_save_testimonial_meta')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (isset($_POST['testimonial_poste'])) {
        update_post_meta($post_id, '_testimonial_poste', sanitize_text_field($_POST['testimonial_poste']));
    }
    if (isset($_POST['testimonial_entreprise'])) {
        update_post_meta($post_id, '_testimonial_entreprise', sanitize_text_field($_POST['testimonial_entreprise']));
    }
}
add_action('save_post_testimonial', 'mdc_save_testimonial_meta');

// ============================================
// ÉVÉNEMENTS
// ============================================

function mdc_register_event_meta() {
    register_post_meta('evenement', '_event_date', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    register_post_meta('evenement', '_event_time_start', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    
    register_post_meta('evenement', '_event_time_end', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field'
    ]);
    
    register_post_meta('evenement', '_event_lieu', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    register_post_meta('evenement', '_event_type', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    
    register_post_meta('evenement', '_event_gallery', [
        'show_in_rest' => true,
        'single' => true,
        'type' => 'string',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
}
add_action('init', 'mdc_register_event_meta');

function mdc_enqueue_event_admin_scripts($hook) {
    if ('post.php' === $hook || 'post-new.php' === $hook) {
        global $post;
        if ($post && 'evenement' === $post->post_type) {
            wp_enqueue_media();
            wp_enqueue_script(
                'mdc-event-gallery',
                get_template_directory_uri() . '/js/event-gallery.js',
                ['jquery'],
                filemtime(get_template_directory() . '/js/event-gallery.js'),
                true
            );
        }
    }
}
add_action('admin_enqueue_scripts', 'mdc_enqueue_event_admin_scripts');

function mdc_add_event_metabox() {
    add_meta_box(
        'mdc_event_meta',
        'Détails de l\'événement',
        'mdc_event_meta_callback',
        'evenement',
        'side',
        'default'
    );
    
    add_meta_box(
        'mdc_event_gallery',
        'Galerie de photos',
        'mdc_event_gallery_callback',
        'evenement',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'mdc_add_event_metabox');

function mdc_event_meta_callback($post) {
    wp_nonce_field('mdc_save_event_meta', 'mdc_event_nonce');
    $date = get_post_meta($post->ID, '_event_date', true);
    $time_start = get_post_meta($post->ID, '_event_time_start', true);
    $time_end = get_post_meta($post->ID, '_event_time_end', true);
    $lieu = get_post_meta($post->ID, '_event_lieu', true);
    $type = get_post_meta($post->ID, '_event_type', true);
    ?>
    <p>
        <label><strong>Type d'événement :</strong></label><br>
        <select name="event_type" style="width: 100%;">
            <option value="">Sélectionner un type</option>
            <option value="formation" <?php selected($type, 'formation'); ?>>Formation</option>
            <option value="conference" <?php selected($type, 'conference'); ?>>Conférence</option>
            <option value="atelier" <?php selected($type, 'atelier'); ?>>Atelier</option>
            <option value="seminaire" <?php selected($type, 'seminaire'); ?>>Séminaire</option>
            <option value="webinaire" <?php selected($type, 'webinaire'); ?>>Webinaire</option>
            <option value="networking" <?php selected($type, 'networking'); ?>>Networking</option>
        </select>
    </p>
    <p>
        <label><strong>Date :</strong></label><br>
        <input type="date" name="event_date" value="<?php echo esc_attr($date); ?>" style="width: 100%;">
    </p>
    <p>
        <label><strong>Heure de début :</strong></label><br>
        <input type="time" name="event_time_start" value="<?php echo esc_attr($time_start); ?>" style="width: 100%;">
    </p>
    <p>
        <label><strong>Heure de fin :</strong></label><br>
        <input type="time" name="event_time_end" value="<?php echo esc_attr($time_end); ?>" style="width: 100%;">
    </p>
    <p>
        <label><strong>Lieu :</strong></label><br>
        <input type="text" name="event_lieu" value="<?php echo esc_attr($lieu); ?>" style="width: 100%;" placeholder="Ex: Antananarivo">
    </p>
    <?php
}

function mdc_event_gallery_callback($post) {
    wp_nonce_field('mdc_save_event_gallery', 'mdc_event_gallery_nonce');
    $gallery_ids = get_post_meta($post->ID, '_event_gallery', true);
    $gallery_ids_array = !empty($gallery_ids) ? explode(',', $gallery_ids) : [];
    ?>
    <div class="event-gallery-container">
        <p style="color: #666; margin-bottom: 15px;">
            💡 <strong>Conseil :</strong> Ajoutez plusieurs photos pour créer une galerie. 
            Pour les événements passés, ces photos seront affichées dans une galerie interactive.
        </p>
        
        <div class="event-gallery-images" id="event-gallery-images">
            <?php if (!empty($gallery_ids_array)) : ?>
                <?php foreach ($gallery_ids_array as $image_id) : 
                    $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                    if ($image_url) :
                ?>
                    <div class="gallery-image-item" data-id="<?php echo esc_attr($image_id); ?>">
                        <img src="<?php echo esc_url($image_url); ?>" alt="">
                        <button type="button" class="remove-gallery-image" title="Supprimer">&times;</button>
                    </div>
                <?php 
                    endif;
                endforeach; ?>
            <?php endif; ?>
        </div>
        
        <p style="margin-top: 15px;">
            <button type="button" class="button button-primary" id="add-gallery-images">
                📷 Ajouter des images
            </button>
            <span style="margin-left: 10px; color: #666; font-size: 12px;">
                Images sélectionnées : <strong id="images-count"><?php echo count($gallery_ids_array); ?></strong>
            </span>
        </p>
        
        <input type="hidden" name="event_gallery" id="event-gallery-ids" value="<?php echo esc_attr($gallery_ids); ?>">
    </div>
    
    <style>
        .event-gallery-images {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            gap: 12px;
            margin-bottom: 15px;
            min-height: 50px;
            padding: 15px;
            background: #f9f9f9;
            border: 2px dashed #ddd;
            border-radius: 8px;
        }
        .event-gallery-images:empty::before {
            content: '📷 Aucune image ajoutée';
            color: #999;
            text-align: center;
            display: block;
            padding: 20px;
        }
        .gallery-image-item {
            position: relative;
            border: 3px solid #fff;
            border-radius: 8px;
            overflow: hidden;
            cursor: move;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .gallery-image-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }
        .gallery-image-item img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            display: block;
        }
        .remove-gallery-image {
            position: absolute;
            top: 5px;
            right: 5px;
            background: rgba(220, 38, 38, 0.9);
            color: white;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            cursor: pointer;
            font-size: 20px;
            line-height: 1;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }
        .remove-gallery-image:hover {
            background: rgba(220, 38, 38, 1);
            transform: scale(1.1);
        }
    </style>
    <?php
}

function mdc_save_event_meta($post_id) {
    if (isset($_POST['mdc_event_nonce']) && wp_verify_nonce($_POST['mdc_event_nonce'], 'mdc_save_event_meta')) {
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (isset($_POST['event_date'])) {
            update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date']));
        }
        if (isset($_POST['event_time_start'])) {
            update_post_meta($post_id, '_event_time_start', sanitize_text_field($_POST['event_time_start']));
        }
        if (isset($_POST['event_time_end'])) {
            update_post_meta($post_id, '_event_time_end', sanitize_text_field($_POST['event_time_end']));
        }
        if (isset($_POST['event_lieu'])) {
            update_post_meta($post_id, '_event_lieu', sanitize_text_field($_POST['event_lieu']));
        }
        if (isset($_POST['event_type'])) {
            update_post_meta($post_id, '_event_type', sanitize_text_field($_POST['event_type']));
        }
    }
    
    if (isset($_POST['mdc_event_gallery_nonce']) && wp_verify_nonce($_POST['mdc_event_gallery_nonce'], 'mdc_save_event_gallery')) {
        if (isset($_POST['event_gallery'])) {
            update_post_meta($post_id, '_event_gallery', sanitize_text_field($_POST['event_gallery']));
        }
    }
}
add_action('save_post_evenement', 'mdc_save_event_meta');
