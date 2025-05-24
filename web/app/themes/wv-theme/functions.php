<?php
namespace WVTheme;
add_action('after_setup_theme', function() {
  add_theme_support('title-tag');
  register_nav_menu('main', __('Menu principal','wv-theme'));
});
