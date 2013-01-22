<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Fetch_model
require_once( APPPATH . 'models/Fetch_model.php' );
  
class Fetch_instagram extends Fetch_model{
  
  /* 
   * init function 
   * NEEDS to be loaded each time we use this model otherwise the proper library is not laoded
   */
  function init(){
    
    $this->load_library();
    
  }
  
  function load_library(){

    //this are gonna become part of this class and the access class but for the sake of productivbity I'm gonna' just live them here     
		require_once( APPPATH . '/libraries/PHP-Instagram-API-master/Examples/_SplClassLoader.php' );

  }
  
  
  function fetch(){
    
    //when I will do the Oauth classes and each particular one
    //I should return an error if the access_token is not given or is not thr right one
    // Right now if one of this condition is not fulfiled the server return an error and is not right
    // If those are not working it should let me reconnect
    
    $loader = new SplClassLoader( 'Instagram', dirname( APPPATH . 'libraries/PHP-Instagram-API-master/Instagram' ) );
		$loader->register();
    
    $instagram = new Instagram\Instagram;		
    
    
		$instagram->setAccessToken( '50301110.89167de.b9d6dab7f3874ee4966bb05fcb75e4b0' );
		
		$param_arr = array(
				"count"		=> 2			       	
    );


    
    $user = $instagram->getCurrentUser();
    		        
    return $user->getLikedMedia( $param_arr );		
    
  }
  
  
  
}  

/* End of file Fetch_twitter.php */
/* Location: ./application/models/services/twitter/Fetch_twitter.php */