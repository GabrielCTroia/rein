<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class VerifyLogin extends CI_Controller {


	function __construct()
	{
		parent::__construct();
		
		$this->load->model('User','',false);
	}
	
	public function index()
	{
		
		//load the credential validation library 
		$this->load->library( 'form_validation' );
		
		$this->form_validation->set_rules( 'email', 'Email', 'trim|required|xss_clean' );
		$this->form_validation->set_rules( 'password', 'Password', 'trim|required|xss_clean|callback_check_database' );
			
		
/* 		return; */
		if( $this->form_validation->run() == false )
		{
			redirect( base_url() . "?login=false" );
		}
		else
		{
			redirect( base_url() );
		}
	}
	
	public function check_database($password)
	{
		//Field validation succeeded.  Validate against database
		$email = $this->input->post('email');

		//query the db
		$result = $this->User->login($email,$password);
		
		if( $result )
		{
			$sess_array = array();
			
			foreach($result as $row)
			{
				$sess_array = array(
						'user_id' => $row->user_id,
						'email' => $row->email				
					);
				
				$this->session->set_userdata( 'logged_in', $sess_array );
			}
			
			return true;
		}
		else
		{
			$this->form_validation->set_message( 'check_database', 'Invalid username or password' );
			return false;
		}
		
	}
	
}