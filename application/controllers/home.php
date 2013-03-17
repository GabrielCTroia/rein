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

  	$data['active_services'] = $this->Services_model->get_active_services();
  	
/*
  	foreach( $active_services as &$service ){
    	
    	$service = $service->s_id;
    	
  	}

    $user_services = explode( "," , $this->userdata[0]->{'GROUP_CONCAT( s_id )'} );	
  	
  	$data['active_services'] = array_diff( $active_services , $user_services );
*/
  	
  	$this->load->view( 'index' , $data );
	}
	
	
	public function settings_access() {}
	
	
	public function oauth_wiki() {

    //  define the component
  	$this->Components_model->init( 'oauth_class_wiki' );
  	
  	$this->load->view( 'index' );  	
  	
	}
	
	
  public function feed( $service_name = null , $limit = 20 ) { 

    // initiate the component
    $this->Components_model->init( 'feed' );	
    
    $this->load->model( 'Posts_model' , '' , false );
    
    //make sure the init passes with no errors
    if ( $this->Posts_model->init( $this->session->userdata['u_id'] ) !== false ) {
      
      $specifics = null;
      
      if( !empty( $service_name ) ) {
        
        $specifics = array( 's.service_name' => $service_name );
          
      }
      
      $data['posts'] = $this->Posts_model->get_posts( $specifics , $limit );
       
    }
    
    //write the error msg
    if( $data['error'] = $this->Posts_model->error ) {
      
      $data['error_msg'] = $this->Posts_model->error_msg;
        
    }
      
    $this->load->view( 'index' , $data );
    
  }
  
  
  public function oauth_class_wiki() {
	   
    // initiate the component
    $this->Components_model->init( 'oauth_class_wiki' );	
    
    $this->load->view( 'index' );
  
  }
  
	
 /* 
	* FEED component 
	*/
	public function old_feed() {
	   
  	return;
  	
  	$data[ 'logged_in' ] = 'logged_in';
  	
  	$this->logged_in();
  	
  	$data['posts'] = "";
		
		//load the Posts model
		$this->load->model( 'Posts' , '' , false );
		
		$this->Posts->set_user( $this->session->userdata['logged_in']['user_id'] );
		
		//load the Services model
		$this->load->model( 'Services' , '' , false );
		
		$data[ 'services' ] = $this->Services->get_services();

		//load the Access model
		$this->load->model( 'Access' , '' , false );
		$this->Access->initialize( $this->session->userdata[ 'logged_in' ][ 'user_id' ] );
		
		
		$data[ 'active_services' ] = $this->Access->get_active_accesses();
		
		//check the services against the active_services and write a 
		// status='active' if the same
		//not sure if the best solution
		if( $data['active_services'] ) {	
		
		  foreach ( $data['services'] as $service ) {

				foreach ( $data['active_services'] as $active_service )	{
					
					if ( $active_service->service_id == $service->service_id )
						  $service->status = "active";
					
				}
			}
		}

		//GETTING
				
		//see the posts specifc to the service only
		
		if( isset( $_REQUEST['service'] ) ) {
			
			$service_name = $_REQUEST['service'];
							
			$service_id = $this->Services->get_service_id( $service_name );
							
			$this->Posts->set_service( $service_name , $service_id );
			
			if( isset( $_REQUEST['method'] ) ) {
			
				$method = $_REQUEST['method']; 
				
				switch( $method ) {
					
					case 'GET_LIVE': 
						//see the live posts 
						// can be seen only if the service is true
						//( can only be seen specifcally not all of them at once )
						
						$access = json_decode( $this->Access->get_access( $service_id ) );
						
						//load the Connect model
						$this->load->model( 'Connect', '', false );					
						$this->Connect->initialize( $service_name , $access );
						
						//get the posts
						//format the posts
						$data['posts'] = $this->Posts->format_posts( $this->Connect->get_live_posts() ); 

							

						//store the live posts 
						// can be seen only if the service is true
						//( can only be seen specifcally not all of them at once )
						if( isset( $_REQUEST['store_posts'] ) && $_REQUEST['store_posts'] == 'true' ) {
							
							$this->Posts->set_service( $service_name , $service_id );
															
							//set access_status
							$this->Access->set_access( $service_id , false  , 'active' );
							
							//insert the posts
							
							//get the last inserted post
							$since_id = ( $this->Posts->get_last_post( false , 'post_foreign_id' ) );
							
							if( $since_id ) {
								$since_id = $this->Posts->unformat_foreign_id( $since_id[0]->post_foreign_id ); 
							}
							
							//ge the maximum id to insert
							//not used yet
							$max_id = false;
							
							
							$data['posts'] = Util::reverse( $this->Posts->format_posts( $this->Connect->get_live_posts( array ( 'since_id' => $since_id , 'max_id' => $max_id ) ) ) ); 
							
							
							
							//check if we have posts
							//and spit an error if NOT or if it didn't insert it
							//or redirect otherwise
							if( !$data['posts'] ) {
							
								$data['posts'] = new StdClass();
								
								$data['posts']->error = true;
								$data['posts']->error_msg = "There are no posts in this range to be inserted";	
								
							} elseif( !$this->Posts->insert_posts( $data['posts'] ) ) {		
								$data['posts'] = new StdClass();
								
								$data['posts']->error = true;
								$data['posts']->error_msg = "The posts were not inserted";
							} else {
								redirect ( base_url() );										
							}
						}											
						break;
						
					case 'AUTH' :
						//load the Connect model
						$this->load->model( 'Connect', '', false );
						
						$this->Connect->initialize( $service_name , json_decode( $this->Services->get_service_data( $service_id )->app_config ) );
						
						$this->Connect->auth(); 
					break; 
					
				}// <-- end switch
				
			} else {
			
				//get the posts
				$data['posts'] = $this->Posts->get_posts();
				
			}
		} else {
		
			//get the posts
			$data['posts'] = $this->Posts->get_posts( 1000 );	
			
		}// <-- end if isset( service
		
	   	$this->load->view( 'index' );	
	}
	
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
