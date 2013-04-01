<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
  $segments = $this->uri->uri_to_assoc();  

  echo form_open( 'init/signup' , array( 'class' => 'form-horizontal' ) ); // <- this should be a little bit more dynamic
  
  echo form_fieldset(); ?>
  
  <?php echo form_input( array(
         'value'  => $this->uri->uri_string()
        ,'name'   => 'url'
        ,'type'   => 'hidden'
      ) ); ?>
  
  <div class="control-group">  
  
  <?php echo form_label( 'Email:' , 'email' , array( 'class' => 'control-label' ) ); ?>
  
    <div class="controls">
      <?php echo form_error('email'); ?>
      <?php echo form_input( array(
            'name'        => 'email'
           ,'id'          => 'email'
           ,'placeholder' => 'Email'
           ,'value'       => set_value('email')
          ) ); ?>
          
    </div>
      
  </div>     
  
  <div class="control-group">
  
  <?php echo form_label( 'Password:' , 'password' , array( 'class' => 'control-label' ) ); ?>
  
    <div class="controls">
  <?php echo form_error('password'); ?>
  <?php echo form_input( array(
        'name'        => 'password'
      , 'id'          => 'password'
      , 'type'        => 'password'
      , 'placeholder' => 'Password'
      ) ); ?>
      
    </div>
  
  </div>
  
  <div class="control-group">        
   
  <?php echo form_label( 'Confirm Password:' , 'password-confirm' , array( 'class' => 'control-label' ) ); ?>
  
    <div class="controls"> 
      <?php echo form_error('password_confirm'); ?>
      <?php echo form_input( array(
            'name'        => 'password_confirm'
          , 'id'          => 'password-confirm'
          , 'type'        => 'password'
          , 'placeholder' => 'Confirm Password'
          ) ); ?>
          
    </div>
    
  </div>       
  
  <div class="controls" >
  
    <?php echo form_submit( array(
              'name'  => ''
            , 'value' => 'Sign Up'
            , 'class' => 'btn clear'
            )); ?>

  </div>
  
  <?php  echo form_fieldset_close();
  
  echo form_close();
  
?>