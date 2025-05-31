<?php
    get_header('home');
 ?>
        <!-- content begin -->
        <div id="content" class="no-bottom no-top">

            <!-- section begin -->
            <section id="section-intro-2" >
                <!-- First video -->
                <video autoplay muted loop playsinline id="bg-video">
                <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/hair-styling-hair-salon-1280x720.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                 <!-- Second video -->
                <!-- <video autoplay muted loop playsinline id="bg-video-2">
                
                <source src="<?php echo get_template_directory_uri(); ?>/assets/videos/home-facial-treatment-spa.mp4" type="video/mp4">
                    Your browser does not support the video tag.
                </video> -->
                <div class="content center-y text-center">

                    <div class="spacer-single"></div>
                    <div class="type-wrap big-font">
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
                    
                    <div class="spacer-half"></div>
                 
                    <div class="small-border"></div>

                         <div class="tp-caption sfb"
                                data-x="center"
                                data-y="320"
                                data-speed="1000"
                                data-start="1100"
                                data-easing="easeInOutExpo">
                                <a href="booking/" class="btn-slider">Schedule a Trial
                                </a>
                            </div>

                </div>
            </section>
            <!-- section close -->


             <!-- section begin -->
           <?php get_template_part('template-parts/time-and-address'); ?>
            <!-- section close -->



            <!-- section begin -->
            <section id="section-top-reason" class="no-top no-bottom">
                <div class="container-fluid">
                    <div class="row-fluid display-table">

                        <div class="col-md-4 text-middle" data-bgcolor="#e2e2e2">
                            <div class="padding40">
                                <div class="box-icon">
                                    <i class="fa fa-tags wow zoomIn" data-wow-delay=".25s"></i>
                                    <div class="text">
                                        <h4>Special Promo</h4>
                                        <p>Our commitment to quality and services ensure our clients happy. With years of experiences and continuing education, our dedicated staff is ready to serve your beauty needs. We're happy to help you decide the best look.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 text-middle text-light" data-bgimage="url(assets/images/background/bg-div-1.jpg)">
                            <div class="padding40 hoverdark30">
                                <div class="box-icon">
                                    <i class="fa fa-tags wow zoomIn" data-wow-delay=".25s"></i>
                                    <div class="text">
                                        <h4>Get Discount 50%</h4>
                                        <p>Our commitment to quality and services ensure our clients happy. With years of experiences and continuing education, our dedicated staff is ready to serve your beauty needs. We're happy to help you decide the best look.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 text-middle text-center" data-bgcolor="#50094d">
                            <div class="padding40">
                                <a href="booking/" class="btn btn-line-white btn-big wow fadeInUp" data-wow-delay=".3s">Make Appointment Now</a>
                                <?php /*echo do_shortcode('[booking resource_id=1]');*/ ?>
                          
                            </div>
                        </div>

                    </div>
                </div>
            </section>
            <!-- section close -->

            <!-- section begin -->
           <?php get_template_part('template-parts/service-small'); ?>
            <!-- section close -->




            <!-- section begin -->
            <section id="explore-5" class="side-bg text-light">
                <div class="col-md-6 image-container">
                    <div class="background-image"></div>
                </div>

                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-md-offset-7">

                            <h2 class="wow-fadeIn">What Client Says</h2>
                            <div class="small-border left wow zoomIn" data-wow-delay=".3s" data-wow-duration=".3s"></div>

                            <ul class="testimonial-list wow fadeIn" data-wow-delay=".25s">
                                <li>I booked hairstyle for my baby shower function and the result was so good. And I had a great experience from Maria Beauty Care at affordable price.
										<span>Mini Vignesh, Nagercoil</span>
                                </li>
                                <li>I got a layer cut recently, and I'm absolutely loving it! The stylist had such a nice and friendly character it made the whole experience really comfortable. They really knew what they were doing, gave helpful suggestions, and made sure I was happy with the look every step of the way. The layers added so much volume and movement to my hair it feels light, fresh, and stylish. Highly recommend!
										<span>Gil Jose, Nagercoil</span>
                                </li>

                                <li>Really awesome service. She is so friendly and happy to be with. She is so professional and guide in everything when come to services. I recommend everyone to visit once to see that yourself.
										<span>Raja Linda, Nagercoil</span>
                                </li>

                                  <li>Had a very good service of pedicure and facial in recent times. Highly recommended.
										<span>Letisha Smith, Nagercoil</span>
                                </li>
                            </ul>

                        </div>


                    </div>
                </div>
            </section>
            <!-- section close -->


            <!-- section begin -->
            <!-- <section id="section-fun-facts" data-bgcolor="#eee">
                <div class="container">

                    <div class="row mb60">

                        <div class="col-md-3 wow fadeIn" data-wow-delay="0">
                            <div class="de_count">
                                <i class="icon-profile-male wow zoomIn" data-wow-delay="0"></i>
                                <h3 class="timer" data-to="8250" data-speed="2500">0</h3>
                                <span>Clients</span>
                            </div>
                        </div>

                        <div class="col-md-3 wow fadeIn" data-wow-delay=".25s">
                            <div class="de_count">
                                <i class="icon-beaker  wow zoomIn" data-wow-delay=".25s"></i>
                                <h3 class="timer" data-to="4830" data-speed="2500">0</h3>
                                <span>Treatments</span>
                            </div>
                        </div>

                        <div class="col-md-3 wow fadeIn" data-wow-delay=".5s">
                            <div class="de_count">
                                <i class="icon-ribbon wow zoomIn" data-wow-delay=".5s"></i>
                                <h3 class="timer" data-to="180" data-speed="2500">0</h3>
                                <span>Therapists</span>
                            </div>
                        </div>

                        <div class="col-md-3 wow fadeIn" data-wow-delay=".75s">
                            <div class="de_count">
                                <i class="icon-puzzle wow zoomIn" data-wow-delay=".75s"></i>
                                <h3 class="timer" data-to="95" data-speed="2500">0</h3>
                                <span>Procedures</span>
                            </div>
                        </div>
                    </div>

                </div>
            </section> -->
            <!-- section close -->

            <!-- section begin -->
            <!-- <section id="section-blog" class="no-top">
                <div class="container">
                    <div class="row">

                        <div class="clearfix"></div>

                        <ul id="blog-carousel" class="blog-list blog-snippet wow fadeInUp mt-60">
                            <li class="col-md-6 item">
                                <div class="post-content">
                                    <div class="post-image">
                                        <img src="images/blog/pic-blog-1.jpg" alt="" />
                                    </div>


                                    <div class="date-box">
                                        <div class="day">26</div>
                                        <div class="month">FEB</div>
                                    </div>

                                    <div class="post-text">
                                        <h3><a href="css/#">How to Make Your Hair Grow Faster</a></h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                                    </div>

                                </div>
                            </li>

                            <li class="col-md-6 item">
                                <div class="post-content">
                                    <div class="post-image">
                                        <img src="images/blog/pic-blog-2.jpg" alt="" />
                                    </div>


                                    <div class="date-box">
                                        <div class="day">20</div>
                                        <div class="month">FEB</div>
                                    </div>

                                    <div class="post-text">
                                        <h3><a href="css/#">5 Ways to Make Hair Look Gorgeous</a></h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                                    </div>

                                </div>
                            </li>

                            <li class="col-md-6 item">
                                <div class="post-content">
                                    <div class="post-image">
                                        <img src="images/blog/pic-blog-3.jpg" alt="" />
                                    </div>


                                    <div class="date-box">
                                        <div class="day">16</div>
                                        <div class="month">FEB</div>
                                    </div>

                                    <div class="post-text">
                                        <h3><a href="css/#">14 Easy Ways to Get Standout Eyes</a></h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                                    </div>

                                </div>
                            </li>

                            <li class="col-md-6 item">
                                <div class="post-content">
                                    <div class="post-image">
                                        <img src="images/blog/pic-blog-4.jpg" alt="" />
                                    </div>


                                    <div class="date-box">
                                        <div class="day">08</div>
                                        <div class="month">FEB</div>
                                    </div>

                                    <div class="post-text">
                                        <h3><a href="css/#">An Owner’s Guide to Naturally Wavy Hair</a></h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.</p>
                                    </div>

                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </section> -->
            <!-- section close -->

            <!-- section begin -->
           <?php get_template_part('template-parts/offer-and-appointment'); ?>
            <!-- section close -->

        </div>
<?php
// Include the footer
get_footer('home');
// Close the wrapper div
?>



