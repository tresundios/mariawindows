<?php
/**
 * Template Name: Contact
 * Description: Contact
 */
    get_header('home');
    get_template_part('template-parts/banner','contact');
?>
<!-- content begin -->
<div id="content" class="no-top no-bottom">

<!-- section begin -->
    <section id="section-map" aria-label="section-map" class="no-top no-bottom">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3949.281163449706!2d77.40053247461964!3d8.174404191856683!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b04f1baa1e977e5%3A0x4f9d113b97bae06f!2sMaria%20Beauty%20Care!5e0!3m2!1sen!2sin!4v1748417979101!5m2!1sen!2sin" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
<!-- section close -->

</div>
  <!-- section begin -->
           <?php get_template_part('template-parts/offer-and-appointment'); ?>
            <!-- section close -->
<?php
// Include the footer
get_footer('home');
// Close the wrapper div
?>



