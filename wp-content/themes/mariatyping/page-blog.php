<?php
/*
Template Name: Blog Page
*/
get_header('home'); ?>

<!-- subheader -->
  <style>
    #subheader {
    background-image: url('<?php echo get_template_directory_uri(); ?>/assets/images/background/subheader-5.jpg') !important;
}
</style>
<section id="subheader" class="subh-center" data-stellar-background-ratio=".2">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Blog Home</h1>
            </div>
        </div>
    </div>
</section>
<!-- subheader close -->
<div id="content">
 <div class="container">
    <?php
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    query_posts('post_type=post&paged=' . $paged);
    get_template_part('template-parts/loop-blog');
    wp_reset_query();
    ?>
    </div>
</div>
     <!-- section begin -->
           <?php get_template_part('template-parts/offer-and-appointment'); ?>
            <!-- section close -->

<?php get_footer('home'); ?>