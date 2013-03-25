<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <div id="settings" class="row">
    
    <div class="span3">
      
      <div class="btn-group btn-group-vertical">
        <button class="btn span2">Personal</button>
<!--         <button class="btn span2">Middle</button> -->
<!--         <button class="btn span2">Right</button> -->
      </div>
      
    </div>
    
    <div class="span9">
      
      <?php if( !empty( $modules['active_services'] ) ) : ?>
        <?php echo $modules['active_services']; ?>
      <?php endif; ?>
      
    </div>
    
  </div>