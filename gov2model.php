<?
/********************************************************************
*	Date		: 25 Mar 2015
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: e-Gov Lab Univ of Indonesia 
*********************************************************************/
#------------------------configuration
//    error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
    error_reporting(E_ALL & ~E_NOTICE);
//    error_reporting(E_ALL);
    ini_set("display_errors", 1);

	$gov2session=array("session","account_id","started","counter","fullname","facebook");
    $gov2cookies=$_COOKIE['govtwopointo'];
	$secret="";
	$public="";
    define("gov2xmlpath",$_SERVER["DOCUMENT_ROOT"]); #-ganti jika lokasinya dipindah. saran pindahkan dan beri permission tulis
    define("account_url","http://ui.cybergl.co.id"); #-jangan diganti
#------------------------model

class gov2model {
	function gov2model () {
        global $cases,$_GET,$gov2cookies;
	    $this->timeout_session	= 60*5; #-----5 menit
		$this->timeout_cookies	= 60*60; #----1 jam        
        if ($_GET['info']) {
            echo "<pre>";
            switch($_GET['info']) {
                case "cases":print_r($cases);break;
                case "cookie":print_r($gov2cookies);break;
            }
            echo "</pre>";
            exit;
        }
	}
    
    function readxml($filename) {
        if (file_exists(gov2xmlpath."/".$filename.".xml")) {return simplexml_load_file(gov2xmlpath."/".$filename.".xml");} 
        else {return "NotExist";}    
    } 
    
	function cookie_save ($keys) {
        global $gov2cookies;
        $keys=explode(",",$keys);
        foreach ($keys as $key) {
            setcookie("govtwopointo[$key]",$gov2cookies[$key], 0, "/");
        }
	}

	function cookie_remove () {
        global $gov2cookies;
        foreach ($gov2cookies as $key=>$val) {
            setcookie("govtwopointo[$key]","", 0, "/");
        }
	}
    
    function authenticate ($privilege="member") {
        global $public,$secret,$gov2cookies,$_GET,$_POST;
        $valid="";
        if (!$gov2cookies && $privilege!="public") {$error="NotLogin";}
        else {
            if (time()-$gov2cookies["started"] > time()+$this->timeout_session) {$error="SessionExpired";}
            else {
                if ($privilege=="public") {unset($error);} else {
                    if ($privilege=="member" || $privilege=="webmaster") {
                        $members=$this->readxml("gov2member");
                        if ($members!="NotExist") {
                            foreach ($members->member as $member) {
                                if ($member->account_id==$gov2cookies["account_id"]) {
                                    $valid=$member;
                                    unset($error);
                                    break;
                                } else {$error="NotMember";}
                            }
                            if (!$error) {
                                if (!$valid->webmaster) {
                                    foreach ($valid->privilege as $cases) {
                                        $controller = $cases->attributes();
                                        if ($controller['controller']==$_SERVER['SCRIPT_NAME']) {
                                            unset($error);
                                            if (!$_GET['cmd'] && !$_POST['cmd'] && !is_array($cases->case)) {break;} else {
                                                foreach ($cases->case as $case) {
                                                    if ($_GET['cmd']==$case || $_POST['cmd']==$case) {unset($error);break;} 
                                                    else {$error="UnauthorizedCase";}              
                                                }
                                            }
                                        } else {$error="UnauthorizedPage";}
                                    }
                                }

                            }                 
                        } else {$error="NotConfigured";}
                    }
                    $gov2cookies["started"]=time()+$this->timeout_session;
                    $gov2cookies["counter"]++;
                    $this->cookie_save('started,counter');
                } 
            }
        } 
        $this->authorized=$gov2cookies;
        $this->error=$error;
    }
}
?>