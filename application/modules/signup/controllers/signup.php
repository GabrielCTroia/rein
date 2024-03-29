<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Signup extends MY_Controller {
  
	function __construct() {
	
		parent::__construct();

    $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		
		/* I DO ALL THE VALIDATION HERE - NOT SURE IF THE BEST */
		
		/* 
		 * check one more time if the user exists in the session and fallback to index() if NOT
		 * OR if the entered credentials are good and log him in if YES
		 */	
		 
		if( $this->logged_in ) { 
	    
  		redirect( "home" );
		
		} 
		
	}  
  
    
  public function widget(){
    
    $this->form_validation->set_rules( 
  	   
  	     array(
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
  	     ) 
  	     
  	   );
     
  	  $this->form_validation->set_error_delimiters('<p class="error">', '</p>'); 

  	  if( $return = $this->form_validation->run() ) {
  		  
  		  $this->load->model( 'User_model' , '' , TRUE );
  		  
  		  //  register a new user to the database and return his unique user_id
  		  $user_id = $this->User_model->register_user( $this->input->post() );  
  		  		  
  		  $this->session->set_userdata(
  		      array(
  		        'logged_in' => TRUE,
  		        'u_id' => $user_id,
  		        'tutorial' => TRUE,
  		        'message' => 'Congratulations on signing up!'
  		      )
  		  );
  		  
  		  redirect( 'home' );
  
  		}	
    
    
    $this->load->view('signup_default.php');
    
  }	
  
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */