<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Login extends MY_Controller {

	function __construct() {
	
		parent::__construct();

    $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		
		
		
		/* I DO ALL THE VALIDATION HERE - NOT SURE IF THE BEST */
		
		/* 
		 * check one more time if the user exists in the session and fallback to index() if NOT
		 * OR if the entered credentials are good and log him in if YES
		 */	
		if( $this->logged_in || self:: _verifylogin() ) { 
		  
	   /*
		  *if the user is in the session OR he entered valid credentials 
	    *then index() is gonna' redirect it wherever it needs ( home.php )
	    */
	    
  		redirect( "home" );
		
		} else if( $this->input->post() ) {
  		
  		$post = $this->input->post();
  		
  		redirect( $post['url'] . "/message/fail" );
  		
		}
		
		
	}  
  
    
  public function widget(){
    
    $this->load->view('default.php');
    
  }	


	  /* 
	   * 
	   *
	   * TO DO - add the ability to login with the EMAIL too
	   */
  	private function _verifylogin() {	
 
      /* load the User model */
    	$this->load->model( 'User_model' , '' , false );
  		
  		/* set the rules */
      $this->form_validation->set_rules(
      
        array(
  	       array(
  	              'field' => 'l-username_email',
  	              'label' => 'User Name',
  	              'rules' => 'trim|required|xss_clean'
  	        ),
  	        
  	        array(
  	              'field' => 'l-password',
  	              'label' => 'Password',
  	              'rules' => 'trim|required|xss_clean|callback__check_db'
  	        )
  	     )     
  	        
  	   );       

  	   
  		if( $this->form_validation->run() ){
        
        /* cache the inputs */  
        $user_name = $this->input->post('l-username_email');
        $password  = $this->input->post('l-password');  
        
        /* retrieve the USER_INFO */          
  		  if( !$user_info = User_model::validate_login( array( "user_name" => $user_name , "password" => $password ) , true ) ) {
    		  
    		  //show error
    		  
  		  } else {
    		  
      		/* and store in the SESSION */                      					
    			$this->session->set_userdata( array_merge( array( 'logged_in' => true ) , $user_info ) );
    			
    			return true;
    		  
  		  }
        	
  		} 
  		
  		
/*   		var_dump($this->input->post()['url']); */
  		/* if it got got far means it's not valid */
  		return false;
		  
  	}
	
    	/* 
    	 * called by $this->verifylogin(); 
    	*/
    	public function _check_db( $password ) {      	
        
        /* cache the inputs */
        $user_name = $this->input->post('l-username_email');
        
        return User_model::validate_login( array( "user_name" => $user_name , "password" => $password ) );	
      	
    	}
  
  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */