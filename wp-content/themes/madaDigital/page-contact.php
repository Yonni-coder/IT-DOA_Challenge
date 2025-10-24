<?php get_header(); ?>

<section class="page-hero">
    <div class="container">
        <h1>
            <?= the_field("contact_title"); ?>
        </h1>
        <p style="max-width: 700px; margin: 1rem auto; color: var(--muted-foreground);">
            <?= the_field("contact_subtitle"); ?>
        </p>
    </div>
</section>

<section style="padding: 4rem 0;">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; max-width: 1000px; margin: 0 auto;">
            <div>
                <h2 style="margin-bottom: 2rem;">Formulaire de contact</h2>
                <form id="contact-form" class="contact-form reveal">
                    <?php wp_nonce_field('contact_form_submit', 'contact_nonce'); ?>
                    <div id="form-messages" style="display: none; padding: 1rem; margin-bottom: 1rem; border-radius: 8px;"></div>
                    
                    <div class="form-group">
                        <label class="form-label" for="name">Nom complet</label>
                        <input type="text" id="name" name="name" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="email">Adresse email</label>
                        <input type="email" id="email" name="email" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="subject">Sujet</label>
                        <input type="text" id="subject" name="subject" class="form-input" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label" for="message">Message</label>
                        <textarea id="message" name="message" class="form-textarea" rows="5" required></textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        <span class="btn-text">Envoyer le message</span>
                        <span class="btn-loading" style="display: none;">Envoi en cours...</span>
                    </button>
                </form>
            </div>
            
            <div>
                <h2 style="margin-bottom: 2rem;">Notre localisation</h2>
                <div id="map" style="height: 300px; border-radius: 12px; overflow: hidden; margin-bottom: 2rem;"></div>
                
                <div style="margin-top: 2rem; display: flex; flex-direction: column; gap: 1.5rem;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 48px; height: 48px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-map-marker-alt" style="color: white; font-size: 1.25rem;"></i>
                        </div>
                        <div>
                            <h3 style="margin-bottom: 0.25rem; font-size: 1.125rem;">Adresse</h3>
                            <p style="color: var(--muted-foreground); margin: 0;">
                                <?php echo esc_html(get_theme_mod('contact_address', 'P893+25J Antsiranana, Madagascar')); ?>
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 48px; height: 48px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-envelope" style="color: white; font-size: 1.25rem;"></i>
                        </div>
                        <div>
                            <h3 style="margin-bottom: 0.25rem; font-size: 1.125rem;">Email</h3>
                            <p style="color: var(--muted-foreground); margin: 0;">
                                <a href="mailto:<?php echo esc_attr(get_theme_mod('contact_email', 'contact@mada-digital.net')); ?>" style="color: inherit;">
                                    <?php echo esc_html(get_theme_mod('contact_email', 'contact@mada-digital.net')); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 48px; height: 48px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-phone" style="color: white; font-size: 1.25rem;"></i>
                        </div>
                        <div>
                            <h3 style="margin-bottom: 0.25rem; font-size: 1.125rem;">Téléphone</h3>
                            <p style="color: var(--muted-foreground); margin: 0;">
                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('contact_phone', '+261 XX XX XXX XX'))); ?>" style="color: inherit;">
                                    <?php echo esc_html(get_theme_mod('contact_phone', '+261 XX XX XXX XX')); ?>
                                </a>
                            </p>
                        </div>
                    </div>
                    
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        <div style="width: 48px; height: 48px; background: var(--primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                            <i class="fas fa-clock" style="color: white; font-size: 1.25rem;"></i>
                        </div>
                        <div>
                            <h3 style="margin-bottom: 0.25rem; font-size: 1.125rem;">Horaires</h3>
                            <p style="color: var(--muted-foreground); margin: 0;">
                                <?php echo esc_html(get_theme_mod('contact_hours', 'Lundi - Vendredi: 8h00 - 17h00')); ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Initialiser Google Maps
function initMap() {
    const lat = parseFloat('<?php echo esc_js(get_theme_mod('contact_latitude', '-12.2797')); ?>');
    const lng = parseFloat('<?php echo esc_js(get_theme_mod('contact_longitude', '49.2919')); ?>');
    
    const location = { lat: lat, lng: lng };
    
    const map = new google.maps.Map(document.getElementById('map'), {
        zoom: 15,
        center: location,
        styles: [
            {
                featureType: 'all',
                elementType: 'geometry',
                stylers: [{ color: '#242f3e' }]
            },
            {
                featureType: 'all',
                elementType: 'labels.text.stroke',
                stylers: [{ color: '#242f3e' }]
            },
            {
                featureType: 'all',
                elementType: 'labels.text.fill',
                stylers: [{ color: '#746855' }]
            }
        ]
    });
    
    const marker = new google.maps.Marker({
        position: location,
        map: map,
        title: '<?php echo esc_js(get_bloginfo('name')); ?>'
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('contact-form');
    
    if (!form) return;
    
    const messagesDiv = document.getElementById('form-messages');
    const btnText = form.querySelector('.btn-text');
    const btnLoading = form.querySelector('.btn-loading');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Afficher le loader
        btnText.style.display = 'none';
        btnLoading.style.display = 'inline';
        submitBtn.disabled = true;
        
        // Préparer les données
        const formData = new FormData(form);
        formData.append('action', 'contact_form_submit');
        formData.append('contact_nonce', '<?php echo wp_create_nonce('contact_form_submit'); ?>');
        
        // Envoyer via AJAX
        fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            messagesDiv.style.display = 'block';
            
            if (data.success) {
                messagesDiv.style.background = '#d4edda';
                messagesDiv.style.color = '#155724';
                messagesDiv.style.border = '1px solid #c3e6cb';
                messagesDiv.textContent = data.data.message;
                form.reset();
            } else {
                messagesDiv.style.background = '#f8d7da';
                messagesDiv.style.color = '#721c24';
                messagesDiv.style.border = '1px solid #f5c6cb';
                messagesDiv.textContent = data.data.message;
            }
            
            setTimeout(() => {
                messagesDiv.style.display = 'none';
            }, 5000);
        })
        .catch(error => {
            console.error('Erreur:', error);
            messagesDiv.style.display = 'block';
            messagesDiv.style.background = '#f8d7da';
            messagesDiv.style.color = '#721c24';
            messagesDiv.textContent = 'Une erreur est survenue. Veuillez réessayer.';
        })
        .finally(() => {
            btnText.style.display = 'inline';
            btnLoading.style.display = 'none';
            submitBtn.disabled = false;
        });
    });
});
</script>

<?php if (get_theme_mod('google_maps_api_key')) : ?>
<script src="https://maps.googleapis.com/maps/api/js?key=<?php echo esc_attr(get_theme_mod('google_maps_api_key')); ?>&callback=initMap" async defer></script>
<?php else : ?>
<script>
    // Alternative avec OpenStreetMap (Leaflet) si pas de clé Google Maps
    document.addEventListener('DOMContentLoaded', function() {
        const mapDiv = document.getElementById('map');
        mapDiv.innerHTML = '<iframe width="100%" height="300" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox=<?php echo esc_attr(get_theme_mod('contact_longitude', '49.2919')); ?>%2C<?php echo esc_attr(get_theme_mod('contact_latitude', '-12.2797')); ?>%2C<?php echo esc_attr(get_theme_mod('contact_longitude', '49.2919')); ?>%2C<?php echo esc_attr(get_theme_mod('contact_latitude', '-12.2797')); ?>&layer=mapnik&marker=<?php echo esc_attr(get_theme_mod('contact_latitude', '-12.2797')); ?>%2C<?php echo esc_attr(get_theme_mod('contact_longitude', '49.2919')); ?>" style="border-radius: 12px;"></iframe>';
    });
</script>
<?php endif; ?>

<?php get_footer(); ?>