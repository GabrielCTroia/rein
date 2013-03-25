<?php //helper

$post->param = json_decode( $post->param ); 

?>		
  		
		<div class="wrapper">
			
			<?php if ( $layout == 'list' ) : ?>
			
			 <div class="span8">
			
  			<div style="width:100%; padding-bottom:56%;position:relative;">
  			 <iframe src="http://player.vimeo.com/video/<?php echo $post->value; ?>" style="width:100%; height: 100%;position:absolute;" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></a><p><a href="http://vimeo.com/<?php echo $post->value; ?>"><?php echo $post->param->title; ?> from <a href="http://vimeo.com/<?php echo $post->param->user_id; ?>"><?php echo $post->param->user_name; ?></a> on <a href="http://vimeo.com">Vimeo</a>.</p>
  			</div>

  		 </div>	
  			
  		 <div class="span8">
    		 
    		 
    		 
  		 </div>
  			
			<?php else : ?>
			
  			<a href="http://player.vimeo.com/video/<?php echo $post->value; ?>" rel="shadowbox['all']">
  			 <img src="<?php echo $post->param->thumbnail; ?>">
  		  </a>
  		  
  		  <p><?php echo $post->param->title; ?> from <a href="http://vimeo.com/<?php echo $post->param->user_id; ?>"></a></p>
						
			<?php endif; ?>

		</div>