<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>		
  
  <div class="span9">
  	
    <div style="">
  		 
  		 <iframe width="560" height="315" src="http://www.youtube.com/embed/<?php echo $post->value; ?>" frameborder="0" allowfullscreen></iframe>
    
    </div>
  		
  </div>
  
  <div class="span3">
    
    <span class="date" title="<?php echo $post->favorited_date; ?>"><?php echo $post->favorited_date; ?></span>
    
  </div>