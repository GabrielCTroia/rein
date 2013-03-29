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
  private $page_url = "/home";  

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
		  redirect( $this->page_url . "/feed" );
	}
	
	

	/* ****************************************************	
  	 Everything below this point is actually a COMPONENT 
	
    **************************************************** */
	
	
 /* 
  * SETTINGS component 
  */
  public function settings() {
    
    $this->load_module( 'settings' , 'widget' );
    
    $this->load->view( 'index.php' , $this->data );
  
    return;
    
    
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
	
	
	
	
  public function feed() { 
  
    $this->load_module( 'feed' , 'widget' );
    
    $this->load->view( 'index.php' , $this->data );
  
  }
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
