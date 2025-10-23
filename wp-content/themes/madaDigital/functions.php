<?php

    add_action('after_setup_theme', 'mdc_setup');

    function mdc_setup(){
        add_theme_support('menus');
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');

        add_theme_support('editor-styles');
        add_theme_support('wp-block-styles');
        add_theme_support('align-wide');
        add_theme_support('responsive-embeds');

        register_nav_menus([
            'Menu principal' => 'Menu principal',
            'Menu mobile' => 'Menu mobile',
        ]);
    }

    require_once get_template_directory() . '/inc/custom-post-types.php';
    require_once get_template_directory() . '/inc/custom-fields-gutenberg.php';

    function enqueue_custom_scripts() {
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
?>