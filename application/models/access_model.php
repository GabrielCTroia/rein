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
   * the foreign User ID needs to be stored fos some services
   */
  protected $fgn_user_id = null;    
  
  /* 
   * the foreign user name needs to be stored for osme services 
   */
  protected $fgn_user_info = null;  
 
  /* 
   * $catches the error
   */  
  public $error = null;
  
  /* 
   * $catches the error_msg
   */  
  public $error_msg = null;
  
  
  
  
  function init( $u_id , $s_id = null ){
    
    if( empty( $u_id ) ){
      
      $this->error = true;
      
      $this->error_msg = "The user is not set!";
      
      return false;
       
    }

    $this->user_id = $u_id;
    
    $this->service_id = $s_id;
    
  }
  
  /* NOT USED YET AND DONT KNOW IF SHOULD BE USED */
  function set_fgn_user( $fgn_u_id , $fgn_user_info = null ){
    
    if( empty( $u_id ) ){
      
      $this->error = true;
      
      $this->error_msg = "The user or service is not set!";
      
      return false;
      
    } 
    
    $this->fgn_user_id = $fgn_u_id;
    
    $this->fgn_user_info= $fgn_user_info;
    
  }
  
  
  

	
	
 /* 
  * stores the access token based on the service_id and user_id
  * updates it if finds duplicate duplicate 
  * @access = api_class->format_api_return() in /models/api_class.php
  */
	function set_access( $access ) {
    
    if( empty( $access['access_token'] ) ){
      
      $this->error = true;
      
      $this->error_msg = "No access token given";
      
      return false;
      
    }
    
    $a_id = $this->user_id . '-' . $this->service_id;

  	$sql = 'INSERT INTO ' . $this->base_table
  	     . ' ( a_id , u_id , s_id , access_token , access_token_secret , access_status , fgn_user_id )'
  	     . " VALUES( '$a_id' , '{$this->user_id}' , '{$this->service_id}' , '" . $access['access_token'] . "' , '" .$access['access_token_secret'] . "' , 'active' , '" . $access['fgn_user_id'] . "' )"
  	     . ' ON DUPLICATE KEY UPDATE a_id = a_id';  	   

    if( !$this->db->query( $sql ) ){
      
      $this->error = true;
      
      $this->error_msg = "Error inserting in the database";
      
      return false;
      
    } else {
      
      return true;
      
    }

	}
	
	 //returns all the services that are active for the USER
/*
	function get_active_accesses() {
		$this->db->select( 's_id' );
		$this->db->from( $this->base_table );
		$this->db->where( 'u_id' , $this->user_id );
		$this->db->where( 'service_status' , 'active' );
		$this->db->order_by( 'service_id' );
		
		$query = $this->db->get( );
		
		if( $query->num_rows() ) {
			//free the result
			$result = $query->result();
			
			$query->free_result();
			
			return $result;
		} 
		
		return false;

	}
*/
	
	
	
  //return all the datas in the access table
  function get_access( $u_id , $s_id ){

    $this->db->select( '*' );
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
			
		} 
		
		return false;
    
  }
  
 /*
  * this is the only function here that can be called without calling the init function first 
  * not sure if is the best way but it's shorter at least
  * going for DEPRECATION 
  */
  function get_access_tokens( $u_id , $s_id ) {

    $this->db->select( 'access_token , access_token_secret' );
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
		}

		return false;
		    
  }	
	
  
}

/* End of file access_model.php */
/* Location: ./application/models/access.php */