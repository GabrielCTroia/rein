<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  
  $included files
  - models/fetch_model.php
  
*/

//load the Fetch_model
require_once( APPPATH . 'models/fetch_class.php' );
  
class Fetch_youtube extends Fetch_class{
  
  protected $service_name = "youtube";

  //set the post category 
  protected $post_category = 'videos';
  
  /* 
   * fetches the posts 
   * @count - number of posts to fetch
   */
  function fetch( $count = 20 ){
    
    $params['apikey'] = 'AI39si7DoiNUorIAB2qb-wnBpdqLimuKoA8cakSvWreAJSzRZ_p865FL-Oq6s8ZODUl7_0__2TpFgBdWw3vq_iPdzX_-qYPO-Q';
		$params['oauth']['key'] = $this->consumer_key;
		$params['oauth']['secret'] = $this->consumer_secret;
		$params['oauth']['algorithm'] = 'HMAC-SHA1';
		$params['oauth']['access_token'] = array('oauth_token'=>urlencode( $this->access_token ),
												 'oauth_token_secret'=>urlencode( $this->access_token_secret ));
		
		$this->load->library('youtube', $params);     
		
		$opt = array(
		        'alt' => 'json'
		      , 'v'   => 2
		      );
		
    return $this->format( json_decode( $this->youtube->getUserFavorites( 'default' , $opt ) ) );
        
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
		
		//get to the real videos
		$posts = $posts->feed->entry;
		

		
		foreach( $posts as $post ){
					
			$param = array();

		  $thumbnails = array();      
        $thumbnails[] = $post->{'media$group'}->{'media$thumbnail'}[1]->url;
        $thumbnails[] = $post->{'media$group'}->{'media$thumbnail'}[2]->url;
		
/* 		abstract_format( $p_fgn_id 
                     , $created_date 
                     , $favorited_date 
                     , $value 
                     , $source 
                     , $tags = array() 
                     , $caption 
                     , $thumbnails = array()
                     , $param ) */

			$formatted[] = $this->abstract_format( 
          			       format_foreign_id( $post->{'media$group'}->{'yt$videoid'}->{'$t'} , $this->service_id )
          			     , date( $date_format, strtotime( $post->published->{'$t'} ) )
          			     , date( $date_format, strtotime( $post->published->{'$t'} ) )
          			     , $post->{'media$group'}->{'yt$videoid'}->{'$t'}
          			     , $post->{'media$group'}->{'media$content'}[0]->url
          			     , $post->{'media$group'}->{'media$category'} //array
          			     , addslashes( $post->{'media$group'}->{'media$title'}->{'$t'} ) 
          			     , $thumbnails
          			     , $param
        			   );				
          			   
		}
		
		return $formatted;
    
  }
  
  
  
}  

/* End of file Fetch_instagram.php */
/* Location: ./application/models/services/twitter/Fetch_instagram.php */