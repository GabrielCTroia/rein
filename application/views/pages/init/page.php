  <header>
    <?php $this->load->view( $page->path . "header.php" ); ?>
  </header>
  
  <div class="page-<?php echo $page->name; ?>">  
    <?php $this->load->view( $component->path . $component->name ); ?>  
  </div>
  
  <?php $this->load->view( $page->path . "footer.php" ); ?>
  
  
  
