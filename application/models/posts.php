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
		
		$select_str = 'post_id, post_foreign_id, service_id, posts.created_date, value, source, param ' . ' , ' .$extra_fields;

		$this->db->select( $select_str );
		$this->db->from( 'posts' );
		$this->db->join( 'users' , 'users.user_id=posts.user_id');
		$this->db->where( 'posts.user_id', $this->user_id );
			
		if( $this->service_id ) 
		{
			
			// if there is a service_id specified than return only that
			// if it's not specified return everything
			$this->db->where( 'posts.service_id', $this->service_id );
			
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
	
	
	
	function format_posts( $posts ){
		

		//if there are no posts to format return false;

		if( !$posts ) return false;
		
		$data = array();
		
		
		//this needs to be out in a separate .config file or something
		$date_format = 'Y-m-d H:i:s';
		 
		
		//each posts is formated almost the same with the only difference in the param
		//so in the next future I need to find a solution to get rid of the switch
		//get the params already set or something like this
		
		//I should keep a lot of other stuff in my DB - in the params field. Never know when I might need it
		switch( $this->service_name )
		{
			case 'twitter' : 

				foreach( $posts as $index=>$post )
				{	
					$data[$index] = array(
						
						'post_foreign_id' => $this->format_foreign_id( $post->id_str ),
						'user_id' => $this->user_id,
						'service_id' => $this->service_id,
						'created_date' => date( $date_format, strtotime($post->created_at) ),
						'status' => 'active',
						'value' => $post->text,
						'source' => '',
						'param' => '{
							"user_id" 		: "' . $post->user->id_str . '",
							"user_name" 	: "' . $post->user->screen_name . '",
							"profile_image" : "' . $post->user->profile_image_url . '",
							"user_url" 		: "' . $post->user->url . '",
							"post_type" 	: "favorited"
						}'
						
					);
				}
			
			break;
			
			case 'instagram' :
				// all the posts (except maybe the twwets should hava a title field - fulletxt searchable 
				// here title = caption

				//not the best place to put it but works for now
				// - if not here it would generate an error
				date_default_timezone_set('America/New_York');
				
				foreach( $posts as $index=>$post )
				{	
					
					$data[$index] = array(
						
						'post_foreign_id' => $this->format_foreign_id( $post->id ) ,
						'user_id' => $this->user_id,
						'service_id' => $this->service_id,
						'created_date' => date( $date_format, $post->created_time ),
						'status' => 'active',
						'value' => $post->images->standard_resolution->url,
						'source' => '',
						'param' => '{
							"user_id" 		: "' . $post->user->id . '",
							"user_name" 	: "' . $post->user->username . '",
							"profile_image" : "' . $post->user->profile_picture . '",
							"user_bio" 		: "if the bio is russian the object breaks",
							"post_type" 	: "favorited",
							"filter" 		: "' . $post->filter . '",
							"tags" 			: "' . $post->tags .'",
                            "caption" 		: "if the caption is russian the object breaks"
						}'
						
					);
				}
				
				
			break;
			
		}		
		
		return $data;

	}
	
	//should be accessed only inside the class
	private function format_foreign_id( $fid )
	{
		$prefix = "s" . $this->service_id . "u" . $this->user_id . "-";
		
		return $prefix . $fid;
	}
	
	//format the foreign id
	function unformat_foreign_id( $fid )
	{
		return substr( $fid , strpos( $fid , "-" ) + 1 , strlen( $fid ) );
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

//pure php doesn't need the closing tag 