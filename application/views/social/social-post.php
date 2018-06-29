<style type="text/css">
    body.modal-open
    {
        padding-right: 0px !important;
    }
    .slc_social_web
    {
        margin: 10px 0px;
    }
    .slc_social_web .ch label, input[type="checkbox"]:checked+label, input[type="checkbox"] + label
    {
        margin-right: 5px;
        height: 20px;
        width: 20px;
    }
    .social_post_preview_panel, .social_post, .twitter_post, .sentiment_analysis, .suggestion_panel
    {
        display: none;
    }
    .tag-suggestion::-webkit-scrollbar {
        width: 0.5em !important;
    }
    .tag-suggestion::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 0px rgba(0,0,0,0) !important;
    }
    .tag-suggestion::-webkit-scrollbar-thumb {
        background-color: #2d3e50 !important;
        outline: 0px solid white !important;
    }
    #image-tag img{
       width: 100%;
    }
    table tr {
        border-bottom: 1px solid #000;
    }

    .btn.active.focus,
    .btn.active:focus,
    .btn.focus,
    .btn:active.focus,
    .btn:active:focus,
    .btn:focus {
        outline: none;
    }
    .hourselect ,.minuteselect ,.ampmselect{
        background-color: #2d3e50;
    }
    .daterangepicker {
        top: 385px !important;
        /*left: 567.656px;*/
        /*right: 32% !important;*/            
    }
    .range_inputs button{
        background-color: #f17455;
        border-color: #f17455;
        color: #fff;            
    }
    .daterangepicker:before{
        content: none;
    }
    .daterangepicker td.active, .daterangepicker td.active:hover{
        background-color: #f17455;
    }
    .range_inputs button:hover{
        background-color: #f17455;
        border-color: #f17455;
        color: #000;
    }
    .dataTables_length,
    .dataTables_filter,
    .dataTables_info,
    .dataTables_paginate{
        display:none;
    }
    .social_update_button {
        background-color: #fff;
        border-radius: 10px;
        padding: 30px 50px 0px;
    }
    .social_update_button button {
        padding: 10px 70px;
    }
    .ex1{
         float:left;
            width: 427px;
            height: 549px;
            overflow: scroll;
    }
    .mod{
    top: 0;
    bottom: 0;
    margin: auto;
    height: 280px;
    }
    .modal-dialog modal-dialog-centered{
    width: 600px;
    margin: auto;
    height: 100vh;
    }
    .modal-dialog modal-dialog-centered{
        position: relative;
    }
    /* Popup box BEGIN */
    .hover_bkgr_fricc{
        /*background:rgba(0,0,0,.4);*/
        cursor:pointer;
        display:none;
        height:100%;
        position:absolute;
        text-align:center;
        top:40%;
        width:100%;
        z-index:10000;
    }
    .hover_bkgr_fricc .helper{
        display:inline-block;
        height:100%;
        vertical-align:middle;
    }
    .hover_bkgr_fricc > div {
        background-color: #fff;
        box-shadow: 10px 10px 60px #555;
        display: inline-block;
        height: auto;
        /*max-width: 551px;*/
        min-height: 100px;
        vertical-align: middle;
        width: 100%;
        position: relative;
        border-radius: 8px;
        padding: 15px 5%;
        text-align: justify;
    }
    .popupCloseButton {
        background-color: #fff;
        border: 3px solid #999;
        border-radius: 50px;
        cursor: pointer;
        display: inline-block;
        font-family: arial;
        font-weight: bold;
        position: absolute;
        top: -20px;
        right: -20px;
        font-size: 25px;
        line-height: 30px;
        width: 30px;
        height: 30px;
        text-align: center;
    }
    .popupCloseButton:hover {
        background-color: #ccc;
    }
    .trigger_popup_fricc {
        cursor: pointer;
        font-size: 20px;
        margin: 20px;
        display: inline-block;
        font-weight: bold;
    }
    /* Popup box BEGIN */

    /*Hashtag Css begin*/
    ul.tagit {
        border: none;
        border-bottom: 1px solid #ccc;
    }
    .ui-widget {
        font-size: 14px !important;
        font-family: 'AvenirNextLTW01Regular';
    }

    ul.tagit li.tagit-choice .tagit-label:not(a) {
        color: #ffffff !important;
    }
    ul.tagit li.tagit-choice:hover,
    ul.tagit li.tagit-choice.remove {
        background-color: #f17455;
        border-color: #f17455;
    }
    ul.tagit li.tagit-choice {
        -moz-border-radius: 6px;
        border-radius: 6px;
        -webkit-border-radius: 6px;
        border: 1px solid #f17455;
        background: none;
        background-color: #f17455;
        font-weight: normal;
    }
    span.ui-helper-hidden-accessible:before {
        content: "Note:";
    }

    input[type="text"].ui-helper-hidden-accessible:before {
        content: "Enter your number";
    }
    /*End of hashtag css*/
}
</style>
<section>
    <form action="<?= site_url('SocialPost/add_social_board') ?>" method="post" enctype="multipart/form-data" id="social_post_panel">
    <div class="content-wrapper">
    <?php if ($this->session->flashdata('message')) { ?>
    <div class="text-center" style="margin-bottom: 10px;">
            <span style="background:#759675;padding: 6px;color:#fff;width:297px;border-radius: 5px;"><?php echo $this->session->flashdata('message'); ?></span>
    </div>
    <?php } ?>
    <div class="row ">
        <div class="col-lg-12 padding-bottom-10">

              <div class="panels dashboard marginbtm0">
                <h4 class="dashboard-heading fontcolor-primary text-bold">Social Post
                                    
                 <a href="#"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAAA0lBMVEUAAAAAgP8Aff8Ae/8Aff8Ae/8AfP8Aev0AfP8Ae/8AefoAX8QAX8QAYMUAYMUAYMYAYcYAYMQAYMYAW70AXL0AXL4AePUAePYAd/UAe/0Ae/4Aev0AW7wAXL0AXb4AXcAAevwAY8sAY8sAZM0AZc4AbeAAbeEAbeIAbuMAb+QAe/wAe/0AfP4AfP8Bff8IgP8QhP8Thv8jjv8pkf8vlP80l/82mP89m/9Bnf9Qpf9erP9frf90uP9+vf+UyP+x1/+22f+52//U6f/a7P/c7f/j8f/bq60bAAAAJXRSTlMAIDc4OzySlLe41Nvc3N3d3d7e4+Pj6Ojp6enq6+zt7e76/Pz8DToV1QAAANpJREFUKM+1UlcbgjAMBNkVcaMCAopb6xb3Qv3/f0nbUgSeNS+X765J2ksZ5vchSMB1gcSnaFbRVcfzHLWusHGeM4tDiGOgmVzsvFmFNCZV81ujFBG1vd/8D4xLcjRXR31mj93hNf0kfZ3eQFJRweoK4XOOspwYCsAJ+68DDDYIBbdD+EXgY/RcKnhEOJ0JtqkAbEIcNwSbIDEcwuWCoEqHC/UeJi57DN1aZJiijaOXw1FBjllSiZRR2YjZyDW0PuF7eSOTsF3Ws1arZWVrMpvaCC+iRYn8H/7AG+OYJgadRoX7AAAAAElFTkSuQmCC" data-toggle="tooltip" title="Knowledge Base" class="float-right img-height marginleft" alt="" pagespeed_url_hash="3175268275" onload="pagespeed.CriticalImages.checkImageForCriticality(this);"></a></h4>
                  <div class="row">
                    <div class="col-xs-12">
                      <div class="setting-section">
                          <span class="fontcolor-primary text-active margin-sides cursor textbold" id="tab1" style="margin-left:40px;">Create Post</span>                           
                       
                          <span class="fontcolor-primary margin-sides cursor textbold" id="tab2"><a href="<?= site_url('SocialPost/view_post') ?>" style="color: #2d3e50"> View Post </a></span>                                                           
                       </div>
                    </div>
                  </div>  
              </div>
              
          </div>
    </div>
    
        <div class="row" id="fihd1-tab1">
            <div class="col-md-4">
                <div class="col-lg-12 padd-0">
                    <div class="panels marginbtm-10">
                        <div class="main-heading">
                            <p style="margin-bottom: 0px;">Let your customers know more about your business through social board</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 padd-0">
                    <div class="panels marginbtm-10">
                        <div class="panel-body" style="padding: 30px 40px;">
                            <h4 class="fontcolor-primary text-bold">Create Post </h4>
                            <p>
                                Note:This will directly post to your authenticated social media like Facebook, Twitter & Linkedin
                            </p>
                            <h4 class="fontcolor-primary text-bold" style="margin-top: 50px;">Post content </h4>

                                <input id="field1" type="text" name="post_content" class="form-control">
                                <div id="textarea_feedback" style=" font-size:  12px;color: #f17455;"></div>
                                <div class="chechbox-twitter" style="display:none; margin:20px 0px;">
                                    <span> Post New Content On Twitter?? </span>
                                    <input type="checkbox" name="twitter_content_flag" id="twitter" value="yes" style="display:none;">

                                    <label for="twitter" style="float: left; margin-right: 5px;"></label>

                                </div>
                                <input id="txt" type="text" name="twitter_content" class="form-control" maxlength="140" placeholder="Enter your post only for twitter" style="display:none;">
                                <div id="textarea_feedback2" style="display:none;color: #f17455;"></div>

                                <div class="forms custom-file-upload" id="remove_image" onclick="getFile()" style="padding-top:17px;">
                                    <label for="files" style="cursor: pointer;" class="fontcolor-primary text-bold">Select Image</label>
                                    <input style="display:none" type="file" id="upfile" name="post_image"/><br>
                                    <img src="<?= site_url('cms-assets/img/add.png') ?>" id="add" style="display: none;">
                                </div>

                            <div class="social_update_button">
                                <div class="text-align">
                                    <button type="button" class="btn btn-color FiHD-secondarybg" value="validate" onclick="myFunction()"> Get Analysis</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- social Board Area -->

            <div class="col-md-4 social_post_preview_panel">
                <div class="col-lg-12 padd-0">

                    <div class="pd50tb text-center">

                        <div class="panels marginbtm-10">
                        	<div class="panel-body social-images">
                            <h5 class="social_post fw600">This Content will post on all your selected Social Media Platform</h5>
                            <p class="social_post" id="field2" style="word-break:  break-word;overflow-y: auto;max-height: 70px;">
                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magnaal
                            </p> <hr class="social_post" />
                            <h5 class="twitter_post fw600">This Content will post on your Twitter Wall</h5>
                            <p class="twitter_post" id="text1" style="word-break:  break-word;overflow-y: auto;max-height: 70px;">

                                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magnaal
                            </p> <hr class="twitter_post" />
                            <div id="image-tag" style="padding-bottom:15px;">
                            </div>

                            <div class="col-md-12 sentiment_analysis" style="background-color: #f1f4f7;border-radius: 0px; padding: 15px 17px;font-size: 14px; text-align:center;">
                            	
                               <h4 class="dashboard-heading">Sentiment Analysis</h4>
                          
                               <div class="col-xs-6">
                               <h4 class="fontcolor-primary textbold" id="polarity"></h4>
                               <p class="mb0 text-muted fontcolor-secondary">Polarity</p>
                               </div>
                               
                               <div class="col-xs-6">
                               <h4 class="fontcolor-primary textbold" id="subjectivity"></h4>
                               <p class="mb0 text-muted fontcolor-secondary">Subjectivity</p>
                               </div>
                              
                               <div class="col-xs-6">
                               <h4 class="fontcolor-primary textbold" id="polarity_confidence"></h4>
                               <p class="mb0 text-muted fontcolor-secondary">Polarity Confidence</p>
                               </div> 

                                <div class="col-xs-6">
                               <h4 class="fontcolor-primary textbold" id="subjectivity_confidence"></h4>
                               <p class="mb0 text-muted fontcolor-secondary">Subjectivity Confidence</p>
                               </div>

                           </div>

                               

                            <div class="col-md-12" style="padding: 20px 20px;">
                                <div class="">
                                    <div class="Setting">                                                
                                        <div class="text-align">                                                
											<!-- Modal -->
                                                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" style="padding: 0px;">
                                                      <div class="modal-dialog modal-dialog-centered" role="document" style="    height: 100vh; margin: auto;">
                                                        <div class="modal-content" style="position: absolute; margin: auto; top: 0; bottom: 0; height: 310px;">
                                                          <div class="modal-header" style="border-bottom: 0px; background: #161f28; color: #fff; padding: 20px 40px;">
                                                            <h5 class="modal-title" style="float:left;" id="exampleModalCenterTitle">Were would you like to post?</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                              <span aria-hidden="true" style="color:#fff;">&times;</span>
                                                            </button>
                                                          </div>
                                                        <div class="-body" style="text-align: justify; padding: 20px 40px;">
                                                           
                                                                <div class="col-md-6 slc_social_web " style=" margin-top:  15px;">
                                                                    <div class="ch">
                                                                       <input type="checkbox" name="facebook" id="Facebook" value="yes">
                                                                    <label for="Facebook"></label>
                                                                    <span>FB</span>
                                                                    </div>
                                                                </div>
                                                                         
                                                                     
                                                                 <div class="col-md-6 slc_social_web" style="margin-top:  15px;">
                                                                    <div class="ch">
                                                                        <input type="checkbox" name="facebook_page" id="Facebook_group" value="yes">
                                                                        <label for="Facebook_group"></label>
                                                                        <span>FB Page</span>
                                                                    </div>
                                                                </div>
                                                               

                                                                <div class="col-md-6 slc_social_web">
                                                                    <div class="ch">
                                                                        <input type="checkbox" name="twitter" id="Twitter" value="yes">
                                                                        <label for="Twitter"></label>
                                                                        <span>Twitter</span>
                                                                    </div>
                                                                </div>
                                                               
                      
                                                                <div class="col-md-6 slc_social_web">
                                                                    <div class="ch">
                                                                        <input type="checkbox" name="linkedin" id="LinkedIn" value="yes">
                                                                        <label for="LinkedIn"></label>
                                                                        <span>LinkedIn Profile</span>
                                                                    </div>
                                                                </div>
                                                               
                                                                    
                                                                <div class="col-md-6 slc_social_web" style="text-align: left;">
                                                                    <div class="ch">
                                                                        <input type="checkbox" name="linkedin_page" id="LinkedIn_company" value="yes">
                                                                        <label for="LinkedIn_company"></label>
                                                                        <span>LinkedIn Company Page</span>
                                                                    </div>
                                                                </div>
                                          
                                                          </div>
                                                          <div class="modal-footer p_fb" style="clear:both; border-top:0px solid #fff; padding: 20px 40px; display: none;">
                                                            <p id="calender-date" style="float:left; margin-top:11px;"></p><img src="<?= site_url('cms-assets/img/close.png') ?>" class="img-height" id="removeschuleding" style="display: none;">
                                                            <input type="hidden" name="schedule_date" id="schedule_date">
                                                            <button type="button" id="daterange" class="btn  btn-color FiHD-secondarybg">Schedule</button>
                                                            <button type="submit" id="save_data" class="btn btn-color FiHD-secondarybg" data-toggle="modal" data-target="#savemodal" data-backdrop="static" data-keyboard="false">Save</button>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>

                                                    <!-- save Modal -->
                                                    <div class="modal fade" id="savemodal2" tabindex="-1" role="dialog" aria-labelledby="savemodalTitle" aria-hidden="true" style="padding: 0px;">
                                                      <div class="modal-dialog modal-dialog-centered" role="document" style="    height: 100vh; margin: auto;">
                                                        <div class="modal-content" style="position: absolute; margin: auto; top: 0; bottom: 0; height: 310px; width: 100%;">
                                                          <div class="modal-header" style="border-bottom: 0px; background: #161f28; color: #fff; padding: 20px 40px;">
                                                            <!-- <h5 class="modal-title" style="float:left;" id="savemodalTitle">Were would you like to post?</h5 -->
                                                            <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                                                              <span aria-hidden="true" style="color:#fff;">&times;</span>
                                                            </button>
                                                          </div>
                                                        <div class="-body" style="text-align: justify; padding: 20px 40px;">                                                                                   
                                                                <div class="col-md-12 slc_social_web" style="text-align: left;">
                                                                    <div class="ch">
                                                                        <p>Your post have been successfully saved</p>
                                                                    </div>
                                                                </div>
                                          
                                                          </div>
                                                          <div class="modal-footer" style="clear:both; border-top:0px solid #fff; padding: 20px 40px;">
                                                            <button type="button" class="btn  btn-color FiHD-secondarybg" data-dismiss="modal" aria-label="Close" id="successfully_save">Ok</button>
                                                          </div>
                                                        </div>
                                                      </div>
                                                    </div>
                                                    <!-- END OF SAVE MODAL -->


											<button type="button" id="post" class="btn  btn-color FiHD-secondarybg btn" data-toggle="modal" data-target="#exampleModalCenter">Post</button>
											<div class="hover_bkgr_fricc">
											<span class=""></span>
											<div>
											<div class="popupCloseButton">X</div>
											
                                           </div>
											
											</div>
											</div>
                                   </div>
                                    </div>
                                </div>
                            
                           </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 suggestion_panel">
                        <div class="col-md-12 padd-0  marginbtm-10 ">
                            <div class="panels marginbtm0 ">
                                <div class="FiHD-analytics-panel" style="padding-bottom: 10px;">
                                          <h4 class="dashboard-heading">#-Tag Suggestion</h4>
                                      <div id="FiHD-analytics-page" class="tag-suggestion" style="height: 400px; overflow-y: scroll;">
                                    <table id="example" class="display" cellspacing="0" width="100%" style="margin-top: -30px;">
                              <thead>
                                  <tr>
                                    <th style="width: 70%;">Key Phrase</th>
                                  </tr>
                              </thead>
                              
                              <tbody id="hashtag_suggestions">
                                  
                              </tbody>
                          </table>
                                </div>
                              </div>

                        </div>
                    </div>

                    <div class="col-lg-12 padd-0">
                        <div class="panels marginbtm-10">
                            <div style="padding: 30px 40px;">
                                <h4>#-Tag</h4>
                                <div class="">
                                     <ul id="myTags"></ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    

</form>
</section>
<script src="<?= site_url('cms-assets/vendor/jquery/dist/jquery.js') ?>"></script>
<script src="<?= site_url('cms-assets/js/jquery-ui.min.js') ?>" type="text/javascript" charset="utf-8"></script>
<script src="<?= site_url('cms-assets/js/moment.min.js') ?>"></script>
<script src="<?= site_url('cms-assets/js/daterangepicker.js') ?>"></script>
<script src="<?= site_url('cms-assets/js/tag-it.min.js') ?>" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?= site_url('cms-assets/js/social-post.js') ?>"></script>
<script type="text/javascript">
jQuery(function() {
    var checks = $('#Twitter, #Facebook, #Facebook_group, #LinkedIn ,#LinkedIn_company');
    checks.click(function() {
        if (checks.filter(':checked').length >= 1) {
            $('.p_fb').show();
        } else {
            $('.p_fb').hide();
        }
    }).triggerHandler('click')
})

/*$('#save_data').click(function(){
    $.ajax({
        type: "POST",
        url: "",
        async : true,
        data: $('#social_post_panel').serialize(),
        success : function(data){
            //$('#ajax_call').html(data);
            console.log(data);
        }
    });
});*/
$("form").submit(function( event ) {
     $('.p_fb').hide();
     //return true;
});

$(function() {
    $('#myTags').tagit();
});

</script>