<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


Class Posts_model extends CI_Model {	

 /* 
  * cache the base table 
  */
  private $base_table = 'posts';

  /* 
   * the user id of the user that is fetched 
   */  
  private $user_id = null;
  
  /* 
   * the id of the service that is being used 
   */
  private $service_id = null;  

  /* 
   * the name of the service that is being used 
   */
  private $service_name = null;  
  
  /* 
   * catches the error status 
   */  
  protected $error = false;
  
  /* 
   * catches the error msg 
   */  
  protected $error_msg = null;  
  
  
  function init( $user_id , $service_id = null ){

    if( !isset( $user_id ) ) {
      $this->error = true;
      $this->error_msg = "There is no user";
    }
    
    $this->user_id = $user_id;
    
    if( !$service_id ) return;
    
      $this->service_id = $service_id;
      
      //load the services model
    	$this->load->model( 'Services_model' , '' , false );   
    	
    	$service_name = $this->Services_model->get_service_by( 'id' , $service_id , 'service_name' );
    	
      $this->service_name = $service_name[0]->service_name;

  }
  
  
	
	function get_posts( $limit = 20 , $extra_fields = false ) {	
		
/* 		$select_str = 'p_id, post_foreign_id, service_id, posts.created_date, value, source, param ' . ' , ' .$extra_fields; */
		
		$select_str = "*";

		/*
$this->db->select( $select_str );
		$this->db->from( 'posts' );
		$this->db->join( 'users' , 'users.u_id = posts.u_id' );
		$this->db->join( 'posts_' . $this->service_name , 'posts_' . $this->service_name '.s_id = posts.u_id' );
		$this->db->where( 'posts.u_id', $this->user_id );
*/

    $sql = 'SELECT ' . $select_str . ' FROM ' . $this->base_table . ' p' 
         . ' JOIN users ON users.u_id = p.u_id'
         . ' JOIN services ON services.s_id = ( SELECT s_id FROM ' . $this->base_table . ' pp WHERE pp.p_id = p.p_id  )'
/*          . ' JOIN posts_( SELECT service_name FROM pp WHERE ppp.s_id = pp.s_id ) p_f ON p_f.p_id = p.p_id '  */
         . ' WHERE p.u_id = ' . $this->user_id
         . ' ORDER BY p.created_date DESC'
         . ' LIMIT ' . $limit 
         ; 
			
/* 		if( $this->service_id ){ */
			
			// if there is a service_id specified than return only that
			// if it's not specified return everything
/* 			$this->db->where( 'posts.s_id', $this->service_id ); */
			
/* 		}	 */
		
/* 		$this->db->order_by( 'posts.created_date desc' ); */
		
		$query = $this->db->query( $sql );
		
		if( $query->num_rows() ) {
			//free the result
			$result = $query->result();
			
			$query->free_result();
			
			return $result;
		} else
		    return false;
		
	}

	//get the latest post in a specified query
	function get_last_post( $service_id = false , $fields = false , $order_by = 'created_date' , $dir = 'desc' ) {
		
		if( $fields ) 
		{
			$select_str = $fields;
		}
		else
		{
			$select_str = 'post_id, post_foreign_id, service_id, posts.created_date, value, source, param ';
		}
		
		$this->db->select( $select_str );
		$this->db->from( 'posts' );
		$this->db->join( 'users' , 'users.user_id=posts.user_id' , 'right' );
		$this->db->where( 'posts.user_id', $this->user_id );
		$this->db->where( 'posts.service_id', $this->service_id );
		$this->db->order_by( 'posts.' . $order_by . ' ' . $dir );
		
		$query = $this->db->get( '' , 1 );
		
		if( $query->num_rows() > 0 )
		{
			return $query->result();
		}
		else {
			return false;
		}
		
	}
	
	
	function insert_posts( $posts ) {

		if( !$this->user_id || !$posts ) {
  		$this->error = true;
      $this->error_msg = "No User or Service defined";
		
      return false;
		};
					
	}
	

}

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */