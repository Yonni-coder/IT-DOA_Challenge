
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
            <?php
            // Récupérer toutes les catégories FAQ
            $categories = get_terms(array(
                'taxonomy' => 'faq_category',
                'hide_empty' => true,
            ));

            foreach ($categories as $category) :
                // Récupérer les questions de cette catégorie
                $faq_query = new WP_Query(array(
                    'post_type' => 'faq',
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'faq_category',
                            'field' => 'term_id',
                            'terms' => $category->term_id,
                        ),
                    ),
                ));

                if ($faq_query->have_posts()) :
            ?>
                <h2 style="margin: 3rem 0 2rem;"><?php echo esc_html($category->name); ?></h2>
                
                <?php while ($faq_query->have_posts()) : $faq_query->the_post(); ?>
                    <div class="accordion-item reveal">
                        <div class="accordion-header" onclick="toggleAccordion(this)">
                            <span><?php the_title(); ?></span>
                            <span style="transition: transform 0.3s;">▼</span>
                        </div>
                        <div class="accordion-content">
                            <div class="accordion-body">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
                
            <?php
                endif;
                wp_reset_postdata();
            endforeach;
            ?>
        </div>
    </section>
</main>

<?php get_footer(); ?>