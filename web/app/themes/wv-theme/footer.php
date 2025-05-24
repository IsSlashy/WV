  <footer class="site-footer">
    <div class="wrap">
      <?php if ( has_nav_menu('footer') ) : ?>
        <nav class="footer-nav">
          <?php
            wp_nav_menu([
              'theme_location' => 'footer',
              'container'      => false,
              'menu_class'     => 'menu menu--footer',
            ]);
          ?>
        </nav>
      <?php endif; ?>
      <p class="copyright">
        &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>
      </p>
    </div>
  </footer>
  <?php wp_footer(); ?>
</body>
</html>
