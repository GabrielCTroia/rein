<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

 /* 
   This controller extends from the CI controller but provides some User helpful methods like: _logged_in
  */

require_once( APPPATH . 'core/controllers/Main_controller.php' );

class User_Controller extends Main_Controller {
  
  
  /*
   * all the info of the user
   * it's gettingpopulated from the DB once authenticated
   */
  public $userdata = null;
  

  function __construct() {
	
		parent::__construct();
		
		if( !$this->_check_authentication() ) {
      
  		$this->_logout();
  		
		}
		
		$this->logged_in = true;
		
		//init the user model and load all of it's content at the very begining

		
  }
    	
  
  /* $METHODS */
  
    protected function _logout(){
      
      /* 
  		 * check if the user doens't exist in the session and fallback to index() if YES
  		 */	
  		if( !$this->session->userdata( 'logged_in' ) ) { 
  		  
  		  //if the user is in the session then index() is gonna' redirect it wherever it needs ( home.php )
    		redirect( '/' );
  		
  		}
      
      /* ElSE */	
  
  		//for some reason the session id is not instantiated
      /* if( session_id() ) session_destroy(); */
  		
  		$this->session->sess_destroy();
  
  		redirect( '/' );
      
    }
    
  
  public function logout(){
    
    $this->_logout();
    
  }    
  
}