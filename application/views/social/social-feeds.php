<style type="text/css">
.socialpost-horizontal{
  overflow-x: auto;
  white-space: nowrap;
}

.socialpost-horizontal .in{
  display: inline-block;
}
.social-panel
{
  height:90vh;
  overflow-x: scroll;
  overflow-y: hidden;
}
.social-panel-inner
{
  min-width: auto;
  height:100%;
  width: 1800px;
}
.feed-panel
{
  width:400px;
  max-width: 400px;
  padding: 0px 15px;
  height:675px;
  display: table-cell;
  position: relative;
}
.feed-panel-heading
{
  background-color: #fff;
  text-align: center;
  color:#202020;
  position: static;
  top:0;
  width: 100%;
  padding: 15px 10px;
  margin-bottom: 10px;
  height: 102px;
}
.feed-post-panel{
   height: 525px;
    overflow-y: scroll;
    overflow-x: hidden;
    word-wrap: break-word;
    padding:0px;
   /* background-color: #fff;*/
}
.feed-post
{
    background-color: #fff;
    padding: 20px;
    /* border-bottom: 5px solid #f1f4f7; */
    margin-bottom: 5px;
    box-shadow: 0px 0px 4px #ccc;
}
.feed-post-text
{
    font-size: 14px;
    margin-bottom: 15px;
}
.feed-post-image img
{
  max-width: 100%;
}
.feed-post-panel::-webkit-scrollbar {
    width: 0.3em !important;
}
.feed-post-panel::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 0px rgba(0,0,0,0) !important;
}
.feed-post-panel::-webkit-scrollbar-thumb {
    background-color: #2d3e50 !important;
    outline: 0px solid white !important;
}
.social-panel::-webkit-scrollbar {
    height: 0.3em !important;
}
.social-panel::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 0px rgba(0,0,0,0) !important;
}
.social-panel::-webkit-scrollbar-thumb {
    background-color: #999 !important;
    outline: 0px solid white !important;
}
.feed-post-metrics
{
    width: 100%;
    height: 40px;
    padding: 10px 10px;
    border-bottom: 1px solid #2d3e5052;
    font-size: 13px;
    margin-top: 15px;
}
.feed-post-metrics span
{
  margin-right: 10px;
  text-align: center;
}
</style>
<section>
    <!-- Page content-->
    <div class="content-wrapper">
        <div class="row ">
            <div class="col-md-12">
                <div class="panels marginbtm-10">
                    <div class="main-heading">
                        <span class="fontcolor-primary text-bold">Social Feeds </span >            
                          <div class="float-right enquiries_header_icon">          
                            <span>
                              <a href="#" data-toggle="tooltip" title="Knowledge Base!"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAMAAADXqc3KAAAA0lBMVEUAAAAAgP8Aff8Ae/8Aff8Ae/8AfP8Aev0AfP8Ae/8AefoAX8QAX8QAYMUAYMUAYMYAYcYAYMQAYMYAW70AXL0AXL4AePUAePYAd/UAe/0Ae/4Aev0AW7wAXL0AXb4AXcAAevwAY8sAY8sAZM0AZc4AbeAAbeEAbeIAbuMAb+QAe/wAe/0AfP4AfP8Bff8IgP8QhP8Thv8jjv8pkf8vlP80l/82mP89m/9Bnf9Qpf9erP9frf90uP9+vf+UyP+x1/+22f+52//U6f/a7P/c7f/j8f/bq60bAAAAJXRSTlMAIDc4OzySlLe41Nvc3N3d3d7e4+Pj6Ojp6enq6+zt7e76/Pz8DToV1QAAANpJREFUKM+1UlcbgjAMBNkVcaMCAopb6xb3Qv3/f0nbUgSeNS+X765J2ksZ5vchSMB1gcSnaFbRVcfzHLWusHGeM4tDiGOgmVzsvFmFNCZV81ujFBG1vd/8D4xLcjRXR31mj93hNf0kfZ3eQFJRweoK4XOOspwYCsAJ+68DDDYIBbdD+EXgY/RcKnhEOJ0JtqkAbEIcNwSbIDEcwuWCoEqHC/UeJi57DN1aZJiijaOXw1FBjllSiZRR2YjZyDW0PuF7eSOTsF3Ws1arZWVrMpvaCC+iRYn8H/7AG+OYJgadRoX7AAAAAElFTkSuQmCC" class="img-height" title="Knowledge Base">
                              </a>
                            </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row social-panel">
        <div class="social-panel-inner">
            <div class="feed-panel">
                <div class="feed-panel-heading">
                	<p>Twitter </p>
                	<img src="<?= site_url('cms-assets/img/Twit.png') ?>" style="width:50px;">
                  
                       </div>
                <div class="feed-post-panel">
                   <?php if (!empty($twitter_user_tweets)) {
                    $i = 1;
                    foreach ($twitter_user_tweets as $key => $value) {
                      $entities = $value['entities'];
                      if (!empty($entities)) {
                          if (!empty($entities['media'])) {
                            $media_link = $entities['media'][0]['media_url_https'];
                          }else{
                            $media_link = '';
                          }
                      }
                      $likes = $value['favorite_count'];
                      $comments = $value['retweeted'];
                     ?>
                    <div class="feed-post">
                        <?php if(!empty($value['text'])){ ?>
                        <div class="feed-post-text">
                            <p><?php echo $value['text']; ?></p>
                            <hr/>
                        </div>
                        <?php } if(!empty($media_link)){ ?>
                        <div class="feed-post-image">
                            <img src="<?php echo $media_link; ?>">
                        </div>
                        <?php } ?>
                        <div class="feed-post-metrics">
                            <span id="<?php echo $value['id']; ?>" onclick="return my_tweet('<?php echo $value['id']; ?>')"><?php if (!empty($value['favorited'])) { ?><img src="<?= site_url('cms-assets/img/Liked heart Icon.png') ?>" style="width: 17px;"> <?php }else{ ?><img src="<?= site_url('cms-assets/img/Like heart Icon.png') ?>" style="width: 17px;"><?php } ?> <?php echo $likes; ?></span>
                            <span><img src="<?= site_url('cms-assets/img/Comment Icon.png') ?>" style="width: 17px;"> <?php echo $comments; ?></span>
                        </div>
                    </div>
                    <?php $i++; } }else{ ?>
                  <div class="feed-post">
                    <div class="feed-post-text">
                        No Data Available.      
                    </div>
                  </div>
                  <?php } ?>
                </div>
            </div>
            <div class="feed-panel">
                <div class="feed-panel-heading">
                    <p>LinkedIn</p>
                    
                    <img src="<?= site_url('cms-assets/img/Link.png') ?>" style="width:50px;">
                    <div class="col-md-12" style="margin-top:10px;">
              </div>
                </div>

                <div class="feed-post-panel">
                  <?php if (!empty($linkedin_company_share_data['values'])) { $i = 1; foreach ($linkedin_company_share_data['values'] as $value) { 
                    $updateContent = $value['updateContent'];
                    if (!empty($updateContent)) {
                        $message = $updateContent['companyStatusUpdate']['share']['comment'];
                        $media_link = $updateContent['companyStatusUpdate']['share']['content']['submittedImageUrl'];
                        $time = $updateContent['companyStatusUpdate']['share']['timestamp'];
                    }
                    $comments = $value['updateComments']['_total'];
                    $likes_count = $value['numLikes'];
                    $is_self_liked = $value['likes'];
                    $updateKey_og = $value['updateKey'];
                    $updateKey = explode("-", $updateKey_og);
                    $id = $updateKey[2];
                  ?>
                    <div class="feed-post">
                        <div style="float: right;"></div>
                        <?php if(!empty($message)){ ?>
                        <div class="feed-post-text">
                          <?php echo $message; ?>
                        </div>
                        <?php }if (!empty($media_link)) { ?>
                        <div class="feed-post-image">
                            <img src="<?php echo $media_link; ?>">
                        </div>
                        <?php } ?>
                        <div class="feed-post-metrics">
                          <?php if (!empty($is_self_liked)) {  ?>
                            <input type="hidden" name="is_like" id="is_like_<?php echo $id; ?>" value="<?php echo "unlike"; ?>">
                          <?php }else{ ?>
                            <input type="hidden" name="is_like" id="is_like_<?php echo $id; ?>" value="<?php echo "like"; ?>">
                          <?php } ?>
                          <!-- <span id="<?php echo $id; ?>" onclick="return social_like('<?php echo $updateKey_og; ?>','is_like_<?php echo $id; ?>','likes_count_<?php echo $id; ?>','linkedin_action')"> -->
                            <span id="<?php echo $id; ?>" > <?php if(!empty($is_self_liked)) { ?><img src="<?= site_url('cms-assets/img/Liked Icon.png') ?>" style="width: 17px;"><?php }else{ ?> <img src="<?= site_url('cms-assets/img/Likes Icon 02.png') ?>" style="width: 17px;"> <?php } ?><span id="likes_count_<?php echo $id; ?>"><?php echo $likes_count; ?></span></span>
                            <span><img src="<?= site_url('cms-assets/img/Comment Icon.png') ?>" style="width: 17px;"> <?php echo $comments; ?></span>
                        </div>
                    </div>
                  <?php $i++; } }else{ ?>
                  <div class="feed-post">
                    <div class="feed-post-text">
                        No Data Available.      
                    </div>
                  </div>
                  <?php } ?>
                </div>
            </div>
            <div class="feed-panel">
                <div class="feed-panel-heading">
                    <p>Facebook</p>
                    <img src="<?= site_url('cms-assets/img/Face.png') ?>" style="width:50px;">
                    
                </div>
                <input type="hidden" name="data_offset" id="data_offset" value="10">
                <div class="feed-post-panel fb_timeline" id="fb_ajax_data" data-offset="10" data-limit="10" data-status-scroll="0">
                    
                </div>
            </div>
        </div>
    </div>

</section>
<script src="https://code.jquery.com/jquery-1.10.2.js" style=""></script>
<script src="<?= site_url('cms-assets/js/sweetalert.min.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  //event.preventDefault();
  $.ajax({ url: "<?= site_url('SocialPost/facebook_feeds') ?>",
      type: 'POST',
      data: {req_type:'facebook_onload'},
      success: function(data){
        var obj = JSON.parse(data);
        if (obj.status == 'success') {
     		$('#fb_ajax_data').append(obj.result);
     	}else{
	        $('#fb_ajax_data').append(obj.result);
	    }
    }});
});

jQuery(function($) {
    $('.fb_timeline').on('scroll', function() {
        if($(this).scrollTop() + $(this).innerHeight() >= $(this)[0].scrollHeight) {
            var offset = $('#data_offset').val();
            og_offset = parseInt($('#fb_ajax_data').attr('data-offset'));
            scroll = parseInt($('#fb_ajax_data').attr('data-status-scroll'));
            var new_offset = parseInt(offset) + 10;
            if (offset == og_offset) {
            	$.ajax({ url: "<?= site_url('SocialPost/facebook_feeds') ?>",
	              type: 'POST',
	              data: {offset: offset, req_type:'facebook_pagination'},
	              success: function(data){
	                var obj = JSON.parse(data);
	                if (obj.status == 'success') {
	                 	$('#data_offset').val(new_offset);
	                 	$('#fb_ajax_data').attr('data-offset', new_offset);
	                 	$('#fb_ajax_data').append(obj.result);
	                }else{
	                 	$('#fb_ajax_data').append(obj.result);
	                 	$('#fb_ajax_data').attr('data-offset', new_offset);
	                }
	            }});
            }else{
            	if (scroll == 0) {
            		var null_html = '<div class="feed-post"> No Data Available. </div>';
            		$('#fb_ajax_data').append(null_html);
            	}
            	$('#fb_ajax_data').attr('data-status-scroll', '1');
            }
        }
    })
});

function my_tweet(tweet_id){
  console.log(tweet_id);
  $.ajax({ url: "<?= site_url('SocialPost/hit_likes') ?>",
          type: 'POST',
          data: {tweet_id: tweet_id,req_type:'twitter_like'},
          success: function(data){
             console.log(data);
             //alert("done");
          }
  });

}
function my_fb_like(fb_p_id,fb_is_like,lyk_count){
  var fb_action = $('#'+fb_is_like).val();
  var likes_count = $('#'+lyk_count).text();
  var add_likes_count = parseInt(likes_count) + 1;
  var sub_likes_count = parseInt(likes_count) - 1;
  $.ajax({ url: "<?= site_url('SocialPost/hit_likes') ?>",
          type: 'POST',
          data: {fb_post_id: fb_p_id,req_type_fb:'facebook_hit_like',fb_action: fb_action},
          success: function(data){
            var obj = JSON.parse(data);
            if (obj.success == true && obj.status == 'like') {
              $('#'+fb_p_id+' img').attr("src", "http://social.altmarkit.com/cms-assets/img/Liked Icon.png");
              $('#'+fb_is_like).val('unlike');
              $('#'+lyk_count).text(add_likes_count);  
            }
            if(obj.success == true && obj.status == 'unlike') {
              $('#'+fb_p_id+' img').attr("src", "http://social.altmarkit.com/cms-assets/img/Likes Icon 02.png");
              $('#'+fb_is_like).val('like');
              $('#'+lyk_count).text(sub_likes_count);
            }
        }
  });
}

function social_like(post_id,is_post_like_unlike,post_lyk_count,social_type){
  // social_action is like or unlike
  var social_action = $('#'+is_post_like_unlike).val();
  var likes_count = $('#'+post_lyk_count).text();
  var add_likes_count = parseInt(likes_count) + 1;
  var sub_likes_count = parseInt(likes_count) - 1;
  $.ajax({ url: "<?= site_url('SocialPost/hit_likes') ?>",
          type: 'POST',
          data: {post_id: post_id,social_action: social_action,req_type: social_type},
          success: function(data){
            var obj = JSON.parse(data);
            if (obj.success == true && obj.status == 'like') {
              $('#'+fb_p_id+' img').attr("src", "http://social.altmarkit.com/cms-assets/img/Liked Icon.png");
              $('#'+fb_is_like).val('unlike');
              $('#'+lyk_count).text(add_likes_count);  
            }
            if(obj.success == true && obj.status == 'unlike') {
              $('#'+fb_p_id+' img').attr("src", "http://social.altmarkit.com/cms-assets/img/Likes Icon 02.png");
              $('#'+fb_is_like).val('like');
              $('#'+lyk_count).text(sub_likes_count);
            }
        }
  });

}

function social_delete_post(network,post_id){
    console.log(post_id);
    swal({
     title: "Are you sure?",
     text: "Once deleted, you will not be able to recover this from Facebook!",
     icon: "warning",
     buttons: true,
     dangerMode: true,
   })
   .then((willDelete) => {
     if (willDelete) {
       $.ajax({
       type: "POST",
            url: "<?= site_url('SocialPost/social_delete_post') ?>",
            async : false,
            data:{'fb_post_id':post_id,'reqtype':'network'},
            success : function(data){
             console.log(data);
           }
       });
       swal("Poof! Post has been deleted!", {
         icon: "success", 
       });
       myVar = setTimeout(alertFunc, 2000);
       
     } else {
       swal("Post is safe!"); 
     }
   });
}

function open_commentbox(e){
    $('#'+e).show();
    $('#'+e).parent('div .feed-post-metrics').css('height','150px');
}

function mykeyFunction(e,id){
	if (e.which == 13) {
		e.preventDefault();
    	var comment = $('#'+id).val();
    	var tmp_arr_id = id.split('_');
    	post_id = tmp_arr_id[1]+'_'+tmp_arr_id[2];
    	$.ajax({
	        type: "POST",
	        url: "<?= site_url('SocialPost/hit_comment') ?>",
	        async : false,
	        data:{'post_id':post_id,'comment':comment,'req_type':'facebook_comment'},
	        success : function(data){
		        var obj = JSON.parse(data);
	        	if (obj.success == true && obj.status == 'comment') {
	        		var new_html = '<span style="border: 1px solid #2d3e50;border-radius: 10px;padding: 0.01em 16px;">' + comment + '</span><br>';
	        		$('#comment_box_'+post_id).append(new_html);
	        		$('#'+id).val('');
	        	}
	    	}
	    });
  	}
}

function alertFunc() {
   window.location.reload(true);
}

</script>