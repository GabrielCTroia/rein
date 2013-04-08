<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once( MODULES_PATH . 'Component_Controller.php' );

class Feed extends Component_Controller {


	public $module_name = 'feed';
	
	//caches the default url for this component
	private $default_url = null;
	
	
	
	
	
	
	
	public function component(){
	  
	  $this->default_url = $this->router->new_method( 'show' );
	  	
		if( !$this->router->curr_method ){
  		
  		redirect( $this->default_url );
  		
		}

	  //load everything I need	
	 	$this->load->model( 'Posts_model' , '' , false );
	 	
	 	$this->Posts_model->init( $this->userdata->u_id );
    	 		 	
	 	//load the parent component - cannot be in the construct because it happens to soon then
		parent::component();	 	
  	
	}
	
	
  	
  
  public function show(){
    
    //this is the where clause iin the query_feed  
    $where = array();  
      
    //get all the needed arguments	 	
    $order_by = $this->router->get_arg_value( 'order-by' ); 	 	
    
    $service_name = $this->router->get_arg_value( 'service-name' );

    if( $service_name ){
      
      $where[ 's.service_name' ] = $service_name;
      
    }
    
    $category_name = $this->router->get_arg_value( 'category-name' );

    if( $category_name ){
      
      $where[ 'p.category' ] = $category_name;
      
    }
    
    //get the pagination right
    $limit = $this->router->get_arg_value( 'limit' , 20 );	
    
      $current_page = $this->router->get_arg_value( 'page' , 1 );
    
      $start = ( $current_page - 1 ) * $limit;
      
      $start_limit = $start . ' , ' . $limit;

    
    //pass the datas
    $this->data['posts'] = $this->_format( $this->query_feed( $order_by , $start_limit , $where ) );	 	
    
/*     $total_posts = $this->query_feed( $order_by , 0 , $where , true ) ; */
    
/*     var_dump(  reset(reset($total_posts)) ); */
    
    $this->data['pages'] = $this->get_pages( $limit );
    
    $this->data['current_page'] = $current_page;
    
    $this->data['layout'] = $this->router->get_arg_value( 'layout' , 'grid' );
   
   
    $this->data['categories'] = $this->Posts_model->get_active_categories();
    
    
   
   
    //load the active_services module with raw data
    $this->load_module( 'active_services' , 'raw' , true );
    	 	
    $this->load->view( 'feed_default' , $this->data );
    
  }
  
  
      private function get_pages( $limit ){
        
        $total_posts = $this->Posts_model->get_total_posts();
        
        $pages = ceil( $total_posts / $limit );
        
        $current_page  = $this->router->get_arg_value( 'page' , 1 );
            
        $start = ( $current_page - 1 ) * $limit;
            
        if( ( $current_page - 1 ) > count( $pages ) ) {
              
          $data['error'] = true;
              
          $data['error_msg'] = "The page doesn't exist";
              
        }
            
        //make sure there's no negative page
        if( $start < 0 ) redirect( $this->get_new_url( 'page' , 1 ) );
        
        
        return $pages;
          
      }
  
  
  
      private function query_feed( $order_by , $start_limit , $where = array() , $count_only = false ){
      
        $order_dir = null;
              
        switch( $order_by ) {
          
          case 'by-service' : 
            
            $order_by = ' ups.FK_s_id , p.favorited_date ';
                              
            break;

          case 'favorited-date' : 
          
            $order_by = 'p.favorited_date';
/*             $order_dir = 'ASC'; */

            break;
            
          case 'collected-date' :
            
            $order_by = 'ups.collected_date DESC , p.p_id';
            $order_dir = 'DESC';
            
            break;  
            
          default : 
          
            $order_by = 'p.favorited_date';
                            
            break;                    
          
        }        

          
        $query = array( 'where'     => $where 
                      , 'limit'     => $start_limit 
                      , 'order_by'  => $order_by 
                      , 'order_dir' => $order_dir
                      );  
                      
          
        return $this->Posts_model->get_posts( $query  , $count_only );
        
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
        	
        	$post->thumbnails = json_decode( $post->thumbnails , true );
            	
        }
    	
        return $posts;
    	
    	}
    	
      /* 
    	 * adds the template type for each service  
    	 */
    	 private function _set_template( $post ){
    	   
    	   switch( $post->service_name ){	

            case 'behance' : $post->template = 'behance';
          	 break;
                      	
          	case 'vimeo' : $post->template = 'vimeo';
          	 break;
          	 
          	case 'youtube' : $post->template = 'youtube';
          	 break;          	 
          	 
          	default : $post->template = 'default';
          	 break;
        	}
    	 
    	 }
    	 
    	 //not used for now
    	 private function _json_decode( $post ){
    	   
    	   $post->thumbnails = json_decode( $post->thumbnails , true );
    	 
    	 }
    	 
  	
  	
  public function delete(){

		if( !empty( $this->router->curr_args['id'] ) ){
			
			$this->Posts_model->trash_posts( $this->router->curr_args['id'] );	

		}
		
		//needs to show a msg - every action needs to be logged with a success msg or a failed msg
		redirect( $this->default_url );
		
	}	
	
	
	public function search(){
  	
  	 	 	
    
/*     $q = $this->router->get_args_value(); */
    
    $q = $this->input->get('term');
    

    
/*     return; */
        
    $this->data['posts'] = $this->_format( $this->Posts_model->search_posts( $q ) );
/*     var_dump(  reset(reset($total_posts)) ); */

/*     var_dump( $this->data['posts'] ); */

    $current_page = $this->router->get_arg_value( 'page' , 1 );
    
    $limit = $this->router->get_arg_value( 'limit' , 20 );
    
    $this->data['pages'] = $this->get_pages( $limit );
    
    $this->data['current_page'] = $current_page;
    
    $this->data['layout'] = $this->router->get_arg_value( 'layout' , 'grid' );
   
   
    $this->data['categories'] = $this->Posts_model->get_active_categories();
    
    
   
   
    //load the active_services module with raw data
    $this->load_module( 'active_services' , 'raw' , true );
    	 	
    $this->load->view( 'feed_default' , $this->data );
  	
	}
  	
  	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */