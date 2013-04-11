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
  
  //this is the that should be used in the urls - not yet tested intensily
  function seo_name( $name ){
    
    $seoname = preg_replace('/\%/',' percentage', $name); 
    $seoname = preg_replace('/\@/',' at ', $name); 
    $seoname = preg_replace('/\&/',' and ', $name); 
    $seoname = preg_replace('/\s[\s]+/','-', $name);    // Strip off multiple spaces 
    $seoname = preg_replace('/[\s\W]+/','-', $name);    // Strip off spaces and non-alpha-numeric 
    $seoname = preg_replace('/^[\-]+/','', $name); // Strip off the starting hyphens 
    $seoname = preg_replace('/[\-]+$/','', $name); // // Strip off the ending hyphens 

    $seoname = strtolower( $name ); 
    
    return $seoname;
    
  }
  
  
  function pretty_name( $name , $upper = true ){
    
    $pretty_name = preg_replace( '/[\-\_]/' , ' ' , $name );
    
    if( $upper ) {
      
      return ucwords( $pretty_name ); 
      
    }
    
    return $pretty_name;
    
  }


  function ago( $time , $suffix = null ){
    
    $time = strtotime( $time );
    
    $periods = array("sec", "min", "h", "d", "w", "M", "y", "dec" );
    $lengths = array("60","60","24","7","4.35","12","10");
    
    $now = time();
    
    $difference  = $now - $time;
    $tense       = "ago";
    
    for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
    
      $difference /= $lengths[$j];
    
    }
    
    $difference = round( $difference );
    
/*     if($difference != 1) { */
/*        $periods[$j].= "s"; */
/*      } */
    
    if( $suffix ){
      $suffix = ' ' . $suffix;
    }

    return "$difference $periods[$j]" . $suffix;
   
  }
  
  
  
  




/* End of file util.php */
/* Location: ./application/helpers/util.php */