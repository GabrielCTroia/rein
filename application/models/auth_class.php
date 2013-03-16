<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
  Needs description
  
  $included files
  - models/api_class.php
  - models/auth_interface.php
  
*/


require_once( APPPATH . 'models/api_class.php' );

require_once( APPPATH . 'models/auth_interface.php' );


//  This class serves as the base for Auth classes containing all the neccessary
//  methods that may be needed down the line
class Auth_class extends Api_class implements Auth_interface {
  
  
  
  //protected static $consumer_key;   
  
  //protected static $consumer_secret;      
  
  //protected static $callback_url;

  //protected static $base_url;
  
  //protected static $request_token;
      
  //protected static $scope = null;


/*
  function __construct(){
    
    parent::__construct();
    
    $this->load->model( 'util' );
    
  }
*/
  public function api_return( $temp_token ){}
  
  
  public function request_temp_token() {
    
    return array(
      'status_code' => 521,
      'status_message' => 'request_temp_token missing functionality'
    );
    
  }
  
  public function generate_access_token( $temp_token ) {
    
    return array(
      'status_code' => 522,
      'status_message' => 'generate_access_token missing functionality'
    );
    
  }
  
  
  protected function format_api_return( $token , $token_secret = 'not set' , $fgn_user_id = 'not set' ){
    
    return array( 'access_token' => $token , 'access_token_secret' => $token_secret , 'fgn_user_id' => $fgn_user_id );
    
  }
  
  protected function _urlencode_rfc3986( $input ) {
  
    if ( is_array( $input ) )
        return array_map( array( get_class( $this ) , '_urlencode_rfc3986' ) , $input );
    else if ( is_scalar( $input ) )
        return str_replace( '+' , ' ' , str_replace( '%7E' , '~' , rawurlencode( $input ) ) );
    else
        return '';
  }
  
  
  protected function _http( $url, $post_data = null ) {    
   
    $ch = curl_init();

    curl_setopt( $ch , CURLOPT_URL , $url );
    curl_setopt( $ch , CURLOPT_CONNECTTIMEOUT , 30 );
    curl_setopt( $ch , CURLOPT_TIMEOUT , 30);
    curl_setopt( $ch , CURLOPT_RETURNTRANSFER , TRUE );
    curl_setopt( $ch , CURLOPT_SSL_VERIFYPEER , FALSE );

    if( isset( $post_data ) ) {
      curl_setopt( $ch , CURLOPT_POST , 1 );
      curl_setopt( $ch , CURLOPT_POSTFIELDS , $post_data );
    }

    $response = curl_exec( $ch );
    $this->http_status = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
    $this->last_api_call = $url;
    curl_close( $ch );

    return $response;
  }
  
}

/* End of file auth_class.php */
/* Location: ./application/models/auth_class.php */