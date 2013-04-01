<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

	<div id="feed">	
	
	   <?php if ( isset ( $error_msg ) && $error_msg ) : ?>

				<p><?php echo $error_msg; ?> Please <a href="/home/settings/tab/connect">connect</a> with some services!</p>
		
		<?php else : ?>
		
		  <header class="clearfix"> 
		    		  
  		  <div class="btn-group pull-right">
          
          <a href="<?php echo Util::get_new_url( $segments , 'layout' , 'grid' ); ?>" class="btn btn-grid" title="Grid Layout"><i class="icon-th"></i></a>
          <a href="<?php echo Util::get_new_url( $segments , 'layout' , 'list' ); ?>" class="btn btn-list" title="List Layout"><i class="icon-th-list"></i></a>
          
        </div>  

        <div class="dropdown-filter dropdown pull-right">
          
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Filter<b class="caret"></b></a>
          
          <ul class="dropdown-menu">
            <li><a href="<?php echo Util::get_new_url( $segments , 'layout' , 'by-service' ); ?>">By Service</a></li>
            <li><a href="<?php echo Util::get_new_url( $segments , 'filter' , 'by-favorited-date' ); ?>">By Favorited Date</a></li>
          </ul>
          
        </div>

		  </header>
		  
		  <?php require_once( __DIR__ . '/layout_' . $layout . '/layout_' . $layout . '.php' ); ?>
		  
		<?php endif; ?>
	
	</div><!-- #feed -->