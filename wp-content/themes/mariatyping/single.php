<!-- your-theme/single.php -->
<?php get_header('home'); ?>
       <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <section id="subheader" class="subh-center" data-stellar-background-ratio=".2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                          <h1><?php the_title(); ?></h1>
                        <h4>Posted on <?php echo get_the_date(); ?> by <?php the_author(); ?></h4>
                    </div>
                </div>
            </div>
        </section>


        
              
           
            
       

            <div  id="content" >
              <div class="container">
                <?php the_content(); ?>
                    </div>
            </div>

  <?php endwhile; else : ?>
        <p>No post found.</p>
    <?php endif; ?>
     <!-- section begin -->
           <?php get_template_part('template-parts/offer-and-appointment'); ?>
            <!-- section close -->

<?php get_footer('home'); ?>