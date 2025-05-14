<?php
/**
 * Template Name: Services Home
 * Description: Services Page for Maria Beauty Care
 */
    get_header('home');
 ?>

<!-- subheader -->
    <section id="subheader" class="subh-center" data-stellar-background-ratio=".2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Our Services</h1>
                    <h4>Discover What We Do</h4>
                </div>
            </div>
        </div>
    </section>
<!-- subheader close -->
    <!-- content begin -->
        <div id="content" class="no-bottom no-top">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-sm-6 col-xs-6 text-center">
                            <div class="picframe">
                                <a href="service-details-1.html">
                                    <span class="overlay img-circle">
                                        <span class="pf_text">
                                            <span class="project-name">View All Services</span>
                                        </span>
                                    </span>
                                </a>

                                <img src="<?php echo get_template_directory_uri(); ?>/assets/services/1-hair-treatments.jpg" alt=""  class="img-circle" />
                            </div>

                            <div class="spacer-single"></div>
                            <h3>Hair Treatments</h3>
                            <p>Revitalize hair with Dye, Keratin, Scalp Exfoliation. Hair Spa, Hot Oil Scalp Massage ensure vibrancy.</p>
                            <div class="spacer-half"></div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-6 text-center">
                            <div class="picframe">
                                <a href="service-details-2.html">
                                    <span class="overlay  img-circle">
                                        <span class="pf_text">
                                            <span class="project-name">View All Services</span>
                                        </span>
                                    </span>
                                </a>

                                <img src="<?php echo get_template_directory_uri(); ?>/assets/services/2-hair-style.jpg" alt="" class="img-circle" />
                            </div>
                            <div class="spacer-single"></div>
                            <h3>Hair Styling</h3>
                            <p>Get perfect Baby Cuts or creative Curling. Our stylists craft personalized looks for any occasion.</p>
                            <div class="spacer-half"></div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-6 text-center">
                            <div class="picframe">
                                <a href="service-details-3.html">
                                    <span class="overlay img-circle">
                                        <span class="pf_text ">
                                            <span class="project-name">View All Services</span>
                                        </span>
                                    </span>
                                </a>

                                <img src="<?php echo get_template_directory_uri(); ?>/assets/services/3-skin-care-treatments.jpg" alt="" class="img-circle" />
                            </div>
                            <div class="spacer-single"></div>
                            <h3>Skin Care and Treatments</h3>
                            <p>Glow with Facials, Waxing, or Pimple Treatments. Ultra Sonic and Peel-Off Masks refresh skin beautifully.</p>
                            <div class="spacer-half"></div>
                        </div>


                        <div class="col-md-4 col-sm-6 col-xs-6 text-center">
                            <div class="picframe">
                                <a href="service-details-4.html">
                                    <span class="overlay img-circle">
                                        <span class="pf_text">
                                            <span class="project-name">View All Services</span>
                                        </span>
                                    </span>
                                </a>

                                <img src="<?php echo get_template_directory_uri(); ?>/assets/services/4-hand-foot-nail.jpg" alt="" class="img-circle" />
                            </div>

                            <div class="spacer-single"></div>
                            <h3>Hand, Foot, and Nail Care</h3>
                            <p>Pamper hands and feet with Pedicures, Manicures. Nail Shaper adds a flawless finish.</p>
                            <div class="spacer-half"></div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-6 text-center">
                            <div class="picframe">
                                <a href="service-details-5.html">
                                    <span class="overlay img-circle">
                                        <span class="pf_text">
                                            <span class="project-name">View All Services</span>
                                        </span>
                                    </span>
                                </a>

                                <img src="<?php echo get_template_directory_uri(); ?>/assets/services/5-spa-relaxation.jpg" alt="" class="img-circle"/>
                            </div>
                            <div class="spacer-single"></div>
                            <h3>Spa and Relaxation</h3>
                            <p>Unwind with Hot Oil Body Massage, Spa. Machine Massager offers rejuvenating stress relief.</p>
                            <div class="spacer-single"></div>
                        </div>

                        <div class="col-md-4 col-sm-6 col-xs-6 text-center">
                            <div class="picframe">
                                <a href="service-details-6.html">
                                    <span class="overlay img-circle">
                                        <span class="pf_text">
                                            <span class="project-name">View All Services</span>
                                        </span>
                                    </span>
                                </a>

                                <img src="<?php echo get_template_directory_uri(); ?>/assets/services/6-saree-draping.jpg" alt="" class="img-circle" />
                            </div>
                            <div class="spacer-single"></div>
                            <h3>Makeup and Styling</h3>
                            <p>Shine with Makeup, Saree Draping. We create stunning looks for any event.</p>
                            <div class="spacer-half"></div>
                        </div>

                        <div class="clearfix"></div>
                    </div>
                </div>
            </section>


            <!-- section begin -->
            <section id="cta" aria-label="cta" class="call-to-action bg-color-2 wow fadeInLeftBig text-light">
                <div class="container">
                    <div class="row">
                        <div class="col-md-9 mt10">
                            <h3><i class="fa fa-phone mr10"></i>Contact us now and get special offers!</h3>
                        </div>

                        <div class="col-md-3 text-right">
                            <a href="booking.html" class="btn btn-line-white btn-big">Make Appointment Now</a>
                        </div>
                    </div>
                </div>
            </section>
            <!-- section close -->




        </div>

<?php
// Include the footer
get_footer('home');
// Close the wrapper div
?>






