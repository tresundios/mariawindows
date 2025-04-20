<?php
/*
* SITESEO
* https://siteseo.io
* (c) SITSEO Team
*/

namespace SiteSEOPro;

if(!defined('ABSPATH')){
	die('Hacking Attempt !');
}

class GoogleNews{

	static function google_news_sitemap(){
		global $siteseo;
		$settings = $siteseo->pro;
		
		if(empty($settings['toggle_state_google_news']) || empty($settings['google_news'])){
			return;
		}
		
		$publication_name = isset($siteseo->pro['publication_name']) ? $siteseo->pro['publication_name'] : get_bloginfo('name');
		$selected_post_types = isset($siteseo->pro['post_types']) ? $siteseo->pro['post_types'] : [];
		
		header('Content-Type: application/xml; charset=utf-8');
		
		if(get_option('permalink_structure')){
			$xsl_url = home_url('/sitemaps.xsl');
		} else{
			$xsl_url = home_url('/?sitemaps-stylesheet=sitemap');
		}
	
	echo'<?xml version="1.0" encoding="UTF-8"?>
<?xml-stylesheet type="text/xsl" href="' . esc_url($xsl_url) . '" ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">';
	
		if(!empty($selected_post_types)){
			//date
			$date = new \DateTime();
			$last_48_hours = $date->modify('-48 hours')->format('Y-m-d\TH:i:sP');
			$args = [
				'post_type' => $selected_post_types,
				'post_status' => 'publish',
				'posts_per_page' => 1000,
				'orderby' => 'modified',
				'order' => 'DESC',
				'date_query' => [
					'after' => $last_48_hours,
				],
				'meta_query' => [
					[
						'key' => '_siteseo_robots_index',
						'compare' => 'NOT EXISTS'
					]
				]
			];
		
			$posts = get_posts($args);
		
			foreach($posts as $post){
				$post_date = get_the_date('Y-m-d\TH:i:sP', $post->ID);
				$title = get_the_title($post->ID);
			
				echo "\t".'<url>
				<loc>'.esc_url(urldecode(get_permalink($post->ID))).'</loc>
				<news:news>
					<news:publication>
						<news:name>'.esc_html($publication_name).'</news:name>
						<news:language>' . esc_html(substr(get_locale(), 0, 2)) . '</news:language>
					</news:publication>
					<news:publication_date>'.esc_html($post_date).'</news:publication_date>
					<news:title>'.esc_html($title).'</news:title>';
				
				echo'</news:news>
			</url>';
			}
		}
		echo'</urlset>';
		exit;

	}
}