<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Fetch_model
require_once( APPPATH . 'models/fetch_model.php' );
  
class Fetch_instagram extends Fetch_model{
  
    
  function load_library(){

    //this are gonna become part of this class and the access class but for the sake of productivbity I'm gonna' just live them here     
		require_once( APPPATH . '/libraries/PHP-Instagram-API-master/Examples/_SplClassLoader.php' );

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
    
    $loader = new SplClassLoader( 'Instagram', dirname( APPPATH . 'libraries/PHP-Instagram-API-master/Instagram' ) );
		$loader->register();
    
    $instagram = new Instagram\Instagram;
    
		$instagram->setAccessToken( $this->access_tokens );
		
		$param_arr = array(
				"count"		=> $count			       	
    );

      
    $current_user = $instagram->getCurrentUser();
    
    
/*     var_dump($current_user->getLikedMedia( array( 'max_like_id' => '427150720_11007611' ) )); */
    
    
/*     var_dump( $current_user->getMedia( $param_arr ) ); */
    
/*     var_dump($user->getLikedMedia()); */
                		        
    return $current_user->getMedia( $param_arr );		
    
  }
  
  
  
  
}  

/* End of file Fetch_instagram.php */
/* Location: ./application/models/services/twitter/Fetch_instagram.php */