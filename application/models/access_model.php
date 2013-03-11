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
  
  /* 
   * the user id of the user that is fetched 
   */  
  protected $user_id = null;
  
  /* 
   * the ID of the service that is being used 
   */
  protected $service_id = null;
 
  /* 
   * $catches the error
   */  
  public $error = null;
  
  /* 
   * $catches the error_msg
   */  
  public $error_msg = null;
  
  
  
  
  function init( $u_id , $s_id ){
    
    if( empty( $u_id ) || empty( $s_id ) ){
      
      $this->error = true;
      
      $this->error_msg = "The user or service is not set!";
      
      return false;
       
    } else {
      
      $this->user_id = $u_id;
      
      $this->service_id = $s_id;
      
    }
    
  }
  
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
  * updates it if finds duplicate duplicate 
  */
	function set_access_token( $token ) {
    
    if( empty( $token ) ){
      
      $this->error = true;
      
      $this->error_msg = "No access token given";
      
      return false;
      
    }

    $a_id = $this->user_id . '-' . $this->service_id;

  	$sql = 'INSERT INTO ' . $this->base_table
  	     . ' ( a_id , u_id , s_id , access_tokens , access_status )'
  	     . ' VALUES( \'' . $a_id . '\',' . $this->user_id . ',' . $this->service_id . ',\'' . $token . '\' , \'active\' )'
  	     . ' ON DUPLICATE KEY UPDATE a_id = a_id';  	   

    if( !$this->db->query( $sql ) ){
      
      $this->error = true;
      
      $this->error_msg = "Error inserting in the database";
      
      return false;
      
    } else {
      
      return true;
      
    }

	}
	
  
  
 /*
  * this is the only function here that can be called without calling the init function first 
  * not sure if is the best way but it's shorter at least
  */
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