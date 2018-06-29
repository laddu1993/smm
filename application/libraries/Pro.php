<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
/**
 *
 * @package    Pro Social Integration & Third Parties
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
class Pro {

var $CI;

function __construct()
{
    $CI =& get_instance();
    $CI->load->model('Common_model','admin');
    $CI->load->helper('url');
    $CI->load->library('session');
    $CI->config->item('base_url');
    
}

  function is_logged_in(){
      if (!isset($_SESSION['marketing_company_id']) && empty($_SESSION['marketing_company_id'])) {
          redirect('Login/index');
      }
  }

  function social_integration_data(){
      $CI =& get_instance();
      $CI->load->model('common_model');
      $twitter_whr = '(company_id = '.$_SESSION['marketing_company_id'].')';
      $social_data = $CI->common_model->fetch_all_table_data_multiple_condition('marketing_social_integration',$twitter_whr);
      foreach ($social_data as $value) {
        if ($value['oauth_provider'] == 'twitter') {
            $data['twitter_data']['access_token'] = $value['access_token'];
            $data['twitter_data']['access_token_secret'] = $value['access_token_secret'];
            $data['twitter_data']['username'] = $value['username'];
        }
        if ($value['oauth_provider'] == 'linkedin') {
            $data['linkedin_data']['access_token'] = $value['access_token'];
            $data['linkedin_data']['getExpiresAt'] = $value['getExpiresAt'];
            $data['linkedin_data']['linkedin_company_id'] = $value['linkedin_company_id'];
        }
        if ($value['oauth_provider'] == 'facebook') {
            $data['facebook_data']['access_token'] = $value['access_token'];
            $data['facebook_data']['facebook_company_id'] = $value['facebook_company_id'];
            $data['facebook_data']['facebook_company_list'] = $value['facebook_company_list'];
        }
      }
    return $data;
  }

  // twitter integration post
  function twitter_post($access_token,$access_token_secret,$description='',$image_name=''){
      
      $consumerKey = 'yJxJ8QRAESmzSDCJxsRYuSqUO';
      $consumerSecret = '0bJAdQe2oE9jtkzhfZOsKtNYVPCklg3UiZDTjUdqcG5EPOfulu';
      $connection = new TwitterOAuth($consumerKey, $consumerSecret, $access_token, $access_token_secret);
        /* For Twitter Image Upload */
        $settings = array(
        'oauth_access_token' => $access_token,
        'oauth_access_token_secret' => $access_token_secret,
        'consumer_key' => $consumerKey,
        'consumer_secret' => $consumerSecret
        );
        $twitter = new TwitterAPIExchange($settings);
        $url = "https://upload.twitter.com/1.1/media/upload.json";
        $method = "POST";
        if (!empty($image_name)) {
            $params = array(
            "media" =>  base64_encode($image_name),
          );
          $json = $twitter
                      ->setPostfields($params)
                      ->buildOauth($url, $method)
                      ->performRequest();
          // Result is a json string
          $res = json_decode($json);
          $med_id = $res->media_id_string;
          $data['twid'] = $med_id;
        }
        
        /* Media or Image String ends over here */
        //var_dump($med_id);die;
        /* Image and Description Will be uploaded from here for Twitter */
        if (!empty($description) && !empty($image_name)) {
            $status = $connection->post(
            "statuses/update", [
                "status" => $description,
                "media_ids" =>$med_id
            ]
          );
          $twitter_id = $status->id;
        }else if (!empty($description) && empty($image_name)) {
          $med_id = '';
          $status = $connection->post(
            "statuses/update", [
                "status" => $description,
                "media_ids" =>$med_id
            ]
          );
          $twitter_id = $status->id;
        }else if (!empty($image_name)) {
            $twitter_id = $med_id;
        }

      return $twitter_id;
  }


  // facebook profile post
  function facebook_profile_post($fb_access_token,$description='',$image_name='',$actual_url){
   
      $fb = new Facebook\Facebook([
        'app_id' => '1459174307464450', // Replace {app-id} with your app id
        'app_secret' => '5be12280339255f88646dc2804cdb7c6',
        'default_graph_version' => 'v2.2',
      ]);
      if ($image_name == $actual_url) {
          $image_name = '';
      }

      if (!empty($fb_access_token)) {

        if (!empty($description) && empty($image_name)) {
          $linkData = [
            'message' => $description,
          ];

          try {
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->post('/me/feed', $linkData, $fb_access_token);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
          }
          $graphNode = $response->getGraphNode();
          $facebook_id = $graphNode['id'];
        }
        
        if (!empty($image_name)) {
            $fb_data = [
            'message' => $description,
            'source' => $fb->fileToUpload($image_name),
            ];
          
            try {
              $permissions = ['email','publish_actions'];
              // Returns a `Facebook\FacebookResponse` object
              $response = $fb->post('/me/photos', $fb_data, $fb_access_token, $permissions);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
            }
            // facebook photo id --> paramtere will id
            $graphNode = $response->getGraphNode();
            $facebook_id = $graphNode['id'];
        }
          
      }
      return $facebook_id;

  }

  // facebook page post
  function facebook_page_post($fb_access_token,$description='',$image_name='',$actual_url,$fb_page_id='',$fb_page_access_token=''){
     
      $fb = new Facebook\Facebook([
        'app_id' => '1459174307464450', // Replace {app-id} with your app id
        'app_secret' => '5be12280339255f88646dc2804cdb7c6',
        'default_graph_version' => 'v2.2',
      ]);
      if ($image_name == $actual_url) {
          $image_name = '';
      }
      if(!empty($fb_page_id)){

        if (!empty($description) && empty($image_name)) {
            $linkData = [
            'message' => $description,
            ];
            try {
              // Returns a `Facebook\FacebookResponse` object
              $response = $fb->post(
                '/'.$fb_page_id.'/feed',
                $linkData,
                $fb_page_access_token
              );
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
            }
            $facebook_company_post = $response->getGraphNode();
            $facebook_company_page_id = $facebook_company_post->asArray();
        }

          if (!empty($image_name)) {
            $fb_page_data = [
            'caption' => $description,
            'url' => $image_name,
            ];
            // Upload to your facebook company page
            try {
              // Returns a `Facebook\FacebookResponse` object
              $response = $fb->post(
                '/'.$fb_page_id.'/photos',
                $fb_page_data,
                $fb_page_access_token
              );
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
            }
            $facebook_company_post = $response->getGraphNode();
            $facebook_company_page_id = $facebook_company_post->asArray();
        }
    }

    return $facebook_company_page_id;

  }


  // facebook integration post
  function facebook_post($fb_access_token,$description='',$image_name='',$actual_url,$fb_page_id='',$fb_page_access_token='',$fb_groups_selected=''){
      
      $fb = new Facebook\Facebook([
        'app_id' => '1459174307464450', // Replace {app-id} with your app id
        'app_secret' => '5be12280339255f88646dc2804cdb7c6',
        'default_graph_version' => 'v2.2',
      ]);
      if ($image_name == $actual_url) {
          $image_name = '';
      }
      if (!empty($fb_access_token) && !empty($image_name)) {
          if (empty($description)) {
              $fb_data = [
              'message' => '',
              'source' => $fb->fileToUpload($image_name),
              ];
          }else{
              $fb_data = [
              'message' => $description,
              'source' => $fb->fileToUpload($image_name),
              ];
          }
          
          try {
            $permissions = ['email','publish_actions'];
            // Returns a `Facebook\FacebookResponse` object
            $response = $fb->post('/me/photos', $fb_data, $fb_access_token, $permissions);
          } catch(Facebook\Exceptions\FacebookResponseException $e) {
            echo 'Graph returned an error: ' . $e->getMessage();
            exit;
          } catch(Facebook\Exceptions\FacebookSDKException $e) {
            echo 'Facebook SDK returned an error: ' . $e->getMessage();
            exit;
          }
          // facebook photo id --> paramtere will id
          $graphNode = $response->getGraphNode();
          $facebook_id = $graphNode['id'];

          if(!empty($fb_page_id)){
              $fb_page_data = [
              'caption' => $description,
              'url' => $image_name,
              ];
                // Upload to your facebook company page
                try {
                  // Returns a `Facebook\FacebookResponse` object
                  $response = $fb->post(
                    '/'.$fb_page_id.'/photos',
                    $fb_page_data,
                    $fb_page_access_token
                  );
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                  echo 'Graph returned an error: ' . $e->getMessage();
                  exit;
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                  echo 'Facebook SDK returned an error: ' . $e->getMessage();
                  exit;
                }
                $facebook_company_post = $response->getGraphNode();
                $facebook_company_page_id = $facebook_company_post->asArray();
          }

      }else if (!empty($description)) {
          $linkData = [
            'link' => 'http://www.altcms.net',
            'message' => $description,
            ];

            try {
              // Returns a `Facebook\FacebookResponse` object
              $response = $fb->post('/me/feed', $linkData, $fb_access_token);
            } catch(Facebook\Exceptions\FacebookResponseException $e) {
              echo 'Graph returned an error: ' . $e->getMessage();
              exit;
            } catch(Facebook\Exceptions\FacebookSDKException $e) {
              echo 'Facebook SDK returned an error: ' . $e->getMessage();
              exit;
            }

            $graphNode = $response->getGraphNode();
            $facebook_id = $graphNode['id'];
            if(!empty($fb_page_id)){
                // Upload to your facebook company page
                try {
                  // Returns a `Facebook\FacebookResponse` object
                  $response = $fb->post(
                    '/'.$fb_page_id.'/feed',
                    $linkData,
                    $fb_page_access_token
                  );
                } catch(Facebook\Exceptions\FacebookResponseException $e) {
                  echo 'Graph returned an error: ' . $e->getMessage();
                  exit;
                } catch(Facebook\Exceptions\FacebookSDKException $e) {
                  echo 'Facebook SDK returned an error: ' . $e->getMessage();
                  exit;
                }
                $facebook_company_post = $response->getGraphNode();
                $facebook_company_page_id = $facebook_company_post->asArray();
          }

      }
      if (!empty($fb_groups_selected)) {
        $fb_groups_selected = explode(",", $fb_groups_selected);
        $linkData = array ('message' => $description,'link'  => $image_name );
          foreach ($fb_groups_selected as $value) {
              try {
                // Returns a `Facebook\FacebookResponse` object
                $response = $fb->post('/'.$value.'/feed',$linkData,$fb_access_token);

              } catch(Facebook\Exceptions\FacebookResponseException $e) {
                echo 'Graph returned an error: ' . $e->getMessage();
                exit;
              } catch(Facebook\Exceptions\FacebookSDKException $e) {
                echo 'Facebook SDK returned an error: ' . $e->getMessage();
                exit;
              }
              $graphNode = $response->getGraphNode();
          }
          
      }
      return $facebook_id;

  }

  // linkedin profile post
  function linkedin_profile_post($description='',$image_name='',$linkedin_access_token,$getExpiresAt){
      
      $client = new Client(
            '81l2aflu70xgnc',
            'xL3DGbcrKCB5h60q'
        );
      $access_token = new AccessToken($linkedin_access_token,$getExpiresAt);
      $client->setAccessToken($access_token);
      if (!empty($linkedin_access_token) && !empty($getExpiresAt)) {
          $share = $client->post(
                'people/~/shares',
                [
                    'comment' => $description,
                    'content' => [
                        'title' => 'Powered By ALT',
                        'description' => 'FiHavock Digital Pvt Ltd',
                        'submitted-url' => 'http://altcms.net/',
                        'submitted-image-url' => $image_name,
                    ],
                    'visibility' => [
                        'code' => 'anyone'
                    ]
                ]
          );
          $linkedin_id = $share['updateKey'];
      }
      return $linkedin_id;
  }

  // linkedin company post
  function linkedin_company_post($linkedin_company_id,$description='',$image_name='',$linkedin_access_token,$getExpiresAt){
      
      $client = new Client(
            '81l2aflu70xgnc',
            'xL3DGbcrKCB5h60q'
        );
      $access_token = new AccessToken($linkedin_access_token,$getExpiresAt);
      $client->setAccessToken($access_token);
      if (!empty($linkedin_company_id)) {
            $cmp_share = $client->post(
                    'companies/' . $linkedin_company_id . '/shares',
                    [
                        'comment' => $description,
                        'content' => [
                            'title' => 'Powered By ALT',
                            'description' => 'FiHavock Digital Pvt Ltd',
                            'submitted-url' => 'http://altcms.net/',
                            'submitted-image-url' => $image_name,
                        ],
                        'visibility' => [
                            'code' => 'anyone'
                        ]
                    ]
            );
        $linkedin_id = $cmp_share['updateKey'];
      }
      return $linkedin_id;
  }


  // linkedin integration post
  function linkedin_post($linkedin_company_id,$description='',$image_name='',$linkedin_access_token,$getExpiresAt){
      
      $client = new Client(
            '81l2aflu70xgnc',
            'xL3DGbcrKCB5h60q'
        );
      $access_token = new AccessToken($linkedin_access_token,$getExpiresAt);
      $client->setAccessToken($access_token);
      if (!empty($linkedin_company_id)) {
            $cmp_share = $client->post(
                    'companies/' . $linkedin_company_id . '/shares',
                    [
                        'comment' => $description,
                        'content' => [
                            'title' => 'Powered By ALT',
                            'description' => 'FiHavock Digital Pvt Ltd',
                            'submitted-url' => 'http://altcms.net/',
                            'submitted-image-url' => $image_name,
                        ],
                        'visibility' => [
                            'code' => 'anyone'
                        ]
                    ]
            );
        $linkedin_id['company_id'] = $cmp_share['updateKey'];
      }
      if (!empty($linkedin_access_token) && !empty($getExpiresAt)) {
          $share = $client->post(
                'people/~/shares',
                [
                    'comment' => $description,
                    'content' => [
                        'title' => 'Powered By ALT',
                        'description' => 'FiHavock Digital Pvt Ltd',
                        'submitted-url' => 'http://altcms.net/',
                        'submitted-image-url' => $image_name,
                    ],
                    'visibility' => [
                        'code' => 'anyone'
                    ]
                ]
          );
          $linkedin_id['profile_id'] = $share['updateKey'];
      }
      return $linkedin_id;
  }

  function twitter_delete_tweet($twitter_access_token, $twitter_access_token_secret,$twitter_id=''){
        
        $consumerKey = 'yJxJ8QRAESmzSDCJxsRYuSqUO';
        $consumerSecret = '0bJAdQe2oE9jtkzhfZOsKtNYVPCklg3UiZDTjUdqcG5EPOfulu';
        $connection = new TwitterOAuth($consumerKey, $consumerSecret, $access_token, $access_token_secret);
        /* For Twitter Image Upload */
        $settings = array(
        'oauth_access_token' => $access_token,
        'oauth_access_token_secret' => $access_token_secret,
        'consumer_key' => $consumerKey,
        'consumer_secret' => $consumerSecret
        );

        $status = $connection->post(
            "statuses/destroy", [
                "id" => $twitter_id,
                "trim_user" => true
            ]
        );

        var_dump($status);die;
  }


}


?>