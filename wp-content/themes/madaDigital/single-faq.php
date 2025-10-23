<?php get_header(); ?>

<main>
    <?php while (have_posts()) : the_post(); ?>
        <article class="faq-single">
            <div class="container" style="max-width: 800px; padding: 4rem 0;">
                <div class="badge">FAQ</div>
                <h1 class="gradient-text"><?php the_title(); ?></h1>
                
                <?php 
                $categories = get_the_terms(get_the_ID(), 'faq_category');
                if ($categories && !is_wp_error($categories)) : ?>
                    <div class="faq-categories" style="margin: 1rem 0;">
                        <?php foreach ($categories as $category) : ?>
                            <span class="badge"><?php echo esc_html($category->name); ?></span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
                
                <div class="faq-content" style="margin-top: 2rem;">
                    <?php the_content(); ?>
                </div>
            </div>
        </article>
    <?php endwhile; ?>
</main>

<?php get_footer(); ?>