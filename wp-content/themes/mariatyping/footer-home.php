  <!-- footer begin -->
  <footer>
            <div class="container">
                <div class="row">

                    <div class="col-md-4">
                        <div class="widget widget_recent_post">
                            <h3>Latest Blog</h3>
                            <?php
                            $args = array(
                                'post_type' => 'post',
                                'posts_per_page' => 5,
                                'post_status' => 'publish',
                                'order' => 'DESC',
                                'orderby' => 'date',
                            );
                            $recent_posts = new WP_Query($args);
                            if ($recent_posts->have_posts()) : ?>
                                <ul>
                                <?php while ($recent_posts->have_posts()) : $recent_posts->the_post(); ?>
                                    <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <p>No posts found.</p>
                            <?php endif; ?>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="widget">
                            <h3>We're Open</h3>
                            <div class="box-border double">
                                <ul class="list-border-bottom">
                                    <li>
                                        <span class="pull-left">Monday - Saturday</span>
                                        <span class="pull-right id-color">10:00 am to 7:30 pm</span>
                                        <div class="clearfix"></div>
                                    </li>
                                    <li>
                                        <span class="pull-left">Sunday &amp; Holiday</span>
                                        <span class="pull-right id-color">Appointments only</span>
                                        <div class="clearfix"></div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="widget widget-address">
                            <h3>Contact Us</h3>

                            <address>
                                   
                                <span>Door No: 39E, Swami Pillai Street,</span>
                                <span>Asaripallam Road,</span>
                                <span>Nesamony Nagar,</span>
                                <span>Nagercoil - 629 201</span>
                                <span><strong>Phone:</strong>+91 81480 64967</span>
                                <span><strong>Email:</strong><a href="mailto:contact@mariabeautycare.in">contact@mariabeautycare.in</a></span>
                                <span><strong>Web:</strong><a href="#">https://mariabeautycare.in/</a></span>
                            </address>
                        </div>
                    </div>


                </div>
            </div>

            <div class="subfooter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            &copy; Copyright 2025 - <a href="http://tresundios.com">Tresundios Software</a>
                        </div>
                        <div class="col-md-6 text-right">
                            <div class="social-icons">
                                <a href="https://www.facebook.com/shinewithmariabeautycare/" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
    
         
                       
                                <a href="https://www.instagram.com/mariabeauty.care/" target="_blank"><i class="fa fa-instagram fa-lg"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </footer>
        <!-- footer close -->
    </div>

    

    <?php
    wp_footer();
    ?>
<a href="https://wa.me/918148064967" target="_blank" id="whatsapp-button">
  <img src="https://img.icons8.com/color/96/000000/whatsapp.png" alt="Chat on WhatsApp">
</a>


</body>
</html>
