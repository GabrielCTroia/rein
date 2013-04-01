<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( MODULES_PATH . 'Component_Controller.php' );

class Settings extends Component_Controller {
  
  
  function component(){
  
    switch( $this->get_url_param('tab') ){
      
      case 'profile' : $this->_profile();
        break;
      
      case 'connect' : $this->_connect();
        break;  
        
      default : redirect( $this->get_new_url( 'tab' , 'profile' ) );
        break;  
      
    }
   
    $this->load->view('settings_default.php' , $this->data );
    
  }
  

    function _profile(){
      
      $this->load_module( 'profile' , 'widget' ); 
      
      $this->data['tab'] = 'profile';
      
    }
  
    function _connect(){
     
      $this->load_module( 'active_services' , 'widget' ); 
      
      $this->data['tab'] = 'connect';
      
    }
  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */