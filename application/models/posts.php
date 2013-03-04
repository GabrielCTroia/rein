<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


Class Posts extends CI_Model {	

	private $user_id = false;
	private $service_name = false;
	private $service_id = false;
	
	function set_user( $user_id )
	{	
		$this->user_id = $user_id;
		
	}
	
	function set_service( $service_name , $service_id )
	{
		$this->service_name = $service_name;
		$this->service_id = $service_id;
		
	}
	
	function get_posts( $limit = 20 , $extra_fields = false )
	{	
		
		$select_str = 'p_id, post_foreign_id, service_id, posts.created_date, value, source, param ' . ' , ' .$extra_fields;

		$this->db->select( $select_str );
		$this->db->from( 'posts' );
		$this->db->join( 'users' , 'users.u_id=posts.u_id');
		$this->db->where( 'posts.u_id', $this->user_id );
			
		if( $this->service_id ){
			
			// if there is a service_id specified than return only that
			// if it's not specified return everything
			$this->db->where( 'posts.s_id', $this->service_id );
			
		}	
		
		$this->db->order_by( 'posts.created_date desc' );
		
		$query = $this->db->get( '' , $limit );


		if( $query->num_rows() > 0 )
		{
			return $query->result();
		}
		else {
			return false;
		}
		
	}

/*
	
	function get_post( $extra_fields = false )
	{
		
		$select_str = 'post_id' . ' , ' . $extra_fields;	
		
		
		
		$this->db->select( $select_str );
		$this->db->from( 'posts' );
		$this->db->join( 'users' , 'users.user_id=posts.user_id');
		$this->db->where( 'posts.user_id', $this->user_id );
		$this->db->where( 'posts.service_id', $this->service_id );
		$this->db->order_by( 'collected_date desc , post_id asc' );
		
		$query = $this->db->get( '' , 1 );
		
		if( $query->num_rows() > 0 )
		{
			return $query->result();
		}
		else {
			return false;
		}
		
	}
*/
	//get the latest post in a specified query
	function get_last_post( $service_id = false , $fields = false , $order_by = 'created_date' , $dir = 'desc' )
	{
		
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
	
	
	function insert_posts( $posts )
	{
		
		if( !$this->user_id || !$posts ) return false;
		
/* 		$posts = $this->format_posts( $posts ); */
		
		//do the check (not sure if it's done write)
		//if this is the same with t
/* 		var_dump ( $this->check_post( 'post_foreign_id' ) ); */
		
		//to be continued
		
		
/* 		var_dump($posts[0]); */
/* 		if ( $this->get_posts( 1 , true ) == $posts[] ); */
		
/*
		foreach ( $posts as $post )
		{
			$this->db->insert( 'posts' , $post );
			
		}
*/
		
		if( $this->db->insert_batch( 'posts' , $posts ) ) {
			return true;
		}
		
		return false;		
			
	}
	
	
	
	
	
	
	
	function set_posts_bulk(){
		//to add bulk into teh db
		//to develop later
	}
	



/*
	function get_posts_twitter(){
		
		
	}
*/

}

/* End of file posts_model.php */
/* Location: ./application/models/posts_model.php */