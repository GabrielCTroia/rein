<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( MODULES_PATH . 'Component_Controller.php' );

class Settings extends Component_Controller {
  
  public $default_url = null;
  
  
  function component(){
    
    $this->default_url = $this->router->new_method( 'show' );
	  	
		if( !$this->router->curr_method ){
  		
  		redirect( $this->default_url );
  		
		}
    
    parent::component();
    
  }
  
  
  public function show(){
    
    
    if( method_exists( $this , $this->router->get_arg_value('tab') ) ){
      
      $tab = $this->router->get_arg_value('tab');
      
      $this->$tab();
      
      $this->data['tab'] = $tab;
      
    } else {
      
      redirect( $this->router->switch_args( array( 'tab' => 'connect') ) );
      
    }
    
    $this->load->view('settings_default.php' , $this->data );
    
  }

    
    /* Tabs views */
    
    function profile(){
      
      $this->load_module( 'profile' , 'widget' ); 
      
    }
  
    function connect(){
     
      $this->load_module( 'active_services' , 'widget' ); 
      
    }
  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */