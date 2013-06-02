<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="container">

  <div id="settings" class="row">
    
    <div class="span3">
      
      <div class="btn-group btn-group-vertical">
        <a href="<?php echo $this->router->switch_args( array( 'tab' => 'profile' ) ); ?>" class="btn span2">Personal</a>
        <a href="<?php echo $this->router->switch_args( array( 'tab' => 'connect' ) ); ?>" class="btn span2">Connect</a>
      </div>
      
    </div>
    
    <div class="span9">
            
      <?php if( !empty( $tab ) ) {
          
          include_once( __DIR__ . '/tabs/' . $tab . '.php' );          
          
      } ?>
      
      
    </div>
    
  </div>
  
</div>  