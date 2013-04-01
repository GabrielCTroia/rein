<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Loader class */
require APPPATH."third_party/MX/Controller.php";


class MY_Controller extends MX_Controller {
  
    /* cache the log state */
  public $logged_in = false;
  
  
  //this is the data that needs to be passed to the views
  protected $data = array();
  
  
  //cache all the loaded modules
  protected $modules = array();
  
  //cache the URL segments as array and pass them to the View for when it's needed 
  protected $segments = array();
  
  
  public function __construct(){
    
    parent::__construct();

    //set the logged in state here and for ever
    if( $this->_check_authentication() ) {
      
  		$this->logged_in = true;
  		
		} else {
  		
  		$this->logged_in = false;
  		
		}
        
    /* 
		 * load the segments in any page starting from the component 
     * 	
		*/
		$this->data['segments'] = $this->url_params = $this->uri->uri_to_assoc(1);
    
    
    $this->data['modules'] =& $this->modules;
    
  }
  
  	
  /* 
   * check if it's logged in 
   */  
  protected function _check_authentication() {
  			
/*   	 var_dump($this->session->userdata( 'logged_in' )); */
  	
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
	
	
	
	/* 
	 * This function loads and assigns the module to the global $this->data['module'] var using HMVC method
	 * @param - module name
	 * @method - the method used to load the module
	 * @params
	 * return - if true it return the datas here
	 */ 
	protected function load_module( $module , $method = null , $params = array() , $return = false ){
  	
  	if( !$module ){
    	
      return;
      	
  	}
  	
  	if( $method ) {
    	
    	$method = '/' . $method;
    	
  	}
  	
  	$this->modules[ $module ] = Modules::run( $module . $method , $params );
  	
  	if( $return ) 
  	 return $this->modules[ $module ];
  	
	}
	
	
  
  /* this needs to be written somewhere else - UTIL or something 
   * 
   * return the the desired datatype
   * @type - var you wish to turn it into
   * @var - the var you wish to convert
  */
  protected function force_datatype( $type_var , $var ){
    
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
	 * returns the same url structure(same params) with different values 
	 */
	function get_new_url( $param , $new_val , $segments = array() ){
    
    if( empty( $segments ) ) {
      
      $segments = $this->url_params;
      
    }
       
    $segments[$param] = $new_val;   
       
    return '/' . $this->uri->assoc_to_uri( $segments ); 
      
  }
  	
  /*
   * this returns the correct url
   * I feel like it should be in UTIL_model
  */
	public function get_url_param( $param , $default = null ){
  	  	 	
  	if( !empty( $this->url_params[ $param ] ) ) {
    	
      if( $param === 'redirect' ){
        
        return str_replace( '-' , '/' , $this->url_params[ $param ] );
        
      }
  
      return $this->force_datatype( $default , $this->url_params[ $param ] );	
    	
  	}
  	 
    return $default;	
  	
	}
	

}