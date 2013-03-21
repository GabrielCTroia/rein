<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

 /* 
   This controller extends from the CI controller but provides some User helpful methods like: _logged_in
  */

class Main_Controller extends CI_Controller {
  
  /* cache the log state */
  public $logged_in = false;
  
  
  
  protected $current_controller = false;
  
  public function __construct(){
    
    parent::__construct();
    
  }	
  	
  	
  /* 
   * check if it's logged in 
   */  
  protected function _check_authentication() {
  			
  	/* 
  	 * load the user model 
  	 */		
  	$this->load->model( 'User_model' , '' , false );		
    
    //check if the logged_in var is true in the session			
		if( $this->session->userdata( 'logged_in' ) ) {
		  
		  if( $this->User_model->init( $this->session->userdata['u_id'] ) !== false  ){
  		  
  		  //check if the id exists in the DB and assign all the info to the $this->userdata var 
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
  
}