<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Explain Views & Controllers organization :
  
  Every Controller loads a common index.php which loads a specific
  page ( home.php , splash.php , callback.php , connect.php ...) 
  which also loads specifc components ( sign-up.php , login.php , feed.php , settings.php ... )
  among with the page specific includes ( header.php , footer.php ) 
  
  
  {Ghost} Component = A component which doesn't have a view assgined to it
                      It mostly only redirects you to another URL where you actually load a view
                      The difference between a Ghost Component and a method is that you actually use it as a URL 
*/

require_once( APPPATH . 'core/controllers/Anonym_controller.php' );

class Init extends Anonym_controller {

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
    $this->load->model( 'Pager_model' , '' , FALSE );
    $this->load->model( 'Components_model' , '' , FALSE );
    
    //  At the time of writing this, both models are identical, so they accept a single
    //  $name variable which automatically generates $name/$path/$url inside the init function
    $this->Pager_model->init( 'init' );
      
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
      redirect( self::$page_url . '/splash' );
            								
		} else {
  		
  		redirect( 'home' );
  		
		}

	}
	

	
	/* ****************************************************	
  	 Everything below this point is actually a COMPONENT 
	
    **************************************************** */
	
	
	
	
 /* 
  * SPLASH component
  */
  public function splash() {

    //  define the component	  
  	$this->Components_model->init( 'splash' );
  	
  	$this->load->view( 'index.php' );
  	
	}
	
	
	
	
	
	
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
    $this->Components_model->init( 'signup' );
    
    
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
		  
		  $this->load->model( 'User_model' , '' , TRUE );
		  
		  //  register a new user to the database and return his unique user_id
		  $user_id = $this->User_model->register_user( $this->input->post() );
		  
		  
		  $this->load->library('session');
		  
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
		  redirect( '/home/settings' );
      
      
		  
		}	

		$this->load->view( 'index.php' );
	
	}
	
	
	
	
 /*
  * LOGIN component
  */
	public function login() {	
	
    /* 
		 * check one more time if the user exists in the session and fallback to index() if NOT
		 * OR if the enetered credentials are good and log him in if YES
		 */	
		if( $this->session->userdata( 'logged_in' ) || self:: _verifylogin() ) { 
		  
	   /*
		  *if the user is in the session OR he entered valid credentials 
	    *then index() is gonna' redirect it wherever it needs ( home.php )
	    */
  		redirect( self::$page_url );
		
		}
    
    /* ELSE  */
    
    //  define the component
    $this->Components_model->init( 'login' );	
          
    //load the FORM helper
    $this->load->helper('form');		
		
    $this->load->view('index.php');		      

	}
	
	

	  /* 
	   * called by self::login() 
	   *
	   * TO DO - add the ability to login with the EMAIL too
	   */
  	private function _verifylogin() {	
 
      /* load the User model */
    	$this->load->model( 'User_model' , '' , false );
    	
    	/* load the credential validation library */
  		$this->load->library( 'form_validation' );
  		
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
        
        /* retriev ethe USER_INFO */          
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
    	 * called by self::verifylogin(); 
    	*/
    	public function _check_db( $password ) {      	
        
        /* cache the inputs */
        $user_name = $this->input->post('user_name');
        
        return User_model::validate_login( array( "user_name" => $user_name , "password" => $password ) );	
      	
    	}
	
	
	
 /*
  * SIGNOUT - Ghost Component
  */
	public function logout() {	
	
    /* 
		 * check if the user doens't exist in the session and fallback to index() if YES
		 */	
		if( !$this->session->userdata( 'logged_in' ) ) { 
		  
		  //if the user is in the session then index() is gonna' redirect it wherever it needs ( home.php )
  		redirect( self::$page_url );
		
		}
    
    /* ElSE */	

		//for some reason the session id is not instantiated
    /* if( session_id() ) session_destroy(); */
		
		$this->session->sess_destroy();

		redirect( self::$page_url );
	
	}
	
	
}	

/* End of file init.php */
/* Location: ./application/controllers/init.php */