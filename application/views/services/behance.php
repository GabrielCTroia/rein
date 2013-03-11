<?php //helper

$post->param = json_decode( $post->param ); 

?>
	<article class="layout-instagram clearfix">
		
		<a href="<?php echo $post->source; ?>">
  		<div class="left">
  <!-- 			<img width="60" src="<?php echo APPPATH . "images/icons/instagram-icon.png" ?>"> -->
  		</div>
  		
  		<div class="wrapper">
  			
  <!-- 			<h4>Post #: <?php echo $index + 1?></h4> -->
  			<span>Created Date <?php echo $post->created_date; ?></span>
  			<br/>	
  			
  <!-- 			<img class="" src="<?php// echo $post->param->profile_image; ?>"/> -->
              
  			<span class="spacer spacer-text"><?php echo $post->param->user_name; ?></span>
  			<img class="spacer spacer-text full-width" src="<?php echo $post->value; ?>" />
  			
  			
  			
  			<?php if ( isset( $post->post_id ) ) : ?>
  <!-- 					<p>post id = <?php echo $post->post_id; ?></p> -->
  			<?php else : ?>
  <!-- 					<p>post (foreign) id = <?php echo $post->post_foreign_id; ?></p> -->
  			<?php endif; ?>
  		</div>
		</a>
	</article> 
	<br/><br/>