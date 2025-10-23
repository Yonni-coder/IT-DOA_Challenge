
<?php get_header(); ?>

<main>
    <section class="page-hero">
        <div class="container">
            <div class="badge">Aide & Support</div>
            <h1><span class="gradient-text">Questions fréquentes</span></h1>
            <p style="max-width: 700px; margin: 1rem auto; color: var(--muted-foreground);">
                Retrouvez les réponses aux questions les plus courantes sur nos services.
            </p>
        </div>
    </section>

    <section style="padding: 4rem 0;">
        <div class="container" style="max-width: 800px;">
            <h2 style="margin-bottom: 2rem;">Services & Expertise</h2>
            
            <div class="accordion-item reveal">
                <div class="accordion-header" onclick="toggleAccordion(this)">
                    <span>Quels types de projets web développez-vous ?</span>
                    <span style="transition: transform 0.3s;">▼</span>
                </div>
                <div class="accordion-content">
                    <div class="accordion-body">
                        Nous développons des sites vitrines, e-commerce, applications web sur-mesure, PWA (Progressive Web Apps), et applications mobiles hybrides. Nous travaillons avec des technologies modernes comme PHP, Java, Angular, Node.js et React.
                    </div>
                </div>
            </div>

            <div class="accordion-item reveal">
                <div class="accordion-header" onclick="toggleAccordion(this)">
                    <span>Proposez-vous des services d'infogérance ?</span>
                    <span style="transition: transform 0.3s;">▼</span>
                </div>
                <div class="accordion-content">
                    <div class="accordion-body">
                        Oui, nous offrons des services d'infogérance complets incluant la maintenance, le monitoring 24/7, les mises à jour de sécurité, et le support technique. Nos équipes interviennent rapidement en cas d'incident.
                    </div>
                </div>
            </div>

            <div class="accordion-item reveal">
                <div class="accordion-header" onclick="toggleAccordion(this)">
                    <span>Travaillez-vous avec des équipements Cisco ?</span>
                    <span style="transition: transform 0.3s;">▼</span>
                </div>
                <div class="accordion-content">
                    <div class="accordion-body">
                        Absolument. Nous sommes spécialisés dans la conception, le déploiement et la maintenance d'infrastructures réseau basées sur des équipements Cisco. Nous gérons les switchs, routeurs, points d'accès Wi-Fi et solutions de sécurité.
                    </div>
                </div>
            </div>

            <h2 style="margin: 3rem 0 2rem;">Processus & Délais</h2>

            <div class="accordion-item reveal">
                <div class="accordion-header" onclick="toggleAccordion(this)">
                    <span>Quel est le délai moyen pour un projet web ?</span>
                    <span style="transition: transform 0.3s;">▼</span>
                </div>
                <div class="accordion-content">
                    <div class="accordion-body">
                        Le délai varie selon la complexité du projet. Un site vitrine nécessite généralement 2-4 semaines, tandis qu'une application web sur-mesure peut prendre 2-6 mois. Nous établissons un planning détaillé lors de la phase de cadrage.
                    </div>
                </div>
            </div>

            <div class="accordion-item reveal">
                <div class="accordion-header" onclick="toggleAccordion(this)">
                    <span>Proposez-vous un support après la livraison ?</span>
                    <span style="transition: transform 0.3s;">▼</span>
                </div>
                <div class="accordion-content">
                    <div class="accordion-body">
                        Oui, nous proposons différents niveaux de support après la livraison, incluant la maintenance corrective, les mises à jour de sécurité, l'hébergement et l'assistance technique. Nous adaptons notre offre à vos besoins spécifiques.
                    </div>
                </div>
            </div>

            <div class="accordion-item reveal">
                <div class="accordion-header" onclick="toggleAccordion(this)">
                    <span>Quelle est votre zone d'intervention à Madagascar ?</span>
                    <span style="transition: transform 0.3s;">▼</span>
                </div>
                <div class="accordion-content">
                    <div class="accordion-body">
                        Nous intervenons sur toute l'île de Madagascar, avec une présence forte à Antsiranana, Antananarivo, Toamasina, Mahajanga, Fianarantsoa, Toliara et Taolagnaro. Nos services à distance sont également disponibles pour toutes les régions.
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>