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
  private static $page_url = "/fetch"; 

  function __construct() {
	
	 parent::__construct();
		

    $this->load->model( 'User_model' , '' , TRUE );
		
		$this->load->model( 'Pager_model' , '' , FALSE );
		$this->load->model( 'Components_model' , '' , FALSE );

		$this->Pager_model->init( 'fetch' );		
		
	}

	public function index(){
  	
  	redirect ( 'home' );
  	
	}	
 
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
  	
  	$service_id = $this->Services_model->get_service_by( 'name' , $service_name , 's_id' );//->s_id;
    $service_id = $service_id[0]->s_id;   	
      	
  	//do a db check before if the service exists and redirect if it doesn't or return an error mesage
  	if( !$service_name || !$this->Services_model->get_service_by( 'name' , $service_name , false ) ) {
    	
    	//no posts to show
    	$data['error_msg'] = "No posts to show for " . $service_name;
    	
  	} else {
  	 
      //load the fetch model specific to the service
    	$this->load->model( "services/$service_name/Fetch_$service_name" , 'fetch_service' , false );
    	
    	/* load the access model */
      $this->load->model( 'Access_model' );
    	
    	if( $access_tokens = $this->Access_model->get_access_token( $this->session->userdata['logged_in']['u_id'] , $service_id ) ) {
      	
        //init the fetch_service model
        if( $this->fetch_service->init( $access_tokens ) !== false ) {	
        
          //if there is an error than show it 
        	if ( !$this->fetch_service->fetch() || isset( $this->fetch_service->error ) ) {
        	   
          	$data['error_msg'] = $this->fetch_service->error;
    
        	} else {
          	
          	/*FORMAT & INSERT the FETCHED datas*/
          	
            /* load the format class */
            $this->load->model( "services/$service_name/Format_$service_name" , 'format_service' , false );
            
            $data['posts'] = $this->format_service->format_posts( $this->fetch_service->fetch() );
          	
        	}
        	
        } else {
          
          $data['error_msg'] = $this->fetch_service->error;
          
        }
      	
    	} else {
      	
        $data['error_msg'] = "No access token in our Database for " . $service_name;	
      	
    	}
    	
      	
  	}
    
    $this->load->view( 'index' , $data );

	}
	
	
	
	
	
	public function stealth( $service_name = NULL ){
  	
  	
  	
  	
	}
	 
	 /* 
	  * FORMAT & INSERT all the fetched datas into the db 
	  */
	 private function _insert( $data , $service_name ){
  	 
/*   	 $this->load->model(  ) */
  	 
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