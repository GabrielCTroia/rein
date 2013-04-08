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
    
    $this->google = new Google_Client();
    $this->google->setApplicationName('Youtube Application');
    $this->google->setClientId( $this->consumer_key );
    $this->google->setClientSecret( $this->consumer_secret );
    $this->google->setRedirectUri( $this->callback_url );
    
    
    //these needs to be set in the db
    $this->google->setDeveloperKey( 'AIzaSyBMnATOVWah8FzW7NtPVGqYIQxVrNjOihU' );
    

    $this->api = new Google_YouTubeService( $this->google );

  }
  
  
  /* see models/auth_class.php */
  public function request_temp_token(){
    
    $this->google->authenticate();
    
  }




  /* see models/auth_class.php */
  public function api_return( $temp_token ){
    
    $this->google->authenticate();
    
    if( $token = $this->google->getAccessToken() ) {

      return $this->format_api_return( $token , 'not set' );
      
    }
    
    return false;
      
  }
  
  
}  

/* End of file Auth_behance.php */
/* Location: ./application/models/services/twitter/Auth_behance.php */