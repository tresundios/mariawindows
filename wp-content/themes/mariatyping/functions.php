<?php

if( !function_exists('mariatyping_setup')) {
    function mariatyping_setup() {
        load_theme_textdomain('mariatyping', get_template_directory(). '/languages');
        add_theme_support('title-tag');
        add_theme_support('post-thumbnails');
        add_theme_support('html5', array('search-form', 'comment-form', 'gallery', 'caption' ));
        add_theme_support('customize-selective-refresh-widgets');
        add_theme_support('responsive-embeds');
        register_nav_menu('mainmenu', __('Main Menu'));
    }
}

add_action('after_setup_theme', 'mariatyping_setup');

function mariatyping_assets() {
    // Base CSS
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.css');
    wp_enqueue_style('jpreloader', get_template_directory_uri() . '/assets/css/jpreloader.css');
    wp_enqueue_style('animate', get_template_directory_uri() . '/assets/css/animate.css');
    wp_enqueue_style('plugin', get_template_directory_uri() . '/assets/css/plugin.css');
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css');
    wp_enqueue_style('owl-theme', get_template_directory_uri() . '/assets//css/owl.theme.css');
    wp_enqueue_style('owl-transitions', get_template_directory_uri() . '/assets/css/owl.transitions.css');
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.css');
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.css');

    // Custom background
    wp_enqueue_style('bg', get_template_directory_uri() . '/assets/css/bg.css');

    // Color scheme
    wp_enqueue_style('color', get_template_directory_uri() . '/assets/css/color.css');

    // Fonts
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/font-awesome.css');
    wp_enqueue_style('elegant-font', get_template_directory_uri() . '/assets/fonts/elegant_font/HTML_CSS/style.css');
    wp_enqueue_style('et-line-font', get_template_directory_uri() . '/assets/fonts/et-line-font/style.css');

    // Revolution Slider
    wp_enqueue_style('rev-settings', get_template_directory_uri() . '/assets/rs-plugin/css/settings.css');
    wp_enqueue_style('rev-custom', get_template_directory_uri() . '/assets/css/rev-settings.css');


    // Base JS
    //wp_enqueue_script('jquery'); // WordPress includes jQuery by default

   // Deregister WordPress default jQuery and load your custom jQuery
    wp_deregister_script('jquery');
    wp_register_script('jquery', get_template_directory_uri() . '/assets/js/jquery.min.js', array(), null, true);
    wp_enqueue_script('jquery');

    

    wp_enqueue_script('jpreloader', get_template_directory_uri() . '/assets/js/jpreLoader.js', array('jquery'), null, true);
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), null, true);
    wp_enqueue_script('isotope', get_template_directory_uri() . '/assets/js/jquery.isotope.min.js', array('jquery'), null, true);
    wp_enqueue_script('easing', get_template_directory_uri() . '/assets/js/easing.js', array('jquery'), null, true);
    wp_enqueue_script('flexslider', get_template_directory_uri() . '/assets/js/jquery.flexslider-min.js', array('jquery'), null, true);
    wp_enqueue_script('scrollto', get_template_directory_uri() . '/assets/js/jquery.scrollto.js', array('jquery'), null, true);
    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/assets/js/owl.carousel.js', array('jquery'), null, true);
    wp_enqueue_script('countTo', get_template_directory_uri() . '/assets/js/jquery.countTo.js', array('jquery'), null, true);
    wp_enqueue_script('classie', get_template_directory_uri() . '/assets/js/classie.js', array(), null, true);
    wp_enqueue_script('video-resize', get_template_directory_uri() . '/assets/js/video.resize.js', array(), null, true);
    wp_enqueue_script('validation', get_template_directory_uri() . '/assets/js/validation.js', array(), null, true);
    wp_enqueue_script('wow', get_template_directory_uri() . '/assets/js/wow.min.js', array(), null, true);
    wp_enqueue_script('magnific-popup', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), null, true);
    wp_enqueue_script('enquire', get_template_directory_uri() . '/assets/js/enquire.min.js', array(), null, true);
    wp_enqueue_script('stellar', get_template_directory_uri() . '/assets/js/jquery.stellar.min.js', array('jquery'), null, true);
    wp_enqueue_script('designesia', get_template_directory_uri() . '/assets/js/designesia.js', array('jquery'), null, true);

    // Revolution Slider Scripts
    wp_enqueue_script('rev-plugins', get_template_directory_uri() . '/assets/rs-plugin/js/jquery.themepunch.plugins.min.js', array('jquery'), null, true);
    wp_enqueue_script('rev-revolution', get_template_directory_uri() . '/assets/rs-plugin/js/jquery.themepunch.revolution.min.js', array('jquery'), null, true);

    // Current page only (conditionally load on specific pages if needed)
    wp_enqueue_script('typed', get_template_directory_uri() . '/assets/js/typed.js', array('jquery'), null, true);
    wp_enqueue_script('typed-custom', get_template_directory_uri() . '/assets/js/typed-custom.js', array('typed'), null, true);

    if(is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}

add_action('wp_enqueue_scripts', 'mariatyping_assets');