<section component="settings">
  
  <div>
    <?php
      if( $this->input->get( 'service' ) && $this->input->get( 'status_code' ) ) {
        
        $service = $this->input->get( 'service' );
        
        //  should be a function that goes through all the status_codes and returns the correlating message
        if( $this->input->get( 'status_code' ) == 200 )
          echo "You have been connected to $service!<br><br>";
        
      }
    ?>
  </div>
  
  <div>
    <h1>Connect with the following services:</h1>
    <?php foreach( $active_services as $service ): ?>
      
       
      <a href="/auth/request_temp_token/<?php echo $service->service_name ?>"><?php echo $service->service_name ?></button>
       
    <?php endforeach; ?>
<!--
    <pre>
      <?php echo print_r( $active_services , 1 ); ?>
    </pre>
-->
  </div>
    
</section>
