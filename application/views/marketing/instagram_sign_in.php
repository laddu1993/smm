<script>
window.location = 'https://api.instagram.com/oauth/authorize/?client_id=<?php echo $Client_ID; ?>&redirect_uri=<?php echo $callback_url; ?>&response_type=code&scope=basic+likes+public_content';
//window.location = 'https://api.instagram.com/oauth/authorize/?client_id=<?php echo $Client_ID; ?>&redirect_uri=<?php echo $callback_url; ?>&response_type=code&scope=basic+likes+public_content+follower_list+relationships+comments';
</script>
<?php //echo(!empty($oauthURL) ? $oauthURL : ''); ?>