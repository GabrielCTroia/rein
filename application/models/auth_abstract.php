<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*   
  
  This is the Abstract Auth class
  
 */
  
  
abstract class Auth_abstract{
  
  /* 
   * the consumer key specific for each service
   */
  protected $consumer_key = null;   


  /* 
   * the consumer secret specific for each service
   */  
  protected $consumer_secret = null;
  
  
  /* 
   * the callback url 
   */
  protected $callback_url = null;
   
  /* 
   * the callback url 
   */
  protected $base_url = null;
  
  
  /* 
   * the scope 
   */
  protected $scope = null;

  
      
  /* 
   * sends the headers to the server specific URL to request the temp token   
   */
  abstract protected function request_temp_token();
  
  
  /* 
   * generate the accesstoken based on the requested $temp_token
   */
  abstract protected function generate_access_token( $temp_token );
  
}










/* End of file access_model.php */
/* Location: ./application/models/access.php */

