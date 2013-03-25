<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

 /* 
  * This is the controller for the anonymus users. 
  * The methods meant to be used by different controller extending this one are written here:
    - signup()
    - login()
  */
  

class Anonym_Controller extends MY_Controller {


  /* 
   * whenver this controller is used means that the user is not logged in 
   */
  
  public function __construct(){
    
    parent::__construct();
    
    /* redirect him to home if it's logged in */
    /* to look into how to deal with the common ground - for ex. pages which shoul be available for both - auth or non auth - LATER */
    if( $this->logged_in ) {
      
  		redirect('home');
  		
		}
		
    
  }  
  
  
}