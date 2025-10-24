<?php
/**
 * Template for single Annonce posts
 */

get_header();
?>

<main>
    <section class="page-hero">
        <div class="container">
            <div class="badge">Annonces & Opportunités</div>
            <h1><?php the_title(); ?></h1>
            <?php
            // Récupérer les métadonnées
            $date_fin = get_post_meta(get_the_ID(), '_annonce_date_fin', true);
            $type = get_post_meta(get_the_ID(), '_annonce_type', true);
            $lieu = get_post_meta(get_the_ID(), '_annonce_lieu', true);
            $contact = get_post_meta(get_the_ID(), '_annonce_contact', true);
            $email = get_post_meta(get_the_ID(), '_annonce_email', true);
            $telephone = get_post_meta(get_the_ID(), '_annonce_telephone', true);
            $url = get_post_meta(get_the_ID(), '_annonce_url', true);
            
            $type_labels = [
                'emploi' => 'Offre d\'emploi',
                'stage' => 'Stage',
                'benevolat' => 'Bénévolat',
                'vente' => 'Vente',
                'location' => 'Location',
                'service' => 'Service',
                'autre' => 'Autre'
            ];
            $type_label = $type_labels[$type] ?? 'Annonce';
            
            $type_icons = [
                'emploi' => 'fa-briefcase',
                'stage' => 'fa-user-graduate',
                'benevolat' => 'fa-hands-helping',
                'vente' => 'fa-tag',
                'location' => 'fa-home',
                'service' => 'fa-concierge-bell',
                'autre' => 'fa-info-circle'
            ];
            $type_icon = $type_icons[$type] ?? 'fa-bullhorn';
            
            $today = current_time('Y-m-d');
            $is_expired = $date_fin && $date_fin < $today;
            ?>
            <div class="annonce-header-meta">
                <span class="annonce-type-badge <?php echo $is_expired ? 'expired' : ''; ?>">
                    <i class="fas <?php echo $type_icon; ?>"></i> 
                    <?php echo esc_html($type_label); ?>
                </span>
                <?php if ($is_expired) : ?>
                    <span class="annonce-status expired">
                        <i class="fas fa-times-circle"></i> Expirée
                    </span>
                <?php else : ?>
                    <span class="annonce-status active">
                        <i class="fas fa-check-circle"></i> Active
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section style="padding: 4rem 0;">
        <div class="container">
            <div class="annonce-single-content">
                <div class="annonce-main">
                    <?php if (has_post_thumbnail()) : ?>
                    <div class="annonce-featured-image reveal">
                        <?php the_post_thumbnail('large'); ?>
                    </div>
                    <?php endif; ?>

                    <div class="annonce-content reveal">
                        <div class="content-wrapper">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>

                <div class="annonce-sidebar">
                    <!-- Informations principales -->
                    <div class="annonce-info-card reveal">
                        <h3><i class="fas fa-info-circle"></i> Détails de l'annonce</h3>
                        
                        <div class="info-grid">
                            <?php if ($date_fin) : ?>
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-calendar-day"></i>
                                </div>
                                <div class="info-content">
                                    <strong>Date d'expiration</strong>
                                    <span class="<?php echo $is_expired ? 'expired-text' : ''; ?>">
                                        <?php echo wp_date('j F Y', strtotime($date_fin)); ?>
                                        <?php if ($is_expired) : ?>
                                            <br><small style="color: #dc2626;">(Annonce expirée)</small>
                                        <?php endif; ?>
                                    </span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($lieu) : ?>
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                <div class="info-content">
                                    <strong>Lieu</strong>
                                    <span><?php echo esc_html($lieu); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php 
                            $date_publication = get_the_date('j F Y');
                            ?>
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-clock"></i>
                                </div>
                                <div class="info-content">
                                    <strong>Publiée le</strong>
                                    <span><?php echo $date_publication; ?></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact -->
                    <div class="annonce-contact-card reveal">
                        <h3><i class="fas fa-envelope"></i> Contact</h3>
                        
                        <div class="contact-grid">
                            <?php if ($contact) : ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="contact-content">
                                    <strong>Contact</strong>
                                    <span><?php echo esc_html($contact); ?></span>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($email) : ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="contact-content">
                                    <strong>Email</strong>
                                    <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-link">
                                        <?php echo esc_html($email); ?>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($telephone) : ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <div class="contact-content">
                                    <strong>Téléphone</strong>
                                    <a href="tel:<?php echo esc_attr($telephone); ?>" class="contact-link">
                                        <?php echo esc_html($telephone); ?>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                            
                            <?php if ($url) : ?>
                            <div class="contact-item">
                                <div class="contact-icon">
                                    <i class="fas fa-link"></i>
                                </div>
                                <div class="contact-content">
                                    <strong>Site web</strong>
                                    <a href="<?php echo esc_url($url); ?>" target="_blank" rel="noopener noreferrer" class="contact-link">
                                        <?php echo esc_html(parse_url($url, PHP_URL_HOST)); ?>
                                    </a>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if ($email || $telephone) : ?>
                        <div class="contact-actions">
                            <?php if ($email) : ?>
                            <a href="mailto:<?php echo esc_attr($email); ?>" class="btn btn-primary">
                                <i class="fas fa-envelope"></i> Envoyer un email
                            </a>
                            <?php endif; ?>
                            
                            <?php if ($telephone) : ?>
                            <a href="tel:<?php echo esc_attr($telephone); ?>" class="btn btn-secondary">
                                <i class="fas fa-phone"></i> Appeler
                            </a>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Actions -->
                    <div class="annonce-actions-card reveal">
                        <h3><i class="fas fa-share-alt"></i> Partager</h3>
                        <div class="share-buttons">
                            <button onclick="shareOnFacebook()" class="share-btn facebook">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button onclick="shareOnTwitter()" class="share-btn twitter">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button onclick="shareOnLinkedIn()" class="share-btn linkedin">
                                <i class="fab fa-linkedin-in"></i>
                            </button>
                            <button onclick="copyLink()" class="share-btn link">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                        
                        <div class="action-buttons">
                            <a href="<?php echo get_permalink(get_page_by_path('annonces')); ?>" class="btn btn-outline">
                                <i class="fas fa-arrow-left"></i> Retour aux annonces
                            </a>
                            <button onclick="window.print()" class="btn btn-outline">
                                <i class="fas fa-print"></i> Imprimer
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* Hero Section */
.annonce-header-meta {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    margin-top: 1rem;
    flex-wrap: wrap;
}

.annonce-type-badge {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    color: white;
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
}

.annonce-type-badge.expired {
    background: linear-gradient(135deg, #9ca3af, #6b7280);
}

.annonce-status {
    padding: 0.75rem 1.5rem;
    border-radius: 25px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.annonce-status.active {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
}

.annonce-status.expired {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
    box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
}

/* Layout */
.annonce-single-content {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 3rem;
    max-width: 1200px;
    margin: 0 auto;
}

.annonce-main {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.annonce-sidebar {
    display: flex;
    flex-direction: column;
    gap: 2rem;
    position: sticky;
    top: 2rem;
    height: fit-content;
}

/* Featured Image */
.annonce-featured-image {
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.annonce-featured-image img {
    width: 100%;
    height: auto;
    display: block;
    transition: transform 0.3s ease;
}

.annonce-featured-image:hover img {
    transform: scale(1.02);
}

/* Content */
.annonce-content {
    background: white;
    border-radius: 16px;
    padding: 2.5rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
}

.content-wrapper {
    font-size: 1.125rem;
    line-height: 1.7;
    color: #374151;
}

.content-wrapper p {
    margin-bottom: 1.5rem;
}

.content-wrapper h2,
.content-wrapper h3,
.content-wrapper h4 {
    margin: 2.5rem 0 1.5rem 0;
    color: #1f2937;
    font-weight: 700;
}

.content-wrapper h2 {
    font-size: 1.75rem;
    border-bottom: 3px solid #3b82f6;
    padding-bottom: 0.5rem;
}

.content-wrapper h3 {
    font-size: 1.5rem;
    color: #374151;
}

.content-wrapper ul, 
.content-wrapper ol {
    margin: 1.5rem 0;
    padding-left: 2rem;
}

.content-wrapper li {
    margin-bottom: 0.5rem;
}

.content-wrapper blockquote {
    border-left: 4px solid #3b82f6;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #6b7280;
}

/* Cards */
.annonce-info-card,
.annonce-contact-card,
.annonce-actions-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    border: 1px solid #e5e7eb;
}

.annonce-info-card h3,
.annonce-contact-card h3,
.annonce-actions-card h3 {
    font-size: 1.25rem;
    margin-bottom: 1.5rem;
    color: #1f2937;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.annonce-info-card h3 i,
.annonce-contact-card h3 i,
.annonce-actions-card h3 i {
    color: #3b82f6;
}

/* Info Grid */
.info-grid {
    display: flex;
    flex-direction: column;
    gap: 1.25rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: transform 0.2s, box-shadow 0.2s;
}

.info-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.info-icon {
    width: 48px;
    height: 48px;
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
}

.info-content strong {
    display: block;
    color: #374151;
    margin-bottom: 0.25rem;
    font-size: 0.95rem;
}

.info-content span {
    color: #1f2937;
    font-weight: 600;
    font-size: 1rem;
}

.expired-text {
    color: #dc2626 !important;
}

/* Contact Grid */
.contact-grid {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.contact-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    background: #f8f9fa;
    border-radius: 12px;
    transition: all 0.2s;
}

.contact-item:hover {
    background: #e5e7eb;
    transform: translateX(4px);
}

.contact-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #10b981, #059669);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.contact-content {
    flex: 1;
}

.contact-content strong {
    display: block;
    color: #374151;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
}

.contact-link {
    color: #3b82f6;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.2s;
}

.contact-link:hover {
    color: #2563eb;
    text-decoration: underline;
}

/* Buttons */
.contact-actions {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 0.75rem;
    margin-top: 1.5rem;
}

.btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    border: none;
    cursor: pointer;
    font-size: 0.95rem;
    text-align: center;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    color: white;
    box-shadow: 0 2px 8px rgba(59, 130, 246, 0.3);
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.btn-secondary {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
    box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);
}

.btn-secondary:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(16, 185, 129, 0.4);
}

.btn-outline {
    background: transparent;
    color: #374151;
    border: 2px solid #e5e7eb;
}

.btn-outline:hover {
    background: #f8f9fa;
    border-color: #d1d5db;
    transform: translateY(-1px);
}

/* Share Buttons */
.share-buttons {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 1.5rem;
    justify-content: center;
}

.share-btn {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    color: white;
}

.share-btn.facebook { background: #3b5998; }
.share-btn.twitter { background: #1da1f2; }
.share-btn.linkedin { background: #0077b5; }
.share-btn.link { background: #6b7280; }

.share-btn:hover {
    transform: translateY(-3px) scale(1.1);
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}

.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

/* Responsive */
@media (max-width: 1024px) {
    .annonce-single-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .annonce-sidebar {
        position: static;
    }
}

@media (max-width: 768px) {
    .annonce-header-meta {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .annonce-content {
        padding: 1.5rem;
    }
    
    .annonce-info-card,
    .annonce-contact-card,
    .annonce-actions-card {
        padding: 1.5rem;
    }
    
    .contact-actions {
        grid-template-columns: 1fr;
    }
    
    .info-item,
    .contact-item {
        flex-direction: column;
        text-align: center;
        gap: 0.75rem;
    }
    
    .share-buttons {
        flex-wrap: wrap;
    }
}

/* Animation reveal */
.reveal {
    opacity: 0;
    transform: translateY(30px);
    animation: reveal 0.6s ease forwards;
}

@keyframes reveal {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.reveal:nth-child(2) { animation-delay: 0.1s; }
.reveal:nth-child(3) { animation-delay: 0.2s; }
.reveal:nth-child(4) { animation-delay: 0.3s; }
</style>

<script>
// Fonctions de partage
function shareOnFacebook() {
    const url = encodeURIComponent(window.location.href);
    const title = encodeURIComponent(document.title);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}&t=${title}`, '_blank', 'width=600,height=400');
}

function shareOnTwitter() {
    const url = encodeURIComponent(window.location.href);
    const text = encodeURIComponent(document.title);
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
}

function shareOnLinkedIn() {
    const url = encodeURIComponent(window.location.href);
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
}

function copyLink() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        // Afficher une notification de succès
        const btn = event.target.closest('.share-btn');
        const originalHTML = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check"></i>';
        btn.style.background = '#10b981';
        
        setTimeout(() => {
            btn.innerHTML = originalHTML;
            btn.style.background = '';
        }, 2000);
    });
}

// Animation au scroll
document.addEventListener('DOMContentLoaded', function() {
    const reveals = document.querySelectorAll('.reveal');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animationPlayState = 'running';
            }
        });
    }, { threshold: 0.1 });
    
    reveals.forEach(reveal => {
        observer.observe(reveal);
    });
});
</script>

<?php
get_footer();