<?php
/**
 *
 * @package    FacebookAuth
 * @author     Vinil Lakkavatri (vinil.lakkavatri@icloud.com)
 * @copyright  2017 Vinil Lakkavatri
 * @company    FiHavock Digital Pvt Ltd
 * @ci_version 3.1.2 echo CI_VERSION;
 * @deprecated File deprecated in Release 2.0.0
 *
 **/
include_once $_SERVER['DOCUMENT_ROOT'].'/vendor/fb-test/src/Facebook/autoload.php';
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\Entities\AccessToken;
use Facebook\HttpClients\FacebookCurlHttpClient;
use Facebook\HttpClients\FacebookHttpable;
class FacebookAuth extends CI_Controller
{
	
	function __construct(){
		
		parent::__construct();
        error_reporting(0);
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Common_model', 'admin');
        $this->company_id = $this->session->userdata('marketing_company_id');
		
	}

	function facebook_sign_in(){
		
		$userData = array();
		$fb = new Facebook\Facebook([
		  'app_id' => '1459174307464450', // Replace {app-id} with your app id
		  'app_secret' => '5be12280339255f88646dc2804cdb7c6',
		  'default_graph_version' => 'v2.2',
		]);
		$oauthURL = site_url().'FacebookAuth/facebook_sign_in';
		
		if (isset($_GET['code']) && isset($_GET['state'])) {
		    $helper = $fb->getRedirectLoginHelper();
		    try {
		        $accessToken = $helper->getAccessToken();
		   	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		        // When Graph returns an error
		        echo 'Graph returned an error: ' . $e->getMessage();
		        exit;
		    } catch(Facebook\Exceptions\FacebookSDKException $e) {
		        // When validation fails or other local issues
		        echo 'Facebook SDK returned an error: ' . $e->getMessage();
		        exit;
		    }
		    if (isset($accessToken)) {
		        // Logged in!
		        $_SESSION['facebook_access_token'] = (string) $accessToken;
		    }

			$oAuth2Client = $fb->getOAuth2Client();
			// Get the access token metadata from /debug_token
			$tokenMetadata = $oAuth2Client->debugToken($accessToken);
			$tokenMetadata->validateAppId('1459174307464450'); // Replace {app-id} with your app id
			$tokenMetadata->validateExpiration();
			if (! $accessToken->isLongLived()) {
			  // Exchanges a short-lived access token for a long-lived one
			  try {
			    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
			  }catch (Facebook\Exceptions\FacebookSDKException $e) {
			    echo "<p>Error getting long-lived access token: " . $helper->getMessage() . "</p>\n\n";
			    exit;
			  }
			  // Long-lived accessToken
			  $accessToken = $accessToken->getValue();
			}

			try {
			  // Returns a `Facebook\FacebookResponse` object
			  $response = $fb->get('/me?fields=id,name,first_name,last_name,email,locale,picture', $accessToken);
			  $status = 1;
			} catch(Facebook\Exceptions\FacebookResponseException $e) {
			  //echo 'Graph returned an error: ' . $e->getMessage();
			  $this->session->set_flashdata('message','Facebook SDK Exceptions Occurred!');
			  redirect('Dashboard/integration?status=fb_exception');
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
			  //echo 'Facebook SDK returned an error: ' . $e->getMessage();
			  $this->session->set_flashdata('message','Facebook SDK Exceptions Occurred!');
			  redirect('Dashboard/integration?status=fb_exception'); 
			}
			$userProfile = $response->getGraphUser();
			 
			// Fetch Facebook Company Pages
			try {
			  // Returns a `FacebookFacebookResponse` object
			  $response = $fb->get('/me/accounts', $accessToken);
			} catch(FacebookExceptionsFacebookResponseException $e) {
				$this->session->set_flashdata('message','Facebook Company Page Exception Occurred!');
				redirect('Dashboard/integration?status=page_accounts_fb_exception');
			    exit;
			} catch(FacebookExceptionsFacebookSDKException $e) {
				$this->session->set_flashdata('message','Facebook Company Page Exception Occurred!');
			    redirect('Dashboard/integration?status=fb_page_sdk_exception');
			    exit;
			}

			$profile_pages = $response->getGraphEdge();
			$fb_user_profile_pages = $profile_pages->asArray();
			$fb_user_profile_pages = serialize($fb_user_profile_pages);

			// fetch facebook groups of user profile
			try {
			  // Returns a `Facebook\FacebookResponse` object
			  $response = $fb->get('/me/groups',$accessToken);

			} catch(Facebook\Exceptions\FacebookResponseException $e) {
				$this->session->set_flashdata('message','Facebook Group Exception Occurred!');
			    redirect('Dashboard/integration?status=groups_sdk_exception');
			    exit;
			} catch(Facebook\Exceptions\FacebookSDKException $e) {
				$this->session->set_flashdata('message','Facebook Group Exception Occurred!');
			    redirect('Dashboard/integration?status=fb_groups_sdk_exception');
			    exit;
			}
			$graphNode = $response->getGraphEdge();
			$fb_groups = $graphNode->asArray();
			//echo "<pre>";print_r($fb_groups);die;
			
			if (!empty($fb_groups)) {
				$userData = array(
					'oauth_provider' => 'facebook',
					'oauth_uid' => $userProfile['id'],
					'access_token' => $accessToken,
					'username' => $userProfile['name'],
					'first_name' => $userProfile['first_name'],
					'last_name' => $userProfile['last_name'],
					'locale' => $userProfile['locale'],
					'profile_url' => $userProfile['picture']['url'],
					'company_id' => $this->company_id,
					'fb_groups_list' => serialize($fb_groups),
					'facebook_company_list' => $fb_user_profile_pages
				);
			}else{
				$userData = array(
					'oauth_provider' => 'facebook',
					'oauth_uid' => $userProfile['id'],
					'access_token' => $accessToken,
					'username' => $userProfile['name'],
					'first_name' => $userProfile['first_name'],
					'last_name' => $userProfile['last_name'],
					'locale' => $userProfile['locale'],
					'profile_url' => $userProfile['picture']['url'],
					'company_id' => $this->company_id,
					'facebook_company_list' => $fb_user_profile_pages
				);
			}
			$userID = $this->admin->insert_into_table('marketing_social_integration',$userData);
			$this->session->set_flashdata('message','Successfully Integrated with Facebook!');
		    redirect('Dashboard/integration');

		}else if(isset($_GET['error']) && isset($_GET['error_code'])){
			$this->session->set_flashdata('message','Facebook Authentication Denied!');
			redirect('Dashboard/integration');
			
		}else{
		    // Well looks like we are a fresh dude, login to Facebook!
		    $helper = $fb->getRedirectLoginHelper();
		    $permissions = ['email','publish_actions','manage_pages','publish_pages','user_friends','user_managed_groups'];
		    $loginUrl = $helper->getLoginUrl($oauthURL, $permissions);
		    $data['oauthURL'] = $loginUrl;
		}

        // Load login & profile view
        $this->load->view('facebook/facebook_sign_in',$data);
	}

	function facebook_remove_credentials(){
		if (isset($_POST) && !empty($_POST)) {
			$this->session->set_flashdata('message','Successfully Revoke Facebook!');
			$whr_in_cond = '(company_id = '.$this->company_id.' AND oauth_provider = "facebook")';
			$social_board = $this->admin->delete_into_table_with_multiple_condition('marketing_social_integration',$whr_in_cond);
		}
	}


}

?>