<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Fetch_model
require_once( APPPATH . 'models/auth_class.php' );

class Auth_instagram extends Auth_class{
    
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
  protected $callback_url = 'http://127.0.0.1:8888/auth/callback/instagram';

  /* 
   * the base API URL  
   */
  protected $base_url = 'https://api.instagram.com/oauth/authorize/';
      
      
  /* 
   * the base API URL  
   */
  protected $scope = null;


  function __construct(){

    //load the necessary libraries for the service
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

    $app_config = array(
	    'client_id'         => $this->consumer_key,
	    'client_secret'     => $this->consumer_secret,
	    'redirect_uri'      => $this->callback_url,
	    'scope'             => $this->scope
	  );    
    
    $auth = new Instagram\Auth( $app_config );
    
    $data = null;
    
    if ( $code = $temp_token['code'] ) {
      
      try {
          $data['access_token'] = $auth->getAccessToken( $code );
      }
      catch ( \Instagram\Core\ApiException $e ) {
          $data['error'] = ucwords( $e->getMessage() );
      }
      
    }
    
    return $data;
    
  }
  
  
}  













/* End of file Auth_instagram.php */
/* Location: ./application/models/services/twitter/Auth_instagram.php */