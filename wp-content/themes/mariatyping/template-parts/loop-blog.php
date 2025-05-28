<!-- your-theme/parts/loop-blog.php -->
<div class="blog-posts">
    <?php 
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
        $args = array(
            'post_type' => 'post',
            'posts_per_page' => 5, // Limit to 5 posts per page
            'paged' => $paged,
        );
        $blog_query = new WP_Query($args);
        if ($blog_query->have_posts()) :
         while ($blog_query->have_posts()) : $blog_query->the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                
                    <span><?php echo get_the_date(); ?> by <?php the_author(); ?></span>
                
                <div class="post-excerpt">
                    <?php the_excerpt(); ?>
                </div>
                <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
            </article>
        <?php endwhile; ?>
         <div class="pagination">
            <?php
                echo paginate_links(array(
                    'total' => $blog_query->max_num_pages,
                    'current' => $paged,
                    'prev_text' => __('Previous', 'mariatyping'),
                    'next_text' => __('Next', 'mariatyping'),
                ));
                ?>
        </div>
    <?php else : ?>
        <p>No posts found.</p>
    <?php endif; ?>
</div>