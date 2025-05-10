<?php
/**
 * The Header for our theme
 * 
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 * 
 * @package mariatyping
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="utf-8">
    <title><?php wp_title('|', true, 'right'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Responsive Minimal Salon Website Template">
    <meta name="keywords" content="barber,beauty,clean,gallery,healthcare,make-up,mashup,massage,menucard,portfolio,products,salon,sauna,skin,spa">
    <meta name="author" content="">

    <?php
    wp_head();
    ?>
</head>

<body id="homepage" <?php body_class() ?>>
<!--<?php echo get_template_directory_uri(); ?>/assets/images/logo.png-->
    <div id="wrapper">

        <!-- header begin -->
        <header class="header_center">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <!-- logo begin -->
                        <div id="logo">
                            <a href="index.html">
                                <img class="logo logo_dark_bg" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo.png" alt="">
                                <img class="logo logo_light_bg" src="<?php echo get_template_directory_uri(); ?>/assets/images/logo_light.png" alt="">
                            </a>
                        </div>
                        <!-- logo close -->

                        <!-- small button begin -->
                        <span id="menu-btn"></span>
                        <!-- small button close -->

                        <!-- mainmenu begin -->
                        <!-- <nav>
                            <ul id="mainmenu">
                                <li><a href="index.html">Home</a>

                                </li>
                                <li><a href="services.html">Services</a>
                                    <ul>
                                        <li><a href="service-details-1.html">Single Page</a>
                                            <ul>
                                                <li><a href="service-details-1.html">Hair</a></li>
                                                <li><a href="service-details-2.html">Make Up</a></li>
                                                <li><a href="service-details-3.html">Facial</a></li>
                                                <li><a href="service-details-4.html">Massage</a></li>
                                                <li><a href="service-details-5.html">Nail</a></li>
                                                <li><a href="service-details-6.html">Waxing</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="services.html">Thumbnails</a></li>
                                        <li><a href="services-masonry.html">Masonry</a></li>
                                        <li><a href="services-list.html">List Style</a></li>
                                        <li><a href="services-list-center.html">List Style Center</a></li>
                                        <li><a href="services-list-description.html">List + Description</a></li>
                                        <li><a href="services-list-tab.html">Tab Style</a></li>
                                        <li><a href="services-thumbnail-circle.html">Thumbnails Circle</a></li>
                                    </ul>
                                </li>
                                <li><a href="booking.html">Book</a></li>
                                <li><a href="#">Pages</a>
                                    <ul>
                                        <li><a href="gallery.html">Gallery</a>
                                            <ul>
                                                <li><a href="gallery-2-cols.html">2 Columns</a></li>
                                                <li><a href="gallery-3-cols.html">3 Columns</a></li>
                                                <li><a href="gallery.html">4 Columns</a></li>
                                                <li><a href="gallery-2-cols-filter.html">2 Columns + Filter</a></li>
                                                <li><a href="gallery-3-cols-filter.html">3 Columns + Filter</a></li>
                                                <li><a href="gallery-4-cols-filter.html">4 Columns + Filter</a></li>
                                            </ul>
                                        </li>
                                        <li><a href="offers.html">Offers</a></li>
                                        <li><a href="popup.html">Popup</a></li>
                                        <li><a href="skills.html">Skills</a></li>
                                        <li><a href="tabs.html">Tabs</a></li>
                                        <li><a href="team.html">Team</a></li>
                                        <li><a href="testimonials.html">Testimonial</a></li>
                                    </ul>
                                </li>
                                <li><a href="about.html">About Us</a></li>
                                <li><a href="shop.html">Shop</a></li>
                                <li><a href="news.html">News</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </nav> -->
                        <?php
                        $menu = wp_nav_menu(
                            array(
                                'theme_location' => 'mainmenu',
                                'menu_id' => 'mainmenu',
                                'container' => 'ul',
                                'menu_class'     => '',
                                'echo' => false,
                            )
                        );
                        echo '<nav>' . $menu . '</nav>';
                        ?>
                        <div class="clearfix"></div>
                    </div>
                    <!-- mainmenu close -->

                </div>
            </div>
        </header>
        <!-- header close -->