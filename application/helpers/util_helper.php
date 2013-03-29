<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
/* we have here all the functions that do not depend on $this */
	
	
	
	/* should not be here BUT in a AUTH model or somtehing like that*/
  function generate_nonce( $length = 32 ){
    $u = md5( uniqid( 'nonce_' , true ) );
    return substr( $u , 0 , $length );
  }
  
  
  /* not sure exactly if still used */
  function data_string_to_array( $data ) {
    
    $data = explode( '&' , $data );
    $data_arr = array();
     
    //  Might be a function for this - turn data string into array of key->value pairs
    foreach( $data as $r ) {
      $temp_arr = explode( '=' , $r );
      $data_arr[ $temp_arr[ 0 ] ] = $temp_arr[ 1 ];
    }
    
    return $data_arr;
  }
  
  
  /* 
	 * creates unique LOCAL-ID based on the FOREIGN-ID 
	*/
	function format_foreign_id( $fid , $sid ){
		
		//the posts are service dependent
		$prefix = $sid . '-' ;
		
		return $prefix . $fid;
		
	}
	
	/* 
	 * unformat the FOREIGN-ID
	 */
	function unformat_foreign_id( $fid ){
	
		return substr( $fid , strpos( $fid , "-" ) + 1 , strlen( $fid ) );
		
	}

  
  /* 
   * Returns a alias like $name 
   */
  function safe_name( $name ){
    
    return preg_replace( '/\s/' , '_' , $name );
    
  }


  function ago( $time ){
    
    $time = strtotime( $time );
    
    $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
    $lengths = array("60","60","24","7","4.35","12","10");
    
    $now = time();
    
    $difference  = $now - $time;
    $tense       = "ago";
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
    
      $difference /= $lengths[$j];
    
    }
    
    $difference = round( $difference );
    
    if($difference != 1) {
       $periods[$j].= "s";
    }
    
    return "$difference $periods[$j] ago ";
   
  }




/* End of file util.php */
/* Location: ./application/helpers/util.php */