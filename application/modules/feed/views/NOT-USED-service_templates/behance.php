<?php //helper

/* var_dump( $post->param ); */

$post->param = json_decode( $post->param ); 

$post->thumbnails = json_decode( $post->thumbnails );


/* var_dump($post); */
/* $post->owner = json_decode( $post->owner ); */

/* $post->owner = $post->owner[0]; */

?>
  		
		<div class="wrapper">
		
		  <div class="span9">
			 
			  <span><?php echo 'Appreciated: ' . ago( $post->favorited_date ); ?></span>
			 
			  <br/>
  			<a href="<?php echo $post->source; ?>" rel="shadowbox['all']"><img src="<?php echo $post->param->thumbnail; ?>" /></a>
  			
  			<br/>
  			<a href="<?php echo $post->source; ?>" target="_blank">View project</a>		  
  		
		  </div>
		  
		  <div class="span3">
  		  
<!--   		  <img src="<?php echo end($post->owner->images); ?>" style="width:50px;height:auto;"/> -->
  		  
  		  <ul>
<!--     		  <li><a href="#"><?php echo $post->owner->display_name; ?></a>, <span><?php echo $post->owner->country; ?></span></li> -->
<!--     		  <li><span><?php echo implode( ', ' , $post->owner->fields ); ?></span></li> -->
  		  </ul>
  		  
		  </div>

			
		</div>
  		
  	
