<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends Component_Controller {

  
  function __construct() {
	
		parent::__construct();

    $this->load->library('form_validation');
		$this->form_validation->CI =& $this;
		
	}  
  
  
  function widget(){ 
  	  
	  $this->form_validation->set_rules( 
	   
	     array(
	       
	        array(
	              'field' => 'first_name',
	              'label' => 'First Name',
	              'rules' => 'trim|xss_clean'
	        ),
	        array(
	              'field' => 'last_name',
	              'label' => 'Last Name',
	              'rules' => 'trim|xss_clean'
	        ),
	        array(
	              'field' => 'dob',
	              'label' => 'Date of Birth',
	              'rules' => 'trim|xss_clean'
	        )
	     ) 
	     
	   );
   

	   $this->form_validation->set_error_delimiters('<p class="error">', '</p>');
        	      
	  if( $return = $this->form_validation->run() ) {
		  
		  $this->load->model( 'User_model' , '' , TRUE );
		  
		  //  register a new user to the database and return his unique user_id
		  if( $this->User_model->update_user( $this->input->post() ) ){
  		  
  		  $input = $this->input->post();
  		  
  		  $this->userdata->first_name = $input['first_name'];
  		  $this->userdata->last_name = $input['last_name'];
  		  $this->userdata->dob = $input['dob'];
  		  
  		  $this->data['message'] = 'Your profile has been updated!';  
  		  
		  } else {
  		  
  		  $this->data['message'] = 'No update!';  
  		  
		  }

		}  
		
    
    $this->load->view('profile_default.php' , $this->data );
    
  }  
  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */