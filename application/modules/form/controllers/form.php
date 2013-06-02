<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Form extends MY_Controller {

	
	function __construct() {
	
		parent::__construct();



	}  


  function widget(){
    
    
$this->load->helper(array('form', 'url'));

/* 		$this->load->library('form_validation'); */
		
		      $this->form_validation->set_rules(
      
        array(
  	       array(
  	              'field' => 'l_email',
  	              'label' => 'Email',
  	              'rules' => 'trim|required|xss_clean'
  	        ),
  	        
  	        array(
  	              'field' => 'l_password',
  	              'label' => 'Password',
  	              'rules' => 'trim|required|xss_clean|md5|callback__check_db'
  	        )
  	     )     
  	        
  	   );    
		
/*
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
    $this->form_validation->set_rules('passconf', 'Password Confirmation', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
*/
		  
  		if ($this->_validate_form() == FALSE)
  		{
  			
  			
/*   			echo validation_errors(); */
/*   			$this->load->view('form'); */
  		}
  		else
  		{
  			echo "a mers valid";
  			exit();
  		}
    
    
    $this->load->view('default.php' , $this->data );
  }



  
    function _validate_form(){
      
/*       echo $this->form_validation->run(); */
      
      if( $this->form_validation->run() ){
        
        /* cache the inputs */  
        $email     = $this->input->post('l-email');
        $password  = $this->input->post('l-password');  
        
        /* retrieve the USER_INFO */          
  		  if( $user_info = User_model::validate_login( array( "email" => $email , "password" => $password ) , true ) ) {
    		  
    		  $this->session->set_userdata( array_merge( array( 'logged_in' => true ) , $user_info ) );
    			
    			return true;
 
  		  }
        
      }
      
      return false;
      
    }
    
    
        	/* 
    	 * called by $this->verifylogin(); 
    	*/
    	public function _check_db( $password ) {      	
        
        
        var_dump("Asd");
        exit;
        /* cache the inputs */
        $email = $this->input->post('l-email');
        
        return User_model::validate_login( array( "email" => $email , "password" => $password ) );	
      	
    	}


  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */