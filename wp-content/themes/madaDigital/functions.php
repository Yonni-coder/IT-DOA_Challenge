<?php
add_action('after_setup_theme', 'mdc_setup');

    function mdc_setup(){
        
        add_theme_support('menus');
        add_theme_support('title-tag');
        register_nav_menus([
            'menu'=> 'Menu principal',
        ]);

    };

    function enqueue_custom_scripts() {
        wp_register_script('app-script', get_template_directory_uri() . '/app.js', [], null, true);
        wp_enqueue_script('app-script');
    };

    add_action('wp_enqueue_scripts', 'enqueue_custom_scripts');
    add_filter("show_admin_bar", "__return_false");
    
;?>