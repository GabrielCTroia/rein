<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <ul id="thumbnails-all" class="thumbnails row clear">	 
  			
  	<?php foreach ( $posts as $index => $post ) : ?>
  	   
  		<?php 
  			//it gets it as an array from the API
  			//and as an object from the DB
  			//so there needs to be a conversion mad					
  			if ( is_array( $post ) ) $post = (object) $post; ?>
      
      <li class="layout-<?php echo $post->service_name; ?> span<?php echo $thumb_span; ?>" style="<?php echo ( $index % ( $thumb_span + 1) == 0 ) ? 'clear: left' : ''; ?>">  
        
        <div class="thumbnail">
          
  		    <?php	include( __DIR__ . '/service_templates/' . $post->service_name . '.php' ); ?>
  		  
  		    <?php echo 'p_id: ' . $post->p_id ?>
  		  
        </div>
  		
      </li>
      
    <?php endforeach; ?>
  
  </ul>
  
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
  

      
	