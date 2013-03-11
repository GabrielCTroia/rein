<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*   
  
  This is the Format Interface <- NO SHIT ? :))
  
 */
  
  
interface Fetch_interface {

  function init( $user_id , $access_tokens );    
      
  function fetch();
  
  function format( $posts );
  
}










/* End of file format_interface.php */
/* Location: ./application/models/format_interface.php */

