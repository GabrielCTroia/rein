<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Sign_up extends CI_Controller {

	public function index() {	
			
		if( !$this->session->userdata( 'logged_in' ) ) {
		  
		  $data[ 'logged_in' ] = 'splash';
		  
		  // Load the sign-up page
		  $this->load->view( 'common/header', $data );
			$this->load->view( 'sign_up' );
			$this->load->view( 'common/footer' );
								
		} else header( 'location: /home/feed' );
	}
}

/* End of file signup.php */
/* Location: ./application/controllers/signup.php */