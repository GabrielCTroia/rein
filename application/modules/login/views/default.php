<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
  
  $segments = $this->uri->uri_to_assoc();  
  
?>

<div class="login">

	<?php if( !empty( $segments['message'] ) == 'fail' ) : ?>
		
		<p class="error">Your login is bad and you shoud feel bad!</p>
	
	<?php endif;?>
	
	<?php echo validation_errors(); 
	
	echo form_open('/login' , array( 'class' => 'form-horizontal' ) ); 
		
		echo form_fieldset(); ?>
		
		<div class="control-group">
		
		<?php echo form_input( array(
         'value'  => $this->uri->uri_string()
        ,'name'   => 'url'
        ,'type'   => 'hidden'
      ) ); ?>
   
   </div>
	
   <div class="control-group">	
   
     <?php echo form_label( 'User Name/Email:' , 'l-username_email' , array( 'class' => 'control-label' ) ); ?>
     
     <div class="controls">
     
       <?php echo form_input( array(
                'name'        => 'l-username_email'
               ,'id'          => 'l-userName'
               ,'placeholder' => 'Username/Email'
              ) ); ?>

     </div>
            
   </div> 
   
   <div class="control-group">
    		
  	<?php	echo form_label( 'Password:' , 'l-password' , array( 'class' => 'control-label' )); ?>
    
      <div class="controls">
    
        <?php echo form_input( array(
                  'name'  => 'l-password'
                , 'id'    => 'l-password'
                , 'type'  => 'password'
                , 'placeholder' => 'Password'
              ) ); ?>
            
      </div>
      
    </div>  
      
    <div class="control-group">
      
      <div class="controls">
      
        <label class="checkbox" for="l-remember_me">
            
      <?php 

      echo form_checkbox( array(
              'name'    => 'l-remember_me'
             ,'id'      => 'l-remember_me'  
             ,'value'   => 'remember'                   
            ) ); 

      ?>
      
        Remember me
      
        </label>
      
      </div> 
      
      <div class="controls">
      
      <?php echo form_submit( array(
            'name'  => ''
          , 'value' => 'Log in!'
          , 'class' => 'btn clear'
      ) ); ?>
      
      </div>
      
    </div>
    
    <?php echo form_fieldset_close();
      
  echo form_close(); ?>
    
  <span class="pull-right">Not having an account? <a href="/init/signup" >Register now</a>.</span>
    
</div>