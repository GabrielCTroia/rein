<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  
  $included files
  - models/fetch_model.php
  
*/

//load the Fetch_model
require_once( APPPATH . 'models/fetch_model.php' );
  
class Fetch_youtube extends Fetch_model{
  
  protected $service_name = "youtube";
  
  /* $PARTICULAR VARS */
  
  private $fgn_user_name = null; 
  

  public function __construct(){
    
    parent::__construct();
    
    //instantiate the api object
    
    $this->google = new Google_Client();
/*
    $this->google->setApplicationName('Youtube Application');
    $this->google->setClientId( $this->consumer_key );
    $this->google->setClientSecret( $this->consumer_secret );
    $this->google->setRedirectUri( $this->callback_url );
    
    
    //these needs to be set in the db
    $this->google->setDeveloperKey( 'AIzaSyBMnATOVWah8FzW7NtPVGqYIQxVrNjOihU' );
*/
    

    $this->api = new Google_YouTubeService( $this->google );
     
  }
  
  /* 
   * fetches the posts 
   * @count - number of posts to fetch
   */
  function fetch( $count = 20 ){

/* var_dump( $this->access_token ); */ 

    $this->google->setAccessToken( $this->access_token );    
    

        
    $searchResponse = $this->api->activities->listActivities();
    
    var_dump( $searchResponse ); 
    
    exit();
            
/*     return $this->format( $this->api->getUserAppreciations( $this->fgn_user_id ) );     */
    
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