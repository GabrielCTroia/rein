<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


	<a href="<?php echo $post->source; ?>" class="wrapper" rel="shadowbox['all']">
	 
	 <img src="<?php echo end( $post->thumbnails ); ?>" />
	 
	 
	 <?php if( !empty( $post->caption ) ) : ?>

  	 <div class="caption"> 
  	   <h5><?php echo $post->caption; ?></h5>
  	 </div>
	 
	 <?php endif; ?>
	 
  </a>
  
  <div class="post-info">

  	<div class="pull-left">
  	   
  	  <a href="<?php echo $post->source; ?>" target="_blank">View</a>
  	
  	</div>
  	
  	<div class="pull-right">
    	
    	<span class="date" title="<?php echo $post->favorited_date; ?>"><?php echo ago( $post->favorited_date ); ?></span>
    	
  	</div>
  	
  </div>