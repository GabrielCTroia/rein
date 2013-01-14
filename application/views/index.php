<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="/<?php echo APPPATH; ?>css/styles.css" />
		
		<script src="/<?php echo APPPATH; ?>javascript/modernizr.js"></script>
		<script src="/<?php echo APPPATH; ?>javascript/loader.js"></script>
  </head>
  <body>
		    
			<?php $this->load->view( $this->Pager->url() ); ?>

	</body>
</html>