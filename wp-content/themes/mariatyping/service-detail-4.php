<?php
/**
 * Template Name: Hand, Foot, and Nail Care
 * Description: Service 4 - Hand, Foot, and Nail Care
 */
    get_header('home');
 ?>
        <!-- subheader -->
        <section id="subheader" class="subh-center" data-stellar-background-ratio=".2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Hand, Foot, and Nail Care</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- subheader close -->

        <!-- content begin -->
        <div id="content" class="no-bottom no-top">
            <section id="services-hand-foot-nail-care" aria-label="services-hair" class="side-bg">
                <div class="col-md-6 image-container">
                    <div class="background-image"></div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-7">
                            <p>
  Pamper your hands and feet with luxurious <strong>Manicures</strong> and <strong>Pedicures</strong>.  
  Our treatments relax, refresh, and restore your skin and nails.  
  Add the perfect touch with our precision <strong>Nail Shaper</strong> service.  
  At Maria Beauty Care, every detail leaves you feeling polished and flawless.
</p>

                            <div class="padding40">

                                <div class="sub-item-service">
                                    <div class="c1">Pedicure</div>
                                    <div class="c2"></div>
                                </div>

                                <div class="sub-item-service">
                                    <div class="c1">Manicure</div>
                                    <div class="c2"></div>
                                </div>

                                <div class="sub-item-service">
                                  <div class="c1">Nail Shaper</div>
                                  <div class="c2"></div>
                                </div>

                                <div class="sub-item-service">
                                  <div class="c1">Foot peel treatment</div>
                                  <div class="c2"></div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>

              <!-- section begin -->
           <?php get_template_part('template-parts/offer-and-appointment'); ?>
            <!-- section close -->


        </div>
<?php
// Include the footer
get_footer('home');
// Close the wrapper div
?>




