
<?php
    get_header();
?>

<?php
    include('inc/nav.php')
;?>
    <!-- Navbar -->
    

    <!-- Home Content -->
    <main>
        <section class="hero">
            <div class="hero-content">
                <div class="badge">
                    <span class="glow"></span>
                    Solutions digitales innovantes
                </div>
                
                <h1>
                    <span class="gradient-text typewriter" id="typewriter">Transformez vos idées</span><br>
                    <span class="gradient-text">en réalité digitale</span>
                </h1>
                
                <p>Depuis 2009, MADA-Digital accompagne vos projets de développement web, mobile et d'infrastructure réseau à Madagascar.</p>
                
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 2rem;">
                    <a href="contact.html" class="btn btn-primary">
                        Démarrer un projet →
                    </a>
                    <a href="services.html" class="btn btn-secondary">
                        Nos services
                    </a>
                </div>
            </div>
        </section>

        <!-- Stats Section with animated counters -->
        <section class="stats reveal">
            <div class="container">
                <div class="stats-grid">
                    <div class="stat-item">
                        <div class="stat-value" data-target="15">0</div>
                        <div style="color: var(--muted-foreground); margin-top: 0.5rem;">Années d'expérience</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" data-target="200">0</div>
                        <div style="color: var(--muted-foreground); margin-top: 0.5rem;">Projets réalisés</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value" data-target="50">0</div>
                        <div style="color: var(--muted-foreground); margin-top: 0.5rem;">Clients satisfaits</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-value">24/7</div>
                        <div style="color: var(--muted-foreground); margin-top: 0.5rem;">Support disponible</div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Preview -->
        <section style="padding: 6rem 0;">
            <div class="container">
                <div style="text-align: center; margin-bottom: 4rem;" class="reveal">
                    <h2 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 1rem;">
                        Nos <span class="gradient-text">Services</span>
                    </h2>
                    <p style="color: var(--muted-foreground); font-size: 1.125rem;">Solutions complètes pour tous vos besoins digitaux</p>
                </div>

                <div class="services-grid">
                    <div class="card reveal">
                        <div class="card-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                            </svg>
                        </div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">Développement Web</h3>
                        <p style="color: var(--muted-foreground);">Applications sur mesure adaptées à vos besoins</p>
                    </div>

                    <div class="card reveal">
                        <div class="card-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                            </svg>
                        </div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">Réseaux & Interconnexion</h3>
                        <p style="color: var(--muted-foreground);">Installation et gestion de réseaux informatiques</p>
                    </div>

                    <div class="card reveal">
                        <div class="card-icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">Vidéosurveillance</h3>
                        <p style="color: var(--muted-foreground);">Solutions de sécurité et surveillance</p>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 3rem;">
                    <a href="services.html" class="btn btn-primary">
                        Voir tous nos services
                    </a>
                </div>
            </div>
        </section>

        <!-- Featured Projects -->
        <section style="padding: 6rem 0; background: var(--muted);">
            <div class="container">
                <div style="text-align: center; margin-bottom: 4rem;" class="reveal">
                    <h2 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 1rem;">
                        Projets <span class="gradient-text">Récents</span>
                    </h2>
                    <p style="color: var(--muted-foreground); font-size: 1.125rem;">Découvrez quelques-unes de nos réalisations</p>
                </div>

                <div class="image-gallery">
                    <div class="gallery-item reveal">
                        <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Site e-commerce" class="gallery-img">
                        <div class="gallery-overlay">
                            <h3>Plateforme E-commerce</h3>
                            <p>Solution complète de vente en ligne</p>
                        </div>
                    </div>

                    <div class="gallery-item reveal">
                        <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Application mobile" class="gallery-img">
                        <div class="gallery-overlay">
                            <h3>Application Mobile</h3>
                            <p>Solution de gestion pour entreprise</p>
                        </div>
                    </div>

                    <div class="gallery-item reveal">
                        <img src="https://images.unsplash.com/photo-1620712943543-bcc4688e7485?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Réseau d'entreprise" class="gallery-img">
                        <div class="gallery-overlay">
                            <h3>Réseau d'Entreprise</h3>
                            <p>Infrastructure réseau complète</p>
                        </div>
                    </div>
                </div>

                <div style="text-align: center; margin-top: 3rem;">
                    <a href="realisations.html" class="btn btn-primary">
                        Voir toutes nos réalisations
                    </a>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section style="padding: 6rem 0;">
            <div class="container">
                <div style="text-align: center; margin-bottom: 4rem;" class="reveal">
                    <h2 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 1rem;">
                        Témoignages <span class="gradient-text">Clients</span>
                    </h2>
                    <p style="color: var(--muted-foreground); font-size: 1.125rem;">Ce que nos clients disent de nous</p>
                </div>

                <div class="testimonials-grid">
                    <div class="testimonial-card reveal">
                        <div class="testimonial-content">
                            <p style="color: var(--muted-foreground);">MADA-Digital a transformé notre présence en ligne avec un site web moderne et fonctionnel. Leur équipe est professionnelle et réactive.</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="Client" class="testimonial-avatar">
                            <div>
                                <h4>Jean Rakoto</h4>
                                <p style="color: var(--muted-foreground); font-size: 0.875rem;">Directeur, Entreprise XYZ</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card reveal">
                        <div class="testimonial-content">
                            <p style="color: var(--muted-foreground);">L'infrastructure réseau déployée par MADA-Digital a considérablement amélioré notre productivité. Service impeccable !</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="Client" class="testimonial-avatar">
                            <div>
                                <h4>Marie Rasoa</h4>
                                <p style="color: var(--muted-foreground); font-size: 0.875rem;">Responsable IT, Société ABC</p>
                            </div>
                        </div>
                    </div>

                    <div class="testimonial-card reveal">
                        <div class="testimonial-content">
                            <p style="color: var(--muted-foreground);">Le système de vidéosurveillance installé a renforcé la sécurité de nos locaux. Un service de qualité à Madagascar.</p>
                        </div>
                        <div class="testimonial-author">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80" alt="Client" class="testimonial-avatar">
                            <div>
                                <h4>Paul Randria</h4>
                                <p style="color: var(--muted-foreground); font-size: 0.875rem;">Gérant, Complexe Commercial</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Partners -->
        <section style="padding: 4rem 0; background: var(--muted);">
            <div class="container">
                <div style="text-align: center; margin-bottom: 3rem;" class="reveal">
                    <h2 style="font-size: clamp(1.5rem, 3vw, 2.5rem); margin-bottom: 1rem;">
                        Nos <span class="gradient-text">Partenaires</span>
                    </h2>
                    <p style="color: var(--muted-foreground);">Nous collaborons avec les meilleures technologies</p>
                </div>

                <div class="partners-grid">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/64/Cisco_logo.svg" alt="Cisco" class="partner-logo reveal">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/2/27/PHP-logo.svg" alt="PHP" class="partner-logo reveal">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/a/a7/React-icon.svg" alt="React" class="partner-logo reveal">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d9/Node.js_logo.svg" alt="Node.js" class="partner-logo reveal">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/6/61/HTML5_logo_and_wordmark.svg" alt="HTML5" class="partner-logo reveal">
                </div>
            </div>
        </section>
    </main>

<?php
    get_footer();
?>