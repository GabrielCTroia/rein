<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/* 
	Class Access:
	-takes care of the ACCESS 
	- gets/sets the access tokens for each service for the user
	
*/
	
Class Access extends CI_Model
{	
	private $user_id = false;
	
	function initialize( $user_id )
	{
		$this->user_id = $user_id;
	}
	
	//get the access_tokens of a specific service of the user_id
	function get_access( $service_id )
	{
		
		$this->db->select( 'access_tokens' );
		$this->db->from( 'users' );
		$this->db->join( 'access' , 'users.user_id = access.user_id' , 'right' );
		$this->db->where( 'users.user_id', $this->user_id );
		$this->db->where( 'access.service_id', $service_id );
		
		$query = $this->db->get( '' , 1 );
		
		if( $query->num_rows() > 0 )
		{
			//free the result
			$result = $query->result();
			$query->free_result();
			
			return $result[0]->access_tokens;
		}
		else
		{
			return false;
		}
	}
	
	//sets the acces_tokens of a specific service of the user_id
	function set_access( $service_id , $access = false , $status = 'init' )
	{
		/* 
			to look into a way to insert or update if there is a user_id with the same service_id 
			- not to add another one
		*/	
		
		$data = array ( 
				'user_id' 			=> $this->user_id , 
				'service_id' 		=> $service_id , 
				'access_status' 	=> $status
				);
				
		//check if it should update/insert the access_tokens to or not		
		if ( $access ) 
		{
			$data['access_tokens'] = $access;
		}
				

		//check if it should do an update or an insert
		if ( $this->get_access ( $service_id ) ) 
		{
			
			$this->db->where( 'user_id' , $this->user_id );
			$this->db->where( 'service_id' , $service_id );
			
			if( !$this->db->update( 'access' , $data ) )
			{	
				
				return false;	
			}	
			
		}
		else
		{

			if( !$this->db->insert( 'access' , $data ) )
			{
				return false;
			}
			
		}

		return true;
		
	}
	
	//returns all the services that are active and working right now
	function get_active_accesses()
	{
		$this->db->select( 'service_id' );
		$this->db->from( 'access' );
		$this->db->where( 'user_id' , $this->user_id );
		$this->db->where( 'access_status' , 'active' );
		$this->db->order_by( 'service_id' );
		
		$query = $this->db->get( );
		
		if( $query->num_rows() > 0 )
		{
			//free the result
			$result = $query->result();
			$query->free_result();
			
			return $result;
		}
		else
		{
			return false;
		}
		
	}
	
}

//pure php doesn't need the closing tag 