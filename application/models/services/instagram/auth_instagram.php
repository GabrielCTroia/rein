<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Fetch_model
require_once( APPPATH . 'models/Auth_abstract.php' );

class Auth_instagram extends Auth_abstract{
    
    /* 
     * the consumer key specific for each service
     */
    protected $consumer_key = '89167de1acc3478ca6c602f0cb3a6893';      
    
    /* 
     * the callback url 
     */
    protected $callback_url = 'http://rein.smalldeskideas.com/index.php/callback/service/instagram';
  
    /* 
     * the base API URL  
     */
    protected $base_url = 'https://api.instagram.com/oauth/authorize/';
        
        
    /* 
     * the base API URL  
     */
    protected $scope = null;

    
    
    public function request_temp_token(){
      
      $url = $this->base_url . "?client_id=" . $this->consumer_key . "&redirect_uri=" . $this->callback_url . "&response_type=code"; 
                
      /* in case there is a scope add it to the URL */
      if( isset( $this->scope ) && is_array( $this->scope ) )
      	$url .= implode( "+" , $this->scope );    
      
      redirect( $url );
      
    }
  
  
    public function request_access_token(){
      
      
    }
    
    
    public function callback(){
      
    }
  
  
}  













/* End of file Auth_instagram.php */
/* Location: ./application/models/services/twitter/Auth_instagram.php */