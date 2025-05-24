<?php get_header(); ?>
<main>
  <?php if (have_posts()): while(have_posts()): the_post(); ?>
    <article id=\"post-<?php the_ID(); ?>\">
      <h1><?php the_title(); ?></h1>
      <?php the_content(); ?>
    </article>
  <?php endwhile; else: ?>
    <p>Aucun contenu pour le moment.</p>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
