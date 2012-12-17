<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');




$Twitter = new EpiTwitter($consumerKey, $consumerSecret);
/* var_dump($Twitter); */
	
?>

<a href="<? echo $Twitter->getAuthenticateUrl(); ?> ">
sign in with twitter
</a>

<? 

if(isset($_GET['oauth_token']) || (isset($_COOKIE['oauth_token']) && isset($_COOKIE['oauth_token_secret'])))
{
  // user has signed in
  echo "user is in";
  
  
}
elseif(isset($_GET['denied']))
{
 // user denied access
 echo 'You must sign in through twitter first';
}
else
{
// user not logged in
 echo 'You are not logged in';
}



?>
