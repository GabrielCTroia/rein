<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Fetch_model
require_once( APPPATH . 'models/auth_abstract.php' );

class Auth_instagram extends Auth_abstract{
    
  /* 
   * the consumer key specific for each service
   */
  protected $consumer_key = '89167de1acc3478ca6c602f0cb3a6893';   
  
  
  /* 
   * the consumer key specific for each service
   */
  protected $consumer_secret = 'dbe1cb5c5f0a4535b566e73bf06a0455';      
  
  /* 
   * the callback url 
   */
  protected $callback_url = 'http://rein.smalldeskideas.com/auth/callback/instagram';

  /* 
   * the base API URL  
   */
  protected $base_url = 'https://api.instagram.com/oauth/authorize/';
      
      
  /* 
   * the base API URL  
   */
  protected $scope = null;


  function __construct(){
    
    //load the necessay libraries for the service
    include_once( __DIR__ . '/load_library.php'); 
    
  }

  public function request_temp_token(){
    
    $url = $this->base_url . "?client_id=" . $this->consumer_key . "&redirect_uri=" . $this->callback_url . "&response_type=code"; 
              
    /* in case there is a scope add it to the URL */
    if( isset( $this->scope ) && is_array( $this->scope ) )
    	$url .= implode( "+" , $this->scope );    
    
    redirect( $url );
    
  }


  public function generate_access_token( $temp_token ){
    
    //took from libraries/instagram/auth.php getAccessToken()				
    $app_config = array(
	    'client_id'         => $this->consumer_key,
	    'client_secret'     => $this->consumer_secret,
	    'redirect_uri'      => $this->callback_url,
	    'scope'             => $this->scope
	  );
	        
	  $auth = new Instagram\Auth( $app_config );
    
    $auth->getAccessToken( $temp_token['code'] );
        
	  $access_token = '{ 
	    
	    "access_token"	: "' . $auth->getAccessToken( $temp_token['code'] ) . '"
	  
	                  }';		        
    
    var_dump($access_token);
  }
  
  
}  













/* End of file Auth_instagram.php */
/* Location: ./application/models/services/twitter/Auth_instagram.php */