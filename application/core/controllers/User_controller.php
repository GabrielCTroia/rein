<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

 /* 
   This controller extends from the CI controller but provides some User helpful methods like: _logged_in
  */

class User_Controller extends CI_Controller {
  
  
  function __construct() {
	
		parent::__construct();
		
		if( !$this->_check_authentication() ) {
      
  		$this->_logout();
  		
		}

		/* 
		 * load the segments in any page starting from the component 
     * 	
		*/
		$this->url_params = $this->uri->uri_to_assoc(3);
		
		//init the user model and load all of it's content at the very begining

		
  }
    
  /* 
   * check if it's logged in 
   */  
  private function _check_authentication() {
  			
  	/* 
  	 * load the user model 
  	 */		
  	$this->load->model( 'User_model' , '' , false );		
  			
		if( $this->session->userdata( 'logged_in' ) ) {
		  
		  if( $this->User_model->init( $this->session->userdata['u_id'] ) !== false  ){

        if( $this->userdata = $this->User_model->get_user() ) {

          return true;
          
        }
  		
      }		 
		  
		}
		
		return false;
		
	}
	
	
	public function get_url_param( $param , $default = null ){
  	
  	if( isset( $this->url_params[ $param ] ) ) {
      
      if( $param === 'redirect' ){
        
        return str_replace( '-' , '/' , $this->url_params[$param] );
        
      }
      
      return $this->url_params[$param];	
    	
  	}
  	 
    return $default;	
  	
	}
  
  
  
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
  
  
}