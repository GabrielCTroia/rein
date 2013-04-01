<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( MODULES_PATH . 'Component_Controller.php' );

class Feed extends Component_Controller {

	
	function __construct() {
	
		parent::__construct();

	}  


	public function component(){
  	
  	$data =& $this->data;
  	
  	$data['layout'] = $this->get_url_param( 'layout' , 'grid' );  	
    
    $this->load->model( 'Posts_model' , '' , false );
    
    //make sure the Posts_model init passes with no errors
    if ( $this->Posts_model->init( $this->userdata->u_id ) !== false ) {
      
      $specifics = array();
      
      if( $service_name = $this->get_url_param( 'service' ) ){

        $specifics[] = 's.service_name = ' . $service_name;
          
      }
      
      $total_posts = $this->Posts_model->get_total_posts();
      
      
      $limit = $this->get_url_param( 'limit' , 20 );
      
            
      $posts = array();
      
      switch( $this->get_url_param( 'filter' , '' ) ) {
        
        case 'by-service' : 
          
          $order_by = ' ups.FK_s_id , p.favorited_date ';
                          
          $posts_query = array( 'order_by' => $order_by );
                            
        break;
          
        default : 
        

          
          $order_by = 'p.favorited_date';
              
          $data['pages'] = $pages = ceil( $total_posts / $limit );
      
          $data['current_page'] = $current_page  = $this->get_url_param( 'page' , 1 );
          
          
          $start = ( $current_page - 1 ) * $limit;
          
          if( ( $current_page - 1 ) > count( $pages ) ) {
            
            $data['error'] = true;
            
            $data['error_msg'] = "The page doesn't exist";
            
          }
          
          //make sure there's no negative page
          if( $start < 0 ) redirect( $this->get_new_url( 'page' , 1 ) );
          
          $posts_query = array( 'where' => $specifics , 'limit' =>  $start . ' , ' . $limit , 'order_by' => $order_by );
                  
        break;                    
        
      }
      
      
      //add the template type
      $data['posts'] = $this->_format( $this->Posts_model->get_posts( $posts_query ) );

      $data['filter'] = $this->get_url_param( 'filter' );
       
    }
    
    //write the error msg
    if( $data['error'] = $this->Posts_model->error ) {
      
      $data['error_msg'] = $this->Posts_model->error_msg;
        
    }
    
    
  	
  	$this->load->view( 'feed_default' , $this->data );
  	
	}
	
	
	/* 
	 * add the needing fields 
	 */
	private function _format( $posts ){
	   
	  if( empty( $posts ) ) {
  	  
  	  return false;
  	  
	  }
	 
	  foreach( $posts as $post ) {
    	
    	$this->_set_template( $post );
    	
    	$this->_json_decode( $post );
        	
    }
	
    return $posts;
	
	}
	
  /* 
	 * adds the template type for each service  
	 */
	 private function _set_template( $post ){
	   
	   switch( $post->service_name ){	
      	
      	case 'vimeo' : $post->template = 'vimeo';
      	 break;
      	 
      	default : $post->template = 'default';
      	 break;
    	}
	 
	 }
	 
	 private function _json_decode( $post ){
	   
	   $post->thumbnails = json_decode( $post->thumbnails , true );
	 
	 }
  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */