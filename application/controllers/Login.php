<?php
/**
 *
 * @package    Login
 * @author     Vinil Lakkavatri (vinil.lakkavatri@icloud.com)
 * @copyright  2017 Vinil Lakkavatri
 * @company    FiHavock Digital Pvt Ltd
 * @ci_version 3.1.2 echo CI_VERSION;
 * @deprecated File deprecated in Release 2.0.0
 *
 **/
include_once $_SERVER['DOCUMENT_ROOT'].'/application/libraries/phpmailer/PHPMailerAutoload.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/application/libraries/phpmailer/class.phpmailer.php';
class Login extends CI_Controller
{
	
	function __construct(){

		parent::__construct();
        error_reporting(0);
        $this->load->helper('url');
        $this->load->library('session');
		
	}

	function index(){
		if (!empty($this->session->userdata('marketing_username')) && !empty($this->session->userdata('marketing_Usr_Id'))) {
        	redirect('Dashboard/index');
        }
		$this->load->view('login/login');
		$this->load->view('dashboard/footer');
	}

	private function passencrypt($string)
	{
	  $key = "a07d50fa47e3cfcad2a166929d680b45";
	  $result = "";
		  for($i=0; $i<strlen($string); $i++)
		  {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)+ord($keychar));
			$result.=$char;
		  }
	  return strrev(str_replace("=","",base64_encode($result)));
	}

	private function passdecrypt($string)
	{
		  $key = "a07d50fa47e3cfcad2a166929d680b45";
		  $result = "";
		  $string = base64_decode(strrev($string));

		  for($i=0; $i<strlen($string); $i++)
		  {
			$char = substr($string, $i, 1);
			$keychar = substr($key, ($i % strlen($key))-1, 1);
			$char = chr(ord($char)-ord($keychar));
			$result.=$char;
		  }
	  	return $result;
	}

	function CallAPI($method, $url, $data = false)
	{
	    $curl = curl_init();

	    switch ($method)
	    {
	        case "POST":
	            curl_setopt($curl, CURLOPT_POST, 1);

	            if ($data)
	                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
	            break;
	        case "PUT":
	            curl_setopt($curl, CURLOPT_PUT, 1);
	            break;
	        default:
	            if ($data)
	                $url = sprintf("%s?%s", $url, http_build_query($data));
	    }

	    // Optional Authentication:
	    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
	    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

	    curl_setopt($curl, CURLOPT_URL, $url);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

	    $result = curl_exec($curl);

	    curl_close($curl);

	    return $result;
	}

	function login_check(){
		if (isset($_POST) && !empty($_POST)) {
			/*error_reporting(E_ALL);
			ini_set("display_errors", 1);*/
			$email = $this->input->post('email');
			$password = $this->input->post('password');
			$pro_url = 'http://ums.altcms.net/UMSAPI/login_verification?uname='.$email.'&pswd='.$password.'&sub_uri=marketing';
			$json_data = $this->CallAPI('POST',$pro_url);
			$user_profile = json_decode($json_data, true);
			$user_profile_st = $user_profile['status']['data'];
			//echo "<pre>";print_r($user_profile_st);die;
			if ($user_profile['status']['code'] == 200 && $user_profile['status']['message'] == 'OK') {
				if (empty($user_profile_st['product_module_access'])) {
					$this->session->set_flashdata('message','You are not accessible for this product login');
					redirect('/');
				}else{
					session_start();
					$this->session->set_userdata(array(
					    'marketing_username'  => $email,
					    'marketing_full_name' => $user_profile_st['full_name'],
					    'marketing_Usr_Id' => $user_profile_st['Usr_Id'],
					    'marketing_user_type'  => $user_profile_st['user_admin'],
					    'marketing_company_id'  => $user_profile_st['company_id'],
				    	'marketing_company_name'  => $user_profile_st['company_name'],
				    	'marketing_product'  => $user_profile_st['product'],
				    	'marketing_user_product_access'  => $user_profile_st['user_product_access'],
					    'marketing_product_module_access'  => $user_profile_st['product_module_access'],
					));
					redirect('Dashboard/index');
				}
			}else{
				$this->session->set_flashdata('message','Error Logging In!');
				redirect('/');
			}
		}
	}

	function logout(){
		unset($_SESSION['marketing_username']);
		unset($_SESSION['marketing_Usr_Id']);
		unset($_SESSION['marketing_full_name']);
		session_destroy();
		//session_regenerate_id(true);
		redirect('/');
	}

	function recover_password(){
		error_reporting(E_ALL);
		ini_set("display_errors", 1);
		if (isset($_POST) && !empty($_POST)) {

			$email = $this->input->post('email');
			$pro_url = 'http://ums.altcms.net/UMSAPI/forgot_password_user_management?uname='.$email;
			$json_data = $this->CallAPI('POST',$pro_url);
			$users_data = json_decode($json_data, true);
			//echo "<pre>";print_r($users_data);die;
			if ($users_data['status']['code'] == 200 && $users_data['status']['message'] == 'OK') {
				$rand = rand();
				$random_id = $this->passencrypt($rand);
				$random_id = 'forgot_'.$random_id;
				$today = date('Y-m-d');
				$link = site_url().'Login/check_link_expiration?time='.base64_encode(urlencode($today)).'&random_id='.base64_encode(urlencode($random_id)).'&email='.base64_encode(urlencode($email)).'&user_id='.base64_encode(urlencode($users_data['status']['data']['id']));
				
				$password = $users_data['status']['data']['password'];
		       	$to = $email;
				$subject = "FORGOT YOUR PASSWORD";
				$message = '<!DOCTYPE html>
					<html xmlns="http://www.w3.org/1999/xhtml">

					<head>
					    <meta http-equiv="content-type" content="text/html; charset=utf-8">
					    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
					    <meta name="format-detection" content="telephone=no" />

					    <head>
					        <title>RESET PASSWORD</title>
					    </head>
					    <style type="text/css">
					        html {
					            font-family: "calibri";
					        }

					        a {
					            text-decoration: none;
					        }

					        .FiHD-secondary {
					            color: #2D3E50 !important;
					        }

					        .mailer {
					            background-color: #eee;
					            padding: 30px 20px 30px;
					            text-align: center;
					            width: 600px;
					            margin: 0 auto;
					            font-size: 14px;
					            /*border-radius:25px;*/
					        }

					        .mailer-body {
					            background-color: #fff;
					            margin-top: 30px;
					        }

					        .mailer-content {
					            text-align: center;
					            padding: 30px 30px;
					        }

					        .mailer-content h1 {
					            text-transform: uppercase;
					            font-size: 22px;
					        }

					        .logo {
					            background-color: #2d3e50;
					            padding: 10px;
					            margin-top: 10px;
					        }

					        button {
					            border-radius: 25px;
					            padding: 10px 30px;
					            background-color: #f17455;
					            margin: 30px 0px;
					            color: #fff;
					            border: none;
					            text-transform: uppercase;
					        }

					        .social {
					            margin: 10px 0px;
					        }

					        .social .icons img {
					            width: 30px;
					            margin: 0px;
					        }

					        .social .icons {
					            display: inline-block;
					        }

					        .help,
					        .policy {
					            display: inline-block;
					            text-transform: capitalize;
					            margin-bottom: 10px;
					        }

					        .help {
					            padding-right: 10px;
					        }

					        .help span,
					        .copy span,
					        .policy span,
					        .mailer-content span,
					        .mailer-content p {
					            color: #2D3E50;
					            margin-bottom: 5px;
					        }

					        .policy {
					            padding-left: 15px;
					            border-left: 2px solid #ccc;
					        }
					    </style>
					    <body>
					        <div class="mailer">
					            <div class="mailer-body">
					                <div class="mailer-content">
					                    <img src="'.base_url().'/cms-assets/image/ALT-lock.png" alt="" style="width:120px;">
					                    <h1>Forgot your Password</h1>
					                    <span>Not to worry, we got you! Let`s get you a new password.</span>
					                    <br>
					                    <a href="'.$link.'" target="_blank"><button>Reset Password</button></a>
					                    <p>If you didn`t request a password Change, you can ignore this message; someone probably typed in your email accidently.</p>
					                    <div class="help">
					                        <a href=""><span>support@altmarkit.com</span></a>
					                    </div>
					                </div>
					            </div>
					            <div class="logo">
					                <img src="'.base_url().'/cms-assets/image/logo.png" alt="" style="width:100px;">
					            </div>
					            <div class="footer">
					                <div class="social">
					                    <div class="icons">
					                        <a href=""><img src="'.base_url().'/cms-assets/image/icons-fb.png" ></a>
					                    </div>
					                    <div class="icons">
					                        <a href=""><img src="'.base_url().'/cms-assets/image/icons-twitter.png"></a>
					                    </div>

					                    <div class="icons">
					                        <a href=""><img src="'.base_url().'/cms-assets/image/icons-linked-in.png" ></a>
					                    </div>
					                </div>
					                <div class="help">
					                    <a href="http://altmarkit.com/support.php"><span>Get Help</span></a>
					                </div>

					                <div class="policy">
					                    <a href="http://altmarkit.com/privacy.php"><span>Privacy Policy</span></a>
					                </div>
					                <div class="copy">
					                    <span>&copy; '.date('Y').' ALT DIGITAL LTD.</span>
					                </div>
					            </div>
					        </div>
					        </div>
					    </body>

					</html>';

				$mail = new PHPMailer;
				$mail->IsSMTP(true);                                      // Set mailer to use SMTP
	   			$mail->Host = 'email-smtp.us-west-2.amazonaws.com';                 // Specify main and backup server
	   			$mail->Port = 587;                                    // Set the SMTP port
	   			$mail->SMTPAuth = true;                               // Enable SMTP authentication
	   			$mail->Username = 'AKIAI373HG2HGLUSPGNA';                // SMTP username
	   			$mail->Password = 'Ajn+4bI1HB76GbWJIB81v1LfaH4kbtNb0Eor8G4+W9cB';                  // SMTP password
	   			$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
	   			$mail->Headers = "\r\nContent-Type: multipart/mixed; 
	   							  boundary=\"PHP-mixed\"";
	   			$mail->From = 'support@altmarkit.com';
	            $mail->Sender = 'support@altmarkit.com';
	   			$mail->FromName = 'ALT DIGITAL LTD';
				$mail->AddAddress($email);
	   			$mail->AddReplyTo('support@altmarkit.com', 'ALT DIGITAL LTD');
	            $mail->IsHTML(true);                        // Set email format to HTML
	            $mail->ReturnPath = 'support@altmarkit.com';
	   			$mail->Subject = $subject;
	   			$mail->Body    = $message;

	   			if($mail->Send()){
			    	$this->session->set_flashdata('message','Please check your EmailID to reset your password.');
		       	  	redirect('Login/recover_password');
			    }else{
					$this->session->set_flashdata('message','Something went wrong please try again after sometime.');
		       		redirect('Login/recover_password');
			    }

			}else{
				$this->session->set_flashdata('message','Entered EmailID is not found.');
				redirect('Login/recover_password');
			}
		}

		if (!empty($data)) {
			$this->load->view('login/forgot-pswd',$data);
		}else{
			$this->load->view('login/forgot-pswd');
		}
		$this->load->view('dashboard/footer');
	}

	function check_link_expiration(){
		if (isset($_GET) && !empty($_GET)) {
			$sub_date = strtotime(base64_decode(urldecode($this->input->get('time'))));
			$submit_date = base64_decode(urldecode($this->input->get('time')));
			//$submit_date = strtotime('2017-12-10');
			$random_id = base64_decode(urldecode($this->input->get('random_id')));
			$now = time();
			$datediff = $now - $sub_date;
			$days_count = floor($datediff / (60 * 60 * 24));
			$user_id = $this->input->get('user_id');
			$email = $this->input->get('email');
			if ($days_count <= 1) {
				redirect('Login/reset_password?time='.base64_encode(urlencode($now)).'&udid='.$user_id.'&email='.$email);
			}else{
				$this->session->set_flashdata('message','Please enter your EmailID to reset your password.');
				redirect('Login/recover_password');
			}
			
		}
	}

	function reset_password(){
		if (isset($_POST) && !empty($_POST)) {
			$pass = $this->input->post('pass');
			$compass = $this->input->post('compass');
			$user_id = base64_decode(urldecode($this->input->post('user_id')));
			$email = base64_decode(urldecode($this->input->post('email')));
			$email_id = str_replace("%40","@", $email);
			if ($pass == $compass) {
				$pro_url = 'http://ums.altcms.net/UMSAPI/reset_password_user_management?pswd='.$pass.'&user_id='.$user_id;
				$json_data = $this->CallAPI('POST',$pro_url);
				$server_response = json_decode($json_data, true);
				//echo "<pre>";print_r($server_response);die;
				if ($server_response['status']['code'] == 200 && $server_response['status']['message'] == 'Modified') {
					$subject = "PASSWORD CHANGED";
					$message = '<!DOCTYPE html>
							<html xmlns="http://www.w3.org/1999/xhtml">

							<head>
							    <meta http-equiv="content-type" content="text/html; charset=utf-8">
							    <meta name="viewport" content="width=device-width, initial-scale=1.0;">
							    <meta name="format-detection" content="telephone=no" />

							    <head>
							        <title>RESET PASSWORD</title>
							    </head>
							    <style type="text/css">
							        html {
							            font-family: "calibri";
							        }

							        a {
							            text-decoration: none;
							        }

							        .FiHD-secondary {
							            color: #2D3E50 !important;
							        }

							        .mailer {
							            background-color: #eee;
							            padding: 30px 20px 30px;
							            text-align: center;
							            width: 600px;
							            margin: 0 auto;
							            font-size: 14px;
							            /*border-radius:25px;*/
							        }

							        .mailer-body {
							            background-color: #fff;
							            margin-top: 30px;
							        }

							        .mailer-content {
							            text-align: center;
							            padding: 30px 30px;
							        }

							        .mailer-content h1 {
							            text-transform: uppercase;
							            font-size: 22px;
							        }

							        .logo {
							            background-color: #2d3e50;
							            padding: 10px;
							            margin-top: 10px;
							        }

							        button {
							            border-radius: 25px;
							            padding: 10px 30px;
							            background-color: #f17455;
							            margin: 30px 0px;
							            color: #fff;
							            border: none;
							            text-transform: uppercase;
							        }

							        .social {
							            margin: 10px 0px;
							        }

							        .social .icons img {
							            width: 30px;
							            margin: 0px;
							        }

							        .social .icons {
							            display: inline-block;
							        }

							        .help,
							        .policy {
							            display: inline-block;
							            text-transform: capitalize;
							            margin-bottom: 10px;
							        }

							        .help {
							            padding-right: 10px;
							        }

							        .help span,
							        .copy span,
							        .policy span,
							        .mailer-content span,
							        .mailer-content p {
							            color: #2D3E50;
							            margin-bottom: 5px;
							        }

							        .policy {
							            padding-left: 15px;
							            border-left: 2px solid #ccc;
							        }
							    </style>
							    <body>
							        <div class="mailer">
							            <div class="mailer-body">
											<div class="mailer-content">
												<img src="'.base_url().'/cms-assets/image/password_changed.png" alt="" style="width:120px;">
												<h1>Password changed</h1>
												<span>Your Password has been successfully changed.</span>
												<br>
												<a href="'.base_url().'" target="_blank"><button>Login</button></a>
												<p>If you didn`t request a password Change, please contact our support.</p>
												<div class="help">
													<a href=""><span>support@altmarkit.com</span></a>
												</div>
											</div>
										</div>
							            <div class="logo">
							                <img src="'.base_url().'/cms-assets/image/logo.png" alt="" style="width:100px;">
							            </div>
							            <div class="footer">
							                <div class="social">
							                    <div class="icons">
							                        <a href=""><img src="'.base_url().'/cms-assets/image/icons-fb.png" ></a>
							                    </div>
							                    <div class="icons">
							                        <a href=""><img src="'.base_url().'/cms-assets/image/icons-twitter.png"></a>
							                    </div>

							                    <div class="icons">
							                        <a href=""><img src="'.base_url().'/cms-assets/image/icons-linked-in.png" ></a>
							                    </div>
							                </div>
							                <div class="help">
							                    <a href="http://altmarkit.com/support.php"><span>Get Help</span></a>
							                </div>

							                <div class="policy">
							                    <a href="http://altmarkit.com/privacy.php"><span>Privacy Policy</span></a>
							                </div>
							                <div class="copy">
							                    <span>&copy; '.date('Y').' ALT DIGITAL LTD.</span>
							                </div>
							            </div>
							        </div>
							        </div>
							    </body>

							</html>';

						$mail = new PHPMailer;
						$mail->IsSMTP(true);                                      // Set mailer to use SMTP
			   			$mail->Host = 'email-smtp.us-west-2.amazonaws.com';                 // Specify main and backup server
			   			$mail->Port = 587;                                    // Set the SMTP port
			   			$mail->SMTPAuth = true;                               // Enable SMTP authentication
			   			$mail->Username = 'AKIAI373HG2HGLUSPGNA';                // SMTP username
			   			$mail->Password = 'Ajn+4bI1HB76GbWJIB81v1LfaH4kbtNb0Eor8G4+W9cB';                  // SMTP password
			   			$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
			   			$mail->Headers = "\r\nContent-Type: multipart/mixed; 
			   							  boundary=\"PHP-mixed\"";
			   			$mail->From = 'support@altmarkit.com';
			            $mail->Sender = 'support@altmarkit.com';
			   			$mail->FromName = 'ALT DIGITAL LTD';
						$mail->AddAddress($email_id);
			   			$mail->AddReplyTo('support@altmarkit.com', 'ALT DIGITAL LTD');
			            $mail->IsHTML(true);                        // Set email format to HTML
			            $mail->ReturnPath = 'support@altmarkit.com';
			   			$mail->Subject = $subject;
			   			$mail->Body    = $message;

			   			if($mail->Send()){
					    	$this->session->set_flashdata('message','Please login with your changed credentials.');
				       	  	redirect('/');
					    }else{
							$this->session->set_flashdata('message','Something went wrong please try again after sometime.');
				       		redirect('/');
					    }
					//$this->session->set_flashdata('message','Please login with your changed credentials.');
					//redirect('/');
				}else{
					$this->session->set_flashdata('message','Please enter your EmailID to reset your password.');
					redirect('Login/recover_password');
				}
			}
		}

		$this->load->view('login/reset-password');
	}


}

?>