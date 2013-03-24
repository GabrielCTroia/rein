<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

 /* 
  * This is the controller for the anonymus users. 
  * The methods meant to be used by different controller extending this one are written here:
    - signup()
    - login()
  */
  
require_once( APPPATH . 'core/controllers/Main_controller.php' );

class Anonym_Controller extends Main_Controller {


  /* 
   * whenver this controller is used means that the user is not logged in 
   */
  
  public function __construct(){
    
    parent::__construct();
    
    if( $this->_check_authentication() ) {
      
  		redirect('home');
  		
		}
		
		$this->logged_in = false;
    
  }
  
  
 /*
  * SIGNUP component
  */
	public function signup() {	
  	
		/* 
		 * check one more time if the user exists in the session and fallback to index() if NOT
		 */	
		if( $this->logged_in ) { 
		  
		  //if the user is in the session then index() is gonna' redirect it wherever it needs ( home.php )
  		redirect( $this->page_url );
		
		}
    
    /* ElSE */

    //  define the component
    $this->Components_model->init( 'signup' );
    
	  
	  $this->form_validation->set_rules( 
	   
	     array(
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
	     ) 
	     
	   );
	      
	  $this->form_validation->set_error_delimiters( '<div class="error">' , '</div>' );
	  
	      
	  if( $this->form_validation->run() ) {
		  
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
		  
		  //  Marius: If it does that, then how will it know if the user just registered.
		  //  Eventually we're going to need to have some tutorials or hints for first time users + we need
		  //  to get them connected with social media networks. I get where you're coming from but it's a 
		  //  short term solution.
		  
		  /* Redirects to home  */
		  redirect( 'home/settings' );
      
      
		  
		}	

		$this->load->view( 'index.php' );
	
	}
	
	
	
	
 /*
  * LOGIN component
  */
	public function login() {	
	
    /* 
		 * check one more time if the user exists in the session and fallback to index() if NOT
		 * OR if the entered credentials are good and log him in if YES
		 */	
		if( $this->logged_in || self:: _verifylogin() ) { 
		  
	   /*
		  *if the user is in the session OR he entered valid credentials 
	    *then index() is gonna' redirect it wherever it needs ( home.php )
	    */
	    
  		redirect( "home" );
		
		}
    
    /* ELSE  */
    
    //  define the component
    $this->Components_model->init( 'login' );		
		
    $this->load->view('index.php');		      

	}
	
	

	  /* 
	   * called by this->login() 
	   *
	   * TO DO - add the ability to login with the EMAIL too
	   */
  	private function _verifylogin() {	
 
      /* load the User model */
    	$this->load->model( 'User_model' , '' , false );
  		
  		/* set the rules */
      $this->form_validation->set_rules(
      
        array(
  	       array(
  	              'field' => 'user_name',
  	              'label' => 'User Name',
  	              'rules' => 'trim|required|xss_clean'
  	        ),
  	        
  	        array(
  	              'field' => 'password',
  	              'label' => 'Password',
  	              'rules' => 'trim|required|xss_clean|callback__check_db'
  	        )
  	     )     
  	        
  	   );       

  	   
  		if( $this->form_validation->run() ){
        
        /* cache the inputs */  
        $user_name = $this->input->post('user_name');
        $password  = $this->input->post('password');  
        
        /* retrieve the USER_INFO */          
  		  if( !$user_info = User_model::validate_login( array( "user_name" => $user_name , "password" => $password ) , true ) ) {
    		  
    		  //show error
    		  
  		  } else {
    		  
      		/* and store in the SESSION */                      					
    			$this->session->set_userdata( array_merge( array( 'logged_in' => true ) , $user_info ) );
    			
    			return true;
    		  
  		  }
        	
  		} 
		  return false;    	
  	}
	
    	/* 
    	 * called by $this->verifylogin(); 
    	*/
    	public function _check_db( $password ) {      	
        
        /* cache the inputs */
        $user_name = $this->input->post('user_name');
        
        return User_model::validate_login( array( "user_name" => $user_name , "password" => $password ) );	
      	
    	}
  
  
  
}