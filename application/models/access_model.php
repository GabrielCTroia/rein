<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
	Class Access:
	-takes care of the ACCESS 
	- gets/sets the access tokens for each service for the user
	
*/
	
Class Access_model extends CI_Model {
  
 /* 
  * cache the base table 
  */
  private $base_table = 'access';
  
  
  //returns all the services that are active and working right now
	function get_active_accesses() {
		$this->db->select( 's_id , service_name' );
		$this->db->from( $this->base_table );
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
	
	
 /* 
  * stores the access token based on the service_id and user_id
  */
	function set_access_token( $u_id , $s_id , $token ) {
  	
/*
  	$data = array(
  	       
  	       'a_id'            => $u_id . $s_id 
  	      ,'u_id'            => $u_id
  	      ,'s_id'            => $s_id
  	      ,'access_tokens'   => $token
  	      ,'access_status'   => 'active'
  	      
  	       );
*/
    $a_id = $u_id . '-' . $s_id;

  	$sql = 'INSERT INTO ' . $this->base_table
  	     . ' ( a_id , u_id , s_id , access_tokens , access_status )'
  	     . ' VALUES( \' ' . $a_id . '\' ,' . $u_id . ',' . $s_id . ', \'' . $token . '\' , \'active\' ) '
  	     . ' ON DUPLICATE KEY UPDATE access_tokens = ' . '\'' . $token . '\'';
  	   
  	
/*   	if( $this->db->insert( $this->base_table , $data ) ) */

    if( $this->db->query( $sql ) )
  	 return true;
  	
  	return false;
	}
	
  
  function get_access_token( $u_id , $s_id ) {

    $this->db->select( 'access_tokens' );
		$this->db->from( $this->base_table );
		$this->db->where( array( 'u_id' => $u_id , 's_id' => $s_id ) );
		
		//this should be only one from the beginnig but there is a bug
		$this->db->limit(1);
		
		$query = $this->db->get();
		
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