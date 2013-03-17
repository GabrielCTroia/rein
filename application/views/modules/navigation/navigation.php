<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
  /* helper */
  
  $logged_in = ( isset( $this->session->userdata['logged_in'] ) && $this->session->userdata['logged_in'] );
  
  
  
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
                          <li class="active"><a href="#">Home</a></li>
                          <li><a href="#contact">Discover</a></li>
                      </ul>
                      
                      <?php if( $logged_in ) : ?>
                        <ul class="nav pull-right">
                          <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->session->userdata['user_name']?><b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="/home/settings">Settings</a></li>
                                    <li><a href="#">Another action</a></li>
                                    <li><a href="#">Something else here</a></li>
                                    <li class="divider"></li>
                                    <li><a href="/log-out">Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                      <?php else : ?>
                        <ul class="nav pull-right">
                          <li>
                            <a href="/log-in">Log in</a>
                          </li>
                        </ul>
                      <?php endif; ?>  
                      
                  </div><!--/.nav-collapse -->
              </div>
          </div>