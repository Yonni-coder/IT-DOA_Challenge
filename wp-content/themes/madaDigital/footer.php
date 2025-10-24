<!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <!-- Logo et description -->
                <div>
                    <div class="logo" style="margin-bottom: 1rem;">
                        <a href="<?php echo home_url('/'); ?>">
                            <img 
                                src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png"
                                data-logo-light="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png"
                                data-logo-dark="<?php echo get_template_directory_uri(); ?>/assets/img/logo.dark.mode.png"
                                alt="<?php bloginfo('name'); ?>"
                                class="logo"
                            >
                        </a>
                    </div>
                    <p style="color: var(--muted-foreground); margin-bottom: 1.5rem;">
                        <?php echo esc_html(get_option('footer_description', 'Votre partenaire digital à Madagascar depuis 2009.')); ?>
                    </p>
                    
                    <!-- Réseaux sociaux -->
                    <div class="social-links">
                        <?php
                        $social_networks = array(
                            'facebook' => 'fab fa-facebook-f',
                            'linkedin' => 'fab fa-linkedin-in',
                            'twitter' => 'fab fa-twitter',
                            'instagram' => 'fab fa-instagram',
                            'youtube' => 'fab fa-youtube',
                            'tiktok' => 'fab fa-tiktok'
                        );
                        
                        foreach ($social_networks as $network => $icon) {
                            $url = get_option('social_' . $network);
                            if (!empty($url)) {
                                echo sprintf(
                                    '<a href="%s" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="%s"><i class="%s"></i></a>',
                                    esc_url($url),
                                    ucfirst($network),
                                    esc_attr($icon)
                                );
                            }
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Liens rapides -->
                <div>
                    <h3 style="margin-bottom: 1.5rem;">Liens rapides</h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu',
                        'container' => 'nav',
                        'container_class' => 'footer-links',
                        'menu_class' => '',
                        'fallback_cb' => function() {
                            echo '<div class="footer-links">';
                            echo '<a href="' . home_url('/') . '" class="footer-link">Accueil</a>';
                            echo '<a href="' . home_url('/a-propos') . '" class="footer-link">À propos</a>';
                            echo '<a href="' . home_url('/services') . '" class="footer-link">Services</a>';
                            echo '<a href="' . home_url('/realisations') . '" class="footer-link">Réalisations</a>';
                            echo '<a href="' . home_url('/blog') . '" class="footer-link">Blog</a>';
                            echo '<a href="' . home_url('/contact') . '" class="footer-link">Contact</a>';
                            echo '</div>';
                        }
                    ));
                    ?>
                </div>
                
                <!-- Contact -->
                <div>
                    <h3 style="margin-bottom: 1.5rem;">Contact</h3>
                    <div class="footer-links">
                        <?php
                        $contact_address = get_option('contact_address', 'P893+25J Antsiranana, Madagascar');
                        $contact_email = get_option('contact_email', get_option('admin_email'));
                        $contact_phone = get_option('contact_phone', '+261 XX XX XXX XX');
                        ?>
                        
                        <div style="display: flex; align-items: flex-start; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <i class="fas fa-map-marker-alt" style="margin-top: 3px; color: var(--primary);"></i>
                            <span style="color: var(--muted-foreground);"><?php echo esc_html($contact_address); ?></span>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem;">
                            <i class="fas fa-envelope" style="color: var(--primary);"></i>
                            <a href="mailto:<?php echo esc_attr($contact_email); ?>" 
                               style="color: var(--muted-foreground); text-decoration: none;">
                                <?php echo esc_html($contact_email); ?>
                            </a>
                        </div>
                        
                        <div style="display: flex; align-items: center; gap: 0.5rem;">
                            <i class="fas fa-phone" style="color: var(--primary);"></i>
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', $contact_phone)); ?>" 
                               style="color: var(--muted-foreground); text-decoration: none;">
                                <?php echo esc_html($contact_phone); ?>
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Newsletter -->
                <?php if (get_option('footer_show_newsletter', 1)): ?>
                <div>
                    <h3 style="margin-bottom: 1.5rem;">Newsletter</h3>
                    <p style="color: var(--muted-foreground); margin-bottom: 1rem;">
                        Inscrivez-vous pour recevoir nos dernières actualités et offres.
                    </p>
                    <form class="newsletter-form" id="newsletterForm">
                        <?php wp_nonce_field('newsletter_action', 'newsletter_nonce'); ?>
                        <input type="email" 
                               name="email" 
                               class="newsletter-input" 
                               placeholder="Votre email" 
                               required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                    <div id="newsletter-message" style="margin-top: 0.75rem; font-size: 14px;"></div>
                </div>
                <?php endif; ?>
            </div>
            
            <!-- Footer bottom -->
            <div class="footer-bottom">
                © <span id="currentYear"><?php echo date('Y'); ?></span> 
                <?php echo esc_html(get_option('footer_copyright', 'MADA-Digital. Tous droits réservés.')); ?>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Script pour la newsletter -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const newsletterForm = document.getElementById('newsletterForm');
        const newsletterMessage = document.getElementById('newsletter-message');
        
        if (newsletterForm) {
            newsletterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const formData = new FormData(this);
                formData.append('action', 'newsletter_subscribe');
                
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalHTML = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
                submitBtn.disabled = true;
                
                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        newsletterMessage.innerHTML = '<span style="color: #00a32a;">✅ ' + data.data + '</span>';
                        newsletterForm.reset();
                        
                        // Animation de succès
                        newsletterMessage.style.animation = 'slideDown 0.3s ease';
                    } else {
                        newsletterMessage.innerHTML = '<span style="color: #d63638;">❌ ' + data.data + '</span>';
                    }
                    
                    // Effacer le message après 5 secondes
                    setTimeout(() => {
                        newsletterMessage.innerHTML = '';
                    }, 5000);
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    newsletterMessage.innerHTML = '<span style="color: #d63638;">❌ Une erreur est survenue.</span>';
                })
                .finally(() => {
                    submitBtn.innerHTML = originalHTML;
                    submitBtn.disabled = false;
                });
            });
        }
        
        // Back to top button
        const backToTop = document.getElementById('backToTop');
        if (backToTop) {
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            });
            
            backToTop.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    });
    </script>

    <?php wp_footer(); ?>
</body>
</html>