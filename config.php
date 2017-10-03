<?
/********************************************************************
*	Date		: Thursday, August 25, 2011
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: eGov Lab UI 
*********************************************************************/
#-----instalation helper, must be shut off upon success

//    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    error_reporting(E_ALL & ~E_NOTICE);
//    error_reporting(E_ALL);
    ini_set("display_errors", 1);

#---------------------------------------path configuration, you can move this to improve security
    define("conpath",$_SERVER["DOCUMENT_ROOT"]); #----- controller path
    define("modpath",$_SERVER["DOCUMENT_ROOT"]."/model"); #----- model path
    define("viwpath",$_SERVER["DOCUMENT_ROOT"]."/view"); #----- view path
    define("xmlpath",$_SERVER["DOCUMENT_ROOT"]."/xml"); #----- xml doc path

#---------------------------------------module recruiter
#-----do not change this

function getmodule ($name) {
    if (file_exists(modpath."/$name.php")) {require modpath."/$name.php";$result=new $name;} 
    else {echo "Module $name is not exist...";}
return $result;
}

#---------------------------------------initialization
#-----do not change this
	$doc	= getmodule("document");
    $config = $doc->readxml('config');
?>