<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
  $segments = $this->uri->uri_to_assoc();  

  //need to shoow the validation errors here
  if( !empty( $segments['message'] ) == 'fail' ) : ?>
    
  <div class="error">You failed to register!</div>  
    
<?php endif;
    
/*   if()   */
    
  
  
  echo form_open( '/signup' ); // <- this should be a little bit more dynamic
  
  echo form_input( array(
         'value'  => $this->uri->uri_string()
        ,'name'   => 'url'
        ,'type'   => 'hidden'
      ) );
  
  echo form_label( 'User Name:' , 'su-userName' );
  echo form_input( array(
        'name' => 'user_name',
        'id' => 'su-userName',
      ) );
  
  echo form_label( 'Email:' , 'su-email' );
  echo form_input( array(
        'name' => 'email',
        'id' => 'su-email'
      ) );
  
  echo form_label( 'Password:' , 'su-password' );
  echo form_input( array(
        'name'  => 'password'
      , 'id'    => 'su-password'
      , 'type'  => 'password'
      ) );
  
  echo form_label( 'Confirm Password:' , 'su-password-confirm' );
  echo form_input( array(
        'name' => 'password_confirm'
      , 'id' => 'su-password-confirm'
      , 'type'  => 'password'
      ) );
  
  echo form_submit( '' , 'Sign Up!' );
  
?>