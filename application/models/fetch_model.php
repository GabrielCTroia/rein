<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  Needs description
  
  $included files
  - models/api_class.php
  - models/fetch_interface.php
  
*/

require_once( APPPATH . 'models/api_class.php' );
  
require_once( APPPATH . 'models/fetch_interface.php' );  
  
class Fetch_model extends Api_class implements Fetch_interface{
    
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
    
  }
  
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

