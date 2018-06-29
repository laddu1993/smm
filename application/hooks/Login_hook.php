<?php
    class Login_hook {
    private $CI;
 
        function __construct(){
            $this->CI =& get_instance();
        }
     
        function validate_session(){
            //echo "<pre>";print_r($this->CI->router->class());die;
            if (empty($this->CI->session->userdata('marketing_username'))  && ($this->CI->router->class != 'Login')) {       
                header('location: /');
            }
        }
    }