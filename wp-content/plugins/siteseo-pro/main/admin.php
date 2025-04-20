<?php
/*
* SITESEO
* https://siteseo.io
* (c) SITSEO Team
*/

namespace SiteSEOPro;

if(!defined('ABSPATH')){
	die('HACKING ATTEMPT!');
}

class Admin{
	
	static function init(){
		
		add_action('admin_enqueue_scripts', '\SiteSEOPro\Admin::enqueue_script');
		add_action('admin_menu', '\SiteSEOPro\Admin::add_menu', 100);
		add_action('init', '\SiteSEOPro\RedirectManager::setup_log_scheduled');
		add_action('siteseo_structured_data_types_enqueue', '\SiteSEOPro\StructuredData::enqueue_metabox');
		add_action('siteseo_display_structured_data_types', '\SiteSEOPro\StructuredData::display_metabox');
		add_action('admin_notices', '\SiteSEOPro\Admin::free_version_nag');
		
	}
	
	static function enqueue_script(){
		
		if(empty($_GET['page']) || strpos($_GET['page'], 'siteseo') === FALSE){
			return;
		}

		wp_enqueue_media();
		
		wp_enqueue_script('siteseo-pro-admin', SITESEO_PRO_URL.'assets/js/admin.js', ['jquery'], SITESEO_PRO_VERSION, true);

		wp_localize_script('siteseo-pro-admin', 'siteseo_pro', [
			'ajax_url' => admin_url('admin-ajax.php'),
			'nonce' => wp_create_nonce('siteseo_pro_nonce'),
		]);

		wp_enqueue_style('siteseo-pro-admin', SITESEO_PRO_URL . 'assets/css/admin.css');

		
	}
	
	static function add_menu(){
		$capability = 'manage_options';

		add_submenu_page('siteseo', __('PRO', 'siteseo-pro'), __('PRO', 'siteseo-pro'), $capability, 'siteseo-pro-page', '\SiteSEOPro\Settings\Pro::home');

		add_submenu_page('siteseo', __('License', 'siteseo-pro'), __('License', 'siteseo-pro'), $capability, 'siteseo-license', '\SiteSEOPro\Settings\License::template');
	}
	

	static function local_business_block(){

		wp_register_script('local-business-block-script',SITESEO_PRO_URL . 'assets/js/block.js', array('wp-blocks', 'wp-element', 'wp-editor'), filemtime(SITESEO_PRO_DIR . 'assets/js/block.js'));
		
		$data = \SiteSEOPro\Tags::local_business();
		
		// Localize
		wp_localize_script('local-business-block-script', 'siteseoProLocalBusiness', array(
			'previewData' => $data,
		));

		register_block_type('siteseo-pro/local-business', array(
			'editor_script' => 'local-business-block-script',
			'render_callback' => '\SiteSEOPro\Tags::load_data_local_business'
		));
	}
	
	// Nag when plugins dont have same version.
	static function free_version_nag(){

		if(!defined('SITESEO_VERSION')){
			return;
		}

		$dismissed_free = (int) get_option('siteseo_version_free_nag');
		$dismissed_pro = (int) get_option('siteseo_version_pro_nag');

		// Checking if time has passed since the dismiss.
		if(!empty($dismissed_free) && time() < $dismissed_pro && !empty($dismissed_pro) && time() < $dismissed_pro){
			return;
		}

		$showing_error = false;
		if(version_compare(SITESEO_VERSION, SITESEO_PRO_VERSION) > 0 && (empty($dismissed_pro) || time() > $dismissed_pro)){
			$showing_error = true;

			echo '<div class="notice notice-warning is-dismissible" id="siteseo-pro-version-notice" onclick="siteseo_pro_dismiss_notice(event)" data-type="pro">
			<p style="font-size:16px;">'.esc_html__('You are using an older version of SiteSEO Pro. We recommend updating to the latest version to ensure seamless and uninterrupted use of the application.', 'siteseo-pro').'</p>
		</div>';
		}elseif(version_compare(SITESEO_VERSION, SITESEO_PRO_VERSION) < 0 && (empty($dismissed_free) || time() > $dismissed_free)){
			$showing_error = true;

			echo '<div class="notice notice-warning is-dismissible" id="siteseo-pro-version-notice" onclick="siteseo_pro_dismiss_notice(event)" data-type="free">
			<p style="font-size:16px;">'.esc_html__('You are using an older version of SiteSEO. We recommend updating to the latest free version to ensure smooth and uninterrupted use of the application.', 'siteseo-pro').'</p>
		</div>';
		}
		
		if(!empty($showing_error)){
			wp_register_script('siteseo-pro-version-notice', '', ['jquery'], SITESEO_PRO_VERSION, true );
			wp_enqueue_script('siteseo-pro-version-notice');
			wp_add_inline_script('siteseo-pro-version-notice', '
		function siteseo_pro_dismiss_notice(e){
			e.preventDefault();
			let target = jQuery(e.target);

			if(!target.hasClass("notice-dismiss")){
				return;
			}

			let jEle = target.closest("#siteseo-pro-version-notice"),
			type = jEle.data("type");

			jEle.slideUp();

			jQuery.post("'.admin_url('admin-ajax.php').'", {
				security : "'.wp_create_nonce('siteseo_version_notice').'",
				action: "siteseo_pro_version_notice",
				type: type
			}, function(res){
				if(!res["success"]){
					alert(res["data"]);
				}
			}).fail(function(data){
				alert("There seems to be some issue dismissing this alert");
			});
		}');
		}
	}
}
