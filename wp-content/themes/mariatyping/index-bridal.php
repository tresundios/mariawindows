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
                                <a href="#" class="btn-slider">Schedule a Trial
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
             <?php get_template_part('template-parts/special-promo'); ?>
            <!-- section close -->
           <!-- section begin -->
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






