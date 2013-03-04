<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/format_interface.php' );

//  This class serves as the base for Format classes containing all the neccessary
//  methods that may be needed down the line
class Format_class extends CI_Model {
  
  /* 
   * the user id of the user that is fetched 
   */  
  protected $user_id = null;

  /* 
   * the name of the service that is being used 
   */
  protected $service_id = null;
 
  /* 
   * catches the error status 
   */  
  protected $error = false;
  
  /* 
   * catches the error msg 
   */  
  protected $error_msg = null;
  
  
  
  
  function init( $user_id , $service_id ){
    
    //the error catching should be implemented in all of the models
    if( !isset( $user_id ) || !isset( $service_id ) ) {
      $this->error = true;
      $this->error_msg = "No User or Service defined";
      
      return false;
    }
      
    
    //set the user
    $this->user_id = $user_id;
    
    //set the service id name
    $this->service_id = $service_id;
    
  }
	
	//this should be declared in the interface but for some reason it's not working for now
	public function format_posts(){}
	
	/* 
	 * creates unique LOCAL-ID based on the FOREIGN-ID 
	*/
	protected function format_foreign_id( $fid )
	{
		$prefix = "s" . $this->service_id . "u" . $this->user_id . "-";
		
		return $prefix . $fid;
	}
	
	/* 
	 * unformat the FOREIGN-ID
	 */
	public function unformat_foreign_id( $fid )
	{
		return substr( $fid , strpos( $fid , "-" ) + 1 , strlen( $fid ) );
	}
  
}

/* End of file format_class.php */
/* Location: ./application/models/format_class.php */