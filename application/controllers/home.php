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
  
    $this->init_component( 'feed' );
    
/*     $this->feed->show();     */
    
/*     var_dump($this); */
/*     var_dump( $this->Components_model->get_components() ); */

    
/*     $this->load->view( 'index' ); */
    
    return;
    
    // initiate the component
    $this->Components_model->init( 'feed' );	
    
    $this->load->model( 'Posts_model' , '' , false );
    
    //make sure the Posts_model init passes with no errors
    if ( $this->Posts_model->init( $this->userdata->u_id ) !== false ) {
      
      $specifics = array();
      
      if( $service_name = $this->get_url_param( 'service' ) ){

        $specifics[] = 's.service_name = ' . $service_name;
          
      }
      
      $total_posts = $this->Posts_model->get_total_posts();
      
      $limit = $this->get_url_param( 'limit' , 20 );
      
            
      $posts = array();
      
      switch( $this->get_url_param( 'filter' , '' ) ) {
        
        case 'by-service' : 
          
          $order_by = ' ups.FK_s_id , p.favorited_date ';
                          
          $posts_query = array( 'order_by' => $order_by );
                            
        break;
          
        default : 
          
          $order_by = 'p.favorited_date';
              
          $data['pages'] = $pages = ceil( $total_posts / $limit );
      
          $data['current_page'] = $current_page  = $this->get_url_param( 'page' , 1 );
          
          
          $start = ( $current_page - 1 ) * $limit;
          
          if( ( $current_page - 1 ) > count( $pages ) ) {
            
            $data['error'] = true;
            
            $data['error_msg'] = "The page doesn't exist";
            
          }
          
          
          
          //make sure there's no negative page
          if( $start < 0 ) redirect( Util::get_new_url( $this->url_params , 'page' , 1 ) );
          
          $posts_query = array( 'where' => $specifics , 'limit' =>  $start . ' , ' . $limit , 'order_by' => $order_by );
                  
        break;                    
        
      }
      
      $data['posts']  = $this->Posts_model->get_posts( $posts_query );
      
      $data['filter'] = $this->get_url_param( 'filter' );
       
    }
    
    //write the error msg
    if( $data['error'] = $this->Posts_model->error ) {
      
      $data['error_msg'] = $this->Posts_model->error_msg;
        
    }
      
    $this->load->view( 'index' , $data );
    
  }
  
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
