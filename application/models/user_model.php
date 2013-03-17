<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
Class User_model extends CI_Model {
	
 /* 
  * cache the base table 
  */
  private $base_table = 'users';
  
  /* 
   * the user id of the user that is fetched 
   */  
  protected $user_id = null;

  /* 
   * $catches the error
   */  
  public $error = null;
  
  /* 
   * $catches the error_msg
   */  
  public $error_msg = null;
	
	
	
  function init( $u_id ){
    
    if( empty( $u_id ) ){
      
      $this->error = true;
      
      $this->error_msg = "The user is not given!";
      
      return false;
       
    }

    $this->user_id = $u_id;
    
	}
	
	
	

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
	  $this->db->select( 'u_id' );
	  $this->db->where(
	      array(
	        'user_name' => $user_name,
	        'email' => $email
	      )
	  );
	  $this->db->limit( 1 );
	  
	  $user_id = $this->db->get( 'users' );
	      
		return $user_id->first_row()->u_id;
	}
	
	
	
	
	private function login( $user_name , $password ){
	 
	 
		$this->db->select( '*' );	
		$this->db->from( 'users' );
		$this->db->where( "user_name = '$user_name'" );
		$this->db->where( "password = '" . md5($password) . "'" );
		$this->db->limit( 1 );
		
		$query = $this->db->get();
		
		if( $query->num_rows() == 1 )
		    return $query->result();
		else
		    return false;	
		
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
			
/*
    				$user_info = array(
  						          'u_id' => $row->u_id,
  						          'email'   => $row->email				
  						          );  				
*/          
            $user_info = (array) $row;
            unset( $user_info['password'] );
  						          
  					return $user_info;	          
  			}  			
  			
			}
			
			return true;
			
		} 
			
		$this->form_validation->set_message( 'check_database', 'Invalid username or password' );
			
		return false;
		
  }
  
  
  /*returns all the necessay infos about the USER
  
   ** not sure if it's the best to carry all of this info everywhere but I believe it's better than doing more queries from different parts of the app 
   * JOINS the TABLES:
     - access  
   */
  public function get_user( $basic = false ){

    $sql  = " SELECT u.u_id, email, user_name, created_date, user_status, user_type, GROUP_CONCAT( s_id ) "
          . " FROM users AS u "
          . " LEFT JOIN access AS a ON a.u_id = u.u_id "
          . " WHERE u.u_id = " . $this->user_id
          . " GROUP BY user_name "
          ; 
		
		$query = $this->db->query( $sql );
		
		if( $query->num_rows() ) {
			//free the result
			$result = $query->result();
			
			$query->free_result();
			
			return $result[0];
		} 
		
		return false;
    
  }
  
  
  
  
  
  	
}


/* End of file user_model.php */
/* Location: ./application/models/user_model.php */
