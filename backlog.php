<?
/********************************************************************
*	Date		: 11 Nov 2014
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@cybergl.co.id
*	Copyright	: PT Cyber GovLab 
*********************************************************************/
require("config.php"); 

#------------------------init
$doc->pagetitle="Product Backlog";
$menu=$doc->readxml("menu");

switch ($_GET['cmd']) {
        case "backlog_archive":
            $data=file_get_contents(xmlpath."/backlog_archive.xml");
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
            header('Content-Type: text/xml');
            echo $data;
        exit;
        break;
        case "backlog":
            $data=file_get_contents(xmlpath."/backlog.xml");
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past
            header('Content-Type: text/xml');
            echo $data;
        exit;
        break;
        default:
            $data=$doc->api(5);
            $data->link=$data->link."?cmd=backlog&client=".$_SERVER["SERVER_NAME"];
            $doc->content("view/webclient.php");
}

$doc->error_message();

#------------------------view
include(viwpath."/body.php");
?>