<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  
  $included files
  - models/fetch_model.php
  
*/

//load the Fetch_model
require_once( APPPATH . 'models/fetch_model.php' );
  
class Fetch_behance extends Fetch_model{
  
  protected $service_name = "behance";

  public function __construct(){
    
    parent::__construct();
    
    //instantiate the api object
    $this->api = new Be_Api( $this->consumer_key , $this->consumer_secret );
    
  }
  
  
  /* 
   * fetches the posts 
   * @count - number of posts to fetch
   */
  function fetch( $count = 20 ){

    //when I will do the Oauth classes and each particular one
    //I should return an error if the access_token is not given or is not thr right one
    // Right now if one of this condition is not fulfiled the server return an error and is not right
    // If those are not working it should let me reconnect
    
    // User data

/*     var_dump( $this->api->getUser( $this->access_tokens ) ); */
    
      var_dump ( $this->api->searchProjects( array( 'q' => 'new york' ) ) );    
/*     var_dump( $this->api );        */
    
  }
  
  
  
  
  /* 
   * formats the posts before they are returned 
   */
  function format( $posts ){
    
    if( !$posts ) return false;
    
    /* create a new array to store the formateted posts */
    $formatted = array();
    
    //this needs to be out in a separate .config file or something
		$date_format = 'Y-m-d H:i:s';

		return $formatted;
    
  }
  
  
}  

/* End of file Fetch_instagram.php */
/* Location: ./application/models/services/twitter/Fetch_instagram.php */