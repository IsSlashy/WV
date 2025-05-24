<?php
namespace WVTheme;

// Support du titre dynamique
add_action('after_setup_theme', function() {
  add_theme_support('title-tag');
  register_nav_menu('main', __('Menu principal','wv-theme'));
});

// Enqueue style & script lazyload
add_action('wp_enqueue_scripts', function() {
  wp_enqueue_style('wv-style', get_stylesheet_uri(), [], '1.0.0');
  wp_enqueue_script(
    'wv-lazyload',
    get_theme_file_uri('/js/lazyload.js'),
    [],
    '1.0.0',
    true
  );
});
