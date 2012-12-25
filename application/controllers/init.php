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
  private static $page_url = "/init";  
  
  
 /* 
  * define the $data that will be passed to the view  
  */
  private static $data = array();
  
  
  

  function __construct() {
	 
   /* 
    * load the parent construct 
    */  
    parent::__construct();
		
		//  We are storing the Page and Components object as classes inside models
		//  because we want to be able to access them from anywhere within the controller
		//  instead of redefining a new variable for it everysingle time
    $this->load->model( 'Pager' , '' , FALSE );
    $this->load->model( 'Components' , '' , FALSE );
    
    //  At the time of writing this, both models are identical, so they accept a single
    //  $name variable which automatically generates $name/$path/$url inside the init function
    $this->Pager->init( 'init' );
      
	}
  
  
  
  
  
  
  /*
   * the index() acts like a router
   * the user never stays on it so it doesn't have a view
  */
	public function index() {	
			
		if( !$this->session->userdata( 'logged_in' ) ) {
      
      /*
      if we just call the self::method instead of redirect() than the url is not gonna' be changed
      it may be usefull in some cases but for now I wanna' stick with this
      */
      
      //  load splah page
      redirect( self::$page_url . '/splash_page' );
            								
		} else
		  redirect( 'home' );
		
	}
	
	public function splash_page() {
	  
  	$this->Components->init( 'splash' );
  	
  	$this->load->view( 'index.php' );
  	
	}
	
	/* Everything below this point is actually a COMPONENT */
	
	
  /*
   * SIGNUP component
  */
	public function signup() {	

		/* 
		 * check one more time if the user exists in the session and fallback to index() if NOT
		 */	
		if( $this->session->userdata( 'logged_in' ) ) { 
		  
		  //if the user is in the session then index() is gonna' redirect it wherever it needs ( home.php )
  		redirect( self::$page_url );
		
		}
    
    /* ElSE */

    //  define the component
    $this->Components->init( 'signup' );
    
    
    /* 
    load the helpers   
    */
	  $this->load->helper( 'form' );
	  $this->load->library( 'form_validation' );
	  
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
		  
  	  /*
		  ****TO WHO EVER READS THIS****
		  At this point the script doesn't get here. Not sure why but I'm kind of tired so I'll go home:D
		  
		  - Dude, there's only 1 other person who will read this
		  */
		  
		  $this->load->model( 'User' , '' , TRUE );
		  
		  //  register a new user to the database and return his unique user_id
		  $user_id = $this->User->register_user( $this->input->post() );
		  
		  
		  $this->load->library('session');
		  
		  $this->session->set_userdata(
		      array(
		        'logged_in' => TRUE,
		        'user_id' => $user_id,
		        'tutorial' => TRUE,
		        'message' => 'Congratulations on signing up!'
		      )
		  );
		  
		  //  Marius: If it does that, then how will it know if the user just registered.
		  //  Eventually we're going to need to have some tutorials or hints for first time users + we need
		  //  to get them connected with social media networks. I get where you're coming from but it's a 
		  //  short term solution.
		  
		  redirect( 'config' );
		  
		}	

		$this->load->view( 'index.php', self::$data );
	
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
		$this->form_validation->set_rules( 'password', 'Password', 'trim|required|xss_clean|callback__check_password' );
		
    
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
	private function _check_password( $password ) {
  	
    return User::validate_login( $password );	
  	
	}
	
}	

/* End of file init.php */
/* Location: ./application/controllers/init.php */