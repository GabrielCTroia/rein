<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Fetch_model
require_once( APPPATH . 'models/auth_class.php' );

class Auth_youtube extends Auth_class{
  
  //should come from the DB but will do for now
  protected $service_name = "Youtube";       
       
  /* 
   * the scope
   */
  protected $scope = array( 'post_as' , 'activity_read' , 'wip_read' , 'wip_write');
  
  
  private $google = null;
  
  

  public function __construct(){
    
    parent::__construct();
    
    $params['key'] = $this->consumer_key;
		$params['secret'] = $this->consumer_secret;
		$params['algorithm'] = 'HMAC-SHA1';
		
		$this->load->library( 'youtube/google_oauth' , $params );

  }
  
  
  /* 
   * see models/auth_class.php 
   * REQUESTS THE TOKEN AND REDIRECTS 
   */
  public function request_temp_token(){
    
    $data = $this->google_oauth->get_request_token( $this->callback_url );
        
		$this->session->set_userdata('token_secret', $data['token_secret']);
		
		redirect( $data['redirect'] ); 
  
  }




  /* see models/auth_class.php */
  public function api_return( $temp_token ){
        
    if( $token = $this->google_oauth->get_access_token( false , $this->session->userdata('token_secret') ) ){
      
      return $this->format_api_return( $token['oauth_token'] , $token['oauth_token_secret'] );
      
    }

    
    return false;
      
  }
  
  
}  

/* End of file Auth_behance.php */
/* Location: ./application/models/services/twitter/Auth_behance.php */