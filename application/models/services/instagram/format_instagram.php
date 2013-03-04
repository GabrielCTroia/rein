<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Format_class
require_once( APPPATH . 'models/format_class.php' );
  
class Format_instagram extends Format_class{
  
  //should come from the DB but will do for now
  protected $service_id = 2;
  
  //should come from the DB but will do for now
  protected $service_name = "Instagram";
  
  function init( $user_id ){
    
    parent::init( $user_id , $service_id );
    
  }
  
  
  function format_posts( $posts = NULL ){
    
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
  			
  			'post_foreign_id' => $this->format_foreign_id( $post->id ) ,
  			'user_id' => $this->user_id,

  			'created_date' => date( $date_format, $post->created_time ),
  			'status' => 'active',
  			'value' => $post->images->standard_resolution->url,
  			'source' => '',
  			'param' => '{
  				"user_id" 		: "' . $post->user->id . '",
  				"user_name" 	: "' . $post->user->username . '",
  				"profile_image" : "' . $post->user->profile_picture . '",
  				"user_bio" 		: "if the bio is russian the object breaks",
  				"post_type" 	: "favorited",
  				"filter"   		: "' . $post->filter . '",
  				"tags"   			: "' . '$post->tags' .'",
          "caption" 		: "if the caption is russian the object breaks"
  			}'
  			
  		);
  		
		}

		return $formatted;
    
  }
  
  
  
  

  
}  

/* End of file Format_instagram.php */
/* Location: ./application/models/services/twitter/Format_instagram.php */