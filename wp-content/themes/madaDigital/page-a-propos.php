
<?php get_header(); ?>

<main>
    <section class="page-hero">
        <div class="container">
            <div class="badge">À propos de nous</div>
            <h1>Notre <span class="gradient-text">Histoire</span></h1>
            <p style="max-width: 700px; margin: 1rem auto; color: var(--muted-foreground);">
                Découvrez l'histoire et les valeurs de MADA-Digital, votre partenaire de confiance à Madagascar.
            </p>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <div class="about-grid">
                <div class="about-content reveal">
                    <h2 class="about-title">
                        À propos de <span class="gradient-text">MADA-Digital</span>
                    </h2>
                    <p class="about-description">
                        Depuis 2009, MADA-Digital propose ses services pour tous travaux de développement d'application web et mobile, d'installation de réseau informatique intranet et extranet, ainsi que d'installation de solution de télécommunication.
                    </p>
                    <ul class="about-list">
                        <li class="about-list-item">
                            <i class="fas fa-check-circle check-icon"></i>
                            <span class="list-text">Équipe de professionnels expérimentés</span>
                        </li>
                        <li class="about-list-item">
                            <i class="fas fa-check-circle check-icon"></i>
                            <span class="list-text">Services dans tout Madagascar</span>
                        </li>
                        <li class="about-list-item">
                            <i class="fas fa-check-circle check-icon"></i>
                            <span class="list-text">Interventions à distance partout dans le monde</span>
                        </li>
                        <li class="about-list-item">
                            <i class="fas fa-check-circle check-icon"></i>
                            <span class="list-text">Satisfaction client garantie</span>
                        </li>
                    </ul>
                </div>

                <div class="images-grid reveal">
                    <img
                        src="https://images.unsplash.com/photo-1521737711867-e3b97375f902?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1587&q=80"
                        alt="Équipe MADA-Digital"
                        class="about-image"
                    />
                    <img
                        src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1770&q=80"
                        alt="Collaboration"
                        class="about-image image-2"
                    />
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section style="padding: 6rem 0; background: var(--muted);">
        <div class="container">
            <div style="text-align: center; margin-bottom: 4rem;" class="reveal">
                <h2 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 1rem;">
                    Nos <span class="gradient-text">Valeurs</span>
                </h2>
            </div>

            <div class="services-grid">
                <div class="card reveal">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">Orientation Client</h3>
                    <p style="color: var(--muted-foreground);">Nous plaçons nos clients au cœur de nos préoccupations et nous engageons à comprendre et répondre à leurs besoins spécifiques.</p>
                </div>

                <div class="card reveal">
                    <div class="card-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">Innovation</h3>
                    <p style="color: var(--muted-foreground);">Nous restons à la pointe des technologies émergentes pour proposer des solutions modernes et efficaces à nos clients.</p>
                </div>

                <div class="card reveal">
                    <div class="card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">Fiabilité</h3>
                    <p style="color: var(--muted-foreground);">Nous nous engageons à fournir des services de qualité, sécurisés et durables qui répondent aux attentes de nos clients.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>