<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* $this->load->model( 'Posts', '', false );	 */

	
Class Posts_twitter extends CI_Model
{	
	
	public static function get_posts()
	{
		parent::get_posts();
		// or the function  can be named get_tweets() - we'll see
		
		echo "get tweets";
			
	}
	
	
	function set_post( $post = array() )
	{
	
		
			
	}
	
	function set_posts_bulk(){
		//to add bulk into teh db
		//to develop later
	}

	


}

//pure php doesn't need the closing tag 