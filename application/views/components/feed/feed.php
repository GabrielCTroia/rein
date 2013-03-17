<?php //helper
    
    //set the default span for the thumnnail 
    $tumb_span = 3;
    
?>

	<div id="feed">	
  	
		<?php if ( isset ( $error_msg ) && $error_msg ) : ?>

				<p><?php echo $error_msg; ?></p>
		
		<?php else : ?>
		   
		  <div class="btn-group pull-right">
        <button class="btn">Left</button>
        <button class="btn">Middle</button>
        <button class="btn">Right</button>
      </div>  
		  
		  
		  
	    <ul class="thumbnails row clear">	  
  
			<?php foreach ( $posts as $index=>$post ) : ?>
			   
				<?php 
					//it gets it as an array from the API
					//and as an object from the DB
					//so there needs to be a conversion mad					
					if ( is_array( $post ) ) $post = (object) $post; ?>
          
        <li class="layout-<?php echo $post->service_name; ?> span<?php echo $tumb_span; ?>" style="<?php echo ( $index % ( $tumb_span + 1) == 0 ) ? 'clear: left' : ''; ?>">  
          
          <div class="thumbnail">

				    <?php	include( __DIR__ . '/services/' . $post->service_name . '.php' ); ?>
				  
          </div>
				
        </li>
	
			<?php endforeach; ?>
		
		  </ul>
		
		<?php endif; ?>
				
	</div>
	