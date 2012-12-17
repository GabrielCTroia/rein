<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



/* redirect( 'index.php/login' , 'refresh' ); */


	
/* session_start(); */


/*
$_SESSION['instagram_access_token'] = '50301110.89167de.b9d6dab7f3874ee4966bb05fcb75e4b0';
$_SESSION['access_token']['oauth_token'] = "84832050-eZOvIj6Cb1nN7qZKOcEhiQUEYNqmJPVNXN62cfuuI";
$_SESSION['access_token']['oauth_token_secret'] = "GILEju4NP8f6XMJ5NYH9Mn9rRvGHyJARrv0xxUQ7Dc";
*/

/* include_once( APPPATH . "models/twitter/twitter.php"); */
/* include_once( APPPATH . "models/instagram/instagram.php"); */




/* include_once( APPPATH . "models/vimeo/vimeo.php"); */


/* return; */
//include_once( APPPATH . "models/google/google.php");

//load the main thing
/* include_once( APPPATH . "models/model.php"); */



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en">
	<head>
		<link rel="stylesheet" href="<? echo APPPATH; ?>css/general.css" />
	
	</head>
	<body>
		<div class="page page-<? echo $component->name; ?> grain full-height">
			<? $this->load->view($component->path); ?>
		</div> <!-- eof .page -->
		
		<footer>
		
		</footer>
		
	</body>
</html>