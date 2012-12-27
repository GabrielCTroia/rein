<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <header class="header">
    <?php $this->load->view( $this->Pager->path() . "header.php" ); ?>
  </header>
  
  <div class="page-<?php echo $this->Pager->name(); ?>">
    <?php $this->load->view( $this->Components->url() ); ?>  
  </div>
  
  <footer class="footer">
		<?php $this->load->view( $this->Pager->path() . "footer.php" ); ?>
	</footer>