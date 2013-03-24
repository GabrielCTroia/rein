<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
?>

<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width">
  
    <style>
      body {
          padding-top: 60px;
          padding-bottom: 40px;
      }
    </style>
    <link rel="stylesheet" href="/css/bootstrap-responsive.min.css">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    
    <link rel="stylesheet" type="text/css" href="/css/plugins/shadowbox-3.0.3/shadowbox.css">
    
		<link rel="stylesheet" href="/css/styles.css" />
		
		<script src="/javascript/vendor/modernizr-2.6.2-respond-1.1.0.min.js"></script>

  </head>
  <body>
    
    <div class="all">
    
      <header class="must-header">   
  
        <div class="container">
      
<!--
        	<a href="/" class="logo pull-left">
        	  <h1>Recycled Inspiration</h1>
        	</a>
-->
      	
          <div class="pull-right">
            <?php $this->load->view( '/modules/navigation/navigation' ); ?>
          </div>
      	
        </div> <!-- eof .container -->
      
      </header>			
    
      <section class="must-page page-<?php echo $this->Pager_model->name() ?>">
      
        <?php $this->load->view( $this->Pager_model->url() ); ?>			
        
      </section>
      
      <div class="push"></div>
      
    </div>
    
    <footer class="must-footer sticky-footer">
  
      <div class="container">
    
      </div><!-- eof .container -->
    
    </footer>
			
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/javascript/vendor/jquery-1.9.1.min.js"><\/script>')</script>
  
    <script src="/javascript/vendor/bootstrap.min.js"></script>
  
    <script src="/javascript/plugins.js"></script>
    <script src="/javascript/main.js"></script>		
    
    <script type="text/javascript" src="/javascript/shadowbox-3.0.3/shadowbox.js"></script>
    <script type="text/javascript">
    Shadowbox.init({
        handleOversize: "drag",
        modal: true
    });
    </script>		
			
	</body>
</html>