<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <div class="container-fluid">
    
    <?php if( !empty( $modules['feed'] ) ) : ?>
        <?php echo $modules['feed']; ?>
    <?php endif; ?>
    
    <?php if( !empty( $modules['settings'] ) ) : ?>
        <?php echo $modules['settings']; ?>
    <?php endif; ?>
      
  </div>