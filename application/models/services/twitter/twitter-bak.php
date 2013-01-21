<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	if( $_SESSION['access_token'] ) {
		
		require_once( APPPATH . 'libraries/twitteroauth-master/twitteroauth/twitteroauth.php');
		require_once( APPPATH . 'libraries/twitteroauth-master/config.php');
		
		$twitter = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, $_SESSION['access_token']['oauth_token'], $_SESSION['access_token']['oauth_token_secret']);

		
		$tweets = $twitter->get('favorites', array( "count" => 100 )); 
	}
	
	else {
?>
	 <a href="<?php echo APPPATH . 'libraries/twitteroauth-master/redirect.php' ?>" >connect with twitter</a>
<?php  } ?>
