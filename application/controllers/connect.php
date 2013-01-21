<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /* 
  The Connect.php Controller pulls 
  
  It controls the following components:
  
  
  *** to see more about the controllers see _guide_composition.txt {Controllers} ***
  */

class Connect extends CI_Controller {

 /* 
  * define the page url  
  */
  private static $page_url = "/connect"; 

  function __construct() {
	
	 parent::__construct();
		
    $this->load->model( 'User' , '' , TRUE );
		
		$this->load->model( 'Pager' , '' , FALSE );
		$this->load->model( 'Components' , '' , FALSE );

		$this->Pager->init( 'connect' );		
		
	}

	public function index(){}	
 
 /*
  * LIVE - {Ghost} Component
  * get the live posts based on the service name  
  */
	public function service( $service_name = NULL , $filters ){
  

	}
	
	
	/* 
	 * DEBUG - Component 
	 */
	 
	 public function debug( $service_name = NULL  ){
  	 
    /*this link should look like:
      
      /connect/debug/twitter/?auth_code=ASDAD&auth_sercetre=ASDA&filters=asdadasda
      
    */
    
	 }
	


}

/* End of file signup.php */
/* Location: ./application/controllers/connect.php */