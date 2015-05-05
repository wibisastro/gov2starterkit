<?
/********************************************************************
*	Date		: 25 Mar 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: e-Gov Lab Univ of Indonesia 
*********************************************************************/
require("gov2model.php");
$cases=array("sessave","authorized","login","logout","authorize","default");

$gov2=new gov2model;

#------------------------controller
$gov2->authenticate();
$cmd="";
$account_id=0;
$session_id=0;
$member=array();

if ($_POST) {
      $data=json_decode(stripslashes($_POST["req"]));
      while(list($key,$val)=each($data)) {${"$key"}=$val;}
}

switch ($cmd) {
    case "sessave":
        if ($session) {$view="escape";} 
        else {$gov2->error="NoID";}
    break;
    default:
        switch ($_GET["cmd"]) {
            case "authorized":
                Header("Location: http://".$_SERVER["SERVER_NAME"]);
            break;
            case "login":
                Header("Location: ".account_url."/service/login.php?cmd=request&client=".$_SERVER["SERVER_NAME"]);
            break;
            case "logout":
                $gov2->cookie_remove();
                Header("Location: ".account_url."/service/logout.php?client=".$_SERVER["SERVER_NAME"]);
                exit;
            break;
            case "authorize":
                if ($_GET["session"]) {
                    $member=json_decode(file_get_contents(account_url."/service/login.php?cmd=getmember&session=".$_GET["session"]));
                    $gov2cookies["account_id"]=$member->member_id;
                    $gov2cookies["session"]=$_GET["session"];
                    $gov2cookies["fullname"]=$member->firstname;
                    $gov2cookies["facebook"]=$member->facebook_id;
                    $gov2cookies["status"]="pending";
                    $gov2->cookie_save("session,account_id,status,fullname,facebook");
                    Header("Location: ".account_url."/service/login.php?cmd=authorize&client=".$_SERVER["SERVER_NAME"]."&session=".$_GET["session"]);
                    exit;
                } else {$gov2->error="NoID";}
            break;
            default:
                if (!$gov2->error) {Header("Location: http://".$_SERVER["SERVER_NAME"]);}
        }
}

include("gov2view.php");
?>