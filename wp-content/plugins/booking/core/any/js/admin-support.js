/**
 * @version 1.0
 * @package Support Functions
 * @subpackage BackEnd Main Script Lib
 * @category Scripts 
 * @author wpdevelop
 *
 * @web-site https://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com 
 * 
 * @modified 2015-04-09
  */

function wpbc_parse_url_and_get_params_arr( url ) {

	var url_parameters     = url.split( '?' )[1];
	var result_params_arr  = {};
	var url_parameters_arr = url_parameters.split( /\?|&/ );
	var param_length       = url_parameters_arr.length;
	for ( var i = 0; i < param_length; i++ ) {
		if ( ! url_parameters_arr[i] ) {
			continue;
		}
		var ary                   = url_parameters_arr[i].split( '=' );
		result_params_arr[ary[0]] = ary[1];
	}
	return result_params_arr;
}

function wpbc_ui_settings__menu__click( url, left_vert_nav_menu_a, section_id_to_show, text_for_path ){

	var current_page_params     = wpbc_parse_url_and_get_params_arr( window.location.href );
	var destination_page_params = wpbc_parse_url_and_get_params_arr( url );

	var is_this_same_page = 0;

	if (current_page_params['page'] === destination_page_params['page']){
		is_this_same_page++;
	}
	if (
		(  (typeof( current_page_params['tab'] ) === 'undefined') &&  (typeof( destination_page_params['tab'] ) === 'undefined') ) ||
		(  (current_page_params['tab'] === destination_page_params['tab']) )
	) {
		is_this_same_page++;
	}
	if (
		(  (typeof( current_page_params['subtab'] ) === 'undefined') &&  (typeof( destination_page_params['subtab'] ) === 'undefined') ) ||
		(  (current_page_params['subtab'] === destination_page_params['subtab']) )
	) {
		is_this_same_page++;
	}

	if ( 3 === is_this_same_page ) {
		wpbc_ui_settings__panel__click( left_vert_nav_menu_a, section_id_to_show, text_for_path )
	} else {
		window.location.href = url;
	}

}

function wpbc_ui_settings__panel__click( left_vert_nav_menu_a, section_id_to_show, text_for_path ){

	// Update text in Top Menu.
	jQuery( '.wpbc_settings_path_el_active' ).html(
		'<a onclick="javascript:wpbc_ui_settings__panel__click( \'' + left_vert_nav_menu_a + '\', \'' + section_id_to_show + '\', \'' + text_for_path + '\' );" href="javascript:void(0);">' + text_for_path + '</a>'
	);

    // Show / Hide section  and enable Left Vert Menu item
    wpbc_navigation_click_show_section( left_vert_nav_menu_a, section_id_to_show , '.postbox' , false);

    // wpbc_scroll_to( '.wpbc_settings_path_el_active' );        // Scroll  to  path.
    // wpbc_scroll_to( '.wpbc_page_top__header_tabs' );            // Scroll  to  Top.
    wpbc_scroll_to( '.wpbc_settings_page_header_title' );            // Scroll  to  Top.

}


/**
 * When  click  on Navigation Column menu
 */
function wpbc_navigation_click_show_section( _this, section_id_to_show ){
    var container_to_hide_class = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '.postbox';
    var is_scroll = arguments.length > 3 && arguments[3] !== undefined ? arguments[3] : true;

    // -- Set Left Nav Active ------------------------------------------------------------------------------------------
    jQuery( _this ).parents( '.wpbc_settings_flex_container' ).find( '.wpbc_settings_navigation_item_active' ).removeClass( 'wpbc_settings_navigation_item_active' );
    jQuery( _this ).parents( '.wpbc_settings_navigation_item' ).addClass( 'wpbc_settings_navigation_item_active' );
    // -- Hide all  and show selected ----------------------------------------------------------------------------------
    jQuery( _this ).parents( '.wpbc_settings_flex_container' ).find( container_to_hide_class ).hide();
    jQuery( '.wpbc_container_always_hide__on_left_nav_click' ).hide();
    jQuery( section_id_to_show ).show();

    // -- Scroll -------------------------------------------------------------------------------------------------------
    //jQuery( _this ).trigger( 'blur' );
    if ( is_scroll ) {
        var targetOffset = wpbc_scroll_to( section_id_to_show );
    }

    // -- Set Value to Input about selected Nav element  ---------------------------------------------------------------       // FixIn: 9.8.6.1.
    var section_id_tab = section_id_to_show.substring( 0, section_id_to_show.length - 8 ) + '_tab';
    if ( container_to_hide_class == section_id_to_show ){
        section_id_tab = '#wpbc_general_settings_all_tab'
    }
    if ('#wpbc_general_settings_capacity_metabox,#wpbc_general_settings_capacity_upgrade_metabox'== section_id_to_show){
        section_id_tab = '#wpbc_general_settings_capacity_tab'
    }
    jQuery( '#form_visible_section' ).val( section_id_tab );
}


/**
	 * Scroll to  specific HTML element
 * 
 * @param {type} object_name
 * @returns {undefined}
 */
function wpbc_scroll_to(object_name) {

	if ( jQuery( object_name ).length > 0 ) {
		var targetOffset = jQuery( object_name ).offset().top;
		if ( targetOffset < 0 ) {
			targetOffset = 0;
		}
		if ( jQuery( '#wpadminbar' ).length > 0 ) {
			targetOffset = targetOffset - 50 - 40;
		} else {
			targetOffset = targetOffset - 20;
		}
		jQuery( 'html,body' ).animate( { scrollTop: targetOffset }, 500 );
		return targetOffset;
	}
	return 0;
}

/**
 * Auto scroll to  unchor after  page loaded.
 */
jQuery( document ).ready(
	function () {
		setTimeout(
			function () {
				// window.location.hash  = #section_id  /  doc: https://developer.mozilla.org/en-US/docs/Web/API/Location .
				wpbc_scroll_to( window.location.hash );
			},
			100
		);
	}
);

function wpbc_animate_border( element, time, colors, x ) {

    if ( x >= colors.length ) {
        x = 0;
    } else {
        x++;
        var color;
        if ( colors[ x ] === '' ) {
            color = '';
        } else {
            color = '#' + colors[ x ];
        }
        element.css( 'border-color', color );
        element.css( 'color', color );
        setTimeout( function () {
            wpbc_animate_border( element, time, colors, x );
        }, time );
    }
}

function wpbc_field_highlight( object_name ) {    
    
    if ( jQuery( object_name ).length > 0 ) { 
     
        wpbc_scroll_to( object_name );
        
        wpbc_animate_border( 
                                jQuery( object_name )                           // Element 
                                , 200                                           // Time in ms
                                , ['d63637', '', 'd63637', '', 'd63637', '', 'd63637', '', 'd63637', '', 'd63637', '']      // Colors Array
                                , 0
                            ); 
    }
}

/**
	 * Show Yes/No dialog
 * 
 * @param {type} message_question
 * @returns {Boolean}
 */
function wpbc_are_you_sure( message_question ){
    var answer = confirm( message_question );
    if ( answer) { return true; }
    else         { return false;}
}

function wpbc_admin_show_message_processing( message_type ){
    
    var message = '' ;
    
    if ( message_type == 'saving' )
        message += _wpbc.get_message( 'message_saving' );
    else if ( message_type == 'updating' )
        message += _wpbc.get_message( 'message_updating' );
    else if ( message_type == 'deleting' )
        message += _wpbc.get_message( 'message_deleting' );
    else 
        message += _wpbc.get_message( 'message_processing' );
      
    if ( message == 'undefined' )  
        message = 'Processing'
      
    message = ' <span class="wpdevelop"><span class="wpbc_icn_rotate_right wpbc_spin wpbc_ajax_icon wpbc_processing wpbc_icn_autorenew"  aria-hidden="true"></span></span> ' + message + '...';
    
    wpbc_admin_show_message( message, 'info', 10000 );
}

/**
 * Show Alert Messages
 * 
 * @param {string} message 
 * @param {string} m_type   - notice (default) | error | warning | info | success
 * @param {tyintpe} m_delay - microseconds
 * @param {bool} is_append (default true) - append notice instead of replacing
 * @returns {undefined}
 */
function wpbc_admin_show_message( message, m_type, m_delay, is_append ){                     // FixIn: 7.2.1.16.

	if ( is_append === undefined) {                                             // FixIn: 8.0.1.100.
		is_append = true;
	}

    var alert_class = 'notice ';                                                //'alert ';
    if (m_type == 'error'){
        alert_class += 'notice-error ';
        message = '<i style="margin-right: 0.5em;color: #d63638;" class="menu_icon icon-1x wpbc_icn_report_gmailerrorred"></i>' + message;
    }                 //'alert-danger ';
    if (m_type == 'warning'){
        alert_class += 'notice-warning ';
        message = '<i style="margin-right: 0.5em;color: #e9aa04;" class="menu_icon icon-1x wpbc_icn_warning"></i>' + message;
    };
    if (m_type == 'info')       alert_class += 'notice-info ';                  //'alert-info '; 
    if ( m_type == 'success' ){
        alert_class += 'alert-success updated ';
        message = '<i style="margin-right: 0.5em;color: #64aa45;" class="menu_icon icon-1x wpbc_icn_done_outline"></i>' + message;
    }

//    var ajx_working_content = '';
//    if ( is_append )
//     ajx_working_content = jQuery('#ajax_working').html();    

    var unique_div_id = new Date();
    unique_div_id = 'wpbc_notice_' + unique_div_id.getTime();

    if ( is_append ){

		jQuery( '#ajax_working .wpbc_processing' ).parent().parent().parent().hide();

		jQuery( '#ajax_working' ).append(
			'<div id="' + unique_div_id + '"><div id="wpbc_alert_message" class="wpbc_alert_message">' +
			    '<div class="wpbc_inner_message ' + alert_class + '"> ' +
			        '<a class="close" href="javascript:void(0)" onclick="javascript:jQuery(this).parent().hide();">&times;</a> ' +
                    message +
			    '</div>' +
			'</div></div>'
		);
	} else
        jQuery('#ajax_working').html(  
                                  '<div id="' + unique_div_id + '"><div id="wpbc_alert_message" class="wpbc_alert_message">' +
                                        '<div class="wpbc_inner_message '+alert_class+'"> ' +
                                            '<a class="close" href="javascript:void(0)" onclick="javascript:jQuery(this).parent().hide();">&times;</a> ' + 
                                            message + 
                                        '</div>' +
                                    '</div></div>' 
                                );
    jQuery( '#' + unique_div_id ).animate( {opacity: 1}, m_delay ).fadeOut( 500 );
    var closed_timer2 = setTimeout( function (){
                                                    jQuery( '#' + unique_div_id ).trigger( 'hide' );
                                    }, ( parseInt( m_delay ) + 501 ) );
}

/**
 * Start: Dropdown BS List elements  -------------------------------------------------------------------------------- */

    function wpbc_close_dropdown_selectbox( selector_id ) {
      jQuery('#' + selector_id + '_container li input[type=checkbox],#' + selector_id + '_container li input[type=radio]').prop('checked', false);
      jQuery('#' + selector_id + '_container').hide();
    }

    // Show Container depend from the selected option in dropdown list.
    function wpbc_show_selected_in_dropdown( selector_id, title, value ){
        jQuery('#' + selector_id + '_selector .wpbc_selected_in_dropdown').html( title );
        jQuery('#' + selector_id ).val( value );
        jQuery('#' + selector_id ).trigger('change');
    }

    // Show Container depend from the selected Radio Option and Selectbox value in dropdown list.
    // Exmaple: wpbc_show_selected_in_dropdown__radio_select_option( 'wh_booking_date', 'wh_booking_date2', 'wh_booking_datedays_interval_Radios' );.
    function wpbc_show_selected_in_dropdown__radio_select_option( selector_id, selector_id2, radio_name ){

        // Get selected value in radio buttons
        var rad_val = jQuery('input:radio[name="' + radio_name + '"]:checked').val();

        if ( rad_val != 'undefined' ) {

            var select_box = jQuery('input:radio[name="' + radio_name + '"]:checked').parents('.input-group').find('select');
            // Selectbox exist
            if ( select_box.length > 0 ) {
                // Get label near selected radiobutton  and selected Tilte in selectbox
                var title = jQuery('input:radio[name="' + radio_name + '"]:checked').parent().find('label').html() + ' ' +
                            jQuery('input:radio[name="' + radio_name + '"]:checked').parents('.input-group').find('select option:selected').text();
                // Get Value of selected option in selectbox
                var value = jQuery('input:radio[name="' + radio_name + '"]:checked').parents('.input-group').find('select option:selected').val();
                // Set  Title in dropdown list
                jQuery('#' + selector_id + '_selector .wpbc_selected_in_dropdown').html( title );
                // Set  value of radio button
                jQuery('#' + selector_id ).val( rad_val );
                // Set  value of selectbox
                jQuery('#' + selector_id2 ).val( value );
            } else {
                // 2 Text Fields
                var text_box = jQuery('input:radio[name="' + radio_name + '"]:checked').parents('.text-group').find('input[type="text"]');
                if ( text_box.length > 0 ) {
                   var text_divs = jQuery('input:radio[name="' + radio_name + '"]:checked').parents('.text-group').find('.dropdown-menu-text-element');

                   // Check if we have 2 DIV elements with text fields
                   if ( text_box.length > 0 ) {

                        var id_list = [ selector_id, selector_id2 ];
                        var title = '';
                        //Loop our text DIV elements
                        jQuery('input:radio[name="' + radio_name + '"]:checked').parents('.text-group').find('.dropdown-menu-text-element').each(function( i ) {

                            if ( title != '' )
                                title += ' - ';
                            title += jQuery(this).find('input[type="text"]').val();
                            jQuery('#' + id_list[ i ] ).val(  jQuery(this).find('input[type="text"]').val() );
                        });
                        // Set  Title in dropdown list
                        jQuery('#' + selector_id + '_selector .wpbc_selected_in_dropdown').html( title );

                   }
                }
            }
        }

        jQuery('#' + selector_id ).trigger( 'change' );

        // Hide dropdown list
        jQuery('#' + selector_id + '_container').hide();
    }

/**
 * End:   Dropdown BS List elements  -------------------------------------------------------------------------------- */


/**
	 * Ajax Request
 * 
 * @param {type} us_id
 * @param {type} window_id
 * @returns {undefined}
 */
function wpbc_verify_window_opening(us_id, window_id) {

	var is_closed = 0;

	if ( jQuery( '#' + window_id ).hasClass( 'closed' ) == true ) {
		jQuery( '#' + window_id ).removeClass( 'closed' );
	} else {
		jQuery( '#' + window_id ).addClass( 'closed' );
		is_closed = 1;
	}

	jQuery.ajax(
		{
		// Start Ajax Sending.
		url    : wpbc_url_ajax,
		type   : 'POST',
		success: function (data, textStatus) {
			if ( textStatus == 'success' ) jQuery( '#ajax_respond' ).html( data );
		},
		error  : function (XMLHttpRequest, textStatus, errorThrown) {
			window.status = 'Ajax sending Error status:' + textStatus;
			alert( XMLHttpRequest.status + ' ' + XMLHttpRequest.statusText );
			if ( XMLHttpRequest.status == 500 ) {
				alert( 'Error: 500' );
			}
		},
		// beforeSend: someFunction,
		data: {
			action    : 'USER_SAVE_WINDOW_STATE',
			user_id   : us_id,
			window    : window_id,
			is_closed : is_closed,
			wpbc_nonce: jQuery( '#wpbc_admin_panel_nonce' ).val()
		}
	}
	);

}

/**
	 * Ajax Request - Saving Custom Data for User
 * 
 * @param {int} us_id
 * @param {string} data_name
 * @param {string} data_value - serialized data
 * @param {int} is_reload  -  { 0 | 1 } reload or not page
 */
function wpbc_save_custom_user_data( us_id, data_name, data_value , is_reload ){

	wpbc_admin_show_message_processing( 'saving' );

        jQuery.ajax({                                           // Start Ajax Sending
                url: wpbc_url_ajax,
                type:'POST',
                success: function (data, textStatus){if( textStatus == 'success')   jQuery('#ajax_respond').html( data );},
                error:function (XMLHttpRequest, textStatus, errorThrown){ window.status = 'Ajax sending Error status:'+ textStatus; alert(XMLHttpRequest.status + ' ' + XMLHttpRequest.statusText); if ( XMLHttpRequest.status == 500 ) { alert('Error: 500'); } } ,
                // beforeSend: someFunction,
                data:{
                    action:     'USER_SAVE_CUSTOM_DATA',
                    user_id:    us_id,
                    data_name:  data_name,
                    data_value: decodeURIComponent( data_value ),
                    is_reload:  is_reload, 
                    wpbc_nonce: jQuery('#wpbc_admin_panel_nonce').val() 
                }
        });
}

// Contact Form.
function wpbc_submit_client_form( submit_form, wpdev_active_locale ){
    
    var count = submit_form.elements.length;
    var formdata = '';
    var inp_value;
    var element;
    var el_type;

    for (var i=0; i<count; i++)   {
        element = submit_form.elements[i];

        if ( (element.type !=='button') && (element.type !=='hidden') ) {       

            // Get Value of Element
            if ( element.type == 'checkbox' ){

                if ( element.value == '' ) {
                    inp_value = element.checked;
                } else {
                    if ( element.checked ) 
                        inp_value = element.value;
                    else 
                        inp_value = '';
                }

            } else if ( element.type == 'radio' ) {

                if ( element.value == '' ) {
                    inp_value = element.checked;
                } else {
                    if ( element.checked ) 
                        inp_value = element.value;
                    else 
                        inp_value = '';
                }
                /*
                if ( element.checked ) 
                    inp_value = element.value; 
                else 
                    continue;
                */
                
            } else {
                inp_value = element.value;
            }                      

            // Get value in selectbox of multiple selection
            if ( (element.type == 'selectbox-multiple') || (element.type == 'select-multiple') ){
                inp_value = jQuery('[name="'+element.name+'"]').val() ;
                if ( ( inp_value == null ) || ( inp_value.toString() == '' ) )
                    inp_value='';
            }
            
            /*if ( element.name == ('phone') ) {
                // we validate a phone number of 10 digits with no comma, no spaces, no punctuation and there will be no + sign in front the number - See more at: http://www.w3resource.com/javascript/form/phone-no-validation.php#sthash.U9FHwcdW.dpuf
                var reg =  /^\d{10}$/;
                var message_verif_phone = "Please enter correctly phone number";
                if ( inp_value != '' )
                    if(reg.test(inp_value) == false) {wpbc_show_error_message( element , message_verif_phone);return;}
            }*/


            // Validation Check -- Requred fields
            if ( element.className.indexOf( 'wpbc-validate-required' ) !== -1 ){      
                
                if  ( ( element.type =='checkbox' ) && ( element.checked === false ) ) {
                    if ( ! jQuery(':checkbox[name="'+element.name+'"]', submit_form).is(":checked") ) {
                        wpbc_show_error_message( element , _wpbc.get_message( 'message_check_required_for_check_box' ) );
                        return;                            
                    }
                }
                if  ( element.type =='radio' ) {
                    if ( ! jQuery(':radio[name="'+element.name+'"]', submit_form).is(":checked") ) {
                        wpbc_show_error_message( element , _wpbc.get_message( 'message_check_required_for_radio_box' ) );
                        return;                            
                    }
                }
                if  ( ( element.type !='checkbox' ) && ( element.type !='radio' ) && ( inp_value === '' ) ) {
                    wpbc_show_error_message( element , _wpbc.get_message( 'message_check_required' ) );
                    return;
                }
            }

            // Validation Check --- Email correct filling field
            if ( element.className.indexOf( 'wpbc-validate-email' ) !== -1 ){                
                var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,})$/;
                if ( ( inp_value != '' ) && ( reg.test(inp_value) == false ) ) {
                    wpbc_show_error_message( element ,  _wpbc.get_message( 'message_check_email' ) );
                    return;
                }
            }

            /*
            // Validation Check --- Same Email Field
            if ( ( element.className.indexOf('wpdev-validates-as-email') !== -1 ) && ( element.className.indexOf('same_as_') !== -1 ) ) { 

                // Get  the name of Primary Email field from the "same_as_NAME" class                    
                var primary_email_name = element.className.match(/same_as_([^\s])+/gi); 
                if (primary_email_name != null) { // We found
                    primary_email_name = primary_email_name[0].substr(8);

                    // Recehck if such primary email field exist in the booking form
                    if (jQuery('[name="' + primary_email_name  + '"]').length > 0) {

                        // Recheck the values of the both emails, if they do  not equla show warning                    
                        if ( jQuery('[name="' + primary_email_name  + '"]').val() !== inp_value ) {
                            wpbc_show_error_message( element , _wpbc.get_message( 'message_check_same_email' ) );return;
                        }
                    }
                }
                // Skip one loop for the email veryfication field
                continue;
            } */

            /*
            // Get Form Data
            if ( element.name !== ('captcha_input' ) ) {
                if (formdata !=='') formdata +=  '~';                                                // next field element

                el_type = element.type;
                if ( element.className.indexOf('wpdev-validates-as-email') !== -1 )  el_type='email';
                if ( element.className.indexOf('wpdev-validates-as-coupon') !== -1 ) el_type='coupon';

                inp_value = inp_value + '';
                inp_value = inp_value.replace(new RegExp("\\^",'g'), '&#94;'); // replace registered characters
                inp_value = inp_value.replace(new RegExp("~",'g'), '&#126;'); // replace registered characters

                inp_value = inp_value.replace(/"/g, '&#34;'); // replace double quot
                inp_value = inp_value.replace(/'/g, '&#39;'); // replace single quot

                formdata += el_type + '^' + element.name + '^' + inp_value ;                    // element attr
            } */
        }

    }  // End Fields Loop
    
        
    submit_form.submit();                                                       // Submit Form,  if previously  was no interuptions 
}

/**
 * Show message under specific element
 * 
 * @param {type} element - jQuery definition  of the element
 * @param {type} errorMessage - String message
 * @param {type} message_type "" | "alert-warning" | "alert-success" | "alert-info" | "alert-danger"
 */
function wpbc_show_message_under_element( element , errorMessage , message_type) {

     wpbc_scroll_to( element );
    
     if ( jQuery( element ).attr('type') == "radio" ) {
        jQuery( element ).parent().parent().parent()
                .after('<span class="wpbc-near-field-message alert '+ message_type +'">'+ errorMessage +'</span>'); // Show message

    } else if (jQuery( element ).attr('type') == "checkbox") {
        jQuery( element ).parent()
                .after('<span class="wpbc-near-field-message alert '+ message_type +'">'+ errorMessage +'</span>'); // Show message

    } else {
        jQuery( element )
                .after('<span class="wpbc-near-field-message alert '+ message_type +'">'+ errorMessage +'</span>'); // Show message
    }
    jQuery(".widget_wpbc .wpbc-near-field-message")
            .css( {'vertical-align': 'sub' } ) ;
    jQuery(".wpbc-near-field-message")
            .animate( {opacity: 1}, 10000 )
            .fadeOut( 2000 ); 
}

// Show Error Message in Booking Form  at Front End.
function wpbc_show_error_message( element , errorMessage) {

    // Scroll to the element
    wpbc_scroll_to( element );

    jQuery("[name='"+ element.name +"']")
            .fadeOut( 350 ).fadeIn( 300 )
            .fadeOut( 350 ).fadeIn( 400 )
            .fadeOut( 350 ).fadeIn( 300 )
            .fadeOut( 350 ).fadeIn( 400 )
            .animate( {opacity: 1}, 4000 )
    ;  // mark red border
    
    if (jQuery("[name='"+ element.name +"']").attr('type') == "radio") {
        jQuery("[name='"+ element.name +"']").parent().parent()//.parent()
                .after('<span class="wpbc-near-field-message alert alert-warning">'+ errorMessage +'</span>'); // Show message

    } else if (jQuery("[name='"+ element.name +"']").attr('type') == "checkbox") {
        jQuery("[name='"+ element.name +"']").parent().parent()
                .after('<span class="wpbc-near-field-message alert alert-warning">'+ errorMessage +'</span>'); // Show message

    } else {
        jQuery("[name='"+ element.name +"']")
                .after('<span class="wpbc-near-field-message alert alert-warning">'+ errorMessage +'</span>'); // Show message
    }
    jQuery(".wpbc-near-field-message")
            .css( {'padding' : '5px 5px 4px', 'margin' : '2px', 'vertical-align': 'top', 'line-height': '32px' } );
    
    if ( element.type == 'checkbox' )
        jQuery(".wpbc-near-field-message").css( { 'vertical-align': 'middle'} );
            
    jQuery(".widget_wpbc .wpbc-near-field-message")
            .css( {'vertical-align': 'sub' } ) ;
    jQuery(".wpbc-near-field-message")
            .animate( {opacity: 1}, 10000 )
            .fadeOut( 2000 );
    jQuery( element).trigger( 'focus' );    // FixIn: 8.7.11.12.
    return;

}


/**
 * Reload the page with  new parameter value.
 * 
 * @param {type} url            - full URL  of the page,  can include or exclude that parameter
 * @param {type} param          - URL parameter name
 * @param {type} value          - URL parameter value
 * @returns {undefined}
 */
function wpbc_reload_page_with_paramater( url, param, value ) {
    var hash       = {};
    var parser     = document.createElement('a');

    parser.href    = url;

    var parameters = parser.search.split(/\?|&/);

    for(var i=0; i < parameters.length; i++) {
        if(!parameters[i])
            continue;

        var ary      = parameters[i].split('=');
        hash[ary[0]] = ary[1];
    }

    hash[param] = value;

    var list = [];  
    Object.keys(hash).forEach(function (key) {
        list.push(key + '=' + hash[key]);
    });

    parser.search = '?' + list.join('&');
    //return parser.href;
    window.location.href = parser.href;
}

// Deprecated:.
jQuery( window ).on( "load", function (){       // FixIn: 8.7.9.7.

    // Color Text picker ///////////////////////////////////////////////////////
    if ( jQuery('.field-text-color').length > 0 ) {
        jQuery('.field-text-color').iris( {
            change: function(event, ui){
                jQuery(this).css( { backgroundColor: ui.color.toString() } );            
                jQuery(this).closest('.fields-color-group').find('.fieldvalue').css( { color: ui.color.toString() } );
            }
            , hide: true
            , border: true
            , palettes: ['#333', '#555', '#777', '#aaa', '#fff']        
        } ).each( function() {
            jQuery(this).css( { backgroundColor: jQuery(this).val() } );
        })
        .on( 'click', function(){                   // FixIn: 8.7.11.12.
            jQuery('.iris-picker').hide();
            jQuery(this).closest('div').find('.iris-picker').show();
        });
    }
    // Color Background picker ///////////////////////////////////////////////// 
    if ( jQuery('.field-background-color').length > 0 ) {
        jQuery('.field-background-color').iris( {
            change: function(event, ui){
                jQuery(this).css( { backgroundColor: ui.color.toString() } );
                jQuery(this).closest('.fields-color-group').find('.fieldvalue').css( { backgroundColor: ui.color.toString() } );
            }
            , hide: true
            , border: true
            , palettes: [ '#FFEE99', '#459', '#78b', '#ab0', '#df5d5d', '#f0f']        
        } ).each( function() {
            jQuery(this).css( { backgroundColor: jQuery(this).val() } );
        })
        .on( 'click', function(){                   // FixIn: 8.7.11.12.
            jQuery('.iris-picker').hide();
            jQuery(this).closest('div').find('.iris-picker').show();
        });
        // FixIn: 8.7.11.12.
        jQuery('.field-text-color, .field-background-color' ).on( 'click', function(event){
            event.stopPropagation();
        });
    }

	// -----------------------------------------------------------------------------------------------------------------
    // General Color picker in settings table //////////////////////////////////
	// -----------------------------------------------------------------------------------------------------------------
    if ( jQuery('.wpbc_colorpick').length > 0 ) {
        jQuery('.wpbc_colorpick').iris( {
            change: function(event, ui){
                jQuery(this).css( { backgroundColor: ui.color.toString() } );
            }
            , hide: true
            , border: true
            , palettes: ['#125', '#459', '#78b', '#ab0', '#de3', '#f0f']        
        } ).each( function() {
            jQuery(this).css( { backgroundColor: jQuery(this).val() } );
        })
        .on( 'click', function(){                   // FixIn: 8.7.11.12.
            jQuery('.iris-picker').hide();
            jQuery(this).closest('td').find('.iris-picker').show();
        });

        jQuery('body' ).on( 'click', function() {
            jQuery('.iris-picker').hide();
        });
        // FixIn: 8.7.11.12.
        jQuery('.wpbc_colorpick' ).on( 'click', function(event){
            event.stopPropagation();
        });
    }
});

// -- Support Functions ------------------------------------------------------------------------------------------------

/**
 * Reset of WP Editor or TextArea Content
 * @param {string} editor_textarea_id - ID of element
 * @param {string} editor_textarea_content - Content
 */
function wpbc_reset_wp_editor_content( editor_textarea_id, editor_textarea_content ) {

        // FixIn: 8.4.7.18.

    if  ( (typeof WPBC_CM !== 'undefined') && ( WPBC_CM.is_defined( '#' + editor_textarea_id ) ) ){

        WPBC_CM.set_codemirror_value( '#' + editor_textarea_id , editor_textarea_content );
    } else {

        if( typeof tinymce != "undefined" ) {
            var editor = tinymce.get( editor_textarea_id );
            if( editor && editor instanceof tinymce.Editor ) {
                editor.setContent( editor_textarea_content );
                editor.save( { no_events: true } );
            } else {
                jQuery( '#' + editor_textarea_id ).val( editor_textarea_content );
            }
        } else {
            jQuery( '#' + editor_textarea_id ).val( editor_textarea_content );
        }
    }
}

/**
	 * Dismiss window / panel in Welcome Page
 * 
 * @param {type} us_id
 * @param {type} window_id
 * @returns {undefined}
 */
function wpbc_dismiss_window(us_id,  window_id ){

    jQuery.ajax({                                           // Start Ajax Sending                        
            url: wpbc_url_ajax,
            type:'POST',
            success: function (data, textStatus){if( textStatus == 'success')   jQuery('#ajax_respond').html( data );},
            error:function (XMLHttpRequest, textStatus, errorThrown){window.status = 'Ajax sending Error status:'+ textStatus;alert(XMLHttpRequest.status + ' ' + XMLHttpRequest.statusText);if (XMLHttpRequest.status == 500) {alert('Please check at this page according this error:' + ' https://wpbookingcalendar.com/faq/#ajax-sending-error');}},
            // beforeSend: someFunction,
            data:{
                //ajax_action : 'USER_SAVE_WINDOW_STATE',
                action : 'USER_SAVE_WINDOW_STATE',
                user_id: us_id ,
                window: window_id,
                is_closed: 1,
                wpbc_nonce: document.getElementById('wpbc_admin_panel_dismiss_window_nonce').value 
            }
    });
}

/**
 * Hide HTML element with animation during 0.5 second
 *
 * @param window_id  - HTML ID of element, such as 'wpbc_my_window' - without # symbol
 */
function wpbc_hide_window(window_id) {
	jQuery( '#' + window_id ).slideUp( 800 );
}
