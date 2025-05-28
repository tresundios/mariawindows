<!-- your-theme/home.php -->
<?php get_header('home'); ?>
<main>
    <h1>Blog</h1>
    <?php get_template_part('parts/loop-blog'); ?>
</main>
<?php get_footer('home'); ?>