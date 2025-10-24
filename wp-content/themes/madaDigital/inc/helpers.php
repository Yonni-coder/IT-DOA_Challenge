<?php
/**
 * Fonctions utilitaires pour le thème
 */

// Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Afficher le logo du site
 */
function mada_display_logo($class = 'logo') {
    if (has_custom_logo()) {
        the_custom_logo();
    } else {
        $logo_light = get_template_directory_uri() . '/assets/img/logo.png';
        $logo_dark = get_template_directory_uri() . '/assets/img/logo.dark.mode.png';
        
        echo sprintf(
            '<a href="%s"><img src="%s" data-logo-light="%s" data-logo-dark="%s" alt="%s" class="%s"></a>',
            home_url('/'),
            $logo_light,
            $logo_light,
            $logo_dark,
            get_bloginfo('name'),
            esc_attr($class)
        );
    }
}

/**
 * Récupérer l'URL de l'image featured
 */
function mada_get_featured_image_url($post_id = null, $size = 'full') {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    if (has_post_thumbnail($post_id)) {
        $image = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), $size);
        return $image[0];
    }
    
    return get_template_directory_uri() . '/assets/img/placeholder.jpg';
}

/**
 * Afficher les réseaux sociaux
 */
function mada_display_social_links($class = 'social-links') {
    $social_networks = array(
        'facebook' => array('icon' => 'fab fa-facebook-f', 'label' => 'Facebook'),
        'twitter' => array('icon' => 'fab fa-twitter', 'label' => 'Twitter'),
        'linkedin' => array('icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'),
        'instagram' => array('icon' => 'fab fa-instagram', 'label' => 'Instagram'),
        'youtube' => array('icon' => 'fab fa-youtube', 'label' => 'YouTube'),
        'tiktok' => array('icon' => 'fab fa-tiktok', 'label' => 'TikTok')
    );
    
    $output = '<div class="' . esc_attr($class) . '">';
    
    foreach ($social_networks as $network => $data) {
        $url = get_option('social_' . $network);
        if (!empty($url)) {
            $output .= sprintf(
                '<a href="%s" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="%s"><i class="%s"></i></a>',
                esc_url($url),
                esc_attr($data['label']),
                esc_attr($data['icon'])
            );
        }
    }
    
    $output .= '</div>';
    
    echo $output;
}

/**
 * Obtenir le temps de lecture estimé
 */
function mada_get_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // 200 mots par minute
    
    return $reading_time;
}

/**
 * Afficher le temps de lecture
 */
function mada_display_reading_time($post_id = null) {
    $time = mada_get_reading_time($post_id);
    echo '<span class="reading-time"><i class="far fa-clock"></i> ' . $time . ' min de lecture</span>';
}

/**
 * Vérifier si une page a du contenu
 */
function mada_has_content($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    return !empty(trim(strip_tags($content)));
}

/**
 * Générer un breadcrumb
 */
function mada_breadcrumb() {
    if (is_front_page()) {
        return;
    }
    
    $delimiter = '<i class="fas fa-chevron-right" style="font-size: 10px; margin: 0 10px;"></i>';
    $home_text = '<i class="fas fa-home"></i> Accueil';
    
    echo '<div class="breadcrumb" style="padding: 1rem 0; color: var(--muted-foreground); font-size: 14px;">';
    echo '<a href="' . home_url('/') . '" style="color: var(--primary); text-decoration: none;">' . $home_text . '</a>';
    
    if (is_category()) {
        echo $delimiter . 'Catégorie: ' . single_cat_title('', false);
    } elseif (is_single()) {
        $category = get_the_category();
        if ($category) {
            echo $delimiter . '<a href="' . get_category_link($category[0]->term_id) . '" style="color: var(--primary); text-decoration: none;">' . $category[0]->name . '</a>';
        }
        echo $delimiter . get_the_title();
    } elseif (is_page()) {
        if (wp_get_post_parent_id(get_the_ID())) {
            $parent_id = wp_get_post_parent_id(get_the_ID());
            $breadcrumbs = array();
            
            while ($parent_id) {
                $page = get_post($parent_id);
                $breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '" style="color: var(--primary); text-decoration: none;">' . get_the_title($page->ID) . '</a>';
                $parent_id = $page->post_parent;
            }
            
            $breadcrumbs = array_reverse($breadcrumbs);
            foreach ($breadcrumbs as $crumb) {
                echo $delimiter . $crumb;
            }
        }
        echo $delimiter . get_the_title();
    } elseif (is_search()) {
        echo $delimiter . 'Résultats de recherche pour: ' . get_search_query();
    } elseif (is_404()) {
        echo $delimiter . 'Erreur 404';
    } elseif (is_archive()) {
        echo $delimiter . post_type_archive_title('', false);
    }
    
    echo '</div>';
}

/**
 * Formater un numéro de téléphone
 */
function mada_format_phone($phone) {
    // Supprimer tous les caractères non numériques sauf le +
    $phone = preg_replace('/[^0-9+]/', '', $phone);
    return $phone;
}

/**
 * Vérifier si l'email est valide et actif
 */
function mada_is_email_deliverable($email) {
    if (!is_email($email)) {
        return false;
    }
    
    // Vérifier si le domaine existe
    list($user, $domain) = explode('@', $email);
    
    if (!checkdnsrr($domain, 'MX') && !checkdnsrr($domain, 'A')) {
        return false;
    }
    
    return true;
}

/**
 * Obtenir l'adresse IP du visiteur
 */
function mada_get_client_ip() {
    $ip = '';
    
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
    }
    
    // Nettoyer l'IP
    return filter_var($ip, FILTER_VALIDATE_IP) ? $ip : '0.0.0.0';
}

/**
 * Générer un slug unique
 */
function mada_generate_unique_slug($title, $post_type = 'post') {
    $slug = sanitize_title($title);
    $original_slug = $slug;
    $counter = 1;
    
    while (get_page_by_path($slug, OBJECT, $post_type)) {
        $slug = $original_slug . '-' . $counter;
        $counter++;
    }
    
    return $slug;
}

/**
 * Tronquer un texte intelligemment
 */
function mada_truncate_text($text, $length = 100, $append = '...') {
    $text = strip_tags($text);
    
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    
    return $text . $append;
}

/**
 * Convertir une date en format relatif (il y a X jours)
 */
function mada_time_ago($date) {
    $timestamp = is_numeric($date) ? $date : strtotime($date);
    $diff = time() - $timestamp;
    
    if ($diff < 60) {
        return 'À l\'instant';
    } elseif ($diff < 3600) {
        $minutes = floor($diff / 60);
        return $minutes . ' minute' . ($minutes > 1 ? 's' : '');
    } elseif ($diff < 86400) {
        $hours = floor($diff / 3600);
        return 'Il y a ' . $hours . ' heure' . ($hours > 1 ? 's' : '');
    } elseif ($diff < 604800) {
        $days = floor($diff / 86400);
        return 'Il y a ' . $days . ' jour' . ($days > 1 ? 's' : '');
    } elseif ($diff < 2592000) {
        $weeks = floor($diff / 604800);
        return 'Il y a ' . $weeks . ' semaine' . ($weeks > 1 ? 's' : '');
    } elseif ($diff < 31536000) {
        $months = floor($diff / 2592000);
        return 'Il y a ' . $months . ' mois';
    } else {
        $years = floor($diff / 31536000);
        return 'Il y a ' . $years . ' an' . ($years > 1 ? 's' : '');
    }
}

/**
 * Générer une couleur aléatoire
 */
function mada_random_color() {
    return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
}

/**
 * Vérifier si une URL est externe
 */
function mada_is_external_url($url) {
    $site_url = parse_url(home_url(), PHP_URL_HOST);
    $link_url = parse_url($url, PHP_URL_HOST);
    
    return $site_url !== $link_url;
}

/**
 * Obtenir les statistiques du site
 */
function mada_get_site_stats() {
    return array(
        'posts' => wp_count_posts('post')->publish,
        'pages' => wp_count_posts('page')->publish,
        'comments' => wp_count_comments()->approved,
        'users' => count_users()['total_users']
    );
}

/**
 * Sanitize récursivement un tableau
 */
function mada_sanitize_array($array) {
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            $array[$key] = mada_sanitize_array($value);
        } else {
            $array[$key] = sanitize_text_field($value);
        }
    }
    return $array;
}

/**
 * Générer un token de sécurité
 */
function mada_generate_token($length = 32) {
    return bin2hex(random_bytes($length));
}

/**
 * Vérifier si l'utilisateur est admin
 */
function mada_is_admin_user() {
    return current_user_can('manage_options');
}

/**
 * Logger les erreurs personnalisées
 */
function mada_log_error($message, $context = array()) {
    if (defined('WP_DEBUG') && WP_DEBUG) {
        $log_entry = sprintf(
            '[%s] %s | Context: %s',
            date('Y-m-d H:i:s'),
            $message,
            json_encode($context)
        );
        error_log($log_entry);
    }
}

/**
 * Formater un prix
 */
function mada_format_price($price, $currency = 'Ar') {
    return number_format($price, 0, ',', ' ') . ' ' . $currency;
}

/**
 * Obtenir le premier paragraphe d'un contenu
 */
function mada_get_first_paragraph($content) {
    $content = strip_tags($content, '<p>');
    preg_match('/<p>(.*?)<\/p>/', $content, $matches);
    return isset($matches[1]) ? $matches[1] : '';
}

/**
 * Vérifier si on est sur mobile
 */
function mada_is_mobile() {
    return wp_is_mobile();
}

/**
 * Générer un extrait personnalisé
 */
function mada_custom_excerpt($text, $length = 150) {
    if (strlen($text) <= $length) {
        return $text;
    }
    
    $text = strip_tags($text);
    $text = substr($text, 0, $length);
    $text = substr($text, 0, strrpos($text, ' '));
    
    return $text . '...';
}