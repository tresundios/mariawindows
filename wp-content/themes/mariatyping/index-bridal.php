<?php
/**
 * Template Name: Bridal Home
 * Description: Bridal Home Page for Maria Beauty Care
 */
    get_header('home');
 ?>
        <!-- content begin -->
        <div id="content" class="no-bottom no-top">

            <!-- revolution slider begin -->
            <section id="section-slider" aria-label="section-slider" class="fullwidthbanner-container">
                <div id="revolution-slider">
                    <ul>
                        <li data-transition="boxfade" data-slotamount="10" data-masterspeed="800" data-thumb="">
                            <!--  BACKGROUND IMAGE -->
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/bridal/1.jpg" alt="" />

                            <div class="tp-caption big-white sfb"
                                data-x="center"
                                data-y="260"
                                data-speed="1000"
                                data-start="800"
                                data-easing="easeInOutExpo"
                                data-endspeed="450">
                                Personalized looks to highlight your unique beauty and style.
                            </div>

                            <div class="tp-caption ultra-big-white sfb"
                                data-x="center"
                                data-y="190"
                                data-speed="1200"
                                data-start="600"
                                data-easing="easeInOutExpo"
                                data-endspeed="400">
                                Flawless Bridal Makeup
                            </div>

                            <div class="tp-caption sfb"
                                data-x="center"
                                data-y="320"
                                data-speed="1000"
                                data-start="1100"
                                data-easing="easeInOutExpo">
                                <a href="#section-gallery" class="btn-slider">Explore Bridal Looks
                                </a>
                            </div>
                        </li>

                    
                        <li data-transition="boxfade" data-slotamount="10" data-masterspeed="800" data-thumb="">
                            <!--  BACKGROUND IMAGE -->
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/bridal/3.jpg" alt="" />

                            <div class="tp-caption big-white sfb"
                                data-x="center"
                                data-y="260"
                                data-speed="1000"
                                data-start="800"
                                data-easing="easeInOutExpo"
                                data-endspeed="450">
                               Elegant updos and romantic curls crafted for your dream day.
                            </div>

                            <div class="tp-caption ultra-big-white sfb"
                                data-x="center"
                                data-y="190"
                                data-speed="1200"
                                data-start="600"
                                data-easing="easeInOutExpo"
                                data-endspeed="400">
                                Stunning Bridal Hairstyles
                            </div>

                            <div class="tp-caption sfb"
                                data-x="center"
                                data-y="320"
                                data-speed="1000"
                                data-start="1100"
                                data-easing="easeInOutExpo">
                                <a href="#bridal-packages" class="btn-slider">Check affordable packages
                                </a>
                            </div>
                        </li>

         
                    </ul>
                </div>
            </section>
            <!-- revolution slider close -->


            
             <!-- section begin -->
            <?php get_template_part('template-parts/time-and-address'); ?>
            <!-- section close -->
            
  
  <!-- section begin -->
              <!-- section begin -->
            <?php get_template_part('template-parts/offer-and-appointment'); ?>
            <!-- section close -->
            <!-- section close -->

         
          
            <!-- section begin -->
            <section id="section-gallery" aria-label="section-gallery" class="no-top no-bottom">
                <div class="col-12  text-center" style="padding-top:40px;padding-bottom:20px;">
                    <h1>Our Beauty Moments</h1>
                    <div class="small-border" data-wow-delay=".3s" data-wow-duration=".3s"></div>
                    <h4>Real clients, real beauty—experience the Maria Beauty Care touch. </h4>
                </div>
                <div id="gallery" class="gallery zoom-gallery gallery-3-cols wow fadeInUp" data-wow-delay=".3s">

                <?php
                // Loop to show 11 gallery items
                for ($i = 1; $i <= 11; $i++) :
                    // Pad numbers like 01, 02, ..., 11
                    $img_number = str_pad($i, 2, '0', STR_PAD_LEFT);
                    $image_url = get_template_directory_uri() . "/assets/bridal_maria/bridal_$img_number.jpg";
                    $image_title = "Maria Bridal Makeup $i";
                ?>
                    <?php get_template_part('template-parts/each-bridal', null, ['image_url'=> $image_url,'image_title' => $image_title]); ?>
                    <!-- close gallery item -->
                <?php endfor; ?>



                </div>
            </section>
            
            <!-- section close -->
            <!-- section close -->

            <!-- section begin -->

            <div class="container" style="padding-top:30px" id="bridal-packages">
                <div class="col-12  text-center">
                    <h1>Bridal Bliss Packages</h1>
                    <div class="small-border" data-wow-delay=".3s" data-wow-duration=".3s"></div>
                    <h4>Transform into the bride you’ve always envisioned, with beauty services tailored just for you.  </h4>
                </div>
                <div class="row table-set  wow fadeInUp" >
                                <div class="col-md-4">
                        <!-- package begin -->
                        <div class="table package text-center">
                            <div class="c1">
                                <h2>Regular</h2>
                                <ul class="list">
                                    <li>Full Body Polishing (Basic)</li>
                                    <li>Full Body Waxing (Basic)</li>
                                    <li>Bridal Special Silver Facial</li>
                                    <li>Face D-Tan Bleach</li>
                                    <li>Pedicure (Basic)</li>
                                    <li>Manicure (Basic)</li>
                                    <li>Hair Trim</li>
                                    <li>Hair Deep Conditioning</li>
                                    <li>Threading (All)</li>
                                    <li>-</li><li>-</li><li>-</li><li>-</li><li></li>
                                </ul>
                            </div>

                         
                          <div class="c2">
                                <strong>Now Only</strong>
                                <h3 class="price">8,999&#8377;</h3>
                                (normally 10,999&#8377;)
                            </div>


                            <div class="c3">
                                <a href="booking/" class="btn-line">Book Now</a>
                            </div>

                        </div>
                        <!-- package close -->
                    </div>
                    <div class="col-md-4">
                        <!-- package begin -->
                        <div class="table package text-center">
                            <div class="c1">
                                <h2>Classic</h2>
                                <ul class="list">
                                    <li>Full Body Polishing (Premium)</li>
                                    <li>Full Body Waxing Rica</li>
                                    <li>Bridal Special D-Toxifying Gold Facial with Power Mask</li>
                                    <li>Aroma Pedicure</li>
                                    <li>Aroma Manicure</li>
                                    <li>Hir Cut (Style Change)</li>
                                    <li>Threading (All)</li>
                                    <li>Face De-Tan</li>
                                    <li>Hair Spa</li>
                                    <li>-</li><li>-</li><li>-</li><li></li><li></li>
                                </ul>
                            </div>

                            <div class="c2">
                                <strong>Now Only</strong>
                                <h3 class="price">12,999&#8377;</h3>
                                (normally 14,999&#8377;)
                            </div>

                            <div class="c3">
                                <a href="booking/" class="btn-line">Book Now</a>
                            </div>

                        </div>
                        <!-- package close -->
                    </div>

                    <div class="col-md-4">
                        <!-- package begin -->
                        <div class="table package text-center">
                            <div class="c1">
                                <h2>Luxury Premium</h2>
                                <ul class="list">
                                    <li>Full Body Polishing (Luxury)</li>
                                    <li>D-Tan Remover Full Body</li>
                                    <li>Full Body Waxing</li>
                                    <li>Power Define Luxury Diamond Facial</li>
                                    <li>Bikini Wax</li>
                                    <li>Rose Petal Pedicure (Luxury)</li>
                                    <li>Rose Petal Manicure (Luxury)</li>
                                    <li>Threading all including Katori Wax</li>
                                    <li>Hair Color</li>
                                    <li>Face D-Tan & Neck</li>
                                    <li>Hair Spa with Power Dose (Luxury)</li>
                                    <li>Styling Hair Cut</li>
                                    <li>Skin Purifying Clean-up with Peeling System</li><li></li>
                                </ul>
                            </div>

                          <div class="c2">
                                <strong>Now Only</strong>
                                <h3 class="price">19,999&#8377;</h3>
                                (normally 22,999&#8377;)
                            </div>


                            <div class="c3">
                                <a href="booking/" class="btn-line">Book Now</a>
                            </div>

                        </div>
                        <!-- package close -->
                    </div>

        



                </div>
            </div>

            
            <!-- section begin -->
            <?php get_template_part('template-parts/special-promo'); ?>
            <!-- section close -->
            <?php get_template_part('template-parts/service-small'); ?>
            <!-- section close -->



<!-- section begin -->
              <!-- section begin -->
           <?php get_template_part('template-parts/offer-and-appointment'); ?>
            <!-- section close -->
            <!-- section close -->
            <!-- section begin -->
            <section id="explore-5" class="side-bg text-light">
                <div class="col-md-6 image-container">
                    <div class="background-image"></div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-7">

                            <h2 class="wow-fadeIn">What They Says</h2>
                            <div class="small-border left wow zoomIn" data-wow-delay=".3s" data-wow-duration=".3s"></div>

                            <ul class="testimonial-list wow fadeIn" data-wow-delay=".25s">
                                <li>They were so friendly and it was pleasure to get my hair done there. I'm very happy with services their provided. I will recommend this salon to my family and friends. Their pricing was competitive and their staff is professional.
										<span>Lynda, Customer</span>
                                </li>
                                <li>A wonderful relaxing time, Thank you! The best salon in town as it proved by quality of staff and services. Their services make my feel so special. I always enjoy coming here, i would definitely return for future treatments. 
										<span>Sarah, Customer</span>
                                </li>
                            </ul>

                        </div>


                    </div>
                </div>
            </section>
            <!-- section close -->

       <!-- section begin -->
              <!-- section begin -->
           <?php get_template_part('template-parts/offer-and-appointment'); ?>
            <!-- section close -->
            <!-- section close -->
            <!-- section begin -->
            <section id="section-hero-2" aria-label="section-hero-2" data-stellar-background-ratio=".2" data-bgcolor="#333" class="text-light">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 mt60 mb100 text-center">
                            <h4 class="mb30">Discover Our Services.</h4>
                            <div class="small-border"></div>
                            <div class="type-wrap font48 text-center">
                                We do
                            <div class="typed-strings">
                                <p>Hair Care</p>
                                <p>Make Up</p>
                                <p>Facial</p>
                                <p>Massage</p>
                                <p>Nail Care</p>
                                <p>Waxing</p>
                            </div>
                                <span class="typed"></span>
                            </div>
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






