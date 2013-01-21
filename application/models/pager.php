<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	
Class Pager extends CI_Model {
  
  private $name;
  private $path = 'pages/';
  private $url;
  
  function __construct() {
    parent::__construct();
  }
  
  public function init( $name ) {
    
    //  init can only be called once
    //  it defines the base properties for the component
    //  **not working now**
    
    /*
if( !empty( $name ) )
      return false;
*/
    
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






/* End of file pager.php */
/* Location: ./application/models/pager.php */