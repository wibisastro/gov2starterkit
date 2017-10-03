<?
/********************************************************************
*	Date		: 21 Apr 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@cybergl.co.id
*	Copyright	: Cyber GovLabs 
*********************************************************************/
require("config.php"); 
require("gov2model.php");

$cases=array("guest");
$gov2=new gov2model;

#------------------------init
$gov2->authenticate("guest");
$menu=$doc->readxml("menu");
#------------------------controller

if (!$gov2->error) {
    $data=$doc->api(9);
    $data->link=$data->link."?cmd=identify&client=".$_SERVER["SERVER_NAME"]."&session=".$gov2->authorized['session'];
    $doc->content("view/webclient.php");
} else {header("location: /login.php");}

$doc->error_message();

#------------------------view
include(viwpath."/service.php");
?>