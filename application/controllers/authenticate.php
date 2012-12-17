<!--
#wanted to cerate anew controller for the connect page (when user are connceting with the services)
#but I store it in the welcome.php for now
#not sure if the best but will see

#one reasone why is googd to leave in the welcome.php is that it has all the login checkup,
#the data array and the GET arguments already defined
-->


<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Authenticate extends CI_Controller {


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{	
		//to do a routing model
		$data = array();
		$component = $data['component'] = new StdClass();
		
		
		if( !$this->session->userdata('logged_in') ) {
			
			$this->load->helper(array('form','url'));
			
			$component->name = "login";
			$component->path = 'pages/login_view';
								
		}else {
			error_reporting(E_ALL);
			ini_set ('error_display', 'ON');
		
			$component->name = "authenticate";
			$component->path = 'pages/authenticate_view';
					
			//see the posts specifc to the service only
			
			if ( isset( $_REQUEST['service'] ) )
			{
				
				$service_name = $_REQUEST['service'];
								
			}
			else 
			{	
				//get the posts
				echo "There is no service chosen. What to authenticate?";
			}
			
			
			



			// STORING
			
		
			
		}


						
		$this->load->view('index', $data);
      
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */