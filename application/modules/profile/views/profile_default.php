<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
?>

<div class="row">
  
  <div class="pull-right">
    
    
      
      
      

    
  </div>
  
  <div class="span6">

  	<?php if( !empty( $message ) ) : ?>
  		
  		<p><?php echo $message; ?></p>
  	
  	<?php endif; ?>
  	
  	<?php 
  	
  	echo form_open( $this->uri->assoc_to_uri( $segments ) , array( 'class' => 'form-horizontal' ) ); 
  		
  		echo form_fieldset(); ?>
  		
  		<?php if( !empty( $this->userdata->avatar ) || false ) : ?>
  	
       <div class="control-group">	
       
          <div class="controls">
            
            <img class="img-polaroid" src="" />
          
          </div>
        
       </div> 
  	 
  	 <?php endif; ?>    	
  	     	
     <div class="control-group">	
     
       <?php echo form_label( 'First Name:' , 'first_name' , array( 'class' => 'control-label' ) ); ?>
       
       <div class="controls">
        <?php echo form_error('first_name'); ?>
         <?php echo form_input( array(
                  'name'        => 'first_name'
                , 'id'          => 'first_name'
                , 'value'       => ucfirst( $this->userdata->first_name )
                ) ); ?>
  
       </div>
              
     </div> 
     
     <div class="control-group">	
     
       <?php echo form_label( 'Last Name:' , 'last_name' , array( 'class' => 'control-label' ) ); ?>
       
       <div class="controls">
         <?php echo form_error('last_name'); ?>
         <?php echo form_input( array(
                  'name'        => 'last_name'
                , 'id'          => 'last_name'
                , 'value'       => ucfirst( $this->userdata->last_name )
                ) ); ?>
  
     </div>
              
     </div> 
     
        <div class="control-group">	
     
       <?php echo form_label( 'Email:' , 'email' , array( 'class' => 'control-label' ) ); ?>
       
       <div class="controls">
       
        <label class="control-label"><?php echo $this->userdata->email; ?></label>
       
       </div>
              
     </div> 
     
     
      <div class="control-group">	
     
       <?php echo form_label( 'Date of Birth:' , 'dob' , array( 'class' => 'control-label' ) ); ?>
       
       <div class="controls">
         <?php echo form_error('dob'); ?>
         <?php echo form_input( array(
                  'name'        => 'dob'
                , 'id'          => 'dob'
                , 'value'       => $this->userdata->dob
                ) ); ?>
  
       </div>
              
     </div> 
        
      <div class="controls">
      
      <?php echo form_submit( array(
            'name'  => ''
          , 'value' => 'Save'
          , 'class' => 'btn clear btn-success'
      ) ); ?>
      
      </div>
      
    </div>
    
    <?php echo form_fieldset_close();
        
    echo form_close(); ?>

  </div>
    
</div>