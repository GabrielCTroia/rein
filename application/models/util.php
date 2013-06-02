<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* this is going to be deprecated */	
	
	
Class Util extends CI_Model {	

  function __construct() {
    parent::__construct();
  }
  
  public function generate_nonce( $length = 32 ){
    $u = md5( uniqid( 'nonce_' , true ) );
    return substr( $u , 0 , $length );
  }
  
  public function data_string_to_array( $data ) {
    
    $data = explode( '&' , $data );
    $data_arr = array();
     
    //  Might be a function for this - turn data string into array of key->value pairs
    foreach( $data as $r ) {
      $temp_arr = explode( '=' , $r );
      $data_arr[ $temp_arr[ 0 ] ] = $temp_arr[ 1 ];
    }
    
    return $data_arr;
  }
  
  
  /* 
	 * creates unique LOCAL-ID based on the FOREIGN-ID 
	*/
	public function format_foreign_id( $fid , $sid ){
		
		//the posts are service dependent
		$prefix = $sid . '-' ;
		
		return $prefix . $fid;
		
	}
	
	/* 
	 * unformat the FOREIGN-ID
	 */
	public function unformat_foreign_id( $fid ){
	
		return substr( $fid , strpos( $fid , "-" ) + 1 , strlen( $fid ) );
		
	}




	/* 
	 * returns the same url structure(same params) with different values 
	 */
	public function get_new_url( $segments = array() , $param , $new_val ){   
       
    $segments[$param] = $new_val;   
       
    return '/' . $this->uri->assoc_to_uri( $segments ); 
      
  }
  
  
  
  public function safe_name( $name ){
    
    return preg_replace( '/\s/' , '_' , $name );
    
  }

}








/* End of file util.php */
/* Location: ./application/models/util.php */