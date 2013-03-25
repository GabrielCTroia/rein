<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
  
  $segments = $this->uri->uri_to_assoc();  
  
?>

<div class="login">

	<?php if( !empty( $segments['message'] ) == 'fail' ) : ?>
		
		<p class="error">Your login is bad and you shoud feel bad!</p>
	
	<?php endif;?>
	
	<?php echo validation_errors(); 
	
	echo form_open('/login'); 
		
		  echo form_input( array(
         'value'  => $this->uri->uri_string()
        ,'name'   => 'url'
        ,'type'   => 'hidden'
      ) );
		
		echo form_label( 'User Name:' , 'su-userName' );
    echo form_input( array(
          'name'  => 'user_name',
          'id'    => 'su-userName',
        ) );
		
		echo form_label( 'Password:' , 'su-password' );
    echo form_input( array(
            'name'  => 'password'
          , 'id'    => 'su-password'
          , 'type'  => 'password'
        ) );
    
    echo form_submit( '' , 'Log in!' );
    
    ?>
    
    Not having an account? <a href="/init/signup">Register now</a>. 
    
</div>