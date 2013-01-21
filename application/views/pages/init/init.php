<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

  <header class="header">
    <?php $this->load->view( $this->Pager_model->path() . "header.php" ); ?>
  </header>
  
  <section class="page-<?php echo $this->Pager_model->name(); ?> grid">
    <?php $this->load->view( $this->Components_model->url() ); ?>  
  </section>
  
  <footer class="footer">
		<?php $this->load->view( $this->Pager_model->path() . "footer.php" ); ?>
	</footer>