<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    //set the default span for the thumnnail 
    $thumb_span = 3;
    
    $segments = $this->uri->uri_to_assoc(1);

?>

	<div id="feed">	
	
	   <?php if ( isset ( $error_msg ) && $error_msg ) : ?>

				<p><?php echo $error_msg; ?></p>
		
		<?php else : ?>
		
		  <header class="clearfix"> 
		    
		    <div class="dropdown-filter dropdown pull-left">
          
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fetch now<b class="caret"></b></a>
          
          <ul class="dropdown-menu">
            
            <?php foreach( $modules['active_services'] as $service ): ?>
              <li><a href="/fetch/service/<?php echo $service->service_name; ?>"><?php echo $service->service_name; ?></a></li>
            <?php endforeach; ?>

          </ul>
          
        </div>
		  
  		  <div class="btn-group pull-right">
          
          <a href="<?php echo Util::get_new_url( $segments , 'layout' , 'grid' ); ?>" class="btn">Grid</a>
          <a href="<?php echo Util::get_new_url( $segments , 'layout' , 'list' ); ?>" class="btn">List</a>
          
        </div>  

        <div class="dropdown-filter dropdown pull-right">
          
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">Filter<b class="caret"></b></a>
          
          <ul class="dropdown-menu">
            <li><a href="<?php echo Util::get_new_url( $segments , 'layout' , 'by-service' ); ?>">By Service</a></li>
            <li><a href="<?php echo Util::get_new_url( $segments , 'filter' , 'by-favorited-date' ); ?>">By Favorited Date</a></li>
          </ul>
          
        </div>

		  </header>
		  
		  <?php require_once( __DIR__ . '/layout_' . $layout . '.php' ); ?>
		  
		<?php endif; ?>
	
	</div><!-- #feed -->