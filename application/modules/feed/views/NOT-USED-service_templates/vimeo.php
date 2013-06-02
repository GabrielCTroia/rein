<?php //helper

$post->param = json_decode( $post->param ); 

$post->thumbnails = json_decode( $post->thumbnails );
?>		
  		
		<div class="wrapper">
			
			<?php if ( $layout == 'list' ) : ?>
			
			 <span><?php echo 'Faved: ' . ago( $post->favorited_date ); ?></span>
			
			 <div class="span9">
			
  			<div style="width:100%; padding-bottom:56%;position:relative;">
  			 <iframe src="http://player.vimeo.com/video/<?php echo $post->value; ?>" style="width:100%; height: 100%;position:absolute;" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></a><p><a href="http://vimeo.com/<?php echo $post->value; ?>"><?php echo $post->param->title; ?> from <a href="http://vimeo.com/<?php echo $post->param->user_id; ?>"><?php echo $post->param->user_name; ?></a> on <a href="http://vimeo.com">Vimeo</a>.</p>
  			</div>

  		 </div>	
  			
  		 <div class="span3">
    		 
    		 
    		 
  		 </div>
  			
			<?php else : ?>
			
			  <span><?php echo 'Faved: ' . ago( $post->favorited_date ); ?></span>
			
  			<a href="http://player.vimeo.com/video/<?php echo $post->value; ?>" rel="shadowbox['all']">
  			 <img src="<?php echo end($post->thumbnails); ?>">
  		  </a>
  		  
<!--   		  <p><?php echo $post->caption; ?> from <a href="http://vimeo.com/<?php echo $post->param->user_id; ?>"></a></p> -->
						
			<?php endif; ?>

		</div>