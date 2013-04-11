<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

  if ( !is_array( $posts ) ) $temp_posts = (array)$posts;
          			
		$service_name = $temp_posts[0]->service_name;
		
		$c = 0;
		
		?>
		
		<h1 class="lead"><?php  echo $service_name; ?></h1>
		
		<ul id="thumbnails-<?php echo $service_name; ?>" class="thumbnails row clear">	 
		
		<?php foreach ( $posts as $index=>$post ) : ?>
		   
			<?php 
				//it gets it as an array from the API
				//and as an object from the DB
				//so there needs to be a conversion mad					
				if ( is_array( $post ) ) $post = (object) $post; 
				
				
				//this is not the besyt way to deal with th filetring but works for now!
				// should be more robust
				?>
				
				<?php if( $filter == 'by-service' && $post->service_name != $service_name ): ?>
				
				 </ul>
				 
				 <h1 class="lead"><?php  echo $post->service_name; ?></h1>
				 
				 <ul id="thumbnails-<?php echo $post->service_name; ?>" class="thumbnails row clear">
				 
				 <?php $c = 0; ?>
				
				<?php endif; ?>
      
      
      
        
      <li class="layout-<?php echo $post->service_name; ?> span<?php echo $thumb_span; ?>" style="<?php echo ( $c % ( $thumb_span + 1) == 0 ) ? 'clear: left' : ''; ?>">  
        
        <div class="thumbnail">

			    <?php	include( __DIR__ . '/service_templates/' . $post->service_name . '.php' ); ?>
			  
        </div>
			
      </li>
      
      
      <?php 
      
        $service_name = $post->service_name; 
        					
				$c++;
        
      ?>

		<?php endforeach; ?>
	
	</ul>