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
    

    
    $data['posts'] = null;
    
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
      	
      	if( !$data['posts'] ) {
      	
        	$data['posts'] = $this->fetch_service->fetch();
          
          var_dump( $data['posts'] );      	
          
        }
        
/*     	} */
      	
  	}
  	
  	
  	
  	
  	
      /*
$client = new Connect_model;
    
      $client->debug = true;
  	
      $client->debug_http = true;
    
      $client->server = 'Twitter';

      	$client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/test_oauth_client.php';
    
    	$client->client_id = '';
    	
      $client->client_secret = '';
      
      $client->scope = '';      
      
      $client->access_token = '84832050-vqPtMcEJCMuslYbISI8275LrMQFv4tSz2PwoobwnRasdasnnbhhmfjfguyfk,vj';

      if(($success = $client->Initialize())) {
        
				 if(strlen($client->access_token)) {
  			
  				 $success = $client->CallAPI(  );
  		   
  		   }
        
      }
    
      $success = $client->Finalize($success);
      
      if($client->exit) echo "exit";
      	
      if($success)	{
        
        $client->Output();
        
      } else {
        
        echo HtmlSpecialChars($client->error);
        
      }
*/
      
    
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