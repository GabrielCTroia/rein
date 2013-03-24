<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


Class Posts_model extends CI_Model {	

 /* 
  * cache the base table 
  */
  protected $base_table = 'posts';

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
  public $error = false;
  
  /* 
   * catches the error msg 
   */  
  public $error_msg = null;  
  
  
  
  /*
   * caches the last get query specs here
   * this way we do not to specify the same ones to times if the happen one after the other
   *
   * NOT USED YET
   /
  /* private $get_query_specs = array(); */
  
  
  function init( $user_id , $service_id = null ){
    
    if( empty( $user_id ) ) {
      
      $this->error = true;
      $this->error_msg = "There is no user! You cannot be here!";
      
      return false;
    }
    
    $this->user_id = $user_id;
    
    if( !$service_id ) return;
    
      $this->service_id = $service_id;
      
      //load the services model
    	$this->load->model( 'Services_model' , '' , false );   
    	
    	$service_name = $this->Services_model->get_service_by( 'id' , $service_id , 'service_name' );
    	
      $this->service_name = $service_name->service_name;

  }
  
  
	
	function get_posts( $query_specs = array() ) {	
		
		//define the default $query_specs
		if( empty( $query_specs['select'] ) ) 
		   $query_specs[ 'select' ] = '*';
		
		if( empty( $query_specs['limit'] ) OR $query_specs['limit'] > 20 ) 
		   $query_specs[ 'limit' ] = 20;
		   
		if( empty( $query_specs['order_by'] ) ) 
		   $query_specs[ 'order_by' ] = 'p.favorited_date';   
		   
    if( empty( $query_specs['order_dir'] ) ) 
		   $query_specs[ 'order_dir' ] = 'DESC';   		   
		


    $sql  = 'SELECT ' . $query_specs['select'] . ' FROM ' . $this->base_table . ' AS p' 
         . ' JOIN users_posts_services AS ups ON ups.FK_p_id = p.post_foreign_id '
         . ' JOIN services AS s ON s.s_id = ups.FK_s_id'         
      
         . ' WHERE ';   
         //check for AND_where
         if( !empty( $query_specs['where'] ) ) {
           foreach( $query_specs['where'] as $ref=>$val ) {              
             //$sql .= $ref . ' = ' . '\'' . $val . '\' AND ';              
             $sql .= $val . ' AND ';
           }
         } 
         
         //check for OR_where
         if( !empty( $query_specs['or_where'] ) ) {
           foreach( $query_specs['where'] as $ref=>$val ) {
             $sql .= $val . ' OR ';
           }
         }

    $sql .= ' ups.FK_u_id = ' . $this->user_id
          . ' GROUP BY ups.FK_p_id' //this is not the best but works - I need to find a way to not insert duplicates in the 1st place       
/*          . ' GROUP BY ups.FK_s_id '  */
          . ' ORDER BY ' . $query_specs['order_by']
          . ' ' . $query_specs['order_dir']
          . ' LIMIT ' . $query_specs['limit']
          ; 

/*
		var_dump($sql);
		exit();
*/
  
		if ( !$query = $this->db->query($sql) ) {
  		
  		$this->error = true;
  		
  		$this->error_msg = "Couldn't insert the posts in the database!";		  
  		
		} else {
  		
  		if( $query->num_rows() ) {
  				
  			//free the result
  			$result = $query->result();
  			
  			$query->free_result();
  			
  			$this->get_query_specs = $query_specs;
  			
  			return (object)$result;
  			
  		} else {
    		
    		$this->error = true;
        
        $this->error_msg = "There are no posts to show!";		  
    		
    		return false;
    		
  		}	
  		
		}
				    
	}

	//get the latest post in a specified query
	function get_last_post( $query_specs = array() ) {
		
		$result = $this->get_posts( $query_specs );
		
		return reset($result);
		
		/*

		
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
		
		if( $query->num_rows() > 0 ) {

			return $query->result();

		} else {
		  
      $this->error = true;
      
      $this->error_msg = "There are mo posts to show!";		  
		  
			return false;
		}
*/
		
	}
	
	
	/* 
	 * returns the total no of posts of user( by default) and of a specific service if desired
	 */
	function get_total_posts( $by_service = false , $by_user = true ){
  	
  	$sql = ' SELECT COUNT( DISTINCT( FK_p_id ) ) FROM users_posts_services AS ups ';
  	     
  	     if( $by_user OR $by_service ) {
    	     
    	     $sql .= ' WHERE ';
    	     
    	     if( $by_service ){
      	     
      	     $sql .= ' ups.FK_s_id = ' . $this->service_id;
      	     
    	     }
    	     
    	     if( $by_user AND $by_service ) {
      	     
      	     $sql .= ' AND ';
      	     
    	     }
    	     
    	     if( $by_user ){
      	     
      	     $sql .= ' ups.FK_u_id = ' . $this->user_id;
      	     
    	     }
    	     
  	     }
  	
/*   	echo ( $sql ); */
  	     
  	//I feel like this needs to be a reusable function
    if ( !$query = $this->db->query($sql) ) {
  		
  		$this->error = true;
  		
  		$this->error_msg = "Error in the query or DB";		  
  		
		} else {
  		
  		if( $query->num_rows() ) {
  				
  			//free the result
  			$result = $query->result();
  			
  			$query->free_result();
  			
  			//return only the value not the reference too
  			return reset( $result[0] );
  			
  		} else {
    		
    		$this->error = true;
        
        $this->error_msg = "There are no posts";		  
    		
    		return false;
    		
  		}	
  		
		}
  	     
	}
	
	
	
	
	
	function insert( $posts ) {

  	
		if( !$this->user_id || !$posts ) {
  		$this->error = true;
      $this->error_msg = "No User or Service defined";
		
      return false;
		};
		
		if( !$posts ){
    	
    	$this->error = true;
    	$this->error_msg = 'no posts to insert';
    	
    	return false;
  	}

    $sql = ' INSERT INTO ' . $this->base_table;

    $sql .= ' (';
     
      foreach( $posts[0] as $key=>$value ) :
        
        $sql .= '`' . $key . '`';
        $sql .= ( $value != end($posts[0]) ) ? ' , ' : ''; 
        
      endforeach;
      
    $sql .= ') ';

    $sql .= ' VALUES ';
     
    foreach( $posts as $post ) :
      $sql .= '(';
      
      foreach( $post as $key=>$value ) :

        $sql .= '\'' . mysql_real_escape_string( $value ) . '\'';
        $sql .= ( $value != end($post) ) ? ' , ' : '';  
        
      endforeach;
      
      $sql .= ') ';
      $sql .= ( $post != end($posts) ) ? ' , ' : '';
      
    endforeach; 
        
    $sql .= ' ON DUPLICATE KEY UPDATE post_foreign_id = post_foreign_id ';    
      
    if( !$this->db->query( $sql ) ){
      $this->error = true;
    	$this->error_msg = 'no posts to insert';
    	
    	return false;
    	
    } else {
          
      $sql2  = ' INSERT INTO users_posts_services '
            . ' (  FK_p_id , FK_u_id , FK_s_id ) '
            . ' VALUES';
           foreach( $posts as $post ) :
              $sql2 .= " ( '" . $post['post_foreign_id'] . "'," . $this->user_id . "," . $this->service_id . ") ";
              $sql2 .= ( $post != end($posts) ) ? ' , ' : '';  
           endforeach;             
           
      if( !$this->db->query( $sql2 ) ){
        
        return false;
        
      }
      

    }
    

	}

}

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */