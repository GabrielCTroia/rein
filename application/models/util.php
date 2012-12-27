<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	
Class Util extends CI_Model
{	
	
	//return the reverse of the array
	/*** we don't actually need this one */
	public static function reverse( $input )	
	{
		if ( is_array( $input ) )	
		{
			$input = array_reverse ( $input );	
		}
		
		return $input;
		
	}

}








/* End of file init.php */
/* Location: ./application/models/util.php */