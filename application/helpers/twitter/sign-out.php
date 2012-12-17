<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* echo( $_COOKIE['oauth_token'] ); */

/* setcookie("oauth_token", '', -100); */
/*
unset( $_COOKIE['oauth_token'] );
unset( $_COOKIE['oauth_token_secret'] );
*/
/* setcookie("oauth_token_secret", '', time()-3600); */

/* echo "<br/>"; */
/* echo($_COOKIE['oauth_token']); */
/*
echo $_COOKIE['oauth_token_secret'];
echo $_COOKIE['oauth_token'];
*/

// Destroy the session
        if (isset($_SESSION)) {
            session_destroy();
        }
        
        
         if ( isset($_SERVER['HTTP_COOKIE']) ) {
	          
	        $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
            foreach($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time()-1000);
                setcookie($name, '', time()-1000, '/');
	         }

	         header("Location: / ");
	         
/*
	         $params = session_get_cookie_params();
	         
	         setcookie(session_name(), '', 0, $params['path'], $params['domain'], $params['secure'], isset($params['httponly']));
*/
	         
/* 	         echo $_SERVER['HTTP_COOKIE']; */
/* 	         var_dump($params); */
	         
         }
        
/* session_write_close(); */

/* if( !isset($_COOKIE['oauth_token']) && !isset($_COOKIE['oauth_token_secret']) ) */
	
?>
