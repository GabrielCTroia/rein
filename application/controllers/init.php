<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/* Explain Views & Controllers organization :
  
  Every Controller loads a common index.php which loads a specific
  page ( home.php , splash.php , callback.php , connect.php ...) 
  which also loads specifc components ( sign-up.php , login.php , feed.php , settings.php ... )
  among with the page specific includes ( header.php , footer.php ) 
  
  
  {Ghost} Component = A component which doesn't have a view assgined to it
                      It mostly only redirects you to another URL where you actually load a view
                      The difference between a Ghost Component and a method is that you actually use it as a URL 
*/

require_once( APPPATH . 'core/controllers/Anonym_controller.php' );

class Init extends Anonym_controller {

 /* 
  * define the page url  
  */
  protected $page_url = "/init";  
  
  
 /* 
  * define the $data that will be passed to the view  
  */
  private static $data = array();
  

  function __construct() {
	 
   /* 
    * load the parent construct 
    */  
    parent::__construct();
        
		/* 
    load the form helpers & libraries  
    */
	  $this->load->helper( 'form' );
	  $this->load->library( 'form_validation' );
		
		//  We are storing the Page and Components object as classes inside models
		//  because we want to be able to access them from anywhere within the controller
		//  instead of redefining a new variable for it everysingle time
    $this->load->model( 'Pager_model' , '' , FALSE );
    $this->load->model( 'Components_model' , '' , FALSE );
    
    //  At the time of writing this, both models are identical, so they accept a single
    //  $name variable which automatically generates $name/$path/$url inside the init function
    $this->Pager_model->init( 'init' ); 
      
	}
  
  

  /*
   * the index() acts like a router
   * the user never stays on it so it doesn't have a view
  */
	public function index() {	
		
		redirect( $this->page_url . '/splash' );

	}
	

	
	/* ****************************************************	
  	 Everything below this point is actually a COMPONENT 
	
    **************************************************** */
	
	
	
	
 /* 
  * SPLASH component
  */
  public function splash() {

    //  define the component	  
  	$this->Components_model->init( 'splash' );
  	
  	$this->load->view( 'index.php' );
  	
 }
	
	
}	

/* End of file init.php */
/* Location: ./application/controllers/init.php */