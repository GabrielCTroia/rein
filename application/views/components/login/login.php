<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="login">

	<?php if (isset($_REQUEST['login']) && $_REQUEST['login'] == 'false' ) : ?>
		
		<p class="spacer text-orange">Your login is bad and you shoud feel bad!</p>
	
	<?php endif;?>
	
	<?php echo validation_errors(); 
	
	echo form_open('/log-in'); 
		
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
    
    Not having an account? <a href="/sign-up">Register now</a>. 
    
</div>