<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login extends MY_Controller {

	function __construct() {
	
		parent::__construct();

    $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		
		/* I DO ALL THE VALIDATION HERE - NOT SURE IF THE BEST */
		
		/* 
		 * check one more time if the user exists in the session and fallback to index() if NOT
		 * OR if the entered credentials are good and log him in if YES
		 */	
		if( $this->logged_in  ) { 
	    
  		redirect( "home" );
  		
<<<<<<< HEAD
  		$post = $this->input->post();
  		
  		redirect( $post['url'] . "/message/fail" );
  		
		}
		
		
=======
  		}

>>>>>>> temp
	}  
  
    
  public function widget(){
    
    
  /* load the User model */
  	$this->load->model( 'User_model' , '' , false );
		
		/* set the rules */
    $this->form_validation->set_rules(
    
      array(
	       array(
	              'field' => 'email',
	              'label' => 'Email',
	              'rules' => 'trim|required|xss_clean|valid_email'
	        ),
	        
	        array(
	              'field' => 'password',
	              'label' => 'Password',
	              'rules' => 'trim|required|xss_clean|md5|callback__check_db'
	        )
	     )     
	        
	   );     
	   
	   $this->form_validation->set_error_delimiters('<p class="error">', '</p>'); 
	   


	   if( $this->form_validation->run() ){
      
      /* retrieve the USER_INFO */          
		  if( $user_info = User_model::validate_login( array( "email" => $this->input->post('email') , "password" => $this->input->post('password') ) , true ) ) {
  		  
  		  $this->session->set_userdata( array_merge( array( 'logged_in' => true ) , $user_info ) );
  			
  			redirect( 'home' );

		  }
      	
		}  
    
    //else stay here
    
    $this->load->view('login_default.php');
    
  }	
	
    	/* 
    	 * called by $this->verifylogin(); 
     	 */
    	public function _check_db( $password ) {      	
        
        /* cache the inputs */
        $email = $this->input->post('email');
        
        return User_model::validate_login( array( "email" => $email , "password" => $password ) );	
      	
    	}
  
  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */