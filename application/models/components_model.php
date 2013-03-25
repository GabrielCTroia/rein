<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
Class Components_model extends CI_Model {
  
  private $name;
  private $path = 'components/';
  private $url;
  

  
  function __construct() {
    parent::__construct();
    
/*     $CI =& get_instance(); */
/*     $CI->load = $this; */

  }
  
  public function init( $name ){
    
    
    $this->name = $name;
    $safe_name = preg_replace( '/\s/' , '_' , $name );
    $this->path .= $safe_name . '/';
    $this->url = "{$this->path}{$safe_name}";
    return true;
    
  }
  
  
  
  public function init2( $name ) {
    
    //  init can only be called once
    //  it defines the base properties for the component
    
    $name = $this->safe_name( $name );
    
/*     $component =  = new stdClass(); */
    
    $path = COMPONENTS_PATH . $name . '/';
    
    require_once( $path . '/' . $name . '_controller.php');
    
/*     $this->load->file( $path . '/' . $name . '_controller.php' ); */

    $controller = ucfirst( $name ) . '_controller';

		$CI =& get_instance();
		
		$CI->$name = new $controller();
		
		
/* 		var_dump( $this->components[ $name ] ); */
		/*
if ($name == '')
		{
			$name = $model;
		}
*/
		
/* 		$CI->$name = new $model(); */

/* 		$this->_ci_modules[] = $module; */
    
    
    return true;
    
  }
  
  
  public function show( $name ){
    
    $name = $this->safe_name( $name );
    
    $this->$name->show();
    
  }
  
  
  public function get_components( $name = null ){
    
    if(!empty( $this->components ) ){
      
      if( $name = $this->safe_name( $name) ){
        
        return $this->components[ $name ];
        
      }
      
      return $this->components;
      
    }

    return "no initialized component";
    
  }

  
  public function name() {
    return $this->name;
  }
  
  public function path() {
    return $this->path;
  }
  
  public function url() {
    return $this->url;
  }
  
  
  
  private function safe_name( $name ){
    
    return preg_replace( '/\s/' , '_' , $name );
    
  }
  
  
}






/* End of file components.php */
/* Location: ./application/models/components.php */