<?php
load_plugin_textdomain('kboard-worldmap-franchise', false, dirname(plugin_basename(__FILE__)) . '/languages');

$worldmap_franchise_skin_dir_name = basename(dirname(__FILE__));

if(!function_exists('kboard_worldmap_franchise_branch_list')){
	function kboard_worldmap_franchise_branch_list(){
		$branch_list = array(
			'seoul'     => array('name' => __('Seoul', 'kboard-worldmap-franchise'), 'latlng'=>'37.566535, 126.9779692'),
			'busan'     => array('name' => __('Busan', 'kboard-worldmap-franchise'), 'latlng'=>'35.1795543, 129.0756416'),
			'daegu'     => array('name' => __('Daegu', 'kboard-worldmap-franchise'), 'latlng'=>'35.8714354, 128.601445'),
			'incheon'   => array('name' => __('Incheon', 'kboard-worldmap-franchise'), 'latlng'=>'37.4562557, 126.7052062'),
			'gwangju'   => array('name' => __('Gwangju', 'kboard-worldmap-franchise'), 'latlng'=>'35.1595454, 126.8526012'),
			'daejeon'   => array('name' => __('Daejeon', 'kboard-worldmap-franchise'), 'latlng'=>'36.3504119, 127.3845475'),
			'ulsan'     => array('name' => __('Ulsan', 'kboard-worldmap-franchise'), 'latlng'=>'35.5383773, 129.3113596'),
			'sejong'    => array('name' => __('Sejong', 'kboard-worldmap-franchise'), 'latlng'=>'36.4800984, 127.2890354'),
			'gyeonggi'  => array('name' => __('Gyeonggi', 'kboard-worldmap-franchise'), 'latlng'=>'37.4138, 127.5183'),
			'gyeongnam' => array('name' => __('Gyeongnam', 'kboard-worldmap-franchise'), 'latlng'=>'35.4606, 128.2132'),
			'gyeongbuk' => array('name' => __('Gyeongbuk', 'kboard-worldmap-franchise'), 'latlng'=>'36.4919, 128.8889'),
			'jeollanam' => array('name' => __('Jeollanam', 'kboard-worldmap-franchise'), 'latlng'=>'34.8679, 126.991'),
			'jeollabuk' => array('name' => __('Jeollabuk', 'kboard-worldmap-franchise'), 'latlng'=>'35.7175, 127.153'),
			'chungnam'  => array('name' => __('Chungnam', 'kboard-worldmap-franchise'), 'latlng'=>'36.5184, 126.8'),
			'chungbuk'  => array('name' => __('Chungbuk', 'kboard-worldmap-franchise'), 'latlng'=>'36.8, 127.7'),
			'gangwon'   => array('name' => __('Gangwon', 'kboard-worldmap-franchise'), 'latlng'=>'37.8228, 128.1555'),
			'jeju'      => array('name' => __('Jeju', 'kboard-worldmap-franchise'), 'latlng'=>'33.4890113, 126.4983023')
		);
		return apply_filters('kboard_worldmap_franchise_branch_list', $branch_list);
	}
}

if(!function_exists('kboard_worldmap_franchise_branch')){
	function kboard_worldmap_franchise_branch($name){
		$branch_list = kboard_worldmap_franchise_branch_list();
		$branch = isset($branch_list[$name]['name']) ? $branch_list[$name]['name'] : '';
		return $branch;
	}
}

if(!function_exists('kboard_worldmap_franchise_geocode')){
	add_action('init', 'kboard_worldmap_franchise_geocode');
	function kboard_worldmap_franchise_geocode(){
		$board_id = isset($_REQUEST['board_id']) ? intval($_REQUEST['board_id']) : '';
		$action = isset($_REQUEST['action']) ? sanitize_text_field($_REQUEST['action']) : '';
		$address = isset($_REQUEST['address']) ? sanitize_text_field($_REQUEST['address']) : '';
		
		if($board_id && $action == 'kboard_worldmap_franchise_geocode' && $address){
			check_ajax_referer('kboard_worldmap_franchise_geocode', 'security');
			
			$board = new KBoard($board_id);
			$google_geocoding_api_key = kboard_worldmap_franchise_google_geocoding_api_key($board);
			
			$args = array();
			$args['method'] = 'GET';
			$response = wp_remote_request("https://maps.googleapis.com/maps/api/geocode/json?key={$google_geocoding_api_key}&address={$address}&language=".get_locale(), $args);
			
			if(!is_wp_error($response) && $response['body']){
				$data = json_decode(wp_remote_retrieve_body($response));
				if($data->results){
					wp_send_json(array('result'=>'success', 'data'=>$data->results));
				}
			}
			
			wp_send_json(array('result'=>'error'));
		}
	}
}

if(!function_exists('kboard_worldmap_franchise_geocode_with_keyword')){
	function kboard_worldmap_franchise_geocode_with_keyword($keyword, $board){
		$google_geocoding_api_key = kboard_worldmap_franchise_google_geocoding_api_key($board);
		
		$address = sanitize_text_field($keyword);
		
		$geocode = new stdClass();
		$geocode->lat = '';
		$geocode->lng = '';
		
		if($google_geocoding_api_key && $address && $board){
			
			$args = array();
			$args['method'] = 'GET';
			$response = wp_remote_request("https://maps.googleapis.com/maps/api/geocode/json?key={$google_geocoding_api_key}&address={$address}&language=".get_locale(), $args);
			
			if(!is_wp_error($response) && $response['body']){
				$data = json_decode(wp_remote_retrieve_body($response));
				if($data->results){
					$geocode->lat = $data->results[0]->geometry->location->lat;
					$geocode->lng = $data->results[0]->geometry->location->lng;
				}
			}
		}
		
		return $geocode;
	}
}

if(!function_exists('kboard_worldmap_franchise_get_gps_list')){
	add_action('init', 'kboard_worldmap_franchise_get_gps_list');
	function kboard_worldmap_franchise_get_gps_list(){
		global $wpdb;
		
		$action = isset($_GET['action']) ? sanitize_text_field($_REQUEST['action']) : '';
		$board_id = isset($_GET['board_id']) ? intval($_GET['board_id']) : '';
		$lat = isset($_GET['lat']) ? floatval($_GET['lat']) : '';
		$lng = isset($_GET['lng']) ? floatval($_GET['lng']) : '';
		$south_east_lat = isset($_GET['south_east_lat']) ? floatval($_GET['south_east_lat']) : '';
		$south_east_lng = isset($_GET['south_east_lng']) ? floatval($_GET['south_east_lng']) : '';
		
		if($board_id && $lat && $lng && $action == 'kboard_worldmap_franchise_get_gps_list'){
			$board = new KBoard($board_id);
			
			$lat = esc_sql($lat);
			$lng = esc_sql($lng);
			
			$distance = kboard_worldmap_franchise_get_distance($lat, $lng, $south_east_lat, $south_east_lng);
			$distance = apply_filters('kboard_worldmap_franchise_distance', $distance, $board_id, $board); // 킬로미터
			$distance = floatval($distance);
			
			$select = "`content`.`uid`, `content`.`title`, `option`.`option_value` AS lat, `option2`.`option_value` AS lng, (6371*acos(cos(radians({$lat}))*cos(radians(`option`.`option_value`))*cos(radians(`option2`.`option_value`)-radians({$lng}))+sin(radians({$lat}))*sin(radians(`option`.`option_value`)))) AS `distance`";
			
			$from[] = "`{$wpdb->prefix}kboard_board_content` AS `content`";
			$from[] = "LEFT JOIN `{$wpdb->prefix}kboard_board_option` AS `option` ON `content`.`uid`=`option`.`content_uid`";
			$from[] = "LEFT JOIN `{$wpdb->prefix}kboard_board_option` AS `option2` ON `content`.`uid`=`option2`.`content_uid`";
			
			$where[] = "`board_id`='{$board_id}'";
			$where[] = "`option`.`option_key`='map_location_lat'";
			$where[] = " `option2`.`option_key`='map_location_lng'";
			$where[] = " (6371*acos(cos(radians({$lat}))*cos(radians(`option`.`option_value`))*cos(radians(`option2`.`option_value`)-radians({$lng}))+sin(radians({$lat}))*sin(radians(`option`.`option_value`)))) < '{$distance}'";
			$where[] = " (`content`.`status`='' OR `content`.`status` IS NULL OR `content`.`status`='pending_approval')";
			
			if(isset($_GET['category1']) && $_GET['category1']){
				$category1 = sanitize_text_field($_GET['category1']);
				$category1 = esc_sql($category1);
				$where[] = "`content`.`category1` = '{$category1}'";
			}
			
			if(isset($_GET['category2']) && $_GET['category2']){
				$category2 = sanitize_text_field($_GET['category2']);
				$category2 = esc_sql($category2);
				$where[] = "`content`.`category2` = '{$category2}'";
			}
			
			$from = implode(' ', $from);
			$where = implode(' AND ', $where);
			$orderby = "`distance` ASC";
			
			$results = $wpdb->get_results("SELECT {$select} FROM {$from} WHERE {$where} ORDER BY {$orderby}");
			
			$additional_list = array();
			foreach($results as $row){
				$content = new KBContent();
				$content->initWithUID($row->uid);
				
				$url = new KBUrl(wp_get_referer());
				
				$additional_list[$row->uid]['title'] = $content->title;
				$additional_list[$row->uid]['lat'] = $content->option->map_location_lat;
				$additional_list[$row->uid]['lng'] = $content->option->map_location_lng;
				$additional_list[$row->uid]['urls'] = $board->meta->view_iframe ? $url->set('uid', $content->uid)->set('mod', 'document')->set('kboard_id', $content->board_id)->set('view_iframe', '1')->toString() :  $url->getDocumentURLWithUID($content->uid);
			}
			
			wp_send_json($additional_list);
		}
	}
}

if(!function_exists('kboard_worldmap_franchise_get_distance')){
	function kboard_worldmap_franchise_get_distance($map_center_lat, $map_center_lng, $south_east_lat, $south_east_lng){
		$theta = $map_center_lng - $south_east_lng;
		$distance = sin(deg2rad($map_center_lat)) * sin(deg2rad($south_east_lat)) +  cos(deg2rad($map_center_lat)) * cos(deg2rad($south_east_lat)) * cos(deg2rad($theta));
		$distance = acos($distance);
		$distance = rad2deg($distance);
		$killometer = $distance * 60 * 1.1515 * 1.609344;
		return $killometer;
	}
}

if(!function_exists('kboard_worldmap_franchise_homepage')){
	function kboard_worldmap_franchise_homepage($link){
		if(strpos($link, 'http://') !== false || strpos($link, 'https://') !== false){
			return $link;
		}
		return "http://{$link}";
	}
}

if(!function_exists('kboard_worldmap_franchise_google_maps_api_key')){
	function kboard_worldmap_franchise_google_maps_api_key($board){
		$google_maps_api_key = $board->meta->google_maps_api_key ? $board->meta->google_maps_api_key : get_option('kboard_google_api_key');
		return apply_filters('kboard_worldmap_franchise_google_maps_api_key', $google_maps_api_key);
	}
}

if(!function_exists('kboard_worldmap_franchise_google_geocoding_api_key')){
	function kboard_worldmap_franchise_google_geocoding_api_key($board){
		$google_geocoding_api_key = $board->meta->google_geocoding_api_key;
		return apply_filters('kboard_worldmap_franchise_google_geocoding_api_key', $google_geocoding_api_key);
	}
}

if(!function_exists('kboard_worldmap_franchise_default_location')){
	function kboard_worldmap_franchise_default_location($board=''){
		$branch_list = kboard_worldmap_franchise_branch_list();
		$default_location = 'seoul';
		$default_location = (kboard_category1() && isset($branch_list[kboard_category1()])) ? $branch_list[kboard_category1()]['latlng'] : $branch_list[$default_location]['latlng'];
		return apply_filters('kboard_worldmap_franchise_default_location', $default_location, $board);
	}
}

if(!function_exists('kboard_worldmap_franchise_default_zoom')){
	function kboard_worldmap_franchise_default_zoom($board=''){
		$default_zoom = '13';
		return apply_filters('kboard_worldmap_franchise_default_zoom', $default_zoom, $board);
	}
}

if(!function_exists('worldmap_franchise_kboard_extends_setting')){
	add_filter('kboard_'.$worldmap_franchise_skin_dir_name.'_extends_setting', 'worldmap_franchise_kboard_extends_setting', 10, 3);
	function worldmap_franchise_kboard_extends_setting($html, $meta, $board_id){
		$board = new KBoard($board_id);
		
		echo '<table class="form-table"><tbody>';
		
		echo '<tr valign="top">';
		echo '<th scope="row">구글 지도 자바스크립트 API 키</th><td>';
		echo '<input type="text" class="regular-text" name="google_maps_api_key" value="'.$board->meta->google_maps_api_key.'" placeholder="Maps JavaScript API">';
		echo '<p class="description">구글 지도 표시를 위해 사용됩니다.</p>';
		echo '<p class="description"><a href="https://blog.cosmosfarm.com/?p=389" onclick="window.open(this.href);return false;" title="구글 지도 API 키 발급 받는 방법 (Maps JavaScript API)">구글 지도 API 키 발급 받는 방법 (Maps JavaScript API)</a></p>';
		echo '</td></tr>';
		
		echo '<tr valign="top">';
		echo '<th scope="row">구글 지오코딩 API 키</th><td>';
		echo '<input type="text" class="regular-text" name="google_geocoding_api_key" value="'.$board->meta->google_geocoding_api_key.'" placeholder="Geocoding API">';
		echo '<p class="description">지표 표시용 주소와 GPS 자표 변환을 위해 사용됩니다.</p>';
		echo '<p class="description">서버 IP 주소 : <code>' . $_SERVER['REMOTE_ADDR'] . '</code></p>';
		echo '<p class="description"><a href="https://blog.cosmosfarm.com/?p=414" onclick="window.open(this.href);return false;" title="구글 지오코딩 API 키 발급 받는 방법 (Geocoding API)">구글 지오코딩 API 키 발급 받는 방법 (Geocoding API)</a></p>';
		echo '</td></tr>';
		
		echo '</tbody></table>';
		
		return $html;
	}
}

if(!function_exists('worldmap_franchise_kboard_extends_setting_update')){
	add_filter('kboard_'.$worldmap_franchise_skin_dir_name.'_extends_setting_update', 'worldmap_franchise_kboard_extends_setting_update', 10, 2);
	function worldmap_franchise_kboard_extends_setting_update($board_meta, $board_id){
		$board_meta->google_maps_api_key = isset($_POST['google_maps_api_key']) ? sanitize_text_field($_POST['google_maps_api_key']) : '';
		$board_meta->google_geocoding_api_key = isset($_POST['google_geocoding_api_key']) ? sanitize_text_field($_POST['google_geocoding_api_key']) : '';
	}
}