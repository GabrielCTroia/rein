<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div id="feed">	
	
	   <?php if ( isset ( $error_msg ) && $error_msg ) : ?>

				<p><?php echo $error_msg; ?> Please <a href="/home/settings/tab/connect">connect</a> with some services!</p>
		
		<?php else : ?>
		
		  <header class="clearfix"> 
		    		  
	      <form action="<?php echo $this->router->new_method( 'search' ); ?>" class="navbar-form pull-left">
          
          <input type="text" class="search-query" name="term" placeholder="Search">
          
        </form>		    		  
		    		  
		    <div class="navbar pull-right">		  
		      
		      <ul class="nav">
  
  		      <li class="navbar-text"><strong>Filter</strong></li>
  
  		      <li class="dropdown-filter dropdown">
                  
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">By Service<b class="caret"></b></a>
                
                <ul class="dropdown-menu">
                    
                  <li><a href="<?php echo $this->router->new_args(); ?>">All</a></li>  
                    
                  <?php foreach( $modules['active_services'] as $service ): ?>
                    
                    <li><a href="<?php echo $this->router->new_args( array( 'filter' => 'by-service' , 'service-name' => $service->service_name , 'page' => '1') ); ?>"><?php echo $service->service_name; ?></a></li>
      
                  <?php endforeach; ?>

                </ul>
              
  		      </li>
          
  		      <li class="dropdown-filter dropdown">
                  
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">By Category<b class="caret"></b></a>
              
              <ul class="dropdown-menu">
                  
                <li><a href="<?php echo $this->router->new_args(); ?>">All</a></li>  
                  
                <?php foreach( $categories as $category ): ?>
                  
                  <li><a href="<?php echo $this->router->new_args( array( 'filter' => 'by-category' , 'category-name' => $category->category , 'page' => '1') ); ?>"><?php echo $category->category; ?></a></li>
    
                <?php endforeach; ?>
    
    
              </ul>
              
  		      </li> 
  		      
		        <li class="dropdown-filter dropdown">
              
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Order<b class="caret"></b></a>
              
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
		  
		  <?php require_once( __DIR__ . '/layout_' . $layout . '/layout_' . $layout . '.php' ); ?>
		  
		  <?php if( $pages > 1 ) : ?>
  
        <div class="pagination pull-right">
          <ul>
      
            <?php if( $current_page > 1 ) : ?>
              <li><a href="<?php echo $this->router->switch_args( array( 'page' => $current_page - 1 ) ); ?>">Prev</a></li>
          	<?php endif; ?>
          	
          	<?php for( $i = 1; $i < $pages + 1; $i++ ) : ?>
              <li class="<?php echo ( $current_page == $i ) ? 'active' : ''; ?>"><a href="<?php echo $this->router->switch_args( array( 'page' => $i ) ); ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
              
            <?php if( $current_page - 1 < count( $pages ) )  : ?>    		
              <li><a href="<?php echo $this->router->switch_args( array( 'page' => $current_page + 1 ) ); ?>">Next</a></li>
            <?php endif; ?>  
          
          </ul>
          
        </div>
      
      <?php endif; ?>
		  
		  
		<?php endif; ?>
	
	</div><!-- #feed -->