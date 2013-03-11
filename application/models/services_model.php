<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* 
	Class Services: 
	
	- takes care of the SERVICES TABLE

*/

Class Services_model extends CI_Model {
  
 /* 
  * cache the base table 
  */  
  private $base_table = 'services';
  
  
 /* 
  * get the service by the specified field
  * 
  * $field_name   = 'name' , 'id' or any other field name which exists in the database
  * $field_value  = the value it's checking against
  * $select       = can be either false which means it's returning the $field_name - this is only for checking if the users exists
                  = OR it can also be an array of different field names
  * 
 	*/
	function get_service_by( $field_name , $field_value , $select = '*' ) {
   
    //rename the 'name' to 'service_name'
    if( $field_name == 'name' ) 
      $field_name = 'service_name';

    //rename the 'id' to 'service_id'      
    if( $field_name == 'id' ) 
      $field_name = 's_id';  
    	 
	  //if is an array implode the values
	  if ( is_array( $select ) ) 
	   $select = implode( ' , ', $select );
	   
	  //if it's false that means it's only used to check if the service exists 
	  //so we return the same $field_name
	  else if ( !$select ) 
	   $select = $field_name;   

		$this->db->select( $select );
		$this->db->from( $this->base_table );
		$this->db->where( $field_name , $field_value );
		$this->db->limit( 1 );
		
		$query = $this->db->get();
		
  	if( !$query->num_rows() ) {
    	
    	$this->error = true;
    	
    	$this->error_msg = "No active services in the Database";
    	
    	return false;
    	
  	} else {
    	
    	$result = $query->result();
    	
    	$query->free_result();
    	
    	return $result[0];
    	
  	}
  	
	}
	
	
	
	public function get_active_services() {
  	
  	$this->db->select( 'service_name' );
  	$this->db->from( 'services' );
  	$this->db->where( 'service_status' , 'active' );
  	
  	$query = $this->db->get();
  	
  	if( !$query->num_rows() ) {
    	
    	$this->error = true;
    	
    	$this->error_msg = "No active services in the Database";
    	
    	return false;
    	
  	} else {
    	
    	$result = $query->result();
    	
    	$query->free_result();
    	
    	return $result;
    	
  	}

	}
	
	
	
	//  to save a bit of repetition
	private function return_query_results( $query ) {
  	
  	if( $query->num_rows() )
  	    return $query->result();
		else
		    return false;	
		
	}
  
  
  
  
  
}



/* End of file services_models.php */
/* Location: ./application/models/services_models.php */