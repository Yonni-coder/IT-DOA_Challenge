
<?php get_header(); ?>

<main>
    <section class="page-hero">
        <div class="container">
            <div class="badge">Nos Réalisations</div>
            <h1>
                <?= the_field("project_title"); ?>
            </h1>
            <p style="max-width: 700px; margin: 1rem auto; color: var(--muted-foreground);">
                <?= the_field("project_subtitle"); ?>
            </p>
        </div>
    </section>

    <section style="padding: 4rem 0;">
        <div class="container">
            <div class="realisations-grid">
                
                <?php
                    // Récupérer les 3 derniers projets
                    $projets = new WP_Query([
                        'post_type' => 'projet',
                        'posts_per_page' => 3,
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ]);
                    
                    if ($projets->have_posts()) :
                        while ($projets->have_posts()) : $projets->the_post();
                    ?>
                        <div class="card reveal">
                            <div class="gallery-item">
                                <?php if (has_post_thumbnail()) : ?>
                                    <?php the_post_thumbnail('large', ['class' => 'gallery-img', 'alt' => get_the_title()]); ?>
                                <?php else : ?>
                                    <img src="https://images.unsplash.com/photo-1551650975-87deedd944c3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="<?php the_title(); ?>" class="gallery-img">
                                <?php endif; ?>
                                <div class="gallery-overlay">
                                    <h3><?php the_title(); ?></h3>
                                    <p><?php echo wp_trim_words(get_the_excerpt(), 10); ?></p>
                                </div>
                            </div>
                            <h3 style="margin: 1.5rem 0 1rem;"><?php the_title(); ?></h3>
                            <p style="color: var(--muted-foreground);">Création d'une plateforme de vente en ligne complète avec système de paiement sécurisé et gestion des stocks.</p>
                        </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                    ?>
                    <div style="text-align: center; padding: 3rem; grid-column: 1/-1; border-radius: 16px; border: 2px dashed #e5e7eb;">
                        <i class="fas fa-calendar-times" style="font-size: 3rem;margin-bottom: 1rem; display: block;"></i>
                        <p style="font-size: 1.1rem;">Aucune réalisation pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php get_footer(); ?>

    