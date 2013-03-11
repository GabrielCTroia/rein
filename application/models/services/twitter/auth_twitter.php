<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( APPPATH . 'models/auth_class.php' );

class Auth_twitter extends Auth_class {
    
  protected $consumer_key = '8m8tyQMU3sTPcQfNKoTsA';   
  
  protected $consumer_secret = 'kLQhNBv3WRKbOV02ApQK2HmyDjuQnvCRi7uLSrWXcc';      
  
  protected $callback_url = 'http://127.0.0.1:8888/auth/callback/twitter';

  protected $OAuth_version = '1.0';
  
  /* 
   * the base API URL  
   */
  protected $base_url = 'https://api.twitter.com/';
  
  protected $request_token = 'oauth/request_token';
  protected $redirect_url = 'oauth/authenticate';
  protected $access_url = 'oauth/access_token';
      
  protected $scope = null;


  function __construct() {
    
    parent::__construct();
    
    $this->request_token  = $this->base_url . $this->request_token;
    $this->redirect_url   = $this->base_url . $this->redirect_url;
    $this->access_url     = $this->base_url . $this->access_url;
  }
  

  public function request_temp_token() {
  
    // Default params
    $params = array(
      'oauth_version' => $this->OAuth_version,
      'oauth_nonce' => $this->util->generate_nonce(),
      'oauth_timestamp' => time(),
      'oauth_consumer_key' => $this->consumer_key,
      'oauth_signature_method' => 'HMAC-SHA1'
    );
     
    
    $concatenatedUrlParams = $this->_build_signature( $params );
    
    
    // form url
    $url = $this->request_token . '?' . $concatenatedUrlParams;

    // Send to cURL
    $results = $this->_http( $url );
    $results_arr = $this->util->data_string_to_array( $results );
    
    //  if error, redirect back to settings with the reason 
    if( $results_arr[ 'oauth_callback_confirmed' ] != 'true' )
      redirect( '/home/settings?service=twitter&status_code=222' );
    
    //  otherwise redirect user to login
    redirect( $this->redirect_url . "?$results" );
    
  }
  
  
  
  
  
  
  public function generate_access_token( $oauth_result ) {// $oauth_result = $_GET of result
    
    $parameters = array();
    
    if( !count( $oauth_result ) ) {
      
      return array(
        'status_code' => 523,
        'status_message' => 'Missing OAuth verification'
      );
      
    }
    
    $params = array(
      'oauth_version' => $this->OAuth_version,
      'oauth_nonce' => $this->util->generate_nonce(),
      'oauth_timestamp' => time(),
      'oauth_consumer_key' => $this->consumer_key,
      'oauth_token' => $oauth_result[ 'oauth_token' ],
      'oauth_verifier' => $oauth_result[ 'oauth_verifier' ],
      'oauth_signature_method' => 'HMAC-SHA1'
    );
    
    
    $concatenatedUrlParams = $this->_build_signature( $params );
    
    
    // form url
    $url = $this->request_token . '?' . $concatenatedUrlParams;

    // Send to cURL
    $results = $this->_http( $url );
    $results_arr = $this->util->data_string_to_array( $results );
    
    if( $results_arr[ 'oauth_callback_confirmed' ] != 'true' ) {
    
      return array(
        'status_code' => 223,
        'status_message' => 'Error retrieving OAuth token/secret'
      );
    } else {
      
      $results_arr[ 'access_token' ] =
        json_encode(
          array(
            'oauth_token' => $results_arr[ 'oauth_token' ],
            'oauth_token_secret' => $results_arr[ 'oauth_token_secret' ]
          )
        );
        
      $results_arr[ 'status_code' ] = 200;
    }
    
    return $results_arr;
  }
  
  
  
  
  
  
  //  Intakes an array of params and does a bunch of gobbledy-gook to it so twitter can process it
  private function _build_signature( $params ) {
    
    // encode params keys, values, join and then sort.
    $consumer_keys = $this->_urlencode_rfc3986( array_keys( $params ) );
    $values = $this->_urlencode_rfc3986( array_values( $params ) );
    $params = array_combine( $consumer_keys , $values );
    uksort( $params , 'strcmp' );

    // convert params to string 
    foreach( $params as $k => $v )
        $pairs[] = $this->_urlencode_rfc3986( $k ) . '=' . $this->_urlencode_rfc3986( $v );
        
    $concatenatedParams = implode( '&' , $pairs );

    // form base string (first key)
    $baseString = 
          'GET&' . $this->_urlencode_rfc3986( $this->request_token ) . '&' . $this->_urlencode_rfc3986( $concatenatedParams );
    
    // form secret (second key)
    $consumer_secret = $this->_urlencode_rfc3986( $this->consumer_secret ).'&';
    
    // make signature and append to params
    $params[ 'oauth_signature' ] =
          $this->_urlencode_rfc3986( base64_encode( hash_hmac( 'sha1' , $baseString , $consumer_secret , TRUE ) ) );
    
    
    // BUILD URL
    // Resort
    uksort( $params , 'strcmp' );
    
    // convert params to string 
    foreach ($params as $k => $v)
        $urlPairs[] = $k . '=' . $v;
        
    return implode( '&' , $urlPairs );
    
  }
}














/* End of file Auth_twitter.php */
/* Location: ./application/models/services/twitter/Auth_twitter.php */