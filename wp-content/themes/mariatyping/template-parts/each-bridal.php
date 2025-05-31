<?php
/**
 * Gallery item template part
 *
 * Expected variables:
 * @param string $image_url - Full image URL
 * @param string $image_title - Title for the image
 */

// Provide fallback values if not set
$image_url   = isset($args['image_url']) ? esc_url($args['image_url']) : '';
$image_title = isset($args['image_title']) ? esc_html($args['image_title']) : '';
?>

                    <div class="item haircut">
                        <div class="picframe">
                            <a href="<?php echo esc_url($image_url); ?>" title="<?php echo esc_attr($image_title); ?>">
                                <span class="overlay">
                                    <span class="pf_text">
                                        <span class="project-name"><?php echo esc_html($image_title); ?></span>
                                    </span>
                                </span>
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($image_title); ?>" />
                            </a>
                        </div>
                    </div>