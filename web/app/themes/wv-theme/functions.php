<?php
namespace WVTheme;

// 1) Chargement des traductions
add_action('after_setup_theme', function() {
    load_theme_textdomain(
        'wv-theme',
        get_stylesheet_directory() . '/languages'
    );

    // 2) Support du titre dynamique dans <head>
    add_theme_support('title-tag');

    // 3) Enregistrement des menus
    register_nav_menu('main',   __('Menu principal', 'wv-theme'));
    register_nav_menu('footer', __('Menu de pied',    'wv-theme'));
});

// 4) Chargement des assets (CSS uniquement)
add_action('wp_enqueue_scripts', function() {
    // La feuille de style principale
    wp_enqueue_style(
        'wv-style',
        get_stylesheet_uri(),
        [],
        '1.0.0'
    );
});
