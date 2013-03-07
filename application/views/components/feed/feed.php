	<div id="wall">	
	  
		<?php if ( isset ( $error ) && $error ) : ?>
		  
				<p><?php echo $error_msg; ?></p>
		
		<?php else : ?>
  
			<?php foreach ($posts as $index=>$post) : ?>
			   
				<?php 
					//it gets it as an array from the API
					//and as an object from the DB
					//so there needs to be a conversion made
					if ( is_array( $post ) ) $post = (object) $post;
					
					include( APPPATH . 'views/services/' . $post->service_name . '.php' ) 
				
				?>
	
			<?php endforeach; ?>
		
		<?php endif; ?>
				
	</div>