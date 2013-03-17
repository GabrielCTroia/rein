<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 /* 
  The Fetch.php Controller pulls 
  
  It controls the following components:
  
  
  *** to see more about the controllers see _guide_composition.txt {Controllers} ***
  */

require_once( APPPATH . 'core/controllers/User_controller.php' );

class Fetch extends User_Controller {

 /* 
  * define the page url  
  */
  private static $page_url = "/fetch"; 

  function __construct() {
	
	 parent::__construct();
		
		
		//set the url parmas on 2 
		$this->url_params = $this->uri->uri_to_assoc(2);

    $this->load->model( 'User_model' , '' , TRUE );
		
		$this->load->model( 'Pager_model' , '' , FALSE );
		$this->load->model( 'Components_model' , '' , FALSE );

		$this->Pager_model->init( 'fetch' );
		
	}
	
  /*
   * the index() acts like a router
   * the user never stays on it so it doesn't have a view
  */
	public function index(){
  	
  	redirect ( 'home' );
  	
	}	
 
 /*
  * get the live posts based on the service name  
  * it only works for the authenticated user (not CRON)
  * it doesn't use the GET method to get the 
  */
	public function service(){
    
    //load the services model
    $this->load->model( 'Services_model' , '' , false );       
              	
    $service_name = $this->get_url_param( 'service' );

  	//do a db check before if the service exists and redirect if it doesn't or return an error mesage
  	if( !$service_name || !$service_id = $this->Services_model->get_service_by( 'name' , $service_name , 's_id' ) ) {
    	
    	$data['error_msg'] = "No posts to show for " . $service_name;
          	
  	} else {   

      $service_id = $service_id->s_id;
  	 
      //load the fetch model specific to the service
    	$this->load->model( "services/$service_name/Fetch_$service_name" , 'fetch_service' , false );
    	
    	/* load the access model */
      $this->load->model( 'Access_model' );
    	
    	if( !$access = $this->Access_model->get_access( $this->session->userdata['u_id'] , $service_id ) ) {
    	
        $data['error_msg'] = "No access token in our Database for " . $service_name;
    	
    	} else {
      	
        //init the fetch_service model
        if( $this->fetch_service->init( $this->session->userdata['u_id'] , $access ) === false ) {	
        
          $data['error_msg'] = $this->fetch_service->error_msg;
        
        } else {
        
          //if there is an error than show it 
        	if ( !$fetched_data = $this->fetch_service->fetch( $this->get_url_param( 'limit' ) ) ) {
        	   
          	$data['error_msg'] = $this->fetch_service->error_msg;
    
        	} else {
          	
          	/*FORMAT & INSERT the FETCHED datas*/
          	
            /* load the format class */
/*             $this->load->model( "services/$service_name/Format_$service_name" , 'format_service' , false ); */
            
            //if to show 
                        
            if( $this->get_url_param( 'show' ) == 'true' ){            
              
              $this->Components_model->init( 'feed' );
              
              $data['posts'] = $fetched_data;
              
              foreach( $data['posts'] as &$post ){
                
                $post['service_name'] = $service_name;
                  
              }  
              
              $this->load->view( 'index' , $data );
              
              return;
              
            } else {
              
              //insert
              $this->load->model( "services/$service_name/Posts_$service_name" , 'posts_service' , false );
              
              if( $this->posts_service->init( $this->session->userdata['u_id'] , $service_id ) === false ){
                
                $data['error_msg'] = $this->posts_service->error_msg;
                
              } else {
                
                if( !$this->posts_service->insert( $fetched_data) ){
                  
                  $data['error_msg'] = $this->posts_service->error_msg;
                  
                }
                
              }
              
            }
            	
        	}
        	
        }
      	
    	}
      	
  	}
      
    if( isset( $data['error_msg'] ) ) {
  	
    	echo $data['error_msg'];
    	
  	} else {
    	
    	redirect( $this->get_url_param( 'redirect', '/' ) );

  	}      

	}
	
	
	
	
 /*
  * STEALTH - Ghost Component
  */
	public function stealth( $service_name = NULL ){
  	
    $this->_insert( $data );
  	
	}
	 
	 /* 
	  * INSERT all the fetched datas into the db 
	  */
	 private function _insert( $data , $service_name ){
  	 
/*   	 $data['posts'] = $this->format_service->format_posts( $data ); */
  	 
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