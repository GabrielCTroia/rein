<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  Needs description
  
  $included files
  - models/api_class.php
  - models/fetch_interface.php
  
*/

require_once( APPPATH . 'models/api_class.php' );
  
require_once( APPPATH . 'models/fetch_interface.php' );  
  
class Fetch_model extends Api_class implements Fetch_interface{
    
  /* 
   * init function 
   * NEEDS to be loaded each time we use this model otherwise the proper library is not loaded
   */  
  function init( $user_id , $access ){
    
    if( empty( $user_id ) || empty( $access ) ) {
      
      $this->error = true;
      
      $this->error_msg = "No user or access token given!";
      
      return false;
      
    }
    
    $this->user_id = $user_id;
    
    $this->access_token = $access[0]->access_token;
    
    $this->access_token_secret = $access[0]->access_token_secret;
    
    $this->fgn_user_id = $access[0]->fgn_user_id;
    
  }
  
 /* 
  * fetches the posts 
  * @count - number of posts to fetch
  */
  function fetch( $count = 20 ){}
  
  
  function format( $posts ){}
  
  /* 
   * abstracts the posts format
   * here are all the fields present in the table
   */ 
  function abstract_format( $p_fgn_id , $created_date , $favorited_date , $value , $source , $tags = array() , $caption , $thumbnails = array(),  $param = array() ){
    
    $formatted = array(

		      'post_foreign_id'  => $p_fgn_id
  			
  			, 'created_date'     => $created_date
  			, 'favorited_date'   => $favorited_date
  			, 'status'           => 'active'
  			, 'value'            => $value
  		  , 'source'           => $source
  			, 'tags'             => json_encode( $tags )
  			, 'caption'          => $caption
  			, 'thumbnails'       => json_encode( $thumbnails )
  		
   			, 'param'            => json_encode( $param )
        
		);
    
    return $formatted;
    
  }
  
}










/* End of file access_model.php */
/* Location: ./application/models/access.php */

