<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <div id="layout-grid" class="grid row clear">	 
  	
  	<?php if( empty( $posts ) ) : ?>
    
      there are no posts
    
    <?php else : ?>			

    	<?php foreach ( $posts as $index => $post ) : ?>
    	   
    		<?php 
    			//it gets it as an array from the API
    			//and as an object from the DB
    			//so there needs to be a conversion mad					
    			if ( is_array( $post ) ) $post = (object) $post; ?>
    			
        <div class="thumb template-<?php echo $post->template; ?> span3">  
          <?php //var_dump( $post ); ?>  
    		  <?php	include( __DIR__ . '/templates/default.php' ); ?>
    		
        </div>
        
      <?php endforeach; ?>
  
  <?php endif; ?>
  
  </div>