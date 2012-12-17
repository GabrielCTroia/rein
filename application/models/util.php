<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
Class Util extends CI_Model
{	
	//return the reverse of the array
	function reverse( $input )	
	{
		if ( is_array( $input ) )	
		{
			$input = array_reverse ( $input );	
		}
		
		return $input;
		
	}

}


//pure php doesn't need the closing tag 