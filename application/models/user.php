<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
Class User extends CI_Model
{
	
	
	
	function login( $email , $password ){
	
		$this->db->select('user_id, email, password');	
		$this->db->from( 'users' );
		$this->db->where( "email = $email" );
		$this->db->where( "password = $password" );
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
		$result = self::login( $input['email'] , $input['password'] );
		
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