<?php 
	
	/* Load required lib files. */
/*
	$auth = 
	
	
	session_start();
	
	$_SESSION['instagram_access_token'] = $auth->getAccessToken( $_GET['code'] );
	
	echo $_SESSION['instagram_access_token'];
*/
		
	
/* 	$url = "/" . APPPATH . "libraries/PHP-Instagram-API-master/Examples/current_user.php" . $params; */
	
		
/*
echo "DA";
return;	
*/
	
/* 	header ("Location: $url");	 */
	
/*
	include_once( APPPATH . 'libraries/sesser-Instaphp/instaphp.php' );
	
	//-- To authenticate, simply grab the code in your callback url
	$code = $_GET['code'];
	
	if (!empty($code)) {
		
	    //-- Create an Instaphp instance
	    $api = Instaphp\Instaphp::Instance();
	    
	    //-- Authenticate
	    $response = $api->Users->Authenticate($code);

	    var_dump($response->error);
	    //-- If no errors, grab the access_token (and cookie it, if desired)
	    if (empty($response->error)) {
	        $token = $response->auth->access_token;
	        setcookie('instaphp', $token, strtotime('30 days'));
	        //-- once you have a token, update the Instaphp instance so it passes the token for future calls
	        $api = Instaphp\Instaphp::Instance($token);
	    }
	} 
*/
		
/* 		index.php?oauth_token=6674b76fa915b955c4a84ec00c3116&oauth_verifier=3f970ca5c53c7c7824a8bb6df0ef7e18fdc7c012 */
		
/* 		rein.smalldeskideas.com/index.php/callback?service=vimeo&oauth_token=9fa14d5c455280e406dbb90133b3bb69&oauth_verifier=26644b980cd99ea4c2e95b0c03ebceb92a68bc44 */
/* 	   		  oauth_token=9fa14d5c455280e406dbb90133b3bb69&oauth_verifier=26644b980cd99ea4c2e95b0c03ebceb92a68bc44 */
/* 		rein.smalldeskideas.com/application/libraries/vimeo/index.php?	   															   */
		
		//rein.smalldeskideas.com/index.php/callback?service=vimeo&oauth_token=9b372198615364c5b590c3f8f7e6601d&oauth_verifier=e6856f640bdfd5d3304a26008333e4a0a86f4066
		error_reporting( E_ALL );
		ini_set( 'display_errors', 'On' );
		
		if ( !isset($_GET['service']) ) die ("The service is not defined."); 
		
		switch( $_GET['service'] ){
			
			case ( $_GET['service'] == 'vimeo' ) : 
				echo "vimeo";
#				return;
				$oauth_token = "oauth_token=" . $_REQUEST['oauth_token'];
				$oauth_verifier = "oauth_verifier=" . $_REQUEST['oauth_verifier'];
				
				$params = "?service=vimeo&" . $oauth_token . "&" . $oauth_verifier;
				
				$url = "/" . APPPATH . "libraries/vimeo/index.php" . $params;
				
				header("Location: $url");				
			break;	
			
			case ( $_GET['service'] == 'twitter' ) :
				
				$oauth_token = "oauth_token" . $_REQUEST['oauth_token'];
				$oauth_verifier = "oauth_verifier" . $_REQUEST['oauth_verifier'];
			
				
				$params = "?" . $oauth_token . $oauth_verifier;
			
				
				$url = "/" . APPPATH . "libraries/twitteroauth-master/callback.php" . $params;
				
				header ("Location: $url");	
			
			break;
			
			case ( $_GET['service'] === 'instagram' ) :
			
				$oauth_token = "oauth_token" . $_REQUEST['oauth_token'];
				$oauth_verifier = "oauth_verifier" . $_REQUEST['oauth_verifier'];
			
				$params = "?" . $_REQUEST['code'];
			
				$url = "/" . APPPATH . "libraries/PHP-Instagram-API-master/Examples/index.php" . $params;
				
				header ("Location: $url");	
			break;
		}
	
?>