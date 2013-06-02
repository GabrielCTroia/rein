<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  
  $included files
  - models/fetch_model.php
  
*/

//load the Fetch_model
require_once( APPPATH . 'models/fetch_class.php' );
  
class Fetch_instagram extends Fetch_class{
  
  protected $service_name = "instagram";
  
  //set the post category 
  protected $post_category = 'pictures';
  
  
  
  public function __construct(){
    
    parent::__construct();
    
    //instantiate the api object
    
    $this->api = new Instagram\Instagram;
    
    
    
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
    
    $this->api->setAccessToken( $this->access_token ); 
		
		$param_arr = array(
				'count'		        => 100			       	
/* 		  , 'min_id'     => '431930742046340822_31888980' */
				
    );
      
    $current_user = $this->api->getCurrentUser();
      
/*     var_dump( $this->api->MediaCollection->getNext() );   */
      
    return  $this->format( $current_user->getLikedMedia( $param_arr ) );		
    
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
		
		  $param = array(
		              'filter'    => $post->filter
		            , 'location'  => $post->location
              );

       /* abstract_format( $p_fgn_id , 
		                       $created_date , 
		                       $favorited_date , 
		                       $value , 
		                       $source , 
		                       $tags = array() , 
		                       $caption , 
		                       $thumbnails = array() ,  
		                       $param ) */  
		  
			$formatted[] = $this->abstract_format( 
          			       format_foreign_id( $post->id , $this->service_id )
          			     , date( $date_format, $post->created_time )
          			     , date( $date_format, $post->created_time ) //the whole list is in order of the likes so I can just increase this with a 1 + current timestamp
          			     , $post->images->standard_resolution->url
          			     , $post->link
          			     , $post->tags // array
          			     , '' 
          			     , (array)$post->images->thumbnail->url
          			     , $param
        			   );		 
		}
		
		
/*
		var_dump( $formatted );
		
		exit();
*/
		
		return $formatted;
    
  }  
  
}  

/* End of file Fetch_instagram.php */
/* Location: ./application/models/services/twitter/Fetch_instagram.php */