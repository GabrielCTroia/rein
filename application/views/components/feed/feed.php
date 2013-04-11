<?php //helper
    
    //set the default span for the thumnnail 
    $thumb_span = 3;
    
    $segments = $this->uri->uri_to_assoc(1);
    
?>

	<div id="feed">	
  	
		<?php if ( isset ( $error_msg ) && $error_msg ) : ?>

				<p><?php echo $error_msg; ?></p>
		
		<?php else : ?>
		  
		  
		  <header class="clearfix"> 

        

  		  <div class="btn-group pull-right">
          <a href="<?php echo Util::get_new_url( $segments , 'layout' , 'grid' ); ?>" class="btn">Grid</a>
          <a href="<?php echo Util::get_new_url( $segments , 'layout' , 'list' ); ?>" class="btn">List</a>
        </div>  

        <div class="dropdown-filter dropdown pull-right">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Filter<b class="caret"></b></a>
          <ul class="dropdown-menu">
          
            <li><a href="<?php echo Util::get_new_url( $segments , 'filter' , 'by-service' ); ?>">By Service</a></li>
            <li><a href="<?php echo Util::get_new_url( $segments , 'filter' , 'by-favorited-date' ); ?>">By Favorited Date</a></li>
          </ul>
        </div>

		  </header>
	     
      <?php switch( $filter ) :
      
             case 'by-service' : ?>
         
      		<?php if ( !is_array( $posts ) ) $temp_posts = (array)$posts;
          			
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
          
          				    <?php	include( __DIR__ . '/services/' . $post->service_name . '.php' ); ?>
          				  
                    </div>
          				
                  </li>
                  
                  
                  <?php 
                  
                    $service_name = $post->service_name; 
                    					
          					$c++;
                    
                  ?>
          	
          			<?php endforeach; ?>
          		
          		</ul>             
         
       <?php break; ?>
         
       <?php default : ?>
       
          <ul id="thumbnails-all" class="thumbnails row clear">	 
          			
      			<?php foreach ( $posts as $index => $post ) : ?>
      			   
      				<?php 
      					//it gets it as an array from the API
      					//and as an object from the DB
      					//so there needs to be a conversion mad					
      					if ( is_array( $post ) ) $post = (object) $post; ?>
              
              <li class="layout-<?php echo $post->service_name; ?> span<?php echo $thumb_span; ?>" style="<?php echo ( $index % ( $thumb_span + 1) == 0 ) ? 'clear: left' : ''; ?>">  
                
                <div class="thumbnail">
                  
                  <?php echo 'favorited: ' . $post->favorited_date; ?>
                  
      				    <?php	include( __DIR__ . '/services/' . $post->service_name . '.php' ); ?>
      				  
      				    <?php echo 'p_id: ' . $post->post_foreign_id ?>
      				  
                </div>
      				
              </li>
              
            <?php endforeach; ?>
      		
      		</ul>
      		
      		<?php if( $current_page > 1 ) : ?>
        	
        		<a href="<?php echo Util::get_new_url( $segments , 'page' , $current_page - 1 ); ?>">Prev</a>
          
          <?php endif; ?>
          
          <?php if( $current_page - 1 < count( $pages ) )  : ?>    		
      		  
      		  <a href="<?php echo Util::get_new_url( $segments , 'page' , $current_page + 1 ); ?>">Next</a>
      		
      		<?php endif; ?>  
      		  
      		  
       <?php break; ?>
       
      <?php endswitch; ?>
	    
	    <?php //this should be in a separete module  $post->p_id;   	    
	    ?>

	     		
		<?php endif; ?>
				
	</div>
	