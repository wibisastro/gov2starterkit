<!DOCTYPE html>
<html lang="en">
<head>
<?include (viwpath."/head.php");?>
    <link rel="stylesheet" type="text/css" href="http://ecom.cybergl.co.id/css/custom.css" />
</head>
<body class="theme-whbl">
<iframe id="iframer" name="iframer" src="" frameborder="1" style="display:<?if ($debug) {echo "inline";} else {echo "none";}?>" width="300" height="200"></iframe>
  <div id="theme-wrapper">
  <?//include (viwpath."/topbar.php");?>
  <div id="page-wrapper" class="container">
			<div class="row">
          <!--content-->
          <div id="content-wrapper">
            <div class="row">
              <div class="col-lg-12">
                        <?
                        if (is_array($doc->content) && !$doc->error)  {
                            while (list($key,$val)=each($doc->content)) {
                                if ($val && file_exists($val)) {include($val);}
                                else {echo $val;}
                            }
                        } elseif (!$doc->error  && !$doc->content) {?>
                            <h1>Under Construction</h1>
                        <?} elseif (!$doc->error && $doc->content) {?>
                            <h1>Var Dump Page</h1>
                            <div class="main-box clearfix">
                                <header class="main-box-header clearfix">
                                    <h2><?echo strip_tags($cmd);?></h2>
                                </header>
                                <div class="main-box-body clearfix">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?echo $doc->content;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?} else {?>
                            <h1>Error</h1>
                            <div class="main-box clearfix">
                                <header class="main-box-header clearfix">
                                    <h2><?echo $doc->error;?></h2>
                                </header>
                                <div class="main-box-body clearfix">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?echo $doc->error_message;?>
                                            <p>
                                                <a href="index.php">Back to Home</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?}?>
              </div>
            </div>		
          </div>              
  		</div>
	</div>
  
  </div>

	
	<!-- global scripts -->
	<script src="http://ecom.cybergl.co.id/js/jquery.js"></script>
	<script src="http://ecom.cybergl.co.id/js/bootstrap.js"></script>
	<script src="http://ecom.cybergl.co.id/js/jquery.nanoscroller.min.js"></script>	
	  
  <!-- theme scripts -->
	<script src="http://ecom.cybergl.co.id/js/scripts.js"></script>
	<script src="http://ecom.cybergl.co.id/js/pace.min.js"></script>
  
</body>
</html>