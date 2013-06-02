<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Router class */
require APPPATH."third_party/MX/Router.php";

class MY_Router extends MX_Router {
  
  /* 
   * cache the current PAGE 
   * 1ST SEGMENT
   * ex: /home , /init
   */
  public $curr_page = null;
  
  /* 
   * cache the current COMPONENT - if exists
   * 2nd SEGMENT
   * ex: /home/feed, /home/splash
   */
  public $curr_component = null;  
  
  
  /* 
   * cache the current METHOD 
   * 3rd SEGMNETS
   * ex: /home/feed/delete
   */
  public $curr_method = null;
  
  
  /* 
   * cache the METHOD's arguments 
   * they fo in pair - 4th with 5th, 6th with 7th and so on
   * ex: /home/feed/delete/id/23, home/feed/show/limit/20/order_by/date/dir/ASC 
        OR, IF WE HAVE MULTIPLE IN THE SAME CAT
       
        /home/feed/delete/id/23,45,46,78,12,45,56,1,23 (or some other separator - but I feel like if they ar so many should be passed via POST) 
   */
  public $curr_args = array();
  

  /* 
   * this is called one time only by the main controller 
      - cannot have it in the controller because the uri loads later
   */
  function init(){
   
   //$segments = $this->uri->segment(1);
   
   //set the page
   $this->curr_page = $this->uri->segment(1);
   
   //set the component
   $this->curr_component = $this->uri->segment(2);
   
   //set the method
   $this->curr_method = $this->uri->segment(3);
   
   //set the args 
   $this->curr_args = $this->uri->uri_to_assoc(4);   
      
  }
  
    

  /*
  pretty complex method
  IF the rest of the args are null or false then nothing stays the same
  IF THEY ARE TRUE than the current ones are used
  */
  
  /* maybe I should implement a redirect somehow - just thinking*/
  function new_url( $page = null , $curr_component = null , $method = null , $args = array() ){
    
    //assign the current values if requested()se to true, otherwise leave null - this way we keep it flexible
    
    if( $page === true ) $page = $this->curr_page;
    
    if( $curr_component === true ) $curr_component = $this->curr_component;
    
    if( $method === true ) $method = $this->curr_method;    
    
    if( $args === true ) $args = $this->curr_args;
    
    
    //add a slash if we have something
    
    if( $page ) $page = '/' . $page;
    
    if( $curr_component ) $curr_component = '/' . $curr_component;
    
    if( $method ) $method = '/' . $method;
    
    if( $args ) $args = '/' . $this->uri->assoc_to_uri( $args );
    else $args = null; //otherwise returns Array
        
/*     var_dump( $this->uri->assoc_to_uri( $args ) );     */
        
        
    return $page . $curr_component . $method . $args;
    
  }
    
  //returns the new URL with just the page and nothing else  
  function new_page( $page = null , $curr_component = null , $method = null , $args = array() ){
    
    return $this->new_url( $page , $curr_component , $method , $args );
    
  }
  
  //returns the new URL with the page/component and nothing else  
  function new_component( $curr_component = null , $method = null , $args = array() ){
    
    return $this->new_url( true , $curr_component , $method , $args );    
    
  }
    
  //returns the new URL with the page/component/method nothing else  
  function new_method( $method = null , $args = array() ){
    
    return $this->new_url( true , true , $method , $args );
    
  }  
  
  //returns the new URL the new args WITHOUT the old ones
  function new_args( $args = array() ){
    
    return $this->new_url( true , true , true , $args );
    
  }
    
  //returns the new URL the new args WITH the old ones
  function switch_args( $args = array() ){

    return $this->new_url( true , true , true , array_merge( $this->curr_args , $args) );

  }
  
  
  
  
  
  
  /* NOT USED YET! */ 
  

    
  /* 
	 * returns the same url structure(same params) with different values 
	 */
/*
	public function get_new_url( $param , $new_val , $segments = array() ){
    
    if( empty( $segments ) ) {
      
      $segments = $this->url_params;
      
    }
       
    $segments[$param] = $new_val;   
       
    return '/' . $this->uri->assoc_to_uri( $segments ); 
      
  }
*/
  	
  /*
   * this returns the correct url
  */
	public function get_arg_value( $arg , $default = null ){
  	  	 	
  	if( !empty( $this->curr_args[ $arg ] ) ) {
    	
      if( $arg === 'redirect' ){
        
        return str_replace( '-' , '/' , $this->curr_args[ 'redirect' ] );
        
      }
  
      return $this->force_datatype( $default , $this->curr_args[ $arg ] );	
    	
  	}
  	 
    return $default;	
  	
	}  
	
	  /* this needs to be written somewhere else - UTIL or something 
   * 
   * return the desired datatype
   * @type - var you wish to turn it into
   * @var - the var you wish to convert
  */
  private function force_datatype( $type_var , $var ){
    
    switch( gettype( $type_var ) ){
      
      case 'integer' : return (int)$var;
        break;
        
      case 'boolean' : return (boolean)$var;
        break;  
      
      case 'string' : return (string)$var;
        break;
        
      default : return $var;
        break;  
      
    }
    
  }
  
}