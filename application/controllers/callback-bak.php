<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Callback extends CI_Controller {


	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome0
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
		
		//load the helpers
		$this->load->helper(array('form','url'));
		
		//load the models
		$this->load->model( 'Services' , '' , true );
		$this->load->model( 'Connect' , '' , true );
		$this->load->model( 'Access' , '' , true );
		

		//init the models
		$service = $this->Services->initialize( $_REQUEST['service'] ) ;
		$service->app_config = json_decode( $service->app_config );
		
		
		$this->Connect->load_library( $service->service_name );
		
		$user = $this->session->userdata['logged_in'];
		$this->Access->initialize( $user['user_id'] );
		
		
		switch( $service->service_name )
		{
			
			case 'twitter' : 
					
				$connection = new TwitterOAuth( $service->app_config->consumer_key , $service->app_config->consumer_secret , $this->session->userdata( 'oauth_token' ) , $this->session->userdata( 'oauth_token_secret' ) );
				
				$raw_access_token = $connection->getAccessToken( $_REQUEST['oauth_verifier'] );
				
				$access_token = '{
							"oauth_token"			: "' . $raw_access_token['oauth_token'] . '" ,
							"oauth_token_secret"	: "' . $raw_access_token['oauth_token_secret'] .  '"
							}';
							
				//remove the $oauth_token and $oauth_token_secret from the Session 
				$temp_oauth = array(
					'oauth_token' 			=> '' ,
					'oauth_token_secret'	=> ''
				);
				
				$this->session->unset_userdata( $temp_oauth );
				
			break;
			
			case 'instagram' :
				
				//took from libraries/instagram/auth.php getAccessToken()				
				$app_config = array(
		            'client_id'         => $service->app_config->consumer_key,
		            'client_secret'     => $service->app_config->consumer_secret,
		            'redirect_uri'      => $service->app_config->callback_url,
		        );
		        
		        $auth = new Instagram\Auth( $app_config );
		        

		        $access_token = '{ 
		        			"access_token"	: "' . $auth->getAccessToken( $_REQUEST['code'] ) . '"
		        			}';		        
			break;
		}
		
		//add the $access_token to the session
/* 		$this->session->set_userdata( $access_token ); */
		
		if ( $this->Access->set_access( $service->service_id , $access_token ) )
		{
			//get out of here
			redirect ( "/?service=" . $service->service_name . "&method=GET_LIVE&store_posts=true" );					
		}

	}
	

	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */