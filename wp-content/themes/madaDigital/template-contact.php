<?php
/**
 * Template Name: Contact
 * Description: Page de contact avec formulaire et carte
 */
get_header();

// Récupérer les coordonnées
$coords = get_contact_coordinates();
?>

<section class="page-hero">
    <div class="container">
        <h1>Contactez<span class="gradient-text">-nous</span></h1>
        <p style="max-width: 700px; margin: 1rem auto; color: var(--muted-foreground);">
            Une question ? Un projet ? Notre équipe est là pour vous accompagner.
        </p>
    </div>
</section>

<?php
// Afficher les messages de confirmation
$messages = array(
    'success' => array(
        'type' => 'success',
        'icon' => '✅',
        'text' => 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.'
    ),
    'partial_success' => array(
        'type' => 'warning',
        'icon' => '⚠️',
        'text' => 'Votre message a été enregistré mais l\'envoi d\'email a échoué. Nous avons bien reçu votre message.'
    ),
    'error' => array(
        'type' => 'error',
        'icon' => '❌',
        'text' => 'Une erreur est survenue. Veuillez réessayer ou nous contacter directement.'
    ),
    'missing_fields' => array(
        'type' => 'warning',
        'icon' => '⚠️',
        'text' => 'Veuillez remplir tous les champs obligatoires.'
    ),
    'invalid_email' => array(
        'type' => 'warning',
        'icon' => '⚠️',
        'text' => 'L\'adresse email n\'est pas valide.'
    ),
    'security_error' => array(
        'type' => 'error',
        'icon' => '🔒',
        'text' => 'Erreur de sécurité. Veuillez actualiser la page et réessayer.'
    )
);

if (isset($_GET['contact']) && isset($messages[$_GET['contact']])) {
    $msg = $messages[$_GET['contact']];
    $bg_colors = array(
        'success' => '#d4edda',
        'warning' => '#fff3cd',
        'error' => '#f8d7da'
    );
    $text_colors = array(
        'success' => '#155724',
        'warning' => '#856404',
        'error' => '#721c24'
    );
    ?>
    <div style="padding: 1rem; background: <?php echo $bg_colors[$msg['type']]; ?>; 
                color: <?php echo $text_colors[$msg['type']]; ?>; border-radius: 8px; 
                margin: 2rem auto; max-width: 1000px; text-align: center; animation: slideDown 0.3s ease;">
        <?php echo $msg['icon'] . ' ' . $msg['text']; ?>
    </div>
    <?php
}
?>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; max-width: 1200px; margin: 0 auto;">
            
                <!-- Formulaire de contact -->
            <div class="reveal">
                <h2 class="section-title">Formulaire de contact</h2>
                <form class="contact-form" method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                    <?php wp_nonce_field('contact_form_action', 'contact_form_nonce'); ?>
                    <input type="hidden" name="action" value="submit_contact_form">
                    
                    <div class="form-group">
                        <label class="form-label" for="name">
                            Nom complet <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               class="form-input" 
                               required 
                               value="<?php echo isset($_POST['name']) ? esc_attr($_POST['name']) : ''; ?>"
                               placeholder="Votre nom complet">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">
                            Adresse email <span class="required">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               class="form-input" 
                               required
                               value="<?php echo isset($_POST['email']) ? esc_attr($_POST['email']) : ''; ?>"
                               placeholder="exemple@domaine.com">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="subject">
                            Sujet <span class="required">*</span>
                        </label>
                        <input type="text" 
                               id="subject" 
                               name="subject" 
                               class="form-input" 
                               required
                               value="<?php echo isset($_POST['subject']) ? esc_attr($_POST['subject']) : ''; ?>"
                               placeholder="Le sujet de votre message">
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="message">
                            Message <span class="required">*</span>
                        </label>
                        <textarea id="message" 
                                  name="message" 
                                  class="form-textarea" 
                                  rows="6" 
                                  required
                                  placeholder="Votre message..."><?php echo isset($_POST['message']) ? esc_textarea($_POST['message']) : ''; ?></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-paper-plane"></i> Envoyer le message
                    </button>
                </form>
            </div>
            
            <!-- Carte et informations -->
            <div class="reveal">
                <h2 style="margin-bottom: 2rem;">Notre localisation</h2>
                
                <!-- Carte interactive -->
                <div id="map" style="width: 100%; height: 400px; border-radius: 12px; overflow: hidden; 
                                    box-shadow: 0 4px 6px rgba(0,0,0,0.1); margin-bottom: 2rem;"></div>
                
                <!-- Informations de contact -->
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    
                    <div style="display: flex; align-items: flex-start; gap: 1rem; padding: 1rem; 
                                background: var(--card); border-radius: 8px; transition: transform 0.2s;"
                         onmouseover="this.style.transform='translateX(5px)'" 
                         onmouseout="this.style.transform='translateX(0)'">
                        <span style="font-size: 1.5rem;">📍</span>
                        <div>
                            <h3 style="margin: 0 0 0.5rem 0;">Adresse</h3>
                            <p style="color: var(--muted-foreground); margin: 0;">
                                <?php echo esc_html($coords['address']); ?>
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 1rem; padding: 1rem; 
                                background: var(--card); border-radius: 8px; transition: transform 0.2s;"
                         onmouseover="this.style.transform='translateX(5px)'" 
                         onmouseout="this.style.transform='translateX(0)'">
                        <span style="font-size: 1.5rem;">📧</span>
                        <div>
                            <h3 style="margin: 0 0 0.5rem 0;">Email</h3>
                            <p style="color: var(--muted-foreground); margin: 0;">
                                <a href="mailto:<?php echo esc_attr(get_option('contact_email', get_option('admin_email'))); ?>" 
                                   style="color: var(--primary); text-decoration: none;">
                                    <?php echo esc_html(get_option('contact_email', get_option('admin_email'))); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 1rem; padding: 1rem; 
                                background: var(--card); border-radius: 8px; transition: transform 0.2s;"
                         onmouseover="this.style.transform='translateX(5px)'" 
                         onmouseout="this.style.transform='translateX(0)'">
                        <span style="font-size: 1.5rem;">📞</span>
                        <div>
                            <h3 style="margin: 0 0 0.5rem 0;">Téléphone</h3>
                            <p style="color: var(--muted-foreground); margin: 0;">
                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_option('contact_phone', '+261 XX XX XXX XX'))); ?>" 
                                   style="color: var(--primary); text-decoration: none;">
                                    <?php echo esc_html(get_option('contact_phone', '+261 XX XX XXX XX')); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: flex-start; gap: 1rem; padding: 1rem; 
                                background: var(--card); border-radius: 8px; transition: transform 0.2s;"
                         onmouseover="this.style.transform='translateX(5px)'" 
                         onmouseout="this.style.transform='translateX(0)'">
                        <span style="font-size: 1.5rem;">🕐</span>
                        <div>
                            <h3 style="margin: 0 0 0.5rem 0;">Horaires</h3>
                            <p style="color: var(--muted-foreground); margin: 0; white-space: pre-line;">
                                <?php echo esc_html(get_option('contact_hours', 'Lundi - Vendredi: 8h00 - 17h00')); ?>
                            </p>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Leaflet CSS et JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const coordinates = {
        lat: <?php echo $coords['lat']; ?>,
        lng: <?php echo $coords['lng']; ?>,
        address: <?php echo json_encode($coords['address']); ?>,
        company: <?php echo json_encode(get_bloginfo('name')); ?>
    };

    console.log('Initialisation de la carte:', coordinates);

    // Initialiser la carte
    var map = L.map('map').setView([coordinates.lat, coordinates.lng], 15);

    // Ajouter les tuiles OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 19
    }).addTo(map);

    // Icône personnalisée
    var customIcon = L.divIcon({
        className: 'custom-marker',
        html: '<div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); width: 40px; height: 40px; border-radius: 50% 50% 50% 0; border: 4px solid white; box-shadow: 0 4px 12px rgba(0,0,0,0.3); transform: rotate(-45deg);"><div style="transform: rotate(45deg); color: white; font-size: 18px; line-height: 32px; text-align: center;">📍</div></div>',
        iconSize: [40, 40],
        iconAnchor: [20, 40],
        popupAnchor: [0, -40]
    });

    // Ajouter le marqueur
    var marker = L.marker([coordinates.lat, coordinates.lng], {icon: customIcon}).addTo(map);
    
    // Popup avec informations
    marker.bindPopup(`
        <div style="text-align: center; padding: 10px;">
            <h4 style="margin: 0 0 10px 0; color: #667eea; font-size: 16px;">${coordinates.company}</h4>
            <p style="margin: 0 0 8px 0; font-size: 13px; color: #666;">${coordinates.address}</p>
            <div style="margin-top: 10px; padding-top: 10px; border-top: 1px solid #eee;">
                <small style="color: #999;">Lat: ${coordinates.lat.toFixed(6)}, Lng: ${coordinates.lng.toFixed(6)}</small>
            </div>
            <a href="https://www.google.com/maps?q=${coordinates.lat},${coordinates.lng}" 
               target="_blank" 
               style="display: inline-block; margin-top: 10px; padding: 5px 15px; background: #667eea; color: white; text-decoration: none; border-radius: 4px; font-size: 12px;">
                Ouvrir dans Google Maps
            </a>
        </div>
    `).openPopup();

    // Ajuster la vue
    map.invalidateSize();
    
    // Animation du marqueur
    setTimeout(function() {
        marker.openPopup();
    }, 500);
});

// Recalculer la taille lors du redimensionnement
window.addEventListener('resize', function() {
    setTimeout(function() {
        if (typeof map !== 'undefined') {
            map.invalidateSize();
        }
    }, 200);
});
</script>

<style>
.custom-marker {
    background: transparent !important;
    border: none !important;
}

.leaflet-popup-content-wrapper {
    border-radius: 12px;
    box-shadow: 0 8px 24px rgba(0,0,0,0.15);
    padding: 0;
}

.leaflet-popup-content {
    margin: 0;
    line-height: 1.5;
}

.leaflet-popup-tip {
    background: white;
}

#map {
    min-height: 400px;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 768px) {
    .container > div {
        grid-template-columns: 1fr !important;
    }
}
</style>

<?php get_footer(); ?>