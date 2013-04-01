<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <div id="layout-list" class="list clear">	 
  			
  	<?php foreach ( $posts as $index => $post ) : ?>
  	   
  		<?php 
  			//it gets it as an array from the API
  			//and as an object from the DB
  			//so there needs to be a conversion mad					
  			if ( is_array( $post ) ) $post = (object) $post; ?>
      
      <div class="item layout-<?php echo $post->service_name; ?> row" >  
        
  		    <?php	include( __DIR__ . '/templates/' . $post->template . '.php' ); ?>
  		
      </div>
      
    <?php endforeach; ?>
  
  </div>
  
  <?php if( $pages > 1 ) : ?>
  
    <div class="pagination pull-right">
      <ul>
  
        <?php if( $current_page > 1 ) : ?>
          <li><a href="<?php echo Util::get_new_url( $segments , 'page' , $current_page - 1 ); ?>">Prev</a></li>
      	<?php endif; ?>
      	
      	<?php for( $i = 1; $i < $pages + 1; $i++ ) : ?>
          <li><a href="<?php echo Util::get_new_url( $segments , 'page' , $i ); ?>"><?php echo $i; ?></a></li>
        <?php endfor; ?>
          
        <?php if( $current_page - 1 < count( $pages ) )  : ?>    		
          <li><a href="<?php echo Util::get_new_url( $segments , 'page' , $current_page + 1 ); ?>">Next</a></li>
        <?php endif; ?>  
      
      </ul>
      
    </div>
  
  <?php endif; ?>
