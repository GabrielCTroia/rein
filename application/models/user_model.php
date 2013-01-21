<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
Class User_model extends CI_Model {
	

	public function register_user( $post ) {
  	$email = $post[ 'email' ];
	  $user_name = $post[ 'user_name' ];
	  
	  // Enter information into database
	  $this->db->insert( 'users' ,
	      array(
	        'user_name' => $user_name,
	        'email' => $email,
	        'password' => $post[ 'password' ],
	        'user_status' => 'active'
	      ) );
	  
	  
	  // get the user_id from the newly created row
	  $this->db->select( 'user_id' );
	  $this->db->where(
	      array(
	        'user_name' => $user_name,
	        'email' => $email
	      )
	  );
	  $this->db->limit( 1 );
	  
	  $user_id = $this->db->get( 'users' );
	      
		return $user_id->first_row()->user_id;
	}
	
	
	
	
	private function login( $user_name , $password ){
	 
	 
		$this->db->select('user_id, email, password');	
		$this->db->from( 'users' );
		$this->db->where( "user_name = '$user_name'" );
		$this->db->where( "password = '$password'" );
		$this->db->limit( 1 );
		
		$query = $this->db->get();
		
		if( $query->num_rows() == 1 )
		{
			return $query->result();
		}
		else
		{
			return false;	
		}
		
	}
	
	
	
	
  /*
   * verifies the login input datas with the DB
   * @returns true/false if $return=false
   * @returns the  (array)user_info if $return=true
  */	
  public function validate_login( $input = array() , $return = false ) {
		
		//query the db
		$result = self::login( $input['user_name'] , $input['password'] );
		
		if( $result ){
			
			$sess_array = array();
			
			if( $return ) {
          
        foreach( $result as $row ){
			
    				$user_info = array(
  						          'user_id' => $row->user_id,
  						          'email'   => $row->email				
  						          );  				
  						          
  					return $user_info;	          
  			}  			
  			
			}
			
			return true;
			
		} 
			
		$this->form_validation->set_message( 'check_database', 'Invalid username or password' );
			
		return false;
		
  }
  
  
  	
}


//pure php doesn't need the closing tag 