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
        <a href="/auth/request_temp_token/<?php echo $service->service_name; ?>">
          <img src="/<?php echo 'images/social-media-icon-set-yaruno/' . $service->service_name . '.png' ?>" alt="<?php echo $service->service_name; ?>">
        </a>
      </div>
       
    <?php endforeach; ?>
    </div>

  </div>