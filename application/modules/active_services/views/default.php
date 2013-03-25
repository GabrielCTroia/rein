<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>


  <?php if( !empty($success) ) : ?>  
    <span class="success">
      Congrats! You are now connected with <?php echo $success; ?>
    </span>
  <?php endif; ?>
  
  <div>
    <h1>Connect with the following services:</h1>
    
    <ul class="services row">
    <?php foreach( $active_services as $service ): ?>
      
      <li class="span1 <?php echo ( !empty( $service->active ) ) ? 'active' : ''; ?>">
        <a href="/auth/request_temp_token/<?php echo $service->service_name; ?>">
          <img src="/<?php echo 'images/social-media-icon-set-yaruno/' . $service->service_name . '.png' ?>" alt="<?php echo $service->service_name; ?>">
          <span><?php echo $service->service_name; ?></span>
        </a>
      </li>
       
    <?php endforeach; ?>
    </ul>

  </div>