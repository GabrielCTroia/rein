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

    $this->api->setAccessToken( $this->access_tokens );    
        
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
		

		
		foreach( $posts as $index=>$post ){
		
		  $formatted[$index] = array(

		      'post_foreign_id'  => Util::format_foreign_id( $post->project->id , $this->service_id , $this->user_id )
  			, 'u_id'             => $this->user_id
  			, 's_id'             => $this->service_id
  			
  			, 'created_date'     => date( $date_format, $post->project->created_on )
  			, 'status'           => 'active'
  			, 'value'            => $post->project->covers->{'115'}
  		  , 'source'           => $post->project->url
  			
  			, 'param'            => '{
          				  "user_id" 		   : "' . $post->project->owners[0]->id . '"
          				, "user_name"      : "' . $post->project->owners[0]->display_name . '"

          				, "user_url"       : "' . $post->project->owners[0]->url . '"
          				, "country"        : "' . $post->project->owners[0]->country . '"
          				, "user_bio" 		   : "if the bio is russian the object breaks"
          				, "post_type" 	   : "appreciated"
          				, "tags"   			   : "' . $post->project->fields[0] .'"
              }'
		  );
		
		}

		return $formatted;
    
  }
  
  
}  

/* End of file Fetch_instagram.php */
/* Location: ./application/models/services/twitter/Fetch_instagram.php */