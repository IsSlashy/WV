<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
  <header class="site-header">
    <div class="wrap">
      <div class="branding">
        <a href="<?php echo esc_url( home_url() ); ?>">
          <h1 class="site-title"><?php bloginfo('name'); ?></h1>
        </a>
      </div>
      <nav class="site-nav">
        <?php
          wp_nav_menu([
            'theme_location' => 'main',
            'container'      => false,
            'menu_class'     => 'menu',
          ]);
        ?>
      </nav>
    </div>
  </header>
