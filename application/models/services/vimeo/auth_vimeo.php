<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Fetch_model
require_once( APPPATH . 'models/auth_class.php' );

class Auth_vimeo extends Auth_class{
    
    
  protected $service_name = "vimeo";
      
  /* 
   * the base API URL  
   */
  protected $scope = 'read';
  
  
  /* 
   * the service object 
   */
  private $vimeo = null;


  function __construct(){
  
    parent::__construct();
    
    $this->api = new phpVimeo( $this->consumer_key , $this->consumer_secret );
    
  }
  
  
  /* 
   * see models/auth_class.php 
   * ALWAYS USE $this-format_api_return WHEN RETURN
   */
  public function api_return( $temp_token ){
    
    if( $tokens = $this->generate_access_token( $temp_token ) ) {           
            
      return $this->format_api_return( $tokens['oauth_token'] , $tokens['oauth_token_secret'] );
      
    }
    
    return false;
      
  }
  
  
  
  
  



  public function request_temp_token(){
    
    // Get a new request token
    $tokens = $this->api->getRequestToken( );
        
    //save it in the session to be used in the callback - vimeo class does it crazy
    $this->session->set_userdata( $tokens );
    
    $url = $this->api->getAuthorizeUrl( $tokens['oauth_token'] , $this->scope );
        
    redirect( $url );
    
  }




  public function generate_access_token( $temp_token ){
    
    $this->api->setToken( $this->session->userdata['oauth_token'] , $this->session->userdata['oauth_token_secret'] );
    
    if( $tokens = $this->api->getAccessToken( $temp_token['oauth_verifier'] ) ){
      
      return $tokens;
      
    } 
          
    return false;
    
  }
  
}  













/* End of file Auth_instagram.php */
/* Location: ./application/models/services/twitter/Auth_instagram.php */