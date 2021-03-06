<?php
// Fetch data from apple store
function fetchAppleData($app_url){
	$array = array();
	if(strpos($app_url, 'apple.com') !== false){
		$id = substr($app_url, strrpos($app_url,'/id')+3);
		$id = explode("?",$id);
		$id = $id['0'];
		$array = array('title'=>'','description'=>'','duration'=>'','tags'=>'','viewCount'=>'');
		//print_r($id);exit;	
		$xml = @file_get_contents('https://itunes.apple.com/lookup?id='.$id);
		$xml = json_decode($xml,true);
		$array['title'] = $xml['results'][0]['trackName'];
		$array['description'] = $xml['results'][0]['description'];
		$array['icon'] = $xml['results'][0]['artworkUrl100'];
		if($array['icon']==''){
			$array['icon'] = $xml['results'][0]['artworkUrl60'];
		}
		
		$array['tags'] = $xml['results'][0]['genres'];
		$array['releaseDate'] = $xml['results'][0]['releaseDate'];
		$array['artistName'] = $xml['results'][0]['artistName'];
		$array['version'] = $xml['results'][0]['version'];
		$array['price'] = $xml['results'][0]['price'];
		$array['minimumOsVersion'] = $xml['results'][0]['minimumOsVersion'];
		if(!empty($xml['results'][0]['screenshotUrls'])){
			$array['screenshotUrls'] = $xml['results'][0]['screenshotUrls'];
		}else{
			$array['screenshotUrls'] = $xml['results'][0]['ipadScreenshotUrls'];
		}

		
	}elseif(strpos($app_url, 'google.com') !== false){
		include_once('playStoreApi.php'); // including class file
		$class_init = new PlayStoreApi; // initiating class
		$item_id = substr($app_url, strrpos($app_url,'id=')+3);
		$item_id = explode("&",$item_id);
		//$item_id = $item_id['0'].'&hl=en';
		$item_id = $item_id['0'];
		$itemInfo = $class_init->itemInfo($item_id); // calling itemInfo
		if($itemInfo !== 0){
			$array['title'] = $itemInfo['results'][0]['trackName'];
			$array['id'] = $itemInfo['results'][0]['app_id'];
			$array['description'] = $itemInfo['results'][0]['description'];
			$array['icon'] = $itemInfo['results'][0]['icon'];

			//$array['tags'] = $xml['results'][0]['genres'];
			$array['releaseDate'] = $itemInfo['results'][0]['releaseDate'];
			$array['artistName'] = $itemInfo['results'][0]['artistName'];
			$array['version'] = $itemInfo['results'][0]['version'];
			$array['price'] = $itemInfo['results'][0]['price'];
			$array['minimumOsVersion'] = $itemInfo['results'][0]['minimumOsVersion'];
			$array['screenshotUrls'] = $itemInfo['screenshotUrls'];
			//echo '<pre>';
			//print_r($array);
			//exit;
		}		
	}
	//echo '<pre>';
	//print_r($xml);
	//print_r($array);exit;	
	return $array;
}
add_action( 'save_post', 'leaf_save_postdata' );
if(!function_exists('leaf_save_postdata')){
	function leaf_save_postdata($post_id ){
		$url ='';
		if('product' != get_post_type($post_id))
		return;
		if( isset($_POST['store-link-apple']) ){
			$url = $_POST['store-link-apple'];
		}
		if( $url =='' && isset($_POST['store-link-google']) ){
			$url = $_POST['store-link-google'];
		}
		$fetch_data_itunes = ot_get_option('fetch_data_itunes');
		if($fetch_data_itunes=='on'){
			if( isset($_POST['fetch_data_itunes']) ){
				$fetch_data_itunes = $_POST['fetch_data_itunes'];
			}
		}
		if($fetch_data_itunes=='on'){
			$fetch_screen_itunes = ot_get_option('fetch_screen_itunes');
			if($url==''){$url =get_post_meta($post_id,'store-link-apple',true);}
			$data =  fetchAppleData($url);
			//print_r($a);exit;
			if(($url !='' && (strpos($url, 'itunes.apple.com') !== false))){
				$date_rl = explode("T",$data['releaseDate']);
				$date_rl = $date_rl['0'];
				update_post_meta( $post_id, 'app-icon', $data['icon'] );
				update_post_meta( $post_id, 'port-release', $date_rl );
				update_post_meta( $post_id, 'port-version', $data['version'] );
				update_post_meta( $post_id, 'port-author-name', $data['artistName'] );
				update_post_meta( $post_id, 'port-requirement', 'iOS '.$data['minimumOsVersion'].' +' );
				update_post_meta( $post_id, '_regular_price', $data['price'] );
			}elseif(($url !='' && (strpos($url, 'play.google.com') !== false))){
				update_post_meta( $post_id, 'app-icon', $data['icon'] );
				update_post_meta( $post_id, 'port-release', $data['releaseDate']);
				update_post_meta( $post_id, 'port-version', $data['version'] );
				update_post_meta( $post_id, 'port-author-name', $data['artistName'] );
				update_post_meta( $post_id, 'port-requirement', 'Android '.$data['minimumOsVersion'].' +' );
				update_post_meta( $post_id, '_regular_price', $data['price'] );
			}
			if($fetch_screen_itunes!='on' && $url !=''){
				update_post_meta( $post_id, 'custom-screenshot', implode("\n",$data['screenshotUrls']));
			}
		}
	}
}
add_action( 'save_post', 'featch_data_appstore');
function featch_data_appstore( $post_id ) {
	$url ='';
	if('product' != get_post_type($post_id))
	return;
	if( isset($_POST['store-link-apple']) ){
        $url = $_POST['store-link-apple'];
    }
	$fetch_data_itunes = ot_get_option('fetch_data_itunes');
	$fetch_screen_itunes = ot_get_option('fetch_screen_itunes');
	if($fetch_data_itunes=='on'){
		if( isset($_POST['fetch_data_itunes']) ){
			$fetch_data_itunes = $_POST['fetch_data_itunes'];
		}
	}
	if($fetch_data_itunes=='on'){
		if($url==''){$url =get_post_meta($post_id,'store-link-apple',true);}
		if( $url =='' && isset($_POST['store-link-google']) ){
			$url = $_POST['store-link-google'];
		}
		$data =  fetchAppleData($url);
		$post['ID'] = $post_id;
		//print_r($data);exit;
		
		if($fetch_screen_itunes=='on' && isset($data['screenshotUrls'][0]) && get_post_meta($post_id,'screenshotUrls',true) != $data['screenshotUrls'][0]){
			//print_r($data['screenshotUrls'][0]);exit;
			if(isset($data['screenshotUrls'][0])){
				if(strpos($data['screenshotUrls'][0], 'http://') !== false || strpos($data['screenshotUrls'][0], 'https://') !== false){
					$ht = '';
				}else{
					if( isset($_SERVER['HTTPS'] ) ) {
						$ht = 'https:';
					}else{
						$ht = 'https:';
					}
				}
				$attach_id = save_to_media_library( $ht.$data['screenshotUrls'][0], $post_id );
			}
			set_post_thumbnail( $post_id, $attach_id );
			if($_POST['product_image_gallery']==''){
				if(isset($data['screenshotUrls'][1])){
					if(strpos($data['screenshotUrls'][1], 'http://') !== false || strpos($data['screenshotUrls'][1], 'https://') !== false){
						$ht = '';
					}else{
						if( isset($_SERVER['HTTPS'] ) ) {
							$ht = 'https:';
						}else{
							$ht = 'https:';
						}
					}
					$attach_1 = save_to_media_library( $ht.$data['screenshotUrls'][1], $post_id );
				}
				if(isset($data['screenshotUrls'][2])){
					if(strpos($data['screenshotUrls'][2], 'http://') !== false || strpos($data['screenshotUrls'][2], 'https://') !== false){
						$ht = '';
					}else{
						if( isset($_SERVER['HTTPS'] ) ) {
							$ht = 'https:';
						}else{
							$ht = 'https:';
						}
					}
					$attach_2 = save_to_media_library( $ht.$data['screenshotUrls'][2], $post_id );
				}
				if(isset($data['screenshotUrls'][3])){
					if(strpos($data['screenshotUrls'][3], 'http://') !== false || strpos($data['screenshotUrls'][3], 'https://') !== false){
						$ht = '';
					}else{
						if( isset($_SERVER['HTTPS'] ) ) {
							$ht = 'https:';
						}else{
							$ht = 'https:';
						}
					}
					$attach_3 = save_to_media_library( $ht.$data['screenshotUrls'][3], $post_id );
				}
				if(isset($data['screenshotUrls'][4])){
					if(strpos($data['screenshotUrls'][4], 'http://') !== false || strpos($data['screenshotUrls'][4], 'https://') !== false){
						$ht = '';
					}else{
						if( isset($_SERVER['HTTPS'] ) ) {
							$ht = 'https:';
						}else{
							$ht = 'https:';
						}
					}
					$attach_4 = save_to_media_library( $ht.$data['screenshotUrls'][4], $post_id );
				}
				$image_gallery = $attach_id.','.$attach_1.','.$attach_2.','.$attach_3.','.$attach_4;
				if($attach_id!='' || $attach_1!='' || $attach_2!='' ||$attach_3!=''|| $attach_4!=''){
					update_post_meta( $post_id, '_product_image_gallery', $image_gallery);
				}
			}
		}
		if(($url !='' && (strpos($url, 'itunes.apple.com') !== false))){
			$post['post_title'] =  $data['title'] ;
			$post['post_name'] =  $data['title'] ;
			$post['post_content'] = $data['description'];
			//wp_set_post_tags( $post_id, $data['tags'], true );
			remove_action( 'save_post', 'featch_data_appstore' );
			wp_update_post($post);
			add_action( 'save_post', 'featch_data_appstore' );
			update_post_meta( $post_id, 'fetch_data_itunes', 'off' );
		}elseif(($url !='' && (strpos($url, 'play.google.com') !== false))){
			$post['post_title'] =  $data['title'] ;
			$post['post_name'] =  $data['id'] ;
			$post['post_content'] = $data['description'];
			//wp_set_post_tags( $post_id, $data['tags'], true );
			remove_action( 'save_post', 'featch_data_appstore' );
			wp_update_post($post);
			add_action( 'save_post', 'featch_data_appstore' );
			update_post_meta( $post_id, 'fetch_data_itunes', 'off' );
		}
		if($fetch_screen_itunes=='on'){
			if(isset($_POST['screenshotUrls']) && $_POST['screenshotUrls']!='0'){
				update_post_meta( $post_id, 'screenshotUrls', $data['screenshotUrls'][0] );
			}
		}
		
	}
}
function construct_filename( $post_id ) {
	$filename = get_the_title( $post_id );
	$filename = sanitize_title( $filename, $post_id );
	$filename = urldecode( $filename );
	$filename = preg_replace( '/[^a-zA-Z0-9\-]/', '', $filename );
	$filename = substr( $filename, 0, 32 );
	$filename = trim( $filename, '-' );
	if ( $filename == '' ) $filename = (string) $post_id;
	return $filename;
}
function save_to_media_library( $image_url, $post_id ) {

	$error = '';
	$response = wp_remote_get( $image_url, array( 'sslverify' => false, 'timeout' => 300, ) );
	if( is_wp_error( $response ) ) {
		$error = new WP_Error( 'thumbnail_retrieval', sprintf( __( 'Error retrieving a thumbnail from the URL <a href="%1$s">%1$s</a> using <code>wp_remote_get()</code><br />If opening that URL in your web browser returns anything else than an error page, the problem may be related to your web server and might be something your host administrator can solve.', 'applay' ), $image_url ) . '<br>' . __( 'Error Details: ', 'applay' ) . implode($response->get_error_message()) );
	} else {
		$image_contents = $response['body'];
		$image_type = wp_remote_retrieve_header( $response, 'content-type' );
	}

	if ( $error != '' ) {
		return $error;
	} else {
		if( isset($_POST['store-link-apple']) ){
			$url = $_POST['store-link-apple'];
		}
		if( $url =='' && isset($_POST['store-link-google']) ){
			$url = $_POST['store-link-google'];
		}
		if(strpos($url, 'play.google.com') !== true){
			// Translate MIME type into an extension
			if ( $image_type == 'image/jpeg' ) {
				$image_extension = '.jpg';
			} elseif ( $image_type == 'image/png' ) {
				$image_extension = '.png';
			} elseif ( $image_type == 'image/gif' ) {
				$image_extension = '.gif';
			} else {
				return new WP_Error( 'thumbnail_upload', __( 'Unsupported MIME type:', 'applay' ) . ' ' . $image_type );
			}
	
			// Construct a file name with extension
			$new_filename = construct_filename( $post_id ) . $image_extension;
		}else{
			$new_filename = construct_filename( $post_id ) . '.webp';
		}

		// Save the image bits using the new filename
		do_action( 'video_thumbnails/pre_upload_bits', $image_contents );
		$upload = wp_upload_bits( $new_filename, null, $image_contents );
		do_action( 'video_thumbnails/after_upload_bits', $upload );

		// Stop for any errors while saving the data or else continue adding the image to the media library
		if ( $upload['error'] ) {
			$error = new WP_Error( 'thumbnail_upload', __( 'Error uploading image data:', 'applay' ) . ' ' . $upload['error'] );
			return $error;
		} else {

			do_action( 'video_thumbnails/image_downloaded', $upload['file'] );

			$image_url = $upload['url'];

			$filename = $upload['file'];

			$wp_filetype = wp_check_filetype( basename( $filename ), null );
			$attachment = array(
				'post_mime_type'	=> $wp_filetype['type'],
				'post_title'		=> get_the_title( $post_id ),
				'post_content'		=> '',
				'post_status'		=> 'inherit'
			);
			$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );
			// you must first include the image.php file
			// for the function wp_generate_attachment_metadata() to work
			require_once( ABSPATH . 'wp-admin/includes/image.php' );
			$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
			wp_update_attachment_metadata( $attach_id, $attach_data );

		}

	}

	return $attach_id;

}
// End Fetch
add_filter('pre_post_title', 'post_mask_empty');
add_filter('pre_post_content', 'post_mask_empty');
function post_mask_empty($value)
{
    if ( empty($value) ) {
        return ' ';
    }
    return $value;
}

add_filter('wp_insert_post_data', 'save_empty_post');
function save_empty_post($data)
{
    if ( ' ' == $data['post_title'] ) {
        $data['post_title'] = '';
    }
    if ( ' ' == $data['post_content'] ) {
        $data['post_content'] = '';
    }
    return $data;
}