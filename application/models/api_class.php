<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
   
/*
  This class be inherited by any class that uses the Api to authorize/fetch datas
*/
class Api_class extends CI_Model{
  
  /* 
   * this instantiates the api class based on each library 
   * it does it in the constructor of each service specific children model
   */
  protected $api = null;
  
  /* 
   * the consumer key needs to be easily accesed 
   */   
  protected $consumer_key = null;
  
 /* 
  * the consumer secret needs to be easily accesed 
  */   
  protected $consumer_secret = null;
  
 /* 
  * the oauth verion - not always needed - most of the libraries have it on their own
  */
  protected $OAuth_version = null;
  
  /* 
   * the callback url for each service
   */ 
  protected $callback_url = null;
  
  /* 
   * the base API URL - not always needed  
   */
  protected $base_url = null;
  
  /* 
   * the scope of the api request
   */ 
  protected $scope = null;  
  
  /* 
   * cache the access token 
   * - it's unique per user and service so we don't actually need $user_id & $service_name
   */ 
  protected $acceess_tokens = array();
    
  /* 
   * the user id of the user that is used
   */  
  protected $user_id = null; 
   
  /* 
  * the service name - much needed in loading the files based on the service
  */   
  protected $service_name = null;
  
 
 /* 
  * the service id - needed when formatting or inserting the datas
  */   
  protected $service_id = null;
   
  /* 
   * $catches the error
   */  
  public $error = null;
  
  /* 
   * $catches the error_msg
   */  
  public $error_msg = null;
  
   
  function __construct(){
    
    parent::__construct();
  
    //if the service name is loaded than populate all the other vars - once and for all :)
    if( $this->service_name ) {
      
      /* $SERVICES PARAMS */
      
      $this->load->model('Services_model' , '' , false );
      
      if( !$service = $this->Services_model->get_service_by( 'name' , strtolower( $this->service_name ) ) ){
        
        $this->error = true;
        
        $this->error_msg = $this->Services_model->error_msg; 
        
        echo $this->error_msg;
        
      } else {
        
        /* load the service params */
        
        $this->service_id = $service->s_id;
        
        $this->base_url = $service->base_url;
        
        $app_config = json_decode( $service->app_config );
        
        $this->consumer_key = $app_config->consumer_key;
        
        $this->consumer_secret = $app_config->consumer_secret;
        
        $this->callback_url = $app_config->callback_url;
        
      }
      
      //this should be verified if true or false
      
    }
    
    $this->load_library();
    
  }
  
  function init(){}  
  
  protected function load_library(){
  
    include_once( __DIR__ . '/services/' . $this->service_name . '/load_library.php');
  
  }
    
}

/* End of file api_class.php */
/* Location: ./application/models/api_class.php */