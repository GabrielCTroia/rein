<?php //helper

$post->param = json_decode( $post->param ); 

?>
	<article class="layout-instagram clearfix">
		
  		<div class="left">
  <!-- 			<img width="60" src="<?php echo APPPATH . "images/icons/instagram-icon.png" ?>"> -->
  		</div>
  		
  		<div class="wrapper">
  			
  <!-- 			<h4>Post #: <?php echo $index + 1?></h4> -->
  			<span>Created Date <?php echo $post->created_date; ?></span>
  			<br/>	
  			
  			<iframe src="http://player.vimeo.com/video/<?php echo $post->value; ?>" width="500" height="281" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe> <p><a href="http://vimeo.com/<?php echo $post->value; ?>"><?php echo $post->param->title; ?></a> from <a href="http://vimeo.com/<?php echo $post->param->user_id; ?>"><?php echo $post->param->user_name; ?></a> on <a href="http://vimeo.com">Vimeo</a>.</p>

  		</div>
  		
  	<a href="<?php echo $post->source; ?>" target="_blank">View project</a>
	</article>