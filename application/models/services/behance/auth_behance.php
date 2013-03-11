<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Fetch_model
require_once( APPPATH . 'models/auth_class.php' );

class Auth_behance extends Auth_class{
   
  //should come from the DB but will do for now
  protected $service_id = 4;
  
  //should come from the DB but will do for now
  protected $service_name = "Behance";       
      
  /* 
   * the base API URL  
   */
  protected $scope = array( 'post_as' , 'activity_read' , 'wip_read' , 'wip_write');
  

  public function __construct(){
    
    parent::__construct();
    
    $this->api = new Be_Api( $this->consumer_key , $this->consumer_secret );
    
  }

  public function request_temp_token(){
    
    $this->api->authenticate( $this->callback_url , $this->scope );
    
  }


  public function generate_access_token( $temp_token ){
    
    if( $token = $this->api->exchangeCodeForToken( $temp_token['code'] , $this->callback_url ) ){
      
      return $token;
      
    }
      
    return false;

  }
  
}  













/* End of file Auth_behance.php */
/* Location: ./application/models/services/twitter/Auth_behance.php */