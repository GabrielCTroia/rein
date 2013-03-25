<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class _RENAME extends MY_Controller {

	
/*
	function __construct() {
	
		parent::__construct();

	}  
*/


  function widget(){
    
    $this->load->view('default.php' , $this->data );
  }


  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */