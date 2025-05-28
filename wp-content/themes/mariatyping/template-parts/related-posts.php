<!-- your-theme/parts/related-posts.php -->
<div class="related-posts">
    <h2>Related Posts</h2>
    <?php
    $categories = get_the_category();
    $category_ids = wp_list_pluck($categories, 'term_id');
    $args = array(
        'post_type' => 'post',
        'posts_per_page' => 3,
        'post__not_in' => array(get_the_ID()), // Exclude current post
        'category__in' => $category_ids,
    );
    $related_query = new WP_Query($args);
    if ($related_query->have_posts()) :
        while ($related_query->have_posts()) : $related_query->the_post();
    ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <?php if (has_post_thumbnail()) : ?>
                    <div class="post-thumbnail">
                        <?php the_post_thumbnail('thumbnail'); ?>
                    </div>
                <?php endif; ?>
                <div class="post-excerpt">
                    <?php the_excerpt(); ?>
                </div>
            </article>
    <?php
        endwhile;
        wp_reset_postdata();
    else :
    ?>
        <p>No related posts found.</p>
    <?php endif; ?>
</div>