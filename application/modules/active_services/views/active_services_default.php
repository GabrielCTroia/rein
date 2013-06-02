<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


  <?php if( !empty($success) ) : ?>  
    <span class="success">
      Congrats! You are now connected with <?php echo $success; ?>
    </span>
  <?php endif; ?>
  
  <div>
  
    <h1>Connect with the following services:</h1>
    
    <div class="services">
    <?php foreach( $active_services as $service ): ?>
      
      <div class=" <?php echo ( !empty( $service->active ) ) ? 'active' : ''; ?>">
        
        <img src="/<?php echo 'images/social-media-icon-set-yaruno/' . $service->service_name . '.png' ?>" alt="<?php echo $service->service_name; ?>">

        
        <?php if ( !empty( $service->active ) ) : ?>
        
          <a href="<?php echo $this->router->switch_args( array( 'method' => 'deactivate' , 'service' => $service->service_name ) ); ?>">Deactivate</a>
          
        <?php else : ?>
          
          <a href="<?php echo $this->router->new_page( 'auth' , 'request_temp_token' , $service->service_name ); ?>">Activate</a>
          
        <?php endif; ?>
        
      </div>
       
    <?php endforeach; ?>
    </div>

  </div>