<?php
/**
 * Testimonial item template part
 *
 * Expected variables:
 * @param string $client_name - Client Name
 * @param string $image_url - Full Image URL
 * @param string $review - Client Review
 */

// Provide fallback values if not set
$client_name = isset($args['client_name']) ? esc_html($args['client_name']) : '';
$image_url = isset($args['image_url']) ? esc_url($args['image_url']) : '';
$review   = isset($args['review']) ? esc_html($args['review']) : '';

?>
<div class="col-md-4 marginbottom30 item">
    <div class="de_testi">
        <blockquote>
            <p><?php echo $review; ?></p>
        </blockquote>
        <div class="de_testi_by">
            <span class="de_testi_pic">
                <img src="<?php echo esc_url($image_url); ?>" alt="" class="img-circle"></span>
            <div class="de_testi_company">
                <strong><?php echo $client_name; ?></strong>, Maria Beauty Care Customer
            </div>
        </div>
    </div>
</div>