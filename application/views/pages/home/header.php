<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
   
 <header class="header">   
  
  <div class="grid">

	<a href="/" class="logo">
	  <h1>Recycle Inspiration</h1>
	</a>
	
	<div>
  	<p>Welcome <?php echo $this->session->userdata['user_name'];?></p>
	</div>
	
	<div class="bundle">
	  <a href="/log-out">Logout</a>
     | 
    <a href="/home/settings">Settings</a>
	</div>
	
  </div> <!-- eof .grid -->
  
 </header> 	
