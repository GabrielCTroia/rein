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
   */
   private $query_specs = array(); 
  
  
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
  
  
	
	function get_posts( $query_specs = array() , $count_only = false ) {	
		
		//define the default $query_specs
		if( empty( $query_specs['select'] ) ) 
		   $query_specs[ 'select' ] = '*';
		
		if( empty( $query_specs['limit'] ) OR $query_specs['limit'] > 20 ) 
		   $query_specs[ 'limit' ] = 20;
		   
		if( empty( $query_specs['order_by'] ) ) 
		   $query_specs[ 'order_by' ] = 'p.favorited_date';   
		   
    if( empty( $query_specs['order_dir'] ) ) 
		   $query_specs[ 'order_dir' ] = 'DESC';   		   
		
		 
		//this replaces the get_total_posts function 
		//it needs to be here because I need to get the number 
		//of posts of the same query that shows the posts
		if( $count_only ){
  		
  		$query_specs['select'] = 'COUNT( DISTINCT( FK_p_id ) )';
  		
  		$query_specs['limit'] = 200;
  		
		} 
		  
    $sql  = 'SELECT ' . $query_specs['select'] . ' FROM ' . $this->base_table . ' AS p' 
         . ' JOIN users_posts_services AS ups ON ups.FK_p_id = p.post_foreign_id '
         . ' JOIN services AS s ON s.s_id = ups.FK_s_id'         
      
         . ' WHERE ';   
         
         //check for AND_where
         if( !empty( $query_specs['where'] ) ) {
           foreach( $query_specs['where'] as $ref=>$val ) {                   
             $sql .= $ref . ' = \'' . $val . '\' AND ';
           }
         } 
         
         //check for OR_where
         if( !empty( $query_specs['or_where'] ) ) {
           foreach( $query_specs['or_where'] as $ref=>$val ) {
             $sql .= $val . ' OR ';
           }
         }

    $sql .= ' ups.FK_u_id = ' . $this->user_id
          . ' AND ups.status = \'active\' '
          . ' GROUP BY ups.FK_p_id' //this is not the best but works - I need to find a way to not insert duplicates in the 1st place       
/*          . ' GROUP BY ups.FK_s_id '  */
          . ' ORDER BY ' . $query_specs['order_by']
          . ' ' . $query_specs['order_dir']
          . ' LIMIT ' . $query_specs['limit']
          ; 

/* var_dump( $sql ); */
/* 		exit(); */
    

    
		if ( !$query = $this->db->query($sql) ) {
  		
  		$this->error = true;
  		
  		$this->error_msg = "Couldn't insert the posts in the database!";		  
    		
		} else {
  		
  		if( $query->num_rows() ) {
				
  			//free the result
  			$result = $query->result();
  			
  			$query->free_result();
  			
  			$this->query_specs = $query_specs;
  	     		
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
		
	}
	
	
  /*
	 * returns the total no of posts of user( by default) and of a specific service if desired
	 */
	function get_total_posts( $by_service = false , $by_user = true , $query_specs = array() ){
  	
  	if( empty( $query_specs ) ){
    	
    	$query_specs = $this->query_specs;
    	
  	}
  	
  	$sql = ' SELECT COUNT( DISTINCT( FK_p_id ) ) FROM users_posts_services AS ups '
         . ' JOIN services AS s ON s.s_id = ups.FK_s_id'         
         . ' JOIN posts AS p ON ups.FK_p_id = p.post_foreign_id'
         
         . ' WHERE ups.FK_u_id = ' . $this->user_id
  	     . ' AND ups.status = \'active\' '
  	     ;

  	     ;
         
         //check for AND_where
         if( !empty( $query_specs['where'] ) ) {
           
           $sql .= ' AND ';
           
           $i = 0;
           $count = count( $query_specs['where'] );           
           foreach( $query_specs['where'] as $ref=>$val ) {                   
             $sql .= $ref . ' = \'' . $val . '\'';
           
             if( $i < ( $count - 1 ) ){
             
               $sql .= ' AND ';
               
             }
           
           }
                      
         } 
         
         //check for OR_where
         if( !empty( $query_specs['or_where'] ) ) {
           
           $sql .= ' AND ';
           
           $i = 0;
           $count = count( $query_specs['where'] );                      
           foreach( $query_specs['or_where'] as $ref=>$val ) {
             $sql .= $ref . ' = \'' . $val . '\'';
             
             if( $i < ( $count - 1 ) ){
             
               $sql .= ' OR ';
             
             }

           }
         }
                          
        
         //check for AND_like
         if( !empty( $query_specs['like'] ) ) {
           
           $sql .= ' AND ';
           
           $i = 0;
           $count = count( $query_specs['like'] );
           foreach( $query_specs['like'] as $ref=>$val ) {                   
      
             $sql .= $ref . ' LIKE \'%' . $val . '%\'';
             
             if( $i < ( $count - 1 ) ){
               
               $sql .= ' AND ';
                           
             }
        
             $i++; 
               
           }
         } 
         
         
   
         //check for OR_like
         if( !empty( $query_specs['or_like'] ) ) {
           
           $sql .= ' AND ';
           
           $i = 0;
           $count = count( $query_specs['or_like'] );           
           foreach( $query_specs['or_like'] as $ref=>$val ) {                   
      
             $sql .= $ref . ' LIKE \'%' . $val . '%\'';
             
             if( $i < ( $count - 1 ) ){
               
               $sql .= ' OR ';
                           
             }
        
             $i++;
             
           }
         } 



/*
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
*/
    
/*
  	     if( $by_user || $by_service ) {
      	     
      	   $sql .= ' AND ';
      	     
    	   }
*/
/*     echo $sql; */
/*
    $sql .= ' ups.status = \'active\''
  	      ;
*/
  	//I feel like this needs to be a reusable function
  	
    if ( !$query = $this->db->query($sql) ) {
  		
  		$this->error = true;
  		
  		$this->error_msg = "Error in the query or DB";		  
  		
		} else {
  		
  		if( $query->num_rows() ) {
  				
  			//free the result
  			$result = $query->result();
  			  			
  			$query->free_result();
  			
/*
  			echo "<br/>";
  			var_dump(reset( $result[0] ));
*/
  			//return only the value not the reference too  			
  			return reset( $result[0] );
  			
  		} else {
    		
    		$this->error = true;
        
        $this->error_msg = "There are no posts";		  
    		
    		return false;
    		
  		}	
  		
		}
  	     
	}
	
	
	
	function get_all_categories(){}
	
	
	//this needs to be called after the posts was called
	function get_active_categories( $query_specs = array() ){
  	
  	if( !$this->user_id ){
    	
    	return false;
  	}
  	
  	if( empty( $query_specs ) ){
    	
    	$query_specs = $this->query_specs;
    	
  	}
  	
  	$sql = ' SELECT category from ' . $this->base_table . ' p '
  	     . ' JOIN users_posts_services AS ups ON ups.FK_p_id = p.post_foreign_id '
  	     . ' WHERE ups.FK_u_id = ' . $this->user_id
  	     . ' AND ups.status = \'active\' '
  	     . ' GROUP BY category '
  	     ;
  	     
  	     
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
  			return $result;
  			
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
      $this->error_msg = 'No User or Service defined';
		
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
          
          //here I should use a procedure of somethig else for these 2 queries
      $sql_ups  = ' INSERT INTO users_posts_services '
            . ' ( FK_p_id , FK_u_id , FK_s_id ) '
            . ' VALUES';
           foreach( $posts as $post ) :
              $sql_ups .= " ( '" . $post['post_foreign_id'] . "'," . $this->user_id . "," . $this->service_id . ") ";
              $sql_ups .= ( $post != end($posts) ) ? ' , ' : '';  
           endforeach;     
      
      $sql_ups .= ' ON DUPLICATE KEY UPDATE FK_p_id = FK_p_id '; 
                   
           
      if( !$this->db->query( $sql_ups ) ){
        
        return false;
        
      }
      

    }
    

	}
	
	
	
	//changes the status in the USERS_POSTS_SERVICES to 'service_deactivated'
	function deactivate_posts( $service_id ){
  	
  	if( !$this->user_id && !$this->service_id) {
  		
  		/* echo error - no user defined */
  		
  		return false; 
  		
		}
		
		$sql = ' UPDATE users_posts_services AS ups'
		     . ' JOIN services AS s ON ups.FK_s_id = s.s_id '
				 . ' SET status = \'s_deactivated\'' 
				 . ' WHERE FK_u_id = ' . $this->user_id				 
				 . ' AND s.service_name = \'' . $service_id . '\''
				 ;
		
		if( !$this->db->query( $sql ) ) {
		
			//echo error
			return false;
			
		}
		
		/* echo error */
	  return true;	
		
  	
  	
	}
	
	
	
	/* it actually only changes the status in the USERS_POSTS_SERVICES table */
	function trash_posts( $post_ids ){
	
		if( !$this->user_id ) {
  		
  		return false; 
  		
		}
		
		if( is_array( $post_ids ) ){
				
				$post_ids = implode( ',' , $post_ids );
			
		}
		
		$sql = ' UPDATE users_posts_services'
				 . ' SET status = \'trash\'' 
				 . ' WHERE FK_u_id = ' . $this->user_id
				 . ' AND FK_p_id = \'' . $post_ids . '\''
				 ;
		
		if( !$this->db->query( $sql ) ) {
		
			//echo error
			return false;
			
		}
		
		/* echo error */
	  return true;	
	
	}
	
	
	
	
	/* deletes the row in UPS  */
	function delete_posts( $post_ids = array() ){

		if( !$this->user_id ) {
  		
  		/* echo error - no user defined */
  		
  		return false; 
  		
		}
		
		if( is_array( $post_ids ) ){
				
				$post_ids = implode( ',' , $post_ids );
			
		}
		
		$sql = 'DELETE FROM users_posts_services'
				 . ' WHERE FK_u_id = ' . $this->user_id
				 . ' AND FK_p_id IN (\'' . $post_ids . '\')'
				 ;
		
		if( !$this->db->query( $sql ) ) {
			
			//echo error
			return false;
			
		}
		
		/* echo error */
	 
	  return true;	
		
	}
	
	
	/* 
	 * this function can only be called by the admin and 
	 * it really deletes the posts in the POSTS table 
	 * rather than just changing the status in the USERS_POSTS_SERVICES
	 */
	function real_delete_posts( $post_ids = array() ){
		
		if( is_array( $post_ids ) ){
				
				$post_ids = implode( ',' , $post_ids );
			
		}
		
		$sql = 'DELETE FROM ' . $this->base_table
				 . ' WHERE p_id IN (\'' . $post_ids . '\')'
				 ;
		
		if( !$this->db->query( $sql ) ) {
			
			return false;
			
		}
	   
	  return true;	
		
	}
	
	//this resets the query_specs array 
	function reset_query(){
  	
  	$this->query_specs = array();
  	
	}
	
	//search method
	function search_posts( $q ){
  	
  	$this->db->select( '*' );
  	$this->db->from( $this->base_table . ' AS p');
  	$this->db->join( 'users_posts_services AS ups' , 'ups.FK_p_id = p.post_foreign_id' );
  	$this->db->join( 'services AS s' , 's.s_id = ups.FK_s_id' );
  	
		//set the query_specs
		$query_specs = array();
		$or_like = array();
		
		//THEY ARE ALL CASE INSENSTIVE
		$or_like['UPPER(p.caption)'] = strtoupper( $q );
		$or_like['UPPER(p.value)'] = strtoupper( $q );
		$or_like['UPPER(p.tags)'] = strtoupper( $q );
		$or_like['UPPER(p.category)'] = strtoupper( $q );
		$or_like['UPPER(s.service_name)'] = strtoupper( $q );
		
		$query_specs['or_like'] = $or_like; 

		foreach( $or_like as $key=>$val ){
  	 
      $this->db->or_like( $key , $val );	
  		
		}
		
		if( empty( $query_specs['limit'] ) OR $query_specs['limit'] > 20 ) 
      $query_specs[ 'limit' ] = 20;
		
		$this->db->limit( $query_specs['limit'] );
  	
  	
    $this->db->where( 'ups.FK_u_id' , $this->user_id );
  	$this->db->group_by( 'ups.FK_p_id' ); // this shit need to be handled
  	
    $query = $this->db->get();
		
		if( $query->num_rows() ) {
			//free the result
			$result = $query->result();
			
			$query->free_result();
			
			$this->query_specs = $query_specs;
			
			return $result;
		} 
		
		return false;

  	
	}
	

}

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */