<?php
/**
 * Functions and definitions for Mada Digital Theme
 *
 * @package Mada_Digital
 */

// Empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

// Définir les constantes du thème
define('MADA_VERSION', '1.0.0');
define('MADA_THEME_DIR', get_template_directory());
define('MADA_THEME_URI', get_template_directory_uri());
define('MADA_INC_DIR', MADA_THEME_DIR . '/inc');

/**
 * Inclure les fichiers du thème
 */
require_once MADA_INC_DIR . '/contact-functions.php';
require_once MADA_INC_DIR . '/newsletter-functions.php';
require_once MADA_INC_DIR . '/admin-options.php';
require_once MADA_INC_DIR . '/contact-messages-admin.php';  
require_once MADA_INC_DIR . '/helpers.php';

add_action('after_setup_theme', 'mdc_setup');

    function mdc_setup(){
        add_theme_support('menus');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        register_nav_menus([
            'Menu principal' => 'Menu principal',
            'Menu mobile' => 'Menu mobile',
        ]);

        // Ajouter le support des templates de page
        add_theme_support('page-templates');
    }

    function enqueue_custom_scripts() {
        // Chargement du CSS principal du thème
        wp_enqueue_style(
            'mada-digital-style',
            get_template_directory_uri() . '/style.css',
            [],
            filemtime(get_template_directory() . '/style.css')
        );
        
        wp_enqueue_style(
            'font-awesome', 
            'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'
        );
        
        wp_enqueue_script(
            'app-script', 
            get_template_directory_uri() . '/app.js', 
            [], 
            filemtime(get_template_directory() . '/app.js'),
            true
        );
    }

    add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');

    function add_nav_link_class($atts, $item, $args) {
        if($args->theme_location == 'Menu principal') {
            $class = 'nav-link';
            if (in_array('current-menu-item', $item->classes) || in_array('current_page_item', $item->classes)) {
                $class .= ' active';
            }
            $atts['class'] = $class;
        }
        
        // Filtres pour le menu mobile
        if($args->theme_location == 'Menu mobile') {
            $class = 'mobile-nav-link';
            if (in_array('current-menu-item', $item->classes) || in_array('current_page_item', $item->classes)) {
                $class .= ' active';
            }
            $atts['class'] = $class;
        }
        
        return $atts;
    }
    add_filter('nav_menu_link_attributes', 'add_nav_link_class', 10, 3);

    function add_span_to_nav_title($title, $item, $args, $depth) {
        if($args->theme_location == 'Menu principal') {
            return '<span>' . $title . '</span>';
        }
        return $title;
    }
    add_filter('nav_menu_item_title', 'add_span_to_nav_title', 10, 4);

    function simplify_nav_menu($var) {
        return is_array($var) ? array_intersect($var, array('current-menu-item', 'current_page_item')) : $var;
    }
    add_filter('nav_menu_css_class', 'simplify_nav_menu', 100, 1);
    add_filter("show_admin_bar", "__return_false");

    // Ajouter une page d'options pour les statistiques
function mon_theme_stats_menu() {
    add_theme_page(
        'Statistiques du site',
        'Statistiques',
        'edit_theme_options',
        'theme-stats',
        'mon_theme_stats_page'
    );
}
add_action('admin_menu', 'mon_theme_stats_menu');

// Afficher le formulaire dans l'admin
function mon_theme_stats_page() {
    // Sauvegarder les données
    if (isset($_POST['save_stats'])) {
        check_admin_referer('save_theme_stats');
        update_option('theme_stats_experience', sanitize_text_field($_POST['stat_experience']));
        update_option('theme_stats_projets', sanitize_text_field($_POST['stat_projets']));
        update_option('theme_stats_clients', sanitize_text_field($_POST['stat_clients']));
        update_option('theme_stats_support', sanitize_text_field($_POST['stat_support']));
        echo '<div class="updated"><p>Statistiques mises à jour !</p></div>';
    }
    
    // Récupérer les valeurs actuelles
    $experience = get_option('theme_stats_experience', '15');
    $projets = get_option('theme_stats_projets', '200');
    $clients = get_option('theme_stats_clients', '50');
    $support = get_option('theme_stats_support', '24/7');
    ?>
    <div class="wrap">
        <h1>Gérer les statistiques</h1>
        <form method="post">
            <?php wp_nonce_field('save_theme_stats'); ?>
            <table class="form-table">
                <tr>
                    <th><label for="stat_experience">Années d'expérience</label></th>
                    <td><input type="text" name="stat_experience" id="stat_experience" value="<?php echo esc_attr($experience); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="stat_projets">Projets réalisés</label></th>
                    <td><input type="text" name="stat_projets" id="stat_projets" value="<?php echo esc_attr($projets); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="stat_clients">Clients satisfaits</label></th>
                    <td><input type="text" name="stat_clients" id="stat_clients" value="<?php echo esc_attr($clients); ?>" class="regular-text"></td>
                </tr>
                <tr>
                    <th><label for="stat_support">Support disponible</label></th>
                    <td><input type="text" name="stat_support" id="stat_support" value="<?php echo esc_attr($support); ?>" class="regular-text"></td>
                </tr>
            </table>
            <?php submit_button('Enregistrer les statistiques', 'primary', 'save_stats'); ?>
        </form>
    </div>
    <?php
}

/**
 * Améliorer la sécurité des emails
 */
function mada_wp_mail_from($original_email_address) {
    $domain = parse_url(home_url(), PHP_URL_HOST);
    return 'noreply@' . $domain;
}
// add_filter('wp_mail_from', 'mada_wp_mail_from'); // Décommenter si nécessaire

function mada_wp_mail_from_name($original_email_from) {
    return get_bloginfo('name');
}
add_filter('wp_mail_from_name', 'mada_wp_mail_from_name');

/**
 * Ajouter le support des SVG
 */
function mada_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['svgz'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'mada_mime_types');

/**
 * Logger personnalisé pour le débogage
 */
function mada_log($message, $type = 'info') {
    if (defined('WP_DEBUG') && WP_DEBUG === true) {
        $log_message = sprintf(
            '[%s] [%s] %s',
            date('Y-m-d H:i:s'),
            strtoupper($type),
            is_array($message) || is_object($message) ? print_r($message, true) : $message
        );
        error_log($log_message);
    }
}

/**
 * Optimisations pour les performances
 */
// Désactiver les emojis si non nécessaires
function mada_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
}
// add_action('init', 'mada_disable_emojis'); // Décommenter pour désactiver

/**
 * Nettoyer le header WordPress
 */
function mada_cleanup_header() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
}
add_action('init', 'mada_cleanup_header');

/**
 * Notification admin pour les nouveaux messages de contact
 */
function mada_notify_new_contact_message($message_id) {
    // Cette fonction peut être appelée après l'insertion d'un message
    // pour envoyer une notification supplémentaire
    do_action('mada_new_contact_message', $message_id);
}