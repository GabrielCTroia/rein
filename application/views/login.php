<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="<?php echo APPPATH; ?>/css/general.css" />
	
	</head>
	<body>
		
		<div id="page" class="grain full-height">
			<div class="login-wrapper c1_4 column-fixed centered middle light-grey padding">
      
      	<?php if (isset($_REQUEST['login']) && $_REQUEST['login'] == 'false' ) : ?>
      		
      		<p class="spacer text-orange">Your login is bad and you shoud feel bad!</p>
      	
      	<?php endif;?>
      	
      	<?php echo validation_errors(); ?>
      	<?php echo form_open('verifylogin'); ?>
      		
      		<label for="email">Email</label>
      		<input class="full-width spacer" id="email" size="20" type="text" name="email" value=""/>
      		
      		<label for ="password">Password</label>
      		<input class="full-width spacer" id="password" size="20" type="password" name="password" value="" />
      		
      		<input type="submit" value="Login" />
      	</form>
      </div>
		</div><!-- eof #page -->
		
		<footer>
		
		</footer>
		
	</body>
</html>