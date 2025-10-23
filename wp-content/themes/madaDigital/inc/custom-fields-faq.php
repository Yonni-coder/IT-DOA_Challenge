<?php 

/**
 * Enregistrement du Custom Post Type FAQ
 * À placer dans functions.php ou dans un plugin custom
 */

function register_faq_post_type() {
    $labels = array(
        'name'                  => 'FAQ',
        'singular_name'         => 'Question',
        'menu_name'             => 'FAQ',
        'name_admin_bar'        => 'Question FAQ',
        'add_new'               => 'Ajouter',
        'add_new_item'          => 'Ajouter une question',
        'new_item'              => 'Nouvelle question',
        'edit_item'             => 'Modifier la question',
        'view_item'             => 'Voir la question',
        'all_items'             => 'Toutes les questions',
        'search_items'          => 'Rechercher',
        'not_found'             => 'Aucune question trouvée',
        'not_found_in_trash'    => 'Aucune question dans la corbeille'
    );

    $args = array(
        'labels'                => $labels,
        'public'                => true,
        'publicly_queryable'    => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'query_var'             => true,
        'rewrite'               => array('slug' => 'faq'),
        'capability_type'       => 'post',
        'has_archive'           => true,
        'hierarchical'          => false,
        'menu_position'         => 20,
        'menu_icon'             => 'dashicons-editor-help',
        'show_in_rest'          => true, // Active Gutenberg
        'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'revisions'),
    );

    register_post_type('faq', $args);
}
add_action('init', 'register_faq_post_type');

/**
 * Enregistrement de la taxonomie "Catégorie FAQ"
 */
function register_faq_taxonomy() {
    $labels = array(
        'name'              => 'Catégories FAQ',
        'singular_name'     => 'Catégorie',
        'search_items'      => 'Rechercher',
        'all_items'         => 'Toutes les catégories',
        'parent_item'       => 'Catégorie parente',
        'parent_item_colon' => 'Catégorie parente:',
        'edit_item'         => 'Modifier',
        'update_item'       => 'Mettre à jour',
        'add_new_item'      => 'Ajouter une catégorie',
        'new_item_name'     => 'Nouvelle catégorie',
        'menu_name'         => 'Catégories',
    );

    $args = array(
        'hierarchical'      => true,
        'labels'            => $labels,
        'show_ui'           => true,
        'show_admin_column' => true,
        'show_in_rest'      => true, // Active dans Gutenberg
        'query_var'         => true,
        'rewrite'           => array('slug' => 'categorie-faq'),
    );

    register_taxonomy('faq_category', array('faq'), $args);
}
add_action('init', 'register_faq_taxonomy');

/**
 * Flush rewrite rules à l'activation
 */
function faq_rewrite_flush() {
    register_faq_post_type();
    register_faq_taxonomy();
    flush_rewrite_rules();
}
register_activation_hook(__FILE__, 'faq_rewrite_flush');

?>