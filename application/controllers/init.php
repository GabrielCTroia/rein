<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Init extends CI_Controller {

	public function index() {	
			
		if( !$this->session->userdata( 'logged_in' ) ) {
		  
		  $data[ 'logged_in' ] = 'splash';
		  
		  // Load the splash page
		  $this->load->view( 'common/header', $data );
			$this->load->view( 'splash' );
			$this->load->view( 'common/footer' );
								
		} else header( 'location: /home/feed' );
	}
}

/* End of file init.php */
/* Location: ./application/controllers/init.php */