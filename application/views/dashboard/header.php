<?php
$product_module_access = $this->session->userdata('marketing_product_module_access');
$user_product_access = $this->session->userdata('marketing_user_product_access');
$Usr_Id = $this->session->userdata('marketing_Usr_Id');
$full_name = $this->session->userdata('marketing_full_name');
$user_type = $this->session->userdata('marketing_user_type');
//echo "<pre>";print_r($user_type);die;
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
      <meta name="description" content="">
      <meta name="keywords" content="">
      <title>ALTMARKIT SOCIAL</title>
      <!-- =============== VENDOR STYLES ===============-->
      <!-- FONT AWESOME-->
      <link rel="stylesheet" href="<?= site_url('cms-assets/css/font-awesome.css') ?>"/>
      <link rel="stylesheet" href="<?= site_url('cms-assets/css/font-awesome.min.css') ?>"/>
      <link rel="stylesheet" href="<?= site_url('cms-assets/css/app.css') ?>" id="maincss">

      <link rel="stylesheet" href="<?= site_url('cms-assets/css/bootstrap.css') ?>" />

      <link rel="stylesheet" href="<?= site_url('cms-assets/css/main.css') ?>" >
      <link rel="stylesheet" href="<?= site_url('cms-assets/css/chk.css') ?>">
      <link rel="stylesheet" href="<?= site_url('cms-assets/vendor/animate.css/animate.min.css') ?>"/>
      <link href="<?= site_url('cms-assets/css/jquery.tagit.css') ?>" rel="stylesheet" type="text/css">
      <link href="<?= site_url('cms-assets/css/tagit.ui-zendesk.css') ?>" rel="stylesheet" type="text/css">
      <!-- database Css -->
      <link rel="stylesheet" type="text/css" href="<?= site_url('cms-assets/vendor/datatables/media/css/jquery.dataTables.min.css') ?>" />
      <!-- datepicker -->
      <link rel="stylesheet" type="text/css" href="<?= site_url('cms-assets/css/daterangepicker.css') ?>" />
      <!-- Single datepicker -->
      <link rel="stylesheet" type="text/css" href="<?= site_url('cms-assets/css/calender-style.css') ?>" />
      <link rel="stylesheet" type="text/css" href="<?= site_url('cms-assets/css/pignose.calendar.min.css') ?>" />
         <style type="text/css">
        .open>.product-dropdown-menu{
          display: block;
        }
        .product-dropdown-menu{
          left: unset;
          right: 229px;
          background-color: #2d3e50;
          color: #fff!important;
          position: absolute;
          top: 100%;         
          z-index: 1000;
          display: none;
          float: left;
          min-width: 160px;
          padding: 5px 0;
          margin: 2px 0 0;
          list-style: none;
          font-size: 14px;
          text-align: left;          
          border: 1px solid #e1e1e1;
          border-radius: 4px;
          box-shadow: 0 6px 12px rgba(0,0,0,.175);
          background-clip: padding-box;
        }
        #cmp_id{
          color: #fff;
          padding: 5px 0px 0px 20px;
          margin-bottom: 5px;
          opacity: 0.5;
          font-weight: bold;
          font-size: 12px;
        }
        
     </style>

   </head>
   <body>
      <div class="FiHD">
      <!-- top navbar-->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
         <div class="navbar-header">
            <img src="<?= site_url('cms-assets/img/alt_logo_icon.png') ?>" alt="" class="img-responsive" style="width: 60px; margin-top: 13px;">
         </div>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
            <span class="navbar-toggler-icon"></span>
         </button>
         <ul class="nav navbar-nav collapse navbar-collapse" id="navbarSupportedContent">
            <li><a href="<?= site_url('Dashboard/index') ?>">Dashboard</a></li>
            <li><a href="<?= site_url('Dashboard/integration') ?>">Integration</a></li>
            <li><a href="<?= site_url('SocialPost/social_board') ?>">Social Post</a></li>
            <li><a href="<?= site_url('SocialPost/social_feeds') ?>">Social Feeds</a></li>
         </ul>
           
           <span class="dropdown" style="top: 16px;float: right; right: 142px;">
             <a href="" class="dropdown-toggle" data-toggle="dropdown" style="color:#fff;"><img src="<?php echo $this->config->item('base_url')?>/cms-assets/img/product.png" title="Switch Product" style="width:18px;">
              <span class="caret"></span></a>
            <ul class="dropdown-menu dropdown1 animated flipInY" style="top: 38px;right: -45px;">
            <?php if($user_type == 0){ ?>
              <li> <a href="http://ums.altcms.net" target="_blank">UMS</a></li>
              <?php } $present_url = 'http://'.$_SERVER['HTTP_HOST']; if (!empty($user_product_access)) { foreach ($user_product_access as $value) { if ($present_url == $value['product_url']) { ?>
              <li> <a href="#" style="cursor: no-drop;"><?php echo $value['product_name'] ?></a></li>
              <?php }else{ ?>
              <li> <a href="<?php echo $value['product_url'] ?>" target="_blank" ><?php echo $value['product_name'] ?></a></li>
              <?php } } } ?>
            </ul>
          </span> 



         <!-- <div class="notificaton"></div> -->
         <a href="" data-toggle="dropdown" class="navdropdown"><?php echo (!empty($full_name) ? $full_name : '-'); ?><b class="caret"></b></a>
         <ul role="menu" class="dropdown-menu dropdown1 animated flipInY">
            <li><p id="cmp_id">Company ID:<br> <?php echo (!empty($this->session->userdata('marketing_company_id')) ? $this->session->userdata('marketing_company_id') : '-'); ?></p></li>
            <li><a href="<?= site_url('Users/edit_profile/'.$Usr_Id.'') ?>" >View Profile <img src="<?= site_url('cms-assets/img/xuser.png.png') ?>" data-toggle="tooltip" title="User" class="img-height marginleft" alt="" style="padding-left: 16px;"></a>
            </li>
            <li><a href="<?= site_url('Login/logout') ?>">Logout <img src="<?= site_url('cms-assets/img/xlock.png.png') ?>" data-toggle="tooltip" title="User" class="img-height marginleft" alt="" style="padding-left: 45px;"> </a>
            </li>
         </ul>

        </div>
      </nav>
      <!-- sidebar-->