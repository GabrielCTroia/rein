<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
require_once( APPPATH . 'models/fetch_interface.php' );  
  
class Fetch_model extends CI_Model implements Fetch_interface{
  
  
  /* 
   * the user id of the user that is fetched 
   */  
  private $user_id = null;
  
  /* 
   * the name of the service that is being used 
   */
  private $service_name = null;  
  
  
  /* 
   * cache the access token 
   * - it's uniq per user and service so we don't actually need $user_id & $service_name
   */ 
  private $acceess_tokens = array();
 
  /* 
   * $catches the error
   */  
  private $error = null;
  
  /* 
   * $catches the error_msg
   */  
  private $error_msg = null;
  
  /* 
   * init function 
   * NEEDS to be loaded each time we use this model otherwise the proper library is not loaded
   */  
  function init( $access_tokens ){
    
    if( empty( $access_tokens ) ) {
      
      $this->error = true;
      
      $this->error_msg = "No access token!";
      
      return false;
      
    }
    
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
  function format(){}
  
}










/* End of file access_model.php */
/* Location: ./application/models/access.php */

