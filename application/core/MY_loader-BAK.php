<?php if( ! defined( 'BASEPATH' ) ) exit( 'No direct script access allowed' );

class MY_Loader extends CI_Loader {


	/**
	 * List of paths to load models from
	 *
	 * @var array
	 * @access protected
	 */
	protected $_ci_module_path		= null;

	/**
	 * List of loaded modules
	 *
	 * @var array
	 * @access protected
	 */
	protected $_ci_modules			= array();
	
	
	
	protected $_ci_components			= array();


	protected $_my_components_path = '';



  function __construct(){
      parent::__construct();

      $this->ci_module_path = APPPATH . 'modules/';
      
      
      $this->_my_component_path = array( APPPATH . 'components/' );
      
      
      $CI =& get_instance();
      $CI->load = $this;
  }




  /**
   * Load a view within the specified layout
   * Functions as an extension of CI_Loader::view()
   * 
   * @param string the path to the view, within the controller's views_path (property)
   * @param array Associative array of variables to make available to the view and layout
   * @param bool Should the view/layout contents be returned, instead of written to output buffer
   * @return mixed Boolean true, or string output based on the $return parameter
   */
	function page( $view, $vars=array(), $return=false ) {
		// application specific variables

                // merge in standard system variables
		$vars = $this->_add_layout_vars($vars);

		// load the layout
		$views_path = isset($CI->views_path) ? $CI->views_path : '';
		$vars['body'] = $this->view($views_path.'/'.$view, $vars, TRUE);
		$layout = isset($this->layout) ? $this->layout : 'default';

		return $this->view("_layouts/$layout", $vars, $return );
	}



	public function component( $component ) {
  	
/*   	$this->load->add_package_path( $this->_my_components_path . 'feed/'); */
  	
	}



	public function component_lib( $component , $name = '' ){
  	
  	$path = COMPONENTS_PATH . $name . '/';
  	
  	$this->_my_load_class( "feed" , null , null );
  	
	}
	
	
	
	
	/**
	 * Load class
	 *
	 * This function loads the requested class.
	 *
	 * @param	string	the item that is being loaded
	 * @param	mixed	any additional parameters
	 * @param	string	an optional object name
	 * @return	void
	 */
	protected function _my_load_class($class, $params = NULL, $object_name = NULL)
	{
		// Get the class name, and while we're at it trim any slashes.
		// The directory path can be included as part of the class name,
		// but we don't want a leading slash
		$class = str_replace('.php', '', trim($class, '/'));

		// Was the path included with the class name?
		// We look for a slash to determine this
		$subdir = '';
		if (($last_slash = strrpos($class, '/')) !== FALSE)
		{
			// Extract the path
			$subdir = substr($class, 0, $last_slash + 1);

			// Get the filename from the path
			$class = substr($class, $last_slash + 1);
		}

		// We'll test for both lowercase and capitalized versions of the file name
		foreach (array(ucfirst($class), strtolower($class)) as $class)
		{
			$subclass = APPPATH.'components/'.$subdir.config_item('subclass_prefix').$class.'.php';

			// Is this a class extension request?
			if (file_exists($subclass))
			{
				$baseclass = BASEPATH.'components/'.ucfirst($class).'.php';

				if ( ! file_exists($baseclass))
				{
					log_message('error', "Unable to load the requested class: ".$class);
					show_error("basepath Unable to load the requested class: ".$class);
				}

				// Safety:  Was the class already loaded by a previous call?
				if (in_array($subclass, $this->_ci_loaded_files))
				{
					// Before we deem this to be a duplicate request, let's see
					// if a custom object name is being supplied.  If so, we'll
					// return a new instance of the object
					if ( ! is_null($object_name))
					{
						$CI =& get_instance();
						if ( ! isset($CI->$object_name))
						{
							return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $object_name);
						}
					}

					$is_duplicate = TRUE;
					log_message('debug', $class." class already loaded. Second attempt ignored.");
					return;
				}

				include_once($baseclass);
				include_once($subclass);
				$this->_ci_loaded_files[] = $subclass;

				return $this->_ci_init_class($class, config_item('subclass_prefix'), $params, $object_name);
			}

			// Lets search for the requested library file and load it.
			$is_duplicate = FALSE;
			foreach ($this->_my_library_paths as $path)
			{
			 
			   
				$filepath = $path.$subdir.$class.'.php';
				
				echo $filepath;
				echo "<br/>";
				
				// Does the file exist?  No?  Bummer...
				if ( ! file_exists($filepath))
				{
					continue;
				}

				// Safety:  Was the class already loaded by a previous call?
				if (in_array($filepath, $this->_ci_loaded_files))
				{
					// Before we deem this to be a duplicate request, let's see
					// if a custom object name is being supplied.  If so, we'll
					// return a new instance of the object
					if ( ! is_null($object_name))
					{
						$CI =& get_instance();
						if ( ! isset($CI->$object_name))
						{
							return $this->_ci_init_class($class, '', $params, $object_name);
						}
					}

					$is_duplicate = TRUE;
					log_message('debug', $class." class already loaded. Second attempt ignored.");
					return;
				}

				include_once($filepath);
				$this->_ci_loaded_files[] = $filepath;
				return $this->_ci_init_class($class, '', $params, $object_name);
			}

		} // END FOREACH

		// One last attempt.  Maybe the library is in a subdirectory, but it wasn't specified?
		if ($subdir == '')
		{
			$path = strtolower($class).'/'.$class;
			return $this->_my_load_class($path, $params);
		}

		// If we got this far we were unable to find the requested class.
		// We do not issue errors if the load call failed due to a duplicate request
		if ($is_duplicate == FALSE)
		{
			log_message('error', "Unable to load the requested class: ".$class);
			show_error("basepath Unable to load the requested class: ".$class);
		}
	}
	
		/**
	 * Class Loader
	 *
	 * This function lets users load and instantiate classes.
	 * It is designed to be called from a user's app controllers.
	 *
	 * @param	string	the name of the class
	 * @param	mixed	the optional parameters
	 * @param	string	an optional object name
	 * @return	void
	 */
	public function library($library = '', $params = NULL, $object_name = NULL)
	{
		if (is_array($library))
		{
			foreach ($library as $class)
			{
				$this->library($class, $params);
			}

			return;
		}

		if ($library == '' OR isset($this->_base_classes[$library]))
		{
			return FALSE;
		}

		if ( ! is_null($params) && ! is_array($params))
		{
			$params = NULL;
		}

		$this->_ci_load_class($library, $params, $object_name);
	}


	/**
	 * Add Package Path
	 *
	 * Prepends a parent path to the library, model, helper, and config path arrays
	 *
	 * @param	string
	 * @param 	boolean
	 * @return	void
	 */
	public function component2( $component , $name = '' ){
  	
  	if ( is_array( $component ) ){
			foreach ($component as $babe)
			{
				$this->component($babe);
			}
			return;
		}
  	
  	
  	
  	if ($component == ''){
			
			return;
			
		}
  	
  	if( $name == '' ){
      
      $name = Util::safe_name( $component );
      	
  	} else {
    	
    	$name = Util::safe_name( $name );
    	
  	}
  	
    
/*     $component =  = new stdClass(); */
    
    $path = COMPONENTS_PATH . $name . '/';
    
/*     require_once( $path . '/' . $name . '_controller.php'); */
    
/*     $this->load->file( $path . '/' . $name . '_controller.php' ); */

    

		$CI =& get_instance();
		
		if( isset( $CI->$name ) ){
			
			show_error('The model name you are loading is the name of a resource that is already being used: '.$name);
			
		}
		
		
		if ( ! class_exists('MY_Component'))
		{
		  load_class('Component' , 'core' , 'MY' );
		}
		
		require_once( $path . $name . '.php' );
		
		$component = ucfirst( $name );
		
		$CI->$name = new $component();

		$this->_ci_components[] = $name;		
		return;
/*
		$path = rtrim($path, '/').'/';

		array_unshift($this->_ci_library_paths, $path);
		array_unshift($this->_ci_model_paths, $path);
		array_unshift($this->_ci_helper_paths, $path);

		$this->_ci_view_paths = array($path.'views/' => $view_cascade) + $this->_ci_view_paths;

		// Add config file path
		$config =& $this->_ci_get_component('config');
		array_unshift($config->_config_paths, $path);
*/
	}




/**
	 * Model Loader
	 *
	 * This function lets users load and instantiate models.
	 *
	 * @param	string	the name of the class
	 * @param	string	name for the model
	 * @param	bool	database connection
	 * @return	void
	 */
	public function model($model, $name = '', $db_conn = FALSE)
	{
		if (is_array($model))
		{
			foreach ($model as $babe)
			{
				$this->model($babe);
			}
			return;
		}

		if ($model == '')
		{
			return;
		}

		$path = '';

		// Is the model in a sub-folder? If so, parse out the filename and path.
		if (($last_slash = strrpos($model, '/')) !== FALSE)
		{
			// The path is in front of the last slash
			$path = substr($model, 0, $last_slash + 1);

			// And the model name behind it
			$model = substr($model, $last_slash + 1);
		}

		if ($name == '')
		{
			$name = $model;
		}

		if (in_array($name, $this->_ci_models, TRUE))
		{
			return;
		}

		$CI =& get_instance();
		if (isset($CI->$name))
		{
			show_error('The model name you are loading is the name of a resource that is already being used: '.$name);
		}

		$model = strtolower($model);

		foreach ($this->_ci_model_paths as $mod_path)
		{
			if ( ! file_exists($mod_path.'models/'.$path.$model.'.php'))
			{
				continue;
			}

			if ($db_conn !== FALSE AND ! class_exists('CI_DB'))
			{
				if ($db_conn === TRUE)
				{
					$db_conn = '';
				}

				$CI->load->database($db_conn, FALSE, TRUE);
			}

			if ( ! class_exists('CI_Model'))
			{
				load_class('Model', 'core');
			}

			require_once($mod_path.'models/'.$path.$model.'.php');

			$model = ucfirst($model);

			$CI->$name = new $model();

			$this->_ci_models[] = $name;
			return;
		}
	
		// couldn't find the model
		show_error('Unable to locate the model you have specified: '.$model);
	}

	/**
	 * Add Package Path
	 *
	 * Prepends a parent path to the library, model, helper, and config path arrays
	 *
	 * @param	string
	 * @param 	boolean
	 * @return	void
	 */
	public function module( $module = null , $name = '' ,  $view_cascade = TRUE ){
		
		
		if( !$module ) {
  		return;
		}
		
		/* check if already loaded */
		if (in_array($name, $this->_ci_modules, TRUE)){
			return;
		}
		
		/* if the module class is not laoded yet load it now */
		if ( ! class_exists('MY_Module')){
		  load_class('MY_Module');
		}
		
		require_once($mod_path.'models/'.$path.$model.'.php');
		
		if ($name == '')
		{
			$name = $model;
		}
		
		$CI->$name = new $model();

		$this->_ci_modules[] = $module;
		return;
/*
			
		array_unshift($this->_ci_library_paths, $path);
		array_unshift($this->_ci_model_paths, $path);
		array_unshift($this->_ci_helper_paths, $path);

		$this->_ci_view_paths = array($path.'views/' => $view_cascade) + $this->_ci_view_paths;

		// Add config file path
		$config =& $this->_ci_get_component('config');
		array_unshift($config->_config_paths, $path);
*/
	}
  
  
}

/* End of file MY_Loader.php */
/* Location: ./app/core/MY_Loader.php */


