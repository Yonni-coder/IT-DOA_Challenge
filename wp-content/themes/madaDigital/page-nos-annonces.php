<?php
/**
 * Template Name: Page des Annonces
 */
get_header(); 

// Date actuelle
$today = current_time('Y-m-d');

// Annonces actives
$annonces_actives = new WP_Query([
    'post_type' => 'annonce',
    'posts_per_page' => -1,
    'meta_key' => '_annonce_date_fin',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query' => [
        [
            'key' => '_annonce_date_fin',
            'value' => $today,
            'compare' => '>=',
            'type' => 'DATE'
        ]
    ]
]);

// Annonces expirées
$annonces_expirees = new WP_Query([
    'post_type' => 'annonce',
    'posts_per_page' => -1,
    'meta_key' => '_annonce_date_fin',
    'orderby' => 'meta_value',
    'order' => 'DESC',
    'meta_query' => [
        [
            'key' => '_annonce_date_fin',
            'value' => $today,
            'compare' => '<',
            'type' => 'DATE'
        ]
    ]
]);
?>

<main>
    <section class="page-hero">
        <div class="container">
            <div class="badge">Annonces & Opportunités</div>
            <h1><?= the_field("annonce_title"); ?></h1>
            <p style="max-width: 700px; margin: 1rem auto; color: var(--muted-foreground);">
                <?= the_field("annonce_subtitle"); ?>
            </p>
        </div>
    </section>

    <section style="padding: 4rem 0;">
        <div class="container">
            <!-- Annonces actives -->
            <div style="text-align: center; margin-bottom: 4rem;" class="reveal">
                <h2 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 1rem;">
                    <span class="gradient-text">
                        <i class="fas fa-bullhorn"></i> Annonces
                    </span>
                    actives
                </h2>
                <p style="color: var(--muted-foreground); font-size: 1.125rem;">
                    Découvrez les dernières opportunités disponibles
                </p>
            </div>
            
            <div class="annonces-grid">
                <?php if ($annonces_actives->have_posts()) : ?>
                    <?php while ($annonces_actives->have_posts()) : $annonces_actives->the_post();
                    ?>
                    <?php
                        get_template_part('template-parts/annonce', 'card', ['status' => 'active']);
                    endwhile; 
                    wp_reset_postdata(); ?>
                <?php else : ?>
                    <div style="text-align: center; padding: 3rem; grid-column: 1/-1; border-radius: 16px; border: 2px dashed #e5e7eb;">
                        <i class="fas fa-inbox" style="font-size: 3rem; margin-bottom: 1rem; display: block; color: #9ca3af;"></i>
                        <p style="font-size: 1.1rem; color: #6b7280;">Aucune annonce active pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Annonces expirées -->
            <?php if ($annonces_expirees->have_posts()) : ?>
            <div style="text-align: center; margin: 6rem 0 4rem;" class="reveal">
                <h2 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 1rem;">
                    <span class="gradient-text">
                        <i class="fas fa-archive"></i> Annonces
                    </span>
                    expirées
                </h2>
                <p style="color: var(--muted-foreground); font-size: 1.125rem;">Archive des annonces passées</p>
            </div>
            
            <div class="annonces-grid">
                <?php while ($annonces_expirees->have_posts()) : $annonces_expirees->the_post(); 
                    get_template_part('template-parts/annonce', 'card', ['status' => 'expired']);
                endwhile; 
                wp_reset_postdata(); ?>
            </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<!-- Modal de contact -->
<div id="annonce-contact-modal" class="contact-modal" style="display: none;">
    <div class="contact-modal-overlay" onclick="closeAnnonceContact()"></div>
    <div class="contact-modal-content">
        <button class="contact-modal-close" onclick="closeAnnonceContact()">&times;</button>
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #6366f1, #8b5cf6); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1rem; color: white; font-size: 2rem;">
                <i class="fas fa-envelope"></i>
            </div>
            <h3 id="contact-title" style="font-size: 1.75rem; margin-bottom: 0.5rem;"></h3>
            <p style="color: var(--muted-foreground);">Informations de contact</p>
        </div>
        <div id="contact-info"></div>
    </div>
</div>

<style>
.annonces-grid {
  display: grid;
  gap: 2rem;
  margin: 3rem 0;
  box-sizing: border-box;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)) !important;
}

/* CAS : il n'y a qu'un seul enfant direct (élément) -> centre et limite la largeur */
</style>

<?php get_footer(); ?>