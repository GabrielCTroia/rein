<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  
  $included files
  - models/fetch_model.php
  
*/

//load the Fetch_model
require_once( APPPATH . 'models/fetch_class.php' );
  
class Fetch_behance extends Fetch_class{
  
  protected $service_name = "behance";
  
  //set the post category 
  protected $post_category = 'projects';
  
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
					
			$param = array();
		  
		  
/* 		abstract_format( $p_fgn_id , $created_date , $favorited_date , $value , $source , $tags = array() , $caption , $thumbnails = array(),  $param ) */

  		
		  
			$formatted[] = $this->abstract_format( 
          			       format_foreign_id( $post->project->id , $this->service_id )
          			     , date( $date_format, $post->project->created_on )
          			     , date( $date_format, $post->timestamp )
          			     , end( $post->project->covers )
          			     , $post->project->url
          			     , $post->project->fields //array
          			     , addslashes( $post->project->name ) 
          			     , (array)$post->project->covers
          			     , $param
        			   );				
          			   
		}
		
		return $formatted;
    
  }
  
  
  
}  

/* End of file Fetch_instagram.php */
/* Location: ./application/models/services/twitter/Fetch_instagram.php */