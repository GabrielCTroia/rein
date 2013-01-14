<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <header class="header">
    <?php $this->load->view( $this->Pager->path() . "header.php" ); ?>
  </header>
  
  <section class="page-<?php echo $this->Pager->name(); ?> grid">
    <?php $this->load->view( $this->Components->url() ); ?>  
  </section>
  
  <footer class="footer">
		<?php $this->load->view( $this->Pager->path() . "footer.php" ); ?>
	</footer>