<?php get_header(); ?>

<?php
// Date actuelle au format Y-m-d
$today = current_time('Y-m-d');

// Événements à venir
$evenements_a_venir = new WP_Query([
    'post_type' => 'evenement',
    'posts_per_page' => -1,
    'meta_key' => '_event_date',
    'orderby' => 'meta_value',
    'order' => 'ASC',
    'meta_query' => [
        [
            'key' => '_event_date',
            'value' => $today,
            'compare' => '>=',
            'type' => 'DATE'
        ]
    ]
]);

// Événements passés
$evenements_passes = new WP_Query([
    'post_type' => 'evenement',
    'posts_per_page' => -1,
    'meta_key' => '_event_date',
    'orderby' => 'meta_value',
    'order' => 'DESC',
    'meta_query' => [
        [
            'key' => '_event_date',
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
            <div class="badge">Événements & Formations</div>
            <h1><?= the_field("event_title"); ?></h1>
            <p style="max-width: 700px; margin: 1rem auto; color: var(--muted-foreground);">
                <?= the_field("event_subtitle"); ?>
            </p>
        </div>
    </section>

    <section style="padding: 4rem 0;">
        <div class="container">

            <div style="text-align: center; margin-bottom: 4rem;" class="reveal">
                <h2 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 1rem;">
                    <span class="gradient-text">
                        <i class="fas fa-star"></i>
                        Évènements
                    </span>
                    à venir
                </h2>
                <p style="color: var(--muted-foreground); font-size: 1.125rem;">Ne manquez pas nos prochaines formations et conférences</p>
            </div>
            
            <div class="events-grid">
                <?php if ($evenements_a_venir->have_posts()) : ?>
                    <?php while ($evenements_a_venir->have_posts()) : $evenements_a_venir->the_post(); 
                        $event_date = get_post_meta(get_the_ID(), '_event_date', true);
                        $event_time_start = get_post_meta(get_the_ID(), '_event_time_start', true);
                        $event_time_end = get_post_meta(get_the_ID(), '_event_time_end', true);
                        $event_lieu = get_post_meta(get_the_ID(), '_event_lieu', true);
                        $event_type = get_post_meta(get_the_ID(), '_event_type', true);
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        
                        $date_formatted = '';
                        if ( ! empty( $event_date ) ) {
                            $timestamp = strtotime( $event_date );
                            if ( $timestamp ) {
                                $date_formatted = wp_date( 'j F Y', $timestamp );
                            }
                        }
                        
                        $type_labels = [
                            'formation' => 'Formation',
                            'conference' => 'Conférence',
                            'atelier' => 'Atelier',
                            'seminaire' => 'Séminaire',
                            'webinaire' => 'Webinaire',
                            'networking' => 'Networking'
                        ];
                        $type_label = isset($type_labels[$event_type]) ? $type_labels[$event_type] : 'Événement';
                        
                        $type_icons = [
                            'formation' => 'fa-graduation-cap',
                            'conference' => 'fa-microphone',
                            'atelier' => 'fa-tools',
                            'seminaire' => 'fa-briefcase',
                            'webinaire' => 'fa-laptop',
                            'networking' => 'fa-handshake'
                        ];
                        $type_icon = isset($type_icons[$event_type]) ? $type_icons[$event_type] : 'fa-calendar-alt';
                        
                        // Construire la date complète pour le compte à rebours
                        $countdown_datetime = $event_date;
                        if ($event_time_start) {
                            $countdown_datetime .= ' ' . $event_time_start;
                        }
                    ?>
                        <div class="event-card reveal">
                            <?php if ($thumbnail_url) : ?>
                            <div style="width: 100%; height: 220px; overflow: hidden; position: relative;">
                                <img src="<?php echo esc_url($thumbnail_url); ?>" 
                                    alt="<?php the_title(); ?>" 
                                    style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease;">
                                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.3));"></div>
                            </div>
                            <?php endif; ?>
                            
                            <div style="padding: 1.5rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                                    <span style="background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; padding: 0.5rem 1.2rem; border-radius: 25px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);">
                                        <i class="fas <?php echo $type_icon; ?>"></i> <?php echo esc_html($type_label); ?>
                                    </span>
                                    <span style="background: linear-gradient(135deg, #f59e0b, #ef4444); color: white; padding: 0.5rem 1.2rem; border-radius: 25px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 2px 8px rgba(245, 158, 11, 0.3);">
                                        <i class="fas fa-bolt"></i> Places limitées
                                    </span>
                                </div>
                                
                                <h3 style="font-size: 1.4rem; margin-bottom: 1rem; font-weight: 700; line-height: 1.3;">
                                    <?php the_title(); ?>
                                </h3>
                                
                                <p style="margin-bottom: 1.5rem; line-height: 1.6; font-size: 0.95rem;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </p>
                                
                                <!-- COMPTE À REBOURS -->
                                <div class="countdown-container" data-datetime="<?php echo esc_attr($countdown_datetime); ?>">
                                    <div class="countdown-title">
                                        <i class="fas fa-hourglass-half"></i>
                                        <span>L'événement commence dans</span>
                                    </div>
                                    <div class="countdown-timer">
                                        <div class="countdown-unit">
                                            <div class="countdown-value" data-type="days">0</div>
                                            <div class="countdown-label">Jours</div>
                                        </div>
                                        <div class="countdown-separator">:</div>
                                        <div class="countdown-unit">
                                            <div class="countdown-value" data-type="hours">0</div>
                                            <div class="countdown-label">Heures</div>
                                        </div>
                                        <div class="countdown-separator">:</div>
                                        <div class="countdown-unit">
                                            <div class="countdown-value" data-type="minutes">0</div>
                                            <div class="countdown-label">Minutes</div>
                                        </div>
                                        <div class="countdown-separator">:</div>
                                        <div class="countdown-unit">
                                            <div class="countdown-value" data-type="seconds">0</div>
                                            <div class="countdown-label">Secondes</div>
                                        </div>
                                    </div>
                                    <div class="countdown-progress">
                                        <div class="countdown-progress-bar"></div>
                                    </div>
                                </div>
                                
                                <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem; margin-top: 1.5rem;">
                                    <?php if ($date_formatted) : ?>
                                    <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem;">
                                        <span style="width: 32px; height: 32px; background: linear-gradient(135deg,#3b82f6, #2563eb); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                            <i class="fas fa-calendar-day"></i>
                                        </span>
                                        <strong><?php echo esc_html($date_formatted); ?></strong>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($event_time_start) : ?>
                                    <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem;">
                                        <span style="width: 32px; height: 32px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <span>
                                            <?php echo esc_html($event_time_start); ?>
                                            <?php if ($event_time_end) : ?>
                                                - <?php echo esc_html($event_time_end); ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($event_lieu) : ?>
                                    <div style="display: flex; align-items: center; gap: 0.75rem; color: #374151; font-size: 0.95rem;">
                                        <span style="width: 32px; height: 32px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        <span><?php echo esc_html($event_lieu); ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <a href="<?= home_url("/contact/"); ?>" class="btn btn-primary">
                                    <i class="fas fa-check-circle"></i> S'inscrire maintenant
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <div style="text-align: center; padding: 3rem; grid-column: 1/-1; border-radius: 16px; border: 2px dashed #e5e7eb;">
                        <i class="fas fa-calendar-times" style="font-size: 3rem;margin-bottom: 1rem; display: block;"></i>
                        <p style="font-size: 1.1rem;">Aucun événement à venir pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>

            <div style="text-align: center; margin-bottom: 4rem; margin-top: 6rem;" class="reveal">
                <h2 style="font-size: clamp(2rem, 4vw, 3rem); margin-bottom: 1rem;">
                    <span class="gradient-text">
                        <i class="fas fa-images"></i>
                        Évènements
                    </span>
                    passés
                </h2>
                <p style="color: var(--muted-foreground); font-size: 1.125rem;">Revivez nos événements précédents en images</p>
            </div>
            
            <div class="events-grid">
                <?php if ($evenements_passes->have_posts()) : ?>
                    <?php while ($evenements_passes->have_posts()) : $evenements_passes->the_post(); 
                        $event_date = get_post_meta(get_the_ID(), '_event_date', true);
                        $event_time_start = get_post_meta(get_the_ID(), '_event_time_start', true);
                        $event_time_end = get_post_meta(get_the_ID(), '_event_time_end', true);
                        $event_lieu = get_post_meta(get_the_ID(), '_event_lieu', true);
                        $event_type = get_post_meta(get_the_ID(), '_event_type', true);
                        $gallery_ids = get_post_meta(get_the_ID(), '_event_gallery', true);
                        $gallery_ids_array = !empty($gallery_ids) ? explode(',', $gallery_ids) : [];
                        $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');
                        
                        $date_formatted = '';
                        if ( ! empty( $event_date ) ) {
                            $timestamp = strtotime( $event_date );
                            if ( $timestamp ) {
                                $date_formatted = wp_date( 'j F Y', $timestamp );
                            }
                        }

                        
                        $type_labels = [
                            'formation' => 'Formation',
                            'conference' => 'Conférence',
                            'atelier' => 'Atelier',
                            'seminaire' => 'Séminaire',
                            'webinaire' => 'Webinaire',
                            'networking' => 'Networking'
                        ];
                        $type_label = isset($type_labels[$event_type]) ? $type_labels[$event_type] : 'Événement';
                        
                        $type_icons = [
                            'formation' => 'fa-graduation-cap',
                            'conference' => 'fa-microphone',
                            'atelier' => 'fa-tools',
                            'seminaire' => 'fa-briefcase',
                            'webinaire' => 'fa-laptop',
                            'networking' => 'fa-handshake'
                        ];
                        $type_icon = isset($type_icons[$event_type]) ? $type_icons[$event_type] : 'fa-calendar-alt';
                        
                        $has_images = !empty($gallery_ids_array) || $thumbnail_url;
                        
                        $gallery_data = [];
                        if (!empty($gallery_ids_array)) {
                            foreach ($gallery_ids_array as $img_id) {
                                $img_url = wp_get_attachment_image_url($img_id, 'large');
                                if ($img_url) {
                                    $gallery_data[] = $img_url;
                                }
                            }
                        } elseif ($thumbnail_url) {
                            $gallery_data[] = $thumbnail_url;
                        }
                    ?>
                        <div class="event-card event-past reveal">
                            <?php if ($thumbnail_url) : ?>
                            <div style="width: 100%; height: 220px; overflow: hidden; position: relative;">
                                <img src="<?php echo esc_url($thumbnail_url); ?>" 
                                    alt="<?php the_title(); ?>" 
                                    style="width: 100%; height: 100%; object-fit: cover; filter: grayscale(20%);">
                                <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, transparent, rgba(0,0,0,0.4));"></div>
                            </div>
                            <?php endif; ?>
                            
                            <div style="padding: 1.5rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
                                    <span style="background: linear-gradient(135deg, #f59e0b, #d97706); padding: 0.5rem 1.2rem; border-radius: 25px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                                        <i class="fas <?php echo $type_icon; ?>"></i> <?php echo esc_html($type_label); ?>
                                    </span>
                                    <span style="background: #d1d5db; color: #4b5563; padding: 0.5rem 1.2rem; border-radius: 25px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem;">
                                        <i class="fas fa-check"></i> Terminé
                                    </span>
                                </div>
                                
                                <h3 style="font-size: 1.4rem; margin-bottom: 1rem; font-weight: 700; line-height: 1.3;">
                                    <?php the_title(); ?>
                                </h3>
                                
                                <p style="margin-bottom: 1.5rem; line-height: 1.6; font-size: 0.95rem;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
                                </p>
                                
                                <div style="display: flex; flex-direction: column; gap: 0.75rem; margin-bottom: 1.5rem;">
                                    <?php if ($date_formatted) : ?>
                                    <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem;">
                                        <span style="width: 32px; height: 32px; background: linear-gradient(135deg,#3b82f6, #2563eb); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                            <i class="fas fa-calendar-day"></i>
                                        </span>
                                        <strong><?php echo esc_html($date_formatted); ?></strong>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($event_time_start) : ?>
                                    <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem;">
                                        <span style="width: 32px; height: 32px; background: linear-gradient(135deg, #10b981, #059669); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                            <i class="fas fa-clock"></i>
                                        </span>
                                        <span>
                                            <?php echo esc_html($event_time_start); ?>
                                            <?php if ($event_time_end) : ?>
                                                - <?php echo esc_html($event_time_end); ?>
                                            <?php endif; ?>
                                        </span>
                                    </div>
                                    <?php endif; ?>
                                    
                                    <?php if ($event_lieu) : ?>
                                    <div style="display: flex; align-items: center; gap: 0.75rem; font-size: 0.95rem;">
                                        <span style="width: 32px; height: 32px; background: linear-gradient(135deg, #f59e0b, #d97706); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white;">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </span>
                                        <span><?php echo esc_html($event_lieu); ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                
                                <?php if ($has_images) : ?>
                                <button class="btn btn-secondary" 
                                        style="width: 100%; padding: 1rem; font-weight: 600; font-size: 1rem; border-radius: 12px; background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; border: none; cursor: pointer; transition: all 0.3s ease; display: inline-flex; align-items: center; justify-content: center; gap: 0.6rem; box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);"
                                        onclick='openEventGallery(<?php echo json_encode($gallery_data); ?>, "<?php echo esc_js(get_the_title()); ?>")'>
                                    <i class="fas fa-images"></i>
                                    Voir la galerie (<?php echo count($gallery_data); ?> photo<?php echo count($gallery_data) > 1 ? 's' : ''; ?>)
                                </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <div style="text-align: center; padding: 3rem; grid-column: 1/-1; border-radius: 16px; border: 2px dashed #e5e7eb;">
                        <i class="fas fa-calendar-times" style="font-size: 3rem;margin-bottom: 1rem; display: block;"></i>
                        <p style="font-size: 1.1rem;">Aucun événement passé pour le moment.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<!-- Modal de galerie -->
<div id="event-gallery-modal" class="gallery-modal" style="display: none;">
    <div class="gallery-modal-overlay" onclick="closeEventGallery()"></div>
    <div class="gallery-modal-content">
        <button class="gallery-modal-close" onclick="closeEventGallery()">&times;</button>
        <h3 id="gallery-title" class="gallery-title"></h3>
        <div class="gallery-slider">
            <button class="gallery-nav gallery-prev" onclick="changeSlide(-1)">‹</button>
            <div class="gallery-image-container">
                <img id="gallery-current-image" src="" alt="">
                <div class="gallery-counter">
                    <span id="gallery-current">1</span> / <span id="gallery-total">1</span>
                </div>
            </div>
            <button class="gallery-nav gallery-next" onclick="changeSlide(1)">›</button>
        </div>
        <div class="gallery-thumbnails" id="gallery-thumbnails"></div>
    </div>
</div>

<style>
/* Styles du compte à rebours */
.countdown-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 16px;
    padding: 1.5rem;
    margin: 1.5rem 0;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
    position: relative;
    overflow: hidden;
}

.countdown-container::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: pulse 3s ease-in-out infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); opacity: 0.5; }
    50% { transform: scale(1.1); opacity: 0.8; }
}

.countdown-title {
    text-align: center;
    color: white;
    font-size: 0.95rem;
    font-weight: 600;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    position: relative;
    z-index: 1;
}

.countdown-title i {
    animation: rotate 2s linear infinite;
}

@keyframes rotate {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.countdown-timer {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 1rem;
    position: relative;
    z-index: 1;
}

.countdown-unit {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 0.75rem 0.5rem;
    min-width: 70px;
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: transform 0.3s ease;
}

.countdown-unit:hover {
    transform: translateY(-5px);
}

.countdown-value {
    font-size: 1.8rem;
    font-weight: 700;
    color: white;
    line-height: 1;
    text-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
}

.countdown-value.flip {
    animation: flipNumber 0.6s ease;
}

@keyframes flipNumber {
    0% { transform: rotateX(0deg); }
    50% { transform: rotateX(90deg); }
    100% { transform: rotateX(0deg); }
}

.countdown-label {
    font-size: 0.7rem;
    color: rgba(255, 255, 255, 0.9);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-top: 0.25rem;
    font-weight: 600;
}

.countdown-separator {
    font-size: 1.5rem;
    color: white;
    font-weight: 700;
    animation: blink 1s infinite;
    margin: 0 0.25rem;
}

@keyframes blink {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.3; }
}

.countdown-progress {
    width: 100%;
    height: 6px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
    overflow: hidden;
    position: relative;
    z-index: 1;
}

.countdown-progress-bar {
    height: 100%;
    background: linear-gradient(90deg, #fff, #ffd700);
    border-radius: 10px;
    animation: progress 60s linear infinite;
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}

@keyframes progress {
    0% { width: 0%; }
    100% { width: 100%; }
}

/* Responsive */
@media (max-width: 640px) {
    .countdown-unit {
        min-width: 60px;
        padding: 0.5rem 0.3rem;
    }
    
    .countdown-value {
        font-size: 1.4rem;
    }
    
    .countdown-label {
        font-size: 0.6rem;
    }
    
    .countdown-separator {
        font-size: 1.2rem;
        margin: 0;
    }
}

/* Styles de la galerie */
.gallery-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 9999;
    display: flex;
    align-items: center;
    justify-content: center;
}

.gallery-modal-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.95);
}

.gallery-modal-content {
    position: relative;
    max-width: 1200px;
    width: 90%;
    max-height: 90vh;
    display: flex;
    flex-direction: column;
    gap: 1rem;
    z-index: 10;
}

.gallery-title {
    color: white;
    text-align: center;
    font-size: 1.5rem;
    margin: 0;
}

.gallery-modal-close {
    position: absolute;
    top: -50px;
    right: 0;
    background: white;
    border: none;
    font-size: 2rem;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 11;
    transition: transform 0.2s;
}

.gallery-modal-close:hover {
    transform: scale(1.1) rotate(90deg);
}

.gallery-slider {
    position: relative;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.gallery-image-container {
    flex: 1;
    position: relative;
    background: #000;
    border-radius: 12px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 400px;
}

.gallery-image-container img {
    max-width: 100%;
    max-height: 70vh;
    object-fit: contain;
    display: block;
}

.gallery-counter {
    position: absolute;
    bottom: 15px;
    left: 50%;
    transform: translateX(-50%);
    background: rgba(0, 0, 0, 0.8);
    color: white;
    padding: 8px 16px;
    border-radius: 20px;
    font-size: 0.9rem;
}

.gallery-nav {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    font-size: 3rem;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s;
    flex-shrink: 0;
}

.gallery-nav:hover {
    background: white;
    transform: scale(1.1);
}

.gallery-thumbnails {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    flex-wrap: wrap;
    max-height: 100px;
    overflow-y: auto;
}

.gallery-thumbnail {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 8px;
    cursor: pointer;
    border: 3px solid transparent;
    transition: all 0.3s;
}

.gallery-thumbnail:hover {
    border-color: white;
    transform: scale(1.05);
}

.gallery-thumbnail.active {
    border-color: var(--primary, #3b82f6);
}

.events-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 2rem;
    margin-top: 2rem;
    margin-bottom: 2rem;
}

@media (max-width: 768px) {
    .events-grid {
        grid-template-columns: 1fr;
    }
}

</style>

<script>
let currentGalleryImages = [];
let currentSlideIndex = 0;

function openEventGallery(images, title) {
    currentGalleryImages = images;
    currentSlideIndex = 0;
    
    document.getElementById('event-gallery-modal').style.display = 'flex';
    document.getElementById('gallery-title').textContent = title;
    document.getElementById('gallery-total').textContent = images.length;
    document.body.style.overflow = 'hidden';
    
    // Créer les miniatures
    const thumbnailsContainer = document.getElementById('gallery-thumbnails');
    thumbnailsContainer.innerHTML = '';
    images.forEach((img, index) => {
        const thumb = document.createElement('img');
        thumb.src = img;
        thumb.className = 'gallery-thumbnail' + (index === 0 ? ' active' : '');
        thumb.onclick = () => goToSlide(index);
        thumbnailsContainer.appendChild(thumb);
    });
    
    showSlide(0);
}

function closeEventGallery() {
    document.getElementById('event-gallery-modal').style.display = 'none';
    document.body.style.overflow = '';
}

function changeSlide(direction) {
    currentSlideIndex += direction;
    if (currentSlideIndex < 0) {
        currentSlideIndex = currentGalleryImages.length - 1;
    } else if (currentSlideIndex >= currentGalleryImages.length) {
        currentSlideIndex = 0;
    }
    showSlide(currentSlideIndex);
}

function goToSlide(index) {
    currentSlideIndex = index;
    showSlide(index);
}

function showSlide(index) {
    document.getElementById('gallery-current-image').src = currentGalleryImages[index];
    document.getElementById('gallery-current').textContent = index + 1;
    
    // Mettre à jour les miniatures actives
    document.querySelectorAll('.gallery-thumbnail').forEach((thumb, i) => {
        thumb.classList.toggle('active', i === index);
    });
}

// Fermer avec la touche Escape
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeEventGallery();
    } else if (e.key === 'ArrowLeft') {
        changeSlide(-1);
    } else if (e.key === 'ArrowRight') {
        changeSlide(1);
    }
});

function initializeCountdowns() {
    const countdownContainers = document.querySelectorAll('.countdown-container');
    
    countdownContainers.forEach(container => {
        const datetime = container.getAttribute('data-datetime');
        if (!datetime) return;
        
        // Convertir la date en timestamp
        const targetDate = new Date(datetime).getTime();
        
        // Fonction pour mettre à jour le compteur
        function updateCountdown() {
            const now = new Date().getTime();
            const distance = targetDate - now;
            
            // Si l'événement est passé
            if (distance < 0) {
                container.innerHTML = `
                    <div class="countdown-title">
                        <i class="fas fa-check-circle"></i>
                        <span>L'événement a commencé !</span>
                    </div>
                `;
                return;
            }
            
            // Calculs
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            // Mettre à jour les valeurs avec animation
            const daysEl = container.querySelector('[data-type="days"]');
            const hoursEl = container.querySelector('[data-type="hours"]');
            const minutesEl = container.querySelector('[data-type="minutes"]');
            const secondsEl = container.querySelector('[data-type="seconds"]');
            
            if (daysEl && daysEl.textContent !== days.toString()) {
                daysEl.classList.add('flip');
                setTimeout(() => daysEl.classList.remove('flip'), 600);
                daysEl.textContent = days;
            }
            
            if (hoursEl && hoursEl.textContent !== hours.toString().padStart(2, '0')) {
                hoursEl.classList.add('flip');
                setTimeout(() => hoursEl.classList.remove('flip'), 600);
                hoursEl.textContent = hours.toString().padStart(2, '0');
            }
            
            if (minutesEl && minutesEl.textContent !== minutes.toString().padStart(2, '0')) {
                minutesEl.classList.add('flip');
                setTimeout(() => minutesEl.classList.remove('flip'), 600);
                minutesEl.textContent = minutes.toString().padStart(2, '0');
            }
            
            if (secondsEl) {
                secondsEl.classList.add('flip');
                setTimeout(() => secondsEl.classList.remove('flip'), 600);
                secondsEl.textContent = seconds.toString().padStart(2, '0');
            }
        }
        
        // Première mise à jour immédiate
        updateCountdown();
        
        // Mise à jour toutes les secondes
        setInterval(updateCountdown, 1000);
    });
}

// Initialiser les compteurs quand le DOM est prêt
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initializeCountdowns);
} else {
    initializeCountdowns();
}


</script>

<?php get_footer(); ?>