<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

 /* 
   This controller extends from the CI controller but provides some User helpful methods like: _logged_in
  */

class Main_Controller extends CI_Controller {
  
  /* cache the log state */
  public $logged_in = false;
  
  
  
  protected $current_controller = false;
  
  
  public $components = array();
  
  
  
  public function __construct(){
    
    parent::__construct();
    
    /* 
		 * load the segments in any page starting from the component 
     * 	
		*/
		$this->url_params = $this->uri->uri_to_assoc(1);
    
  }
  
  
  public function init_component( $component ) {
  	
  	$path = APPPATH . 'components/';
  	
  	$this->load->add_package_path( $path . $component . '/' );
  	
  	$this->load->library( 'feed' );
  	
  	$this->feed->show();
  	
	}	
	
	public function show_component( $component ) {
  	
  	
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
  
  /* this needs to be written somewhere else - UTIL or something 
   * 
   * return the the desired datatype
   * @type - var you wish to turn it into
   * @var - the var you wish to convert
  */
  private function force_datatype( $type_var , $var ){
    
    switch( gettype( $type_var ) ){
      
      case 'integer' : return (int)$var;
        break;
        
      case 'boolean' : return (boolean)$var;
        break;  
      
      case 'string' : return (string)$var;
        break;
        
      default : return $var;
        break;  
      
    }
    
  }
  	
  /*
   * this returns the correct url
   * I feel like it should be in UTIL_model
  */
	public function get_url_param( $param , $default = null ){
  	  	 	
  	if( isset( $this->url_params[ $param ] ) ) {
    	
      if( $param === 'redirect' ){
        
        return str_replace( '-' , '/' , $this->url_params[$param] );
        
      }
      
      if( $this->url_params[$param]  ){
        
        return $this->force_datatype( $default , $this->url_params[$param] );	
        
      }
               
      return $default;
    	
  	}
  	 
    return $default;	
  	
	}
	
	

  
  
  
}