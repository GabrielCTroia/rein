<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  
  $included files
  - models/fetch_model.php
  
*/

//load the Fetch_model
require_once( APPPATH . 'models/fetch_model.php' );
  
class Fetch_vimeo extends Fetch_model{
  
  protected $service_name = "vimeo";



  function __construct(){
    
    parent::__construct();
    
    $this->api = new phpVimeo( $this->consumer_key , $this->consumer_secret );
    

  }
  
  
  /* 
   * fetches the posts 
   * @count - number of posts to fetch
   */
  function fetch( $count = 20 ){
    
    $this->api->setToken( $this->access_token , $this->access_token_secret );
    
    $posts = $this->api->call('vimeo.videos.getLikes')->videos->video;
    
    return $this->format( $posts );
    
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
  			
  			  'post_foreign_id'   => Util::format_foreign_id( $post->id , $this->service_id )
  			, 'u_id'              => $this->user_id
  			, 's_id'              => $this->service_id
  			
  			 
  			, 'created_date'      => $post->upload_date
  			, 'favorited_date'    => $post->liked_on
  			, 'status'            => 'active'
  			, 'value'             => $post->id
  		  , 'source'            => ''
  			
  			, 'param'             => '{
      				  "user_id" 		   : "' . $post->owner . '"
      				, "user_name"      : "' . $this->get_username( $post->owner ) . '"
      				, "title"      	   : "' . addslashes( $post->title ) . '"
      				, "upload_date" 	 : "' . $post->modified_date . '"
      				, "privacy"   		 : "' . $post->privacy . '"
      				, "is_hd"   			 : "' . $post->is_hd .'"
      				, "thumbnail"      : "' . $this->get_thumbnail( $post->id ) . '" 
  			}'
  			
  		);
  		
		}

		return $formatted;
    
  }
  
  /* 
   * this makes necessary calls - like user information or similar 
   */
  protected function api_get_extra( $method , $params = null , $select = null ){
    
    if( $data = $this->api->call( $method , $params ) ) {
      
      if( $select ) {
        
        var_dump($data);
        
        return $data->$select; 
          
      }  
      
      return $data;
      
    }
    
    return null;
    
  }
  
  private function get_username( $user_id ){  
          
    if( $data = $this->api->call( 'vimeo.people.getInfo' , array( 'user_id' => $user_id ) ) ) {
      
      return $data->person->username;
      
    }
    
    return null;
    
  }
  
  private function get_thumbnail( $video_id ){
    
    if( $data = $this->api->call( 'videos.getThumbnailUrls' , array( 'video_id' => $video_id ) ) ) {
      
      $data = end($data->thumbnails->thumbnail);
    
      return $data->_content; 
      
    }
    
    return false;
    
  }
  
  
}  

/* End of file Fetch_instagram.php */
/* Location: ./application/models/services/twitter/Fetch_instagram.php */