<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Callback extends CI_Controller {

  /* 
  * define the page url  
  */
  private static $page_url = "/callback";  


	function __construct() {
	
		parent::__construct();
		
/*     $this->_logged_in(); */
		
/*     $this->load->model( 'User' , '' , TRUE ); */
		
/* 		$this->load->model( 'Pager' , '' , FALSE ); */
/* 		$this->load->model( 'Components' , '' , FALSE ); */

/* 		$this->Pager->init( 'callback' );		 */
		
	}

	public function index(){
		
  	
	}	
	
	
 /*
  * SERVICE - Ghost Component
  */
	public function service( $service_name = NULL ){
  	
  	//get the access tokens and store them in the database based in each service
  	
  	// can have a switch ( not respecting the OpenClose principle - for each new service we have to come in and add a new case )
  	// OR we cn call subclasses based on the service name.
  	
  	if( $service_name ) echo $service_name;

	}


	
}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */