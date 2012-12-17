	<?php $post->param = json_decode($post->param); ?>
				
	
	<article class="layout-twitter spacer spacer-double c1_1 clearfix">
		<div class="left">
			<img  src="<?php echo APPPATH . "images/icons/twitter_60x60px.png" ?>">
		</div>
		
		<div class="wrapper column c2_3">
			
			<h4>Post #: <?php echo $index + 1?></h4>
			<span>Created Date <?php echo $post->created_date; ?></span>
			<br/>					
			<img src="<?php echo $post->param->profile_image; ?>"/>
			
			<span class="spacer spacer-text"><?php echo $post->param->user_name; ?></span>
			<p class="spacer spacer-text"><?php echo $post->value; ?></p>
			
			<span class="right"><?php echo $post->source; ?></span>
			
			<?php if ( isset( $post->post_id ) ) : ?>
					<p>post id = <?php echo $post->post_id; ?></p>
			<?php else : ?>
					<p>post (foreign) id = <?php echo $post->post_foreign_id; ?></p>
			<?php endif; ?>
		</div>
	</article>