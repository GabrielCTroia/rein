<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
Class Connect extends CI_Model
{	
	
	private $service_name = false;
	private $param = false;
	
/*
	@service_name = 
	@param = array() with : the access tokens
			 				the app codes
*/			
	function initialize( $service_name , $param ){
		
		$this->set_service( $service_name );
		$this->set_param( $param );
		
		$this->load_library();	
	}
	
	function set_service( $service_name ) 
	{
		
		$this->service_name = $service_name;
	
	}
	
	function set_param( $param )
	{
		$this->param = $param;
	}

	
	function load_library( $service_name = false )
	{
		// TO DO
		// get rid of the switch - should be able to load anyservice based on the $this->service
		// this means that the Ouath Libraries (classes) needs be rewritten 
		// grouped together
		
		if ( !$service_name ) $service_name = $this->service_name;
		
		switch ( $service_name ){
			
			case 'twitter' : 
			
				require_once( APPPATH . 'libraries/twitteroauth-master/twitteroauth/twitteroauth.php');
				require_once( APPPATH . 'libraries/twitteroauth-master/config.php');				
					
				return true;
					
			break;
			
			case 'instagram' : 

				require_once( APPPATH . '/libraries/PHP-Instagram-API-master/Examples/_SplClassLoader.php' );
				
				$loader = new SplClassLoader( 'Instagram', dirname( APPPATH . 'libraries/PHP-Instagram-API-master/Instagram' ) );
				$loader->register();
				
				return $loader;
					
			break;
			
		}

		return false;

	}
	
	//redirect to the specifc authenticate service page
	function route( $service_name = false ){

		if ( !$service_name ) $service_name = $this->service_name;
		
		$url = "";
		
		switch( $service_name )
		{
			case "twitter" : 
				
				$connection = new TwitterOAuth( $this->param->consumer_key , $this->param->consumer_secret );
				
				$request_token = $connection->getRequestToken();
				
				$temp_oauth = array(
					'oauth_token' 			=> $request_token['oauth_token'] ,444xxxx
					'oauth_token_secret'	=> $request_token['oauth_token_secret'] 
				);
				
				/* Save temporary credentials to session. */
				/* the callback url doesn't provide me the oauth_secret back - kind of stupid */
				$this->session->set_userdata( $temp_oauth );

				$url = $connection->getAuthorizeURL( $request_token );

			break;

			case "instagram" : 

				$base_url = "https://api.instagram.com/oauth/authorize/";
				$url = $base_url . "?client_id=" . $this->param->consumer_key . "&redirect_uri=" . $this->param->callback_url . "&response_type=code"; 
                
          if( isset( $this->param->scope ) ) {
          	
          	//in case there is a scope add it to the URL
          	//for now I use the implicit basic which is perfect 
          	//for retrieveing the feed, so I don't need any other scop
          	$url .= implode( "+" , $this->param->scope );    
        	
            }
                
                
			
			break;				
			
		}
		
		redirect( $url );
		
	}
	
	function auth(  )
	{
		//this is going to take over route and use the route just for routing not for the logic
		
		$this->route();
	}
	
	//get the live posts based on the service and format
	// will be .json / .xml / or default = raw 
	function get_live_posts( $param = false , $format = 'raw' ) 
	{	
		
		if( !$this->param ) return false;
		// TO DO
		// get rid of the switch - should be able to load anyservice based on the $this->service
		// this means that the Ouath Libraries (classes) needs be rewritten 
		// grouped together
		switch ( $this->service_name ){
			
			case 'twitter' : 

				$service = new TwitterOAuth( "" , "" , $this->param->oauth_token, $this->param->oauth_token_secret);

                //when I will do the Oauth classes and each particular one
                //I should return an error if the access_token is not given or is not thr right one
                // Right now if one of this condition is not fulfiled the server return an error and is not right
                // If those are not working it should let me reconnect
                
                $param_arr = array(
         				"count"		=> 20			       	
		                );
		         
		        if ( isset( $param['since_id'] ) && $param['since_id'] )  $param_arr['since_id'] = $param['since_id'];
		        if ( isset( $param['max_id'] ) && $param['max_id'] )  $param_arr['max_id'] = $param['max_id'];
		        
				return $service->get('favorites', $param_arr );
			
			break;
			
			case 'instagram' : 
				
				$instagram = new Instagram\Instagram;
				
				$instagram->setAccessToken( $this->param->access_token );
				
                //when I will do the Oauth classes and each particular one
                //I should return an error if the access_token is not given or is not thr right one
                // Right now if one of this condition is not fulfiled the server return an error and is not right
                // If those are not working it should let me reconnect
				
				$user = $instagram->getCurrentUser();
				
				$param_arr = array(
         				"count"		=> 20			       	
		                );
		         
		        if ( isset( $param['since_id'] ) && $param['since_id'] )  $param_arr['since_id'] = $param['since_id'];
		        if ( isset( $param['max_id'] ) && $param['max_id'] )  $param_arr['max_id'] = $param['max_id'];
				
				
				return $user->getLikedMedia( $param_arr );			
				
			break;
			
		}
		
		return false;
		
	}
	


}

//pure php doesn't need the closing tag