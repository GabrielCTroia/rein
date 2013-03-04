<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
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
  
  

}








/* End of file util.php */
/* Location: ./application/models/util.php */