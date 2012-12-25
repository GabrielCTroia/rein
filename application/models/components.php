<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
Class Components extends CI_Model {
  
  private $name;
  private $path = 'components/';
  private $url;
  
  function __construct() {
    parent::__construct();
  }
  
  public function init( $name ) {
    
    //  init can only be called once
    //  it defines the base properties for the component
    
    
    $this->name = $name;
    $safe_name = preg_replace( '/\s/' , '_' , $name );
    $this->path .= $safe_name . '/';
    $this->url = "{$this->path}{$safe_name}";
    return true;
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
  
  
  
}






/* End of file components.php */
/* Location: ./application/models/components.php */