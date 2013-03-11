<?php

// Turn on error reporting
/*
error_reporting( E_ALL );
ini_set( 'display_errors', 'On' );
*/

require_once('vimeo.php');


if(!session_id()) session_start();




// Create the object and enable caching
$vimeo = new phpVimeo('862103b8d1e32733d80d1a7fbfcded18413dca64', '78a6aa39c0b46970d11946528062bc3acf303ca9'); 
#$vimeo = new phpVimeo('862103b8d1e32733d80d1a7fbfcded18413dca64', '78a6aa39c0b46970d11946528062bc3acf303ca9', 'c6b32389a8329e25b495076004978c6f', 'b2a0439afa17c7a05dabd1475ee7700d8f86a7e1');
/* $vimeo->enableCache(phpVimeo::CACHE_FILE, './cache', 300); */

echo session_id();

// Clear session
if ($_GET['clear'] == 'all') {
    session_destroy();
    session_start();
}

// Set up variables
$state = $_SESSION['vimeo_state'];
$request_token = $_SESSION['oauth_request_token'];
$access_token = $_SESSION['vimeo_oauth_access_token'];

var_dump($access_token);
var_dump($_SESSION['vimeo_oauth_access_token_secret']);
#echo (""$_SESSION['oauth_access_token']);

// Coming back
if ($_REQUEST['oauth_token'] != NULL && $_SESSION['vimeo_state'] === 'start') {
    $_SESSION['vimeo_state'] = $state = 'returned';
}

// If we have an access token, set it
if ($_SESSION['vimeo_oauth_access_token'] != null) {
    $vimeo->setToken($_SESSION['vimeo_oauth_access_token'], $_SESSION['vimeo_oauth_access_token_secret']);
}

switch ($_SESSION['vimeo_state']) {
    default:
        // Get a new request token
        $token = $vimeo->getRequestToken();

        // Store it in the session
        $_SESSION['oauth_request_token'] = $token['oauth_token'];
        $_SESSION['oauth_request_token_secret'] = $token['oauth_token_secret'];
        $_SESSION['vimeo_state'] = 'start';
        // Build authorize link
        $authorize_link = $vimeo->getAuthorizeUrl($token['oauth_token'], 'read');

        break;

    case 'returned':
        // Store it
        if ($_SESSION['vimeo_oauth_access_token'] === NULL && $_SESSION['vimeo_oauth_access_token_secret'] === NULL) {

          	  // Exchange for an access token
            $vimeo->setToken($_SESSION['oauth_request_token'], $_SESSION['oauth_request_token_secret']);
            $token = $vimeo->getAccessToken($_REQUEST['oauth_verifier']);

            // Store
            $_SESSION['vimeo_oauth_access_token'] = $token['oauth_token'];
            $_SESSION['vimeo_oauth_access_token_secret'] = $token['oauth_token_secret'];
            $_SESSION['vimeo_state'] = 'done';

            // Set the token
            $vimeo->setToken($_SESSION['vimeo_oauth_access_token'], $_SESSION['vimeo_oauth_access_token_secret']);
        }

        // Do an authenticated call
        try {
        	echo "<br/>";
        	 var_dump($vimeo);
            $videos = $vimeo->call('vimeo.albums.getWatchLater', $_SESSION['vimeo_oauth_access_token']);
        }
        catch (VimeoAPIException $e) {
            echo "Encountered an API error -- code {$e->getCode()} - {$e->getMessage()}";
        }

        break;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Vimeo Advanced API OAuth Example</title>
</head>
<body>

    <h1>Vimeo Advanced API OAuth Example</h1>
    <p>This is a basic example of Vimeo's new OAuth authentication method. Everything is saved in session vars, so <a href="?clear=all">click here if you want to start over</a>.</p>
    
    

    <?php if ($_SESSION['vimeo_state'] == 'start'): ?>
        <p>Click the link to go to Vimeo to authorize your account.</p>
        <p><a href="<?= $authorize_link ?>"><?php echo $authorize_link ?></a></p>
    <?php endif ?>

    <? 
	    
/* 	    var_dump( $vimeo->call('vimeo.activity.happenedToUser', array('user_id' => '10486857')) ); */
	    
/* 	    $watchLater = $vimeo->call('vimeo.albums.getWatchLater');  */
	    
	    
	    
/* 	    var_dump($watchLater); */
	    
/* 	    var_dump("DA"); */
	    
	    
    ?>
    

    <?php if ($ticket): ?>
        asda
        <pre><?php print_r($ticket) ?></pre>
    <?php endif ?>

    <?php if ($videos): ?>
    
        <pre><?php print_r($videos) ?></pre>
    <?php endif ?>

</body>
</html>
