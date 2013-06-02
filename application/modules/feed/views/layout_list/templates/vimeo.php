<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>		
  
  <div class="span9">
  	
    <div style="width:100%; padding-bottom:56%;position:relative;">
  		 
  		 <iframe src="http://player.vimeo.com/video/<?php echo $post->value; ?>" style="width:100%; height: 100%;position:absolute;" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
  		 
  		 
  		 
<!--   		 </a><p><a href="http://vimeo.com/<?php echo $post->value; ?>">  -->
<!--   		 <a href="http://vimeo.com/<?php echo $post->param->user_id; ?>"><?php echo $post->param->user_name; ?></a> on <a href="http://vimeo.com">Vimeo</a>.</p> -->

        <?php //echo $post->caption; ?>
        
  		</div>
  		
  </div>
  
  <div class="span3">
    
    <span class="date" title="<?php echo $post->favorited_date; ?>"><?php echo $post->favorited_date; ?></span>
    
  </div>