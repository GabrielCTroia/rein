<?php //helper
    
?>

	<div id="wall">	

		<?php if ( isset ( $error_msg ) && $error_msg ) : ?>

				<p><?php echo $error_msg; ?></p>
		
		<?php else : ?>
  
			<?php foreach ($posts as $index=>$post) : ?>
			   
				<?php 
					//it gets it as an array from the API
					//and as an object from the DB
					//so there needs to be a conversion mad					
					if ( is_array( $post ) ) $post = (object) $post;
          
					include( __DIR__ . '/services/' . $post->service_name . '.php' ); 
				
				?>
				
				<br/>
	
			<?php endforeach; ?>
		
		<?php endif; ?>
				
	</div>