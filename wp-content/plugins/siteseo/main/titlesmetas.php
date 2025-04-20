<?php
/*
* SITESEO
* https://siteseo.io
* (c) SiteSEO Team
*/

namespace SiteSEO;

if(!defined('ABSPATH')){
	die('HACKING ATTEMPT!');
}

class TitlesMetas{
	
	static function advanced_metas($robots){
		global $siteseo, $post;
		
		$disable_noindex = !empty($siteseo->advanced_settings['appearance_adminbar_noindex']) ?? '';

		if(empty($siteseo->setting_enabled['toggle-titles']) || !empty($disable_noindex)){
			return $robots;
		}
		
		$settings = $siteseo->titles_settings;
		
		//all  post types and taxonomies
		$post_types = siteseo_post_types();
		$taxonomies = get_taxonomies(array('public' => true), 'objects');
    
		$post_id = isset($post) && is_object($post) ? $post->ID : 0;
		
		$index_extras = [
			'max-snippet' => '-1',
			'max-image-preview' => 'large',
			'max-video-preview' => '-1'
		];
		
		
		$robots = [
			'noindex' => !empty($settings['titles_noindex']),
			'nofollow' => !empty($settings['titles_nofollow']),
			'nosnippet' => !empty($settings['titles_nosnippet']),
			'noarchive' => !empty($settings['titles_noarchive']),
			'noimageindex' => !empty($settings['titles_noimageindex'])
		];
    
		// taxonomies
		$term_id = 0;
		if(is_tax() || is_category() || is_tag()){
			$queried_object = get_queried_object();
			$term_id = $queried_object->term_id ?? 0;
			
			if($term_id) {
				$robots['noindex'] = !empty(get_term_meta($term_id, '_siteseo_robots_index', true)) || $robots['noindex'];
				$robots['nofollow'] = !empty(get_term_meta($term_id, '_siteseo_robots_follow', true)) || $robots['nofollow'];
				$robots['nosnippet'] = !empty(get_term_meta($term_id, '_siteseo_robots_snippet', true)) || $robots['nosnippet'];
				$robots['noarchive'] = !empty(get_term_meta($term_id, '_siteseo_robots_archive', true)) || $robots['noarchive'];
				$robots['noimageindex'] = !empty(get_term_meta($term_id, '_siteseo_robots_imageindex', true)) || $robots['noimageindex'];
			}

			if(!$robots['noindex']){
				$robots['index'] = true;
				$robots = array_merge($robots, $index_extras);
			}

			if(!$robots['nofollow']){
				$robots['follow'] = true;
			}

			return array_filter($robots);
		}
		
		// single post types
		foreach($post_types as $post_type){
			if(is_singular($post_type->name)){
				
				if($post_id) {
					$robots['noindex'] = !empty(get_post_meta($post_id, '_siteseo_robots_index', true)) || $robots['noindex'];
					$robots['nofollow'] = !empty(get_post_meta($post_id, '_siteseo_robots_follow', true)) || $robots['nofollow'];
					$robots['nosnippet'] = !empty(get_post_meta($post_id, '_siteseo_robots_snippet', true)) || $robots['nosnippet'];
					$robots['noarchive'] = !empty(get_post_meta($post_id, '_siteseo_robots_archive', true)) || $robots['noarchive'];
					$robots['noimageindex'] = !empty(get_post_meta($post_id, '_siteseo_robots_imageindex', true)) || $robots['noimageindex'];
				}

				if(!$robots['noindex']){
					$robots['index'] = true;
					$robots = array_merge($robots, $index_extras);
				}

				if(!$robots['nofollow']){
					$robots['follow'] = true;
				}

				return array_filter($robots);
			}
		}
		
		//archive pages
		if(is_author()){
			$robots['noindex'] = !empty($settings['titles_archives_author_noindex']);
			
			if(!$robots['noindex']){
				$robots['index'] = true;
				$robots = array_merge($robots, $index_extras);
			}
		}
		
		if(is_date()){
			$robots['noindex'] = !empty($settings['titles_archives_date_noindex']);
			
			if(!$robots['noindex']){
				$robots['index'] = true;
				$robots = array_merge($robots, $index_extras);
			}
		}
		
		if(is_search()){
			$robots['noindex'] = !empty($settings['titles_archives_search_title_noindex']);
			
			if(!$robots['noindex']){
				$robots['index'] = true;
				$robots = array_merge($robots, $index_extras);
			}
		}
    
		// front page
		if(is_front_page()){

			$robots = [
				'index' => true,
				'follow' => true
			];

			if(!empty($settings['titles_noindex'])){
				$robots['noindex'] = true;
				unset($robots['index']);
			}

			if(!empty($settings['titles_nofollow'])){
				$robots['nofollow'] = true;
				unset($robots['follow']);
			}

			if(!empty($settings['titles_nosnippet'])){
				$robots['nosnippet'] = true;
			}

			if(!empty($settings['titles_noarchive'])){
				$robots['noarchive'] = true;
			}

			if(!empty($settings['titles_noimageindex'])){
				$robots['noimageindex'] = true;
			}

			$robots = array_merge($robots, $index_extras);
		}
    
		return array_filter($robots);
    }
	
	static function add_nositelinkssearchbox(){
		global $siteseo;
		
		if(empty($siteseo->setting_enabled['toggle-titles'])){
			return;
		}
	
		if(!empty($siteseo->titles_settings['titles_nositelinkssearchbox'])){
			echo '<meta name="google" content="nositelinkssearchbox" >';
		}
		
	}
	
	static function add_canonical_url(){
		
		$post_types = siteseo_post_types();
		
		foreach($post_types as $post_type){
			if(is_singular($post_type->name)){
				$post_id = get_the_ID();
				$canonical_meta = get_post_meta($post_id, '_siteseo_robots_canonical', true);
				$canonical = !empty($canonical_meta) ? $canonical_meta : urldecode(get_permalink($post_id));
				
				if($canonical){
					echo '<link rel="canonical" href="'.esc_url($canonical).'" />' . "\n";
				}
			}
		}

		//taxonomies
		$taxonomies = get_taxonomies(array('public' => true), 'objects');
		
		if(is_tag() || is_category() || is_tax()){
			$term = get_queried_object();
			if($term && isset($term->term_id, $term->taxonomy)){
				$term_id = $term->term_id;
				$taxonomy_name = $term->taxonomy;
				
				$canonical_meta = get_term_meta($term_id, '_siteseo_robots_canonical', true);
				$canonical = !empty($canonical_meta) ? $canonical_meta : urldecode(get_term_link($term_id, $taxonomy_name));
				
				if($canonical){
					echo '<link rel="canonical" href="'.esc_url($canonical).'" />' . "\n";
				}
			}
		}
		
		if(is_front_page() && is_home()){
			$canonical = trailingslashit(home_url());
			echo '<link rel="canonical" href="'.esc_url($canonical).'" />' . "\n";				
		}
	}
	
	static function replace_variables($content, $in_editor = false){
		global $post, $siteseo, $wp_query, $term;
		
		// Site info
		$site_title = get_bloginfo('name');
		$site_tagline = get_bloginfo('description');
		$site_sep = $siteseo->titles_settings['titles_sep'];

		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$page = get_query_var('page') ? get_query_var('page') : 1;
		
		// Date info
		$current_time = current_time('timestamp');
		$archive_date = get_the_date('d');
		$archive_month = get_the_date('M');
		$archive_month_name = get_the_date('F');
		$archive_year = get_the_date('Y');
		
		// Author
		$author_id = isset($post->post_author) ? $post->post_author : get_current_user_id();
		$author_first_name = get_the_author_meta('first_name', $author_id);
		$author_last_name = get_the_author_meta('last_name', $author_id);
		$author_website = get_the_author_meta('url', $author_id);
		$author_nickname = get_the_author_meta('nickname', $author_id);
		$author_bio = get_the_author_meta('description', $author_id);
		
		// WooCommerce
		$wc_variables = [];
		if(function_exists('wc_get_product') && is_singular('product')){
			$product = wc_get_product($post->ID);
			if($product){
				$wc_variables = array(
					'%%wc_single_cat%%' => wp_strip_all_tags(wc_get_product_category_list($post->ID)),
					'%%wc_single_tag%%' => wp_strip_all_tags(wc_get_product_tag_list($post->ID)),
					'%%wc_single_short_desc%%' => $product->get_short_description(),
					'%%wc_single_price%%' => $product->get_price(),
					'%%wc_single_price_exe_tax%%' => wc_get_price_excluding_tax($product),
					'%%wc_sku%%' => $product->get_sku()
				);
			}
		}

		$replacements = array(
			'%%sep%%' => $site_sep,
			'%%sitetitle%%' => $site_title,
			'%%tagline%%' => $site_tagline,
			'%%post_title%%' => (is_singular() || $in_editor === TRUE) ? get_the_title() : '',
			'%%post_excerpt%%' => (is_singular() || $in_editor === TRUE) ? get_the_excerpt() : '',
			'%%post_content%%' => (is_singular() || $in_editor === TRUE) ? wp_strip_all_tags(get_the_content()) : '',
			'%%post_thumbnail_url%%' => get_the_post_thumbnail_url($post),
			'%%post_url%%' => urldecode(get_permalink()),
			'%%post_date%%' => get_the_date(),
			'%%post_modified_date%%' => get_the_modified_date(),
			'%%post_author%%' => get_the_author(),
			'%%post_category%%' => wp_strip_all_tags(get_the_category_list(', ')),
			'%%post_tag%%' => wp_strip_all_tags(get_the_tag_list('', ', ', '')),
			'%%_category_title%%' => single_cat_title('', false),
			'%%_category_description%%' => category_description(),
			'%%tag_title%%' => single_tag_title('', false),
			'%%tag_description%%' => tag_description(),
			'%%term_title%%' => single_term_title('', false),
			'%%term_description%%' => term_description(),
			'%%search_keywords%%' => get_search_query(),
			'%%current_pagination%%' => $paged,
			'%%page%%' => $page,
			'%%cpt_plural%%' => post_type_archive_title('', false),
			'%%archive_title%%' => get_the_archive_title(),
			'%%archive_date%%' => $archive_date,
			'%%archive_date_day%%' => $archive_date,
			'%%archive_date_month%%' => $archive_month,
			'%%archive_date_month_name%%' => $archive_month_name,
			'%%archive_date_year%%' => $archive_year,
			'%%currentday%%' => date_i18n('j', $current_time),
			'%%currentmonth%%' => date_i18n('F', $current_time),
			'%%currentmonth_short%%' => date_i18n('M', $current_time),
			'%%currentmonth_num%%' => date_i18n('n', $current_time),
			'%%currentyear%%' => date_i18n('Y', $current_time),
			'%%currentdate%%' => date_i18n(get_option('date_format'), $current_time),
			'%%currenttime%%' => date_i18n(get_option('time_format'), $current_time),
			'%%author_first_name%%' => $author_first_name,
			'%%author_last_name%%' => $author_last_name,
			'%%author_website%%' => $author_website,
			'%%author_nickname%%' => $author_nickname,
			'%%author_bio%%' => $author_bio,
		);
		
		//WooCommerces
		if(!empty($wc_variables)){
			$replacements = array_merge($replacements, $wc_variables);
		}

		if(preg_match_all('/%%_cf_(.*?)%%/', $content, $matches)){
			foreach ($matches[1] as $custom_field) {
				$meta_value = get_post_meta($post->ID, $custom_field, true);
				$replacements["%%_cf_{$custom_field}%%"] = $meta_value;
			}
		}

		if(preg_match_all('/%%_ct_(.*?)%%/', $content, $matches)){
			foreach($matches[1] as $taxonomy){
				$terms = get_the_terms($post->ID, $taxonomy);
				$term_names = is_array($terms) ? wp_list_pluck($terms, 'name') : [];
				$replacements["%%_ct_{$taxonomy}%%"] = implode(', ', $term_names);
			}
		}

		if(preg_match_all('/%%_ucf_(.*?)%%/', $content, $matches)){
			foreach($matches[1] as $user_meta){
				$meta_value = get_user_meta($author_id, $user_meta, true);
				$replacements["%%_ucf_{$user_meta}%%"] = $meta_value;
			}
		}

		$target_keywords = isset($siteseo->keywords_settings['tempory_set']) ? $siteseo->keywords_settings['tempory_set'] : '';
		$replacements['%%target_keyword%%'] = $target_keywords;

		$replacements = array_map(function($value){
			if(is_array($value) || is_object($value)){
				return '';
			}

			return is_null($value) ? '' : wp_strip_all_tags($value);
		}, $replacements);

		return str_replace(
			array_keys($replacements),
			array_values($replacements),
			$content
		);
	}
	
	static function modify_site_title($title, $sep = ''){
		global $siteseo, $post;

		// Check enabled
		if(empty($siteseo->setting_enabled['toggle-titles'])){
			return $title;
		}

		$settings = $siteseo->titles_settings;

		// post types and taxonomies
		$post_types = siteseo_post_types();
		$taxonomies = get_taxonomies(array('public' => true), 'objects');
		
		// Check set by meta
		$post_id = isset($post) && is_object($post) ? $post->ID : '';
		$post_meta_title = !empty(get_post_meta($post_id, '_siteseo_titles_title', true)) ? get_post_meta($post_id, '_siteseo_titles_title', true) : '';
		
		// front page
		if(is_front_page() && !empty($settings['titles_home_site_title'])){
			$new_title = esc_attr(self::replace_variables($settings['titles_home_site_title']));

			if(!empty($sep)){
				$new_title .= " $sep " . get_bloginfo('name');
			}

			return $new_title;
		}

		// single post types
		foreach($post_types as $post_type){
			if(is_singular($post_type->name)){
				$default_title = isset($settings['titles_single_titles'][$post_type->name]['title']) ? $settings['titles_single_titles'][$post_type->name]['title'] : '';
				$new_title = !empty($post_meta_title) ? $post_meta_title : $default_title;

				if(!empty($new_title)){
					$new_title = esc_attr(self::replace_variables($new_title));

					if(!empty($sep)){
						$new_title .= " $sep " . get_bloginfo('name');
					}

					return $new_title;
				}
			}
		}

		//taxonomies
		foreach($taxonomies as $taxonomy){
			if(is_category()){
				$term = get_queried_object();
				$term_id = $term->term_id;
				$term_meta_title = get_term_meta($term_id, '_siteseo_titles_title', true);
				$default_title = isset($settings['titles_tax_titles']['category']['title']) ? $settings['titles_tax_titles']['category']['title'] : '';
				$disabled = !empty($settings['titles_tax_titles']['category']['disabled']);
				$new_title = !empty($term_meta_title) ? $term_meta_title : $default_title;

				if(!empty($new_title) && !$disabled){
					$new_title = esc_attr(self::replace_variables($new_title));
					
					if(!empty($sep)){
						$new_title .= " $sep " . get_bloginfo('name');
					}

					return $new_title;
				}
			} elseif(is_tag()) {
				$term = get_queried_object();
				$term_id = $term->term_id;
				$term_meta_title = get_term_meta($term_id, '_siteseo_titles_title', true);
				$default_title = isset($settings['titles_tax_titles']['post_tag']['title']) ? $settings['titles_tax_titles']['post_tag']['title'] : '';
				$disabled = !empty($settings['titles_tax_titles']['post_tag']['disabled']);

				$new_title = !empty($term_meta_title) ? $term_meta_title : $default_title;

				if(!empty($new_title) && !$disabled){
					$new_title = esc_attr(self::replace_variables($new_title));

					
					if(!empty($sep)){
						$new_title .= " $sep " . get_bloginfo('name');
					}

					return $new_title;
				}
			} elseif(is_tax($taxonomy->name)) {
				$term = get_queried_object();
				$term_id = $term->term_id;
				$term_meta_title = get_term_meta($term_id, '_siteseo_titles_title', true);
				$default_title = isset($settings['titles_tax_titles'][$taxonomy->name]['title']) ? $settings['titles_tax_titles'][$taxonomy->name]['title'] : '';
				$disabled = !empty($settings['titles_tax_titles'][$taxonomy->name]['disabled']);

				$new_title = !empty($term_meta_title) ? $term_meta_title : $default_title;

				if(!empty($new_title) && !$disabled){
					$new_title = esc_attr(self::replace_variables($new_title));

					if(!empty($sep)){
						$new_title .= " $sep " . get_bloginfo('name');
					}

					return $new_title;
				}
			}
		}
		
		// author archive
		if(is_author() && !empty($settings['titles_archives_author_title']) && empty($settings['titles_archives_author_disable'])) {
			$new_title = esc_attr(self::replace_variables($settings['titles_archives_author_title']));

			if(!empty($sep)){
				$new_title .= " $sep " . get_bloginfo('name');
			}

			return $new_title;
		}

		//Date archive
		if(is_date() && !empty($settings['titles_archives_date_title']) && empty($settings['titles_archives_date_disable'])){
			$new_title = esc_attr(self::replace_variables($settings['titles_archives_date_title']));

			if(!empty($sep)){
				$new_title .= " $sep " . get_bloginfo('name');
			}

			return $new_title;
		}
		
		// Search archive
		if(is_search() && !empty($settings['titles_archives_search_title'])){

			$new_title = esc_attr(self::replace_variables($settings['titles_archives_search_title']));

			if(!empty($sep)){
				$new_title .= " $sep " . get_bloginfo('name');
			}

			return $new_title;
		}
		
		// 404 archive
		if(is_404() && !empty($settings['titles_archives_404_title'])){

			$new_title = esc_attr(self::replace_variables($settings['titles_archives_404_title']));

			if(!empty($sep)){
				$new_title .= " $sep " . get_bloginfo('name');
			}

			return $new_title;
		}

		return $title;
    }
	
	static function add_meta_description(){
		global $siteseo, $post;

		if(empty($siteseo->setting_enabled['toggle-titles'])){
			return;
		}

		$settings = $siteseo->titles_settings;

		// Get all registered post types
		$post_types = siteseo_post_types();
		$taxonomies = get_taxonomies(array('public' => true), 'objects');

		$post_id = isset($post) && is_object($post) ? $post->ID : '';

		//front page
		if(is_front_page() && is_home()){
			if(!empty($settings['titles_home_site_desc'])){
				echo '<meta name="description" content="' . esc_attr(self::replace_variables($settings['titles_home_site_desc'])) . '">';
			} else{
				$description = get_bloginfo('description');
				if(!empty($description)){
					echo '<meta name="description" content="' . esc_attr($description) . '">';
				}
			}
		}

		// single post types
		foreach($post_types as $post_type){
			if(is_singular($post_type->name)){
				$meta_desc = get_post_meta($post_id, '_siteseo_titles_desc', true);
				$default_desc = isset($settings['titles_single_titles'][$post_type->name]['description']) ? $settings['titles_single_titles'][$post_type->name]['description'] : '';

				$description = !empty($meta_desc) ? $meta_desc : $default_desc;

				if(!empty($description)){
					echo '<meta name="description" content="' . esc_attr(self::replace_variables($description)) . '">';
				}
			}
		}
		
		if(is_category() || is_tag() || is_tax()){
			$term = get_queried_object();
			if($term){
				$term_id = $term->term_id;
				$term_meta_desc = get_term_meta($term_id, '_siteseo_titles_desc', true);
				$default_desc = '';
				$taxonomy_name = '';

				if(is_category()){
					$default_desc = isset($settings['titles_tax_titles']['category']['description']) ? $settings['titles_tax_titles']['category']['description'] : '';
					$taxonomy_name = 'category';
				} elseif(is_tag()){
					$default_desc = isset($settings['titles_tax_titles']['post_tag']['description']) ? $settings['titles_tax_titles']['post_tag']['description'] : '';
					$taxonomy_name = 'post_tag';
				} else{
					$taxonomy_name = $term->taxonomy;
					$default_desc = isset($settings['titles_tax_titles'][$taxonomy_name]['description']) ? $settings['titles_tax_titles'][$taxonomy_name]['description'] : '';
				}

				$disabled = isset($settings['titles_tax_titles'][$taxonomy_name]['disabled']);

				$description = !empty($term_meta_desc) ? $term_meta_desc : $default_desc;

				if(!empty($disabled)){
					echo '<meta name="description" content="' . esc_attr(self::replace_variables($description)) . '">';
				}
			}
		}
		
		// Author archive
		if(is_author() && !empty($settings['titles_archives_author_desc']) && empty($settings['titles_archives_author_disable'])){
			echo '<meta name="description" content="'.esc_attr(self::replace_variables($settings['titles_archives_author_desc'])).'" >';
		}
		
		// Date archive
		if(is_date() && !empty($settings['titles_archives_date_desc']) && empty($settings['titles_archives_date_disable'])){
			echo '<meta name="description" content="'.esc_attr(self::replace_variables($settings['titles_archives_date_desc'])).'" >';
		}
		
		// Search archive
		if(is_search() && !empty($settings['titles_archives_search_desc'])){
			echo '<meta name="description" content="'.esc_attr(self::replace_variables($settings['titles_archives_search_desc'])).'" >';
		}
		
		// 404 archives
		if(is_404() && !empty($settings['titles_archives_404_desc'])){
			echo '<meta name="description" content="'.esc_attr(self::replace_variables($settings['titles_archives_404_desc'])).'" >';
		}
    }
	
	static function add_rel_link_pages(){
		global $siteseo, $paged;

		if(empty($siteseo->setting_enabled['toggle-titles'])){
			return;
		}

		if(!empty($siteseo->titles_settings['titles_paged_rel'])){

			if(get_previous_posts_link()){

				echo '<link rel="prev" href="'.esc_url(get_pagenum_link($paged - 1)).'" />';
			}
			if(get_next_posts_link()){

				echo '<link rel="next" href="'.esc_url(get_pagenum_link($paged + 1)).'" />';
			}
		}
	}

	static function date_time_publish(){
		global $siteseo;
		
		if(empty($siteseo->setting_enabled['toggle-titles'])){
			return;
		}
		
		if(!is_singular()){
			return;
		}
		
		
		$current_post_type = get_post_type();
		
		$type_settings = isset($siteseo->titles_settings['titles_single_titles'][$current_post_type]) ? $siteseo->titles_settings['titles_single_titles'][$current_post_type] : '';
		
		// post type
		if(!empty($type_settings['date'])){
			$published_time = get_the_date('c');
			$modified_time = get_the_modified_date('c');
			echo '<meta property="article:published_time" content="'. esc_attr($published_time) .'">';
			echo '<meta property="article:modified_time" content="'. esc_attr($modified_time) .'">';
		}
		
		// thumbnails
		if(!empty($type_settings['thumb_gcs'])){
			if(get_the_post_thumbnail_url(get_the_ID())){
				echo '<meta name="thumbnail" content="'.esc_url(get_the_post_thumbnail_url(get_the_ID())).'">';
			}
		}

	}
}
