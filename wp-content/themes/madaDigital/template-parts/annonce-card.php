<?php
$status = $args['status'] ?? 'active';
$date_fin = get_post_meta(get_the_ID(), '_annonce_date_fin', true);
$type = get_post_meta(get_the_ID(), '_annonce_type', true);
$lieu = get_post_meta(get_the_ID(), '_annonce_lieu', true);
$contact = get_post_meta(get_the_ID(), '_annonce_contact', true);
$email = get_post_meta(get_the_ID(), '_annonce_email', true);
$telephone = get_post_meta(get_the_ID(), '_annonce_telephone', true);
$url = get_post_meta(get_the_ID(), '_annonce_url', true);
$thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'large');

$date_fin_formatted = '';
if (!empty($date_fin)) {
    $timestamp = strtotime($date_fin);
    if ($timestamp) {
        $date_fin_formatted = wp_date('j F Y', $timestamp);
    }
}

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

$type_colors = [
    'emploi' => 'linear-gradient(135deg, #3b82f6, #2563eb)',
    'stage' => 'linear-gradient(135deg, #8b5cf6, #7c3aed)',
    'benevolat' => 'linear-gradient(135deg, #10b981, #059669)',
    'vente' => 'linear-gradient(135deg, #f59e0b, #d97706)',
    'location' => 'linear-gradient(135deg, #ec4899, #db2777)',
    'service' => 'linear-gradient(135deg, #06b6d4, #0891b2)',
    'autre' => 'linear-gradient(135deg, #6366f1, #4f46e5)'
];
$type_color = $type_colors[$type] ?? 'linear-gradient(135deg, #6366f1, #8b5cf6)';

$is_expired = $status === 'expired';
?>

<div class="annonce-card <?php echo $is_expired ? 'annonce-expired' : ''; ?> reveal">
    <?php if ($thumbnail_url) : ?>
    <div style="width: 100%; height: 220px; overflow: hidden; position: relative;">
        <img src="<?php echo esc_url($thumbnail_url); ?>" 
            alt="<?php the_title(); ?>" 
            style="width: 100%; height: 100%; object-fit: cover; <?php echo $is_expired ? 'filter: grayscale(50%);' : ''; ?>">
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(to bottom, transparent, rgba(0,0,0,<?php echo $is_expired ? '0.5' : '0.3'; ?>));"></div>
    </div>
    <?php endif; ?>
    
    <div style="padding: 1.5rem; <?php echo $is_expired ? 'opacity: 0.7;' : ''; ?>">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.5rem;">
            <span style="background: <?php echo $is_expired ? '#9ca3af' : $type_color; ?>; color: white; padding: 0.5rem 1.2rem; border-radius: 25px; font-size: 0.85rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem; <?php echo !$is_expired ? 'box-shadow: 0 2px 8px rgba(99, 102, 241, 0.3);' : ''; ?>">
                <i class="fas <?php echo $type_icon; ?>"></i> <?php echo esc_html($type_label); ?>
            </span>
            <?php if ($is_expired) : ?>
            <span style="background: #dc2626; color: white; padding: 0.5rem 1.2rem; border-radius: 25px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem;">
                <i class="fas fa-times-circle"></i> Expirée
            </span>
            <?php else : ?>
            <span style="background: linear-gradient(135deg, #10b981, #059669); color: white; padding: 0.5rem 1.2rem; border-radius: 25px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 0.4rem; box-shadow: 0 2px 8px rgba(16, 185, 129, 0.3);">
                <i class="fas fa-check-circle"></i> Active
            </span>
            <?php endif; ?>
        </div>
        
        <h3 style="font-size: 1.4rem; margin-bottom: 1rem; font-weight: 700; line-height: 1.3;">
            <?php the_title(); ?>
        </h3>
        
        <p style="margin-bottom: 1.5rem; line-height: 1.6; font-size: 0.95rem;">
            <?php echo wp_trim_words(get_the_excerpt(), 20); ?>
        </p>