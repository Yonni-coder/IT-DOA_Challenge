<?php 

function mdc_register_post_types () {

    register_post_type("service", [
        "labels" => [
            "name" => "Services",
            "singular_name" => "Service",
            "add_new_item" => "Ajouter un service",
            "edit_item" => "Modifier un le service"
        ],
        "public" => true,
        "has_archive" => true,
        "menu_icon" => "dashicons-admin-tools",
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'services'],
        'show_in_rest' => true
    ]);

    register_post_type('projet', [
        'labels' => [
            'name' => 'Réalisations',
            'singular_name' => 'Réalisation',
            'add_new_item' => 'Ajouter une réalisation',
            'edit_item' => 'Modifier la réalisation',
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-portfolio',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite' => ['slug' => 'realisations'],
        'show_in_rest' => true
    ]);

    register_post_type('testimonial', [
        'labels' => [
            'name' => 'Témoignages',
            'singular_name' => 'Témoignage',
            'add_new_item' => 'Ajouter un témoignage',
            'edit_item' => 'Modifier le témoignage',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-format-quote',
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
    ]);

    register_post_type('evenement', [
        'labels' => [
            'name' => 'Événements',
            'singular_name' => 'Événement',
            'add_new_item' => 'Ajouter un événement',
            'edit_item' => 'Modifier l\'événement',
        ],
        'public' => true,
        'has_archive' => true,
        'menu_icon' => 'dashicons-calendar-alt',
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'rewrite' => ['slug' => 'evenements'],
        'show_in_rest' => true
    ]);

    register_post_type('partenaire', [
        'labels' => [
            'name' => 'Partenaires',
            'singular_name' => 'Partenaire',
            'add_new_item' => 'Ajouter un partenaire',
            'edit_item' => 'Modifier le partenaire',
        ],
        'public' => true,
        'menu_icon' => 'dashicons-groups',
        'supports' => ['title', 'thumbnail'],
        'show_in_rest' => true
    ]);

}

add_action("init", "mdc_register_post_types");

?>