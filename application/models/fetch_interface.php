<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*   
  
  This is the Format Interface <- NO SHIT ? :))
  
 */
  
  
interface Fetch_interface {
  

  function init( $access_tokens );    
      
  function load_library();    
      
  function fetch();
  
  function format();
  
}










/* End of file format_interface.php */
/* Location: ./application/models/format_interface.php */

