<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /* 
  The Fetch.php Controller pulls 
  
  It controls the following components:
  
  
  *** to see more about the controllers see _guide_composition.txt {Controllers} ***
  */

class Fetch extends CI_Controller {

 /* 
  * define the page url  
  */
  private static $page_url = "/connect"; 

  function __construct() {
	
	 parent::__construct();
		

    $this->load->model( 'User_model' , '' , TRUE );
		
		$this->load->model( 'Pager_model' , '' , FALSE );
		$this->load->model( 'Components_model' , '' , FALSE );

		$this->Pager_model->init( 'fetch' );		
		
	}

	public function index(){}	
 
 /*
  * LIVE - {Ghost} Component
  * get the live posts based on the service name  
  * it only works for the authenticated user (not CRON)
  * it doesn't use the GET method to get the 
  */
	public function live( $service_name = NULL ){
    
    $data['posts'] = NULL;
    
  	$this->Components_model->init( 'feed' );
    
    //load the services model
  	$this->load->model( 'Services_model' , '' , false );      	
      	
    
  	//do a db check before if the service exists and redirect if it doesn't or return a error mesage
  	// . 
  	// .
  	if( !$service_name || !$this->Services_model->get_service_by( 'name' , $service_name , false ) ) {
    	
    	//no posts to show
    	
  	} else {
  	   
      //load the fetch model specific to the service
    	$this->load->model( "services/$service_name/Fetch_$service_name" , 'fetch_service' , false );
    	
    	//init the fetch_service model
    	$this->fetch_service->init();
    	
    	//fetch the datas and cache them in a var
/*     	if ( !$data['error_msg'] = $this->fetch_service->fetch()->error ) { */
      	
      	if( $data['posts'] ) {
      	
        	$data['posts'] = $this->fetch_service->fetch();
          
/*           var_dump( $data['posts'] );    */   	
          
        }
        
/*     	} */
      	
  	}
      
    
    $this->load->view( 'index' , $data );

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

/* End of file fetch.php */
/* Location: ./application/controllers/fetch.php */