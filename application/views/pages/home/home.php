<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="container well">

  <?php   
    
    
    
/*     if( ['feed'] ) echo "Da"; */
    
/*     if( $this->Components_model->url() ) */
      
      $this->Components_model->show( 'feed' ); 

  ?>
  
</div>