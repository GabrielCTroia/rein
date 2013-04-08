<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
  
/*   var_dump($post); */
  
?>

  <div class="span9">
    
    <?php foreach( $post->thumbnails as $thumb ) : ?>
    
      <a href="<?php echo $post->source; ?>" rel="shadowbox['all']"><img src="<?php echo $thumb; ?>" /></a> 
      
    <?php endforeach; ?>
  		
  </div>
		  
  <div class="span3">
	
    <span class="date" title="<?php echo $post->favorited_date; ?>"><?php echo $post->favorited_date ?></span>
    
  </div>