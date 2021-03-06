<?php
	
	error_reporting(0);
	include_once( 'Queryelements.php' );
	class PlayStoreApi{
		
		private $base_store_url = 'https://play.google.com';

		function get_fcontent( $url,  $javascript_loop = 0, $timeout = 5 ) {
			$url = str_replace( "&amp;", "&", urldecode(trim($url)) );
	
			$cookie = tempnam ("/tmp", "CURLCOOKIE");
			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1" );
			curl_setopt( $ch, CURLOPT_URL, $url );
			curl_setopt( $ch, CURLOPT_COOKIEJAR, $cookie );
			curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, true );
			curl_setopt( $ch, CURLOPT_ENCODING, "" );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_AUTOREFERER, true );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );    # required for https urls
			curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, $timeout );
			curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
			curl_setopt( $ch, CURLOPT_MAXREDIRS, 10 );
			$content = curl_exec( $ch );
			$response = curl_getinfo( $ch );
			curl_close ( $ch );
	
			if ($response['http_code'] == 301 || $response['http_code'] == 302) {
				//ini_set("user_agent", "Mozilla/5.0 (Windows; U; Windows NT 5.1; rv:1.7.3) Gecko/20041001 Firefox/0.10.1");
	
				if ( $headers = get_headers($response['url']) ) {
					foreach( $headers as $value ) {
						if ( substr( strtolower($value), 0, 9 ) == "location:" )
							return get_url( trim( substr( $value, 9, strlen($value) ) ) );
					}
				}
			}
	
			if (( preg_match("/>[[:space:]]+window\.location\.replace\('(.*)'\)/i", $content, $value) || preg_match("/>[[:space:]]+window\.location\=\"(.*)\"/i", $content, $value) ) && $javascript_loop < 5) {
				return get_url( $value[1], $javascript_loop+1 );
			} else {
				return array( $content, $response );
			}
		}

		function topPaidApps($start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/collection/topselling_paid?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$paid_apps[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $paid_apps;
			}
			else
			{
				return 0;
			}
		}

		function topFreeApps($start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/collection/topselling_free?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$free_apps[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $free_apps;
			}
			else
			{
				return 0;
			}
		}

		function topGrossingApps($start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/collection/topgrossing?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$grossing_apps[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $grossing_apps;
			}
			else
			{
				return 0;
			}
		}

		function topNewPaidApps($start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/collection/topselling_new_paid?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$new_paid_apps[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $new_paid_apps;
			}
			else
			{
				return 0;
			}
		}

		function topNewFreeApps($start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/collection/topselling_new_free?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$new_free_apps[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $new_free_apps;
			}
			else
			{
				return 0;
			}
		}

		function topPaidGames($start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/collection/topselling_paid_game?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$paid_games[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $paid_games;
			}
			else
			{
				return 0;
			}
		}

		function topFreeGames($start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/collection/topselling_free_game?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}
			if(isset($this_content[0])){
				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$free_games[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $free_games;
			}
			else
			{
				return 0;
			}
		}

		function topTrendingApps($start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/collection/movers_shakers?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}
			if(isset($this_content[0])){
				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$trending_apps[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $trending_apps;
			}
			else
			{
				return 0;
			}
		}

		function staffPicks($start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/collection/featured?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}
			if(isset($this_content[0])){
				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$staff_picks[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $staff_picks;
			}
			else
			{
				return 0;
			}
		}


		function staffPicksForTablet($start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/collection/tablet_featured?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}
			if(isset($this_content[0])){
				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$staff_picks_for_tablet[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $staff_picks_for_tablet;
			}
			else
			{
				return 0;
			}
		}

		function listCategories(){
			$page_url = 'https://play.google.com/store/apps/category/GAME';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$initial_load = explode('</ul>',pq('#tab-body-categories > div > .padded-content3')->html());
				foreach($initial_load as $filtering_elements){
					phpQuery::newDocumentHTML($filtering_elements);
					$heading_element = pq('h2 > a')->text();
					$list_items = pq('li');
					$str_replace = array('<li>','<ul>');
					$break_all_items = explode('</li>',$list_items);
					$break_all_items = str_replace($str_replace,'',$break_all_items);
					if(!empty($heading_element)){ $categories_array[$heading_element] = ''; }
					foreach($break_all_items as $li)
					{
						phpQuery::newDocument($li);
						$category_name = pq('a:first-child')->text();
						$category_url = pq('a:first-child')->attr('href');
						$category_id_context = explode('/',$category_url);
						$category_url = $this->base_store_url.''.$category_url;
						if(isset($category_id_context[4])) { $category_id = str_replace('?feature=category-nav','',$category_id_context[4]); } else { $category_id = 'Not defined'; }
						if(!empty($category_id) && $category_id !== 'Not defined'){
							$categories_array[$heading_element][] = (object) array('category_name' => $category_name,'category_url' => $category_url, 'category_id' => $category_id);
						}
					}
				}
				return $categories_array;
			}
			else
			{
				return 0;
			}
		}
		
		function categoryPaidItems($category,$start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/category/'.$category.'/collection/topselling_paid?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
			
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}
				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$category_paid_apps[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $category_paid_apps;
			}
			else
			{
				return 0;
			}
		}

		function categoryFreeItems($category,$start = 1){
			$start = $start - 1;
			$start = $start * 24;
			$page_url = 'https://play.google.com/store/apps/category/'.$category.'/collection/topselling_free?start='.$start.'&num=24';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$category_free_apps[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $category_free_apps;
			}
			else
			{
				return 0;
			}
		}

		function developerItems($developer_id,$start = 1){
			$start = $start - 1;
			$start = $start * 12;
			$page_url = 'https://play.google.com/store/apps/developer?id='.$developer_id.'&start='.$start.'&num=12';
			$elements_to_look = 'snippet-list';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > div > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.snippet-content')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > div > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$developer_apps[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $developer_apps;
			}
			else
			{
				return 0;
			}
		}

		function searchStore($search_query,$sort='Popularity',$price='All',$safe_search = 'Off',$start=1){
			$start = $start - 1;
			$start = $start * 24;
			// Required search parameters array ( ** CAUTION --- DO NOT EDIT --- ** )
			$sort_array = array('Popularity' => 0, 'Relevance' => 1);
			$price_array = array('All' => 0, 'Paid' => 2,'Free' => 1);
			$safe_search_array = array('Off' => 1, 'Low' => 1, 'Moderate' => 2, 'Strict' => 3);

			if(in_array($sort,$sort_array)) { $sort_term = $sort_array[$sort]; } else { $sort_term = 0; }
			if(in_array($price,$price_array)) { $price_term = $price_array[$price]; } else { $price_term = 0; }
			if(in_array($safe_search,$safe_search_array)) { $safe_search_term = $safe_search_array[$safe_search]; } else { $safe_search_term = 0; }

			$page_url = 'https://play.google.com/store/search?q='.$search_query.'&c=apps&price='.$price_term.'&safe='.$safe_search_term.'&sort='.$sort_term.'&start='.$start.'&num=24';
			$elements_to_look = 'search-results-list';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$list_items = pq('.'.$elements_to_look.' > li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$icon = pq('img')->attr('src');
					$app_title = pq('.details > a.title')->html();
					$app_author = pq('.attribution > div > a')->html();
					$app_snippet = pq('.description')->html();
					$app_price = pq('.buy-button-price')->text();
					if($app_price == 'Install') { $app_price = 'Free'; }
					// external links
					$app_play_store_link = $this->base_store_url.''.pq('.details > a.title')->attr('href');
					$app_id_context = explode('?id=',$app_play_store_link);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$app_id = $app_id_context[0];
					}
					else
					{
						$app_id = 'Not defined';
					}
					$ratings_context = explode(' ',pq('.ratings')->attr('title'));
					if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
					if(!empty($app_id) && $app_id != 'Not defined')
					{
						$searched_apps[] = (object) array('app_title' => $app_title,'app_icon' => $icon,'app_author' => $app_author,'app_snippet' => $app_snippet,'app_price' => $app_price,
							'app_play_store_link' => $app_play_store_link,'app_id' => $app_id,'app_ratings' => $ratings);
					}
				}
				return $searched_apps;
			}
			else
			{
				return 0;
			}
		}
		function itemInfo($item_id){
			$page_url = 'https://play.google.com/store/apps/details?id='.$item_id.'&hl=en';
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
			phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}
				//$banner_image = pq('.doc-banner-image-container > img')->attr('src');
				$banner_icon = pq('img[itemprop="image"]')->attr('src');
				$banner_icon = str_replace('=w300', '=w128', $banner_icon);
				$ratings_context = explode(' ',pq('.ratings')->attr('title'));
				if(isset($ratings_context[1])){$ratings = $ratings_context[1];}else{$ratings = 'Not defined';}
				$app_title = pq('h1[itemprop="name"]>span')->html();
				$app_ct = pq('div[itemprop="description"]>content>div')->html();
				$app_author = pq('.JNury .oQ6oV .i4sPve > span.T32cc:fist-child a:not([itemprop])')->html();
				//$release = pq('div[itemprop="author"]>div')->html();
				//$version = pq('div[itemprop="softwareVersion"]')->html();
				//$minimumOsVersion = pq('div[itemprop="operatingSystems"]')->html();
				$app_price = pq('meta[itemprop="price"]')->attr('content');
				$ratings_context = pq('meta[itemprop="ratingValue"]')->attr('content');
				if((strpos($app_price, ",") == false) && (strpos($app_price, ".") == false)) $app_price = __('Free', 'applay');
				
				foreach(pq('button[data-screenshot-item-index] img') as $appshots) {
					$app_screen_shots = pq($appshots)->attr('src');

					if(substr($app_screen_shots, -8, 8) == '=h310-rw'){
						$app_screen_shots = str_replace('=h500', '', $app_screen_shots);
					}

					//fix wrong src url
					if(filter_var($app_screen_shots, FILTER_VALIDATE_URL) === false && pq($appshots)->attr('data-src') ){
						$app_screen_shots = pq($appshots)->attr('data-src');
					}

					if(substr(pq($appshots)->attr('srcset'), -3, 3) == ' 2x'){
						//$app_screen_shots = str_replace(' 2x', '', pq($appshots)->attr('srcset'));
					}
					if (filter_var($app_screen_shots, FILTER_VALIDATE_URL) !== false) { //check valid url
						/* custom get HD image
						$app_info['screenshotUrls'][] = str_replace('w720-h310', 'w2048-h1080', $app_screen_shots);
						*/
						$app_info['screenshotUrls'][] = $app_screen_shots;
					}
					
				}
				$app_store_url = $page_url;
				$app_info['results'][] = array(
					'app_id' => $item_id,
					'app_store_url' => $app_store_url,
					'icon' => $banner_icon, 
					'app_video' => $app_video,
					'description' => $app_ct, 
					'trackName' => $app_title, 
					'artistName' => $app_author, 
					'releaseDate' => $release,
					'version' => $version,
					'_regular_price' => $app_price,
					'app_rating' => $app_rating,
					'minimumOsVersion' => $minimumOsVersion,
					'storename_css' => 'googleplay',
					'fallback' => '0'
				);
				return $app_info;
			}
			else
			{
				return 0;
			}
		}
		
		function relatedViewed($item_id){
			$page_url = 'https://play.google.com/store/apps/details?id='.$item_id;
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$list_items = pq('div[data-analyticsid="related"] > .snippet-list li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$related_thumbnail = pq('img.app-snippet-thumbnail')->attr('src');
					$related_app_title = pq('.common-snippet-title')->html();
					$related_app_store_url = $this->base_store_url.''.pq('a.app-snippet-thumbnail')->attr('href');
					$app_id_context = explode('?id=',$related_app_store_url);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$related_app_id = $app_id_context[0];
					}
					else
					{
						$related_app_id = 'Not defined';
					}
					$related_app_developer = pq('.attribution > div > a')->text();
					$related_app_developer_store_url = pq('.attribution > div > a')->attr('href');
	
					$related_app_rating_context = explode(' ',pq('.app-snippet-ratings > div > div.ratings')->attr('title'));
					if(isset($related_app_rating_context[1])){$related_rating = $related_app_rating_context[1];}else{$related_rating = 'Not defined';}
	
					if(!empty($related_app_id) && $related_app_id !== 'Not defined')
					{
						$related_viewed[] = (object) array('related_app_title' => $related_app_title,'related_app_thumbnail' => $related_thumbnail,'related_app_store_url' => $related_app_store_url,
							'related_app_id' => $related_app_id,'related_app_developer' => $related_app_developer,'related_app_developer_store_url' => $related_app_developer_store_url,
							'related_app_rating' => $related_rating
						);
					}
				}
				return $related_viewed;
			}
			else
			{
				return 0;
			}
		}

		function relatedInstalled($item_id){
			$page_url = 'https://play.google.com/store/apps/details?id='.$item_id;
			$this_content = $this->get_fcontent($page_url);
			if(isset($this_content[0])){
				phpQuery::newDocumentHTML($this_content[0]);
				$error_found = pq("#error-section")->text();
				if($error_found == "We're sorry, the requested URL was not found on this server.")
				{
					return 0;
				}

				$list_items = pq('div[data-analyticsid="users-also-installed"] > .snippet-list li');
				$break_all_items = explode('</li>',$list_items);
				$break_all_items = str_replace('<li>','',$break_all_items);
				foreach($break_all_items as $li)
				{
					phpQuery::newDocument($li);
					$related_thumbnail = pq('img.app-snippet-thumbnail')->attr('src');
					$related_app_title = pq('.common-snippet-title')->html();
					$related_app_store_url = $this->base_store_url.''.pq('a.app-snippet-thumbnail')->attr('href');
					$app_id_context = explode('?id=',$related_app_store_url);
					if(isset($app_id_context[1]))
					{
						$app_id_context = explode('&',$app_id_context[1]);
						$related_app_id = $app_id_context[0];
					}
					else
					{
						$related_app_id = 'Not defined';
					}
					$related_app_developer = pq('.attribution > div > a')->text();
					$related_app_developer_store_url = pq('.attribution > div > a')->attr('href');
	
					$related_app_rating_context = explode(' ',pq('.app-snippet-ratings > div > div.ratings')->attr('title'));
					if(isset($related_app_rating_context[1])){$related_rating = $related_app_rating_context[1];}else{$related_rating = 'Not defined';}
	
					if(!empty($related_app_id) && $related_app_id !== 'Not defined')
					{
						$related_installed[] = (object) array('related_app_title' => $related_app_title,'related_app_thumbnail' => $related_thumbnail,'related_app_store_url' => $related_app_store_url,
							'related_app_id' => $related_app_id,'related_app_developer' => $related_app_developer,'related_app_developer_store_url' => $related_app_developer_store_url,
							'related_app_rating' => $related_rating
						);
					}
				}
				return $related_installed;
			}
			else
			{
				return 0;
			}
		}
	}
?>