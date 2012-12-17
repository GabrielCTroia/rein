<div id="top-bar" class="light-grey spacer padding padding-horizontal" style="height:50px">
	
	<p class="left"> Welcome back <?php echo $this->session->userdata['logged_in']['email']; ?></p>

	<a class="right" href="index.php/logout">Log Out</a>
	<div class="clear"></div>
	<div class="">			
		<p>Connect with:</p>
		
		<?php foreach ( $services as $service ): ?>
						
				<?php if( isset( $service->status ) ) : ?>
					
					<span ><?php echo $service->service_name; ?></span>
				
				<?php else: ?>
					
					<a href="/?service=<?php echo $service->service_name; ?>&method=AUTH" class="text-orange"><?php echo $service->service_name; ?></a>
					
				<?php endif; ?>
				
		<?php endforeach; ?>
		
		
	</div>

</div><!-- eof #top-bar --> 

<div class="wrapper grid-width inner lightgrey">

	<div id="wall" class="c3_4 light-grey ">	
	<a href="/?store_posts=true">store the posts</a>
	<div class="spacer"></div>
	
		<?php if( !isset( $posts ) || !$posts) :?>
			
			<p>There are no posts to show!</p>
			
		<?php elseif ( isset( $posts ) && $posts && isset ( $posts->error ) && $posts->error == true ) : ?>
		
			<p><?php echo $posts->error_msg; ?></p>
		
		<?php else : ?>
		
			<?php foreach ($posts as $index=>$post) : ?>
				
				<?php 
					//it gets it as an array from the API
					//and as an object from the DB
					//so there needs to be a conversion made
					if ( is_array( $post ) ) $post = (object) $post;
					
					include( APPPATH . 'views/services/' . $this->Services->get_service_name( $post->service_id ) . '.php' ) 
				
				?>
	
			<?php endforeach; ?>
		
		<?php endif; ?>
				
	</div>

</div>