    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="logo" style="margin-bottom: 1rem;">
                        <a href="<?php echo home_url('/'); ?>">
                            <img 
                                src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png"
                                data-logo-light="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png"
                                data-logo-dark="<?php echo get_template_directory_uri(); ?>/assets/img/logo.dark.mode.png"
                                alt="Mada Digital"
                                class="logo"
                            >
                        </a>
                    </div>
                    <p style="color: var(--muted-foreground); margin-bottom: 1.5rem;">
                        <?php echo esc_html(get_theme_mod('footer_description', 'Votre partenaire digital à Madagascar depuis 2009.')); ?>
                    </p>
                    <div class="social-links">
                        <?php if (get_theme_mod('footer_facebook', '#') !== '#') : ?>
                            <a href="<?php echo esc_url(get_theme_mod('footer_facebook', '#')); ?>" class="social-link" target="_blank" rel="noopener">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('footer_linkedin', '#') !== '#') : ?>
                            <a href="<?php echo esc_url(get_theme_mod('footer_linkedin', '#')); ?>" class="social-link" target="_blank" rel="noopener">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('footer_twitter', '#') !== '#') : ?>
                            <a href="<?php echo esc_url(get_theme_mod('footer_twitter', '#')); ?>" class="social-link" target="_blank" rel="noopener">
                                <i class="fab fa-twitter"></i>
                            </a>
                        <?php endif; ?>
                        
                        <?php if (get_theme_mod('footer_instagram', '#') !== '#') : ?>
                            <a href="<?php echo esc_url(get_theme_mod('footer_instagram', '#')); ?>" class="social-link" target="_blank" rel="noopener">
                                <i class="fab fa-instagram"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
                
                <div>
                    <h3 style="margin-bottom: 1.5rem;">Liens rapides</h3>
                    <div class="footer-links">
                        <?php
                        if (has_nav_menu('Menu footer')) {
                            wp_nav_menu(array(
                                'theme_location' => 'Menu footer',
                                'container'      => false,
                                'items_wrap'     => '%3$s',
                                'link_before'    => '<span class="footer-link">',
                                'link_after'     => '</span>',
                            ));
                        } else {
                            // Menu par défaut si aucun menu n'est assigné
                            ?>
                            <a href="<?php echo home_url('/'); ?>" class="footer-link">Accueil</a>
                            <a href="<?php echo home_url('/a-propos'); ?>" class="footer-link">À propos</a>
                            <a href="<?php echo home_url('/services'); ?>" class="footer-link">Services</a>
                            <!-- <a href="<?php echo home_url('/realisations'); ?>" class="footer-link">Réalisations</a> -->
                            <a href="<?php echo home_url('/evenements'); ?>" class="footer-link">Événements</a>
                            <a href="<?php echo home_url('/faq'); ?>" class="footer-link">FAQ</a>
                            <a href="<?php echo home_url('/contact'); ?>" class="footer-link">Contact</a>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                
                <div>
                    <h3 style="margin-bottom: 1.5rem;">Contact</h3>
                    <div class="footer-links">
                        <span style="color: var(--muted-foreground);">
                            <?php echo esc_html(get_theme_mod('footer_address', 'P893+25J Antsiranana, Madagascar')); ?>
                        </span>
                        <span style="color: var(--muted-foreground);">
                            <a href="mailto:<?php echo esc_attr(get_theme_mod('footer_email', 'contact@mada-digital.net')); ?>" style="color: inherit;">
                                <?php echo esc_html(get_theme_mod('footer_email', 'contact@mada-digital.net')); ?>
                            </a>
                        </span>
                        <span style="color: var(--muted-foreground);">
                            <a href="tel:<?php echo esc_attr(str_replace(' ', '', get_theme_mod('footer_phone', '+261 XX XX XXX XX'))); ?>" style="color: inherit;">
                                <?php echo esc_html(get_theme_mod('footer_phone', '+261 XX XX XXX XX')); ?>
                            </a>
                        </span>
                    </div>
                </div>
                
                <div>
                    <h3 style="margin-bottom: 1.5rem;">
                        <?php echo esc_html(get_theme_mod('footer_newsletter_title', 'Newsletter')); ?>
                    </h3>
                    <p style="color: var(--muted-foreground); margin-bottom: 1rem;">
                        <?php echo esc_html(get_theme_mod('footer_newsletter_text', 'Inscrivez-vous pour recevoir nos dernières actualités.')); ?>
                    </p>
                    <form class="newsletter-form" method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                        <input type="hidden" name="action" value="newsletter_subscription">
                        <?php wp_nonce_field('newsletter_subscription', 'newsletter_nonce'); ?>
                        <input type="email" name="newsletter_email" class="newsletter-input" placeholder="Votre email" required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                © <span id="currentYear"><?php echo date('Y'); ?></span> <?php echo esc_html(get_theme_mod('footer_copyright', 'MADA-Digital. Tous droits réservés.')); ?>
            </div>
        </div>
    </footer>

    <!-- Back to top button -->
    <div class="back-to-top" id="backToTop">
        <i class="fas fa-arrow-up"></i>
    </div>

    <!-- Modal for event photos -->
    <div class="modal" id="eventModal">
        <div class="modal-content">
            <button class="modal-close" id="modalClose">
                <i class="fas fa-times"></i>
            </button>
            <img src="" alt="Photo de l'événement" class="modal-image" id="modalImage">
        </div>
    </div>

    <script type='text/javascript' src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js?ver=3.3.1'></script>

    <!-- Motion.js for animations -->
    <script type="module">
        import { animate } from 'https://cdn.jsdelivr.net/npm/motion@latest/+esm';
        window.motionAnimate = animate;
    </script>
    
    <?php wp_footer() ;?>
</body>
</html>