<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	
  <?php $this->load->view( $this->Pager_model->path() . "header.php" ); ?>

  <section class="page-<?php echo $this->Pager_model->name() ?> grid">
    <?php $this->load->view( $this->Components_model->url() ); ?>
  </section>
  
	<?php $this->load->view( $this->Pager_model->path() . "footer.php" ); ?>
