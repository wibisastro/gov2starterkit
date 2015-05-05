<?
/********************************************************************
*	Date		: 26 Apr 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@cybergl.co.id
*	Copyleft	: Cyber GovLab 
*********************************************************************/
require("config.php");
require("gov2model.php");
$cases=array("public");
$gov2=new gov2model;
$gov2->authenticate($cases[0]);

#------------------------init
$doc->pagetitle="Gov 2.0 StarterKit";
$menu=$doc->readxml("menu");
$doc->content("view/index.php");

$doc->error_message();

#------------------------view
include(viwpath."/body.php");
?>