<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* 
	Class Services: 
	
	- takes care of the SERVICES TABLE
	sets/gets the dats out of it

*/	
	
Class Services extends CI_Model
{	
	private $service_name = false; 
	
	
	//returns the service object
	function initialize( $service_name )
	{
		$this->service_name = $service_name;
		
		return( $this->get_service() );
	}
	

	function get_service( $limit = 1 )
	{
		//this does the work for all the 3 below
		//no need for them anymore
		
		$this->db->select( '*' );
		$this->db->from( 'services' );
		$this->db->where( 'service_name' , $this->service_name );
		$this->db->where( 'service_status' , 'active' );
		
		$query = $this->db->get( '' , $limit );
		
		if( $query->num_rows() > 0 )
		{
			$result = $query->result();
			$query->free_result();
			
			return $result[0];
		}
		else {
			return false;
		}
		
	}
	
	//get the service name by id
	function get_service_name( $id )
	{
		$this->db->select( 'service_name' );
		$this->db->from( 'services' );
		$this->db->where( 'service_id' , $id );
		$this->db->order_by( 'service_id' );
		
		$query = $this->db->get();
		
		
		if( $query->num_rows() > 0 )		
		{	
			$result = $query->result();
			
			return $result[0]->service_name;
				
		}
		else
		{
			return false;	
		}
		
		
	}
	
	
	//get the service id by name
	function get_service_id( $name )
	{
		
		$this->db->select( 'service_id' );
		$this->db->from( 'services' );
		$this->db->where( 'service_name' , $name );
		
		$query = $this->db->get();
		
		
		if( $query->num_rows() > 0 )		
		{	
			$result = $query->result();
			
			return $result[0]->service_id;
				
		}
		else
		{
			return false;	
		}
		
	}
	
	//returns a specific service's datas
	function get_service_data( $service_id , $limit = 1 )
	{
		//maybe I should make them all 3 in one: get_Srvice_id / get_service_name / get_Service_data
		$this->db->select( '*' );
		$this->db->from( 'services' );
		$this->db->where( 'service_id' , $service_id );
		$this->db->where( 'service_status' , 'active' );
		
		$query = $this->db->get( '' , $limit );
		
		if( $query->num_rows() > 0 )
		{
			$result = $query->result();
			$query->free_result();
			
			return $result[0];
		}
		else {
			return false;
		}
		
	}
	
	
	
	//returns a list of active services ready to connect
	function get_services( $limit = 50 )
	{
		
		$this->db->select( 'service_id , service_name' );
		$this->db->from( 'services' );
		$this->db->where( 'service_status' , 'active' );
		
		$query = $this->db->get( '' , $limit );
		
		if( $query->num_rows() > 0 )
		{
			$result = $query->result();
			$query->free_result();
			
			return $result;
		}
		else {
			return false;
		}
		
	}
	
	//returns a list of services reeady to be authenticated with
	function get_authentication( $limit = 50 )
	{
		
		$this->db->select( 'service_name , service_id' );
		$this->db->from( 'services' );
		$this->db->where( 'authentication' , 1 );
		
		$query = $this->db->get( '' , $limit );
		
		if( $query->num_rows() > 0 )
		{
			$result =  $query->result();
			$query->free_result();
			
			return $result;
			
		}
		else {
			return false;
		}
		
	}
	
}


//pure php doesn't need the closing tag 