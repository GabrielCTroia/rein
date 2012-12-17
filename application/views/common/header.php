<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="/<?php echo APPPATH; ?>css/styles.css" />
		
		<script src="/<?php echo APPPATH; ?>javascript/modernizr.js"></script>
		<script src="/<?php echo APPPATH; ?>javascript/loader.js"></script>
	</head>
	<body>
		
		<div id="wrapper">
		  
		  <header id="header" class="<?php echo $logged_in;?>">
		    <div id="logo">
		      <h1>Recycle Inspiration</h1>
		    </div>
		    <?php if( $logged_in === 'logged_in' ): ?>
		      
		      <!-- Connected to Information -->
		      
		      <!-- Profile Picture -->
		      
		      <a class="right" href="/home/logout">Log Out</a>
        	<div class="right">			
        		<p>Connect with:</p>
        		
        		<?php foreach ( $services as $service ): ?>
        						
        				<?php if( isset( $service->status ) ) : ?>
        					
        					<span ><?php echo $service->service_name; ?></span>
        				
        				<?php else: ?>
        					
        					<a href="/?service=<?php echo $service->service_name; ?>&method=AUTH" class="text-orange"><?php echo $service->service_name; ?></a>
        					
        				<?php endif; ?>
        				
        		<?php endforeach; ?>
        		
        		
        	</div>
		      
		    <?php elseif( $logged_in === 'splash' ): ?>
		      
		      <div class="bundle">
		        <a href="/login" style="font-weight:900">Login</a>
		         | 
		        <a href="/sign-up" style="font-weight:900">Sign-Up</a>
		      </div>
		        
		    <?php endif; ?>
		  </header>