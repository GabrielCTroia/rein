<? if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . "libraries/Oath/EpiCurl.php" );
require_once( APPPATH . "libraries/Oath/EpiOAuth.php" );
require_once( APPPATH . "libraries/Oath/EpiTwitter.php" );
	
require_once( "keys.php" );
	
	
$Twitter = new EpiTwitter($consumerKey, $consumerSecret);
/* var_dump($Twitter); */
if(isset($_GET['oauth_token']) || (isset($_COOKIE['oauth_token']) && isset($_COOKIE['oauth_token_secret']) ) ) : ?>
  
  <? 
/* 	  echo $_GET['oauth_token']; */
/*
	  echo $_COOKIE['oauth_token']; 
	  echo "<br/>";
	  echo $_COOKIE['oauth_token_secret'];
	  echo "<br/>";
*/
	  
	// user has signed in
	if( !isset($_COOKIE['oauth_token']) || !isset($_COOKIE['oauth_token_secret']) )
	{
		// user comes from twitter
                // send token to twitter
	        $Twitter->setToken($_GET['oauth_token']);
               // get secret token
		$token = $Twitter->getAccessToken();
                // make the cookies for tokens
		setcookie('oauth_token', $token->oauth_token);
		setcookie('oauth_token_secret', $token->oauth_token_secret);
        
               // pass tokens to EpiTwitter object
		$Twitter->setToken($token->oauth_token, $token->oauth_token_secret);

	}
	else
	{

		 // user switched pages and came back or got here directly, stilled logged in
	     // pass tokens to EpiTwitter object
		 $Twitter->setToken($_COOKIE['oauth_token'],$_COOKIE['oauth_token_secret']);
	}
	
	$user= $Twitter->get_accountVerify_credentials();
	$friendIds = $Twitter->get('/friends/ids.json', array('screen_name' => $twitterInfo->
screen_name));

	var_dump($friendIds);
	
/* 	var_dump($Twitter); */
/* 	var_dump($user); */
  ?>
  
  
  
  <a href="/index.php/signout">log out</a>
  <br/>
  
  
<? elseif(isset($_GET['denied'])) : ?>
	
	<a href="<? echo $Twitter->getAuthenticateUrl(); ?> ">You must sign in through twitter first</a>
	
	
<? else : ?>
	
	<a href="<? echo $Twitter->getAuthenticateUrl(); ?> ">Sign in with twitter</a>
	
<? endif; ?>