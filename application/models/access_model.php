<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
	Class Access:
	-takes care of the ACCESS 
	- gets/sets the access tokens for each service for the user
	
*/
	
Class Access_model extends CI_Model {
  
  //returns all the services that are active and working right now
	function get_active_accesses() {
		$this->db->select( 's_id , service_name' );
		$this->db->from( 'access' );
		$this->db->where( 'service_status' , 'active' );
		$this->db->order_by( 'service_id' );
		
		$query = $this->db->get( );
		
		if( $query->num_rows() ) {
			//free the result
			$result = $query->result();
			$query->free_result();
			
			return $result;
		} else
		    return false;
		
	}
  
}

/* End of file access_model.php */
/* Location: ./application/models/access.php */