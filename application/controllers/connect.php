<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Connect extends CI_Controller {
  
  public function signup() {	
			
		if( !$this->session->userdata( 'logged_in' ) ) {
		
		  $this->load->helper( 'form' );
		  $this->load->library( 'form_validation' );
		  
		  $this->form_validation->set_rules( array(
		        array(
		              'field' => 'name',
		              'label' => 'Name',
		              'rules' => 'trim|required|min_length[5]|max_length[60]'
		        ),
		        array(
		              'field' => 'user_name',
		              'label' => 'User Name',
		              'rules' => 'trim|required|min_length[5]|max_length[30]|is_unique[users.user_name]'
		        ),
		        array(
		              'field' => 'email',
		              'label' => 'Email',
		              'rules' => 'trim|required|valid_email|is_unique[users.email]'
		        ),
		        array(
		              'field' => 'password',
		              'label' => 'Password',
		              'rules' => 'required|matches[password_confirm]|md5'
		        ),
		        array(
		              'field' => 'password_confirm',
		              'label' => 'Password Confirmation',
		              'rules' => 'required'
		        )
		      ) );
		      
		  $this->form_validation->set_error_delimiters( '<div class="error">' , '</div>' );
		  
		  
		  if( $this->form_validation->run() == FALSE ) {
		    
		    $data[ 'logged_in' ] = 'splash';
		    
		    // Load the sign-up page
		    $this->load->view( 'common/header', $data );
			  $this->load->view( 'sign_up' );
			  
			} else {
			  
			  $this->load->library('session');
			  
			  $email = $this->input->post( 'email' );
			  $user_name = $this->input->post( 'user_name' );
			  
			  // Enter information into database
			  $this->db->insert( 'users' , array(
			        'name' => $this->input->post( 'name' ),
			        'user_name' => $user_name,
			        'email' => $email,
			        'password' => $this->input->post( 'password' )
			      ) );
			  
			  // get the user_id from the newly created row
			  $user_id = $this->db->get_where( 'users' , array(
			        'user_name' => $user_name,
			        'email' => $email
			      ) , 1 );
			  
			  /*
        $this->session->set_user_data( array(
        			        'user_id' => $user_id,
        			        'logged_in' => TRUE
        			      ) );
        */
			  
			  $data[ 'logged_in' ] = 'logged_in';
			  $data[ 'message' ] = 'Congratulations on signing up!';
			  
		    $this->load->view( 'common/header', $data );
  			$this->load->view( 'config.php' , $data );
  		}
			
			$this->load->view( 'common/footer' );
								
		} else header( 'location: /home/feed' );
	}
}

/* End of file signup.php */
/* Location: ./application/controllers/signup.php */