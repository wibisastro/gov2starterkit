<header class="navbar" id="header-navbar">
  <div class="container">
    <a href="index.html" id="logo" class="navbar-brand">
      <img src="http://ecom.cybergl.co.id/images/logo-admin.png" alt="" class="normal-logo logo-white"/>
      <img src="http://ecom.cybergl.co.id/images/logo-admin-black.png" alt="" class="normal-logo logo-black"/>
      <img src="http://ecom.cybergl.co.id/images/logo-admin-black.png" alt="" class="small-logo hidden-xs hidden-sm hidden"/>
    </a>
    
    <div class="clearfix">
    <button class="navbar-toggle" data-target=".navbar-ex1-collapse" data-toggle="collapse" type="button">
      <span class="sr-only">Toggle navigation</span>
      <span class="fa fa-bars"></span>
    </button>
    
    <div class="nav-no-collapse navbar-left pull-left hidden-sm hidden-xs">
      <ul class="nav navbar-nav pull-left">
        <li>
          <a class="btn" id="make-small-nav">
            <i><img src="<?echo $config->img;?>/pointer_down.gif"></i>
          </a>
        </li>					
      </ul>
    </div>
    
    <div class="nav-no-collapse pull-right" id="header-nav">
      <ul class="nav navbar-nav pull-right">						
        <li class="dropdown profile-dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <?if ($gov2->authorized["facebook"]) {?>
              <img src="http://graph.facebook.com/<?echo $gov2->authorized["facebook"];?>/picture?type=small" alt=""/>
              <?}?>
            <span class="hidden-xs">
            <?if ($gov2->authorized["account_id"]){
              echo $gov2->authorized["fullname"];
            } else { echo "Member";}
            ?>
            </span> <b class="caret"></b>
          </a>
          <ul class="dropdown-menu dropdown-menu-right">
              <?if ($gov2->authorized["account_id"]){?>
                <li><a href="login.php"><img src="<?echo $config->img;?>/pointer_back.gif"> Profile</a></li>
                <li><a href="gov2login.php?cmd=logout"><img src="<?echo $config->img;?>/pointer_back_fast.gif"> Logout</a></li>
              <?} else {?>
                <li><a href="login.php"><img src="<?echo $config->img;?>/pointer_fast.gif"> Login</a></li>
                <li><a href="login.php?cmd=signup"><img src="<?echo $config->img;?>/pointer_up.gif"> Signup</a></li>
              <?}?>
          </ul>
        </li>
      </ul>
    </div>
    </div>
  </div>
</header>