<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<link rel="stylesheet" href="<?php echo APPPATH; ?>/css/general.css" />
	
	</head>
	<body>
		
		<div id="page" class="page-<?php echo $page->name; ?> grain full-height">
			<?php $this->load->view( $page->path ); ?>
		</div><!-- eof #page -->
		
		<footer>
		
		</footer>
		
	</body>
</html>