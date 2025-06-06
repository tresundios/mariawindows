<?php /**
 * @version 1.0
 * @package Booking Calendar
 * @category Content of Up page
 * @author wpdevelop
 *
 * @web-site https://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com
 *
 * @modified 2017-10-16
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly

// FixIn: 8.0.1.6.

/**
 * Show Content
 *  Update Content
 *  Define Slug
 *  Define where to show
 */
class WPBC_Page_SettingsUpPro extends WPBC_Page_Structure {


	public function in_page() {
		if ( class_exists( 'wpdev_bk_personal' ) ) {
			return (string) wp_rand( 100000, 1000000 );
		}
		return 'wpbc-go-pro';
	}


	public function tabs() {

		$tabs = array();



		$tabs[ 'upgrade' ] = array(
			'title' => __( 'Upgrade', 'booking')                     // Title of TAB
		, 'page_title' => ''
		, 'hint' => ''                      // Hint
		, 'link' => ''                      // Can be skiped,  then generated link based on Page and Tab tags. Or can  be extenral link
		, 'position' => 'right'             // 'left'  ||  'right'  ||  ''
		, 'css_classes' => ''               // CSS class(es)
		, 'icon' => ''                      // Icon - link to the real PNG img
		, 'font_icon' => 'wpbc_icn_redeem'                 // CSS definition  of forn Icon
		, 'default' => ( ! class_exists( 'wpdev_bk_personal' ) )                // Is this tab activated by default or not: true || false.
		, 'hided'   => true                                // Is this tab hided: true || false.
			, 'folder_style' => 'order:9999;'
		);

		return $tabs;
	}


	public function content() {

		$this->css();
		?>
		<div class="wpbc_redirection_message">Redirection to <a href="https://wpbookingcalendar.com/features/#content">Booking Calendar website</a> after <span class="wpbc_countdown">5</span> seconds...</div>
		<script type="text/javascript">

			var count = 1;
			jQuery( ".wpbc_countdown" ).html( count );
			var countdown = setInterval(
				function(){
					jQuery( ".wpbc_countdown" ).html( count );
					if ( count == 0 ){
						clearInterval( countdown );
						window.location.href = "https://wpbookingcalendar.com/features/#content";
						//window.open( 'http://google.com', "_self" );
					}
			        count--;
		        }
	        , 10 );
		</script>
		<?php
		//	// FixIn: 10.1.3.1.

		wpbc_redirect( 'https://wpbookingcalendar.com/features/#content' );
	}

	public function css(){
		?>
		<style type="text/css">
			.nav-tab-wrapper {
				display:none;
			}
			.wpbc_countdown {
				font-weight: 600;
				font-size: 1.2em;
			}
			.wpbc_redirection_message {
				width:100%;
				text-align: center;

			}
	 	</style>
		<?php

	}
}

add_action('wpbc_menu_created', array( new WPBC_Page_SettingsUpPro() , '__construct') );    // Executed after creation of Menu