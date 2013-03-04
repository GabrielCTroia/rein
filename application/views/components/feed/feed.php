	<div id="wall">	
	
	  <a href="/?store_posts=true">store the posts</a>
	  <div class="spacer"></div>
	  
		<?php if ( isset ( $error_msg ) && $error_msg ) : ?>
		
				<p><?php echo $error_msg; ?></p>
		
		<?php elseif( !isset( $posts ) || !$posts ) :?>

			<p>There are no posts to shows!</p>
		
		<?php else : ?>
		  
			<?php foreach ($posts as $index=>$post) : ?>

				<?php 
					//it gets it as an array from the API
					//and as an object from the DB
					//so there needs to be a conversion made
					if ( is_array( $post ) ) $post = (object) $post;
					
					include( APPPATH . 'views/services/instagram.php' ) 
				
				?>
	
			<?php endforeach; ?>
		
		<?php endif; ?>
				
	</div>