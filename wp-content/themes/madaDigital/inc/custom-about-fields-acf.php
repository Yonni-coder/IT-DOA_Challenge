<?php
/**
 * Enregistrement des champs personnalisés pour la page À propos
 * Nécessite le plugin Advanced Custom Fields (ACF)
 */

if( function_exists('acf_add_local_field_group') ):

acf_add_local_field_group(array(
    'key' => 'group_about_page',
    'title' => 'Contenu de la page À propos',
    'fields' => array(
        // Hero Section
        array(
            'key' => 'field_hero_section',
            'label' => 'Section Hero',
            'name' => '',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_hero_badge',
            'label' => 'Badge',
            'name' => 'hero_badge',
            'type' => 'text',
            'default_value' => 'À propos de nous',
        ),
        array(
            'key' => 'field_hero_title',
            'label' => 'Titre',
            'name' => 'hero_title',
            'type' => 'wysiwyg',
            'default_value' => 'Notre <span class="gradient-text">Histoire</span>',
            'toolbar' => 'basic',
            'media_upload' => 0,
        ),
        array(
            'key' => 'field_hero_description',
            'label' => 'Description',
            'name' => 'hero_description',
            'type' => 'textarea',
            'default_value' => 'Découvrez l\'histoire et les valeurs de MADA-Digital, votre partenaire de confiance à Madagascar.',
        ),

        // About Section
        array(
            'key' => 'field_about_section',
            'label' => 'Section À propos',
            'name' => '',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_about_title',
            'label' => 'Titre',
            'name' => 'about_title',
            'type' => 'wysiwyg',
            'default_value' => 'À propos de <span class="gradient-text">MADA-Digital</span>',
            'toolbar' => 'basic',
            'media_upload' => 0,
        ),
        array(
            'key' => 'field_about_description',
            'label' => 'Description',
            'name' => 'about_description',
            'type' => 'textarea',
            'default_value' => 'Depuis 2009, MADA-Digital propose ses services pour tous travaux de développement d\'application web et mobile, d\'installation de réseau informatique intranet et extranet, ainsi que d\'installation de solution de télécommunication.',
        ),
        array(
            'key' => 'field_about_features',
            'label' => 'Caractéristiques',
            'name' => 'about_features',
            'type' => 'repeater',
            'layout' => 'table',
            'button_label' => 'Ajouter une caractéristique',
            'sub_fields' => array(
                array(
                    'key' => 'field_feature_text',
                    'label' => 'Texte',
                    'name' => 'text',
                    'type' => 'text',
                ),
            ),
        ),
        array(
            'key' => 'field_about_image_1',
            'label' => 'Image 1',
            'name' => 'about_image_1',
            'type' => 'image',
            'return_format' => 'array',
        ),
        array(
            'key' => 'field_about_image_2',
            'label' => 'Image 2',
            'name' => 'about_image_2',
            'type' => 'image',
            'return_format' => 'array',
        ),

        // Values Section
        array(
            'key' => 'field_values_section',
            'label' => 'Section Valeurs',
            'name' => '',
            'type' => 'tab',
        ),
        array(
            'key' => 'field_values_title',
            'label' => 'Titre',
            'name' => 'values_title',
            'type' => 'wysiwyg',
            'default_value' => 'Nos <span class="gradient-text">Valeurs</span>',
            'toolbar' => 'basic',
            'media_upload' => 0,
        ),
        array(
            'key' => 'field_company_values',
            'label' => 'Valeurs de l\'entreprise',
            'name' => 'company_values',
            'type' => 'repeater',
            'layout' => 'block',
            'button_label' => 'Ajouter une valeur',
            'sub_fields' => array(
                array(
                    'key' => 'field_value_icon',
                    'label' => 'Icône (classe Font Awesome)',
                    'name' => 'icon',
                    'type' => 'text',
                    'instructions' => 'Ex: fas fa-users, fas fa-lightbulb, fas fa-shield-alt',
                    'default_value' => 'fas fa-star',
                ),
                array(
                    'key' => 'field_value_title',
                    'label' => 'Titre',
                    'name' => 'title',
                    'type' => 'text',
                ),
                array(
                    'key' => 'field_value_description',
                    'label' => 'Description',
                    'name' => 'description',
                    'type' => 'textarea',
                ),
            ),
        ),
    ),
    'location' => array(
        array(
            array(
                'param' => 'page_template',
                'operator' => '==',
                'value' => 'page-a-propos.php',
            ),
        ),
    ),
));

endif;
?>