<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
   
	 <header class="main-header">   

    <div class="container">
  
    	<a href="/" class="logo pull-left">
    	  <h1>Recycled Inspiration</h1>
    	</a>
  	
      <p>Welcome <?php echo $this->session->userdata['user_name'];?></p>
  	
      <div class="pull-right">
        <?php $this->load->view( '/modules/navigation/navigation' ); ?>
      </div>
  	
    </div> <!-- eof .container -->
    
  </header>

