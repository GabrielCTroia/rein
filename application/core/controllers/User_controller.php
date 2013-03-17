<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

 /* 
   This controller extends from the CI controller but provides some User helpful methods like: _logged_in
  */

class User_Controller extends CI_Controller {
  
  
  function __construct() {
	
		parent::__construct();
		
		$this->_check_authentication();
		
		$this->load->model( 'User_model' , '' , false );
		
		
		
		
		//init the user model and load all of it's content at the very begining
		if( $this->User_model->init( $this->session->userdata['u_id'] ) !== false  ){

      $this->userdata = $this->User_model->get_user();
  		
		}		
		
  }
    
    /* 
     * check if it's logged in 
     */  
    private function _check_authentication() {
    			
  		if( !$this->session->userdata( 'logged_in' ) ) {
  		  
  		  redirect( '/log-in' );
  		  
  		}
  		
  	}
  
  
}