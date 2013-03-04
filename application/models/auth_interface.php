<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*   
  
  This is the Auth Interface
  
 */
  
  
interface Auth_interface {
      
  /* 
   * sends the headers to the server specific URL to request the temp token   
   */
  function request_temp_token();
  
  
  /* 
   * generate the accesstoken based on the requested $temp_token
   */
  function generate_access_token( $temp_token );
  
}










/* End of file auth_interface.php */
/* Location: ./application/models/auth_interface.php */

