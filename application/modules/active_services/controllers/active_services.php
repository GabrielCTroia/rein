<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( MODULES_PATH . 'Component_Controller.php' );

class Active_services extends Component_Controller {

  //cache the total active services
	private $total_services = array();
	
	//cache the total activated services by the user
	private $active_services = array();
	
	
	function __construct() {
	
		parent::__construct();
		
		$this->load->model( 'Services_model' , '' , true );
		
		$this->load->model( 'Access_model' , '' , true );
    
    $this->Access_model->init( $this->userdata->u_id );

		
		$total_services = $this->Services_model->get_active_services();
		
		$active_services = $this->Access_model->get_users_accesses();
				
		//really don;t like that I have to use to foreachs but it's fine for now
		if( $active_services && $total_services){
		
  		foreach( $active_services as $active ){
        
        $active->active = 'true';
        
        foreach( $total_services as &$total ){
          
          if( $total->s_id == $active->s_id ){
            
            $total = $active;
            
          }
        
        }
        
      }
      
    }
    
    $this->total_services = $total_services;
		
		$this->active_services = $active_services;
		
	}  
	
	
	private function _json_encode( $val ){
  	
  	return json_encode( $val );
  	
	}
	
	/* if by_user = true than return all the active services of the user */
  function widget( $by_user = false ){
    
  	//get the active services
  	$this->data['active_services'] = $this->raw( $by_user );


    $this->data['success'] = $this->get_url_param( 'success' );


    $this->load->view('active_services_default' , $this->data );
    
    
    parent::widget();
  
  }
  
  
  //this return just the datas - no template
  function raw( $by_user = false ){
  
    if( $by_user ){
        
      return $this->active_services;
      
    }
    
    return $this->total_services;
    
  }
  
  
  
  function deactivate(){
      
    if( $this->Access_model->deactivate_service( $this->router->get_arg_value( 'service' ) ) ){
      
      $this->load->model( 'Posts_model' , '' , true );
    
      $this->Posts_model->init( $this->userdata->u_id );
      
      $this->Posts_model->deactivate_posts( $this->router->get_arg_value( 'service' ) );
      
      
    }
    
    //redirect
    
  }  


  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */