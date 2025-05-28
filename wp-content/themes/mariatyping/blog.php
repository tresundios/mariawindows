<?php 
/**
 * Template Name: Blog List
 * Description: Blog List
 */

get_header('home'); ?>
<!-- subheader -->
        <section id="subheader" class="subh-center" data-stellar-background-ratio=".2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>News</h1>
                        <h4>Latest From Us</h4>
                    </div>
                </div>
            </div>
        </section>
        <!-- subheader close -->
    <?php get_template_part('template-parts/loop-blog'); ?>
</main>
<?php get_footer('home'); ?>