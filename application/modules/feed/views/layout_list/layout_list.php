<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <div id="layout-list" class="container list clear">	 
  			
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