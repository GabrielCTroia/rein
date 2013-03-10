<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Fetch_model
require_once( APPPATH . 'models/auth_class.php' );

class Auth_vimeo extends Auth_class{
    
  /* 
   * the consumer key specific for each service
   */
  protected $consumer_key = '862103b8d1e32733d80d1a7fbfcded18413dca64';   
  
  /* 
   * the consumer key specific for each service
   */
  protected $consumer_secret = '78a6aa39c0b46970d11946528062bc3acf303ca9';      
  
  /* 
   * the callback url 
   */
  protected $callback_url = 'http://127.0.0.1:8888/auth/callback/vimeo';

  /* 
   * the base API URL  
   */
  protected $base_url = 'https://vimeo.com/oauth/authorize';
      
      
  /* 
   * the base API URL  
   */
  protected $scope = 'read';
  
  
  /* 
   * the service object 
   */
  private $vimeo = null;


  function __construct(){

    //load the necessary libraries for the service
    include_once( __DIR__ . '/load_library.php'); 
    
    $this->vimeo = new phpVimeo( $this->consumer_key , $this->consumer_secret );
  }


  public function request_temp_token(){
    
    // Get a new request token
    $tokens = $this->vimeo->getRequestToken( );
        
    //save it in the session to be used in the callback - vimeo class does it crazy
    $this->session->set_userdata( $tokens );

    
    $url = $this->vimeo->getAuthorizeUrl( $tokens['oauth_token'] , $this->scope );
        
    redirect( $url );
    
  }


  public function generate_access_token( $temp_token ){
    
    $this->vimeo->setToken( $this->session->userdata['oauth_token'] , $this->session->userdata['oauth_token_secret'] );
    
    if( !$data = $this->vimeo->getAccessToken( $temp_token['oauth_verifier'] ) ){
      
      $this->error = true;
      
      $this->error_msg = "no returned access_token";
      
      return false;
      
    } else if( empty( $data['oauth_token'] ) ) {
    
      $this->error = true;
      
      $this->error_msg = $data;
      
      return false;
      
    } else {
      
      $data['access_token'] = $data['oauth_token'];
      
      return $data;
      
    }
    
  }
  
}  













/* End of file Auth_instagram.php */
/* Location: ./application/models/services/twitter/Auth_instagram.php */