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
  
  
	
	function get_posts( $specifics = array() , $limit = 20 ,  $extra_fields = false , $order_by = 'created_date' , $order_dir = 'DESC' ) {	
		
		$select_str = "*"; //this should be more restriced but works for the testing phase


    $sql  = 'SELECT ' . $select_str . ' FROM ' . $this->base_table . ' AS p' 
         . ' JOIN users_posts_services AS ups ON ups.FK_p_id = p.post_foreign_id '
         . ' JOIN services AS s ON s.s_id = ups.FK_s_id'         
         . ' WHERE ';
         if( !empty( $specifics ) ) {
           foreach( $specifics as $ref=>$val ) {              
             $sql .= $ref . ' = ' . '\'' . $val . '\' AND ';              
           }
         } 

    $sql .= 'ups.FK_u_id = ' . $this->user_id
         . ' GROUP BY ups.FK_p_id ' //this is not the best but works - I need to find a way to not insert duplicates in the 1st place       
         . ' ORDER BY p.' . $order_by . ' ' . $order_dir
         . ' LIMIT ' . $limit 
         ; 

		if ( !$query = $this->db->query($sql) ) {
  		
  		$this->error = true;
  		
  		$this->error_msg = "Couldn't insert the posts in the database!";		  
  		
		} else {
  		
  		if( $query->num_rows() ) {
  				
  			//free the result
  			$result = $query->result();
  			
  			$query->free_result();
  			
  			return (object)$result;
  			
  		} else {
    		
    		$this->error = true;
        
        $this->error_msg = "There are no posts to show!";		  
    		
    		return false;
    		
  		}	
  		
		}
				    
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
		
		if( $query->num_rows() > 0 ) {

			return $query->result();

		} else {
		  
      $this->error = true;
      
      $this->error_msg = "There are mo posts to show!";		  
		  
			return false;
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
  	
/*
  	var_dump( $posts[0] );
  	exit();
*/
  	
/*   	$sql = ' BEGIN ' */
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

    
/*     $sql .= ' COMMIT ';      */
  
/*
        $sql .= ' (';
          foreach( $posts[0] as $ref=>&$value ) :
            $sql .= '`' . $ref . '`';
            $sql .= ( $value != end($posts[0]) ) ? ' , ' : ''; 
          endforeach;
        $sql .= ') ';      
        
        $sql .= ' VALUES';
          foreach( $posts as $post ) :
            $sql .= '(';
            foreach( $post as $ref=>$value ) :
              $sql .= '\'' . mysql_real_escape_string( $value ) . '\'';
              $sql .= ( $value != end($post) ) ? ' , ' : '';  
            endforeach;
            $sql .= ') ';
            $sql .= ( $post != end($posts) ) ? ' , ' : '';
          endforeach; 
*/  
          
          
/*
      	$sql .= ' ON DUPLICATE KEY UPDATE post_foreign_id = post_foreign_id ';
      	
      	$sql .= ' INSERT INTO users_posts_services ( FK_u_id , FK_p_id , FK_s_id )'
      	      . " VALUES( {$this->user_id} , $post  ,  ) "
    
    $sql .= ' COMMIT';
     
  	
  	BEGIN
INSERT INTO users (username, password) 
  VALUES('test', 'test')
INSERT INTO profiles (userid, bio, homepage) 
  VALUES(LAST_INSERT_ID(),'Hello world!', 'http://www.stackoverflow.com');
COMMIT;
*/
  	
      
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