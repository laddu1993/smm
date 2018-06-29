<?php
/**
 *
 * @package    LinkedInAuth
 * @author     Vinil Lakkavatri (vinil.lakkavatri@icloud.com)
 * @copyright  2017 Vinil Lakkavatri
 * @company    FiHavock Digital Pvt Ltd
 * @ci_version 3.1.2 echo CI_VERSION;
 * @deprecated File deprecated in Release 2.0.0
 *
 **/
include_once $_SERVER['DOCUMENT_ROOT']."/vendor/autoload.php";
use LinkedIn\Client;
use LinkedIn\Scope;
use LinkedIn\AccessToken;
class LinkedInAuth extends CI_Controller
{
	
	function __construct(){
		
		parent::__construct();
        error_reporting(0);
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Common_model', 'admin');
        $this->company_id = $this->session->userdata('marketing_company_id');
		
	}

	function linkedin_sign_in(){
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		$Client_ID = '81l2aflu70xgnc';
		$Client_Secret = 'xL3DGbcrKCB5h60q';
		$callback_url = site_url().'LinkedInAuth/linkedin_sign_in';
		$client = new Client(
		    getenv('81l2aflu70xgnc'),
		    getenv('xL3DGbcrKCB5h60q')
		);
		if (isset($_GET['code']) && isset($_GET['state'])) { 
				// we are returning back from LinkedIn with the code
		        try {
		            // you have to set initially used redirect url to be able
		            // to retrieve access token
		            $client->setRedirectUrl($callback_url);
		            // retrieve access token using code provided by LinkedIn
		            $accessToken = $client->getAccessToken($_GET['code']);

		            $access_token = $accessToken->getToken();

		            $getExpiresAt = $accessToken->getExpiresAt();
		            
		            $profile = $client->get(
		                'people/~:(id,firstName,lastName,pictureUrls::(original),headline,publicProfileUrl,location,industry,positions,email-address)'
		            );

		            $company = $client->get(
		                'companies',
		                ['format' => 'json', 'is-company-admin' => 'true']
		            );
		            
		            $profile['linkedin_company_list'] = serialize($company['values']);
		            $_SESSION['linkedin_access_token'] = $access_token;
		            $userData = array(
					'oauth_provider' => 'linkedin',
					'oauth_uid' => $profile['id'],
					'access_token' => $access_token,
					'getExpiresAt' => $getExpiresAt,
					'linkedin_company_list' => $profile['linkedin_company_list'],
					'email' => $profile['emailAddress'],
					'first_name' => $profile['firstName'],
					'last_name' => $profile['lastName'],
					'profile_url' => $profile['pictureUrls']['values'][0],
					'company_id' => $this->company_id,
					'picture_url' => $profile['publicProfileUrl']
					);
					$userID = $this->admin->insert_into_table('marketing_social_integration',$userData);
					$this->session->set_flashdata('message','Successfully Integrated with LinkedIn!');
		            redirect('Dashboard/integration?status=success&req_type=linkedin');	
		        } catch (\LinkedIn\Exception $exception) {
		            // in case of failure, provide with details
		            $this->session->set_flashdata('message','Some problem occurred, please try again later!');
		            redirect('Dashboard/integration');		        
		        }

		}elseif (isset($_GET['error'])) {
			$this->session->set_flashdata('message','LinkedIn Authentication Denied!');
		    redirect('Dashboard/integration?status=error');
		}else {
		    // define desired list of scopes
		    /*$data['Client_ID'] = '81l2aflu70xgnc';
			$data['callback_url'] = site_url().'Admin/linkedin_sign_in';*/
			$scopes = Scope::getValues();
		    $data['loginUrl'] = $client->getLoginUrl($scopes); // get url on LinkedIn to start linking
		    $_SESSION['linkedin_state'] = $client->getState(); // save state for future validation
		    $_SESSION['linkedin_redirect_url'] = $client->getRedirectUrl();
		}

		$this->load->view('linkedin/linkedin_sign_in',$data);
	}

	function linkedin_remove_credentials(){
		if (isset($_POST) && !empty($_POST)) {
			$this->session->set_flashdata('message','Successfully Revoke Linkedin!');
			$whr_in_cond = '(company_id = '.$this->company_id.' AND oauth_provider = "linkedin")';
			$social_board = $this->admin->delete_into_table_with_multiple_condition('marketing_social_integration',$whr_in_cond);
		}
	}


}

?>