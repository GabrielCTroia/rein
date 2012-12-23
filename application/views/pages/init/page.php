  <?php $this->load->view( $page->path . "header.php" ); ?>  
  
  <div class="page-<?php echo $page->name; ?>">  
    <?php $this->load->view( $component->url ); ?>  
  </div>
  
  <?php $this->load->view( $page->path . "footer.php" ); ?>
  
  
  
