<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  
  $included files
  - models/fetch_model.php
  
*/

//load the Fetch_model
require_once( APPPATH . 'models/fetch_model.php' );
  
class Fetch_behance extends Fetch_model{
  
  protected $service_name = "behance";
  
  /* $PARTICULAR VARS */
  
  private $fgn_user_name = null; 
  

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

    $this->api->setAccessToken( $this->access_token );    
     
/*     var_dump($this->api->getUserAppreciations( $this->fgn_user_id ));  */
            
    return $this->format( $this->api->getUserAppreciations( $this->fgn_user_id ) );    
    
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
		
		//this too
		date_default_timezone_set('America/New_York');

		foreach( $posts as $post ){
      		
		  $formatted[] = array(

		      'post_foreign_id'  => format_foreign_id( $post->project->id , $this->service_id )
  			
  			, 'created_date'     => date( $date_format, $post->project->created_on )
  			, 'favorited_date'   => date( $date_format, $post->timestamp )
  			, 'status'           => 'active'
  			, 'value'            => end( $post->project->covers )
  		  , 'source'           => $post->project->url
  			
  			, 'owner'            => json_encode( $post->project->owners )
  			, 'caption'          => $post->project->name
  		
  			, 'param'            => '{
      				  "post_type" 	   : "appreciated"
      				, "tags"   			   : "' . $post->project->fields[0] .'"
      				, "thumbnail"      : "' . end( $post->project->covers ) . '"
      				, "fields"         : "' . implode( ',' ,  $post->project->fields ) . '"
        }'
        
		  );
		
		}

		return $formatted;
    
  }
  
  
  
}  

/* End of file Fetch_instagram.php */
/* Location: ./application/models/services/twitter/Fetch_instagram.php */