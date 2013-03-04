<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

//load the Fetch_model
require_once( APPPATH . 'models/fetch_model.php' );
  
class Fetch_twitter extends Fetch_model{
  
  /* 
   * init function 
   * NEEDS to be loaded each time we use this model otherwise the proper library is not laoded
   */
  function init(){
    
    $this->load_library();
    
  }
  
  function load_library(){

    //this are gonna become part of this class and the access class but for the sake of productivbity I'm gonna' just live them here     
    require_once( APPPATH . 'libraries/twitteroauth-master/twitteroauth/twitteroauth.php');
		require_once( APPPATH . 'libraries/twitteroauth-master/config.php');				

  }
  
  /* 
   * fetch the live posts 
   */
  function fetch( $count = 20 ){
    
    //the oauth CODES are gonna' be taken from the DB once activated
    $service = new TwitterOAuth( "" , "" , "hJd74V3X2hTB7Ixzc0H8mdpRUdNc9b5nvDu14o", "lWo2mPGirFPy2AlwhIteChnuCfhgu04MmVnzoWWEm0" );

      //when I will do the Oauth classes and each particular one
      //I should return an error if the access_token is not given or is not thr right one
      // Right now if one of this condition is not fulfiled the server return an error and is not right
      // If those are not working it should let me reconnect
      
      $param_arr = array(
				"count"	 => $count			       	
                );
    
    //check if there is an error in the request 
    //valid only for twitter
    if( $error = $service->get('favorites' , $param_arr )->error ){
      
      $this->error = $error;
      
      var_dump( $this->error );
      
      return false;
    }
          
		return $this->format( $service->get('favorites' , $param_arr ) );
		   
  }
  
  
  /* 
   * format the posts before showing or storing into the db 
   */
  function format( $posts ){
    foreach( $posts as $index=>$post )
				{	
					$data[$index]  = array(
						
						'post_foreign_id' => 'asd',
						'user_id' => '1',
						'service_id' => 'twitter',
						'created_date' => "today",
						'status' => 'active',
						'value' => "Asd",
						'source' => '',
						'param' => '{
							"user_id" 		: "' . "ASd" . '",
							"user_name" 	: "' . "ASDASDa" . '",
							"profile_image" : "' . "asd" . '",
							"user_url" 		: "' . "ASD" . '",
							"post_type" 	: "favorited"
						}'
						
					);
				}
		
		return $data;
				
  }
  
  
  
  
  
}  

/* End of file Fetch_twitter.php */
/* Location: ./application/models/services/twitter/Fetch_twitter.php */