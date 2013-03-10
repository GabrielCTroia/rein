<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  
  $included files
  - models/fetch_model.php
  
*/

//load the Fetch_model
require_once( APPPATH . 'models/fetch_model.php' );
  
class Fetch_instagram extends Fetch_model{
  
  //should come from the DB but will do for now
  protected $service_id = 2;
  
  //should come from the DB but will do for now
  protected $service_name = "Instagram";
  

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
				'count'		=> $count			       	
    );

      
    $current_user = $instagram->getCurrentUser();
                		        
    return  $this->format( $current_user->getMedia( $param_arr ) );		
    
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
		
		//not the best place to put it but works for now
		// - if not here it would generate an error
		date_default_timezone_set('America/New_York');
		
		foreach( $posts as $index=>$post ) {	
					
  		$formatted[$index] = array(
  			
  			  'post_foreign_id'  => Util::format_foreign_id( $post->id , $this->service_id , $this->user_id )
  			, 'u_id'          => $this->user_id
  			, 's_id'     => $this->service_id
  			
  			 
  			, 'created_date' => date( $date_format, $post->created_time )
  			, 'status' => 'active'
  			, 'value' => $post->images->standard_resolution->url
  		  , 'source' => ''
  			, 'param' => '{
  				  "user_id" 		: "' . $post->user->id . '"
  				, "user_name" 	: "' . $post->user->username . '"
  				, "profile_image" : "' . $post->user->profile_picture . '"
  				, "user_bio" 		: "if the bio is russian the object breaks"
  				, "post_type" 	: "favorited"
  				, "filter"   		: "' . $post->filter . '"
  				, "tags"   			: "' . '$post->tags' .'"
          , "caption" 		: "if the caption is russian the object breaks"
  			}'
  			
  		);
  		
		}

		return $formatted;
    
  }
  
  
}  

/* End of file Fetch_instagram.php */
/* Location: ./application/models/services/twitter/Fetch_instagram.php */