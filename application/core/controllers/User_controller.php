<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

 /* 
   This controller extends from the CI controller but provides some User helpful methods like: _logged_in
  */

class User_Controller extends CI_Controller {
  
  function __construct() {
	
		parent::__construct();
		
		$this->_logged_in();

  }
    
    /* 
     * check if it's logged in 
     */  
    private function _logged_in() {
    			
  		if( !$this->session->userdata( 'logged_in' ) ) {
  		  header( 'location: /log-in' );
  		  exit();
  		}
  		
  	}
  
}