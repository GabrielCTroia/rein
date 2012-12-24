<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );


class Home extends CI_Controller {


	function __construct() {
	
		parent::__construct();
		$this->load->model( 'user', '', true) ;
		$page = $data['page'] = new StdClass();
	}
	
	
	private function logged_in() {
  			
		if( !$this->session->userdata( 'logged_in' ) ) {
		  header( 'location: /login' );
		  exit();
		}
	}
	
	
	public function index() {
		
		$this->logged_in();
		
		$session_data = $this->session->userdata( 'logged_in' );
		$data[ 'username' ] = $session_data[ 'username' ];
		$this->load->view( 'home_view', $data );
	}
	
	
	public function feed() {
  	
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
		
		$this->load->view( 'common/header', $data );
		$this->load->view( 'feed', $data );
		$this->load->view( 'common/footer', $data );
	}
	
	
	public function logout() {
	
		$this->session->unset_userdata( 'logged_in' );
		
		header( 'location: /' );
		exit();		
	}
	
}