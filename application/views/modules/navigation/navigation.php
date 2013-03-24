<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  
  /* helper */
  
?>    
    
  <div class="navbar navbar-inverse">
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
                          <li class="active"><a href="/home">Home</a></li>
                      </ul>
                      
                      <?php if( $this->logged_in ) : ?>
                        <ul class="nav pull-right">
                          <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $this->userdata->user_name;?><b class="caret"></b></a>
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
                            <a href="/sign-up">Sign Up</a>
                          </li>
                          <li>
                            <a href="/log-in">Log in</a>
                          </li>
                        </ul>
                      <?php endif; ?>  
                      
                  </div><!--/.nav-collapse -->
              </div>
          </div>