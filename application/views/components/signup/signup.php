<section class="center" page="signup">
  
  <?php
    
    echo validation_errors();
    
    echo form_open( htmlentities( $_SERVER['PHP_SELF'] . $_SERVER["REQUEST_URI"] ) );
    
/*
    echo form_label( 'Name:' , 'su-name' );
    echo form_input( array(
          'name' => 'name'
         ,'id' => 'su-name'
        ) );
*/
    
    echo form_label( 'User Name:' , 'su-userName' );
    echo form_input( array(
          'name' => 'user_name'
         ,'id' => 'su-userName'
        ) );
    
    echo form_label( 'Email:' , 'su-email' );
    echo form_input( array(
          'name' => 'email'
         ,'id' => 'su-email'
        ) );
    
    echo form_label( 'Password:' , 'su-password' );
    echo form_input( array(
          'name' => 'password'
         ,'id' => 'su-password'
        ) );
    
    echo form_label( 'Confirm Password:' , 'su-password-confirm' );
    echo form_input( array(
          'name'  => 'password_confirm'
         ,'id'    => 'su-password-confirm'
        ) );
    
    echo form_submit( '' , 'Sign Up!' );
    
  ?>
  
</section>