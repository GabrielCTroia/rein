<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <header> 
    		  
    <form action="<?php echo $this->router->new_method( 'search' ); ?>" class="navbar-form pull-left">
      
      <input type="text" class="search-query" name="term" placeholder="Search">
      
    </form>		    		  
    		  
    <div class="navbar pull-right">		  
      
      <ul class="nav">

	      <li class="dropdown-filter dropdown">
              
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo pretty_name( $this->router->get_arg_value( 'service-name' , 'All Services' ) ); ?><b class="caret"></b></a>
            
            <ul class="dropdown-menu">
                
              <li><a href="<?php echo $this->router->new_args(); ?>">All Services</a></li>  
                
              <?php foreach( $modules['active_services'] as $service ): ?>
                
                <li><a href="<?php echo $this->router->new_args( array( 'filter' => 'by-service' , 'service-name' => $service->service_name , 'page' => '1') ); ?>"><?php echo $service->service_name; ?></a></li>
  
              <?php endforeach; ?>

            </ul>
          
	      </li>
      
	      <li class="dropdown-filter dropdown">
              
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo pretty_name( $this->router->get_arg_value( 'category-name' , 'All Categories' ) ); ?><b class="caret"></b></a>
          
          <ul class="dropdown-menu">
              
            <li><a href="<?php echo $this->router->new_args(); ?>">All Categories</a></li>  
              
            <?php foreach( $categories as $category ): ?>
              
              <li><a href="<?php echo $this->router->new_args( array( 'filter' => 'by-category' , 'category-name' => $category->category , 'page' => '1') ); ?>"><?php echo $category->category; ?></a></li>

            <?php endforeach; ?>


          </ul>
          
	      </li> 
	      
        <li class="dropdown-filter dropdown">
          
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo pretty_name( $this->router->get_arg_value( 'order-by' , 'By Favorited Date' ) ); ?><b class="caret"></b></a>
          
          <ul class="dropdown-menu">
            <li><a href="<?php echo $this->router->switch_args( array( 'order-by' => 'favorited-date' , 'page' => 1 ) ); ?>">By Favorited Date</a></li>
            <li><a href="<?php echo $this->router->switch_args( array( 'order-by' => 'collected-date' , 'page' => 1 ) ); ?>">By Collected Date</a></li>
          </ul>
          
	      </li>
	      
      </ul>
      
      <li class="btn-group pull-right">
          
          <a href="<?php echo $this->router->new_args( array( 'layout' => 'grid' ) ); ?>" class="btn btn-grid" title="Grid Layout"><i class="icon-th"></i></a>
          <a href="<?php echo $this->router->new_args( array( 'layout' => 'list' ) ); ?>" class="btn btn-list" title="List Layout"><i class="icon-th-list"></i></a>
          
      </li>  

    </div>
    
  </header>