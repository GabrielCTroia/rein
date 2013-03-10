<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* $this->load->model( 'Posts', '', false );	 */

require_once( APPPATH . 'models/posts_model.php' );  

	
Class Posts_instagram extends Posts_Model {	
	
	function insert( $posts = NULL ){
  	
  	if( !$posts ){
    	
    	$this->error = true;
    	$this->error_msg = 'no posts to insert';
    	
    	return false;
  	}
  	
  	$sql  = 'INSERT INTO ' . $this->base_table;
      $sql .= '(';
        foreach( $posts[0] as $ref=>$value ) :
          $sql .= '`' . $ref . '`';
          $sql .= ( $value != end($posts[0]) ) ? ' , ' : ''; 
        endforeach;
      $sql .= ') ';      
    $sql .= ' VALUES';
      foreach( $posts as $post ) :
        $sql .= '(';
        foreach( $post as $ref=>$value ) :
          $sql .= '\'' . $value . '\'';
          $sql .= ( $value != end($post) ) ? ' , ' : '';  
        endforeach;
        $sql .= ') ';
        $sql .= ( $post != end($posts) ) ? ' , ' : '';
      endforeach;   
  	$sql .= ' ON DUPLICATE KEY UPDATE post_foreign_id = post_foreign_id';
  	   

/*   	if( $this->db->insert( $this->base_table , $data ) ) */
/*     echo $sql; */
    
    if( !$this->db->query( $sql ) ){
      $this->error = true;
    	$this->error_msg = 'no posts to insert';
    	
    	return false;
    	
    }
    
  }
  
}

//pure php doesn't need the closing tag 