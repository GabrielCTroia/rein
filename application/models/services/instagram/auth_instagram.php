<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Fetch_model
require_once( APPPATH . 'models/auth_class.php' );

class Auth_instagram extends Auth_class{
  
  //should come from the DB but will do for now
  protected $service_name = "instagram"; 
  

  public function __construct(){
    
    parent::__construct();
    
    $app_config = array(
      'client_id'         => $this->consumer_key,
      'client_secret'     => $this->consumer_secret,
      'redirect_uri'      => $this->callback_url,
      'scope'             => $this->scope
    );

    $this->api = new Instagram\Auth( $app_config );;
    
  }
  
  /* see models/auth_class.php */
  public function api_return( $temp_token ){
    
    if( $token = $this->generate_access_token( $temp_token['code'] ) ) {
      
      return array( 'token' => $token , 'user_id' => 'not set yet' );
      
    }
    
    return false;
      
  }
  

  public function request_temp_token(){
    
    if( empty( $this->base_url ) ){
      
      $this->error = true;
      
      $this->error_msg = "No base_url defined";
      
      echo $this->error_msg;
      
      return false;
      
    }
    
    $url = $this->base_url . "?client_id=" . $this->consumer_key . "&redirect_uri=" . $this->callback_url . "&response_type=code"; 
              
    /* in case there is a scope add it to the URL */
    if( isset( $this->scope ) && is_array( $this->scope ) )
    	$url .= implode( "+" , $this->scope );    
    
    redirect( $url );
    
  }


  public function generate_access_token( $temp_token ){
      
    if ( $token = $this->api->getAccessToken( $temp_token ) ) {
      
      return $token;
      
    } 
    
    return false;
    
  }
  
  
}  













/* End of file Auth_instagram.php */
/* Location: ./application/models/services/twitter/Auth_instagram.php */