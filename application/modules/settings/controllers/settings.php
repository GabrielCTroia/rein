<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends MY_Controller {

	
/*
	function __construct() {
	
		parent::__construct();

	}  
*/


  function widget(){
    
    $this->load_module( 'active_services' , 'widget' );
    
    $this->load->view('default.php' , $this->data );

  }
  
  
/*
  function component(){
      
    
    
    $this->load->view('default.php' , $this->data );
    
  }
*/

  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */