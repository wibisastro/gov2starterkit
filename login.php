<?
/********************************************************************
*	Date		: 27 Apr 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@cybergl.co.id
*	Copyright	: PT Cyber Gatra Loka. All rights reserved.
*********************************************************************/
require("config.php");
require("gov2model.php");
$gov2=new gov2model;
$gov2->authenticate("guest");

#------------------------init
$menu=$doc->readxml("menu");
$doc->content("gov2view.php");

if ($cmd=="signup") {
    $view="signup";
}

$doc->error_message();

#------------------------display
include(viwpath."/body.php");
?>