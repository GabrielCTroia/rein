<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

		  <?php if( $pages > 1 ) : ?>
  
        <footer class="pagination pull-right">
          
          <ul>
      
            <?php if( $current_page > 1 ) : ?>
              <li><a href="<?php echo $this->router->switch_args( array( 'page' => $current_page - 1 ) ); ?>">Prev</a></li>
          	<?php endif; ?>
          	
          	<?php for( $i = 1; $i < $pages + 1; $i++ ) : ?>
              <li class="<?php echo ( $current_page == $i ) ? 'active' : ''; ?>"><a href="<?php echo $this->router->switch_args( array( 'page' => $i ) ); ?>"><?php echo $i; ?></a></li>
            <?php endfor; ?>
              
            <?php if( $current_page < $pages )  : ?>    		
              <li><a href="<?php echo $this->router->switch_args( array( 'page' => $current_page + 1 ) ); ?>">Next</a></li>
            <?php endif; ?>  
          
          </ul>
          
        </footer>
      
      <?php endif; ?>