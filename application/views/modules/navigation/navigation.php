<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
  /* helper */
  
?>    
    
  <div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
      <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
          </a>
          <a class="brand" href="/">ReIn</a>
          <div class="nav-collapse collapse">
              <ul class="nav">
                  
                  <li class="active">
                    <a href="/home">Home</a>
                  </li>
                  
                  <?php if( $this->logged_in && $modules['active_services'] ) : ?>
                  
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Fetch now<b class="caret"></b></a>
                
                    <ul class="dropdown-menu">
                      
                      <?php foreach( $modules['active_services'] as $service ): ?>
                        <li><a href="/fetch/service/<?php echo $service->service_name; ?>"><?php echo $service->service_name; ?></a></li>
                      <?php endforeach; ?>
          
                    </ul>
                  </li> 
                  
                  <?php endif; ?>
                    
              </ul>
              
              <?php if( $this->logged_in ) : ?>
                <ul class="nav pull-right">
                  <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo ( $this->userdata->first_name ) ? $this->userdata->first_name : $this->userdata->email ; ?><b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><a href="/home/settings">Settings</a></li>
                            <li class="divider"></li>
                            <li><a href="/log-out">Log Out</a></li>
                        </ul>
                    </li>
                </ul>
              <?php else : ?>
                <ul class="nav pull-right">
                  <li>
                    <a href="/init/signup">Sign Up</a>
                  </li>
                  <li>
                    <a href="/init/login">Log in</a>
                  </li>
                </ul>
              <?php endif; ?>  
              
          </div><!--/.nav-collapse -->
      </div>
  </div>