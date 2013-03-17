<?php //helper

$post->param = json_decode( $post->param ); 

?>
  		
  		<div class="wrapper">

  			<a href="<?php echo $post->source; ?>" rel="shadowbox['all']"><img src="<?php echo $post->param->thumbnail; ?>" /></a>
  			
  			<span class="spacer spacer-text"><?php echo $post->param->user_name; ?></span>
  		
  			<a href="<?php echo $post->source; ?>" target="_blank">View project</a>
  			
  		</div>
  		
  	
