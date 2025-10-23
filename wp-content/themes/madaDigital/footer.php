    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-grid">
                <div>
                    <div class="logo" style="margin-bottom: 1rem;">
                        <a href="<?php echo home_url('/'); ?>">
                            <img 
                                src="<?php echo get_template_directory_uri(); ?>/assets/img/logo.png"
                                data-logo-light="<?= get_template_directory_uri(); ?>/assets/img/logo.png"
                                data-logo-dark="<?= get_template_directory_uri(); ?>/assets/img/logo.dark.mode.png"
                                alt="Mada Digital"
                                class="logo"
                            >
                        </a>
                    </div>
                    <p style="color: var(--muted-foreground); margin-bottom: 1.5rem;">Votre partenaire digital à Madagascar depuis 2009.</p>
                    <div class="social-links">
                        <a href="#" class="social-link">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="social-link">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <div>
                    <h3 style="margin-bottom: 1.5rem;">Liens rapides</h3>
                    <div class="footer-links">
                        <a href="index.html" class="footer-link">Accueil</a>
                        <a href="apropos.html" class="footer-link">À propos</a>
                        <a href="services.html" class="footer-link">Services</a>
                        <a href="realisations.html" class="footer-link">Réalisations</a>
                        <a href="evenements.html" class="footer-link">Événements</a>
                        <a href="faq.html" class="footer-link">FAQ</a>
                        <a href="contact.html" class="footer-link">Contact</a>
                    </div>
                </div>
                
                <div>
                    <h3 style="margin-bottom: 1.5rem;">Contact</h3>
                    <div class="footer-links">
                        <span style="color: var(--muted-foreground);">P893+25J Antsiranana, Madagascar</span>
                        <span style="color: var(--muted-foreground);">contact@mada-digital.net</span>
                        <span style="color: var(--muted-foreground);">+261 XX XX XXX XX</span>
                    </div>
                </div>
                
                <div>
                    <h3 style="margin-bottom: 1.5rem;">Newsletter</h3>
                    <p style="color: var(--muted-foreground); margin-bottom: 1rem;">Inscrivez-vous pour recevoir nos dernières actualités.</p>
                    <form class="newsletter-form">
                        <input type="email" class="newsletter-input" placeholder="Votre email" required>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div class="footer-bottom">
                © <span id="currentYear"> <?php echo date('Y') ;?> </span> MADA-Digital. Tous droits réservés.
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