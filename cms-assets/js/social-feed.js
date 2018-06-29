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