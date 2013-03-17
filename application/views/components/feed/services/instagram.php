<?php //helper

$post->param = json_decode( $post->param ); 

?>
	
	<div class="wrapper">
  	
		<a href="<?php echo $post->value; ?>" rel="shadowbox['all']"><img class="" src="<?php echo $post->value; ?>" /></a>
		
		<span class="spacer spacer-text"><?php echo $post->param->user_name; ?></span>
		
	</div>