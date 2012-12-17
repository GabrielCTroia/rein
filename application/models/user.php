<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
Class User extends CI_Model
{
	
	function login($email,$password)
	{
		$this->db->select('user_id, email, password');	
		$this->db->from('users');
		$this->db->where('email =' . "'" . $email . "'" );
		$this->db->where('password =' . "'" . $password . "'" );
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		if( $query->num_rows() == 1 )
		{
			return $query->result();
		}
		else
		{
			return false;
			
		}
	}
}


//pure php doesn't need the closing tag 