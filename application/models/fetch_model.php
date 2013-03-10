<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  Needs description
  
  $included files
  - models/fetch_interface.php
  
*/

  
require_once( APPPATH . 'models/fetch_interface.php' );  
  
class Fetch_model extends CI_Model implements Fetch_interface{
  
  /* 
   * the user id of the user that is fetched 
   */  
  protected $user_id = null;
  
  /* 
   * the ID of the service that is being used 
   */
  protected $service_id = null;
  
  /* 
   * the name of the service that is being used 
   */
  protected $service_name = null;  
    
  /* 
   * cache the access token 
   * - it's unique per user and service so we don't actually need $user_id & $service_name
   */ 
  protected $acceess_tokens = array();
 
  /* 
   * $catches the error
   */  
  public $error = null;
  
  /* 
   * $catches the error_msg
   */  
  public $error_msg = null;
  
  
  /* 
   * this laods the library and does any other stuff with no params
   * for the ones with params we use init
   */
  function __construct(){
	 
		include_once( __DIR__ . '/services/' . $this->service_name . '/load_library.php');

  }
  
  /* 
   * init function 
   * NEEDS to be loaded each time we use this model otherwise the proper library is not loaded
   */  
  function init( $user_id , $access_tokens ){
    
    if( empty( $user_id ) || empty( $access_tokens ) ) {
      
      $this->error = true;
      
      $this->error_msg = "No user or access token given!";
      
      return false;
      
    }
    
    $this->user_id = $user_id;
    
    $this->access_tokens = $access_tokens[0]->access_tokens;
    
    $this->load_library();
    
  }
  
  
  function load_library(){}
  
 /* 
  * fetches the posts 
  * @count - number of posts to fetch
  */
  function fetch( $count = 20 ){}
  
  
  /* 
   * formats the posts 
   * not sure if the best is to be here or in a separate class file
   */ 
  function format( $posts ){}
  
}










/* End of file access_model.php */
/* Location: ./application/models/access.php */

