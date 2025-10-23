<?php

function mdc_testimonial_meta_boxes() {
    add_meta_box(
        'testimonial_details',
        'Détails du témoignage',
        'mdc_testimonial_meta_box_callback',
        'testimonial',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'mdc_testimonial_meta_boxes');

function mdc_testimonial_meta_box_callback($post) {
    wp_nonce_field('mdc_save_testimonial', 'mdc_testimonial_nonce');
    
    $poste = get_post_meta($post->ID, '_testimonial_poste', true);
    $entreprise = get_post_meta($post->ID, '_testimonial_entreprise', true);
    ?>
    <p>
        <label><strong>Poste :</strong></label><br>
        <input type="text" name="testimonial_poste" value="<?php echo esc_attr($poste); ?>" style="width: 100%;">
    </p>
    <p>
        <label><strong>Entreprise :</strong></label><br>
        <input type="text" name="testimonial_entreprise" value="<?php echo esc_attr($entreprise); ?>" style="width: 100%;">
    </p>
    <?php
}

function mdc_save_testimonial_meta($post_id) {
    if (!isset($_POST['mdc_testimonial_nonce']) || !wp_verify_nonce($_POST['mdc_testimonial_nonce'], 'mdc_save_testimonial')) {
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

function mdc_service_meta_boxes() {
    add_meta_box(
        'service_details',
        'Icône du service',
        'mdc_service_meta_box_callback',
        'services',
        'normal',
        'high'
    );
}
add_action('add_meta_boxes', 'mdc_service_meta_boxes');

function mdc_service_meta_box_callback($post) {
    wp_nonce_field('mdc_save_service', 'mdc_service_nonce');
    
    $icon = get_post_meta($post->ID, '_service_icon', true);
    ?>
    <p>
        <label><strong>Code SVG de l'icône :</strong></label><br>
        <textarea name="service_icon" rows="5" style="width: 100%;"><?php echo esc_textarea($icon); ?></textarea>
        <small>Collez le code SVG complet ici</small>
    </p>
    <?php
}

function mdc_save_service_meta($post_id) {
    if (!isset($_POST['mdc_service_nonce']) || !wp_verify_nonce($_POST['mdc_service_nonce'], 'mdc_save_service')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (isset($_POST['service_icon'])) {
        update_post_meta($post_id, '_service_icon', wp_kses_post($_POST['service_icon']));
    }
}
add_action('save_post_service', 'mdc_save_service_meta');

function mdc_event_meta_boxes() {
    add_meta_box(
        'event_details',
        'Détails de l\'événement',
        'mdc_event_meta_box_callback',
        'evenement',
        'side',
        'high'
    );
}
add_action('add_meta_boxes', 'mdc_event_meta_boxes');

function mdc_event_meta_box_callback($post) {
    wp_nonce_field('mdc_save_event', 'mdc_event_nonce');
    
    $date = get_post_meta($post->ID, '_event_date', true);
    $lieu = get_post_meta($post->ID, '_event_lieu', true);
    ?>
    <p>
        <label><strong>Date :</strong></label><br>
        <input type="date" name="event_date" value="<?php echo esc_attr($date); ?>" style="width: 100%;">
    </p>
    <p>
        <label><strong>Lieu :</strong></label><br>
        <input type="text" name="event_lieu" value="<?php echo esc_attr($lieu); ?>" style="width: 100%;">
    </p>
    <?php
}

function mdc_save_event_meta($post_id) {
    if (!isset($_POST['mdc_event_nonce']) || !wp_verify_nonce($_POST['mdc_event_nonce'], 'mdc_save_event')) {
        return;
    }
    
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    if (isset($_POST['event_date'])) {
        update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date']));
    }
    
    if (isset($_POST['event_lieu'])) {
        update_post_meta($post_id, '_event_lieu', sanitize_text_field($_POST['event_lieu']));
    }
}
add_action('save_post_evenement', 'mdc_save_event_meta');
?>