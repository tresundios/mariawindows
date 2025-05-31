<?php
/**
 * @version 1.0
 * @package Booking Calendar 
 * @subpackage Activation / Deactivation
 * @category Functions
 * @author      wpdevelop
 *
 * @web-site    https://wpbookingcalendar.com/
 * @email       info@wpbookingcalendar.com 
 * @modified    2016-03-17
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


/** Activation  & Deactivation  of Booking Calendar  */
class WPBC_BookingInstall extends WPBC_Install {

    /**
	 * Overload Booking Calendar option names and some other parameters
     * 
     * //FixIn: 7.0.1.12 
     * Important! for correct loading of trasnaltions later, we must  do not use here loacale of plugin. So here will be untranslated strings!!!
     *      
     */    
    public function get_init_option_names() {
        
        add_bk_action( 'wpdev_booking_activate_user', array( $this, 'wpbc_activate') );        // Hook  for MU User activation 
        
        $links = array(
                  'option-version_num'                  => 'booking_version_num'
                , 'option-is_delete_if_deactive'        => 'booking_is_delete_if_deactive'
                , 'option-activation_process'           => 'booking_activation_process'
                , 'transient-wpbc_activation_redirect'  => '_booking_activation_redirect'
                , 'message-delete_data'                 =>  '<strong>' . 'Warning!' . '</strong> '
                                                            . 'All booking data will be deleted when the plugin is deactivated.' 
                                                            . '<br />'
                                                            . sprintf( 'If you want to save your booking data, please uncheck the %s"Delete booking data"%s at the' 
                                                                       , '<strong>', '</strong>') 
                                                            . '<a href="' . esc_url( admin_url( add_query_arg( array( 'page' => 'wpbc-settings' ), 'admin.php' ) ) ) 
                                                                     . '&scroll_to_section=wpbc_general_settings_uninstall_tab"> ' . 'settings page' . '.'
                                                            . ' </a>'
                , 'link_settings'                       => '<a class="wpbc_plugins_links__settings" href="' . esc_url( admin_url( add_query_arg( array( 'page' => 'wpbc-settings' ), 'admin.php' ) ) )
                                                                       . '">'. "Settings" .'</a>'
                , 'link_whats_new'                      => '<a title="'. "Check new functionality in this plugin update." .'" href="' 
                                                                       . esc_url( admin_url( add_query_arg( array( 'page' => 'wpbc-about'  ), 'index.php' ) ) ) 
                                                                       .'">'. "What's New".'</a>'
                , 'link_faq' => '<a title="FAQ" href="https://wpbookingcalendar.com/faq/">FAQ</a>'
                , 'link_up'  => '<a title="Check Pro functionality" href="https://wpbookingcalendar.com/features/#link_up" style="color: rgb(0, 163, 42);font-weight:700;">Get Pro</a>'
                , 'link_upgrade'  => '<a title="Upgrade to higher version" href="'
														. esc_url( admin_url( add_query_arg( array( 'page' => 'wpbc-settings', 'tab' => 'upgrade' ), 'admin.php' ) ) )
														. '" style="color: rgb(0, 163, 42);font-weight:700;">Get More</a>'
        );

		return $links;
        
    }
    
    /** Check if was updated from lower to  high version */
    public function is_update_from_lower_to_high_version() {
        
        $is_make_activation = false;

	    // Check  conditions for different version about Upgrade
	    if ( ( class_exists( 'wpdev_bk_personal' ) ) && ( ! wpbc_is_table_exists( 'bookingtypes' ) ) ) {
		    $is_make_activation = true;
	    }
	    if ( ( ! $is_make_activation ) && ( class_exists( 'wpdev_bk_biz_s' ) ) && ( wpbc_is_field_in_table_exists( 'booking', 'pay_request' ) == 0 ) ) {
		    $is_make_activation = true;
	    }
	    																									// FixIn: 9.9.0.13.
	    if ( ( ! $is_make_activation ) && ( class_exists( 'wpdev_bk_biz_m' ) ) && ( ! wpbc_is_table_exists( 'booking_seasons' ) ) ) {
		    $is_make_activation = true;
	    }
	    if ( ( ! $is_make_activation ) && ( class_exists( 'wpdev_bk_biz_l' ) ) && ( ! wpbc_is_table_exists( 'booking_coupons' ) ) ) {
		    $is_make_activation = true;
	    }
	    if ( ( ! $is_make_activation ) && ( class_exists( 'wpdev_bk_multiuser' ) ) && ( wpbc_is_field_in_table_exists( 'booking_coupons', 'users' ) == 0 ) ) {
		    $is_make_activation = true;
	    }
        return $is_make_activation;
    }

}


// <editor-fold     defaultstate="collapsed"                        desc=" Examples Data for Demos "  >

function wpbc_create_examples_4_demo( $my_bk_types = array() ){

	global $wpdb;
	$version = wpbc_get_plugin_version_type();

        if (class_exists('wpdev_bk_multiuser')) {

	        if ( empty( $my_bk_types ) ) {
		        $my_bk_types = array( 13, 14, 15, 16, 17 );	// The booking resources with these IDs are exist in the Demo sites
	        } else {
		        shuffle( $my_bk_types );
	        }

			// Get NUMBER of Bookings.
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
			$bookings_count = $wpdb->get_results( "SELECT COUNT(*) as count FROM {$wpdb->prefix}booking as bk WHERE bk.trash != 1" );

          if (count($bookings_count)>0)   $bookings_count = $bookings_count[0]->count ;
          if ($bookings_count>=20) return;

			if ( ( ( defined( 'WP_BK_BETA_DATA_FILL_AS' ) ) && ( 'BL' === WP_BK_BETA_DATA_FILL_AS ) ) && ( isset( $_SERVER['HTTP_HOST'] ) ) && ( 'beta' === $_SERVER['HTTP_HOST'] ) ) {
				update_bk_option( 'booking_range_selection_time_is_active', 'On' );
				update_bk_option( 'booking_range_selection_start_time', '14:00' );
				update_bk_option( 'booking_range_selection_end_time', '12:00' );

				update_bk_option( 'booking_is_delete_if_deactive', 'On');
			}

			$max_num_bookings = 5;                                                        // How many bookings exist  per resource
          foreach ($my_bk_types as $resource_id) {                                     // Loop all resources                                        
                $bk_type  = $resource_id;                                              // Booking Resource

	          if ( ( ( defined( 'WP_BK_BETA_DATA_FILL_AS' ) ) && ( 'BL' === WP_BK_BETA_DATA_FILL_AS ) ) && ( isset( $_SERVER['HTTP_HOST'] ) ) && ( 'beta' === $_SERVER['HTTP_HOST'] ) ) {
		          $min_days = 3;
		          $max_days = 7;
	          } else {
		          $min_days = 1;        // FixIn: 10.0.0.51.
		          $max_days = 1;        // FixIn: 10.0.0.51.
	          }

	          $evry_one         = $max_days + wp_rand( 1, 5 );                                                  // Multiplier of interval between 2 dates of different bookings
	          $days_start_shift = wp_rand( $max_days, ( 90 * $max_days ) );//(ceil($max_num_bookings/2)) * $max_days;           // How long far ago we are start bookings

	          // Fill Development server by initial bookings
	          if ( ( ( defined( 'WP_BK_BETA_DATA_FILL' ) ) && ( WP_BK_BETA_DATA_FILL > 0 ) ) && ( isset( $_SERVER['HTTP_HOST'] ) ) && ( 'beta' === $_SERVER['HTTP_HOST'] ) ) {
		          $evry_one         = $min_days + wp_rand( 1, 7 );//3*$max_days+wp_rand(1,7);                                                  // Multiplier of interval between 2 dates of different bookings
		          $days_start_shift = wp_rand( 2 * $max_days, ( 5 * $max_days ) );  //wp_rand(2*$max_days,(5*$max_days));//(ceil($max_num_bookings/2)) * $max_days;           // How long far ago we are start bookings
	          }

	          for ( $i = 0; $i < $max_num_bookings; $i ++ ) {

                $is_appr  = wp_rand(0,1);                                                  // Pending | Approved
                $num_days = wp_rand($min_days,$max_days);                                  // Max Number of Dates for specific booking

                $second_name = wpbc_get_initial_values_4_demo('second_name');
                $city =  wpbc_get_initial_values_4_demo('city');
	            if ( ( ( defined( 'WP_BK_BETA_DATA_FILL_AS' ) ) && ( 'BL' === WP_BK_BETA_DATA_FILL_AS ) ) && ( isset( $_SERVER['HTTP_HOST'] ) ) && ( 'beta' === $_SERVER['HTTP_HOST'] ) ) {
		            $start_time = '14:00';
		            $end_time   = '12:00';
	            } else {
		            $range_time = wpbc_get_initial_values_4_demo( 'rangetime' );        // FixIn: 10.0.0.51.
		            $start_time = $range_time[0];        // FixIn: 10.0.0.51.
		            $end_time   = $range_time[1];        // FixIn: 10.0.0.51.
	            }

                $form  = '';
                	$form .= 'selectbox-one^rangetime'.$bk_type.'^'.$start_time.' - '.$end_time.'~';
                $form .= 'text^name'.$bk_type.'^'.wpbc_get_initial_values_4_demo('name').'~';
                $form .= 'text^secondname'.$bk_type.'^'.$second_name.'~';
                $form .= 'text^email'.$bk_type.'^'.$second_name.'.example@wpbookingcalendar.com~';
                $form .= 'text^address'.$bk_type.'^'.wpbc_get_initial_values_4_demo('adress').'~';
                $form .= 'text^city'.$bk_type.'^'.$city[0].'~';
                $form .= 'text^postcode'.$bk_type.'^'.wpbc_get_initial_values_4_demo('postcode').'~';
                $form .= 'text^country'.$bk_type.'^'.$city[1].'~';
                $form .= 'text^phone'.$bk_type.'^'.wpbc_get_initial_values_4_demo('phone').'~';
                $form .= 'selectbox-one^visitors'.$bk_type.'^1~';
                //$form .= 'checkbox^children'.$bk_type.'[]^0~';
                $form .= 'textarea^details'.$bk_type.'^'.wpbc_get_initial_values_4_demo('info').'~';
                $form .= 'coupon^coupon'.$bk_type.'^ ';


                $wp_bk_querie = "INSERT INTO {$wpdb->prefix}booking ( form, booking_type, cost, hash, modification_date ) VALUES
                                                   ( '".$form."', ".$bk_type .", ".wp_rand(0,1000).", MD5('". time() . '_' . wp_rand(1000,1000000)."'), NOW() ) ;";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_bk_querie );
                $temp_id = $wpdb->insert_id;

                $wp_queries_sub = "INSERT INTO {$wpdb->prefix}bookingdates (
                                     booking_id,
                                     booking_date,
                                     approved
                                    ) VALUES ";
                for ($d_num = 0; $d_num < $num_days; $d_num++) {
                    $my_interval = ( $i*$evry_one + $d_num);

	                if ( ( ( defined( 'WP_BK_BETA_DATA_FILL_AS' ) ) && ( 'BL' === WP_BK_BETA_DATA_FILL_AS ) ) && ( isset( $_SERVER['HTTP_HOST'] ) ) && ( 'beta' === $_SERVER['HTTP_HOST'] ) ) {

		                if ( 'On' !== get_bk_option( 'booking_range_selection_time_is_active' ) ) {
			                $wp_queries_sub .= "( " . $temp_id . ", DATE_ADD(CURDATE(), INTERVAL  -" . $days_start_shift . " day) + INTERVAL " . $my_interval . " day  ," . $is_appr . " ),";
		                } else {
			                if ( $d_num == 0 ) {                                       // Check In
				                $wp_queries_sub .= "( " . $temp_id . ", DATE_ADD(CURDATE(), INTERVAL  -" . $days_start_shift . " day) + INTERVAL \"" . $my_interval . " " . $start_time . ":01\" DAY_SECOND  ," . $is_appr . " ),";
			                } elseif ( $d_num == ( $num_days - 1 ) ) {                   // Check Out
				                $wp_queries_sub .= "( " . $temp_id . ", DATE_ADD(CURDATE(), INTERVAL -" . $days_start_shift . " day) + INTERVAL \"" . $my_interval . " " . $end_time . ":02\" DAY_SECOND  ," . $is_appr . " ),";
			                } else {
				                $wp_queries_sub .= "( " . $temp_id . ", DATE_ADD(CURDATE(), INTERVAL  -" . $days_start_shift . " day) + INTERVAL " . $my_interval . " day  ," . $is_appr . " ),";
			                }
		                }
	                } else {
		                $wp_queries_sub .= "( " . $temp_id . ", DATE_ADD(CURDATE(), INTERVAL -" . $days_start_shift . " DAY) + INTERVAL \"" . $my_interval . " " . $start_time . ":01\" DAY_SECOND  ," . $is_appr . " ),";        	// FixIn: 10.0.0.51.
		                $wp_queries_sub .= "( " . $temp_id . ", DATE_ADD(CURDATE(), INTERVAL -" . $days_start_shift . " DAY) + INTERVAL \"" . $my_interval . " " . $end_time . ":02\" DAY_SECOND  ," . $is_appr . " ),";        	// FixIn: 10.0.0.51.
	                }
                }
                $wp_queries_sub = substr($wp_queries_sub,0,-1) . ";";

				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_queries_sub );
             }
          }
        } else if ( $version == 'free' ) {
             if (empty($my_bk_types))   $my_bk_types=array(1,1);
             else                       shuffle($my_bk_types);

             for ($i = 0; $i < count($my_bk_types); $i++) {

				 $bk_type  = 1;
				 $is_appr  = wp_rand( 0, 1 );
				 $evry_one = 2;
				 if ( ( isset( $_SERVER['HTTP_HOST'] ) ) && ( ( 'beta' === $_SERVER['HTTP_HOST'] ) || ( 'freetest.wpbookingcalendar.com' === $_SERVER['HTTP_HOST'] ) ) ) {
					 $evry_one         = wp_rand( 1, 21 );
					 $num_days         = wp_rand( 1, 10 );
					 $days_start_shift = - 1 * wp_rand( 0, 28 );
				 }


                $second_name = wpbc_get_initial_values_4_demo('second_name');
                $form  = '';
                $form .= 'text^name'.$bk_type.'^'.wpbc_get_initial_values_4_demo('name').'~';
                $form .= 'text^secondname'.$bk_type.'^'.$second_name.'~';
                $form .= 'text^email'.$bk_type.'^'.$second_name.'.example@wpbookingcalendar.com~';
                $form .= 'text^phone'.$bk_type.'^'.wpbc_get_initial_values_4_demo('phone').'~';
                $form .= 'textarea^details'.$bk_type.'^'.wpbc_get_initial_values_4_demo('info');

                $wp_bk_querie = "INSERT INTO {$wpdb->prefix}booking ( form, modification_date ) VALUES ( '".$form."', NOW()  ) ;";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_bk_querie );
                $temp_id = $wpdb->insert_id;
                $wp_queries_sub = "INSERT INTO {$wpdb->prefix}bookingdates (
                                     booking_id,
                                     booking_date,
                                     approved
                                    ) VALUES ";

                if ( ( 'beta' === $_SERVER['HTTP_HOST'] ) || ( 'freetest.wpbookingcalendar.com' === $_SERVER['HTTP_HOST'] ) ) {
                    for ($d_num = 0; $d_num < $num_days; $d_num++) {
                            $wp_queries_sub .= "( ". $temp_id .", CURDATE()+ INTERVAL ".($days_start_shift + 2*($i+1)*$evry_one + $d_num)." day  ,". $is_appr." ),";
                    }
                    $wp_queries_sub = substr($wp_queries_sub,0,-1) . ";";
                } else {
                    $wp_queries_sub .= "( ". $temp_id .", CURDATE()+ INTERVAL ".(2*($i+1)*$evry_one+2)." day ,". $is_appr." ),
                                    ( ". $temp_id .", CURDATE()+ INTERVAL ".(2*($i+1)*$evry_one+3)." day  ,". $is_appr." ),
                                    ( ". $temp_id .", CURDATE()+ INTERVAL ".(2*($i+1)*$evry_one+4)." day ,". $is_appr." );";
                }
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_queries_sub );
             }
        } else if ( $version == 'personal' ) {
                $max_num_bookings = 8;                                                  // How many bookings exist     
            for ($i = 0; $i < $max_num_bookings; $i++) {               

                $bk_type  = wp_rand(1,4);                                                  // Booking Resource
                $min_days = 1;
                $max_days = 7;                    
                $is_appr  = wp_rand(0,1);                                                  // Pending | Approved
                $evry_one = $max_days;                                                  // Multiplier of interval between 2 dates of different bookings
                $num_days = wp_rand($min_days,$max_days);                                  // Max Number of Dates for specific booking
                $days_start_shift = -1 * (ceil($max_num_bookings/2)) * $max_days;       // How long far ago we are start bookings    

                $second_name = wpbc_get_initial_values_4_demo('second_name');
                $form  = '';
                $form .= 'text^name'.$bk_type.'^'.wpbc_get_initial_values_4_demo('name').'~';
                $form .= 'text^secondname'.$bk_type.'^'.$second_name.'~';
                $form .= 'text^email'.$bk_type.'^'.$second_name.'.example@wpbookingcalendar.com~';
                $form .= 'text^phone'.$bk_type.'^'.wpbc_get_initial_values_4_demo('phone').'~';
                $form .= 'selectbox-one^visitors'.$bk_type.'^'.wp_rand(1,4).'~';
                $form .= 'selectbox-one^children'.$bk_type.'^'.wp_rand(0,3).'~';
                $form .= 'textarea^details'.$bk_type.'^'.wpbc_get_initial_values_4_demo('info');

                $wp_bk_querie = "INSERT INTO {$wpdb->prefix}booking ( form, booking_type, hash,  modification_date ) VALUES
                                                   ( '".$form."', ".$bk_type .", MD5('". time() . '_' . wp_rand(1000,1000000)."'), NOW() ) ;";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_bk_querie );
                $temp_id = $wpdb->insert_id;

                $wp_queries_sub = "INSERT INTO {$wpdb->prefix}bookingdates (
                                     booking_id,
                                     booking_date,
                                     approved
                                    ) VALUES ";
                for ($d_num = 0; $d_num < $num_days; $d_num++) {
                    $wp_queries_sub .= "( ". $temp_id .", CURDATE()+ INTERVAL ".($days_start_shift + $i*$evry_one + $d_num)." day  ,". $is_appr." ),";
                }
                $wp_queries_sub = substr($wp_queries_sub,0,-1) . ";";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_queries_sub );
             }
        } else if ( $version == 'biz_s' ) {
                $max_num_bookings = 8;                                                  // How many bookings exist
            for ($i = 0; $i < $max_num_bookings; $i++) {               

                $bk_type  = wp_rand(1,4);                                                  // Booking Resource
                $min_days = 1;
                $max_days = 1;                    
                $is_appr  = wp_rand(0,1);                                                  // Pending | Approved
                $evry_one = $max_days;                                                  // Multiplier of interval between 2 dates of different bookings
                $num_days = wp_rand($min_days,$max_days);                                  // Max Number of Dates for specific booking
                $days_start_shift = (ceil($max_num_bookings/4)) * $max_days;       // How long far ago we are start bookings    

                $second_name = wpbc_get_initial_values_4_demo('second_name');
                $city =  wpbc_get_initial_values_4_demo('city');
                $range_time = wpbc_get_initial_values_4_demo('rangetime');
                $start_time = $range_time[0];
                $end_time   = $range_time[1];

                $form  = '';
                $form .= 'selectbox-one^rangetime'.$bk_type.'^'.$start_time.' - '.$end_time.'~';
                $form .= 'text^name'.$bk_type.'^'.wpbc_get_initial_values_4_demo('name').'~';
                $form .= 'text^secondname'.$bk_type.'^'.$second_name.'~';
                $form .= 'text^email'.$bk_type.'^'.$second_name.'.example@wpbookingcalendar.com~';
                $form .= 'text^address'.$bk_type.'^'.wpbc_get_initial_values_4_demo('adress').'~';
                $form .= 'text^city'.$bk_type.'^'.$city[0].'~';
                $form .= 'text^postcode'.$bk_type.'^'.wpbc_get_initial_values_4_demo('postcode').'~';
                $form .= 'text^country'.$bk_type.'^'.$city[1].'~';
                $form .= 'text^phone'.$bk_type.'^'.wpbc_get_initial_values_4_demo('phone').'~';
                $form .= 'selectbox-one^visitors'.$bk_type.'^'.wp_rand(1,4).'~';
                $form .= 'checkbox^children'.$bk_type.'[]^'.wp_rand(0,3).'~';
                $form .= 'textarea^details'.$bk_type.'^'.wpbc_get_initial_values_4_demo('info');

                $wp_bk_querie = "INSERT INTO {$wpdb->prefix}booking ( form, booking_type, cost, hash, modification_date ) VALUES
                                                   ( '".$form."', ".$bk_type .", ".wp_rand(0,1000).", MD5('". time() . '_' . wp_rand(1000,1000000)."'), NOW() ) ;";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_bk_querie );
                $temp_id = $wpdb->insert_id;

                $wp_queries_sub = "INSERT INTO {$wpdb->prefix}bookingdates (
                                     booking_id,
                                     booking_date,
                                     approved
                                    ) VALUES ";
                for ($d_num = 0; $d_num < $num_days; $d_num++) {
                    $my_interval = ( $i*$evry_one + $d_num);
//                        $wp_queries_sub .= "( ". $temp_id .", CURDATE()+ INTERVAL \"".($days_start_shift + $i*$evry_one + $d_num)." ".$start_time.":01\" DAY_SECOND  ,". $is_appr." ),";
//                        $wp_queries_sub .= "( ". $temp_id .", CURDATE()+ INTERVAL \"".($days_start_shift + $i*$evry_one + $d_num)." ".$end_time  .":02\" DAY_SECOND  ,". $is_appr." ),";                        
                    $wp_queries_sub .= "( ". $temp_id .", DATE_ADD(CURDATE(), INTERVAL -".$days_start_shift." DAY) + INTERVAL \"".$my_interval." ".$start_time.":01\" DAY_SECOND  ,". $is_appr." ),";                        
                    $wp_queries_sub .= "( ". $temp_id .", DATE_ADD(CURDATE(), INTERVAL -".$days_start_shift." DAY) + INTERVAL \"".$my_interval." ".$end_time.":02\" DAY_SECOND  ,". $is_appr." ),";
                }
                $wp_queries_sub = substr($wp_queries_sub,0,-1) . ";";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_queries_sub );
             }
        } else if ( $version == 'biz_m' ) {
                $max_num_bookings = 8;                                                  // How many bookings exist     
            for ($i = 0; $i < $max_num_bookings; $i++) {               

                $bk_type  = wp_rand(1,4);                                                  // Booking Resource
                $min_days = 3;
                $max_days = 7;                    
                $is_appr  = wp_rand(0,1);                                                  // Pending | Approved
                $evry_one = $max_days;                                                  // Multiplier of interval between 2 dates of different bookings
                $num_days = wp_rand($min_days,$max_days);                                  // Max Number of Dates for specific booking
                $days_start_shift =  (ceil($max_num_bookings/2)) * $max_days;       // How long far ago we are start bookings    

                $second_name = wpbc_get_initial_values_4_demo('second_name');
                $city =  wpbc_get_initial_values_4_demo('city');
                $start_time = '14:00';
                $end_time   = '12:00';

                $form  = '';
                $form .= 'text^name'.$bk_type.'^'.wpbc_get_initial_values_4_demo('name').'~';
                $form .= 'text^secondname'.$bk_type.'^'.$second_name.'~';
                $form .= 'text^email'.$bk_type.'^'.$second_name.'.example@wpbookingcalendar.com~';
                $form .= 'text^address'.$bk_type.'^'.wpbc_get_initial_values_4_demo('adress').'~';
                $form .= 'text^city'.$bk_type.'^'.$city[0].'~';
                $form .= 'text^postcode'.$bk_type.'^'.wpbc_get_initial_values_4_demo('postcode').'~';
                $form .= 'text^country'.$bk_type.'^'.$city[1].'~';
                $form .= 'text^phone'.$bk_type.'^'.wpbc_get_initial_values_4_demo('phone').'~';
                $form .= 'selectbox-one^visitors'.$bk_type.'^'.wp_rand(1,4).'~';
                $form .= 'checkbox^children'.$bk_type.'[]^'.wp_rand(0,3).'~';
                $form .= 'textarea^details'.$bk_type.'^'.wpbc_get_initial_values_4_demo('info').'~';
                $form .= 'text^starttime'.$bk_type.'^'.$start_time.'~';
                $form .= 'text^endtime'.$bk_type.'^'.$end_time;

                $wp_bk_querie = "INSERT INTO {$wpdb->prefix}booking ( form, booking_type, cost, hash, modification_date ) VALUES
                                                   ( '".$form."', ".$bk_type .", ".wp_rand(0,1000).", MD5('". time() . '_' . wp_rand(1000,1000000)."'), NOW() ) ;";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_bk_querie );
                $temp_id = $wpdb->insert_id;

                $wp_queries_sub = "INSERT INTO {$wpdb->prefix}bookingdates (
                                     booking_id,
                                     booking_date,
                                     approved
                                    ) VALUES ";
                for ($d_num = 0; $d_num < $num_days; $d_num++) {
                    $my_interval = ( $i*$evry_one + $d_num);
                    if ($d_num == 0) {                                       // Check In
                        $wp_queries_sub .= "( ". $temp_id .", DATE_ADD(CURDATE(), INTERVAL  -".$days_start_shift." day) + INTERVAL \"".$my_interval." ".$start_time.":01\" DAY_SECOND  ,". $is_appr." ),";
                    } elseif ($d_num == ($num_days-1) ) {                   // Check Out
                        $wp_queries_sub .= "( ". $temp_id .", DATE_ADD(CURDATE(), INTERVAL -".$days_start_shift." day) + INTERVAL \"".$my_interval." ".$end_time.":02\" DAY_SECOND  ,". $is_appr." ),";
                    } else {
                        $wp_queries_sub .= "( ". $temp_id .", DATE_ADD(CURDATE(), INTERVAL  -".$days_start_shift." day) + INTERVAL ".$my_interval." day  ,". $is_appr." ),";
                    }                        
                }
                $wp_queries_sub = substr($wp_queries_sub,0,-1) . ";";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_queries_sub );
             }

        } else if ( $version == 'biz_l' ) {
                $max_num_bookings = 12;                                                  // How many bookings exist     
            for ($res_groups = 0; $res_groups < 2; $res_groups++)    
            for ($i = 0; $i < $max_num_bookings; $i++) {               
                if($res_groups) 
                    $bk_type  = wp_rand(1,6);                                                  // Booking Resource
                else $bk_type  = wp_rand(7,12);                                                  // Booking Resource
                $min_days = 2;
                $max_days = 7;                    
                $is_appr  = wp_rand(0,1);                                                  // Pending | Approved
                $evry_one = $max_days;                                                  // Multiplier of interval between 2 dates of different bookings
                $num_days = wp_rand($min_days,$max_days);                                  // Max Number of Dates for specific booking
                $days_start_shift =  (ceil($max_num_bookings/2)) * $max_days;       // How long far ago we are start bookings    

                $second_name = wpbc_get_initial_values_4_demo('second_name');
                $city =  wpbc_get_initial_values_4_demo('city');
                $start_time = '14:00';
                $end_time   = '12:00';


                $form  = '';
                $form .= 'text^name'.$bk_type.'^'.wpbc_get_initial_values_4_demo('name').'~';
                $form .= 'text^secondname'.$bk_type.'^'.$second_name.'~';
                $form .= 'text^email'.$bk_type.'^'.$second_name.'.example@wpbookingcalendar.com~';
                $form .= 'text^address'.$bk_type.'^'.wpbc_get_initial_values_4_demo('adress').'~';
                $form .= 'text^city'.$bk_type.'^'.$city[0].'~';
                $form .= 'text^postcode'.$bk_type.'^'.wpbc_get_initial_values_4_demo('postcode').'~';
                $form .= 'text^country'.$bk_type.'^'.$city[1].'~';
                $form .= 'text^phone'.$bk_type.'^'.wpbc_get_initial_values_4_demo('phone').'~';
                $form .= 'selectbox-one^visitors'.$bk_type.'^1~';
                //$form .= 'checkbox^children'.$bk_type.'[]^0~';
                $form .= 'textarea^details'.$bk_type.'^'.wpbc_get_initial_values_4_demo('info').'~';
                $form .= 'coupon^coupon'.$bk_type.'^ ';

                $wp_bk_querie = "INSERT INTO {$wpdb->prefix}booking ( form, booking_type, cost, hash, modification_date ) VALUES
                                                   ( '".$form."', ".$bk_type .", ".wp_rand(0,1000).", MD5('". time() . '_' . wp_rand(1000,1000000)."'), NOW() ) ;";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_bk_querie );
                $temp_id = $wpdb->insert_id;

                $wp_queries_sub = "INSERT INTO {$wpdb->prefix}bookingdates (
                                     booking_id,
                                     booking_date,
                                     approved
                                    ) VALUES ";
                for ($d_num = 0; $d_num < $num_days; $d_num++) {
                    $my_interval = ( $i*$evry_one + $d_num);

                    $wp_queries_sub .= "( ". $temp_id .", DATE_ADD(CURDATE(), INTERVAL  -".$days_start_shift." day) + INTERVAL ".$my_interval." day  ,". $is_appr." ),";                                                
                }
                $wp_queries_sub = substr($wp_queries_sub,0,-1) . ";";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_queries_sub );
             }
        }
}


function wpbc_get_initial_values_4_demo( $type ) {
    $names = array('Jacob', 'Michael', 'Daniel', 'Anthony', 'William', 'Emma', 'Sophia', 'Kamila', 'Isabella', 'Jack', 'Daniel', 'Matthew',
            'Olivia', 'Emily', 'Grace', 'Jessica', 'Joshua', 'Harry', 'Thomas', 'Oliver', 'Jack' );
    $second_names = array(  'Smith', 'Johnson', 'Widams', 'Brown', 'Jones', 'Miller', 'Davis', 'Garcia', 'Rodriguez', 'Wilyson', 'Gonzalez', 'Gomez',
            'Taylor', 'Bron', 'Wilson', 'Davies', 'Robinson', 'Evans', 'Walker', 'Jackson', 'Clarke' );
    $city =    array( 'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'San Antonio', 'San Diego', 'San Jose', 'Detroit',
            'San Francisco', 'Jacksonville', 'Austin',
            'London', 'Birmingham', 'Leeds', 'Glasgow', 'Sheffield', 'Bradford', 'Edinburgh', 'Liverpool', 'Manchester' );
    $adress =   array('30 Mortensen Avenue', '144 Hitchcock Rd', '222 Lincoln Ave', '200 Lincoln Ave', '65 West Alisal St',
            '426 Work St', '65 West Alisal Street', '159 Main St', '305 Jonoton Avenue', '423 Caiptown Rd', '34 Linoro Ave',
            '50 Voro Ave', '15 East St', '226 Middle St', '35 West Town Street', '59 Other St', '50 Merci Ave', '15 Dolof St',
            '226 Gordon St', '35 Sero Street', '59 Exit St' );
    $country = array( 'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'UK','UK','UK','UK','UK','UK','UK','UK','UK' );

    $range_times = array( array("10:00","12:00"), array("12:00","14:00"), array("14:00","16:00"), array("16:00","18:00"), array("18:00","20:00") );

    switch ($type) {
        case 'rangetime':
            return $range_times[ wp_rand(0 , (count($range_times)-1) ) ] ;
            break;
        case 'name':
            return $names[ wp_rand(0 , (count($names)-1) ) ] ;
            break;
        case 'second_name':
            return $second_names[ wp_rand(0 , (count($second_names)-1) ) ] ;
            break;
        case 'adress':
            return $adress[ wp_rand(0 , (count($adress)-1) ) ] ;
            break;
        case 'city':
            $city_num = wp_rand(0 , (count($city)-1) )  ;
            return array( $city[$city_num], $country[$city_num]) ;
            break;
        case 'postcode':
            return (wp_rand(0,9).wp_rand(0,9).wp_rand(0,9).wp_rand(0,9).wp_rand(0,9));
            break;
        case 'phone':
            return (wp_rand(0,9).wp_rand(0,9).wp_rand(0,9).'-'.wp_rand(0,9).wp_rand(0,9).'-'.wp_rand(0,9).wp_rand(0,9)) ;
            break;
        case 'starttime':
            return ('0'.wp_rand(0,9) . ':' .wp_rand(1,3).'0' );
            break;
        case 'endtime':
            return (wp_rand(12,23) . ':' .wp_rand(1,3).'0' );
            break;
        case 'visitors':
            return wp_rand(1,4);
            break;
        default:
            return '';
            break;
    }

}


function wpbc_set_default_initial_values( $evry_one = 1 ) {
    global $wpdb;
    $names = array(  'Jacob', 'Michael', 'Daniel', 'Anthony', 'William', 'Emma', 'Sophia', 'Kamila', 'Isabella', 'Jack', 'Daniel', 'Matthew',
            'Olivia', 'Emily', 'Grace', 'Jessica', 'Joshua', 'Harry', 'Thomas', 'Oliver', 'Jack' );
    $second_names = array(  'Smith', 'Johnson', 'Widams', 'Brown', 'Jones', 'Miller', 'Davis', 'Garcia', 'Rodriguez', 'Wilyson', 'Gonzalez', 'Gomez',
            'Taylor', 'Bron', 'Wilson', 'Davies', 'Robinson', 'Evans', 'Walker', 'Jackson', 'Clarke' );
    $city =    array(       'New York', 'Los Angeles', 'Chicago', 'Houston', 'Phoenix', 'San Antonio', 'San Diego', 'San Jose', 'Detroit',
            'San Francisco', 'Jacksonville', 'Austin',
            'London', 'Birmingham', 'Leeds', 'Glasgow', 'Sheffield', 'Bradford', 'Edinburgh', 'Liverpool', 'Manchester' );
    $adress =   array(      '30 Mortensen Avenue', '144 Hitchcock Rd', '222 Lincoln Ave', '200 Lincoln Ave', '65 West Alisal St',
            '426 Work St', '65 West Alisal Street', '159 Main St', '305 Jonoton Avenue', '423 Caiptown Rd', '34 Linoro Ave',
            '50 Voro Ave', '15 East St', '226 Middle St', '35 West Town Street', '59 Other St', '50 Merci Ave', '15 Dolof St',
            '226 Gordon St', '35 Sero Street', '59 Exit St' );
    $country = array( 'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'US' ,'UK','UK','UK','UK','UK','UK','UK','UK','UK' );
    $info = array(    '  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ' ,'  ','  ','  ','  ','  ','  ','  ','  ','  ' );

    for ($i = 0; $i < count($names); $i++) {
        if ( ($i % $evry_one) !==0 ) {
            continue;
        }
        $bk_type = wp_rand(1,4);
        $is_appr = wp_rand(0,1);

        $start_time = '0'.wp_rand(0,9) . ':' .wp_rand(1,3).'0' ;
        $end_time     = wp_rand(12,23) . ':' .wp_rand(1,3).'0' ;

        $form = 'text^starttime'.$bk_type.'^'.$start_time.'~';
        $form .='text^endtime'.$bk_type.'^'.$end_time.'~';
        $form .='text^name'.$bk_type.'^'.$names[$i].'~';
        $form .='text^secondname'.$bk_type.'^'.$second_names[$i].'~';
        $form .='text^email'.$bk_type.'^'.$second_names[$i].'.example@wpbookingcalendar.com~';
        $form .='text^address'.$bk_type.'^'.$adress[$i].'~';
        $form .='text^city'.$bk_type.'^'.$city[$i].'~';
        $form .='text^postcode'.$bk_type.'^'.wp_rand(0,9).wp_rand(0,9).wp_rand(0,9).wp_rand(0,9).wp_rand(0,9).'~';
        $form .='text^country'.$bk_type.'^'.$country[$i].'~';
        $form .='text^phone'.$bk_type.'^'.wp_rand(0,9).wp_rand(0,9).wp_rand(0,9).'-'.wp_rand(0,9).wp_rand(0,9).'-'.wp_rand(0,9).wp_rand(0,9).'~';
        $form .='selectbox-one^visitors'.$bk_type.'^'.wp_rand(0,9).'~';
        $form .='checkbox^children'.$bk_type.'[]^false~';
        $form .='textarea^details'.$bk_type.'^'.$info[$i];

        $wp_bk_querie = "INSERT INTO {$wpdb->prefix}booking ( form, booking_type, cost, hash ) VALUES
                                           ( '".$form."', ".$bk_type .", ".wp_rand(0,1000).", MD5('". time() . '_' . wp_rand(1000,1000000)."') ) ;";
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
        $wpdb->query( $wp_bk_querie );

        $temp_id = $wpdb->insert_id;
        $wp_queries_sub = "INSERT INTO {$wpdb->prefix}bookingdates (
                             booking_id,
                             booking_date,
                             approved
                            ) VALUES
                            ( ". $temp_id .", CURDATE()+ INTERVAL \"".(2*($i+1)*$evry_one+2)." ".$start_time.":01"."\" DAY_SECOND ,". $is_appr." ),
                            ( ". $temp_id .", CURDATE()+ INTERVAL ".(2*($i+1)*$evry_one+3)." day  ,". $is_appr." ),
                            ( ". $temp_id .", CURDATE()+ INTERVAL \"".(2*($i+1)*$evry_one+4)." ".$end_time.":02"."\" DAY_SECOND ,". $is_appr." );";
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
		$wpdb->query( $wp_queries_sub );
    }
}

// </editor-fold>


// <editor-fold     defaultstate="collapsed"                        desc=" Support & Maintence "  >

/** Reindex DataBase to have "date key field" for be able to sort by dates. */
function wpbc_reindex_booking_db(){ global $wpdb;
    $is_show_messages = false;
//    if ( ( wpbc_is_settings_page('QUERY_STRING') ) && ( strpos($_SERVER[ 'QUERY_STRING' ],'reindex_sort_data=1') !== false ) )        
//         $is_show_messages = true;


    if ($is_show_messages)  {
        // Hide all settings
		// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
        ?><style type="text/css" rel="stylesheet" >
            #post_option .meta-box {
                display:none;
            }
            #post_option .button-primary {
                display:none;
            }
            #post_option .technical-booking-section {
                display:block;
            }
        </style>
        <?php
    }

    if  (wpbc_is_field_in_table_exists('booking','sort_date') == 0) {
        $simple_sql  = "ALTER TABLE {$wpdb->prefix}booking ADD sort_date datetime AFTER booking_id";
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
		$wpdb->query( $simple_sql );
    }

    // Refill the sort date index.
    if  (wpbc_is_field_in_table_exists('booking','sort_date') != 0) {

		$bookings_res = array();
	    if ( ! wpbc_is_this_wp_playground_db() ) {        // FixIn: 10.0.0.1.
			// 1. Select  all bookings ID, where sort_date is NULL in wp_booking.
			$sql = " SELECT booking_id as id FROM {$wpdb->prefix}booking as bk WHERE sort_date IS NULL";

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$bookings_res = $wpdb->get_results( $sql );
		}
		if ( $is_show_messages ) {
			/* translators: 1: ... */
			echo esc_html( sprintf( __( '%1$s Found %2$s not indexed bookings %3$s', 'booking' ), ' ', count( $bookings_res ), '<br/>' ) );
		}


		if ( count( $bookings_res ) > 0 ) {
            $id_string = '';
            foreach ($bookings_res as $value) {  $id_string .= $value->id . ','; }
            $id_string = substr($id_string,0,-1);

            //2. Select all (FIRST ??) booking_date, where booking_id = booking_id from #1 in wp_bookingdates
            $sql  = " SELECT booking_id as id, booking_date as date" ;
            $sql .= " FROM {$wpdb->prefix}bookingdates as bdt" ;
            $sql .= " WHERE booking_id IN ( ". $id_string ." ) GROUP BY bdt.booking_id ORDER BY bdt.booking_date " ;

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
			$sort_date_array = $wpdb->get_results( $sql );

			if ( $is_show_messages ) {
				/* translators: 1: ... */
				echo esc_html( sprintf( __( '%1$s Finish getting sort dates. %2$s', 'booking' ), ' ', '<br/>' ) );
			}

            //3. Insert  that firtst date into the bookings in wp_booking
            $ii=0;
            foreach ($sort_date_array as $value) { $ii++;
                $sql  = "UPDATE {$wpdb->prefix}booking as bdt ";
                $sql .= " SET sort_date = '".$value->date. "' WHERE booking_id  = ". $value->id . " ";
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $sql );

				if ( $is_show_messages ) {
					/* translators: 1: ... */
					echo esc_html( sprintf( __( 'Updated booking: %s', 'booking' ), $value->id . '  [' . $ii . ' / ' . count( $bookings_res ) . '] <br/>' ) );
				}
            }
        }

    }


}

// </editor-fold>



////////////////////////////////////////////////////////////////////////////////
//   A c t i v a t e    &    D e a c t i v a t e
////////////////////////////////////////////////////////////////////////////////

/** Activation */
function wpbc_booking_activate() {        
    
    make_bk_action( 'wpbc_before_activation' );
    
    wpbc_load_translation();
    
    $version = wpbc_get_plugin_version_type();
    $is_demo = wpbc_is_this_demo();

	// -----------------------------------------------------------------------------------------------------------------
    // Options
	// -----------------------------------------------------------------------------------------------------------------
    $default_options_to_add = wpbc_get_default_options();

    make_bk_action( 'wpbc_before_activation__add_options', $default_options_to_add );           // FixIn: 9.6.2.11.

    foreach ( $default_options_to_add as $default_option_name => $default_option_value ) {
        add_bk_option( $default_option_name, $default_option_value );
    }

    
	// -----------------------------------------------------------------------------------------------------------------
    // DB Tables
	// -----------------------------------------------------------------------------------------------------------------
    if ( true ){
        global $wpdb;
        $charset_collate = '';
        //if ( $wpdb->has_cap( 'collation' ) ) {
            if ( ! empty($wpdb->charset) ) $charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
            if ( ! empty($wpdb->collate) ) $charset_collate .= " COLLATE $wpdb->collate";
        //}

        $wp_queries = array();
        if ( ! wpbc_is_table_exists('booking') ) { // Check if tables not exist yet
// FixIn: 10.0.0.1.
            $simple_sql = "CREATE TABLE {$wpdb->prefix}booking (
                     booking_id bigint(20) unsigned NOT NULL auto_increment, " .
					 /*
				   " booking_options TEXT,
					 trash bigint(10) NOT NULL default 0,
					 is_new bigint(10) NOT NULL default 1,
					 sort_date datetime,
					 modification_date datetime,
					 creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
					 status varchar(200) NOT NULL default '',
					 sync_gid varchar(200) NOT NULL default '',
					 is_trash datetime,
					 hash TEXT, " .  /**/

				   " form text ,
                     booking_type bigint(10) NOT NULL default 1,
                     PRIMARY KEY  (booking_id)
                    ) {$charset_collate};";
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->query( $simple_sql );
        } elseif  (wpbc_is_field_in_table_exists('booking','form') == 0) {
            $wp_queries[]  = "ALTER TABLE {$wpdb->prefix}booking ADD form TEXT AFTER booking_id";
        }

        if  (wpbc_is_field_in_table_exists('booking','modification_date') == 0) {
            $wp_queries[]  = "ALTER TABLE {$wpdb->prefix}booking ADD modification_date datetime AFTER booking_id";            
        }

		// FixIn: 9.2.3.3.
	    if ( wpbc_is_field_in_table_exists( 'booking', 'creation_date' ) == 0 ) {
            $wp_queries[]  = "ALTER TABLE {$wpdb->prefix}booking ADD creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER modification_date";
			/**
			 *
			// Can be only  one 'TIMESTAMP' field at  some servers.
			//													   ADD re_create_date TIMESTAMP NOT NULL DEFAULT 0 AFTER rules_id
			//$wp_queries[]  = "ALTER TABLE {$wpdb->prefix}booking ADD creation_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER booking_id";
			 */
        }

        if  (wpbc_is_field_in_table_exists('booking','sort_date') == 0) {
            $wp_queries[]  = "ALTER TABLE {$wpdb->prefix}booking ADD sort_date datetime AFTER booking_id";
        }

        if  (wpbc_is_field_in_table_exists('booking','status') == 0) {
            $wp_queries[]  = "ALTER TABLE {$wpdb->prefix}booking ADD status varchar(200) NOT NULL default '' AFTER booking_id";
        }

        if  (wpbc_is_field_in_table_exists('booking','is_new') == 0) {
            $wp_queries[]  = "ALTER TABLE {$wpdb->prefix}booking ADD is_new bigint(10) NOT NULL default 1 AFTER booking_id";            
        }

        // Version: 5.2 - Google ID of the booking for Sync functionality
        if  (wpbc_is_field_in_table_exists('booking','sync_gid') == 0) {
            $wp_queries[]  = "ALTER TABLE {$wpdb->prefix}booking ADD sync_gid varchar(200) NOT NULL default '' AFTER booking_id";            
        }

	    // FixIn: 9.2.3.5.
        if  (wpbc_is_field_in_table_exists('booking','is_trash') == 0) {
            $wp_queries[]  = "ALTER TABLE {$wpdb->prefix}booking ADD is_trash datetime AFTER booking_id";
        }

        // FixIn: 6.1.1.10.
        if  (wpbc_is_field_in_table_exists('booking','trash') == 0) {
            $wp_queries[]  = "ALTER TABLE {$wpdb->prefix}booking ADD trash bigint(10) NOT NULL default 0 AFTER booking_id";            
        }



	    // FixIn: 9.1.2.12.
	    if ( wpbc_is_field_in_table_exists( 'booking', 'booking_options' ) == 0 ) {
		    $wp_queries[] = "ALTER TABLE {$wpdb->prefix}booking ADD booking_options TEXT AFTER booking_id";
	    }

		$is_insert_test_bookings = false;

		// FixIn: 8.7.9.1.
		if ( ! wpbc_is_table_exists( 'bookingdates' ) ) {
			// Check if tables not exist yet.
			$simple_sql = "CREATE TABLE {$wpdb->prefix}bookingdates (
                     booking_dates_id bigint(20) unsigned NOT NULL auto_increment,
                     booking_id bigint(20) unsigned NOT NULL,
                     booking_date datetime NOT NULL default '0000-00-00 00:00:00',
                     approved bigint(20) unsigned NOT NULL default 0,
                     PRIMARY KEY  (booking_dates_id)
                    ) {$charset_collate}";

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->query( $simple_sql );

			if ( ! class_exists( 'wpdev_bk_personal' ) ) {
				$is_insert_test_bookings = true;
			}
		}

		if ( 0 === wpbc_is_index_in_table_exists( 'bookingdates', 'booking_id_dates' ) ) {
			// If we remove this index,  so  then its can  significant impact  to the speed of page loading at the Booking Listing and Timelines.
			// Index for SPEED opening Booking Listing and Timeline with  thousands of Bookings,  otherwise,  without this index, speed will be TOO SLOW...
			$simple_sql = "CREATE UNIQUE INDEX booking_id_dates ON {$wpdb->prefix}bookingdates ( booking_id, booking_date);";
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->query( $simple_sql );
		}


		if ( count( $wp_queries ) > 0 ) {
			foreach ( $wp_queries as $wp_q ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( $wp_q );
			}

			if ( $is_insert_test_bookings ) {
				// -- Test Booking #1 --
				$is_appr    = 1;
				$wp_queries_sub = "INSERT INTO {$wpdb->prefix}booking ( form, modification_date ) VALUES (
                     'text^name1^John~text^secondname1^Smith~text^email1^example-free@wpbookingcalendar.com~text^phone1^458-77-77~textarea^details1^This is a test booking showing booking for several days.', NOW() );";
				$wpdb->query( $wp_queries_sub );  // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared

				$temp_id        = $wpdb->insert_id;
				$wp_queries_sub = "INSERT INTO {$wpdb->prefix}bookingdates ( booking_id, booking_date, approved  ) VALUES
                        ( " . $temp_id . ", CURDATE()+ INTERVAL 2 day ,". $is_appr."  ),
                        ( " . $temp_id . ", CURDATE()+ INTERVAL 3 day ,". $is_appr."  ),
                        ( " . $temp_id . ", CURDATE()+ INTERVAL 4 day ,". $is_appr."  );";
				$wpdb->query( $wp_queries_sub );  // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared

				// -- Test Booking #2 --
				$is_appr    = 0;
				$wp_queries_sub = "INSERT INTO {$wpdb->prefix}booking ( form, modification_date ) VALUES (
                     'text^name1^Emma~text^secondname1^Robinson~text^email1^example-free@wpbookingcalendar.com~text^phone1^999-77-77~textarea^details1^This is a test booking showing booking for several days.', NOW() );";
				$wpdb->query( $wp_queries_sub );  // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared

				$temp_id        = $wpdb->insert_id;
				$wp_queries_sub = "INSERT INTO {$wpdb->prefix}bookingdates ( booking_id, booking_date, approved  ) VALUES
                        ( " . $temp_id . ", CURDATE()+ INTERVAL 28 day ,". $is_appr." ),
                        ( " . $temp_id . ", CURDATE()+ INTERVAL 29 day ,". $is_appr." ),
                        ( " . $temp_id . ", CURDATE()+ INTERVAL 30 day ,". $is_appr." );";
				$wpdb->query( $wp_queries_sub );  // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared


				// -- Test Booking #3 --
				$is_appr    = 1;
				$start_time = '10:00';
				$end_time   = '10:30';
				$wp_queries_sub = "INSERT INTO {$wpdb->prefix}booking ( form, modification_date, is_new ) VALUES (
                     'selectbox^rangetime1^".$start_time." - ".$end_time."~text^name1^Sophia~text^secondname1^Robinson~text^email1^example-free@wpbookingcalendar.com~text^phone1^458-77-77~textarea^details1^This is a test booking showing a one day time slot booking.', NOW(), 0 );";
				$wpdb->query( $wp_queries_sub );  // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared

				$temp_id = $wpdb->insert_id;

				$wp_queries_sub = "INSERT INTO {$wpdb->prefix}bookingdates ( booking_id, booking_date, approved ) VALUES
									( ". $temp_id .", CURDATE()+ INTERVAL \"8 " . $start_time. ":01\" DAY_SECOND ,". $is_appr." ),
									( ". $temp_id .", CURDATE()+ INTERVAL \"8 " . $end_time  . ":02\" DAY_SECOND ,". $is_appr." );";
				$wpdb->query( $wp_queries_sub );  // phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared


			}
		}

	    // FixIn: 9.2.3.3.
		if ( wpbc_is_field_in_table_exists( 'booking', 'hash' ) == 0 ) {  //HASH_EDIT

			$simple_sql = "ALTER TABLE {$wpdb->prefix}booking ADD hash TEXT AFTER form";
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
			$wpdb->query( $simple_sql );

			// Update hash  value only in last 100 bookings
			$sql_check_table = "SELECT booking_id as id FROM {$wpdb->prefix}booking  ORDER BY booking_id DESC LIMIT 0, 100";

			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
			$res = $wpdb->get_results( $sql_check_table );

			foreach ( $res as $l ) {
				// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared
				$wpdb->query( "UPDATE {$wpdb->prefix}booking SET hash = MD5('" . time() . '_' . wp_rand( 1000, 1000000 ) . "') WHERE booking_id = " . $l->id );
			}
		}
    }
    make_bk_action( 'wpbc_activation_after_db_actions' );            													// FixIn: 9.3.1.2.

	// -----------------------------------------------------------------------------------------------------------------
    // Other versions Activation
	// -----------------------------------------------------------------------------------------------------------------
    make_bk_action( 'wpbc_other_versions_activation' );

    
	// -----------------------------------------------------------------------------------------------------------------
    // Examples in demos
	// -----------------------------------------------------------------------------------------------------------------
    if ( $is_demo ) {  wpbc_create_examples_4_demo(); }

    
    // Fill Development server by initial bookings
    if (       ( defined( 'WP_BK_BETA_DATA_FILL' ) ) 
            && (  WP_BK_BETA_DATA_FILL > 0 )  
        ) {
		if ( ( isset( $_SERVER['HTTP_HOST'] ) ) && ( ( 'beta' === $_SERVER['HTTP_HOST'] ) || ( 'freetest.wpbookingcalendar.com' === $_SERVER['HTTP_HOST'] ) ) ) {
            $types_array = array();
            for ( $i = 0; $i < WP_BK_BETA_DATA_FILL; $i++) {
                foreach ( range(1, 12) as $types_el) {
                    $types_array[] = $types_el;
                }
            }
            wpbc_create_examples_4_demo( $types_array ); 
        }
    }
    //wpbc_set_default_initial_values();

	// -----------------------------------------------------------------------------------------------------------------
    wpbc_reindex_booking_db();    

    make_bk_action( 'wpbc_after_activation' );
}
add_bk_action( 'wpbc_activation',  'wpbc_booking_activate' );



// Deactivate
function wpbc_booking_deactivate() {

	// -----------------------------------------------------------------------------------------------------------------
    // Options
	// -----------------------------------------------------------------------------------------------------------------
    $default_options_to_add = wpbc_get_default_options();
    foreach ( $default_options_to_add as $default_option_name => $default_option_value) {
        
        delete_bk_option( $default_option_name );
    }   
    
    
	// -----------------------------------------------------------------------------------------------------------------
    // Widgets
	// -----------------------------------------------------------------------------------------------------------------
    delete_bk_option( 'widget_bookingwidget' );
    delete_bk_option( 'widget_bookingsearchwidget' );
    delete_bk_option( 'widget_bookingselectwidget' );
    delete_bk_option( 'booking_activation_redirect_for_version' );
    
    
	// -----------------------------------------------------------------------------------------------------------------
    // DB Tables
	// -----------------------------------------------------------------------------------------------------------------
    global $wpdb;
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery.SchemaChange
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}booking" );
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared, WordPress.DB.DirectDatabaseQuery.SchemaChange
	$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}bookingdates" );

    // Delete all users booking windows states.
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared,
	if ( false === $wpdb->query( "DELETE FROM {$wpdb->usermeta} WHERE meta_key LIKE '%booking_%'" ) ) {
        debuge_error('Error during deleting user meta at DB',__FILE__,__LINE__);
        die();
    }
	
	// Delete or Drafts and Pending from demo sites
	if ( wpbc_is_this_demo() ) {  // Delete all temp posts at the demo sites: (post_status = pending || draft) && ( post_type = post ) && (post_author != 1)
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.NotPrepared,
		$postss = $wpdb->get_results( "SELECT * FROM {$wpdb->posts} WHERE ( post_status = 'pending' OR  post_status = 'draft' OR  post_status = 'auto-draft' OR  post_status = 'trash' OR  post_status = 'inherit' ) AND ( post_type='post' OR  post_type='revision') AND post_author != 1" );
		foreach ( $postss as $pp ) {
			wp_delete_post( $pp->ID, true );
		}
	}
	
	////////////////////////////////////////////////////////////////////////////
	// Other versions Deactivation
	////////////////////////////////////////////////////////////////////////////
	make_bk_action( 'wpbc_other_versions_deactivation' );
}
add_bk_action( 'wpbc_deactivation',  'wpbc_booking_deactivate' );


/**
 * Default Options
 *
 * Exmaple of getting options for deleting in MU:
 *
 * $option_name = '';
 * $is_get_multiuser_general_options = true;
 * $options_for_delete = wpbc_get_default_options( $option_name, $is_get_multiuser_general_options );
 */
function wpbc_get_default_options( $option_name = '', $is_get_multiuser_general_options = false ) {
        
    $is_demo = wpbc_is_this_demo();    
    $blg_title = str_replace( array( '"', "'" ), '', get_option( 'blogname' ) );
        
    $default_options  = array();

	// If this option here, then system get this option from "Super Admin" options configuration for "Regular" users.
    $mu_option4delete = array();

	// FixIn: 9.6.3.5.
	$default_options['booking_setup_wizard_page_steps_is_done'] = '';
 $mu_option4delete[]='booking_setup_wizard_page_steps_is_done';

    $default_options['booking_admin_cal_count'] = ($is_demo) ? '3' : '2';       
 $mu_option4delete[]='booking_admin_cal_count';                                 // $multiuser_general_option[] = implode( '', array_keys( array_slice( $default_options, -1 ) ) );
    // $default_options['booking_skin'] = '/css/skins/24_9__light_square_1.css'; //.
    // $default_options['booking_skin'] = '/css/skins/24_9__green_5.css';         // FixIn: 10.11.4.2.
    $default_options['booking_skin'] = '/css/skins/25_5__square_7.css';           // FixIn: 10.11.4.2.
 $mu_option4delete[]='booking_skin';
	// FixIn: 9.6.3.5.
    $default_options['booking_listing_default_view_mode'] = 'vm_booking_listing';	// 'vm_calendar';		// FixIn: 9.6.3.5.
 $mu_option4delete[]='booking_listing_default_view_mode';

    $default_options['booking_view_days_num'] = (  ( ! class_exists( 'wpdev_bk_personal' ) ) ? '90' : '30' );
 $mu_option4delete[]='booking_view_days_num';
 // FixIn: 8.9.4.3.
    $default_options['booking_calendar_overview__day_mode__days_number_show'] = (  ( ! class_exists( 'wpdev_bk_personal' ) ) ? '7' : '7' );
 $mu_option4delete[]='booking_calendar_overview__day_mode__days_number_show';
    $default_options['booking_timeline__month_mode__days_number_show'] = (  ( ! class_exists( 'wpdev_bk_personal' ) ) ? '7' : '7' );
 $mu_option4delete[]='booking_timeline__month_mode__days_number_show';
 // FixIn: 8.6.1.13.
    $default_options['booking_max_monthes_in_calendar'] = '2y';
 $mu_option4delete[]='booking_max_monthes_in_calendar';
    $default_options['booking_client_cal_count'] = '1';
 $mu_option4delete[]='booking_client_cal_count';    
    $default_options['booking_start_day_weeek'] = '0';
 $mu_option4delete[]='booking_start_day_weeek';     
    $default_options['booking_title_after_reservation'] =  ( ! class_exists( 'wpdev_bk_biz_s' ) )
															? __( 'Your booking is received. We will confirm it soon. Many thanks!', 'booking' )
															: __( 'Your booking is received. Please proceed with payment to confirm it. Many thanks!', 'booking' );
 $mu_option4delete[]='booking_title_after_reservation';    
//    $default_options['booking_title_after_reservation_time'] = '7000';
 //$mu_option4delete[]='booking_title_after_reservation_time';
    $default_options['booking_type_of_thank_you_message'] = 'message';
 $mu_option4delete[]='booking_type_of_thank_you_message';
    $default_options['booking_thank_you_page_URL'] = '/thank-you';
 $mu_option4delete[]='booking_thank_you_page_URL';         
    $default_options['booking_is_use_autofill_4_logged_user'] = ($is_demo) ? 'On' : 'Off';
 $mu_option4delete[]='booking_is_use_autofill_4_logged_user';      
    $default_options['booking_date_format'] = get_option( 'date_format' );
 $mu_option4delete[]='booking_date_format';
    $default_options['booking_time_format'] = get_option( 'time_format' );	//'H:i';
 $mu_option4delete[]='booking_time_format';

	//FixIn:10.2.0.1	------------------------------------------------------------------------------------------------
 	// Confirmation  section:
	$default_options['booking_confirmation_header_enabled'] = 'On';
	/* translators: 1: ... */
	$default_options['booking_confirmation_header']         = sprintf( __( 'Your booking id: %s', 'booking' ), '<strong>[booking_id]</strong>' );
$mu_option4delete[] = 'booking_confirmation_header_enabled';
$mu_option4delete[] = 'booking_confirmation_header';

	$default_options['booking_confirmation__personal_info__header_enabled'] = 'On';
	$default_options['booking_confirmation__personal_info__title']          =  __( 'Personal information', 'booking' );
	$default_options['booking_confirmation__personal_info__content']        = '[content]';
$mu_option4delete[] = 'booking_confirmation__personal_info__header_enabled';
$mu_option4delete[] = 'booking_confirmation__personal_info__title';
$mu_option4delete[] = 'booking_confirmation__personal_info__content';

	$default_options['booking_confirmation__booking_details__header_enabled'] = 'On';
	$default_options['booking_confirmation__booking_details__title']          = __( 'Booking details', 'booking' );
	$default_options['booking_confirmation__booking_details__content'] =  ( class_exists( 'wpdev_bk_personal' ) )
																				? "<h4>[resource_title]</h4>[readable_dates][readable_times]\n[add_to_google_cal_button]"
																				: "[readable_dates][readable_times]\n[add_to_google_cal_button]";

$mu_option4delete[] = 'booking_confirmation__booking_details__header_enabled';
$mu_option4delete[] = 'booking_confirmation__booking_details__title';
$mu_option4delete[] = 'booking_confirmation__booking_details__content';
	//FixIn:10.2.0.1	End	--------------------------------------------------------------------------------------------

    $default_options['booking_date_view_type'] = 'short';
 $mu_option4delete[]='booking_date_view_type';        
    $default_options['booking_is_delete_if_deactive'] = ($is_demo) ? 'On' : 'Off';
 $mu_option4delete[]='booking_is_delete_if_deactive';       
    $default_options['booking_dif_colors_approval_pending'] = 'On';             // Depricated
    $default_options['booking_is_use_hints_at_admin_panel'] = 'On';
 $mu_option4delete[]='booking_is_use_hints_at_admin_panel';
    $default_options['booking_is_load_js_css_on_specific_pages'] = 'Off';
 $mu_option4delete[]='booking_is_nonce_at_front_end';                                // FixIn: 10.1.1.2.
    $default_options['booking_is_nonce_at_front_end'] = 'Off';
	// FixIn: 9.8.6.2.
 $mu_option4delete[]='booking_load_balancer_max_threads';
	$default_options['booking_load_balancer_max_threads'] = ( $is_demo ) ? '1' : '3';


//FixIn: 7.2.1.15	
 $mu_option4delete[]='booking_is_show_system_debug_log';
    $default_options['booking_is_show_system_debug_log'] = 'Off';


 $mu_option4delete[]='booking_is_load_js_css_on_specific_pages';
    $default_options['booking_pages_for_load_js_css'] = '';
 $mu_option4delete[]='booking_pages_for_load_js_css';
    $default_options['booking_type_of_day_selections'] = ( ( get_bk_option( 'booking_range_selection_is_active' ) == 'On' ) && ( ! $is_demo ) ) ?  'range' : 'multiple';
 $mu_option4delete[]='booking_type_of_day_selections';

 	// FixIn: 8.7.11.10.
	$default_options['booking_timeslot_picker'] = 'On';
$mu_option4delete[]= 'booking_timeslot_picker';
	$default_options['booking_timeslot_picker_skin'] = '/css/time_picker_skins/light__24_8.css';
$mu_option4delete[]= 'booking_timeslot_picker_skin';

    $default_options['booking_timeslot_day_bg_as_available'] = 'Off';	//(  ( class_exists( 'wpdev_bk_personal' ) ) ? 'Off' : 'On' );                                                   // FixIn: 8.2.1.27.
 $mu_option4delete[]='booking_timeslot_day_bg_as_available';


	$default_options['booking_disable_timeslots_in_tooltip'] = 'Off';													//FixIn: 9.5.0.2.2
 $mu_option4delete[]='booking_disable_timeslots_in_tooltip';

	$default_options['booking_highlight_timeslot_word'] = __( 'Booked Times:', 'booking' );								// FixIn: 9.4.3.1.
 $mu_option4delete[]='booking_highlight_timeslot_word';

    $default_options['booking_form_is_using_bs_css'] = 'Off';
 $mu_option4delete[]='booking_form_is_using_bs_css';  
    $default_options['booking_form_format_type'] = 'vertical';
 $mu_option4delete[]='booking_form_format_type';
 
 // Does not exist  in  MU
    $default_options['booking_form_field_active1'] = 'On';
    $default_options['booking_form_field_required1'] = 'On';
    $default_options['booking_form_field_label1'] = 'First Name';
    $default_options['booking_form_field_active2'] = 'On';
    $default_options['booking_form_field_required2'] = 'On';
    $default_options['booking_form_field_label2'] = 'Last Name';
    $default_options['booking_form_field_active3'] = 'On';
    $default_options['booking_form_field_required3'] = 'On';
    $default_options['booking_form_field_label3'] = 'Email';
    $default_options['booking_form_field_active4'] = 'On';
    $default_options['booking_form_field_required4'] = 'Off';
    $default_options['booking_form_field_label4'] = 'Phone';
    $default_options['booking_form_field_active5'] = 'On';
    $default_options['booking_form_field_required5'] = 'Off';
    $default_options['booking_form_field_label5'] = 'Details';
    $default_options['booking_form_field_active6'] = 'Off';
    $default_options['booking_form_field_required6'] = 'Off';
    $default_options['booking_form_field_label6'] = 'Visitors';
    $default_options['booking_form_field_values6'] = "1\n2\n3\n4";
    
    
    $default_options['booking_is_days_always_available'] = 'Off';    
 $mu_option4delete[]='booking_is_days_always_available';

	// FixIn: 8.3.2.2.
    $default_options['booking_is_show_pending_days_as_available'] = 'Off';
 $mu_option4delete[]='booking_is_show_pending_days_as_available';

    $default_options['booking_unavailable_days_num_from_today'] = '0';
 $mu_option4delete[]='booking_unavailable_days_num_from_today';      
    $default_options['booking_unavailable_day0'] = 'Off';
 $mu_option4delete[]='booking_unavailable_day0';      
    $default_options['booking_unavailable_day1'] = 'Off';
 $mu_option4delete[]='booking_unavailable_day1';  
    $default_options['booking_unavailable_day2'] = 'Off';
 $mu_option4delete[]='booking_unavailable_day2';  
    $default_options['booking_unavailable_day3'] = 'Off';
 $mu_option4delete[]='booking_unavailable_day3';  
    $default_options['booking_unavailable_day4'] = 'Off';
 $mu_option4delete[]='booking_unavailable_day4';  
    $default_options['booking_unavailable_day5'] = 'Off';
 $mu_option4delete[]='booking_unavailable_day5';  
    $default_options['booking_unavailable_day6'] = 'Off';       
 $mu_option4delete[]='booking_unavailable_day6';  
    $default_options['booking_menu_position'] = ( $is_demo ) ? 'top' : 'top';
 $mu_option4delete[]='booking_menu_position';  
    $default_options['booking_translation_load_from'] = 'wp.org';
 $mu_option4delete[]='booking_translation_load_from';
    $default_options['booking_user_role_booking'] = ( $is_demo ) ? 'subscriber' : 'editor';
 $mu_option4delete[]='booking_user_role_booking';  
    $default_options['booking_user_role_availability'] = ( $is_demo ) ? 'subscriber' : 'editor';                        // FixIn: 9.5.2.2.
 $mu_option4delete[]='booking_user_role_availability';
    $default_options['booking_user_role_addbooking'] = ( $is_demo ) ? 'subscriber' : 'editor';
 $mu_option4delete[]='booking_user_role_addbooking';
    $default_options['booking_user_role_resources'] = ( $is_demo ) ? 'subscriber' : 'editor';
 $mu_option4delete[]='booking_user_role_resources';  
    $default_options['booking_user_role_settings'] = ( $is_demo ) ? 'subscriber' : 'administrator';
 $mu_option4delete[]='booking_user_role_settings';  
//FixIn: 9.8.15.2.6
if ( class_exists( 'wpdev_bk_biz_m' ) ) {
		$default_options['booking_user_role_prices'] = ( $is_demo ) ? 'subscriber' : 'editor';
	 $mu_option4delete[]='booking_user_role_prices';
}

    // New admin ///////////////////////////////////////////////////////////////
    
    $default_options['booking_is_email_reservation_adress'] = 'On';
    $default_options['booking_email_reservation_adress'] = htmlspecialchars( '"Booking system" <' . get_option( 'admin_email' ) . '>' );
    $default_options['booking_email_reservation_from_adress'] = '[visitoremail]';
    $default_options['booking_email_reservation_subject'] = __( 'New booking', 'booking' );
    /* translators: 1: ... */
    $default_options['booking_email_reservation_content'] = htmlspecialchars( sprintf( __( 'You need to approve a new booking %1$s for: %2$s Person detail information:%3$s Currently a new booking is waiting for approval. Please visit the moderation panel%4$sThank you, %5$s', 'booking' ), '[bookingtype]', '[dates]<br/><br/>', '<br/> [content]<br/><br/>', ' [moderatelink]<br/><br/>', $blg_title . '<br/>[siteurl]' ) );

    // New Visitor /////////////////////////////////////////////////////////////
    
    $default_options['booking_is_email_newbookingbyperson_adress'] = 'Off';    
    $default_options['booking_email_newbookingbyperson_adress'] = htmlspecialchars( '"Booking system" <' . get_option( 'admin_email' ) . '>' );
    $default_options['booking_email_newbookingbyperson_subject'] = __( 'New booking', 'booking' );
    if ( class_exists( 'wpdev_bk_personal' ) )
        /* translators: 1: ... */
        $default_options['booking_email_newbookingbyperson_content'] = htmlspecialchars( sprintf( __( 'Your reservation %1$s for: %2$s is processing now! We will send confirmation by email. %3$sYou can edit this booking at this page: %4$s  Thank you, %5$s', 'booking' ), '[bookingtype]', '[dates]', '<br/><br/>[content]<br/><br/>', '[visitorbookingediturl]<br/><br/>', $blg_title . '<br/>[siteurl]' ) );
    else
        /* translators: 1: ... */
        $default_options['booking_email_newbookingbyperson_content'] = htmlspecialchars( sprintf( __( 'Your reservation %1$s for: %2$s is processing now! We will send confirmation by email. %3$s Thank you, %4$s', 'booking' ), '[bookingtype]', '[dates]', '<br/><br/>[content]<br/><br/>', $blg_title . '<br/>[siteurl]' ) );
    
    // Approval ////////////////////////////////////////////////////////////////
    
    $default_options['booking_is_email_approval_adress'] = 'On';
    $default_options['booking_is_email_approval_send_copy_to_admin'] = 'Off';
    $default_options['booking_email_approval_adress'] = htmlspecialchars( '"Booking system" <' . get_option( 'admin_email' ) . '>' );
    $default_options['booking_email_approval_subject'] = __( 'Your booking has been approved', 'booking' );
    if ( class_exists( 'wpdev_bk_personal' ) ) {
		/* translators: 1: ... */
		$default_options['booking_email_approval_content'] = htmlspecialchars( sprintf( __( 'Your reservation %1$s for: %2$s has been approved.%3$sYou can edit the booking on this page: %4$s Thank you, %5$s', 'booking' ), '[bookingtype]', '[dates]', '<br/><br/>[content]<br/><br/>', '[visitorbookingediturl]<br/><br/>', $blg_title . '<br/>[siteurl]' ) );
	} else {
		/* translators: 1: ... */
		$default_options['booking_email_approval_content'] = htmlspecialchars( sprintf( __( 'Your booking %1$s for: %2$s has been approved.%3$sThank you, %4$s', 'booking' ), '[bookingtype]', '[dates]', '<br/><br/>[content]<br/><br/>', $blg_title . '<br/>[siteurl]' ) );
	}

    // Decline /////////////////////////////////////////////////////////////////
    
    $default_options['booking_is_email_deny_adress'] = 'On';
    $default_options['booking_is_email_deny_send_copy_to_admin'] = 'Off';
    $default_options['booking_email_deny_adress'] = htmlspecialchars( '"Booking system" <' . get_option( 'admin_email' ) . '>' );
    $default_options['booking_email_deny_subject'] = __( 'Your booking has been declined', 'booking' );
    /* translators: 1: ... */
    $default_options['booking_email_deny_content'] = htmlspecialchars( sprintf( __( 'Your booking %1$s for: %2$s has been  canceled. %3$sThank you, %4$s', 'booking' ), '[bookingtype]', '[dates]', '<br/>[denyreason]<br/><br/>[content]<br/><br/>', $blg_title . '<br/>[siteurl]' ) );

	// -----------------------------------------------------------------------------------------------------------------
    $default_options['booking_widget_title'] = __( 'Booking form', 'booking' );
    $default_options['booking_widget_show'] = 'booking_form';
    $default_options['booking_widget_type'] = '1';
    $default_options['booking_widget_calendar_count'] = '1';
    $default_options['booking_widget_last_field'] = '';

    $default_options['booking_wpdev_copyright_adminpanel'] = 'On';
 $mu_option4delete[]='booking_wpdev_copyright_adminpanel';    
    $default_options['booking_is_show_powered_by_notice'] = 'On';
 $mu_option4delete[]='booking_is_show_powered_by_notice';  
    $default_options['booking_form_theme'] = '';
 $mu_option4delete[]='booking_form_theme';
    $default_options['booking_is_use_captcha'] = 'Off';
 $mu_option4delete[]='booking_is_use_captcha';
    $default_options['booking_is_show_legend'] = 'On';
 $mu_option4delete[]='booking_is_show_legend';
    $default_options['booking_send_button_title'] = __( 'Send', 'booking' );                // FixIn: 8.8.1.14.
 $mu_option4delete[]='booking_send_button_title';
    $default_options['booking_legend_is_show_item_available'] = 'On';
 $mu_option4delete[]='booking_legend_is_show_item_available';          
    $default_options['booking_legend_text_for_item_available'] = __( 'Available', 'booking' );
 $mu_option4delete[]='booking_legend_text_for_item_available';
    $default_options['booking_legend_is_show_item_pending'] = 'On';
 $mu_option4delete[]='booking_legend_is_show_item_pending';    
    $default_options['booking_legend_text_for_item_pending'] = __( 'Pending', 'booking' );
 $mu_option4delete[]='booking_legend_text_for_item_pending';    
    $default_options['booking_legend_is_show_item_approved'] = 'On';
 $mu_option4delete[]='booking_legend_is_show_item_approved';    
    $default_options['booking_legend_text_for_item_approved'] = __( 'Booked', 'booking' );
 $mu_option4delete[]='booking_legend_text_for_item_approved';
	// FixIn: 9.9.0.5.
    $default_options['booking_legend_is_show_item_unavailable'] = 'Off';
 $mu_option4delete[]='booking_legend_is_show_item_unavailable';
    $default_options['booking_legend_text_for_item_unavailable'] = __( 'Unavailable', 'booking' );
 $mu_option4delete[]='booking_legend_text_for_item_unavailable';

    // FixIn: 10.1.5.5.
	$default_options['booking_legend_is_show_item_partially'] = ( ( class_exists( 'wpdev_bk_personal' ) ) && ( ! class_exists( 'wpdev_bk_biz_s' ) ) ) ? 'Off' : 'On';
 $mu_option4delete[]='booking_legend_is_show_item_partially';
	$default_options['booking_legend_text_for_item_partially'] = __( 'Partially booked', 'booking' );
 $mu_option4delete[]='booking_legend_text_for_item_partially';

    $default_options['booking_legend_is_show_numbers'] = 'On';                    //FixIn:6.0.1.4						// FixIn: 8.1.3.8.
 $mu_option4delete[]='booking_legend_is_show_numbers';
    $default_options['booking_legend_is_vertical'] = 'Off';                    											// FixIn: 9.4.3.6.
 $mu_option4delete[]='booking_legend_is_vertical';

    /*
     Import previous (old version) Email  templates
     or get defult values from Email Classes,  if the emails was not saved
     if the emails was saved,  in this case  - return empty array(), Useful  for the Email Settings page  to loading data from  DB,  during activation Mail API class.
     So if we get empty array for values, in this case,  we need to  get this optiosn from DB.
     */
    // Get NEW Email Templates default data or Import previous saved 
    $emails_init = wpbc_import6_email__new_admin__get_fields_array_for_activation();
    $emails_init = array_merge( $emails_init, wpbc_import6_email__new_visitor__get_fields_array_for_activation() );
    $emails_init = array_merge( $emails_init, wpbc_import6_email__approved__get_fields_array_for_activation() );
    $emails_init = array_merge( $emails_init, wpbc_import6_email__deleted__get_fields_array_for_activation() );
    $emails_init = array_merge( $emails_init, wpbc_import6_email__deny__get_fields_array_for_activation() );
    $emails_init = array_merge( $emails_init, wpbc_import6_email__trash__get_fields_array_for_activation() );
    if ( class_exists( 'wpdev_bk_personal' ) ) 
        $emails_init = array_merge( $emails_init, wpbc_import6_email__modification__get_fields_array_for_activation() );
    if ( class_exists( 'wpdev_bk_biz_s' ) ) 
        $emails_init = array_merge( $emails_init, wpbc_import6_email__payment_request__get_fields_array_for_activation() );    
    foreach ( $emails_init as $email_key_name => $email_values ) {

        if ( ! empty( $email_values ) ) $default_options[ $email_key_name ] = $email_values;
        else                            $default_options[ $email_key_name ] = get_bk_option( $email_key_name );
    }

        
 $mu_option4delete[]='booking_gcal_auto_import_is_active';                      // Creation  in   wpbc-gcal.php file 
 $mu_option4delete[]='booking_gcal_auto_import_time';    
 $mu_option4delete[]='booking_cron';                                            // Creation  in wpbc-cron.php

	// FixIn: 8.0.1.6.
	//$default_options['booking_form_structure_type'] = 'vertical';
	// $default_options['booking_form_structure_type'] = 'form_right';        // FixIn: 10.3.0.6.
	$default_options['booking_form_structure_type'] = 'wizard_services_a'; // FixIn: 10.11.4.3.
	$default_options['booking_menu_go_pro'] 		= 'show';	// show | hide

//	$default_options['booking_form_layout_width']       = '440';
//	$default_options['booking_form_layout_width_px_pr'] = 'px';
//	$default_options['booking_form_layout_max_cols']    = 1;

	// FixIn: 10.11.4.3.
	$default_options['booking_form_layout_width']       = '100';
	$default_options['booking_form_layout_width_px_pr'] = '%';
	$default_options['booking_form_layout_max_cols']    = 2;


	// -----------------------------------------------------------------------------------------------------------------
    // PS
	// -----------------------------------------------------------------------------------------------------------------
    if ( class_exists( 'wpdev_bk_personal' ) ) {

        $default_options['booking_is_use_simple_booking_form'] = 'Off';                                              	// FixIn: 8.1.1.12.
     $mu_option4delete[]='booking_is_use_simple_booking_form';

        $default_options['booking_is_use_codehighlighter_booking_form'] = 'On';                                         // FixIn: 8.4.7.18.
     $mu_option4delete[]='booking_is_use_codehighlighter_booking_form';

        $default_options['booking_form']        = str_replace( '\\n\\', '', wpbc_get_default_booking_form() );
        $default_options['booking_form_show']   = str_replace( '\\n\\', '', wpbc_get_default_booking_form_show() );

        $default_options['booking_url_bookings_edit_by_visitors'] = site_url();
     $mu_option4delete[]='booking_url_bookings_edit_by_visitors';

        $default_options['booking_url_bookings_listing_by_customer'] = site_url();										//FixIn: 8.1.3.5.1
     $mu_option4delete[]='booking_url_bookings_listing_by_customer';

        $default_options['booking_default_booking_resource'] = '';                  // All resources
     $mu_option4delete[]='booking_default_booking_resource'; 
        $default_options['booking_is_change_hash_after_approvement'] = 'On';     // FixIn: 10.10.1.1.
     $mu_option4delete[]='booking_is_change_hash_after_approvement'; 
        $default_options['booking_email_modification_adress'] = htmlspecialchars( '"Booking system" <' . get_option( 'admin_email' ) . '>' );
        $default_options['booking_email_modification_subject'] = __( 'The reservation has been modified', 'booking' );
        /* translators: 1: ... */
        $default_options['booking_email_modification_content'] = htmlspecialchars( sprintf( __( 'The reservation %1$s for: %2$s has been modified. %3$sYou can edit this booking on this page: %4$s  Thank you, %5$s', 'booking' ), '[bookingtype]', '[dates]', '<br/><br/>[content]<br/><br/>', '[visitorbookingediturl]<br/><br/>', $blg_title . '<br/>[siteurl]' ) );
        $default_options['booking_is_email_modification_adress'] = 'On';
        $default_options['booking_is_email_modification_send_copy_to_admin'] = 'Off';
        $default_options['booking_resourses_num_per_page'] = '10';
     $mu_option4delete[]='booking_resourses_num_per_page';         
        $default_options['booking_default_title_in_day_for_calendar_view_mode'] = '[id]: [name] [secondname]';
     $mu_option4delete[]='booking_default_title_in_day_for_calendar_view_mode';

	// FixIn: 8.1.3.31.
        $default_options['booking_calendar_overview_start_time'] = '0';
     $mu_option4delete[]='booking_calendar_overview_start_time';
        $default_options['booking_calendar_overview_end_time'] = '24';
     $mu_option4delete[]='booking_calendar_overview_end_time';

        $default_options['booking_default_title_in_day_for_timeline_front_end'] = '[name] [secondname]';
     $mu_option4delete[]='booking_default_title_in_day_for_timeline_front_end';
        $default_options['booking_is_show_popover_in_timeline_front_end'] = ($is_demo) ? 'On' : 'Off';
     $mu_option4delete[]='booking_is_show_popover_in_timeline_front_end';
	 // FixIn: 9.6.3.5.

        $default_options['booking_send_emails_off_addbooking'] = 'Off';												 // FixIn: 8.4.5.4.
     $mu_option4delete[]='booking_send_emails_off_addbooking';

	    // FixIn: 9.6.3.5.

        $default_options['booking_change_resource_skip_checking'] = 'Off';												 // FixIn: 8.4.5.4.
     $mu_option4delete[]='booking_change_resource_skip_checking';

        $default_options['booking_log_booking_actions'] = 'On';												 		// FixIn: 8.6.1.10.
     $mu_option4delete[]='booking_log_booking_actions';


    }

	// FixIn: 8.5.1.1.
	//	$default_options['booking_ics_force_import'] = 'Off';								// FixIn: 8.4.7.1.
		$default_options['booking_ics_force_trash_before_import'] = 'Off';					// FixIn: 8.4.7.12.
	//$mu_option4delete[]='booking_ics_force_trash_before_import';   						// No need to delete ^
		$default_options['booking_ics_import_append_checkout_day'] = 'Off';                                             //FixIn: 9.6.2.7 // FixIn: 9.5.4.1.
	//$mu_option4delete[]='booking_ics_import_append_checkout_day';   			// No need to delete ^

	// FixIn: 9.8.15.8.
	$default_options['booking_condition_import_only_new'] = (  get_bk_option( 'booking_ics_force_import' ) === 'On' )   ?  'Off' : 'On';
	$default_options['booking_condition_import_if_available'] = 'Off';

	// FixIn: 10.1.5.4.
        $default_options['booking_recurrent_time'] =  ( class_exists( 'wpdev_bk_personal' ) ) ? 'Off' : 'On';
     $mu_option4delete[]='booking_recurrent_time';

        $default_options['booking_calendar_allow_several_months_on_mobile'] =  'Off';
     $mu_option4delete[]='booking_calendar_allow_several_months_on_mobile';

	// -----------------------------------------------------------------------------------------------------------------
    // BS
	// -----------------------------------------------------------------------------------------------------------------
    if ( class_exists( 'wpdev_bk_biz_s' ) ) {
        
     //$mu_option4delete[]='booking_paypal_price_period';                         // No need to  delete,  this option, because different users can  have different settings. During init defined at ../booking/inc/gateways/page-gateways.php

		$default_options['booking_gateways_order'] = 'stripe_v3,paypal_std_co,paypal,authorizenet,sage,redsys,bank_transfer,pay_cash,ipay88,ideal';   //     Default Original Payment Gateways
	//$mu_option4delete[]='booking_gateways_order';        	// No need to delete ^

		// FixIn: 8.1.3.29.
		$default_options['booking_ics_import_add_change_over_time'] = 'On';
	//$mu_option4delete[]='booking_ics_import_add_change_over_time';        	// No need to delete ^

		// FixIn: 8.5.2.3.
		$default_options['booking_is_ics_export_only_approved'] = 'Off';
	//$mu_option4delete[]='booking_is_ics_export_only_approved';   				// No need to delete ^
		$default_options['booking_is_ics_export_imported_bookings'] = '';												// FixIn: 8.8.3.19.


        $default_options['booking_auto_approve_new_bookings_is_active'] = 'Off';
     $mu_option4delete[]='booking_auto_approve_new_bookings_is_active';

	// FixIn: 8.1.3.27.
        $default_options['booking_auto_approve_bookings_when_import'] = 'Off';
     $mu_option4delete[]='booking_auto_approve_bookings_when_import';
        $default_options['booking_auto_approve_bookings_when_zero_cost'] = 'Off';
     $mu_option4delete[]='booking_auto_approve_bookings_when_zero_cost';
        $default_options['booking_auto_approve_bookings_if_added_in_admin_panel'] = 'Off';
     $mu_option4delete[]='booking_auto_approve_bookings_if_added_in_admin_panel';

        $default_options['booking_auto_cancel_pending_unpaid_bk_is_active'] = 'Off';
     $mu_option4delete[]='booking_auto_cancel_pending_unpaid_bk_is_active';      
        $default_options['booking_auto_cancel_pending_unpaid_bk_time'] = '24';
     $mu_option4delete[]='booking_auto_cancel_pending_unpaid_bk_time';      
        $default_options['booking_auto_cancel_pending_unpaid_bk_is_send_email'] = 'On';
     $mu_option4delete[]='booking_auto_cancel_pending_unpaid_bk_is_send_email';      
        $default_options['booking_auto_cancel_pending_unpaid_bk_email_reason'] = __( 'This booking canceled because we did not receive payment and the administrator did not approve it.', 'booking' );
     $mu_option4delete[]='booking_auto_cancel_pending_unpaid_bk_email_reason';          
        $default_options['booking_range_selection_type'] = 'fixed';
     $mu_option4delete[]='booking_range_selection_type';
        $default_options['booking_range_selection_days_count'] = '3';
     $mu_option4delete[]='booking_range_selection_days_count';
        $default_options['booking_range_selection_days_max_count_dynamic'] = 30;
     $mu_option4delete[]='booking_range_selection_days_max_count_dynamic';
        $default_options['booking_range_selection_days_specific_num_dynamic'] = '';
     $mu_option4delete[]='booking_range_selection_days_specific_num_dynamic';
        $default_options['booking_range_start_day'] = '-1';
     $mu_option4delete[]='booking_range_start_day';
        $default_options['booking_range_selection_days_count_dynamic'] = '1';
     $mu_option4delete[]='booking_range_selection_days_count_dynamic';
        $default_options['booking_range_start_day_dynamic'] = '-1';
     $mu_option4delete[]='booking_range_start_day_dynamic';
        $default_options['booking_range_selection_time_is_active'] = 'Off';
     $mu_option4delete[]='booking_range_selection_time_is_active';
        $default_options['booking_range_selection_start_time'] = '12:00';
     $mu_option4delete[]='booking_range_selection_start_time';
        $default_options['booking_range_selection_end_time'] = '10:00';
     $mu_option4delete[]='booking_range_selection_end_time';
        $default_options['booking_change_over_days_triangles'] =  'On';         					// FixIn: 7.0.1.24.

     $mu_option4delete[]='booking_last_checkout_day_available';
        $default_options['booking_last_checkout_day_available'] = 'Off';         										// FixIn: 8.1.3.28.

     $mu_option4delete[]='booking_change_over_days_triangles';     

     $mu_option4delete[]='booking_change_over__is_excerpt_on_pages';
        $default_options['booking_change_over__is_excerpt_on_pages'] = 'Off';         									// FixIn: 8.9.4.10.
     $mu_option4delete[]='booking_change_over__excerpt_on_pages';
        $default_options['booking_change_over__excerpt_on_pages'] = '';         										// FixIn: 8.9.4.10.


        $default_options['booking_email_payment_request_adress'] = htmlspecialchars( '"Booking system" <' . get_option( 'admin_email' ) . '>' );
        $default_options['booking_email_payment_request_subject'] = __( 'You need to make payment for this reservation', 'booking' );
        /* translators: 1: ... */
        $default_options['booking_email_payment_request_content'] = htmlspecialchars( sprintf( __( 'You need to make payment %1$s for reservation %2$s at %3$s. %4$s Please make payment on this page: %5$s  Thank you, %6$s', 'booking' ), '[cost]', '[bookingtype]', '[dates]', '<br/><br/>[paymentreason]<br/><br/>[content]<br/><br/>', '[visitorbookingpayurl]<br/><br/>', $blg_title . '<br/>[siteurl]' ) );
        $default_options['booking_is_email_payment_request_adress'] = 'On';
        $default_options['booking_is_email_payment_request_send_copy_to_admin'] = 'Off';
    }
    
    
	// -----------------------------------------------------------------------------------------------------------------
    // BM
	// -----------------------------------------------------------------------------------------------------------------
    if ( class_exists( 'wpdev_bk_biz_m' ) ) {   

	    // FixIn: 8.1.3.15.
        $default_options['booking_is_show_booked_data_in_tooltips'] = 'Off';
     $mu_option4delete[]='booking_is_show_booked_data_in_tooltips';
        $default_options['booking_booked_data_in_tooltips'] =  '[name] [secondname]';
     $mu_option4delete[]='booking_booked_data_in_tooltips';

        $default_options['booking_number_for_pre_checkin_date_hint'] = '14';            // FixIn: 10.0.0.31.
     $mu_option4delete[]='booking_number_for_pre_checkin_date_hint';
        $default_options['booking_available_days_num_from_today'] = '';
     $mu_option4delete[]='booking_available_days_num_from_today';
        $default_options['booking_unavailable_extra_in_out'] = '';
     $mu_option4delete[]='booking_unavailable_extra_in_out';
        $default_options['booking_unavailable_extra_minutes_in'] = '';
     $mu_option4delete[]='booking_unavailable_extra_minutes_in';
        $default_options['booking_unavailable_extra_minutes_out'] = '';
     $mu_option4delete[]='booking_unavailable_extra_minutes_out';
        $default_options['booking_unavailable_extra_days_in'] = '';
     $mu_option4delete[]='booking_unavailable_extra_days_in';
        $default_options['booking_unavailable_extra_days_out'] = '';
     $mu_option4delete[]='booking_unavailable_extra_days_out';

        $default_options['booking_forms_extended'] = serialize( array() );
        $default_options['booking_advanced_costs_values'] = serialize( array() );
        $default_options['booking_is_resource_deposit_payment_active'] = 'On';
     $mu_option4delete[]='booking_is_resource_deposit_payment_active';        
        $default_options['booking_advanced_costs_calc_fixed_cost_with_procents'] = 'Off';
        $default_options['booking_is_show_cost_in_tooltips'] = 'Off';
     $mu_option4delete[]='booking_is_show_cost_in_tooltips';
        $default_options['booking_highlight_cost_word'] = __( 'Cost: ', 'booking' );
     $mu_option4delete[]='booking_highlight_cost_word';        
        $default_options['booking_is_show_cost_in_date_cell'] = 'Off';
     $mu_option4delete[]='booking_is_show_cost_in_date_cell';      
        $default_options['booking_cost_in_date_cell_currency'] = '&#36;';
     $mu_option4delete[]='booking_cost_in_date_cell_currency';         
        $default_options['booking_visitor_number_rate'] = '0';                  //Depricated
        $default_options['booking_visitor_number_rate_type'] = '%';             //Depricated    
    }
    
    
	// -----------------------------------------------------------------------------------------------------------------
    // BL
	// -----------------------------------------------------------------------------------------------------------------
    if ( class_exists( 'wpdev_bk_biz_l' ) ) {
    
// Get Key of Last added item to "$default_options" array
// $multiuser_general_option[] = implode( '', array_keys( array_slice( $default_options, -1 ) ) ); 
        
        $default_options['booking_check_out_available_for_parents'] = 'On';     
     $mu_option4delete[]='booking_check_out_available_for_parents';                 
        $default_options['booking_check_in_available_for_parents'] = 'Off';     
     $mu_option4delete[]='booking_check_in_available_for_parents';                 
        $default_options['booking_is_show_pending_days_as_available'] = 'Off';
     $mu_option4delete[]='booking_is_show_pending_days_as_available';                 
        $default_options['booking_auto_cancel_pending_bookings_for_approved_date'] = 'Off';
     $mu_option4delete[]='booking_auto_cancel_pending_bookings_for_approved_date';

        $default_options['booking_quantity_control'] = ( get_bk_option( 'booking_is_use_visitors_number_for_availability') == 'On' ) ? 'On' : 'Off';
     $mu_option4delete[]='booking_quantity_control';
        $default_options['booking_capacity_field'] = ( get_bk_option( 'booking_is_use_visitors_number_for_availability') == 'On' ) ? 'select^visitors' : '';
     $mu_option4delete[]='booking_capacity_field';

        $default_options['booking_is_show_availability_in_tooltips'] = 'On';                                            // FixIn: 8.1.3.8.
     $mu_option4delete[]='booking_is_show_availability_in_tooltips';                 
        $default_options['booking_highlight_availability_word'] = __( 'Available: ', 'booking' );
     $mu_option4delete[]='booking_highlight_availability_word';

        $default_options['booking_is_show_availability_in_date_cell'] = 'Off';                                          // FixIn: 10.6.4.1.
     $mu_option4delete[]='booking_is_show_availability_in_date_cell';
        $default_options['booking_highlight_availability_word_in_date_cell'] = __( 'available', 'booking' );
     $mu_option4delete[]='booking_highlight_availability_word_in_date_cell';


        $default_options['booking_is_dissbale_booking_for_different_sub_resources'] = 'Off';
     $mu_option4delete[]='booking_is_dissbale_booking_for_different_sub_resources';                 
// FixIn: 10.10.1.2          $default_options['booking_is_resource_no_update__during_editing'] = 'On';										// FixIn: 9.4.2.3.
// FixIn: 10.10.1.2       $mu_option4delete[]='booking_is_resource_no_update__during_editing';
        $default_options['booking_search_form_show'] = str_replace( '\\n\\r', "\n", wpbc_get_default_search_form_template( 'standard_search_form' ) );     	//FixIn:6.1.0.1		// FixIn: 8.5.2.11.
     $mu_option4delete[]='booking_search_form_show';                 
        $default_options['booking_found_search_item'] = str_replace( '\\n\\r', "\n", wpbc_get_default_search_results_template( 'advanced_search_results' ) );  //FixIn:6.1.0.1		// FixIn: 8.5.2.11.
     $mu_option4delete[]='booking_found_search_item';                 
        $default_options['booking_cache_expiration'] = '2d';
     $mu_option4delete[]='booking_cache_expiration';
        $default_options['booking_search_results_order'] = 'prioritet';													 // FixIn: 8.4.7.8.
     $mu_option4delete[]='booking_search_results_order';
        $default_options['booking_search_form_dates_format'] = 'yy-mm-dd';												// FixIn: 8.6.1.21.
     $mu_option4delete[]='booking_search_form_dates_format';
        $default_options['booking_search_results_days_select'] = 'Off';													// FixIn: 8.8.2.3.
     $mu_option4delete[]='booking_search_results_days_select';
        $default_options['booking_from_search_scroll_to_calendar'] = 'On';												// FixIn: 9.4.4.6.
     $mu_option4delete[]='booking_from_search_scroll_to_calendar';

        $default_options['booking_search_from_auto_open_checkout_cal'] = 'On';											// FixIn: 10.0.0.39.
     $mu_option4delete[]='booking_search_from_auto_open_checkout_cal';
        $default_options['booking_search_from__search_header'] = '[result_count] ' . __('Result(s) Found','booking');	// FixIn: 10.0.0.41.
     $mu_option4delete[]='booking_search_from__search_header';
        $default_options['booking_search_from__search_header_advanced'] = __( 'Extended Search Results', 'booking' );	// FixIn: 10.0.0.41.
     $mu_option4delete[]='booking_search_from__search_header_advanced';
        $default_options['booking_search_from__search_nothing_found'] = __('Nothing Found','booking');
     $mu_option4delete[]='booking_search_from__search_nothing_found';

        $default_options['booking_search_form__dates_required_enabled'] = 'Off';
     $mu_option4delete[]='booking_search_form__dates_required_enabled';
        $default_options['booking_search_form__dates_required_warning'] = __('Please select check-in and check-out dates to perform the search.','booking');
     $mu_option4delete[]='booking_search_form__dates_required_warning';


        //    Updated during regeneration  seacrh  cache
        //$default_options['booking_cache_content']='';
       $mu_option4delete[]='booking_cache_content';  
        //$default_options['booking_cache_created']=wpbc_datetime_localized( date ('Y-m-d H:i:s'), 'Y-m-d H:i:s' );
       $mu_option4delete[]='booking_cache_created';  
       $mu_option4delete[]='booking_resources_search_options';                                                          // FixIn: 10.0.0.18.
    }


	// -----------------------------------------------------------------------------------------------------------------
    // MU
	// -----------------------------------------------------------------------------------------------------------------
	if ( class_exists( 'wpdev_bk_multiuser' ) ) {

		// FixIn: 8.1.3.19.
			$default_options['booking_is_custom_forms_for_regular_users'] = 'Off';
		$mu_option4delete[]='booking_is_custom_forms_for_regular_users';

		// FixIn: 9.2.3.8.
			$default_options['booking_super_admin_receive_regular_user_payments'] = 'Off';
		$mu_option4delete[]='booking_super_admin_receive_regular_user_payments';
	}
    
    
    if ( ! $is_get_multiuser_general_options ) { 
        
        if ( ! empty( $option_name ) ) {
            
            if (isset( $default_options[ $option_name ] ))
                return $default_options[ $option_name ];                        // Return 1 option    
            else
                return  false;                                                  // Option does NOT exist
            
        } else {
            return $default_options;                                            // Return  ALL
        }
        
    } else
        return $mu_option4delete;                                               // Get options for MU
}


// <editor-fold     defaultstate="collapsed"                        desc="  Update Deprecated Options "  >
function wpbc_after_activation__update_deprecated_options() {
	update_bk_option( 'booking_form_is_using_bs_css', 'Off' );
}
add_bk_action( 'wpbc_after_activation', 'wpbc_after_activation__update_deprecated_options' );
// </editor-fold>
