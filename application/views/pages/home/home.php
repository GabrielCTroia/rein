<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
	
  <?php $this->load->view( $this->Pager->path() . "header.php" ); ?>

  <section class="page-<?php echo $this->Pager->name() ?> grid">
    <?php $this->load->view( $this->Components->url() ); ?>
  </section>
  
	<?php $this->load->view( $this->Pager->path() . "footer.php" ); ?>