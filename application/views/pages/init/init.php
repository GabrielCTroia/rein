<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <div class="container">
    
    <div class="pull-left">
      
      <?php if( !empty( $modules['splash'] ) ) : ?>
          <?php echo $modules['splash']; ?>
      <?php endif; ?>      
      
    </div>
    
    <div class="well transparent pull-right">  
      <?php if( !empty( $modules['login'] ) ) : ?>
          <?php echo $modules['login']; ?>
      <?php endif; ?>
        
      <?php if( !empty( $modules['signup'] ) ) : ?>
          <?php echo $modules['signup']; ?>
      <?php endif; ?>
      
      
      <?php if( !empty( $modules['form'] ) ) : ?>
          <?php echo $modules['form']; ?>
      <?php endif; ?>
    </div>
    
  </div>