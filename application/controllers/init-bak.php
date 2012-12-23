<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Explain Views & Controllers organization :
  
  Every Controller loads a common index.php which loads a specific
  page ( home.php , splash.php , callback.php , connect.php ...) 
  which also loads specifc components ( sign-up.php , login.php , feed.php , settings.php ... )
  among with the page specific includes ( hedaer.php , footer.php ) 
  
*/



class Init extends CI_Controller {
  
  /* 
   * define the page url  
  */
  $page_url = base_url() . "init";  
  
  /* 
  load the parent construct 
  */  
  function __construct()
	{
		parent::__construct();

	}
  
  /*
   * the index() acts like a router
   * the user never stays on it so it doesn't have a view
  */
	public function index() {	
			
		if( !$this->session->userdata( 'logged_in' ) ) {
      
  		//if it's not logged in redirect to signup
/*       redirect( $page_url . 'signup' ); */

      /* set the page */
      $data['page'] = 'init';

      self::signup();
								
		} else redirect( 'home' );
	
	}
	
	
	/* Everything below this point is actually a COMPONENT */
	
	
  /*
   * SIGNUP component
  */
	public function signup() {	
		
		/* 
		 * check if the user exists in the session and redirects it to HOME page if TRUE
		 */	
		if( $this->session->userdata( 'logged_in' ) ) { 
		  
		  //if the user is in the session then index() is gonna' redirect it wherever it needs ( home.php )
  		redirect( self::$page_url );
		
		}
    
    /* ElSE */

    /* set the component */
    $data['component'] = 'signup';
    		
	  $this->load->helper( 'form' );
	  $this->load->library( 'form_validation' );
	  
	  $this->form_validation->set_rules( 
	   
	     array(
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
	     ) 
	     
	   );
	      
	  $this->form_validation->set_error_delimiters( '<div class="error">' , '</div>' );
	  
	  
	  if( $this->form_validation->run() == FALSE ) {
	    
  	  redirect( $page_url );
  	  
		} else {
		  
		  /* this should actually be stored in a model */
		  
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
		  
		  /* still need to add the user to session and send it to the home page 
  		  
  		  update: actually it should redirect it to verify login and from there redirect to wherever if it's good
		  */
		  
		  
  	 
		  //something like this
		  //but maybe stored somewhere else ( where the inserts are made )
		  
		  //if the user is in the session then index() is gonna' redirect it wherever it needs ( home.php )
  		
  		redirect( self::$page_url . "/verifylogin" );
		  
		  /*
      $this->session->set_user_data( array(
      			        'user_id' => $user_id,
      			        'logged_in' => TRUE
      			      ) );
      */
		  
		  //$data[ 'message' ] = 'Congratulations on signing up!';
		  
		}	
	
		$this->load->view( 'index.php' , $data );
	
	}
	
	
	
	/*
   * SIGNUP component
  */
	public function verifylogin() {	
  
    /* load the User model */
  	$this->load->model('User','',false);
  	
  	/* load the credential validation library */
		$this->load->library( 'form_validation' );
		
		$this->form_validation->set_rules( 'email', 'Email', 'trim|required|xss_clean' );
		$this->form_validation->set_rules( 'password', 'Password', 'trim|required|xss_clean|callback_check_password' );
		
    
    /* 
    * if it's valid populate the session with the user info and redirect to self again (this time should be re-redirected to home )
    */ 
    		
		if( $this->form_validation->run() == true ){
				
		  $user_info = User::validate_login( $password , true );
            					
			$this->session->set_userdata( 'logged_in' , $user_info );
	
		} 
  	
  	redirect( self::$page_url );
  	
	}
	
	//called by self::verifylogin();
	private function check_password( $password ) {
  	
    return User::validate_login( $password );	
  	
	}
	
}	

/* End of file init.php */
/* Location: ./application/controllers/init.php */