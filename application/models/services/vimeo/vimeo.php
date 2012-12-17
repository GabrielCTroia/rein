<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @file
 * User has successfully authenticated with Twitter. Access tokens saved to session and DB.
 */
 include_once( APPPATH . 'libraries/vimeo/vimeo.php');
 
#
#$vimeo = new phpVimeo( $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
$vimeo = new phpVimeo('862103b8d1e32733d80d1a7fbfcded18413dca64', '78a6aa39c0b46970d11946528062bc3acf303ca9'); 
 
/* $vimeo->setToken($_SESSION['oauth_request_token'], '2e78618862b878ca31ac426b68779814d21fbdd5');  */
$vimeo->setToken($_SESSION['vimeo_oauth_access_token'], $_SESSION['vimeo_oauth_access_token_secret']);
													
# echo $_SESSION['oauth_access_token']; 
 echo "<br/>";
echo $_SESSION['vimeo_oauth_access_token_secret'];
echo "<br/>";
#var_dump($vimeo);

/* echo session_id(); */

/* echo $_SESSION['vimeo_oauth_access_token']; */
echo "<br/>";

/* var_dump($vimeo); */
/* echo $_SESSION['vimeo_oauth_request_token_secret']; */

$videos = $vimeo->call('vimeo.albums.getWatchLater', $_SESSION['vimeo_oauth_access_token']);
/* print_r($videos); */


/* $vimeo->call('vimeo.videos.setTitle', array('user_id' => 10486857 ) ); */
#$videos = $vimeo->call('vimeo.albums.getWatchLater', $_SESSION['oauth_access_token']);

/* Load required lib files. */
?>
<br/>
<a href="<?php echo htmlspecialchars_decode('http://vimeo.com/api/rest/v2&format=json&method=vimeo.activity.userDid&oauth_consumer_key=c1f5add1d34817a6775d10b3f6821268&oauth_nonce=b297496f5184c5b8e1340253a9e4706f&oauth_signature_method=HMAC-SHA1&oauth_timestamp=1352939058&oauth_token=e269370b18fe3ccbc68d376309778e7b&oauth_version=1.0&page=1&per_page=2&user_id=10486857'); ?>">go</a>
<a href="<?php echo APPPATH . 'libraries/vimeo/index.php' ?>" >connect with vimeo</a>