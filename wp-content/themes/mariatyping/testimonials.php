<?php
/**
 * Template Name: Testimonials
 * Description: Testimonials
 */
    get_header('home');
    get_template_part('template-parts/banner','testimonials');
?>
<div id="content">
    <div class="container">
        <div class="row">
            <div class="masonry">
                <div class="col-md-4 marginbottom30 item">
                    <div class="de_testi">
                        <blockquote>
                            <p>Everything is nicely accessible inside the theme customization screen. It is easily comprehensible, the way things work is very natural and intuitive.</p>
                        </blockquote>
                        <div class="de_testi_by">
                            <span class="de_testi_pic">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/misc/testi_pic%20(2).jpg" alt="" class="img-circle"></span>
                            <div class="de_testi_company">
                                <strong>Mores</strong>, Customer
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 marginbottom30 item">
                    <div class="de_testi">
                        <blockquote>
                            <p>The support staff is AMAZING. Same day service. They also have built a GREAT theme that supports so many functions. You can tweak little things here and there and use its functionality for SO much more! What an AWESOME AWESOME AWESOME theme.</p>
                        </blockquote>
                        <div class="de_testi_by">
                            <div class="de_testi_pic">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/misc/testi_pic%20(1).jpg" alt="" class="img-circle">
                            </div>
                            <div class="de_testi_company">
                                <strong>Feldhouse</strong>, Customer
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 marginbottom30 item">
                    <div class="de_testi">
                        <blockquote>
                            <p>There are some themes I have bought and are just 'eh' about. This one hands down does so much more than you could think. Perfect theme - and thanks for continually updating and improving it!</p>
                        </blockquote>
                        <div class="de_testi_by">
                            <div class="de_testi_pic">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/misc/testi-default.jpg" alt="" class="img-circle">
                            </div>
                            <div class="de_testi_company">
                                <strong>Feldhouse</strong>, Customer
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 marginbottom30 item">
                    <div class="de_testi">
                        <blockquote>
                            <p>All of my questions were answered, designesia was very forthcoming and helpful and even sent me custom code for a specific problem I had. I know one thing: whatever theme designesia publishes, you can be assured that you get the best quality and support out there.</p>
                        </blockquote>
                        <div class="de_testi_by">
                            <span class="de_testi_pic">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/misc/testi_pic%20(2).jpg" alt="" class="img-circle"></span>
                            <div class="de_testi_company">
                                <strong>Mores</strong>, Customer
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 marginbottom30 item">
                    <div class="de_testi">
                        <blockquote>
                            <p>Again, great template and I love that it works on the computer, iPad, phone, etc. Very clean design, keep up the great work!</p>
                        </blockquote>
                        <div class="de_testi_by">
                            <div class="de_testi_pic">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/misc/testi_pic%20(1).jpg" alt="" class="img-circle">
                            </div>
                            <div class="de_testi_company">
                                <strong>Barbara</strong>, Customer
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 marginbottom30 item">
                    <div class="de_testi">
                        <blockquote>
                            <p>Fit our needs like a glove. 1 hour to setup. I am currently implementing the language support Thanks for the awesome.</p>
                        </blockquote>
                        <div class="de_testi_by">
                            <div class="de_testi_pic">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/misc/testi-default.jpg" alt="" class="img-circle">
                            </div>
                            <div class="de_testi_company">
                                <strong>Itweb</strong>, Customer
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
     <!-- section begin -->
           <?php get_template_part('template-parts/offer-and-appointment'); ?>
            <!-- section close -->

<?php
// Include the footer
get_footer('home');
// Close the wrapper div
?>



