<?php /**
 * @version 1.0
 * @package Booking > Resource page
 * @category Settings page
 * @author wpdevelop
 *
 * @web-site https://wpbookingcalendar.com/
 * @email info@wpbookingcalendar.com
 *
 * @modified 2023-12-29
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit;                                             // Exit if accessed directly			// FixIn: 9.8.15.7.


/**
 * Show Content
 *  Update Content
 *  Define Slug
 *  Define where to show
 */
class WPBC_Page_Settings__bresource extends WPBC_Page_Structure {

    public function in_page() {
		if ( class_exists( 'wpdev_bk_personal' ) ) {
			return (string) wp_rand( 100000, 1000000 );
		}
        return 'wpbc-resources';
    }

    public function tabs() {

        $tabs = array();

        $tabs[ 'resources' ] = array(
                              'title'       => __('Resource','booking')            // Title of TAB
                            , 'hint'        => __('Create unique calendars with individual availability.', 'booking')                      // Hint
                            , 'page_title'  => ucwords( __('Booking resource','booking') )                               // Title of Page
                            //, 'link'      => ''                                 // Can be skiped,  then generated link based on Page and Tab tags. Or can  be external link
                            //, 'position'  => 'left'                             // 'left'  ||  'right'  ||  ''
                            //, 'css_classes'=> ''                                // CSS class(es)
                            //, 'icon'      => ''                                 // Icon - link to the real PNG img
                            , 'font_icon' => 'wpbc-bi-list 0wpbc_icn_checklist'           // CSS definition  of font Icon
                            , 'default'   => ( ! class_exists( 'wpdev_bk_personal' ) )                           // Is this tab activated by default or not: true || false.
                            //, 'disabled'  => false                        // Is this tab disabled: true || false.
                            , 'hided'     => true                           // Is this tab hided: true || false.
                            , 'subtabs'   => array()
                    );
        return $tabs;
    }


    /** Show Content of Settings page */
    public function content() {

        $this->css();

        ////////////////////////////////////////////////////////////////////////
        // Checking
        ////////////////////////////////////////////////////////////////////////

        do_action( 'wpbc_hook_settings_page_header', 'resources');              // Define Notices Section and show some static messages, if needed

        ////////////////////////////////////////////////////////////////////////
        //  S u b m i t   Main Form
        ////////////////////////////////////////////////////////////////////////

        $submit_form_name = 'wpbc_bresources';                         // Define form name
		/*
	        // phpcs:ignore WordPress.Security.NonceVerification.Recommended, WordPress.Security.NonceVerification.Missing
	        if ( isset( $_POST['is_form_sbmitted_'. $submit_form_name ] ) ) {
	            // Nonce checking    {Return false if invalid, 1 if generated between, 0-12 hours ago, 2 if generated between 12-24 hours ago. }
	            $nonce_gen_time = check_admin_referer( 'wpbc_settings_page_' . $submit_form_name );  // Its stop show anything on submiting, if its not refear to the original page

	            // Save Changes
	            $this->update();
	        }
		*/
        do_action('wpbc_bresources_check_submit_actions');

        ////////////////////////////////////////////////////////////////////////
        // JavaScript: Tooltips, Popover, Datepick (js & css)
        ////////////////////////////////////////////////////////////////////////

        echo '<span class="wpdevelop">';

        wpbc_js_for_bookings_page();

        // Toolbar
        $this->toolbar();


        echo '</span>';

        ?><div class="clear" style="margin-bottom:5px;"></div><?php


        // Scroll links ////////////////////////////////////////////////////////
        if (0) {
        ?>
        <div class="wpdvlp-sub-tabs" style="background:none;border:none;box-shadow: none;padding:0;">
	        <span class="nav-tabs" style="text-align:right;">
                <a href="javascript:void(0);" onclick="javascript:wpbc_scroll_to('#wpbc_booking_resource_table' );" original-title="" class="nav-tab go-to-link"><span><?php esc_html_e('Resource' ,'booking'); ?></span></a>
            </span>
        </div>
        <div class="clear"></div>
        <?php
        }

	    do_action( 'wpbc_hook_settings_page_before_content_table', 'resources');              // Define Notices Section and show some static messages, if needed

        ////////////////////////////////////////////////////////////////////////
        // Content  ////////////////////////////////////////////////////////////
        ?>
        <div class="clear"></div>
        <span class="metabox-holder">
            <form  name="<?php echo esc_attr( $submit_form_name ); ?>" id="<?php echo esc_attr( $submit_form_name ); ?>" action="" method="post" autocomplete="off">
                <?php
                   // N o n c e   field, and key for checking   S u b m i t
                   wp_nonce_field( 'wpbc_settings_page_' . $submit_form_name );
                ?><input type="hidden" name="is_form_sbmitted_<?php echo esc_attr( $submit_form_name ); ?>" id="is_form_sbmitted_<?php echo esc_attr( $submit_form_name ); ?>" value="1" /><?php
                ?><div class="clear" style="margin-top:20px;"></div>
                <div id="wpbc_booking_resource_table" class="wpbc_settings_row wpbc_settings_row_rightNO">
                    <?php
                        $this->wpbc_resources_table__show();
                    ?>
                </div>
                <div class="clear"></div>
        </span>
        <?php

        do_action( 'wpbc_hook_settings_page_footer', 'resources' );

        $this->enqueue_js();
    }


    // <editor-fold     defaultstate="collapsed"                        desc=" CSS  &   JS   "  >

	    /** CSS for this page */
	    private function css() {
	        ?>
	        <style type="text/css">
	            .wpbc-help-message {
	                border:none;
	            }
	            /* Selectbox element in toolbar */
	            .visibility_container select optgroup{
	                color:#999;
	                vertical-align: middle;
	                font-style: italic;
	                font-weight: 400;
	            }
	            .visibility_container select option {
	                padding:5px;
	                font-weight: 600;
	            }
	            .visibility_container select optgroup option{
	                padding: 5px 20px;
	                color:#555;
	                font-weight: 600;
	            }
	            #wpbc_create_new_custom_form_name_fields {
	                width: 360px;
	                display:none;
	            }
	            @media (max-width: 399px) {
	                #wpbc_create_new_custom_form_name_fields {
	                    width: 100%;
	                }
	            }
	        </style>
	        <?php
	    }
	
	
	
	    /**
		 * Add Custom JavaScript - for some specific settings options
	     * Executed After post content, after initial definition of settings,  and possible definition after POST request.
	     *
	     * @param type $menu_slug
	     */
	    private function enqueue_js(){
	
	        // JavaScript //////////////////////////////////////////////////////////////
	
	        $js_script = '';
	
	        /*
		        // Hide|Show  on Click      Checkbox
		        $js_script .= " jQuery('#bresources_booking_gcal_auto_import_is_active').on( 'change', function(){
		                                if ( this.checked ) {
		                                    jQuery('.wpbc_tr_auto_import').removeClass('hidden_items');
		                                } else {
		                                    jQuery('.wpbc_tr_auto_import').addClass('hidden_items');
		                                }
		                            } ); ";
	        */
		    
	        // Enqueue JS to  the footer of the page
	        wpbc_enqueue_js( $js_script );
	    }

    // </editor-fold>


	// -----------------------------------------------------------------------------------------------------------------
    // Toolbar
	// -----------------------------------------------------------------------------------------------------------------
    /** Show Toolbar  - Add new booking resources */
    private function toolbar() {

		$wpbc_hidded_element_id = 'toolbar_booking_resources';
		ob_start();
		$is_panel_visible = wpbc_is_dismissed( $wpbc_hidded_element_id , array(
												'title' => '<i class="menu_icon icon-1x wpbc_icn_close"></i> ',
												'hint'  => __( 'Dismiss', 'booking' ),
												'class' => 'wpbc_panel_get_started_dismiss',
												'css'   => 'background: #fff;border-radius: 7px;margin-bottom: -100%;z-index: 4;position: relative;top: 12px;right: 13px;'
											));
		 ?><script type="text/javascript"> jQuery('#<?php echo esc_attr( $wpbc_hidded_element_id ); ?>').hide(); </script><?php
		$dismiss_button_content = ob_get_clean();

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $dismiss_button_content;

		if ( $is_panel_visible ) {
			?>
			<div id="toolbar_booking_resources" style="position:relative;margin-bottom: 5em;padding:1px;border:5px solid #fff;border-radius:5px;box-shadow: 0 3px 15px 0px #d4d4d4;">
				<div class="wpdvlp-top-tabs wpbc_blur">
					<div class="wpdvlp-tabs-wrapper">
						<div class="nav-tabs">
							<a href="javascript:void(0);" class="nav-tab nav-tab-active ">
								<i class="menu_icon icon-1x wpbc_icn_add _circle_outline"></i>
								<span class="nav-tab-text">&nbsp;&nbsp;<?php echo esc_html__('Add Resource', 'booking') . ' ( ' . esc_html__('Calendar', 'booking') . ' )'; ?></span>
							</a>
							<a href="javascript:void(0);" class="nav-tab ">
								<i class="menu_icon icon-1x wpbc_icn_tune"></i>
								<span class="nav-tab-text">&nbsp;&nbsp;<?php echo esc_html__('Options', 'booking'); ?></span>
							</a>
						</div><!-- nav-tabs -->
					</div><!-- wpdvlp-tabs-wrapper -->
				</div><!-- wpdvlp-top-tabs -->
				<form name="wpbc_form_add_new_booking_resources" id="wpbc_form_add_new_booking_resources" action="" method="post" autocomplete="off">
					<div id="booking_resources_toolbar_container" class="wpbc_ajx_toolbar wpbc_blur">
						<div class="ui_container    ui_container_toolbar		ui_container_small    ui_container_actions    ui_container_actions_row_1" style="display: flex;">
							<div class="ui_group">
								<div class="ui_element">
									<input type="text" id="booking_resource_name"
															   name="booking_resource_name" style="min-width:250px;"
															   class="wpbc_ui_control wpbc_ui_text "
															   placeholder="Enter name of booking resource" value=""
															   autocomplete="off" maxlength="200">
								</div>
								<div class="ui_element">
									<a  class="wpbc_ui_control wpbc_ui_button wpbc_ui_button_primary tooltip_top " id="ui_btn_erase_availability"
										href="javascript:void(0);"
										data-original-title="<?php esc_attr_e( 'Add New Booking Resource(s)' ,'booking'); ?>>"><span><?php esc_html_e('Add New', 'booking'); ?>&nbsp;&nbsp;&nbsp;</span><i
											class="menu_icon icon-1x wpbc_icn_add _circle_outline"></i></a>
								</div>
								<div class="ui_element" style="margin-left:15px;">
									<label for="resources_count"
										   class="wpbc_ui_control_label "
										   style=""><span style="font-weight:400"><?php esc_html_e('Resources count', 'booking'); ?> </span></label>
									<select id="resources_count" name="resources_count" class="wpbc_ui_control wpbc_ui_select " style="max-width: 69px;" autocomplete="off">
										<option value="1" class="" style="">1</option>
									</select>
								</div>
							</div>
						</div>
					</div>
				</form>
				<div class="clear"></div>
				<table style="width: 100%;/*! margin-top: 85px; */">
					<tbody>
					<tr>
						<td colspan="2">
							<div class="wpbc_widget_content" style="transform: translate(0) translateY(-4em);">
								<div class="ui_container    ui_container_toolbar		ui_container_small"  style="background: #fff;position: relative;">
									<div class="ui_group    ui_group__upgrade" style="/*! float: right; */">
										<div class="wpbc_upgrade_note wpbc_upgrade_theme_green" style="margin-left: auto;right: 50px;transform: translate(0) translateY(-50%);width: Min(500px, 90%);">
											<div>
												This <a target="_blank" href="https://wpbookingcalendar.com/features/#personal">feature</a>
												is available in the <strong>Pro versions</strong>.
												<a target="_blank" href="https://wpbookingcalendar.com/prices/#bk_news_section">Upgrade to Pro</a>.
											</div>
										</div>
									</div>
								</div>
							</div>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
			<?php
		}

    }

	// -----------------------------------------------------------------------------------------------------------------
    //   B o o k i n g      R e s o u r c e s      T a b l e
	// -----------------------------------------------------------------------------------------------------------------
    /** Show booking resources table */
    public function wpbc_resources_table__show() {

		?>
		<div id="wpbc_booking_resource_table" class="wpbc_settings_row wpbc_settings_row_rightNO">
			<div class="wpdevelop wpbc_selectable_table wpbc_resources_table">
            <table class="table table-striped widefat " cellspacing="0" cellpadding="0">
                <thead class="wpbc_selectable_head">
                    <tr>
	                    <th class="" style="width:5em;text-align: center;"><span href="javascript:void(0);">ID </span></th>
	                    <th class="wpbc_hide_mobile"><span href="javascript:void(0);"><?php esc_html_e( 'Resource Name', 'booking' ); ?> </span></th>
	                    <th class="" style="text-align:center;"><?php esc_html_e( 'Shortcode for page', 'booking' ); ?></th>
	                    <th class="" style="text-align:center;"><?php esc_html_e( 'Actions', 'booking' ); ?></th>
                    </tr>
                </thead>
	            <tbody class="wpbc_selectable_body">
	            <tr class="wpbc_row wpbc_resource_row" id="resource_1">
					<td style="background: transparent;border: none;box-shadow: none;margin: 16px 0 0;padding: 0;display: flex;flex-flow: column;justify-content: center;align-items: center;width: 100%;"
						class="wpbc_hide_mobile wpbc_flextable">
						<div class="wpbc_flextable_col wpbc_flextable_col_id">
							<div class="wpbc_listing_col wpbc_col_booking_labels wpbc_col_labels wpbc_label_resource_id_container">
								<span class="wpbc_label wpbc_label_booking_id wpbc_label_resource_id">1</span>
							</div>
						</div>
					</td>
		            <td class="wpbc_hide_mobile">
			            <input type="text" value="Default" id="booking_resource_1" name="booking_resource_1"
			                   style="float:right;width:100%;font-weight:600;color: #aaa;height: 32px;" disabled="disabled"
			                   class="large-text disabled">
		            </td>
					<?php /* ?>
		            <td class="wpbc_hide_mobile">
						<div class="wpbc_ajx_toolbar" style="display: flex;flex-flow: row wrap;justify-content: center;align-items: center;margin: 0;">
							<div class="ui_container    ui_container_toolbar		ui_container_small    ui_container_options    ui_container_actions_row_1"
								 style="border: none;background: none;padding: 0;">
								<div class="ui_group">
									<div class="ui_element">
									   <a href="https://wpbookingcalendar.com/faq/#shortcodes" class="tooltip_top wpbc-bi-question-circle"	style="line-height: 2.4em;"
										  title="<?php esc_attr_e( 'Learn how to integrate the booking form into a page using the shortcode.','booking'); ?>"></a>
									</div>
									<div class="ui_element">
										<input type="text" value="[booking resource_id=1]" readonly="readonly" onfocus="this.select()"
											   id="booking_resource_shortcode_1" name="booking_resource_shortcode_1"
											   class="large-text put-in" style="width:auto;font-weight:600;border:1px solid #e1e1e1;text-align: center;cursor:pointer;" />
									</div>
									<!--div class="ui_element">
										<a href="javascript:void(0)" onclick="javascript:wpbc_resource_page_btn_click(1);"
										   id="ui_btn_erase_availability" class="wpbc_ui_control wpbc_ui_button wpbc_ui_button_danger0 tooltip_top "
										   title="<?php esc_attr_e( 'Customize Booking Calendar shortcode','booking'); ?>"  >
												<span style="display: none;"><?php esc_html_e('Customize','booking'); ?>&nbsp;&nbsp;&nbsp;</span>
												<i class="menu_icon icon-1x wpbc_icn_tune"></i>
										</a>
									</div-->
								</div>
							</div>
						</div>
		            </td>
		            <td class="" style="text-align: center;">
						<div class="ui_element" style="margin: 0 15px 0 0;">
							<a href="javascript:void(0)" onclick="javascript:wpbc_resource_page_btn_click(1);"
							   id="ui_btn_erase_availability" class="wpbc_ui_control wpbc_ui_button wpbc_ui_button_danger0 tooltip_top "
							   title="<?php esc_attr_e( 'Customize Booking Calendar shortcode','booking'); ?>"  >
									<span style="display: none;"><?php esc_html_e('Customize','booking'); ?>&nbsp;&nbsp;&nbsp;</span>
									<i class="menu_icon icon-1x wpbc_icn_tune"></i>
							</a>
						</div>
			            <a href="javascript:void(0);"
			               onclick="javascript: wpbc_modal_dialog__show__resource_publish( 1 );"
			               class="button button-primary tooltip_top"
						   title="<?php esc_attr_e('Embed your booking form into the page', 'booking'); ?>"
						><?php esc_html_e( 'Publish', 'booking' ); ?></a>
		            </td>
 					<?php */
					// FixIn: 10.3.0.8.
					?>
					<td colspan="2" class="wpbc_flextable_col">
						<div class="wpbc_ajx_toolbar">
							<div class="ui_container ui_container_small">
								<div class="ui_group ui_group__shortcode">
									<div class="ui_element" style="flex: 1 1 auto;margin: 0;">
										<div id="div_booking_resource_shortcode_1" name="div_booking_resource_shortcode_1" class="shortcode_text_field large-text put-in">
											[booking resource_id=1]
										</div>
										<input type="hidden" value="[booking resource_id=1]" id="booking_resource_shortcode_1" name="booking_resource_shortcode_1">
									</div>
									<div class="ui_element" style="margin-left: 0px;margin-right: 0px;">
									   <a href="https://wpbookingcalendar.com/faq/#shortcodes"
										  class="tooltip_top wpbc-bi-question-circle"
										  data-original-title="<?php echo esc_attr( __('Learn how to integrate the booking form into a page using the shortcode.','booking') ); ?>"></a>
									</div>
								</div>
								<div class="ui_group ui_group__publish_btn">
									<div class="ui_element" style="margin: 0 15px 0 0;">
										<a href="javascript:void(0)" onclick="javascript:wpbc_resource_page_btn_click(1);"
										   id="ui_btn_erase_availability"
										   class="wpbc_ui_control wpbc_ui_button wpbc_ui_button_danger0 tooltip_top "
										   data-original-title="<?php echo esc_attr( __('Customize Booking Calendar shortcode','booking') ); ?>">
												<span style="display: none;"><?php esc_html_e('Customize','booking'); ?>&nbsp;&nbsp;&nbsp;</span>
												<i class="menu_icon icon-1x wpbc_icn_tune"></i>
										</a>
									</div>
									<div class="ui_element" style="margin: 0 2px 0 0;">
										<a class="wpbc_ui_control wpbc_ui_button wpbc_ui_button_primary tooltip_top "
										   href="javascript:void(0);"
										   onclick="javascript: wpbc_modal_dialog__show__resource_publish( 1 );"
										   data-original-title="<?php echo esc_attr( __('Embed your booking form into the page','booking') ); ?>">
											<span><?php esc_html_e('Publish','booking'); ?></span>
											<i class="menu_icon icon-1x wpbc_icn_tune" style="display: none;"></i>
										</a>
									</div>
								</div>
							</div>
						</div>
					</td>
	            </tr>
	            </tbody>
	            <tfoot class="wpbc_selectable_foot">
	            <tr>
		            <th colspan="5" style="text-align: center;"></th>
	            </tr>
	            </tfoot>
            </table>
		    </div>
			<div class="clear"></div>
			<?php
				echo  '<a style="margin:0;" class="button button" href="' . esc_url( wpbc_get_settings_url() . '&system_info=show&_wpnonce='. wp_create_nonce( 'wpbc_settings_url_nonce' ) ) .'&restore_dismissed=On#wpbc_general_settings_restore_dismissed_metabox">' .
					  esc_html__( 'Restore all dismissed windows', 'booking' )
					. '</a>';
			?>
		</div>
		<?php
    }

}

add_action('wpbc_menu_created', array( new WPBC_Page_Settings__bresource() , '__construct') );    // Executed after creation of Menu