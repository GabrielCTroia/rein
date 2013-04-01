<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Component_Controller extends MY_Controller {
  
  protected $component_url_params = null;
  
  function __construct(){
    
    parent::__construct();
    
    
    //no segmnets for the compoennt yet - not working properly -- need to create  router class to manage all the links
/*     $this->data['segments'] = $this->component_url_params = $this->uri->uri_to_assoc(3); */

  }
  
  
  /* 
	 * returns the same url structure(same params) with different values 
	 */
	function get_new_component_url( $param , $new_val , $segments = array() ){
    
    if( empty( $segments ) ) {
      
      $segments = $this->component_url_params;
      
    }
       
    $segments[$param] = $new_val;   
       
    return '/' . $this->uri->assoc_to_uri( $segments ); 
      
  }
  	
  /*
   * this returns the correct url
   * I feel like it should be in UTIL_model
  */
	public function get_component_url_param( $param , $default = null ){
  	  	 	
  	if( isset( $this->component_url_params[ $param ] ) ) {
    	
      if( $param === 'redirect' ){
        
        return str_replace( '-' , '/' , $this->component_url_params[ $param ] );
        
      }
      
      return $this->force_datatype( $default , $this->component_url_params[ $param ] );	
    	
  	}
  	 
    return $default;	
  	
	}
  
  
}