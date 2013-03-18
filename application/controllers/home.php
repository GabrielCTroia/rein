<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

 /* 
  The Home.php Controller interacts with the user needs
  
  IT controls the following components:
  
  - feed
  - settings
  
  
  *** to see more about the controllers see _guide_composition.txt {Controllers} ***
  */

require_once( APPPATH . 'core/controllers/User_controller.php' );

class Home extends User_Controller {

  /* 
  * define the page url  
  */
  private static $page_url = "/home";  

	function __construct() {
	
		parent::__construct();
		
		$this->load->model( 'User_model' , '' , TRUE );
		
		$this->load->model( 'Pager_model' , '' , FALSE );
    $this->load->model( 'Components_model' , '' , FALSE );
    
    $this->Pager_model->init( 'home' );
	}

		
  /*
   * the index() acts like a router
   * the user never stays on it so it doesn't have a view
  */
  public function index() {	
      
		  //default redirect to feed
		  redirect( self::$page_url . "/feed" );
	}
	
	

	/* ****************************************************	
  	 Everything below this point is actually a COMPONENT 
	
    **************************************************** */
	
	
	
	
	
 /* 
  * SETTINGS component 
  */
  public function settings() {

    //  define the component
  	$this->Components_model->init( 'settings' );

  	$this->load->model( 'Services_model' , '' , TRUE );
  	
  	
  	//get the active services
  	$data['active_services'] = $this->Services_model->get_active_services();
  	
  	
  	//still need to do a difference between the active and the users active and show them properly
  	// I guess I'll go with a loop - it's fine for now
/*
  	foreach( $active_services as &$service ){
    	
    	$service = $service->s_id;
    	
  	}

    $user_services = explode( "," , $this->userdata[0]->{'GROUP_CONCAT( s_id )'} );	
  	
  	$data['active_services'] = array_diff( $active_services , $user_services );
*/

    $data['success'] = $this->get_url_param( 'success' );
  	
  	$this->load->view( 'index' , $data );
	}
	
	
	public function settings_access() {}
	
	
	public function oauth_wiki() {

    //  define the component
  	$this->Components_model->init( 'oauth_class_wiki' );
  	
  	$this->load->view( 'index' );  	
  	
	}
	
	
  public function feed() { 
    
    // initiate the component
    $this->Components_model->init( 'feed' );	
    
    $this->load->model( 'Posts_model' , '' , false );
    
    //make sure the Posts_model init passes with no errors
    if ( $this->Posts_model->init( $this->session->userdata['u_id'] ) !== false ) {
      
      $specifics = null;
      
      if( $service_name = $this->get_url_param( 'service' ) ){

        $specifics = array( 's.service_name' => $service_name );
          
      }
      
      switch( $this->get_url_param( 'filter' ) ) {
        
        case 'by-service' : $filter = ' ups.FK_s_id, ups.collected_date ';
          break;
          
        case 'by-collected-date' : $filter = 'ups.collected_date';
          break;
          
        default : $filter = 'ups.collected_date';
          break;                    
      }
      
      
      $data['posts'] = $this->Posts_model->get_posts( $specifics , $this->get_url_param( 'limit' , 20 ) , false , $filter );
      
      $data['filter'] = $this->get_url_param( 'filter' );
       
    }
    
    
    
    
    
    //write the error msg
    if( $data['error'] = $this->Posts_model->error ) {
      
      $data['error_msg'] = $this->Posts_model->error_msg;
        
    }
      
    $this->load->view( 'index' , $data );
    
  }
  
  
  public function logout(){
    
    $this->_logout();
    
  }
  
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
