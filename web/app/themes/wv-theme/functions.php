<?php
namespace WVTheme;

add_action('after_setup_theme', function() {
  // 1) Load translations
  load_theme_textdomain(
    'wv-theme',
    get_stylesheet_directory() . '/languages'
  );

  // 2) Dynamic title tag support
  add_theme_support('title-tag');

  // 3) Register menus
  register_nav_menu(
    'main',
    __('Menu principal', 'wv-theme')
  );
  register_nav_menu(
    'footer',
    __('Menu de pied',    'wv-theme')
  );
});

// Enqueue your styles/scripts as before...
add_action('wp_enqueue_scripts', function() {
  wp_enqueue_style(
    'wv-style',
    get_stylesheet_uri(),
    [],
    '1.0.0'
  );
  wp_enqueue_script(
    'wv-lazyload',
    get_theme_file_uri('/js/lazyload.js'),
    [],
    '1.0.0',
    true
  );
});
