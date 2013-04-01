<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Active_services extends MY_Controller {

	
	function __construct() {
	
		parent::__construct();
		
		$this->load->model( 'Services_model' , '' , TRUE );
		
	}  

	/* if by_user = true than return all the active services of the user */
  function widget( $by_user = false ){
    
  	//get the active services
  	$this->data['active_services'] = $this->raw( $by_user );
  
  	//still need to do a difference between the active and the users active and show them properly
  	// I guess I'll go with a loop - it's fine for now
/*
  	foreach( $active_services as &$service ){
    	
    	$service = $service->s_id;
    	
  	}

    $user_services = explode( "," , $this->userdata[0]->{'GROUP_CONCAT( s_id )'} );	
  	
  	$data['active_services'] = array_diff( $active_services , $user_services );
*/

    $this->data['success'] = $this->get_url_param( 'success' );
    
    

    $this->load->view('active_services_default' , $this->data );
  
  }
  
  
  //this return just the datas - no template
  function raw( $by_user = false ){
  
    
    if( $by_user ){
      
      $this->load->model( 'Access_model' , '' , TRUE );
      
      $this->Access_model->init( $this->userdata->u_id );
      
      return $this->Access_model->get_users_accesses();
      
    }
    
    
    return $this->Services_model->get_active_services();
    
  }


  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */