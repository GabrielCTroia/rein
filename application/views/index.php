<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php 
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="/<?php echo APPPATH; ?>css/styles.css" />
		
		<script src="/<?php echo APPPATH; ?>javascript/modernizr.js"></script>
		<script src="/<?php echo APPPATH; ?>javascript/loader.js"></script>
  </head>
  <body>
		
			<?php $this->load->view( $this->Pager_model->url() ); ?>

	</body>
</html>