<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


/*  var_dump($post); */
?>


	<a href="<?php echo $post->source; ?>" class="wrapper" >
	 
	 <img src="<?php echo end( $post->thumbnails ); ?>" />
	 
	 <?php if( !empty( $post->caption ) ) : ?>

  	 <div class="caption"> 
  	   <h5><?php echo $post->caption; ?></h5>
  	 </div>
	 
	 <?php endif; ?>
	 
  </a>
  
  <div class="post-info hidden">

  	<div class="pull-left">
  	   
  	  <a href="<?php echo $post->source; ?>" target="_blank">View</a>
  	
  	</div>
  	
  	<div class="pull-right">
    	
    	<span class="date" title="<?php echo $post->favorited_date; ?>"><?php echo ago( $post->favorited_date ); ?></span>
    	
    	<a href="<?php echo $this->router->new_method( 'delete' , array( "id" => $post->post_foreign_id ) ); ?>"><i class="icon-remove-sign"></i></a>
    	
  	</div>
  	
  </div>