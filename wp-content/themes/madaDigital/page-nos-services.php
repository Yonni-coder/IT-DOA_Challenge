
<?php get_header(); ?>

<!-- Services Content -->
<main>
    <section class="page-hero">
        <div class="container">
            <div class="badge">Nos Services</div>
            <h1>
                <?php the_field("service_title"); ?>
            </h1>
            <p style="max-width: 700px; margin: 1rem auto; color: var(--muted-foreground);">
                <?php the_field("service_subtitle"); ?>
            </p>
        </div>
    </section>

    <section style="padding: 4rem 0;">
        <div class="container">
            
            <div class="services-grid">
                <?php
                    $services = new WP_Query([
                        'post_type' => 'service',
                        'orderby' => 'date',
                        'order' => 'DESC'
                    ]);
                
                if ($services->have_posts()) :
                    while ($services->have_posts()) : $services->the_post();
                        $icon = get_post_meta(get_the_ID(), '_service_icon', true);
                ?>
                    <div class="card reveal">
                        <div class="card-icon">
                            <?php
                                if ($icon) {
                                    echo $icon;
                                } else {
                                    echo '<svg fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"/></svg>';
                                }
                            ?>
                        </div>
                        <h3 style="font-size: 1.5rem; margin-bottom: 1rem;"><?php the_title(); ?></h3>
                        <p style="color: var(--muted-foreground);"><?php echo wp_trim_words(get_the_content(), 15); ?></p>
                    </div>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
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
                <?php endif; ?>
            </div>

        </div>
    </section>
</main>

<?php get_footer(); ?>