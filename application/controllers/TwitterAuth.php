<?php
/**
 *
 * @package    TwitterAuth
 * @author     Vinil Lakkavatri (vinil.lakkavatri@icloud.com)
 * @copyright  2017 Vinil Lakkavatri
 * @company    FiHavock Digital Pvt Ltd
 * @ci_version 3.1.2 echo CI_VERSION;
 * @deprecated File deprecated in Release 2.0.0
 *
 **/
include_once $_SERVER['DOCUMENT_ROOT']."/vendor/twitter-oauth-php-codexworld/twitteroauth.php";
include_once $_SERVER['DOCUMENT_ROOT']."/vendor/twitter-oauth-php-codexworld/TwitterAPIExchange.php";
class TwitterAuth extends CI_Controller
{
	
	function __construct(){
		
		parent::__construct();
        error_reporting(0);
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Common_model', 'admin');
        $this->company_id = $this->session->userdata('marketing_company_id');
		
	}

	function twitter_sign_in(){

    	$consumerKey = 'yJxJ8QRAESmzSDCJxsRYuSqUO';
		$consumerSecret = '0bJAdQe2oE9jtkzhfZOsKtNYVPCklg3UiZDTjUdqcG5EPOfulu';
		$oauthCallback = site_url().'TwitterAuth/twitter_sign_in/';
		$sessToken = $this->session->userdata('token');
		$sessTokenSecret = $this->session->userdata('token_secret');
		//Get status and user info from session
		$sessStatus = $this->session->userdata('status');
		$sessUserData = $this->session->userdata('userData');
		$userData = $sessUserData;
		if(isset($_GET['oauth_token']) && $sessToken == $_GET['oauth_token']){
				//Successful response returns oauth_token, oauth_token_secret, user_id, and screen_name
				$connection = new TwitterOAuth($consumerKey, $consumerSecret, $sessToken, $sessTokenSecret); //print_r($connection);die;
				$accessToken = $connection->getAccessToken($_GET['oauth_verifier']);
				if($connection->http_code == '200'){
					//Get user profile info
					$userInfo = $connection->get('account/verify_credentials');
					//echo "<pre>";print_r($accessToken);die;
					//Preparing data for database insertion
					$name = explode(" ",$userInfo->name);
					$first_name = isset($name[0])?$name[0]:'';
					$last_name = isset($name[1])?$name[1]:'';
					$userData = array(
						'oauth_provider' => 'twitter',
						'oauth_uid' => $userInfo->id,
						'access_token' => $accessToken['oauth_token'],
						'access_token_secret' => $accessToken['oauth_token_secret'],
						'username' => $userInfo->screen_name,
						'first_name' => $first_name,
						'last_name' => $last_name,
						'locale' => $userInfo->lang,
						'profile_url' => 'https://twitter.com/'.$userInfo->screen_name,
						'company_id' => $this->company_id,
						'picture_url' => $userInfo->profile_image_url
					);
					//echo "<pre>";print_r($userData);die;
					//Insert or update user data
					$userID = $this->admin->insert_into_table('TwitterAuth_social_integration',$userData);
					$this->session->set_flashdata('message','Successfully Integrated with Twitter!');
					//Store status and user profile info into session
					$userData['accessToken'] = $accessToken;
					$this->session->set_userdata('status','verified');
					$this->session->set_userdata('userData',$userData);
				}else{
					$data['error_msg'] = 'Some problem occurred, please try again later!';
					$this->session->set_flashdata('message','Some problem occurred, please try again later!');
				}
			
			redirect('Dashboard/integration');
		}elseif(isset($_GET['denied'])){
			$this->session->set_flashdata('message','Twitter Authentication Denied!');
			redirect('Dashboard/integration');
		}else{
			$connection = new TwitterOAuth($consumerKey, $consumerSecret);
			$requestToken = $connection->getRequestToken($oauthCallback);
			echo "<pre>";print_r($connection);
			echo "<pre>";print_r($requestToken);die;
			//Received token info from twitter
			$this->session->set_userdata('token',$requestToken['oauth_token']);
			$this->session->set_userdata('token_secret',$requestToken['oauth_token_secret']);
			
			//Any value other than 200 is failure, so continue only if http code is 200
			if($connection->http_code == '200'){
				//redirect user to twitter
				$twitterUrl = $connection->getAuthorizeURL($requestToken['oauth_token']);
				$data['oauthURL'] = $twitterUrl;
			}else{
				$data['oauthURL'] = base_url().'twitter_sign_in';
				$data['error_msg'] = 'Error connecting to twitter! try again later!';
			}
		}
		$data['userData'] = $userData;
		//echo "<pre>";print_r($data);die;

		$this->load->view('twitter/twitter_sign_in',$data);
	}

	function twitter_remove_credentials(){
		if (isset($_POST) && !empty($_POST)) {
			$this->session->set_flashdata('message','Successfully Revoke Twitter!');
			$whr_in_cond = '(company_id = '.$this->company_id.' AND oauth_provider = "twitter")';
			$social_board = $this->admin->delete_into_table_with_multiple_condition('marketing_social_integration',$whr_in_cond);
		}
	}


}

?>