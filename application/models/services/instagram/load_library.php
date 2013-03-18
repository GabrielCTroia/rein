<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * this whole file may not be needed in the future but now is the best to have it so. 
 * In the future we want to have all the methods in one file and not depend on the libraries but for now is faster like this
 * 
 */
 
 include_once( APPPATH . 'lib/Instagram/_SplClassLoader.php' );

 $loader = new SplClassLoader( 'Instagram', APPPATH . 'lib' );
 $loader->register();




















/* End of file load_library.php */
/* Location: ./application/models/services/twitter/load_library.php */