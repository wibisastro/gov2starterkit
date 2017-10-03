<?
/********************************************************************
*	Date		: 25 Mar 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: e-Gov Lab Univ of Indonesia 
*********************************************************************/


#------------------------configuration
    define("account_url","http://ui.cybergl.co.id");
    if ($gov2->error && !$view) {$view=$gov2->error;}
    elseif (!$gov2->error) {$view="profile";}
#------------------------view
switch ($view) {
    case "escape":
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Gov 2.0 Login iFrame</title>
        </head>
        <body>
        <script>
            window.parent.location.href = "http://<?echo $_SERVER["SERVER_NAME"];?>/gov2login.php?cmd=authorize&session=<?echo $session;?>"; 
        </script>
        <a target="_parent" href="http://<?echo $_SERVER["SERVER_NAME"];?>/gov2login.php?cmd=authorize&session=<?echo $session;?>"><img src="http://ecom.cybergl.co.id/images/working.gif" border="0"</a>
        </body>
        </html>
        <?
    break;
    case "NotExist":
    case "NotMember":
    case "UnauthorizedPage":
    case "UnauthorizedCase":
    case "SessionExpired":
        echo "Err:".$gov2->error;
    break;
    case "signup":
        ?>
        <style>
        .saas-frame {
        position: relative;
        top: 20px;
        bottom: 0;
        left: 0;
        right: 0;
        }
        </style>
        <div class="saas-frame">
        <iframe src="<?echo account_url."/service/signup.php?";?>" width="100%" frameborder="0"></iframe>		
        </div>	
        <script type="text/javascript" src="http://geo.gov2.web.id/js/iframeResizer.min.js"></script>
        <script type="text/javascript">

            iFrameResize({
                log                     : false,                  // Enable console logging
                enablePublicMethods     : true,                  // Enable methods within iframe hosted page
                resizedCallback         : function(messageData){ // Callback fn when message is received
                }
            });
        </script>
        <?
    break;
    case "NotLogin":
        ?>
        <style>
        .saas-frame {
        position: relative;
        top: 20px;
        bottom: 0;
        left: 0;
        right: 0;
        }
        </style>
        <div class="saas-frame">
        <iframe src="<?echo account_url."/service/index.php?".$gov2join."client=".$_SERVER["SERVER_NAME"]."&caller=".$_SERVER["REQUEST_URI"];?>" width="100%" frameborder="0"></iframe>		
        </div>	
        <script type="text/javascript" src="http://geo.gov2.web.id/js/iframeResizer.min.js"></script>
        <script type="text/javascript">

            iFrameResize({
                log                     : false,                  // Enable console logging
                enablePublicMethods     : true,                  // Enable methods within iframe hosted page
                resizedCallback         : function(messageData){ // Callback fn when message is received
                }
            });
        </script>
        <?
    break;
    case "profile":
        ?>
        <style>
        .saas-frame {
        position: relative;
        top: 20px;
        bottom: 0;
        left: 0;
        right: 0;
        }
        </style>
        <div class="saas-frame">
        <iframe src="<?echo account_url;?>/service/profile.php?client=<?echo $_SERVER["SERVER_NAME"];?>&session=<?echo $gov2cookies['session'];?>" width="100%" frameborder="0"></iframe>		
        </div>	
        <script type="text/javascript" src="http://geo.gov2.web.id/js/iframeResizer.min.js"></script>
        <script type="text/javascript">

            iFrameResize({
                log                     : false,                  // Enable console logging
                enablePublicMethods     : true,                  // Enable methods within iframe hosted page
                resizedCallback         : function(messageData){ // Callback fn when message is received
                }
            });
        </script>
        <?
    break;
    default:
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Gov 2.0 Login iFrame</title>
        </head>
        <body>
        <script>
            window.location.href = "http://<?echo $_SERVER["SERVER_NAME"];?>";
        </script>
        </body>
        </html>
        <?
}
?>