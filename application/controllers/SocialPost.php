<?php
/**
 *
 * @package    SocialPost
 * @author     Vinil Lakkavatri (vinil.lakkavatri@icloud.com)
 * @copyright  2017 Vinil Lakkavatri
 * @company    FiHavock Digital Pvt Ltd
 * @ci_version 3.1.2 echo CI_VERSION;
 * @deprecated File deprecated in Release 2.0.0
 *
 **/
include_once $_SERVER['DOCUMENT_ROOT']."/vendor/aylien_textapi_php-master/src/AYLIEN/TextAPI.php";
include_once $_SERVER['DOCUMENT_ROOT']."/vendor/twitter-oauth-php-codexworld/twitteroauth.php";
include_once $_SERVER['DOCUMENT_ROOT']."/vendor/twitter-oauth-php-codexworld/TwitterAPIExchange.php";
include_once $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/vendor/fb-test/src/Facebook/autoload.php';
use LinkedIn\Client;
use LinkedIn\Scope;
use LinkedIn\AccessToken;
class SocialPost extends CI_Controller
{
	
	function __construct(){
		
		parent::__construct();
        error_reporting(0);
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('pro');
        $this->load->model('Common_model', 'admin');
        $this->company_id = $this->session->userdata('marketing_company_id');
        if (!file_exists($_SERVER['DOCUMENT_ROOT']."/userfiles/clients/".$this->company_id)) {
		    mkdir($_SERVER['DOCUMENT_ROOT']."/userfiles/clients/".$this->company_id);
		    chmod($_SERVER['DOCUMENT_ROOT']."/userfiles/clients/".$this->company_id, 0777);
		}
		$actual_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/userfiles/clients/".$this->company_id."/";
		$save_path = $_SERVER['DOCUMENT_ROOT']."/userfiles/clients/".$this->company_id."/";
		$this->global_data = array( 'save_path' => $save_path, 'actual_url' => $actual_url);
		
	}

	function social_board(){

		$this->load->view('dashboard/header');
		if (!empty($data)) {
			$this->load->view('social/social-post',$data);
		}else{
			$this->load->view('social/social-post');
		}
		$this->load->view('dashboard/footer');
	}


	function add_social_board(){

		if (isset($_POST) && !empty($_POST)) {
			
			// linkedin related integration
			//include_once '/opt/bitnami/apache2/htdocs/vendor/autoload.php';
			$twitter_whr = '(company_id = '.$this->company_id.' AND oauth_provider = "twitter")';
			$twitter_data = current($this->admin->fetch_all_table_data_multiple_condition('marketing_social_integration',$twitter_whr));
			$twitter_whr = '(company_id = '.$this->company_id.' AND oauth_provider = "facebook")';
			$facebook_data = current($this->admin->fetch_all_table_data_multiple_condition('marketing_social_integration',$twitter_whr));
			$twitter_whr = '(company_id = '.$this->company_id.' AND oauth_provider = "linkedin")';
			$linkedin_data = current($this->admin->fetch_all_table_data_multiple_condition('marketing_social_integration',$twitter_whr));
			
			/* POST DATA */
			$post_content = $this->input->post('post_content');
			$twitter_content_flag = $this->input->post('twitter_content_flag');
			$twitter_content = $this->input->post('twitter_content');
			
			// social platform flags
			$facebook = $this->input->post('facebook');
			if (!empty($facebook)) {
				$shared_social[] = 'facebook_profile';
			}
			$facebook_page = $this->input->post('facebook_page');
			if (!empty($facebook_page)) {
				$shared_social[] = 'facebook_page';
			}
			$twitter = $this->input->post('twitter');
			if (!empty($twitter)) {
				$shared_social[] = 'twitter';
			}
			$linkedin = $this->input->post('linkedin');
			if (!empty($linkedin)) {
				$shared_social[] = 'linkedin_profile';
			}
			$linkedin_page = $this->input->post('linkedin_page');
			if (!empty($linkedin_page)) {
				$shared_social[] = 'linkedin_page';
			}
			$schedule_date = $this->input->post('schedule_date');
			$tags = $this->input->post('tags');
			array_pop($tags);

			$rand = rand();
			if(isset($_FILES['post_image']['name']) && !empty($_FILES['post_image']['name'])){
				$image_name = $rand.'_'.$_FILES['post_image']['name'];
				$tmp_image_name = $_FILES['post_image']['tmp_name'];
				$image_type = $_FILES['post_image']['type'];
				$image_size = $_FILES['post_image']['size'];
				$status = move_uploaded_file($tmp_image_name, $this->global_data['save_path'].$image_name);
				if (!empty($image_name)) {
					$mediaContent = file_get_contents($this->global_data['actual_url'].$image_name);
					$data['image_name'] = $this->global_data['actual_url'].$image_name;
					$s_status = '0';
				}
			}else{
				$data['image_name'] = '';
				$mediaContent = '';
			}

			if (!empty($tags)) {
				$tags = implode(" ", $tags);
			}
			$data['description'] = $post_content.' '.$tags;
			//echo "<pre>";print_r($data);die;
			$data['added_by'] =  $this->session->userdata('marketing_username');
			date_default_timezone_set("Asia/Kolkata");
			$data['added_date'] = date("Y-m-d H:i:sa");
			
			if (empty($schedule_date)) {

				// Twitter Integration Post
				if (!empty($twitter_data)) {
					if (!empty($twitter)) {
						if (empty($twitter_content)) {
							$twitter_content = $post_content.' '.$tags;
						}else{
							$twitter_content = $twitter_content.' '.$tags;
						}
						$twitter_access_token = $twitter_data['access_token'];
						$twitter_access_token_secret = $twitter_data['access_token_secret'];
						$twitter_post = $this->pro->twitter_post($twitter_access_token, $twitter_access_token_secret,$twitter_content,$mediaContent);
						$data['twid'] = $twitter_post;
						$social_shared[] = 'twitter';
					}
				}

				// Facebook Integration Post
				if (!empty($facebook_data)) {
					$facebook_access_token = $facebook_data['access_token'];
					$fb_page_id = $facebook_data['facebook_company_id'];
					$fb_company_details = unserialize($facebook_data['facebook_company_list']);
					$fb_groups_selected = $facebook_data['fb_groups_selected'];
					foreach ($fb_company_details as $value) {
						if ($fb_page_id == $value['id']) {
							$fb_page_access_token = $value['access_token'];
						}
					}

					if (!empty($facebook)) {
						$post_into_fb_profile = $this->pro->facebook_profile_post($facebook_access_token,$data['description'],$data['image_name'],$this->global_data['actual_url']);
						$fbid[] = array('facebook_profile_id' => $post_into_fb_profile);
						$social_shared[] = 'facebook_profile';
					}

					if (!empty(!empty($facebook_page))) {
						$post_into_fb_page = $facebook_post = $this->pro->facebook_page_post($facebook_access_token,$data['description'],$data['image_name'],$this->global_data['actual_url'],$fb_page_id,$fb_page_access_token);
						$fbid[] = array('facebook_page_id' => $post_into_fb_page);
						$social_shared[] = 'facebook_page';
					}

					if (!empty($fbid)) {
						$data['fbid'] = json_encode($fbid);
					}
					
				}

				// LinkedIn Integration Post
				if (!empty($linkedin_data)) {
					$getExpiresAt = $linkedin_data['getExpiresAt'];
					$linkedin_access_token = $linkedin_data['access_token'];
					$linkedin_company_id = $linkedin_data['linkedin_company_id'];

					if (!empty($linkedin)) {
						$post_into_linkedin_profile = $this->pro->linkedin_profile_post($data['description'],$data['image_name'],$linkedin_access_token,$getExpiresAt);
						$linkedinid[] = array('linkedin_profile_id' => $post_into_linkedin_profile);
						$social_shared[] = 'linkedin_profile';
					}

					if (!empty($linkedin_page)) {
						$post_into_linkedin_page = $this->pro->linkedin_company_post($linkedin_company_id,$data['description'],$data['image_name'],$linkedin_access_token,$getExpiresAt);
						$linkedinid[] = array('linkedin_page_id' => $post_into_linkedin_page);
						$social_shared[] = 'linkedin_page';
					}

					if (!empty($linkedinid)) {
						$data['linkedinid'] = json_encode($linkedinid);
					}
					
				}
			}else{
				$schedule_date = date("Y-m-d H:i:s", strtotime($schedule_date));
				$data['is_scheduled'] = 1;
				$data['is_scheduled_date'] = $schedule_date;
			}
			//echo "<pre>";print_r($data);die;
			$data['company_id'] = $this->company_id;
			$data['social_shared'] = implode(",", $shared_social);
			$insert_data = $this->admin->insert_into_table('marketing_social_board',$data);
			$data['post_id'] = $insert_data;
			$data['social_shared'] = implode(",", $social_shared);
			$data['description'] = $data['description'].'.';
			$data['unique_id'] = 12345678;
			$cron_schedule = $this->admin->insert_into_table('cron_schedule',$data);
			$data['description'] = $data['description'].'@Powered By ALTCMS';
			$data['unique_id'] = 87654321;
			$cron_schedule = $this->admin->insert_into_table('cron_schedule',$data);
			// bulk emails sent to facebook groups 
			$this->session->set_flashdata('message','Successfully Posted on All Social Media Platform!');
			redirect('SocialPost/social_board');
		}
	}

	function social_board_del(){

		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST['cid'];
			$social_data = current($this->admin->fetch_social_board($id));
			$image_name = $social_data['image_name'];
			$image_name = explode("/", $image_name);
			$file_name = $image_name[6];
			$client_name = $image_name[2];
			$client_name = explode(".", $client_name);
			$client_name = $client_name[0];

			$social_board = $this->admin->social_board_del($id);
			unlink($_SERVER['DOCUMENT_ROOT'].'/userfiles/clients/'.$client_name.'/'.$file_name);
		}
	}

	function view_post(){

		$view_post = '(company_id = '.$this->company_id.')';
		$data['view_post'] = $this->admin->fetch_all_table_data_multiple_condition('marketing_social_board',$view_post);

		$this->load->view('dashboard/header');
		if (!empty($data)) {
			$this->load->view('social/view-post',$data);
		}else{
			$this->load->view('social/view-post');
		}
		$this->load->view('dashboard/footer');
	}

	function social_feeds(){

		// facebook data fetching over here
		if (!empty($this->session->userdata('marketing_company_id'))) {
			$social_data = $this->pro->social_integration_data();
		}
		//$facebook_data = $social_data['facebook_data'];
		$twitter_data = $social_data['twitter_data'];

		if (!empty($twitter_data)) {

		    $consumerKey = 'yJxJ8QRAESmzSDCJxsRYuSqUO';
		    $consumerSecret = '0bJAdQe2oE9jtkzhfZOsKtNYVPCklg3UiZDTjUdqcG5EPOfulu';
		    
		    $access_token = $twitter_data['access_token'];
		    $access_token_secret = $twitter_data['access_token_secret'];
		    $username = $twitter_data['username'];
		    $connection = new TwitterOAuth($consumerKey, $consumerSecret, $access_token, $access_token_secret);
		
		    $settings = array(
		        'oauth_access_token' => $access_token,
		        'oauth_access_token_secret' => $access_token_secret,
		        'consumer_key' => $consumerKey,
		        'consumer_secret' => $consumerSecret
		    );
		    $twitter = new TwitterAPIExchange($settings);

		    $url = "https://api.twitter.com/1.1/users/show.json";
	        $method = "GET";
	        $getfield = '?screen_name='.$username;
	        $json = $twitter
	                    ->setGetfield($getfield)
	                    ->buildOauth($url, $method)
	                    ->performRequest();
	        // Result is a json string
	        $res = json_decode($json, true);
		    //$status = $connection->get("users/show");

	        $url = "https://api.twitter.com/1.1/statuses/user_timeline.json";
			$requestMethod = "GET";
			$getfield = '?screen_name='.$username.'&count=10';
			$string = json_decode($twitter->setGetfield($getfield)
			->buildOauth($url, $requestMethod)
			->performRequest(),$assoc = TRUE);

			$data['twitter_user_tweets'] = $string;

	        $data['twitter_user_profile'] = $res;
	    }

		//echo "<pre>";print_r($data);die;

		$this->load->view('dashboard/header');
		if (!empty($data)) {
			$this->load->view('social/social-feeds',$data);
		}else{
			$this->load->view('social/social-feeds');
		}
		$this->load->view('dashboard/footer');
	}

	function facebook_feeds(){
		$social_data = $this->pro->social_integration_data();
		$facebook_data = $social_data['facebook_data'];
		if (!empty($facebook_data)) {
		$fb = new Facebook\Facebook([
	        'app_id' => '1459174307464450', // Replace {app-id} with your app id
	        'app_secret' => '5be12280339255f88646dc2804cdb7c6',
	        'default_graph_version' => 'v2.2',
	    ]);
		$facebook_company_page = $facebook_data['facebook_company_id'];
		$fb_company_details = unserialize($facebook_data['facebook_company_list']);
		foreach ($fb_company_details as $value) {
			if ($facebook_company_page == $value['id']) {
				$fb_page_access_token = $value['access_token'];
			}
		}
		$fb_access_token = $facebook_data['access_token'];
		if (isset($_POST['req_type']) && !empty($_POST['req_type'] == 'facebook_onload')) {
			try {
			  // Returns a `Facebook\FacebookResponse` object
			  $response = $fb->get('/'.$facebook_company_page.'/feed?fields=comments{comment_count,message},likes{name,id},actions,created_time,full_picture,link,name,description,picture,message,is_published,shares,status_type,subscribed,type&limit=10',$fb_page_access_token);

			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  echo 'Graph returned an error: ' . $e->getMessage();
			  //exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  //exit;
			}
			$graphNode = $response->getGraphEdge();

		}else if (isset($_POST['req_type']) && !empty($_POST['req_type'] == 'facebook_pagination')) {
			$offset = $this->input->post('offset');
			try {
			  // Returns a `Facebook\FacebookResponse` object
			  $response = $fb->get('/'.$facebook_company_page.'/feed?fields=comments{comment_count,message},likes{name,id},actions,created_time,full_picture,link,name,description,picture,message,is_published,shares,status_type,subscribed,type&limit=10&offset='.$offset.'',$fb_page_access_token);

			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  echo 'Graph returned an error: ' . $e->getMessage();
			  //exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  //exit;
			}
			$graphNode = $response->getGraphEdge();
			//$graphNode = $fb->next($graphNode);

		}
		$fb_company_page_data = $graphNode->asArray();
		//$html = '';
		if (!empty($fb_company_page_data)) {
			$i = 1; 
			foreach ($fb_company_page_data as $value) {
                $id = $value['id'];
                $fb_page_id = explode("_", $id);
                $fb_page_id = $fb_page_id[0];
                $time = $value['created_time'];
                $full_picture = $value['full_picture'];
                $comments = count($value['comments']);
                $likes = count($value['reactions']);
                $link = $value['permalink_url'];
                $likes_count = count($value['likes']);
                foreach ($value['likes'] as $val) {
                    $is_self_liked[] = $val['id'];
                }
                $fb_page_id = array('0' => $fb_page_id);
                $is_self_liked=array_intersect($is_self_liked,$fb_page_id);
                $str_id = '`'.$id.'`';
                $html = '<div class="feed-post">
                        <div style="float: right;"><span onclick="return social_delete_post('."'facebook'".','.$str_id.')"><img src="'.base_url().'cms-assets/img/delete.png" style="width: 17px;"></span></div>';
                if(!empty($value['message'])){
               	$html .= '<div class="feed-post-text">'.$value['message'].'</div>';
               	}if (!empty($full_picture)) {
               	$html .= '<div class="feed-post-image"><img src="'.$full_picture.'"></div>';
               	}
               	$html .= '<div class="feed-post-metrics" style="border-bottom: 0px !important;height: 90px;">';
               	if (!empty($is_self_liked)) {
               	$html .= '<input type="hidden" name="is_like" id="is_like_'.$id.'" value="unlike">';
               	}else{
               	$html .= '<input type="hidden" name="is_like" id="is_like_'.$id.'" value="like">';
               	}
               	$html .= '<span id="'.$id.'" onclick="return my_fb_like('.$str_id.' ,'."'is_like_".$id."'".','."'likes_count_".$id."'".')">';
               	if (!empty($is_self_liked)) {
               	$html .= '<img src="'.base_url().'cms-assets/img/Liked Icon.png" style="width: 17px;">';
               	}else{
               	$html .= '<img src="'.base_url().'cms-assets/img/Likes Icon 02.png" style="width: 17px;">';
               	}
               	$html .= '<span id="likes_count_'.$id.'">'.$likes_count.'</span></span><span onclick="open_commentbox('."'text_commentbox_".$id."'".')"><img src="'.base_url().'cms-assets/img/Comment Icon.png" style="width: 17px;">'.$comments.'</span><div id="text_commentbox_'.$id.'" style="display: none;"><input type="hidden" name="post_id" value="'.$id.'"><input type="text" name="comment" id="comment_'.$id.'" class="form-control fb_comment" style="height: 60px;" onkeypress="mykeyFunction(event,'."'comment_".$id."'".')"><div style="float:  right;margin-top: 22px;" id="comment_box_'.$id.'"></div></div></div></div>';
               	unset($is_self_liked);
               	$new_html[] = $html;
               	$status = 'success';
               	$i++; } }else{
               	$html .= '<div class="feed-post no-data"> No Data Available. </div>';
                $status = 'fail';
                }
            $new_html = implode("", $new_html);
            $data_json = array('status' => $status, 'result' => $new_html);
            echo json_encode($data_json);
		}else{
			$html .= '<div class="feed-post no-data"> No Data Available. </div>';
			$data_json = array('status' => 'fail', 'result' => $html);
            echo json_encode($data_json);
		}
		
	}

	function linkedin_feeds(){
		$social_data = $this->pro->social_integration_data();
		$linkedin_data = $social_data['linkedin_data'];
		if (!empty($linkedin_data)) {
	      	$client = new Client(
	            '81l2aflu70xgnc',
	            'xL3DGbcrKCB5h60q'
	        );
	      	$linkedin_access_token = $linkedin_data['access_token'];
	      	$getExpiresAt = $linkedin_data['getExpiresAt'];
	      	$company_id = $linkedin_data['linkedin_company_id'];

		    $access_token = new AccessToken($linkedin_access_token,$getExpiresAt);
		    $client->setAccessToken($access_token);

		    if (isset($_POST['req_type']) && !empty($_POST['req_type'] == 'linkedin_pagination')) {
				$offset = $this->input->post('offset');
				if (empty($offset)) {
					$offset = 0;
				}
				$company_data = $client->get('companies/'.$company_id.'/updates?start='.$offset.'&count=10&format=json');
		    	$linkedin_company_share_data = $company_data;
			}
			if (!empty($linkedin_company_share_data['values'])) { $i = 1; foreach ($linkedin_company_share_data['values'] as $value) { 
                    $updateContent = $value['updateContent'];
                    if (!empty($updateContent)) {
                        $message = $updateContent['companyStatusUpdate']['share']['comment'];
                        $media_link = $updateContent['companyStatusUpdate']['share']['content']['submittedImageUrl'];
                        $time = $updateContent['companyStatusUpdate']['share']['timestamp'];
                    }
                    $comments = $value['updateComments']['_total'];
                    $likes_count = $value['numLikes'];
                    $is_self_liked = $value['likes'];
                    $updateKey_og = $value['updateKey'];
                    $updateKey = explode("-", $updateKey_og);
                    $id = $updateKey[2];
                    $str_id = '`'.$id.'`';
					$html = '<div class="feed-post">
                        <div style="float: right;"></div>';
                    if(!empty($message)){
                    $html .= '<div class="feed-post-text">'.$message.'</div>';
                	}if (!empty($media_link)) {
                	$html .= '<div class="feed-post-image"><img src="'.$media_link.'"></div>';
                    }
                    $html .= '<div class="feed-post-metrics"><span id="'.$id.'" >';
                    if(!empty($is_self_liked)) {
                    $html .= '<img src="'.base_url().'cms-assets/img/Liked Icon.png" style="width: 17px;">';
                    }else{
                    $html .= '<img src="'.base_url().'cms-assets/img/Likes Icon 02.png" style="width: 17px;">';
                    }
                    $html .= '<span id="likes_count_'.$id.'">'.$likes_count.'</span></span><span><img src="'.base_url().'cms-assets/img/Comment Icon.png" style="width: 17px;">'.$comments.'</span></div></div>';
                    $new_html[] = $html;
               		$status = 'success';
                    $i++;
				}
			}else{
	           	$html .= '<div class="feed-post no-data"> No Data Available. </div>';
	            $status = 'fail';
            }
		    $new_html = implode("", $new_html);
            $data_json = array('status' => $status, 'result' => $new_html);
            echo json_encode($data_json);
		}else{
			$html .= '<div class="feed-post no-data"> No Data Available. </div>';
			$data_json = array('status' => 'fail', 'result' => $html);
            echo json_encode($data_json);
		}

	}

	function sentiment(){
		$textapi = new AYLIEN\TextAPI("d94fcc98", "3f66e8201e1cc75698967e46721ea9fb");
		if (isset($_POST) && !empty($_POST)) {
			$social_text = $this->input->post('social_text');
			$sentiment = $textapi->Sentiment(array(
		    'text' => $social_text
			));

			$entities = $textapi->Entities(array(
			    'text' => $social_text
			));
			$sentiment = (array) $sentiment;
			foreach ($sentiment as $key => $value) {
				if ($key == 'polarity_confidence' || $key == 'subjectivity_confidence') {
					if ($value == 1) {
						$sentiment[$key] = $value;
					}else{
						$val = $value;
						$val = explode(".", $val);
						$tmp_val = str_split($val[1], 2);
						$org_val = $val[0].'.'.$tmp_val[0];
						$sentiment[$key] = $org_val;
					}
				}else{
					$sentiment[$key] = $value;
				}
			}
			$data['sentiment'] = $sentiment;
			$data['entities'] = (array) $entities;
			echo json_encode($data);
		}
		
	}

	function hit_likes(){
		$social_data = $this->pro->social_integration_data();
		$facebook_data = $social_data['facebook_data'];
		$twitter_data = $social_data['twitter_data'];
		$linkedin_data = $social_data['linkedin_data'];
		if (isset($_POST['req_type_twitter']) && !empty($_POST['tweet_id'])) {
			// facebook data fetching over here
			$tweet_id = $this->input->post('tweet_id');
			if (!empty($twitter_data)) {

			    $consumerKey = 'yJxJ8QRAESmzSDCJxsRYuSqUO';
			    $consumerSecret = '0bJAdQe2oE9jtkzhfZOsKtNYVPCklg3UiZDTjUdqcG5EPOfulu';
			    
			    $access_token = $twitter_data['access_token'];
			    $access_token_secret = $twitter_data['access_token_secret'];
			    $username = $twitter_data['username'];
			    $connection = new TwitterOAuth($consumerKey, $consumerSecret, $access_token, $access_token_secret);
			
			    $settings = array(
			        'oauth_access_token' => $access_token,
			        'oauth_access_token_secret' => $access_token_secret,
			        'consumer_key' => $consumerKey,
			        'consumer_secret' => $consumerSecret
			    );
			    $twitter = new TwitterAPIExchange($settings);

			    $url = "https://api.twitter.com/1.1/favorites/create.json";
		        $method = "POST";
		        $getfield = '?id='.$tweet_id;
		        $json = $twitter
		                    ->setGetfield($getfield)
		                    ->buildOauth($url, $method)
		                    ->performRequest();
		        // Result is a json string
		        $res = json_decode($json, true);
			    //$status = $connection->get("users/show");

		        echo print_r($res);
		    }
		}else if (isset($_POST['req_type_fb']) && !empty($_POST['fb_post_id'])) {
			$fb_post_id = $this->input->post('fb_post_id');
			$fb_action = $this->input->post('fb_action');
			$fb = new Facebook\Facebook([
		        'app_id' => '1459174307464450', // Replace {app-id} with your app id
		        'app_secret' => '5be12280339255f88646dc2804cdb7c6',
		        'default_graph_version' => 'v2.2',
		    ]);
			$facebook_company_page = $facebook_data['facebook_company_id'];
			$fb_company_details = unserialize($facebook_data['facebook_company_list']);
			foreach ($fb_company_details as $value) {
				if ($facebook_company_page == $value['id']) {
					$fb_page_access_token = $value['access_token'];
				}
			}
			$fb_access_token = $facebook_data['access_token'];

			if ($fb_action == 'like') {
				try {
				  // Returns a `Facebook\FacebookResponse` object
				  $response = $fb->post(
				    ''.$fb_post_id.'/likes',
				    array (),
				    $fb_page_access_token
				  );
				} catch(Facebook\Exceptions\FacebookResponseException $e) {
				  echo 'Graph returned an error: ' . $e->getMessage();
				  exit;
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
				  echo 'Facebook SDK returned an error: ' . $e->getMessage();
				  exit;
				}
				$graphNode = $response->getGraphNode();
				$message = $graphNode->asArray();
				$message = (array) $message;
				$up_d = array('success' => true, 'status' => 'like', 'message' => $message);
				echo json_encode($up_d);
			}
			if($fb_action == 'unlike'){
				try {
				  // Returns a `Facebook\FacebookResponse` object
				  $response = $fb->delete(
				    '/'.$fb_post_id.'/likes',
				    array (),
				    $fb_page_access_token
				  );
				} catch(Facebook\Exceptions\FacebookResponseException $e) {
				  echo 'Graph returned an error: ' . $e->getMessage();
				  exit;
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
				  echo 'Facebook SDK returned an error: ' . $e->getMessage();
				  exit;
				}
				$graphNode = $response->getGraphNode();
				$message = $graphNode->asArray();
				$message = (array) $message;
				$up_d = array('success' => true, 'status' => 'unlike', 'message' => $message);
				echo json_encode($up_d);
			}
			
		}
		if (!empty($_POST['req_type'] == 'linkedin_action') && isset($_POST['req_type'])) {
			if (!empty($linkedin_data)) {
				$post_id = $this->input->post('post_id');
				$social_action = $this->input->post('social_action');
		      	$client = new Client(
		            '81l2aflu70xgnc',
		            'xL3DGbcrKCB5h60q'
		        );
		      	
		      	$linkedin_access_token = $linkedin_data['access_token'];
		      	$getExpiresAt = $linkedin_data['getExpiresAt'];
		      	$company_id = $linkedin_data['linkedin_company_id'];

			    $access_token = new AccessToken($linkedin_access_token,$getExpiresAt);
			    $client->setAccessToken($access_token);

			    // Company Data 
			    $company_like = $client->post('companies/'.$company_id.'/updates/key='.$post_id.'/likes?format=json');
			    echo json_encode($company_like);
			}
		}
	}

	function hit_comment(){
		if (isset($_POST['req_type']) && !empty($_POST['req_type'] == 'facebook_comment')) {
			$post_id = $this->input->post('post_id');
			$facebook_page_id = explode("_", $post_id);
			$facebook_page_id = $facebook_page_id[0];
			$comment = $this->input->post('comment');
			$comments =  array('message' => $comment);
			$social_data = $this->pro->social_integration_data();
			$facebook_data = $social_data['facebook_data'];
			$fb = new Facebook\Facebook([
		        'app_id' => '1459174307464450', // Replace {app-id} with your app id
		        'app_secret' => '5be12280339255f88646dc2804cdb7c6',
		        'default_graph_version' => 'v2.2',
		    ]);
			$fb_company_details = unserialize($facebook_data['facebook_company_list']);
			foreach ($fb_company_details as $value) {
				if ($facebook_page_id == $value['id']) {
					$fb_page_access_token = $value['access_token'];
				}
			}
	      	
	      	try {
			  // Returns a `Facebook\FacebookResponse` object
			  $response = $fb->post('/'.$post_id.'/comments', $comments, $fb_page_access_token);

			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  echo 'Graph returned an error: ' . $e->getMessage();
			  exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  exit;
			}
			$graphNode = $response->getGraphNode();
			$message = $graphNode->asArray();
			$message = (array) $message;
			$up_d = array('success' => true, 'status' => 'comment', 'message' => $message);
			echo json_encode($up_d);
		}
	}

	function social_delete_post(){
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		$social_data = $this->pro->social_integration_data();
		$facebook_data = $social_data['facebook_data'];
		if (!empty($facebook_data)) {
			$fb_post_id = $this->input->post('fb_post_id');

			$fb = new Facebook\Facebook([
		        'app_id' => '1459174307464450', // Replace {app-id} with your app id
		        'app_secret' => '5be12280339255f88646dc2804cdb7c6',
		        'default_graph_version' => 'v2.2',
		    ]);
			$facebook_company_page = $facebook_data['facebook_company_id'];
			$fb_company_details = unserialize($facebook_data['facebook_company_list']);
			foreach ($fb_company_details as $value) {
				if ($facebook_company_page == $value['id']) {
					$fb_page_access_token = $value['access_token'];
				}
			}
			$fb_access_token = $facebook_data['access_token'];

				try {
				  // Returns a `Facebook\FacebookResponse` object
				  $response = $fb->delete(
				    ''.$fb_post_id.'',
				    array (),
				    $fb_page_access_token
				  );
				} catch(Facebook\Exceptions\FacebookResponseException $e) {
				  echo 'Graph returned an error: ' . $e->getMessage();
				  exit;
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
				  echo 'Facebook SDK returned an error: ' . $e->getMessage();
				  exit;
				}
				$graphNode = $response->getGraphNode();
		}
		echo json_encode($graphNode);
		//echo "<pre>";print_r($graphNode);die;
	}


}

?>