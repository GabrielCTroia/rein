<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'core/controllers/User_controller.php' );

class Auth extends User_Controller {

  /* 
  * define the page url  
  */
  private static $page_url = "/auth";  
  
	
	function __construct( $service_name = null ) {
	
		parent::__construct();
		
		$this->load->library('session');
	}  
  
  
	public function index() {	
	
  	echo "There is no service chosen. What to authenticate?";
  }


	public function service( $service_name = NULL ){
	
		// better than having all of these 3 methods below 
		// we should do the logic here. check if it doesn't have an access token than do all of these requests
	}
		
		
  /* 
   * sends the headers to the server specific URL to request the temp token   
   */
	public function request_temp_token( $service_name = NULL ) {
		
    $this->load->model( 'Services_model' );      	
  
    if( !$service_name || !$this->Services_model->get_service_by( 'name' , $service_name , false ) ) {
      
      echo "there is no service name or this service is not in our database";
/*       redirect( self::$page_url ); */
  	
  	} else {       
      
      $this->load->model( "services/$service_name/Auth_$service_name" , 'auth_service' , false );

      $this->auth_service->request_temp_token();

  	}
	}
    
  /* 
   * sends the headers to the server specific URL to request the temp token   
   */
	public function callback( $service_name = NULL ){
		
		if( empty( $service_name ) ) {
  		echo "There is no service chosen. What to authenticate?";
/*   		redirect( self::$page_url ); */
		}  		
  		
		
		$this->load->model( 'Services_model' , '' , TRUE );
    
    $service_id = $this->Services_model->get_service_by( 'name' , $service_name , 's_id' );//->s_id;
    $service_id = $service_id->s_id;
    
    
    $this->load->model( "services/$service_name/Auth_$service_name" , 'auth_service' );
    
    //check if there is an acces token returned
    if ( !empty( $_GET ) && $api_return = $this->auth_service->api_return( $_GET ) ) {
      
      

      //check if tehre are any errors and show them if TRUE
      
      //I guess this is only for twitter - need to abstract it for each of them
/*
      if( $return[ 'status_code' ] != 200 ) {
        echo 'Status Code: ' . $return[ 'status_code' ] . '<br>';
        echo 'Status Message: ' . $return[ 'status_message' ];
        return; 
      }
*/
      
      // echo '<pre>' . print_r( $return , 1 ) . '</pre>';

      /* load the access model */
      $this->load->model( 'Access_model' , '' , true );
                        
      /* store the access token */
      /* the user id should come out from the session */
      if( $this->Access_model->init( $this->session->userdata['u_id'] , $service_id ) === false ){
        
        echo $this->Access_model->error_msg;
        
      } else {
        
        if( $this->Access_model->set_access( $api_return ) === false ){
          
          echo $this->Access_model->error_msg;
          
        } else {
          
          redirect( '/fetch/service/' . $service_name . '/20/show' );          
/*           redirect( '/home/settings?service=' . $service_name . '&status_code=200' ); */
          
        }
            
      }
    
    } else {
      
      echo "We do not authorize manually input urls!";
      
    }
		
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