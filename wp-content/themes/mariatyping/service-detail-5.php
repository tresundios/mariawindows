<?php
/**
 * Template Name: Spa and Relaxation
 * Description: Service 5 - Spa and Relaxation
 */
    get_header('home');
 ?>
        <!-- subheader -->
        <section id="subheader" class="subh-center" data-stellar-background-ratio=".2">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <h1>Spa and Relaxation</h1>
                    </div>
                </div>
            </div>
        </section>
        <!-- subheader close -->

        <!-- content begin -->
        <div id="content" class="no-bottom no-top">
            <section id="services-spa-n-relaxation" aria-label="services-hair" class="side-bg">
                <div class="col-md-6 image-container">
                    <div class="background-image"></div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-7">
                            <p>
  Unwind and relax with our soothing <strong>Hot Oil Body Massage</strong> and indulgent <strong>Spa Treatments</strong>.  
  Melt away tension as our expert therapists restore balance and calm.  
  Enhance your experience with our advanced <strong>Machine Massager</strong> for deep, rejuvenating stress relief.  
  At Maria Beauty Care, relaxation meets revitalization in every session.
</p>

                            <div class="padding40">

                                <div class="sub-item-service">
                                    <div class="c1">Spa</div>
                                    <div class="c2"></div>
                                </div>

                                <div class="sub-item-service">
                                    <div class="c1">Aromatherapy massage</div>
                                    <div class="c2"></div>
                                </div>

                                <div class="sub-item-service">
                                  <div class="c1">Hot Oil Massage</div>
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




