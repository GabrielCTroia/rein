<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>



	<section id="feed" class="<?php echo $classes['module']; ?>">	
	
	  <?php if ( isset ( $error_msg ) && $error_msg ) : ?>

		  <p><?php echo $error_msg; ?> Please <a href="/home/settings/tab/connect">connect</a> with some services!</p>
		
		<?php else : ?>
    
      <?php require_once( MODULES_PATH . $this->module_name . '/views/common/header.php' ); ?>
      		  
  		<?php require_once( __DIR__ . '/layout_' . $layout . '/layout_' . $layout . '.php' ); ?>
  
  		<?php require_once( MODULES_PATH . $this->module_name . '/views/common/footer.php' ); ?>
  
		<?php endif; ?>
	
	</section><!-- #feed -->