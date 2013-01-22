<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'core/controllers/User_controller.php' );

class Authenticate extends User_Controller {

  /* 
  * define the page url  
  */
  private static $page_url = "/authenticate";  
  
	
	function __construct() {
	
		parent::__construct();
		
/* 		$this->load->model( 'User_model' , '' , TRUE ); */
		
/* 		$this->load->model( 'Pager_model' , '' , FALSE ); */
/*     $this->load->model( 'Components_model' , '' , FALSE ); */
    
/*     $this->Pager_model->init( 'home' ); */
    
	}  
  
  
	public function index() {	

  	echo "There is no service chosen. What to authenticate?";

		//to do a routing model
/* 		$data = array(); */
/* 		$component = $data['component'] = new StdClass(); */
		

		
/*
			$component->name = "authenticate";
			$component->path = 'pages/authenticate_view';
*/
					
			//see the posts specifc to the service only
			
		/*
	if ( isset( $_REQUEST['service'] ) )
			{
				
				$service_name = $_REQUEST['service'];
								
			}
*/
/*
			else 
			{	
				//get the posts
				echo "There is no service chosen. What to authenticate?";
			}
			
*/
			
			



			// STORING
			
		
			
		}


		public function service( $service_name = NULL ){
  		// better than having all of these 3 methods below 
  		// we should do th elogic here. check if it doesn't have an access token than do all of this requests
  		
		}
		
		
    /* 
     * sends the headers to the server specific URL to request the temp token   
     */
		public function request_temp_token( $service_name = NULL ){
  		
      $this->load->model( 'Services_model' , '' , false );      	
      
      if( !$service_name || !$this->Services_model->get_service_by( 'name' , $service_name , false ) ) {
    	
        echo "There is no service chosen. What to authenticate?";
    	
    	} else { 
      	
      	
        $this->load->model( "services/$service_name/Auth_$service_name" , 'auth_service' , false );
        
        $this->auth_service->request_temp_token();

    	}
    	
  		
		}
    
    /* 
     * sends the headers to the server specific URL to request the temp token   
     */
		public function callback( $service_name = NULL ){
  		
  		/* load the callback model */
  		
		}  
        
    /* 
     * sends the headers to the server specific URL to request the access token   
     */
		public function request_access_token( $service_name = NULL ){
  		
  		echo "request access_token";
  		
		}
		
		


	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */