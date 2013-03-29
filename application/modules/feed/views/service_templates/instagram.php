<?php //helper

$post->param = json_decode( $post->param ); 

$post->owner = json_decode( $post->owner ); 

?>
	
	<div class="wrapper">
	
    <?php if ( $layout == 'list' ) : ?>
      
      <div class="span9">
        
        <span><?php echo 'Liked: ' . ago( $post->favorited_date ); ?></span>
        
        <span class="spacer spacer-text"><?php echo $post->favorited_date; ?></span>
        <br/>
    
    		<a href="<?php echo $post->value; ?>" rel="shadowbox['all']"><img class="" src="<?php echo $post->value; ?>" /></a>

      </div>
      
      <div class="span3">
        
        <span class="spacer spacer-text"><?php echo $post->owner->user_name; ?></span>
        
      </div>
		
		<?php else : ?>
		
		  <span><?php echo 'Liked: ' . ago( $post->favorited_date ); ?></span>
		
		  <a href="<?php echo $post->value; ?>" rel="shadowbox['all']"><img class="" src="<?php echo $post->value; ?>" /></a>
    		
    	<span class="spacer spacer-text"><?php echo $post->owner->user_name; ?></span>
		  
		<?php endif; ?>
		
	</div>