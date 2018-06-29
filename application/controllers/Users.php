<?php 
/**
 *
 * @package    Users
 * @author     Vinil Lakkavatri (vinil.lakkavatri@icloud.com)
 * @copyright  2017 Vinil Lakkavatri
 * @company    FiHavock Digital Pvt Ltd
 * @ci_version 3.1.2 echo CI_VERSION;
 * @deprecated File deprecated in Release 2.0.0
 *
 **/
class Users extends CI_Controller
{
	
	function __construct(){
		parent::__construct();
        error_reporting(0);
        $this->load->model('Common_model', 'admin');
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->library('pro');
        $this->company_id = $this->session->userdata('marketing_company_id');
	}

	function CallAPI($method, $url, $data = false){
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

	function check_user_email_exists(){
		if (isset($_POST) && !empty($_POST)) {
			$email_id = $this->input->post('email_id');
			$url = 'http://ums.altcms.net/UMSAPI/user_profile_exists?email_id='.$email_id;
			$json_data = $this->CallAPI('POST',$url);
			$users_data = json_decode($json_data, true);
			if ($users_data['status']['message'] == 'Unauthorized') {
				echo $users_data['status']['message'];
			}else{
				echo $users_data['status']['message'];
			}
		}
	}

	function adduser(){

		if (isset($_POST) && !empty($_POST)) {
			include_once '/opt/bitnami/apache2/htdocs/cms/application/libraries/phpmailer/PHPMailerAutoload.php';
			include_once '/opt/bitnami/apache2/htdocs/cms/application/libraries/phpmailer/class.phpmailer.php';
			$email_id = $this->input->post('email_id');
			$full_name = $this->input->post('full_name');
			$status = $this->input->post('status');
			$user_admin = $this->input->post('user_admin');
			$new_password = $this->input->post('new_password');
			$confirm_password = $this->input->post('confirm_password');
			$addedby = $this->session->userdata['full_name'];

			$url = 'http://ums.altcms.net/UMSAPI/create_user_profile?comp_id='.$this->company_id.'&email_id='.$email_id.'&full_name='.base64_encode(urlencode($full_name)).'&new_password='.$new_password.'&confirm_password='.$confirm_password.'&status='.$status.'&user_admin='.$user_admin.'&addedby='.base64_encode(urlencode($addedby));
			$json_data = $this->CallAPI('POST',$url);
			$users_data = json_decode($json_data, true);
			if ($users_data['status']['code'] == 201 && $users_data['status']['message'] == 'Created') {
					$last_inserted_id = $users_data['status']['data']['last_inserted_id'];
					$to = $email_id;
					$today = date('Y-m-d');
					$link = site_url().'Admin/user_verfication?time='.base64_encode(urlencode($today)).'&email_id='.base64_encode(urlencode($email_id)).'&status='.base64_encode(urlencode($status)).'&user_id='.base64_encode(urlencode($last_inserted_id));

					$subject = "Your ALT CMS account is now ready";
					$message = '<!DOCTYPE html>
					<html xmlns="http://www.w3.org/1999/xhtml">
				   	<head>
				   	<meta http-equiv="content-type" content="text/html; charset=utf-8">
			     	<meta name="viewport" content="width=device-width, initial-scale=1.0;">
			    	<meta name="format-detection" content="telephone=no"/>
					<head>
						<title>Confirm</title>
					</head>
					<style type="text/css">
					a{
						text-decoration: none;
					}
					.FiHD-secondary{
						color: #2D3E50 !important;
					}
					.mailer{
						background-color: #eee;
						padding: 30px 20px 30px;
						text-align: center;
						width: 600px;
						margin: 0 auto;
						font-size: 14px;
						border-radius:25px;
					}
					.mailer img{
						margin-bottom: 30px;

					}
					.mailer-body{
						background-color: #fff;
					}
					.mailer-content{
						text-align: center;
						padding: 30px 30px;
					}
					.mailer-content h1{
						text-transform: uppercase;
						font-size: 28px;
					}
					button{
						border-radius: 25px;
					    padding: 10px 30px;
					    background-color: #FD6705;
					    margin: 30px 0px;
					    color: #fff;
					    border: none;
					    text-transform: uppercase;
					}

					.social {
						margin: 30px 0px;
					}
					.social .icons img{
						width: 30px;
						margin: 0px;
					}
					.social .icons{
						display: inline-block;
					}
					.help ,.policy {
						display: inline-block;
						text-transform: capitalize;
						margin-bottom: 30px;
					}
					.help{
						padding-right: 10px;
					}
					.help span, .copy span, .policy span ,.mailer-content span , .mailer-content p{
						color:#2D3E50;
					}
					.policy{
						padding-left: 15px;
						border-left: 2px solid #ccc;
					}
					.copy{
						margin-bottom: 30px;
					}
					</style>
					<body>
						<div class="mailer">
							<img src="http://altdms.net/cms-assets/img/logo.png">
							<div class="mailer-body">

								<div class="mailer-content">
									<img src="http://altdms.net/cms-assets/img/envelope.svg" alt="" style="width:120px;">
									<h1>Before we get started<span class="FiHD-secondary">...</span></h1>
									<span>please take a second to make sure we`ve got your email right.</span>
									<br>
									<a href="'.$link.'" target="_blank"><button>confirm my email</button></a>
									<p>If you didn`t request a password reset, you can ignore this message, someone probably typed in your email accidently  </p>
								</div>
							</div>	
							<div class="footer">
								<div class="social" >
									<div class="icons">
										<a href=""><img src="http://altdms.net/cms-assets/img/icons-fb.png"  ></a>
									</div>
									<div class="icons">
										<a href=""><img src="http://altdms.net/cms-assets/img/icons-twitter.png" ></a>
									</div>

									<div class="icons">
										<a href=""><img src="http://altdms.net/cms-assets/img/icons-linked-in.png" ></a>
									</div>
								</div>
									<div class="help">
										<a href=""><span>Help & support</span></a>
									</div>
									
									<div class="policy">
										<a href=""><span>Privacy Policy</span></a>
									</div>
									<div class="copy">
										<span>Copyright 2018 by Fi Havock Digital P.Ltd. All Right Reserved.</span>
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
		   			$mail->From = 'sales@fihd.in';
		            $mail->Sender = 'sales@fihd.in';
		   			$mail->FromName = 'FiHavock Digital Pvt Ltd';

					$mail->AddAddress($email_id);
		   			$mail->AddReplyTo('sales@fihd.in', 'FiHavock Digital Pvt Ltd' );
		            $mail->IsHTML(true);                        // Set email format to HTML
		            $mail->ReturnPath = 'sales@fihd.in';
		   			$mail->Subject = $subject;
		   			$mail->Body    = $message;

		   			if($mail->Send()){
				    	$this->session->set_flashdata('message','Successfully Added New User');
			       	  	redirect('Users/users');
				    }else{
						$this->session->set_flashdata('message','Email is not shooted to User');
			       		redirect('Users/users');
				    }
			}else if ($users_data['status']['code'] == 401 && $users_data['status']['message'] == 'Unauthorized') {
				$this->session->set_flashdata('message','EmailID already exists!');
				redirect('Users/users');
			}else{
				$this->session->set_flashdata('message','Internal Server Error');
				redirect('Users/users');
			}
		}

		$this->load->view('admin/header',$data);
		$this->load->view('users/adduser');
		$this->load->view('admin/footer');
		
	}

	function users(){

		$url = 'http://ums.altcms.net/UMSAPI/user_management_list?comp_id='.$this->company_id;
		$json_data = $this->CallAPI('POST',$url);
		$users_data = json_decode($json_data, true);
		if ($users_data['status']['code'] == 200 && $users_data['status']['message'] == 'OK') {
			$data['users_data'] = $users_data['status']['data'];
		}
		$this->load->view('admin/header',$data);
		if (!empty($data)) {
			$this->load->view('users/user_register',$data);
		}else{
			$this->load->view('users/user_register');
		}
		$this->load->view('admin/footer');
	}

	function add_edit(){

		$Usr_Id = $this->uri->segment(3);
		if (!empty($Usr_Id)) {
			$url = 'http://ums.altcms.net/UMSAPI/user_profile?comp_id='.$this->company_id.'&user_id='.$Usr_Id;
			$json_data = $this->CallAPI('POST',$url);
			$users_data = json_decode($json_data, true);
			if ($users_data['status']['code'] == 200 && $users_data['status']['message'] == 'OK') {
				$data = $users_data['status']['data'];
				if (empty($data)) {
					redirect('Users/users');
				}
			}else{
				$this->session->set_flashdata('message','Internal Server Error');
			}
		}
		//echo "<pre>";print_r($data);die;
		$this->load->view('admin/header',$data);
		if (!empty($data)) {
			$this->load->view('users/user-edit',$data);
		}else{
			$this->load->view('users/user-edit');
		}
		$this->load->view('admin/footer');
	}

	function update_user(){
		if (isset($_POST) && !empty($_POST)) {
			//$data['username'] = $this->input->post('username');
			$full_name = $this->input->post('full_name');
			$status = $this->input->post('status');
			$user_admin = $this->input->post('user_admin');
			$new_password = $this->input->post('new_password');
			$confirm_password = $this->input->post('confirm_password');
			$id =  $this->input->post('Usr_Id');

			$url = 'http://ums.altcms.net/UMSAPI/update_user_management?comp_id='.$this->company_id.'&user_id='.$id.'&full_name='.base64_encode(urlencode($full_name)).'&status='.$status.'&user_admin='.$user_admin.'&new_password='.$new_password.'&confirm_password='.$confirm_password;
			$json_data = $this->CallAPI('POST',$url);
			$users_data = json_decode($json_data, true);
			if ($users_data['status']['code'] == 200 && $users_data['status']['message'] == 'Modified') {
				$this->session->set_flashdata('message','Successfully Updated!!');
			}else{
				$this->session->set_flashdata('message','Internal Server Error');
			}
			//echo "<pre>";print_r($update_data);die;
			redirect('Users/add_edit/'.$id);
		}
	}

	function edit_profile(){

		if (isset($_POST) && !empty($_POST)) {
			//$up_data['username'] = $this->input->post('username');
			$full_name = $this->input->post('full_name');
			$new_password = $this->input->post('new_password');
			$confirm_password = $this->input->post('confirm_password');
			$id =  $this->input->post('Usr_Id');
			$url = 'http://ums.altcms.net/UMSAPI/update_user_management?comp_id='.$this->company_id.'&user_id='.$id.'&full_name='.base64_encode(urlencode($full_name)).'&new_password='.$new_password.'&confirm_password='.$confirm_password;
			$json_data = $this->CallAPI('POST',$url);
			$users_data = json_decode($json_data, true);
			if ($users_data['status']['code'] == 200 && $users_data['status']['message'] == 'Modified') {
				$this->session->set_flashdata('message','Successfully Updated!!');
			}else{
				$this->session->set_flashdata('message','Internal Server Error');
			}
			redirect('Users/edit_profile/'.$id);
		}
		$Usr_Id = $this->uri->segment(3);
		if (!empty($Usr_Id)) {
			if ($Usr_Id == $_SESSION['marketing_Usr_Id']) {
				$url = 'http://ums.altcms.net/UMSAPI/user_profile?comp_id='.$this->company_id.'&user_id='.$Usr_Id;
				$json_data = $this->CallAPI('POST',$url);
				$users_data = json_decode($json_data, true);
				if ($users_data['status']['code'] == 200 && $users_data['status']['message'] == 'OK') {
					$data = $users_data['status']['data'];
					$data['company_name'] = $this->session->userdata('marketing_company_name');
				}else{
					$this->session->set_flashdata('message','Internal Server Error');
				}
			}else if($Usr_Id != $_SESSION['marketing_Usr_Id']){
				redirect('Users/edit_profile/'.$_SESSION['Usr_Id'].'');
			}
		}
		
		$this->load->view('dashboard/header',$data);
		if (!empty($data)) {
			$this->load->view('users/edit-profile',$data);
		}else{
			$this->load->view('users/edit-profile');
		}
		$this->load->view('dashboard/footer');
		//echo "<pre>";print_r($data);die;

	}

	function add_delete(){
		if (isset($_POST) && !empty($_POST)) {
			$id = $_POST['remove_user_id'];
			$url = 'http://ums.altcms.net/UMSAPI/delete_user_management?comp_id='.$this->company_id.'&user_id='.$id;
			$json_data = $this->CallAPI('POST',$url);
			$users_data = json_decode($json_data, true);
			if ($users_data['status']['code'] == 200 && $users_data['status']['message'] == 'OK') {
				$this->session->set_flashdata('message','Successfully Deleted User!');
			}else{
				$this->session->set_flashdata('message','Internal Server Error');
			}
			$output['status'] = 1;
		}
		return $output;
	}


}

?>