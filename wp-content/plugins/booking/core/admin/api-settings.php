<?php
/**
 * @version     1.0
 * @package     General Settings API - Saving different options
 * @category    Settings API
 * @author      wpdevelop
 *
 * @web-site    https://wpbookingcalendar.com/
 * @email       info@wpbookingcalendar.com 
 * @modified    2016-02-24
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly


// General Settings API - Saving different options
class  WPBC_Settings_API_General extends WPBC_Settings_API {


    /**
	 * Override Settings API Constructor
     *   During creation,  system try to load values from DB, if exist.
     * 
     *  @param type $id - of Settings
     */
    public function __construct( $id = '' ){
          
        $options = array( 
                        'db_prefix_option' => ''                                // 'booking_' 
                      , 'db_saving_type'   => 'separate' 
                      , 'id'               => 'set_gen'
            ); 
        
        $id = empty($id) ? $options['id'] : $id;
                
        parent::__construct( $id, $options );                                   // Define ID of Setting page and options
                
        add_action( 'wpbc_after_settings_content', array($this, 'enqueue_js'), 10, 3 );
    }

    
    /** Init all fields rows for settings page */
    public function init_settings_fields() {
        
        $this->fields = array();

        $default_options_values = wpbc_get_default_options();


        // <editor-fold     defaultstate="collapsed"                        desc=" C a l e n d a r    S e c t i o n "  >


        //  Number of months  //////////////////////////////////////////////////
        $months_options = array();
        for ($mm = 1; $mm < 12; $mm++) { $months_options[ $mm . 'm' ] = $mm . ' ' .  __('month(s)' ,'booking'); }
		$months_options[ 18 . 'm' ] =  '18 ' .  __('month(s)' ,'booking');                                              // FixIn: 10.0.0.11.
        for ($yy = 1; $yy < 11; $yy++) { $months_options[ $yy . 'y' ] = $yy . ' ' .  __('year(s)' ,'booking');  }
        
        $this->fields['booking_max_monthes_in_calendar'] = array(   
                                    'type'          => 'select'
                                    , 'default'     => $default_options_values['booking_max_monthes_in_calendar']                   // '1y'            
                                    , 'title'       => __('Number of months to scroll', 'booking')
                                    , 'description' => __('Select the maximum number of months to show (scroll)' ,'booking')
                                    , 'options'     => $months_options
                                    , 'group'       => 'calendar'
                            );
        
        
        //  Start Day of the week  /////////////////////////////////////////////
        $this->fields['booking_start_day_weeek'] = array(   
                                    'type'          => 'select'
                                    , 'default' => $default_options_values['booking_start_day_weeek']                   // '2'            
                                    // , 'value' => false
                                    , 'title'       => __('Start Day of the week', 'booking')
                                    , 'description' => __('Select your start day of the week' ,'booking')
                                    , 'options'     => array(
                                                                  '0' => __('Sunday' ,'booking')
                                                                , '1' => __('Monday' ,'booking')
                                                                , '2' => __('Tuesday' ,'booking')
                                                                , '3' => __('Wednesday' ,'booking')
                                                                , '4' => __('Thursday' ,'booking')
                                                                , '5' => __('Friday' ,'booking')
                                                                , '6' => __('Saturday' ,'booking')                                        
                                                            )
                                    , 'group'       => 'calendar'
                            );

	    $this->fields['booking_calendar_allow_several_months_on_mobile'] = array(
	                            'type'          => 'checkbox'
	                            , 'default'     => $default_options_values['booking_calendar_allow_several_months_on_mobile']   //'Off'
	                            , 'title'       => __('Allow multiple months to be shown on mobile' ,'booking')  //__('Use time selections as recurrent time slots' ,'booking')
	                            , 'label'       => __('Enable this option to allow multiple months to be shown in the calendar on mobile devices. By default, the calendar only shows one month on mobile devices for easy scrolling.' ,'booking')
	                            //, 'description' => ''
	                            , 'group'       => 'calendar'
	                            , 'tr_class'    => ''
	        );

        //  Divider  ///////////////////////////////////////////////////////////        
        $this->fields['hr_calendar_after_week_day'] = array( 'type' => 'hr', 'group' => 'calendar' );
                
        

        $field_options = array(
                                  'single' => array(
                                                      'title' =>  __('Single day' ,'booking')
                                                    , 'attr' =>  array(
                                                                        'id' => 'type_of_day_selections_single'
                                                                    )
                                                )
                                , 'multiple' => array(
                                                      'title' =>  __('Multiple days' ,'booking')
                                                    , 'attr' =>  array(
                                                                        'id' => 'type_of_day_selections_multiple'
                                                                    )
                                                )
                            );
        //  Days  ///////////////////////////////////////////////////////////  
        $this->fields['booking_type_of_day_selections'] = array(   
                                    'type'          => 'radio'
                                    , 'default'     => $default_options_values['booking_type_of_day_selections']                   // 'multiple'            
                                    , 'title'       => __('Days selection in calendar', 'booking')
                                    , 'description' => ''
                                    , 'options'     => $field_options
                                    , 'group'       => 'calendar'
                            );
        
        ////////////////////////////////////////////////////////////////////////                                
        
        $this->fields = apply_filters( 'wpbc_settings_calendar_range_days_selection', $this->fields, $default_options_values );      // Range days

	    // FixIn: 10.1.5.4.
	    //$this->fields = apply_filters( 'wpbc_settings_calendar_recurrent_time_slots', $this->fields, $default_options_values );      // Recurent Times
		/**
		 * Recurrent time  - Settings ( Calendar ) page
		 */
        $this->fields['hr_calendar_before_recurrent_time'] = array( 'type' => 'hr', 'group' => 'calendar' , 'tr_class'    => 'wpbc_recurrent_check_in_out_time_slots');
	    $this->fields['booking_recurrent_time'] = array(
	                            'type'          => 'checkbox'
	                            , 'default'     => $default_options_values['booking_recurrent_time']   //'Off'
	                            , 'title'       => __('Use selected times for each booking date' ,'booking')  //__('Use time selections as recurrent time slots' ,'booking')
	                            , 'label'       => __('Enable this option if you want to use the selected times as booked time slots on each selected date. Otherwise, the selected times will be used as the check-in time for the first date and check-out time for the last date of the reservation.' ,'booking')
	                            //, 'description' => ''
	                            , 'group'       => 'calendar'
	                            , 'tr_class'    => 'wpbc_recurrent_check_in_out_time_slots'
	        );

	    $this->fields = apply_filters( 'wpbc_settings_calendar_check_in_out_times',   $this->fields, $default_options_values );      // Check In/Out Times


        // </editor-fold>


	    // <editor-fold     defaultstate="collapsed"                        desc=" Dates Tooltips "  >
	    		//FixIn: 9.5.0.2.2
	    $this->fields['booking_disable_timeslots_in_tooltip'] = array(
	                            'type'          => 'checkbox'
	                            , 'default'     => $default_options_values['booking_disable_timeslots_in_tooltip']   //'Off'
	                            , 'title'       => __('Disable times in tooltips' ,'booking')
	                            , 'label'       => __('Disable show booked times in tooltip, when mouse over specific day in calendar' ,'booking')
	                            , 'description' => ''
	                            , 'group'       => 'days_tooltips'
	                            , 'tr_class'    => ''
	        );

		// FixIn: 9.4.3.1.
        $this->fields['booking_highlight_timeslot_word'] = array(
                                'type'          => 'text'
                                , 'default'     => $default_options_values['booking_highlight_timeslot_word']   //__('Booked Times:' ,'booking')
                                , 'placeholder' => __('Booked Times:' ,'booking')
                                , 'title'       => __('Title of booked timeslot(s)' ,'booking')
								/* translators: 1: ... */
                                , 'description' => sprintf( __( 'Type your %1$stitle%2$s, what will show in mouseover tooltip near booked timeslot(s)', 'booking' ),'<b>','</b>')
                                //,'description_tag' => 'span'
                                , 'class'       => 'regular-text'
                                , 'group'       => 'days_tooltips'
	                            , 'tr_class'    => 'wpbc_booking_timeslots_in_tooltip wpbc_sub_settings_grayed'         //FixIn: 9.5.0.2.2
                        );
        $this->fields = apply_filters( 'wpbc_settings_calendar_showing_info_in_cal',  $this->fields, $default_options_values );      // Availability in calendar...
		$this->fields = apply_filters( 'wpbc_settings_calendar_show_booking_details',  $this->fields, $default_options_values );     // Show Booking details in mouse over tooltips
	    $this->fields = apply_filters( 'wpbc_settings_calendar_showing_cost_in_tooltip',  $this->fields, $default_options_values );  // Showing Cost,

		// </editor-fold>


        // <editor-fold     defaultstate="collapsed"                        desc=" L e g e n d    I t e m s "  >
        // Legend Items ////////////////////////////////////////////////////////

	    $this->fields['hr_calendar_before_legend'] = array( 'type' => 'hr', 'group' => 'calendar' );

        $this->fields['booking_is_show_legend'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_is_show_legend']         // 'Off'
                                , 'title'       => __('Show legend below calendar' ,'booking')
                                , 'label'       => __('Check this box to display a legend of dates below the booking calendar.' ,'booking')
                                , 'description' => ''
                                , 'group'       => 'calendar'
            );
        // Available item
        $this->fields['booking_legend_is_show_item_available_prefix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_legend_is_show_item_available 
                                                                            wpbc_calendar_legend_items wpbc_sub_settings_grayed">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'set_gen_booking_legend_is_show_item_available'
                                                                , array(   'title'=> __('Available item' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>'
                        );
        $this->fields['booking_legend_is_show_item_available'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_legend_is_show_item_available']         // 'On'
                                , 'is_new_line' => false
                                , 'group'       => 'calendar'
                                , 'only_field'  => true
            );
        $this->fields['booking_legend_text_for_item_available'] = array(
                                'type'          => 'text'
                                , 'default'     => $default_options_values['booking_legend_text_for_item_available']         // __('Available' ,'booking')
                                , 'placeholder' => __('Available' ,'booking')
                                , 'css'         => '' //'width:8em;'
                                , 'group'       => 'calendar'
                                , 'only_field'  => true
                        );
        $this->fields['booking_legend_is_show_item_available_sufix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        =>    '<p class="description" style="line-height: 1.7em;margin: 0;">'
                                                        /* translators: 1: ... */
                                                        . sprintf( __( 'Activate and type your %1$stitle of available%2$s item in legend', 'booking' ),'<b>','</b>')
                                                    . '</p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'
                        );
        // Pending item
        $this->fields['booking_legend_is_show_item_pending_prefix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_legend_is_show_item_pending 
                                                                            wpbc_calendar_legend_items wpbc_sub_settings_grayed">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'set_gen_booking_legend_is_show_item_pending'
                                                                , array(   'title'=> __('Pending item' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>'
                        );
        $this->fields['booking_legend_is_show_item_pending'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_legend_is_show_item_pending']         // 'On'
                                , 'is_new_line' => false
                                , 'group'       => 'calendar'
                                , 'only_field'  => true
            );
        $this->fields['booking_legend_text_for_item_pending'] = array(
                                'type'          => 'text'
                                , 'default'     => $default_options_values['booking_legend_text_for_item_pending']         // __('Pending' ,'booking')
                                , 'placeholder' => __('Pending' ,'booking')
                                , 'css'         => '' //'width:8em;'
                                , 'group'       => 'calendar'
                                , 'only_field'  => true
                        );
        $this->fields['booking_legend_is_show_item_pending_sufix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        =>    '<p class="description" style="line-height: 1.7em;margin: 0;">'
                                                        /* translators: 1: ... */
                                                        . sprintf( __( 'Activate and type your %1$stitle of pending%2$s item in legend', 'booking' ),'<b>','</b>')
                                                    . '</p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'
                        );
        // Approved item
        $this->fields['booking_legend_is_show_item_approved_prefix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_legend_is_show_item_approved 
                                                                            wpbc_calendar_legend_items wpbc_sub_settings_grayed">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'set_gen_booking_legend_is_show_item_approved'
                                                                , array(   'title'=> __('Approved item' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>'
                        );
        $this->fields['booking_legend_is_show_item_approved'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_legend_is_show_item_approved']         // 'On'
                                , 'is_new_line' => false
                                , 'group'       => 'calendar'
                                , 'only_field'  => true
            );
        $this->fields['booking_legend_text_for_item_approved'] = array(
                                'type'          => 'text'
                                , 'default'     => $default_options_values['booking_legend_text_for_item_approved']         //__('Booked' ,'booking')
                                , 'placeholder' => __('Booked' ,'booking')
                                , 'css'         => '' //'width:8em;'
                                , 'group'       => 'calendar'
                                , 'only_field'  => true
                        );
        $this->fields['booking_legend_is_show_item_approved_sufix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        =>    '<p class="description" style="line-height: 1.7em;margin: 0;">'
                                                        /* translators: 1: ... */
                                                        . sprintf( __( 'Activate and type your %1$stitle of approved%2$s item in legend', 'booking' ),'<b>','</b>')
                                                    . '</p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'
                        );

		//FixIn: 10.1.5.5       if ( class_exists('wpdev_bk_biz_s') ) {

        // Partially booked item
        $this->fields['booking_legend_is_show_item_partially_prefix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_legend_is_show_item_partially 
                                                                            wpbc_calendar_legend_items wpbc_sub_settings_grayed">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'set_gen_booking_legend_is_show_item_partially'
                                                                , array(   'title'=> __('Partially booked item' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>'
                        );
        $this->fields['booking_legend_is_show_item_partially'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_legend_is_show_item_partially']         //'On'
                                , 'is_new_line' => false
                                , 'group'       => 'calendar'
                                , 'only_field'  => true
            );
        $this->fields['booking_legend_text_for_item_partially'] = array(
                                'type'          => 'text'
                                , 'default'     => $default_options_values['booking_legend_text_for_item_partially']         //__('Partially booked' ,'booking')
                                , 'placeholder' => __('Partially booked' ,'booking')
                                , 'css'         => '' //'width:8em;'
                                , 'group'       => 'calendar'
                                , 'only_field'  => true
                        );
        $this->fields['booking_legend_is_show_item_partially_sufix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        =>    '<p class="description" style="line-height: 1.7em;margin: 0;">'
                                                        /* translators: 1: ... */
                                                        . sprintf( __( 'Activate and type your %1$stitle of partially booked%2$s item in legend', 'booking' ),'<b>','</b>')
                                                    . '</p>'
                                                    . '<p class="description" style="line-height: 1.7em;margin: 0;"><strong>' . esc_html__('Note' ,'booking') .':</strong> '
                                                        . sprintf(__('Partially booked item - day, which is booked for the specific time-slot(s).' ,'booking'),'<b>','</b>')
                                                    . '</p>'
                                                           .'</fieldset>
                                                        </td>
                                                    </tr>'
                        );
        //}


		// Unavailable Legend Item      // FixIn: 9.9.0.5.
        $this->fields['booking_legend_is_show_item_unavailable_prefix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_legend_is_show_item_unavailable 
                                                                            wpbc_calendar_legend_items wpbc_sub_settings_grayed">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'set_gen_booking_legend_is_show_item_unavailable'
                                                                , array(   'title'=> __('Unavailable item' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>'
                        );
        $this->fields['booking_legend_is_show_item_unavailable'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_legend_is_show_item_unavailable']         // 'On'
                                , 'is_new_line' => false
                                , 'group'       => 'calendar'
                                , 'only_field'  => true
            );
        $this->fields['booking_legend_text_for_item_unavailable'] = array(
                                'type'          => 'text'
                                , 'default'     => $default_options_values['booking_legend_text_for_item_unavailable']         //__('Booked' ,'booking')
                                , 'placeholder' => __('Unavailable' ,'booking')
                                , 'css'         => '' //'width:8em;'
                                , 'group'       => 'calendar'
                                , 'only_field'  => true
                        );
        $this->fields['booking_legend_is_show_item_unavailable_sufix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'calendar'
                                , 'html'        =>    '<p class="description" style="line-height: 1.7em;margin: 0;">'
                                                        /* translators: 1: ... */
                                                        . sprintf( __( 'Activate and type your %1$stitle of unavailable%2$s item in legend', 'booking' ),'<b>','</b>')
                                                    . '</p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'
                        );




//        //  Help Section ///////////////////////////////////////////////////////
//        $this->fields['booking_help_translation_section_after_legend_items'] = array(
//                                  'type'              => 'help'
//                                , 'value'             => wpbc_get_help_rows_about_config_in_several_languges()
//                                , 'class'             => ''
//                                , 'css'               => ''
//                                , 'description'       => ''
//                                , 'cols'              => 2
//                                , 'group'             => 'calendar'
//                                , 'tr_class'          => 'wpbc_calendar_legend_items wpbc_sub_settings_grayed'
//                                , 'description_tag'   => 'span'
//                        );
        $this->fields['booking_legend_is_show_numbers'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_legend_is_show_numbers']         //'On'
                                , 'title'       => __('Show date number in legend' ,'booking')
                                , 'label'       => sprintf(__('Check this box to display today date number in legend cells. ' ,'booking'),'<b>','</b>')
                                , 'description' => ''
                                , 'tr_class'    => 'wpbc_calendar_legend_items wpbc_sub_settings_grayed'
                                , 'group'       => 'calendar'
            );
		// FixIn: 9.4.3.6.
        $this->fields['booking_legend_is_vertical'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_legend_is_vertical']                //'Off'
                                , 'title'       => __('Show legend items in a column' ,'booking')
                                , 'label'       => sprintf(__('Check this box to display legend items vertically in a column.' ,'booking'),'<b>','</b>')
                                , 'description' => ''
                                , 'tr_class'    => 'wpbc_calendar_legend_items wpbc_sub_settings_grayed'
                                , 'group'       => 'calendar'
            );
        // </editor-fold>


        // <editor-fold     defaultstate="collapsed"                        desc=" A v a i l a b i l i t y "  >
        
        //  Unavailable Weekdays  /////////////////////////////////////////////

        $this->fields['booking_unavailable_day_html_prefix'] = array(   
                                    'type'          => 'pure_html'
                                    , 'group'       => 'availability'
                                    , 'html'        => '<tr valign="top">
                                                            <th scope="row">
                                                                <label class="wpbc-form-checkbox" for="' 
                                                                                // . esc_attr( 'unavailable_day0' ) 
                                                                . '">' . wp_kses_post(  __('Unavailable Weekdays' ,'booking') ) 
                                                                . '</label>
                                                            </th>
                                                            <td><fieldset>'
                            );        
        $this->fields['booking_unavailable_day0'] = array(  'label'  => __('Sunday' ,'booking')             
                                                    , 'type' => 'checkbox', 'default' => $default_options_values['booking_unavailable_day0'], 'only_field' => true, 'group' => 'availability', 'is_new_line' => false
                                            );
        $this->fields['booking_unavailable_day1'] = array(  'label'  => __('Monday' ,'booking')             
                                                    , 'type' => 'checkbox', 'default' => $default_options_values['booking_unavailable_day1'], 'only_field' => true, 'group' => 'availability', 'is_new_line' => false
                                            );
        $this->fields['booking_unavailable_day2'] = array(  'label'  => __('Tuesday' ,'booking')             
                                                    , 'type' => 'checkbox', 'default' => $default_options_values['booking_unavailable_day2'], 'only_field' => true, 'group' => 'availability', 'is_new_line' => false
                                            );
        $this->fields['booking_unavailable_day3'] = array(  'label'  => __('Wednesday' ,'booking')             
                                                    , 'type' => 'checkbox', 'default' => $default_options_values['booking_unavailable_day3'], 'only_field' => true, 'group' => 'availability', 'is_new_line' => false
                                            );
        $this->fields['booking_unavailable_day4'] = array(  'label'  => __('Thursday' ,'booking')             
                                                    , 'type' => 'checkbox', 'default' => $default_options_values['booking_unavailable_day4'], 'only_field' => true, 'group' => 'availability', 'is_new_line' => false
                                            );
        $this->fields['booking_unavailable_day5'] = array(  'label'  => __('Friday' ,'booking')             
                                                    , 'type' => 'checkbox', 'default' => $default_options_values['booking_unavailable_day5'], 'only_field' => true, 'group' => 'availability', 'is_new_line' => false
                                            );
        $this->fields['booking_unavailable_day6'] = array(  'label'  => __('Saturday' ,'booking')             
                                                    , 'type' => 'checkbox', 'default' => $default_options_values['booking_unavailable_day6'], 'only_field' => true, 'group' => 'availability', 'is_new_line' => false
                                            );
        $this->fields['booking_unavailable_day_html_sufix'] = array(   
                                    'type'          => 'pure_html'
                                    , 'group'       => 'availability'
                                    , 'html'        => '    </fieldset><p class="description">' 
                                                            . __('Select weekdays to be marked as unavailable in calendars. This setting will override all other availability settings.' ,'booking') 
                                                            . '</p>
                                                            </td>
                                                        </tr>'            
                            );        
 
        //  Divider  ///////////////////////////////////////////////////////////        
        $this->fields['hr_calendar_after_unavailable_day'] = array( 'type' => 'hr', 'group' => 'availability' );
        
        
        
        //  Unavailable days from today  ///////////////////////////////////////
        $field_options = array();


		// FixIn: 10.8.1.4.
		$field_options[0] = ' - ';
		foreach ( range( 5, 55 , 5 ) as $extra_num) {                                           // Each 5 minutes
		    $field_options[ $extra_num . 'm' ] = $extra_num . ' ' . __( 'minutes', 'booking' );
		}
		$field_options[ '60' . 'm' ] =  '1 ' . __( 'hour', 'booking' );
		foreach ( range( 65, 115 , 5 ) as $extra_num) {                                         // 1 hour + Each 5 minutes
		    $field_options[ $extra_num . 'm' ] =  '1 ' . __( 'hour', 'booking' ) . ' ' . ($extra_num - 60 ) . ' ' . __( 'minutes', 'booking' );
		}
		foreach ( range( 120, 1380 , 60 ) as $extra_num) {                                      // Each Hour based on minutes
		    $field_options[ $extra_num . 'm' ] = ($extra_num / 60) . ' ' . __( 'hours', 'booking' );
		}


		$field_options[ 1 ] = 1  . ' ' . __( 'day', 'booking' );
	    for ( $ii = 2; $ii < 92; $ii ++ ) {
		    $field_options[ $ii ] = $ii . ' ' . __( 'days', 'booking' );
	    }


		$unavailable_from_today_arr = wpbc_get_unavailable_from_today_hints_arr();

		$this->fields['booking_unavailable_days_num_from_today'] = array(
                                    'type'          => 'select'
                                    , 'default'     => $default_options_values['booking_unavailable_days_num_from_today']                                  //'0'            
                                    , 'title'       => __('Unavailable time from current time', 'booking')
                                    , 'description' => __('Select an unavailable time interval on the calendar, starting from today\'s current time.' ,'booking')
													   . '<br><code id="ui_btn_cstm__set_calendar_unavailable_from_today_hint" style="font-weight: 600;font-size: 10px;padding: 3px 5px;color: #626262;border-radius:2px;background: #f9f2f4">'
													   . '<span style="color: #cc3a5f;text-transform: uppercase;">' . esc_html( __( 'Unavailable', 'booking' ) ) . '</span>'
													   . $unavailable_from_today_arr['booking_unavailable_days_num_from_today__hint']
													   .'</code>'
                                    , 'options'     => $field_options
                                    , 'group'       => 'availability'
                            );

        //  Limit available days from today  ///////////////////////////////////        
        $this->fields = apply_filters( 'wpbc_settings_calendar_unavailable_days', $this->fields, $default_options_values );
        

        //  Extend unavailable booking dates interval - cleaning  //////////////        
        $this->fields = apply_filters( 'wpbc_settings_calendar_extend_unavailable_interval', $this->fields, $default_options_values );
        
        // </editor-fold>


	    // <editor-fold     defaultstate="collapsed"                        desc=" B o o k i n g    C o n f i r m a t i o n "  >

        $field_options = array(
                                    'message'  => array( 'title' => __('Show booking confirmation at same page' ,'booking'), 'attr' => array( 'id' => 'type_of_thank_you_message_message' ) )
                                  , 'page'     => array( 'title' => __('Redirect to thank you page' ,'booking'), 'attr' => array( 'id' => 'type_of_thank_you_message_page' ) )
                            );
	    $description_text = '';

        $this->fields['booking_type_of_thank_you_message'] = array(   
                                    'type'          => 'radio'
                                    , 'default'     => $default_options_values['booking_type_of_thank_you_message']         //'message'            
                                    , 'title'       => __('After  booking action:' ,'booking')
                                    , 'description' => $description_text
                                    , 'options'     => $field_options
                                    , 'group'       => 'booking_confirmation'
                            );

//        $this->fields['booking_title_after_reservation_time'] = array(
//                                'type'          => 'text'
//                                , 'default'     => $default_options_values['booking_title_after_reservation_time']         //'7000'
//                                , 'placeholder' => '7000'
//                                , 'title'       => __('Time of message showing' ,'booking')
//                                , 'description' => sprintf(__('Set duration of time (milliseconds) to show this message' ,'booking'),'<b>','</b>')
//                                           . ' ' . sprintf(__('You can set the value to %s to display the message indefinitely.' ,'booking'),'<b>0</b>')            // FixIn: 9.6.2.2.
//                                , 'description_tag' => 'span'
//                                , 'css'         => 'width:5em'
//                                , 'group'       => 'booking_confirmation'
//                                , 'tr_class'    => 'wpbc_calendar_thank_you_message wpbc_calendar_thank_you wpbc_sub_settings_grayed'
//                        );
//        //  Help Section ///////////////////////////////////////////////////////
//        $this->fields['booking_help_translation_section_after_thank_you_message'] = array(   
//                                  'type'              => 'help'
//                                , 'value'             => wpbc_get_help_rows_about_config_in_several_languges()
//                                , 'class'             => ''
//                                , 'css'               => ''
//                                , 'description'       => ''
//                                , 'cols'              => 2 
//                                , 'group'             => 'booking_confirmation'
//                                , 'tr_class'          => 'wpbc_calendar_thank_you_message wpbc_calendar_thank_you wpbc_sub_settings_grayed'
//                                , 'description_tag'   => 'span'
//                        );

        //  URL of "Thank you page"
        $this->fields['booking_thank_you_page_URL_prefix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'booking_confirmation'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_thank_you_page_URL 
                                                                            wpbc_calendar_thank_you_page wpbc_calendar_thank_you wpbc_sub_settings_grayed">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'set_gen_booking_thank_you_page_URL'
                                                                , array(   'title'=> __('Confirmation Page URL' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset>' . '<code style="font-size:14px;">' . home_url() . '</code>'         // FixIn: 7.0.1.20.
                        );                
        $this->fields['booking_thank_you_page_URL'] = array(   
                                'type'          => 'text'
                                , 'default'     => $default_options_values['booking_thank_you_page_URL']         //'/thank-you'
                                , 'placeholder' => '/thank-you'
                                , 'css'         => 'width:75%'
                                , 'group'       => 'booking_confirmation'
                                , 'only_field'  => true           
                        );
        $this->fields['booking_thank_you_page_URL_sufix'] = array(   
                                'type'          => 'pure_html'
                                , 'group'       => 'booking_confirmation'
                                , 'html'        =>    '<p class="description" style="line-height: 1.7em;margin: 0;">'
                                                      /* translators: 1: ... */
                                                      . sprintf( __( 'This page should include the shortcode %s to display booking details and confirmation after a successful booking.', 'booking' )
														        , '<strong>[booking_confirm]</strong>' )
                                                    . '</p>
                                                           </fieldset>
                                                        </td>
                                                    </tr>'            
                        );        
        // </editor-fold>

// FixIn: 10.2.0.1.

	    // <editor-fold     defaultstate="collapsed"                        desc=" ==  B o o k i n g    C o n f i r m a t i o n         -       CONFIG  == "  >

		// -------------------------------------------------------------------------------------------------------------
		// Message title
	    // -------------------------------------------------------------------------------------------------------------
        $this->fields['booking_title_after_reservation'] = array(
                                'type'          => 'text'
                                , 'default'     => $default_options_values['booking_title_after_reservation']
                                , 'placeholder' =>  ( ! class_exists( 'wpdev_bk_biz_s' ) )
															? __( 'Your booking is received. We will confirm it soon. Many thanks!', 'booking' )
															: __( 'Your booking is received. Please proceed with payment to confirm it. Many thanks!', 'booking' )
                                , 'title'       => __( 'Message title', 'booking' )
                                /* translators: 1: ... */
                                , 'description' => ''//sprintf( __( 'Type title of message %1$safter booking has done by user%2$s', 'booking' ),'<b>','</b>')
                                ,'description_tag' => 'p'
                                , 'css'         => 'width:100%'
                                , 'rows' => 2
                                , 'group'       => 'booking_confirmation'
                                , 'tr_class'    => '  '
                        );
		// -------------------------------------------------------------------------------------------------------------
		// Header
	    // -------------------------------------------------------------------------------------------------------------
        $this->fields['booking_confirmation_header_prefix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'booking_confirmation'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_confirmation_header">
                                                        <th scope="row">'.
                                                            WPBC_Settings_API::label_static( 'set_gen_booking_confirmation_header'
                                                                , array(   'title'=> __('Header' ,'booking'), 'label_css' => '' ) )
                                                        .'</th>
                                                        <td><fieldset style="display:flex;flex-flow: row wrap;justify-content: flex-start;align-items: center;">'
                        );
        $this->fields['booking_confirmation_header_enabled'] = array(
                                  'type'        => 'checkbox'
                                , 'default'     => $default_options_values['booking_confirmation_header_enabled']
                                , 'is_new_line' => false
                                , 'group'       => 'booking_confirmation'
                                , 'only_field'  => true
	                            , 'css'         => 'flex:0 0 auto;margin-right:10px;'
                                , 'label'       => __('Enable', 'booking')
                        );

        $this->fields['booking_confirmation_header'] = array(
                                  'type'        => 'text'
                                , 'default'     => $default_options_values['booking_confirmation_header']
                                /* translators: 1: ... */
                                , 'placeholder' => sprintf( __( 'Your booking id: %s', 'booking' ), '<strong>[booking_id]</strong>' )
                                , 'css'         => 'flex:1 1 auto;'
                                , 'group'       => 'booking_confirmation'
	                            , 'class'       => 'wpbc_booking_confirmation_header__field'
                                , 'only_field'  => true
                        );
	    $this->fields['booking_confirmation_header_sufix'] = array( 'type' => 'pure_html', 'group' => 'booking_confirmation', 'html' => '</fieldset> </td> </tr>' );
		// </editor-fold>


		//$is_use_code_mirror =((function_exists( 'wpbc_codemirror') ) && ( is_user_logged_in() && 'false' !== (wp_get_current_user()->syntax_highlighting))) ? true : false; //FixIn: 8.4.7.18  it does not work ?
		$is_use_code_mirror = true;

	    // <editor-fold     defaultstate="collapsed"                        desc=" ==  B o o k i n g    C o n f i r m a t i o n         -       == Personal Information == "  >
		// -------------------------------------------------------------------------------------------------------------
		// == Personal Information ==
	    // -------------------------------------------------------------------------------------------------------------
        $this->fields['booking_confirmation__personal_info__prefix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'booking_confirmation_left'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_confirmation__personal_info__header_enabled">
                                                        <td colspan="2" style="padding-bottom: 0;" ><fieldset style="display: flex;flex-flow: row wrap;justify-content: flex-start;align-items: center;">'
                        );

        $this->fields['booking_confirmation__personal_info__header_enabled'] = array(
                                      'type'        => 'checkbox'
                                    , 'default'     => $default_options_values['booking_confirmation__personal_info__header_enabled']
	                                , 'is_new_line' => false
	                                , 'only_field'  => true
                                    , 'label'       => __( 'Enable', 'booking' )
                                    , 'css'         => 'flex:0 0 auto;margin-right:5px;'
                                    , 'group'       => 'booking_confirmation_left'
                                );
        $this->fields['booking_confirmation__personal_info__title'] = array(
                                      'type'        => 'text'
                                    , 'default'     => $default_options_values['booking_confirmation__personal_info__title']
                                    , 'placeholder' => __( 'Example', 'booking' ) . ": '" . __( 'Personal information', 'booking' ) . "'"
                                    , 'title'       => ''
                                    , 'description' => ''
                                    , 'css'         => 'flex: 1 1 100px;font-size: 16px;line-height: 34px;font-weight: 600;width:auto;'
                                    , 'group'       => 'booking_confirmation_left'
                                    , 'class'    => 'wpbc_booking_confirmation__personal_info__field'
                                    , 'tr_class'    => ''
									, 'only_field'  => true
                            );
		$this->fields['booking_confirmation__personal_info__sufix'] = array( 'type' => 'pure_html', 'group' => 'booking_confirmation_left',
																			 'html' => '<p style="text-align: right;font-size:12px;width:100%;">'
												/* translators: 1: ... */
												. sprintf( __( 'Enter %1$stitle%2$s for this section of Booking Confirmation', 'booking' ),'<b>','</b>')
																			           . '.</p>' . '</fieldset> </td> </tr>' );

		$wpbc_metabox_id = 'confirmation_left_cont__promote_upgrade';

	    $this->fields['booking_confirmation__personal_info__content_before'] = array(
												'type'  => 'pure_html',
												'group' => 'booking_confirmation_left',
												'html'  => '<tr class="'.$wpbc_metabox_id.'_close_content wpbc_booking_confirmation__personal_info__fields '
												             //. ( ( ! class_exists( 'wpdev_bk_personal' ) ) ? 'wpbc_blur' : '' )
                                                             .'"><td colspan="2" style="padding-top:0;">'
															   . '<div style="margin: 0 0 10px;font-weight: 600;font-size: 14px;">'
															   . '<label class="wpbc-form-email-content" for="booking_confirmation__personal_info__content">' .
																   __( 'Content', 'booking' )
															   . '</label></div>'
											);
        $this->fields['booking_confirmation__personal_info__content'] = array(
                                      'type'        => ( $is_use_code_mirror ? 'textarea' : 'wp_textarea' )				// FixIn: 8.4.7.18.
                                    , 'default'     => $default_options_values['booking_confirmation__personal_info__content']
	                                                   // '[content]'
                                    //, 'placeholder' => '[content]'
                                    , 'title'       => __('Content', 'booking')
                                    //, 'description' => __('Example', 'booking') . ': ' . '[content]'
                                    , 'description_tag' => ''
                                    , 'css'         => 'width:100%;height:70px;'
                                    , 'group'       => 'booking_confirmation_left'
                                    , 'tr_class'    => ''//(  class_exists('wpdev_bk_personal') ) ? 'wpbc_blur' : ''
                                    , 'rows'        => 2
                                    , 'show_in_2_cols' => true
									, 'only_field'  => true
                            );
		$this->fields['booking_confirmation__personal_info__content_after'] = array( 'type'  => 'pure_html', 'group' => 'booking_confirmation_left', 'html'  => '</td></tr>' );

		/*
		if (  ! class_exists( 'wpdev_bk_personal' ) ) {
			ob_start();
			$is_panel_visible = wpbc_is_dismissed( $wpbc_metabox_id . '_close', array(
													'title' => '<i class="menu_icon icon-1x wpbc_icn_close"></i> ',
													'hint'  => __( 'Dismiss', 'booking' ),
													'class' => 'wpbc_panel_get_started_dismiss',
													'css'   => 'background: #fff;border-radius: 7px;',
													'dismiss_css_class' => '.' . $wpbc_metabox_id . '_close_content'
												));
			if ( ! $is_panel_visible ) {
				?><script type="text/javascript"> jQuery('#<?php echo esc_attr( $wpbc_metabox_id ); ?>_close,.<?php echo esc_attr( $wpbc_metabox_id ); ?>_close_content').hide(); </script><?php
			}
			$dismiss_button_content = ob_get_clean();

			if (  $is_panel_visible ){

			    $this->fields['booking_confirmation_left__promote_upgrade'] = array(
	                                'type'          => 'pure_html'
	                                , 'group'       => 'booking_confirmation_left'
			                        , 'html' => '<tr id="'.$wpbc_metabox_id.'_close" class="wpbc_booking_confirmation__personal_info__fields"><td colspan="2">													
										            <div class="wpbc_widget_content" style="transform: translate(0) translateY(-9em);">									        		
														<div class="ui_container    ui_container_toolbar		ui_container_small" style="background: #fff;position: relative;">
															<div class="ui_group    ui_group__upgrade">
																<div style="transform: translate(0%) translateY(-2.75em);position: relative;z-index:9;width: 85.6%;">'.$dismiss_button_content.'</div>
																<div class="wpbc_upgrade_note wpbc_upgrade_theme_green">
																	<div>This <a target="_blank" href="https://wpbookingcalendar.com/features/#personal">feature</a> 
																		 is available in the <strong>Pro</strong> versions. 
																		<a target="_blank" href="https://wpbookingcalendar.com/prices/#bk_news_section">Upgrade to Pro</a>.																
																	</div>
																</div>
															</div>														
														</div>
													</div>
										    </td> </tr>'
	                        );
			}
		}
		*/
		// </editor-fold>


	    // <editor-fold     defaultstate="collapsed"                        desc=" ==  B o o k i n g    C o n f i r m a t i o n         -       == Booking details == "  >
		// -------------------------------------------------------------------------------------------------------------
		// == Booking details ==
	    // -------------------------------------------------------------------------------------------------------------
        $this->fields['booking_confirmation__booking_details__prefix'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'booking_confirmation_right'
                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_confirmation__booking_details__header_enabled">
                                                        <td colspan="2" style="padding-bottom: 0;" ><fieldset style="display: flex;flex-flow: row wrap;justify-content: flex-start;align-items: center;">'
                        );

        $this->fields['booking_confirmation__booking_details__header_enabled'] = array(
                                      'type'        => 'checkbox'
                                    , 'default'     => $default_options_values['booking_confirmation__booking_details__header_enabled']
	                                , 'is_new_line' => false
	                                , 'only_field'  => true
                                    , 'label'       => __( 'Enable', 'booking' )
                                    , 'css'         => 'flex:0 0 auto;margin-right:5px;'
                                    , 'group'       => 'booking_confirmation_right'
                                );
        $this->fields['booking_confirmation__booking_details__title'] = array(
                                      'type'        => 'text'
                                    , 'default'     => $default_options_values['booking_confirmation__booking_details__title']
        							, 'placeholder' => __( 'Example', 'booking' ) . ": '" . __( 'Booking details', 'booking' ) . "'"
                                    , 'title'       => ''
                                    , 'description' => ''
                                    , 'css'         => 'flex: 1 1 100px;font-size: 16px;line-height: 34px;font-weight: 600;;width:auto;'
                                    , 'group'       => 'booking_confirmation_right'
	                                , 'class' => 'wpbc_booking_confirmation__booking_details__field'
                                    , 'tr_class'    => ''
									, 'only_field'  => true
                            );
		$this->fields['booking_confirmation__booking_details__sufix'] = array( 'type' => 'pure_html', 'group' => 'booking_confirmation_right',
																			 'html' => '<p style="text-align: right;font-size:12px;width:100%;">'
												/* translators: 1: ... */
												. sprintf( __( 'Enter %1$stitle%2$s for this section of Booking Confirmation', 'booking' ),'<b>','</b>')
																			           . '.</p>' . '</fieldset> </td> </tr>' );
	    $this->fields['booking_confirmation__booking_details__content_before'] = array(
												'type'  => 'pure_html',
												'group' => 'booking_confirmation_right',
												'html'  => '<tr class="wpbc_booking_confirmation__booking_details__fields"><td colspan="2" style="padding-top:0;">'
															   . '<div style="margin: 0 0 10px;font-weight: 600;font-size: 14px;">'
															   . '<label class="wpbc-form-email-content" for="booking_confirmation__booking_details__content">' .
																   __( 'Content', 'booking' )
															   . '</label></div>'
											);
        $this->fields['booking_confirmation__booking_details__content'] = array(
                                      'type'        => ( $is_use_code_mirror ? 'textarea' : 'wp_textarea' )				// FixIn: 8.4.7.18.
                                    , 'default'     => $default_options_values['booking_confirmation__booking_details__content']
													//    ( ( class_exists( 'wpdev_bk_personal' ) ) ? '<h4 class="wpbc_ty__section_text_resource">[resource_title]</h4>' : '' )
													//  . '<div class="wpbc_ty__section_text_dates">' . esc_html__( 'Dates', 'booking' ) . ': <strong>[dates]</strong></div>'
													//  . '<div class="wpbc_ty__section_text_times">' . esc_html__( 'Time', 'booking' ) . ': <strong>[times]</strong></div>'
                                    //, 'placeholder' => '[content]'
                                    , 'title'       => __('Content', 'booking')
                                    //, 'description' => __('Example', 'booking') . ': ' . '[content]'
                                    , 'description_tag' => ''
                                    , 'css'         => 'width:100%;height:70px;'
                                    , 'group'       => 'booking_confirmation_right'
                                    , 'tr_class'    => ''
                                    , 'rows'        => 10
                                    , 'show_in_2_cols' => true
									, 'only_field'  => true
                            );
		$this->fields['booking_confirmation__booking_details__content_after'] = array( 'type'  => 'pure_html', 'group' => 'booking_confirmation_right', 'html'  => '</td></tr>' );

		// </editor-fold>


		// <editor-fold     defaultstate="collapsed"                        desc=" ==  B o o k i n g    C o n f i r m a t i o n         -        == Help Shortcodes == "  >
		        ////////////////////////////////////////////////////////////////////
        // Help
        ////////////////////////////////////////////////////////////////////

        $this->fields['booking_confirmation_help_shortcodes'] = array(
                                      'type' => 'help'
                                    , 'value' => array()
                                    , 'cols' => 2
                                    , 'group' => 'booking_confirmation_help'
									, 'css' => 'margin:10px 0 0; padding: 0 5px 0 0 !important;overflow: auto;border:none;max-height: 445px;'
									, 'only_field'  => true
                            );

        $skip_shortcodes = array(
                                'denyreason'
                              , 'moderatelink'
                              , 'paymentreason'
                              , 'visitorbookingediturl'
		 					  , 'visitorbookingslisting'
                              , 'visitorbookingcancelurl'
                              , 'visitorbookingpayurl'
                          );
        $email_example = '';

        $help_fields = wpbc_get_email_help_shortcodes( $skip_shortcodes, $email_example );
	    if ( class_exists( 'wpdev_bk_personal' ) ) {
		    array_shift( $help_fields );
		    array_shift( $help_fields );
	    }
		$icn = '<a 	href="https://wpbookingcalendar.com/faq/#available_shortcodes" 
					class="tooltip_top wpbc-bi-question-circle wpbc_help_tooltip_icon_left" 				 
					data-original-title="%2$s"></a> %1$s';
		/* translators: 1: ... */
		$this->fields['booking_confirmation_help_shortcodes']['value'][] = sprintf( $icn, '<code>[readable_dates]</code>', sprintf( __('%s - dates in readable format' ,'booking'), '[readable_dates]' ) );
		/* translators: 1: ... */
		$this->fields['booking_confirmation_help_shortcodes']['value'][] = sprintf( $icn, '<code>[readable_times]</code>', sprintf( __('%s - time in readable format' ,'booking'), '[readable_times]' ) );

        foreach ( $help_fields as $help_fields_key => $help_fields_value ) {
            $this->fields['booking_confirmation_help_shortcodes']['value'][] = $help_fields_value;
        }

	    // </editor-fold>

        // <editor-fold     defaultstate="collapsed"                        desc=" Booking Admin Panel "  >

        $field_options = array(
                                  'vm_booking_listing' => __('Bookings Listing' ,'booking')                             // FixIn: 9.6.3.5.
                                , 'vm_calendar' => __('Timeline View' ,'booking')
                            );   
        $this->fields['booking_listing_default_view_mode'] = array(   
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_listing_default_view_mode']         //'vm_calendar'            
                                , 'title'       => __('Default booking admin page', 'booking')
                                , 'description' => __('Select your default view mode of bookings at the booking listing page' ,'booking')
                                , 'options'     => $field_options
                                , 'group'       => 'booking_listing'
                        );

        // Default booking resources.
        $this->fields = apply_filters( 'wpbc_settings_booking_listing_br_default_count', $this->fields, $default_options_values );


		// FixIn: 8.6.1.13.

        // Calendar Default View mode 
        if ( class_exists( 'wpdev_bk_personal' ) ) 
            $field_options = array(
                                      '1' => __('Day' ,'booking')
                                    , '7' => __('Week' ,'booking')
                                    , '30' => __('Month' ,'booking')
                                    , '60' => __('2 Months' ,'booking')
                                    , '90' => __('3 Months' ,'booking')
                                    , '365' => __('Year' ,'booking')
                                );                                                      
        else
             $field_options = array(
                                      '30' => __('Month' ,'booking')        // Day   ?
                                    , '90' => __('3 Months' ,'booking')     // Week  ?
                                    , '365' => __('Year' ,'booking')        // Month ?
                                );                                                      
        $this->fields['booking_view_days_num'] = array( 
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_view_days_num']         //'30'            
                                , 'title'       => __('Default view mode', 'booking')
                                , 'description' => __('Select your default calendar view mode at booking calendar overview page' ,'booking')
                                , 'options'     => $field_options
                                , 'group'       => 'booking_calendar_overview'   //FixIn: 8.5.2.20  // FixIn: 8.9.4.4.
                        );

		// FixIn: 8.9.4.3.
	    $field_options = array();
	    foreach ( range( 1, 31, 1) as $value ) {
	        $field_options[ $value ] = $value;
	    }
	    $this->fields['booking_calendar_overview__day_mode__days_number_show'] = array(
	                            'type'          => 'select'
	                            , 'default'     => $default_options_values['booking_calendar_overview__day_mode__days_number_show']   // 31
	                            , 'title'       => __('Days number to show in day view mode', 'booking')
	                            /* translators: 1: ... */
	                            , 'description' => sprintf( __( 'Select number of days to show in %1$sDay%2$s view mode', 'booking' ),'<b>','</b>')
		                                           . ( ( class_exists( 'wpdev_bk_personal' ) ) ? ' ' . __( 'for one booking resource', 'booking' ) : '' )
	                            , 'options'     => $field_options
	                            , 'group'       => 'booking_calendar_overview'  // FixIn: 8.9.4.4.
	                    );
	    $this->fields['booking_timeline__month_mode__days_number_show'] = array(
	                            'type'          => 'select'
	                            , 'default'     => $default_options_values['booking_timeline__month_mode__days_number_show']           //31
	                            , 'title'       => __('Days number to show in month view mode', 'booking')
	                            , 'description' => __('Select number of days to show in month view mode for one booking resource.' ,'booking')
	                            , 'options'     => $field_options
	                            , 'group'       => 'booking_timeline'
	                    );


        //Default Titles in Calendar cells
        $this->fields = apply_filters( 'wpbc_settings_booking_listing_timeline_title_in_day', $this->fields, $default_options_values );


	    // FixIn: 9.6.3.5.

	    // <editor-fold     defaultstate="collapsed"                        desc="  ==  Dates : Time  ==  "  >
		$timezone_error_message = '';
		if ( 'UTC' !== date_default_timezone_get() ) {
			$timezone_error_message .= '<div style="line-height: 2em;margin-bottom:2em;" class="wpbc-settings-notice notice-error">';
			$timezone_error_message .= '<strong>' . esc_html__( 'PHP default timezone is invalid', 'booking' ) . '</strong>. ';
			$timezone_error_message .= '<a href="' . esc_url( admin_url( 'site-health.php' ) ) . '">' .  __( 'Read more' , 'booking' )  . '</a>' . '<br/>';
			/* translators: 1: ... */
			$timezone_error_message .= sprintf( __( 'Find additional details %1$shere%2$s', 'booking' ), '<a href="https://make.wordpress.org/core/2019/09/23/date-time-improvements-wp-5-3/">', '</a>' );
			$timezone_error_message .= '</div>';
		}

        $this->fields['system_timezones'] = array(
                           'type'              => 'html'
                         , 'html'             =>  $timezone_error_message
                                                  . '<div style="line-height: 2em;">'
	                                                 . __( 'Server Default Timezone', 'booking' ) . ': <strong>' . date_default_timezone_get()  . '</strong><br/>'
	                                                 . __( 'WordPress Timezone', 'booking' )      . ': <strong>' . wp_timezone()->getName()     . '</strong>'
											     . '</div>'

                         , 'class'             => ''
                         , 'css'               => 'margin:0;padding:0;border:0;'
                         , 'cols'              => 2
                         , 'group'             => 'date_time'
                 );

		$this->fields['hr_booking_date_format'] = array( 'type' => 'hr', 'group' => 'date_time' );
		// -------------------------------------------------------------------------------------------------------------
        // Default Dates View Mode
		// -------------------------------------------------------------------------------------------------------------
        $this->fields['booking_date_view_type'] = array(
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_date_view_type']         //'short'
                                , 'title'       => __('Dates view', 'booking')
                                , 'description' =>  __('Select the default view for dates on the booking tables' ,'booking')
                                , 'options'     =>  array(
							                                 'short' => __('Short days view' ,'booking')
							                               , 'wide' => __('Wide days view' ,'booking')
							                            )
                                , 'group'       => 'date_time'
                        );
		$this->fields['hr_booking_time_format'] = array( 'type' => 'hr', 'group' => 'date_time' );
		// -------------------------------------------------------------------------------------------------------------
        // Dates : Time
		// -------------------------------------------------------------------------------------------------------------

        $this->fields['booking_date_format_html_prefix'] = array(
                                    'type'          => 'pure_html'
                                    , 'group'       => 'date_time'
                                    , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_date_format">
                                                            <th scope="row">'.
                                                                WPBC_Settings_API::label_static( 'set_gen_booking_date_format'
                                                                    , array(   'title'=> __('Date Format' ,'booking'), 'label_css' => 'margin: 0.25em 0 !important;vertical-align: middle;' ) )
                                                            .'</th>
                                                            <td><fieldset>'
                            );          
        $field_options = array();
	    foreach ( array( 'j M Y', 'F j, Y', 'Y/m/d', 'm/d/Y', 'd/m/Y' ) as $format ) {
            $field_options[ esc_attr($format) ] = array( 'title' => date_i18n( $format ) );
        }
        $field_options['custom'] =  array( 'title' =>  __('Custom' ,'booking') . ':', 'attr' =>  array( 'id' => 'date_format_selection_custom' ) );

        $this->fields['booking_date_format_selection'] = array(   
                                      'type'        => 'radio'
                                    , 'default'     => get_option('date_format')
                                    , 'options'     => $field_options
                                    , 'group'       => 'date_time'
                                    , 'only_field'  => true
	                                , 'is_new_line' => !true
                            );

        $booking_date_format = get_bk_option( 'booking_date_format');       
        $this->fields['booking_date_format'] = array(  
                                'type'          => 'text'
                                , 'default'     => $default_options_values['booking_date_format']         //get_option('date_format')
                                , 'value'       => htmlentities( $booking_date_format )      // Display value of this field in specific way
                                , 'group'       => 'date_time'
                                , 'placeholder' => get_option('date_format')
                                , 'css'         => 'width:auto;margin: 10px 0;'
                                , 'only_field'  => true
            );
        $this->fields['booking_date_format_html_sufix'] = array(   
                                      'type'        => 'pure_html'
                                    , 'group'       => 'date_time'
                                    , 'html'        => '<span class="description" style="padding:0;"><code>' . date_i18n( $booking_date_format ) . '</code></span>
                                                               </fieldset>
                                                            </td>
                                                        </tr>'            
                            );        
        $this->fields['booking_date_format_help'] = array(
                           'type'              => 'html'
                         , 'html'             => '<div style="line-height: 2em;">'.
														/* translators: 1: ... */
														sprintf( __( 'Type your date format for emails and the booking table. %1$sDocumentation on date formatting%2$s', 'booking' ),'<br/><a href="https://wordpress.org/documentation/article/customize-date-and-time-format/" target="_blank">','</a>')
                                                 .'</div>'
                         , 'class'             => ''
                         , 'css'               => 'margin:0;padding:0;border:0;'
                         , 'description'       => ''
                         , 'cols'              => 2
                         , 'group'             => 'date_time'
                         , 'tr_class'          => ''
                         , 'description_tag'   => 'div'
                 );


        // -------------------------------------------------------------------------------------------------------------
	    // Time Format
	    // -------------------------------------------------------------------------------------------------------------

	    $this->fields['booking_time_format_html_prefix'] = array(
	                                'type'          => 'pure_html'
	                                , 'group'       => 'date_time'
	                                , 'html'        => '<tr valign="top" class="wpbc_tr_set_gen_booking_time_format">
	                                                        <th scope="row">'.
	                                                            WPBC_Settings_API::label_static( 'set_gen_booking_time_format'
	                                                                , array(   'title'=> __('Time Format' ,'booking'), 'label_css' => 'margin: 0.25em 0 !important;vertical-align: middle;' ) )
	                                                        .'</th>
	                                                        <td><fieldset>'
	                        );
	    $field_options = array();
	    foreach ( array( 'g:i a', 'g:i A', 'H:i' ) as $format ) {
	        $field_options[ esc_attr($format) ] = array( 'title' => date_i18n( $format ) );
	    }
	    $field_options['custom'] =  array( 'title' =>  __('Custom' ,'booking') . ':', 'attr' =>  array( 'id' => 'time_format_selection_custom' ) );

	    $this->fields['booking_time_format_selection'] = array(
	                                'type'          => 'radio'
	                                , 'default'     => 'H:i'
	                                , 'options'     => $field_options
	                                , 'group'       => 'date_time'
	                                , 'only_field'  => true
                                    , 'is_new_line' => ! true
	                        );

	    $booking_time_format = get_bk_option( 'booking_time_format');
	    $this->fields['booking_time_format'] = array(
	                            'type'          => 'text'
	                            , 'default'     => $default_options_values['booking_time_format']   //'H:i'
	                            , 'value'       => htmlentities( $booking_time_format )      // Display value of this field in specific way
	                            , 'group'       => 'date_time'
	                            , 'placeholder' => 'H:i'
	                            , 'css'         => 'width:auto; margin: 10px 0;'
	                            , 'only_field'  => true
	        );
        $this->fields['booking_time_format_html_sufix'] = array(
                                      'type'        => 'pure_html'
                                    , 'group'       => 'date_time'
                                    , 'html'        => '<span class="description" style="padding:0;"><code>' . date_i18n( $booking_time_format ) . '</code></span>
                                                               </fieldset>
                                                            </td>
                                                        </tr>'
                            );
        $this->fields['booking_time_format_help'] = array(
                           'type'              => 'html'
                         , 'html'             => '<div style="line-height: 2em;">'.
														/* translators: 1: ... */
														sprintf( __( 'Type your time format for emails and the booking table. %1$sDocumentation on time formatting%2$s', 'booking' ),'<br/><a href="https://www.php.net/manual/datetime.format.php" target="_blank">','</a>')
                                                 .'</div>'
                         , 'class'             => ''
                         , 'css'               => 'margin:0;padding:0;border:0;'
                         , 'description'       => ''
                         , 'cols'              => 2
                         , 'group'             => 'date_time'
                         , 'tr_class'          => ''
                         , 'description_tag'   => 'div'
                 );



		// </editor-fold>



        //  Divider  ///////////////////////////////////////////////////////////////       
        $this->fields['hr_booking_listing_before_is_use_hints_at_admin_panel'] = array( 'type' => 'hr', 'group' => 'booking_listing' );


        // Show hide Notes
        $this->fields = apply_filters( 'wpbc_settings_booking_show_hide_options', $this->fields, $default_options_values );         // FixIn: 8.1.3.32.


        // </editor-fold>
        
        
        // <editor-fold     defaultstate="collapsed"                        desc=" auto_cancelation_approval "  >
        
        // auto_cancelation_approval
        $this->fields = apply_filters( 'wpbc_settings_auto_cancelation_approval_section', $this->fields, $default_options_values );
        // </editor-fold>


        // <editor-fold     defaultstate="collapsed"                        desc=" Capacity "  >

	     $this->fields = apply_filters( 'wpbc_settings_capacity_based_on_visitors', $this->fields, $default_options_values );

        $this->fields['booking_is_days_always_available'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_is_days_always_available']         //'On'
                                , 'title'       => __('Allow unlimited bookings per same day(s)' ,'booking')
                                /* translators: 1: ... */
                                , 'label'       => sprintf( __( 'Check this box, if you want to %1$sset any days as available%2$s in calendar. Your visitors will be able to make %3$sunlimited bookings per same date(s) in calendar and do not see any booked date(s)%4$s of other visitors.', 'booking' ), '<strong>', '</strong>' , '<strong>', '</strong>' )
                                , 'description' => ''
                                , 'group'       => 'capacity'
            );


        // FixIn: 8.3.2.2.
        if ( ! class_exists('wpdev_bk_biz_l') )
		    $this->fields['booking_is_show_pending_days_as_available'] = array(
		                            'type'          => 'checkbox'
		                            , 'default'     => $default_options_values['booking_is_show_pending_days_as_available']   //_'Off'
		                            , 'title'       =>  __('Use pending days as available' ,'booking')
		                            , 'label'       => sprintf(__('Check this box if you want to show the pending days as available in calendars' ,'booking') )
		                            , 'description' => ''
		                            , 'group'       => 'capacity'
		                            , 'tr_class'    => ''
		        );

        $this->fields = apply_filters( 'wpbc_settings_pending_days_as_available', $this->fields, $default_options_values );



		// </editor-fold>

	    // <editor-fold     defaultstate="collapsed"                        desc=" Capacity Free example "  >
	    if ( ! class_exists('wpdev_bk_personal') ){

		    // Showing availability in tooltip
		    $this->fields['booking_quantity_control__promote_upgrade'] = array(
		                              'type'        => 'checkbox'
	                            , 'default' 	=> 'On'
		                        , 'value' 	    => 'On'
		                            , 'title'       =>  __('Booking Quantity Control' ,'booking')
		                            , 'label'       =>  __('Enable this option to allow visitors to define the number of items they can book for specific dates or times within a single reservation. ' ,'booking')
		                            , 'description' =>  __('If disabled, visitors can book only one slot within a single reservation.' ,'booking')
		                            , 'description_tag' => 'p'
		                            , 'group'       => 'capacity_upgrade'
			                        , 'tr_class'    => 'wpbc_blur'
		        );
			$this->fields['booking_capacity_field__promote_upgrade'] = array(
										  'type' 			=> 'select'
								, 'default' 		=> 'items'
								, 'value' 		    => 'items'
										, 'title' 			=> __('Quantity field name', 'booking')
										, 'description' 	=> sprintf( __( 'Select the field that will control how many slots visitors can book during the reservation process.' ,'booking'), '<b>', '</b>' )
										, 'description_tag' => 'span'
										, 'css' 			=> ''
		                                , 'tr_class'    	=> 'wpbc_booking_capacity_field_settings wpbc_sub_settings_grayed'
								, 'options' 		=> array( 'items'  => __('Items' ,'booking') )
										, 'group' 			=> 'capacity_upgrade'
										, 'tr_class'    => 'wpbc_blur'
								);
		    $this->fields['booking_is_dissbale_booking_for_different_sub_resources__promote_upgrade'] = array(
		                            'type'          => 'checkbox'
                            , 'default'     => 'On'
			                , 'value'     => 'On'
		                            , 'title'       => __('Disable bookings in different booking resources' ,'booking')
		                            , 'label'       => __('Check this box to disable reservations, which can be stored in different booking resources.' ,'booking')
		                            , 'description' => '<strong>' . esc_html__('Note' ,'booking') . '!</strong> ' . __('When checked, all reserved days must be at same booking resource otherwise error message will show.' ,'booking')
		                            , 'group'       => 'capacity_upgrade'
			                        , 'tr_class'    => 'wpbc_blur'
		        );
		    $this->fields['capacity_upgrade__promote_upgrade'] = array(
                                'type'          => 'pure_html'
                                , 'group'       => 'capacity_upgrade'
		                        , 'html' => '<tr><td colspan="2">
									        	<div class="wpbc_widget_content" style="transform: translate(0) translateY(-10em);">
													<div class="ui_container    ui_container_toolbar		ui_container_small" style="background: #fff;position: relative;">
														<div class="ui_group    ui_group__upgrade">
															<div class="wpbc_upgrade_note wpbc_upgrade_theme_green">
																<div>This <a target="_blank" href="https://wpbookingcalendar.com/features/#capacity">feature</a> 
																	 is available in the <strong>Business Large or MultiUser version</strong>. 
																	<a target="_blank" href="https://wpbookingcalendar.com/prices/#bk_news_section">Upgrade to Pro</a>.																
																</div>
															</div>
														</div>														
													</div>
												</div>
									    </td> </tr>'
                        );
	    }
	    // </editor-fold>

        
        // <editor-fold     defaultstate="collapsed"                        desc=" Advanced "  >
        

        $this->fields = apply_filters( 'wpbc_settings_edit_url_hash', $this->fields, $default_options_values );
        // FixIn: 10.10.1.2  $this->fields = apply_filters( 'wpbc_settings_resource_no_update__during_editing', $this->fields, $default_options_values );

        // Show advanced settings of JavaScript loading
        

//        //Show | Hide links for Advanced JavaScript section
//        $this->fields['booking_advanced_js_loading_settings'] = array(
//                                  'type' => 'html'
//                                , 'html'  =>
//                                          '<a id="wpbc_show_advanced_section_link_show" class="wpbc_expand_section_link" href="javascript:void(0)">+ ' . __('Show advanced settings of JavaScript loading' ,'booking') . '</a>'
//                                        . '<a id="wpbc_show_advanced_section_link_hide" class="wpbc_expand_section_link" href="javascript:void(0)" style="display:none;">- ' . __('Hide advanced settings of JavaScript loading' ,'booking') . '</a>'
//                                , 'cols'  => 2
//                                , 'group' => 'advanced'
//            );

	    // FixIn: 9.8.6.2.
	    $balencer_options     = array_combine( range( 1, 5 ), range( 1, 5 ) );
	    $balencer_options[99] = __( 'All', 'booking' );
        $this->fields['booking_load_balancer_max_threads'] = array(
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_load_balancer_max_threads']
                                , 'title'       => __('Parallel requests' ,'booking')
                                , 'description' => __('Select the number of simultaneous requests to load data in multiple calendars.' ,'booking') . ' <sup style="color:#7812bd;"><strong> '.__('Performance','booking').'</strong></sup>'
	        							           . '<div class="wpbc-general-settings-notice wpbc-settings-notice notice-info">'
                                                   .    __('This Server Balancer control how many parallel requests for loading calendar data can be sent at the same time. A lower number minimizes server impact but may increase the total time for loading all calendars.' ,'booking')
                                                   .'</div>'

                                , 'options' => $balencer_options
                                , 'group'       => 'advanced'
	                            , 'is_demo_safe' => wpbc_is_this_demo()
            );


        $this->fields['booking_is_load_js_css_on_specific_pages'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_is_load_js_css_on_specific_pages']         //'Off'            
                                , 'title'       => __('Load JS and CSS files only on specific pages' ,'booking')
                                , 'label'       => __('Activate loading of CSS and JavaScript files of plugin only at specific pages.' ,'booking')
                                , 'description' => ''
                                , 'group'       => 'advanced'
                                , 'tr_class'    => 'wpbc_advanced_js_loading_settings'//wpbc_advanced_js_loading_settings wpbc_sub_settings_grayed hidden_items'
                                , 'is_demo_safe' => wpbc_is_this_demo()
            );       
        $this->fields['booking_pages_for_load_js_css'] = array(   
                                'type'          => 'textarea'
                                , 'default'     => $default_options_values['booking_pages_for_load_js_css']         //''
                                , 'placeholder' => '/booking-form/'
                                , 'title'       => __('Relative URLs of pages, where to load plugin CSS and JS files' ,'booking')
                                /* translators: 1: ... */
                                , 'description' => sprintf(__( 'Enter relative URLs of pages, where you have Booking Calendar elements (booking forms or availability calendars). Please enter one URL per line. Example: %s' ,'booking'),'<code>/booking-form/</code>')
                                ,'description_tag' => 'p'
                                , 'css'         => 'width:100%'
                                , 'rows'        => 5
                                , 'group'       => 'advanced'
                                , 'tr_class'    => 'wpbc_advanced_js_loading_settings wpbc_is_load_js_css_on_specific_pages wpbc_sub_settings_grayed'//  hidden_items'
                                , 'is_demo_safe' => wpbc_is_this_demo()
                        );

        $this->fields['booking_form_is_using_bs_css'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_form_is_using_bs_css']         // 'On'
                                , 'title'       => __('Use CSS BootStrap' ,'booking')
                                , 'label'       => __('Using BootStrap CSS for the form fields' ,'booking'). ' <sup style="color:#bd8212;"><strong> '.__('Deprecated','booking').'</strong></sup>'
                                , 'description' => ''
                                , 'description_tag' => 'p'
                                , 'group'       => 'advanced'
            );

		//$this->fields['hr_booking_is_show_system_debug_log'] = array( 'type' => 'hr', 'group' => 'advanced', 'tr_class' => 'wpbc_advanced_js_loading_settings' ); // wpbc_sub_settings_grayed hidden_items' );
		// FixIn: 7.2.1.15.
        $this->fields[ 'booking_is_show_system_debug_log' ] = array(   
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_is_show_system_debug_log']         //'Off'            
                                , 'title'       => __('Show system debugging log for beta features' ,'booking')
                                , 'label'       => __('Activate this option only for testing beta features' ,'booking')
                                , 'description' => ''
                                , 'group'       => 'advanced'
                                , 'tr_class'    => 'wpbc_advanced_js_loading_settings'// wpbc_sub_settings_grayed hidden_items'
                                , 'is_demo_safe' => wpbc_is_this_demo()
            );

		//FixIn: 10.1.1.2  //TODO: Update Text here 2024-06-16 12:57
        $this->fields['booking_is_nonce_at_front_end'] = array(
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_is_nonce_at_front_end']             //'Off'
                                , 'title'       => __( 'Use Nonce Fields', 'booking' )
                                , 'label'       => __( 'Activate this option to add security tokens (nonce fields) to booking forms on the front-end. Please note that this may cause issues if you are using cache plugins or caching software.', 'booking' )
                                , 'description' => ''
                                , 'group'       => 'advanced'
                                , 'tr_class'    => 'wpbc_advanced_is_nonce'  //wpbc_advanced_js_loading_settings wpbc_sub_settings_grayed hidden_items'
	                            , 'toggle_class' => 'wpbc_toggle_danger'
                                , 'is_demo_safe' => wpbc_is_this_demo()
            );

	    if ( wpbc_is_this_demo() ) {
		    $this->fields['booking_pages_for_load_js_css_demo'] = array( 'group'    => 'advanced',
		                                                                 'type'     => 'html',
		                                                                 'html'     => wpbc_get_warning_text_in_demo_mode(),
		                                                                 'cols'     => 2,
		                                                                 'tr_class' => 'wpbc_advanced_js_loading_settings'// wpbc_sub_settings_grayed hidden_items'
		    );
	    }
        
        //  Divider  ///////////////////////////////////////////////////////////////
        $this->fields['hr_calendar_before_advanced_js_loading_settings'] = array( 'type' => 'hr', 'group' => 'advanced' );

        // Show settings of powered by notice
        $this->fields['booking_advanced_powered_by_notice_settings'] = array(    
                                  'type' => 'html'
                                , 'html'  =>  
                                          '<a id="wpbc_powered_by_link_show" class="wpbc_expand_section_link" href="javascript:void(0)">+ ' . __('Show settings of powered by notice' ,'booking') . '</a>'
                                        . '<a id="wpbc_powered_by_link_hide" class="wpbc_expand_section_link" href="javascript:void(0)" style="display:none;">- ' . __('Hide settings of powered by notice' ,'booking') . '</a>'
                                , 'cols'  => 2
                                , 'group' => 'advanced'
            );
        $this->fields['booking_is_show_powered_by_notice'] = array(   
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_is_show_powered_by_notice']         //'On'            
                                , 'title'       => __('Powered by notice' ,'booking')
                                , 'label'       => sprintf(__(' Turn On/Off powered by "Booking Calendar" notice under the calendar.' ,'booking'),'wpbookingcalendar.com')
                                , 'description' => ''
                                , 'group'       => 'advanced'
                                , 'tr_class'    => 'wpbc_is_show_powered_by_notice wpbc_sub_settings_grayed hidden_items'
            );       
        $this->fields['booking_wpdev_copyright_adminpanel'] = array(   
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_wpdev_copyright_adminpanel']         //'On'            
                                , 'title'       => __('Help and info notices' ,'booking')
                                , 'label'       => sprintf(__(' Turn On/Off version notice and help info links at booking admin panel.' ,'booking'),'wpbookingcalendar.com')
                                , 'description' => ''
                                , 'group'       => 'advanced'
                                , 'tr_class'    => 'wpbc_is_show_powered_by_notice wpbc_sub_settings_grayed hidden_items'
	                            , 'is_demo_safe' => wpbc_is_this_demo()                                                 // FixIn: 8.1.3.9.
            );       
        
        // </editor-fold>
                                 
        
        // <editor-fold     defaultstate="collapsed"                        desc=" Information "  >
if(1){
        if (  function_exists( 'wpbc_get_dashboard_info' ) ) {
            $this->fields['booking_information'] = array(   
                               'type'              => 'html'
                             , 'html'              => wpbc_get_dashboard_info()
                             , 'cols'              => 2
                             , 'group'             => 'information'
                     ); 
        }
}
        // </editor-fold>

        
        // <editor-fold     defaultstate="collapsed"                        desc=" User permissions for plugin menu pages "  >
        
        
        $this->fields['booking_menu_position'] = array(   
                                'type'          => 'select'
                                , 'default'     => 'top'
                                , 'title'       => __('Plugin menu position', 'booking')
                                , 'description' => ''
                                , 'options'     => array(
                                                              'top'     => __('Top', 'booking')
                                                            , 'middle'  => __('Middle', 'booking')
                                                            , 'bottom'  => __('Bottom', 'booking')
                                                        )
                                , 'group'       => 'permissions'
                                , 'is_demo_safe' => wpbc_is_this_demo()
                        );
        
        $this->fields['booking_user_role_booking_header'] = array(   
                                    'type'          => 'pure_html'
                                    , 'group'       => 'permissions'
                                    , 'html'        => '<tr valign="top">
                                                            <th scope="row" colspan="2">
                                                                <hr/><p><strong>' . wp_kses_post(  __('User permissions for plugin menu pages' ,'booking') )  . ':</strong></p>
                                                            </th>
                                                        </tr>'
                            );        
        
        $field_options = array();
        $field_options['subscriber']    = translate_user_role('Subscriber');
        $field_options['contributor']   = translate_user_role('Contributor');
        $field_options['author']        = translate_user_role('Author');
        $field_options['editor']        = translate_user_role('Editor');
        $field_options['administrator'] = translate_user_role('Administrator');
        
        $this->fields['booking_user_role_booking'] = array(   
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_user_role_booking']         //'editor'            
                                , 'title'       => __('Bookings', 'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'permissions'
                                , 'is_demo_safe' => wpbc_is_this_demo()
                        );
        $this->fields['booking_user_role_availability'] = array(                                                        // FixIn: 9.5.2.2.
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_user_role_availability']         //'editor'
                                , 'title'       => __('Availability', 'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'permissions'
                                , 'is_demo_safe' => wpbc_is_this_demo()
                        );
		//FixIn: 9.8.15.2.6
	    if ( class_exists( 'wpdev_bk_biz_m' ) )
            $this->fields['booking_user_role_prices'] = array(
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_user_role_prices']            //'editor'
                                , 'title'       => __('Prices', 'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'permissions'
                                , 'is_demo_safe' => wpbc_is_this_demo()
                        );

        $this->fields['booking_user_role_addbooking'] = array(
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_user_role_addbooking']         //'editor'
                                , 'title'       => __('Add booking', 'booking')
                                , 'description' => ''
                                , 'options'     => $field_options
                                , 'group'       => 'permissions'
                                , 'is_demo_safe' => wpbc_is_this_demo()
                        );
        if ( class_exists( 'wpdev_bk_personal' ) )
            $this->fields['booking_user_role_resources'] = array(   
                                    'type'          => 'select'
                                    , 'default'     => $default_options_values['booking_user_role_resources']         //'editor'            
                                    , 'title'       => __('Resources', 'booking')
                                    , 'description' => ''
                                    , 'options'     => $field_options
                                    , 'group'       => 'permissions'
                                    , 'is_demo_safe' => wpbc_is_this_demo()
                            );
        $this->fields['booking_user_role_settings'] = array(
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_user_role_settings']         //'administrator'
                                , 'title'       => __('Settings', 'booking')
                                , 'description' => __('Select user access level for the menu pages of plugin' ,'booking')
                                , 'description_tag' => 'p'
                                , 'options'     => $field_options
                                , 'group'       => 'permissions'
                                , 'is_demo_safe' => wpbc_is_this_demo()
                        );

	    if ( ! class_exists( 'wpdev_bk_personal' ) )
		    $this->fields['booking_menu_go_pro'] = array(
                                'type'          => 'select'
                                , 'default'     => $default_options_values['booking_menu_go_pro']         //'administrator'
                                , 'title'       => __('Premium', 'booking')
                                , 'description' => __('Show / hide menu' ,'booking')
                                , 'description_tag' => 'p'
                                , 'options'     => array(
				                                          'show' => __('Show', 'booking')
                                	                    , 'hide' => __('Hide', 'booking')
			                                        )
                                , 'group'       => 'permissions'
                                , 'is_demo_safe' => wpbc_is_this_demo()
                        );

        if ( wpbc_is_this_demo() )
            $this->fields['booking_user_role_settings_demo'] = array( 'group' => 'permissions', 'type' => 'html', 'html' => wpbc_get_warning_text_in_demo_mode(), 'cols' => 2 ); 
        
        
        // </editor-fold>
        
                
        // <editor-fold     defaultstate="collapsed"                        desc=" Uninstall "  >
        $this->fields['booking_is_delete_if_deactive'] = array(   
                                'type'          => 'checkbox'
                                , 'default'     => $default_options_values['booking_is_delete_if_deactive']         //'Off'            
                                , 'title'       => __('Delete booking data, when plugin deactivated' ,'booking')
                                , 'label'       => __('Turn on to delete all booking data when you uninstall this plugin.' ,'booking')
                                , 'description' => ''
                                , 'group'       => 'uninstall'
	                            , 'toggle_class' => 'wpbc_toggle_danger'
            );       
        // </editor-fold>
        
        
        // <editor-fold     defaultstate="collapsed"                        desc=" Tools "  >

        if ( ( ! wpbc_is_this_demo() ) && ( current_user_can( 'activate_plugins' ) ) ) {

	        $this->fields['tools_section_buttons'] = array(
	                           'type'              => 'help'
	                         , 'value'             => array()
	                         , 'class'             => ''
	                         , 'css'               => 'margin:0;padding:0;border:0;'
	                         , 'description'       => ''
	                         , 'cols'              => 2
	                         , 'group'             => 'help'
	                         , 'tr_class'          => ''
	                         , 'description_tag'   => 'p'
	                 );

			$my_system_buttons = '';

			$my_system_buttons .= '<a class="button button" href="'
		                                        . esc_url( wpbc_get_settings_url()
		                                        . '&system_info=show&_wpnonce='. wp_create_nonce( 'wpbc_settings_url_nonce' ) ) .'&booking_system_info=show#wpbc_general_settings_system_info_metabox">'
		                                                . 'Booking System ' . __('Info' ,'booking')
		                        . '</a>';
			// FixIn: 8.4.7.19.
			$my_system_buttons .= ' <a class="button button" href="'
		            . wpbc_get_bookings_url()
		              . '&wh_booking_type=lost">'
		            . 'Find Lost Bookings'
	            . '</a>';  // FixIn: 8.5.2.19.

	        // FixIn: 9.5.3.1.
			$my_system_buttons .= ' <a class="button button" href="'
		            . wpbc_get_resources_url()
		              . '&show_all_resources=1">'
		            . 'Find Lost Resources'
	            . '</a>';

			if ( ( isset( $_SERVER['HTTP_HOST'] ) ) && ( 'beta' === $_SERVER['HTTP_HOST'] ) ) {

				$my_system_buttons .=  '<div style="width:100%;height:2em;border-bottom:1px dashed #777;margin-bottom:1em;"></div>';

	            // Link: http://server.com/wp-admin/admin.php?page=wpbc-settings&system_info=show&_wpnonce='. wp_create_nonce( 'wpbc_settings_url_nonce' ) .' &reset=custom_forms#wpbc_general_settings_system_info_metabox
	            $my_system_buttons .=  ' <a class="button button-secondary" style="background:#fff9e6;" href="'
								            . esc_url( wpbc_get_settings_url()
								            . '&system_info=show&_wpnonce='. wp_create_nonce( 'wpbc_settings_url_nonce' ) ) .'&reset=custom_forms#wpbc_general_settings_system_info_metabox">'
								            . 'Reset custom forms'
							            . '</a>';


	            $my_system_buttons .=  ' <a class="button button-secondary" style="background:#fff9e6;" href="'
								            . esc_url( wpbc_get_settings_url()
								            . '&wpbc_setup_wizard=reset&_wpnonce='. wp_create_nonce( 'wpbc_settings_url_nonce' ) ) .'">'
								            . 'Reset Setup Wizard'
							            . '</a>';
//	            if ( ( isset( $_GET['wpbc_setup_wizard'] ) ) && ( 'reset' === $_GET['wpbc_setup_wizard'] ) ) {
//		            $my_system_buttons .= '<script type="text/javascript"> window.location.href = "' . esc_url( wpbc_get_setup_wizard_page_url() ) . '"; </script>';
//	            }
	            $my_system_buttons .=  ' <a class="button button-secondary" style="background:#fff9e6;" href="'
								            . esc_url( wpbc_get_settings_url()
								            . '&wpbc_setup_wizard=completed&_wpnonce='. wp_create_nonce( 'wpbc_settings_url_nonce' ) ) .'">'
								            . 'Set Setup Wizard as Completed'
							            . '</a>';
            }

            $this->fields['tools_section_buttons']['value'][] =
                  '<div class="wpbc_booking_system_info_buttons_align">'
                .       $my_system_buttons
                . '</div>';
        }

        // </editor-fold>


        // <editor-fold     defaultstate="collapsed"                        desc=" Transaltions "  >

        $this->fields['help_translation_section_after_legend_items'] = array(
                           'type'              => 'help'
                         , 'value'             => wpbc_get_help_rows_about_config_in_several_languges()
                         , 'class'             => ''
                         , 'css'               => 'margin:0;padding:0;border:0;'
                         , 'description'       => ''
                         , 'cols'              => 2
                         , 'group'             => 'translations'
                         , 'tr_class'          => ''
                         , 'description_tag'   => 'p'
                 );
		$this->fields['hr_help_translation_section_after_legend_items'] = array( 'type' => 'hr', 'group' => 'translations' );

        $this->fields['booking_translation_load_from'] = array(
                                'type'          => 'select'
                                , 'default'     => 'top'
                                , 'title'       => __('Firstly load translation', 'booking')
                                , 'options'     => array(
													        'wp.org' => 'WordPress.org '
												        ,   'wpbc'   => __( 'Local', 'booking' )
                                                        )
                                , 'group'       => 'translations'
                                , 'is_demo_safe' => wpbc_is_this_demo()
                        );

        $this->fields['help_translation_section_after_translation_load_from'] = array(
                           'type'              => 'help'
                         , 'value'             => array(
							 sprintf(
								/* translators: 1: ... */
								 __( 'The plugin tries to use translations from %1$s, if failed (doesn\'t exist), try using translations from %2$s folder. You can change this behavior with this option.', 'booking')
							        , '"<strong>../wp-content/languages/plugins/</strong>"'
								    , '"<strong>../wp-content/plugins/{Booking Calendar Folder}/languages/</strong>"' )
	                                                    )
                         , 'class'             => ''
                         , 'css'               => 'margin:0;padding:0;border:0;'
                         , 'description'       => ''
                         , 'cols'              => 2
                         , 'group'             => 'translations'
                         , 'tr_class'          => ''
                         , 'description_tag'   => 'p'
                 );
		// </editor-fold>

    }      
    

    /**
	 * Add Custon JavaScript - for some specific settings options
     *      Need to executes after showing of entire settings page (on hook: wpbc_after_settings_content).
     *      After initial definition of settings,  and possible definition after POST request.
     * 
     * @param type $menu_slug
     * 
     */
    public function enqueue_js( $menu_slug, $active_page_tab, $active_page_subtab ) {

        $js_script = '';

        // Hide 'Title of booked timeslot(s)' items                                                                     //FixIn: 9.5.0.2.2
        $js_script .= " 
                        if ( jQuery('#set_gen_booking_disable_timeslots_in_tooltip').is(':checked') ) {   
                            jQuery('.wpbc_booking_timeslots_in_tooltip').addClass('hidden_items'); 
                        }
                      ";
        // Hide or Show 'Title of booked timeslot(s)' on click checkbox
        $js_script .= " jQuery('#set_gen_booking_disable_timeslots_in_tooltip').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_booking_timeslots_in_tooltip').addClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_booking_timeslots_in_tooltip').removeClass('hidden_items');
                                }
                            } ); ";

	    // FixIn: 9.6.3.5.

        // Hide Legend items
        $js_script .= " 
                        if ( ! jQuery('#set_gen_booking_is_show_legend').is(':checked') ) {   
                            jQuery('.wpbc_calendar_legend_items').addClass('hidden_items'); 
                        }
                      ";        
        // Hide or Show Legend items on click checkbox
        $js_script .= " jQuery('#set_gen_booking_is_show_legend').on( 'change', function(){    
                                if ( this.checked ) { 
                                    jQuery('.wpbc_calendar_legend_items').removeClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_calendar_legend_items').addClass('hidden_items');
                                }
                            } ); ";        
        // Thank you Message or Page
        $js_script .= " 
                        if ( jQuery('#type_of_thank_you_message_message').is(':checked') ) {   
                            jQuery('.wpbc_calendar_thank_you_page').addClass('hidden_items'); 
                        }
                        if ( jQuery('#type_of_thank_you_message_page').is(':checked') ) {   
                            jQuery('.wpbc_calendar_thank_you_message').addClass('hidden_items'); 
                        }
                      ";        
        $js_script .= " jQuery('input[name=\"set_gen_booking_type_of_thank_you_message\"]').on( 'change', function(){    
                                if ( jQuery('#type_of_thank_you_message_message').is(':checked') ) {   
                                    jQuery('.wpbc_calendar_thank_you_message').removeClass('hidden_items');
                                    jQuery('.wpbc_calendar_thank_you_page').addClass('hidden_items'); 
                                } else {
                                    jQuery('.wpbc_calendar_thank_you_message').addClass('hidden_items');
                                    jQuery('.wpbc_calendar_thank_you_page').removeClass('hidden_items'); 
                                }
                            } ); ";    
        
        // Default calendar view mode (Booking Listing) - set  active / inctive options depend from  resource selection.
        $js_script .= " jQuery('#set_gen_booking_view_days_num').on( 'focus', function(){    
                            if ( jQuery('#set_gen_booking_default_booking_resource').length > 0 ) {
                                jQuery('#set_gen_booking_default_booking_resource').on('change', function() {
                                    jQuery('#set_gen_booking_view_days_num option:eq(2)').prop('selected', true);
                                });
                                if ( jQuery('#set_gen_booking_default_booking_resource').val() == '' ) { 
                                    jQuery('#set_gen_booking_view_days_num option:eq(0)').prop('disabled', false);
                                    jQuery('#set_gen_booking_view_days_num option:eq(1)').prop('disabled', false);
                                    jQuery('#set_gen_booking_view_days_num option:eq(2)').prop('disabled', false);
                                    jQuery('#set_gen_booking_view_days_num option:eq(3)').prop('disabled', false);
                                    jQuery('#set_gen_booking_view_days_num option:eq(4)').prop('disabled', true);
                                    jQuery('#set_gen_booking_view_days_num option:eq(5)').prop('disabled', true);
                                } else {
                                    jQuery('#set_gen_booking_view_days_num option:eq(0)').prop('disabled', true);
                                    jQuery('#set_gen_booking_view_days_num option:eq(1)').prop('disabled', true);
                                    jQuery('#set_gen_booking_view_days_num option:eq(2)').prop('disabled', false);
                                    jQuery('#set_gen_booking_view_days_num option:eq(3)').prop('disabled', true);
                                    jQuery('#set_gen_booking_view_days_num option:eq(4)').prop('disabled', false);
                                    jQuery('#set_gen_booking_view_days_num option:eq(5)').prop('disabled', false);                                                                
                                }
                            }
                        } ); ";        
        
        ////////////////////////////////////////////////////////////////////////
        // Set  correct  value for dates format,  depend on from selection of radio buttons
        $booking_date_format = esc_js( get_bk_option( 'booking_date_format') );                                         // FixIn: 10.6.1.2.
        // On initial Load set correct text value and correct radio button
        $js_script .= " 
                        // Select by  default Custom  value, later  check all other predefined values
                        jQuery( '#date_format_selection_custom' ).prop('checked', true);

                        jQuery('input[name=\"set_gen_booking_date_format_selection\"]').each(function() {
                           var radio_button_value = jQuery( this ).val()
                           var encodedStr = radio_button_value.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
                                                                                        return '&#'+i.charCodeAt(0)+';';
                                                                                    });
                           if ( encodedStr == '". $booking_date_format ."' ) {
                                jQuery( this ).prop('checked', true);                     
                           }
                        });
                        
                        jQuery('#set_gen_booking_date_format').val('". $booking_date_format ."');
                        ";
        // On click Radio button "Date Format", - set value in custom Text field
        $js_script .= " jQuery('input[name=\"set_gen_booking_date_format_selection\"]').on( 'change', function(){    
                                if (  ( this.checked ) && ( jQuery(this).val() != 'custom' )  ){ 

                                    jQuery('#set_gen_booking_date_format').val( jQuery(this).val().replace(/[\u00A0-\u9999<>\&]/gim, 
                                        function(i) {
                                            return '&#'+i.charCodeAt(0)+';';
                                        }) 
                                    );
                                }                            
                            } ); "; 
        // If we edit custom "Date Format" Text  field - select Custom Radio button.                                 
        $js_script .= " jQuery('#set_gen_booking_date_format').on( 'change', function(){                                              
                                jQuery( '#date_format_selection_custom' ).prop('checked', true);
                            } ); ";        
        
	    ////////////////////////////////////////////////////////////////////////
	    // Set  correct  value for Time Format,  depend on from selection of radio buttons
	    $booking_time_format = esc_js( get_bk_option( 'booking_time_format') );                                         // FixIn: 10.6.1.2.
	    // Function  to  load on initial stage of page loading, set correct value of text and select correct radio button.
	    $js_script .= " 
	                    // Select by  default Custom  value, later  check all other predefined values
	                    jQuery( '#time_format_selection_custom' ).prop('checked', true);
	
	                    jQuery('input[name=\"set_gen_booking_time_format_selection\"]').each(function() {
	                       var radio_button_value = jQuery( this ).val()
	                       var encodedStr = radio_button_value.replace(/[\u00A0-\u9999<>\&]/gim, function(i) {
	                                                                                    return '&#'+i.charCodeAt(0)+';';
	                                                                                });
	                       if ( encodedStr == '". $booking_time_format ."' ) {
	                            jQuery( this ).prop('checked', true);                     
	                       }
	                    });
	
	                    jQuery('#set_gen_booking_time_format').val('". $booking_time_format ."');
	                    ";
	    // On click Radio button "Time Format", - set value in custom Text field
	    $js_script .= " jQuery('input[name=\"set_gen_booking_time_format_selection\"]').on( 'change', function(){    
	                            if (  ( this.checked ) && ( jQuery(this).val() != 'custom' )  ){ 
	
	                                jQuery('#set_gen_booking_time_format').val( jQuery(this).val().replace(/[\u00A0-\u9999<>\&]/gim, 
	                                    function(i) {
	                                        return '&#'+i.charCodeAt(0)+';';
	                                    }) 
	                                );
	                            }                            
	                        } ); ";
	    // If we edit custom "Date Format" Text  field - select Custom Radio button.
	    $js_script .= " jQuery('#set_gen_booking_time_format').on( 'change', function(){                                              
	                            jQuery( '#time_format_selection_custom' ).prop('checked', true);
	                        } ); ";

        ////////////////////////////////////////////////////////////////////////
        // Advanced section
        ////////////////////////////////////////////////////////////////////////
        
        // Click on "Always available "
        $js_script .= " jQuery('#set_gen_booking_is_days_always_available').on( 'change', function(){    
                            if ( this.checked ) { 
                                var answer = confirm('"                 
                                              . esc_js( __( 'Warning', 'booking' ) ) . '! '
                                              . esc_js( __( 'You allow unlimited number of bookings per same dates, its can be a reason of double bookings on the same date. Do you really want to do this?', 'booking' ) ) 
                                      .  "' );  
                                if ( answer) { 
                                    this.checked = true;   
                                    jQuery('#set_gen_booking_quantity_control').prop('checked', false ).trigger('change');                                                                                                            
                                    jQuery('#set_gen_booking_is_show_pending_days_as_available').prop('checked', false );            
                                    jQuery('.wpbc_pending_days_as_available_sub_settings').addClass('hidden_items'); 
                                } else { 
                                    this.checked = false; 
                                } 
                            }                            
                        } ); ";

        // FixIn: 8.3.2.2.
	    if ( ! class_exists('wpdev_bk_biz_l') ) {
	    	// Click on "Use pending days as available"
	        $js_script .= " jQuery('#set_gen_booking_is_show_pending_days_as_available').on( 'change', function(){            
                            if ( this.checked ) { 
                                jQuery('#set_gen_booking_is_days_always_available').prop('checked', false );
                            } else {

                            }
                        } ); ";
        }

        // Click  on Show Advanced JavaScript section  link
        $js_script .= " jQuery('#wpbc_show_advanced_section_link_show').on( 'click', function(){                                 
                            jQuery('#wpbc_show_advanced_section_link_show').toggle(200);                            
                            jQuery('#wpbc_show_advanced_section_link_hide').animate( {opacity: 1}, 200 ).toggle(200);     
                            jQuery('.wpbc_advanced_js_loading_settings').removeClass('hidden_items'); 
                            
                            if ( ! jQuery('#set_gen_booking_is_load_js_css_on_specific_pages').is(':checked') ) {   
                                jQuery('.wpbc_is_load_js_css_on_specific_pages').addClass('hidden_items'); 
                            }
                        } ); ";   
        $js_script .= " jQuery('#wpbc_show_advanced_section_link_hide').on( 'click', function(){    
                            jQuery('#wpbc_show_advanced_section_link_hide').toggle(200);                            
                            jQuery('#wpbc_show_advanced_section_link_show').animate( {opacity: 1}, 200 ).toggle(200);                        
                            jQuery('.wpbc_advanced_js_loading_settings').addClass('hidden_items'); 
                        } ); ";   
        $js_script .= " jQuery('#set_gen_booking_is_load_js_css_on_specific_pages').on( 'change', function(){    
                            if ( this.checked ) { 
                                var answer = confirm('"                 
                                              . esc_js( __( 'Warning', 'booking' ) ) . '! '
                                              . esc_js( __( 'You are need to be sure what you are doing. You are disable of loading some JavaScripts Do you really want to do this?', 'booking' ) )                                                                                                                           
                                      .  "' );  
                                if ( answer) {
                                    this.checked = true;                                       
                                    jQuery('.wpbc_is_load_js_css_on_specific_pages').removeClass('hidden_items'); 
                                } else { 
                                    this.checked = false; 
                                } 
                            } else {
                                jQuery('.wpbc_is_load_js_css_on_specific_pages').addClass('hidden_items'); 
                            }
                        } ); 
                        if ( ! jQuery('#set_gen_booking_is_load_js_css_on_specific_pages').is(':checked') ) {   
                            jQuery('.wpbc_is_load_js_css_on_specific_pages').addClass('hidden_items'); 
                        }
                                                
                        ";         
        
        
        // Click  on Powered by  links
        $js_script .= " jQuery('#wpbc_powered_by_link_show').on( 'click', function(){                                 
                            jQuery('#wpbc_powered_by_link_show').toggle(200);                            
                            jQuery('#wpbc_powered_by_link_hide').animate( {opacity: 1}, 200 ).toggle(200);  
                            jQuery('.wpbc_is_show_powered_by_notice').removeClass('hidden_items');                             
                        } ); ";   
        $js_script .= " jQuery('#wpbc_powered_by_link_hide').on( 'click', function(){    
                            jQuery('#wpbc_powered_by_link_hide').toggle(200);                            
                            jQuery('#wpbc_powered_by_link_show').animate( {opacity: 1}, 200 ).toggle(200);   
                            jQuery('.wpbc_is_show_powered_by_notice').addClass('hidden_items'); 
                        } ); ";   

        
        // Show confirmation window,  if user activate this checkbox
        $js_script .= " jQuery('#set_gen_booking_is_delete_if_deactive').on( 'change', function(){    
                            if ( this.checked ) { 
                                var answer = confirm('"                 
                                              . esc_js( __( 'Warning', 'booking' ) ) . '! '
                                              . esc_js( __( 'If you check this option, all booking data will be deleted when you uninstall this plugin. Do you really want to do this?', 'booking' ) )                                                        
                                      .  "' );  
                                if ( answer) {
                                    this.checked = true;                                                                           
                                } else { 
                                    this.checked = false; 
                                } 
                            }
                        } );                         
                        ";         





		// =============================================================================================================        // FixIn: 10.1.5.4.
		// 'Dates selection' - some options hide or show
	    // =============================================================================================================

	    // Initial Hiding some Sections in settings
	    $js_script .= " function wpbc_check_showing_range_days_selection_sections() {        
	                                                                                                    // Single selected
	                        if ( jQuery('#type_of_day_selections_single').is(':checked') ) {
	                            jQuery('.wpbc_recurrent_check_in_out_time_slots').addClass('hidden_items');                            // Hide Reccurent, Check in/out Sections
	                            
	                            jQuery('#set_gen_booking_last_checkout_day_available').prop('checked', false);                        // Uncheck  Recurrent
	                            
	                            jQuery('#set_gen_booking_recurrent_time').prop('checked', false);                                     // Uncheck  Reccurent
	                            jQuery('#set_gen_booking_range_selection_time_is_active').prop('checked', false);                     //      and Check In/Out
	
	                            jQuery('.wpbc_range_days_selection').addClass('hidden_items');                                         // Hide Range section
	                        }                                                                           // Multiple selected
	                        if ( jQuery('#type_of_day_selections_multiple').is(':checked') ) {
	                            jQuery('.wpbc_recurrent_check_in_out_time_slots').removeClass('hidden_items');                         // Show Reccurent, Check in/out Sections
	
	                            jQuery('.wpbc_range_days_selection').addClass('hidden_items');                                         // Hide Range section
	                        }                                                       
	                                                                                                    // Range selected
	                        if ( jQuery('#type_of_day_selections_range').is(':checked') ) {
	                            
	                            jQuery('.wpbc_recurrent_check_in_out_time_slots').removeClass('hidden_items');                         // Show Reccurent, Check in/out Sections
	                        
	                            jQuery('.wpbc_range_days_selection').removeClass('hidden_items');                                      // Show Range section
	                            jQuery('.wpbc_tr_set_gen_booking_range_start_day_week fieldset').removeClass('hidden_items'); 
	                            jQuery('.wpbc_tr_set_gen_booking_range_start_day_dynamic_week fieldset').removeClass('hidden_items'); 
	                            
	                                                                                                    // Fixed selected
	                            if ( jQuery('#range_selection_type_fixed').is(':checked') ) {
	                                jQuery('.wpbc_range_dynamic_selection').addClass('hidden_items');
	                                                                                                    // Any Week Days selected
	                                if ( jQuery('#range_fixed_start_day_any_day').is(':checked') ) {   
	                                    jQuery('.wpbc_tr_set_gen_booking_range_start_day_week fieldset').addClass('hidden_items'); 
	                                }
	                            }
	                                                                                                    // Dynamic selected
	                            if ( jQuery('#range_selection_type_dynamic').is(':checked') ) {
	                                jQuery('.wpbc_range_fixed_selection').addClass('hidden_items'); 
	                                                                                                    // Any Week Days selected
	                                if ( jQuery('#range_dynamic_start_day_any_day').is(':checked') ) {   
	                                    jQuery('.wpbc_tr_set_gen_booking_range_start_day_dynamic_week fieldset').addClass('hidden_items'); 
	                                }
	                            }                            
	                        }
	                        
	                        if ( jQuery('#set_gen_booking_range_selection_time_is_active').is(':checked') ) { // Check In/Out selected
	                            jQuery('.wpbc_check_in_out_time_slots').removeClass('hidden_items');                      // Show Check In/Out times                         
	                        } else {
	                            jQuery('.wpbc_check_in_out_time_slots').addClass('hidden_items');                         // Hide Check In/Out times                         
	                        }
	                    } 
	                    wpbc_check_showing_range_days_selection_sections();         // Run first  time to  init                
	                    ";

	    // Hiding or showing section based on User Clicks in settings
	    $list_of_id_to_hook = array(
	                                  '#type_of_day_selections_single'
	                                , '#type_of_day_selections_multiple'
	                                , '#type_of_day_selections_range'
	                                , '#range_selection_type_fixed'
	                                , '#range_selection_type_dynamic'
	                                , '#range_fixed_start_day_specific_day'
	                                , '#range_fixed_start_day_any_day'
	                                , '#range_dynamic_start_day_specific_day'
	                                , '#range_dynamic_start_day_any_day'
	                               );
	    $list_of_id_to_hook = implode( ',', $list_of_id_to_hook );

		// Click on "Days Selections", "Type of range", "Start Week days" checkboxes or radioboxes, show/hide sections.
	    $js_script .= " jQuery('{$list_of_id_to_hook}').on( 'change', function(){            
	                            wpbc_check_showing_range_days_selection_sections();
	                        } ); ";

		// Click on "Recurrent Time" - then Uncheck "Check In/Out" and hide show sections.
	    $js_script .= " jQuery('#set_gen_booking_recurrent_time').on( 'change', function(){    
	                            if ( this.checked ) { 
	                                jQuery('#set_gen_booking_range_selection_time_is_active').prop('checked', false);
	                            }
	                            wpbc_check_showing_range_days_selection_sections();
	                        } ); ";

		// Click on "Check In/Out" - then Uncheck "Recurrent Time" and hide show sections.
	    $js_script .= " jQuery('#set_gen_booking_range_selection_time_is_active').on( 'change', function(){    
	                            if ( this.checked ) { 
	                                jQuery('#set_gen_booking_recurrent_time').prop('checked', false);
	                                jQuery('#set_gen_booking_last_checkout_day_available').prop('checked', false);                        // Uncheck  Reccurent
	                            }
	                            wpbc_check_showing_range_days_selection_sections();
	                        } ); ";

		// Confirmation  Section  configuration
        $js_script .= " 
                        if ( ! jQuery('#set_gen_booking_confirmation__personal_info__header_enabled').is(':checked') ) {  
                            jQuery('.wpbc_booking_confirmation__personal_info__field').addClass('wpbc_field_disabled'); 
                            jQuery('.wpbc_booking_confirmation__personal_info__fields').addClass('hidden_items'); 
                        }
                      ";
        $js_script .= " jQuery('#set_gen_booking_confirmation__personal_info__header_enabled').on( 'change', function(){    
                                if ( ! this.checked ) { 
                                    jQuery('.wpbc_booking_confirmation__personal_info__field').addClass('wpbc_field_disabled');
                                    jQuery('.wpbc_booking_confirmation__personal_info__fields').addClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_booking_confirmation__personal_info__field').removeClass('wpbc_field_disabled');
                                    jQuery('.wpbc_booking_confirmation__personal_info__fields').removeClass('hidden_items');
                                }
                            } ); ";
        $js_script .= " 
                        if ( ! jQuery('#set_gen_booking_confirmation__booking_details__header_enabled').is(':checked') ) {
                            jQuery('.wpbc_booking_confirmation__booking_details__field').addClass('wpbc_field_disabled');   
                            jQuery('.wpbc_booking_confirmation__booking_details__fields').addClass('hidden_items');                             
                        }
                      ";
        $js_script .= " jQuery('#set_gen_booking_confirmation__booking_details__header_enabled').on( 'change', function(){    
                                if ( ! this.checked ) { 
                                    jQuery('.wpbc_booking_confirmation__booking_details__field').addClass('wpbc_field_disabled');
                                    jQuery('.wpbc_booking_confirmation__booking_details__fields').addClass('hidden_items');
                                } else {
                                    jQuery('.wpbc_booking_confirmation__booking_details__field').removeClass('wpbc_field_disabled');
                                    jQuery('.wpbc_booking_confirmation__booking_details__fields').removeClass('hidden_items');
                                }
                            } ); ";

        $js_script .= " 
                        if ( ! jQuery('#set_gen_booking_confirmation_header_enabled').is(':checked') ) {   
                            jQuery('.wpbc_booking_confirmation_header__field').addClass('wpbc_field_disabled'); 
                        }
                      ";
        $js_script .= " jQuery('#set_gen_booking_confirmation_header_enabled').on( 'change', function(){    
                                if ( ! this.checked ) { 
                                    jQuery('.wpbc_booking_confirmation_header__field').addClass('wpbc_field_disabled');
                                } else {
                                    jQuery('.wpbc_booking_confirmation_header__field').removeClass('wpbc_field_disabled');
                                }
                            } ); ";


        // Enqueue JS to  the footer of the page
        wpbc_enqueue_js( $js_script );
    }
    
}


/**
 * Override VALIDATED fields BEFORE saving to DB
 * Description:
 * Check "Thank you page" URL
 *
 * @param array $validated_fields
 */
function wpbc_settings_validate_fields_before_saving__all( $validated_fields ) {


    $validated_fields['booking_thank_you_page_URL'] = wpbc_make_link_relative( $validated_fields['booking_thank_you_page_URL'] );
    
    unset( $validated_fields[ 'booking_date_format_selection' ] );                      // We do not need to this field,  because saving to DB only: "date_format" field
    unset( $validated_fields[ 'booking_time_format_selection' ] );                      // We do not need to this field,  because saving to DB only: "time_format" field

	// Unset  promote fields
	foreach ( $validated_fields as $field_name => $field_value ) {
		if ( strpos( $field_name, '__promote_upgrade' ) > 0 ) {
			unset( $validated_fields[ $field_name ] );
		}
	}

    return $validated_fields;
}
add_filter( 'wpbc_settings_validate_fields_before_saving', 'wpbc_settings_validate_fields_before_saving__all', 10, 1 );   // Hook for validated fields.


/**
 * Load Code mirror highlighter for Booking Confirmation  at the  WP Booking Calendar > Settings General page in "Booking Confirmation" section
 *
 * @param $page_name
 *
 * @return false|void
 */
function wpbc_hook_settings_page_footer__define_code_mirror( $page_name ) {

	if ( 'general_settings' != $page_name ) {
		return false;
	}

	$is_use_code_mirror = (  ( function_exists( 'wpbc_codemirror') ) && ( is_user_logged_in() && 'false' !== (wp_get_current_user()->syntax_highlighting) ) ) ? true : false;		// FixIn: 8.4.7.18.

	if ( $is_use_code_mirror ) {

		wpbc_codemirror()->set_codemirror( array(
			'textarea_id' => '#set_gen_booking_confirmation__personal_info__content'
			 // , 'preview_id'   => '#wpbc_add_form_html_preview'
		) );
		wpbc_codemirror()->set_codemirror( array(
			'textarea_id' => '#set_gen_booking_confirmation__booking_details__content'
			// , 'preview_id'   => '#wpbc_add_form_html_preview'
		) );

	}
}
 //add_action( 'wpbc_hook_settings_page_footer', 'wpbc_hook_settings_page_footer__define_code_mirror' );