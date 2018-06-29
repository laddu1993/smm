<?php
/**
 *
 * @package    Dashboard
 * @author     Vinil Lakkavatri (vinil.lakkavatri@icloud.com)
 * @copyright  2017 Vinil Lakkavatri
 * @company    FiHavock Digital Pvt Ltd
 * @ci_version 3.1.2 echo CI_VERSION;
 * @deprecated File deprecated in Release 2.0.0
 *
 **/
include_once $_SERVER['DOCUMENT_ROOT']."/vendor/twitter-oauth-php-codexworld/twitteroauth.php";
include_once $_SERVER['DOCUMENT_ROOT']."/vendor/twitter-oauth-php-codexworld/TwitterAPIExchange.php";
include_once $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";
include_once $_SERVER['DOCUMENT_ROOT'].'/vendor/fb-test/src/Facebook/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
//use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
use LinkedIn\Client;
use LinkedIn\Scope;
use LinkedIn\AccessToken;
class Dashboard extends CI_Controller
{
	
	function __construct(){
		
		parent::__construct();
        error_reporting(0);
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Common_model', 'admin');
        $this->company_id = $this->session->userdata('marketing_company_id');
        // Global variable declaration
	    if (!file_exists($_SERVER['DOCUMENT_ROOT']."/userfiles/clients/".$this->company_id)) {
		    mkdir($_SERVER['DOCUMENT_ROOT']."/userfiles/clients/".$this->company_id);
		    chmod($_SERVER['DOCUMENT_ROOT']."/userfiles/clients/".$this->company_id, 0777);
		}
		$actual_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]/userfiles/clients/".$this->company_id."/";
		$save_path = $_SERVER['DOCUMENT_ROOT']."/userfiles/clients/".$this->company_id."/";
		$this->global_data = array( 'save_path' => $save_path, 'actual_url' => $actual_url);
		
	}

	function index(){
		
		if (isset($_POST['req_type']) && !empty($_POST['req_type'])) {
			$twitter_whr = '(company_id = '.$this->company_id.')';
			$social_data = $this->admin->fetch_all_table_data_multiple_condition('marketing_social_integration',$twitter_whr);
			foreach ($social_data as $value) {
				if ($value['oauth_provider'] == 'twitter') {
					$twitter_data['access_token'] = $value['access_token'];
					$twitter_data['access_token_secret'] = $value['access_token_secret'];
					$twitter_data['username'] = $value['username'];
				}
				if ($value['oauth_provider'] == 'linkedin') {
					$linkedin_data['access_token'] = $value['access_token'];
					$linkedin_data['getExpiresAt'] = $value['getExpiresAt'];
					$linkedin_data['linkedin_company_id'] = $value['linkedin_company_id'];
				}
				if ($value['oauth_provider'] == 'facebook') {
					$facebook_data['access_token'] = $value['access_token'];
					$facebook_data['facebook_company_id'] = $value['facebook_company_id'];
					$facebook_data['facebook_company_list'] = $value['facebook_company_list'];
				}
			}
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
		        $res = json_decode($json, true);

		        $data['twitter_user_profile'] = $res;
		    }
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
				try {
				  // Returns a `Facebook\FacebookResponse` object
				  $response = $fb->get('/'.$facebook_company_page.'?fields=fan_count,link,name,new_like_count,talking_about_count,unread_message_count,can_post,posts',$fb_page_access_token);

				} catch(Facebook\Exceptions\FacebookResponseException $e) {
				  echo 'Graph returned an error: ' . $e->getMessage();
				  //continue;
				} catch(Facebook\Exceptions\FacebookSDKException $e) {
				  echo 'Facebook SDK returned an error: ' . $e->getMessage();
				  //exit;
				}
				$user_timeline = $response->getGraphNode();
				$user_feeds = $user_timeline->asArray();
				$facebook_page_summary = $user_feeds;
				$data['facebook_page_summary'] = $facebook_page_summary;
			}
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

			    // Profile Data
			    $profile = $client->get('people/~:(id,firstName,lastName,pictureUrls::(original),headline,publicProfileUrl,location,industry,positions,email-address)');

			    $followers = $client->get('companies/'.$company_id.'/num-followers?format=json');

			    $data['linkedin_followers'] = $followers;
			}

			$twitter_whr = '(company_id = '.$this->company_id.')';
			$data['marketing_social_board'] = current($this->admin->fetch_all_table_data_multiple_condition('marketing_social_board',$twitter_whr,'added_date','DESC'));
			$today = date('Y-m-d h:i:s');
			$twitter_whr = '(company_id = '.$this->company_id.' AND is_scheduled = 1 AND is_scheduled_date > "'.$today.'")';
			$data['scheduled_social_board'] = current($this->admin->fetch_all_table_data_multiple_condition('marketing_social_board',$twitter_whr,'added_date','DESC'));
			echo '<script src="'.base_url().'/cms-assets/vendor/jquery/dist/jquery.js"></script>
				<script src="'.base_url().'/cms-assets/vendor/bootstrap/dist/js/bootstrap.js"></script>';
		
		}
		if (!empty($data)) {
			$this->load->view('dashboard/dashboard',$data);
			$this->load->view('dashboard/footer');
		}else{
			$this->load->view('dashboard/header');
			$this->load->view('dashboard/dashboard');
			$this->load->view('dashboard/footer');
		}
	}

	function integration(){

		if (isset($_POST) && !empty($_POST)) {
			
			$linkedin_company_list = $this->input->post('linkedin_company_list');
			$linkedin_company_id = $this->input->post('linkedin_company_id');
			if (!empty($linkedin_company_id)) {
				$up_linkedin_data['linkedin_company_id'] = $linkedin_company_id;
				$whr_in_cond = '(company_id = '.$this->company_id.' AND oauth_provider = "linkedin")';
				$linkedin_update_credentials = $this->admin->update_into_table_with_multiple_condition('marketing_social_integration',$whr_in_cond,$up_linkedin_data);
			}
			
			$facebook_company_page = $this->input->post('facebook_company_page');
			$fb_groups_selected = $this->input->post('fb_groups_selected');
			if (!empty($facebook_company_page) || !empty($fb_groups_list)) {
				$up_data['facebook_company_id'] = $facebook_company_page;
				if (!empty($fb_groups_selected)) {
					$up_data['fb_groups_selected'] = implode(",", $fb_groups_selected);
				}
				$whr_in_cond = '(company_id = '.$this->company_id.' AND oauth_provider = "facebook")';
				$facebook_update_credentials = $this->admin->update_into_table_with_multiple_condition('marketing_social_integration',$whr_in_cond,$up_data);
			}
			redirect("Dashboard/integration");
			
		}
		$twitter_whr = '(company_id = '.$this->company_id.' AND oauth_provider = "twitter")';
		$data['twitter_data'] = current($this->admin->fetch_all_table_data_multiple_condition('marketing_social_integration',$twitter_whr));
		$twitter_whr = '(company_id = '.$this->company_id.' AND oauth_provider = "linkedin")';
		$data['linkedin_data'] = current($this->admin->fetch_all_table_data_multiple_condition('marketing_social_integration',$twitter_whr));
		$twitter_whr = '(company_id = '.$this->company_id.' AND oauth_provider = "facebook")';
		$data['facebook_data'] = current($this->admin->fetch_all_table_data_multiple_condition('marketing_social_integration',$twitter_whr));
		$twitter_whr = '(company_id = '.$this->company_id.' AND oauth_provider = "instagram")';
		$data['instagram_data'] = current($this->admin->fetch_all_table_data_multiple_condition('marketing_social_integration',$twitter_whr));
		$twitter_whr = '(company_id = '.$this->company_id.' AND oauth_provider = "google")';
		$data['google_plus_data'] = current($this->admin->fetch_all_table_data_multiple_condition('marketing_social_integration',$twitter_whr));
		//echo "<pre>";print_r($data);die;
		
		$this->load->view('dashboard/header',$data);
		$this->load->view('dashboard/integration',$data);
		$this->load->view('dashboard/footer');
	}


}

?>