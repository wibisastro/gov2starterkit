<?
/********************************************************************
*	Date		: Sunday, November 22, 2009
*	Author		: Wibisono Sastrodiwiryo
*	Email		: wibi@alumni.ui.ac.id
*	Copyleft	: eGov Lab UI 
*	Version		: 2 -> 27-Mar-07, 23:17 

# ---- ver 2.1, 02-Apr-07, gabung head dan body ke doc
# ---- ver 2.2, 29-Apr-09, tambah mainmenu dropdown
# ---- ver 2.3, 25-Agu-09, tambah pagetitle di navpath
# ---- ver 2.4, 28-Sep-09, tambah buildsql
# ---- ver 2.5, 22-Nov-09, tambah buildcolumn
# ---- ver 2.6, 28-Jul-11, tambah parse_request
# ---- ver 2.7, 21-Sep-11, perbaikan error_message
# ---- ver 3.0, 15-Apr-14, downgrade untuk publikasi kpu
# ---- ver 3.1, 16-Jan-15, tambahkan fungsi readxml
# ---- ver 3.2, 22-Jan-15, tambahkan fungsi navpath
# ---- ver 4.1, 24-Mar-15, modifikasi fungsi sitemap
# ---- ver 4.2, 25-Mar-15, modifikasi fungsi error_message
# ---- ver 4.3, 25-Mar-15, modifikasi fungsi txt
# ---- ver 5.1, 25-Apr-15, hapus fungsi error_message_ajax, leftside, rightside, error_message_search, sortlist, set_pagerow, table_panel, filter, sort_method, menu_editdel, selectall
# ---- ver 5.2, 27-Apr-15, tambahkan fungsi api
*/

class document {
	function document() {
		global $PHP_SELF,$ses;
		$this->forbiden="This script is not for direct execution";
		if ($ses->cookies["item_perpage"]) {$this->item_perpage=$ses->cookies["item_perpage"];}
		else {$this->item_perpage=12;}
		$this->curdate = date("l")." ".date("j")." ".date("M")." ".date("y").", ".date("H:i");
		$this->querystring(getenv("QUERY_STRING"));
	}

    function api($nav_id) {
        global $config;
        $service_url=$config->platform->arch;
        $data=file_get_contents($service_url."/api.php?cmd=service&nav_id=".$nav_id);
	return json_decode($data);
	}
    
	function lnk($link, $text="", $class="", $java="",$title="",$target="",$id="") {
		if ($class) {$class=" class=\"$class\"";}
		if (!$text) {$text=$link;}
		if ($target) {$target=" target=\"$target\"";}
		if ($title) {$title=" title=\"$title\"";}
		if ($id) {$id=" id=\"$id\"";}
		return "<a href=\"$link\"$class $java$title$target$id>$text</a>";
	}

	function txt($name,$style="") {
        $xml=$this->readxml("text");
        foreach ($xml->text as $text) {
            if ($text->name == $name) {
                if ($style) {
                    $result="<span class=$style>$text->text</span>";
                } elseif ($text->type != "button" && $text->type != "label") {
                    $result="<span class=\"$text->type\">$text->text</span>";
                } else {$result=$text->text;}
                break;
            } else {$result="NoText:$name";}
        }
	return $result;
	}

	function img ($src="", $alt="", $url="") {
		if ($url) {return "<img border=\"0\" src=\"$url\" alt=\"$alt\" />";}
		else {return "<img border=\"0\" src=\"".imgurl."/$src\" alt=\"$alt\" />";}
	}

	function querystring($querystring) {
		if ($querystring) $qsses=explode("&", $querystring);
		for ($a=0;$a<=sizeof($qsses)-1;$a++) {$qsitem=explode("=", $qsses[$a]);$qsarray[$qsitem[0]]=$qsitem[1];}
		$a=0;
		if (is_array($qsarray)) {
			while (list($key,$val)=each($qsarray))  {
				if ($key != "page" && $key != "seq") {$qsresult[$a]=$key."=".$val;$a++;}
			}
			if (is_array($qsresult)) {$this->querystring=implode("&", $qsresult);}
		}
	}

	function content($val) {
		$index=sizeof($this->content);
		$index++;
		if (file_exists(viwpath."/$val")) {$this->content[$index]=viwpath."/$val";}
		else {$this->content[$index]=$val;}
	}

	function tab($val) {
		$index=sizeof($this->tab);
		$index++;
		$this->tab[$index]=viwpath."/$val";
	}

	function strip_java($data) {
		return eregi_replace("<[ \n\r]*script[^>]*>.*<[ \n\r]*/script[^>]*>","",$data);
	}

	function error_message ($message="") {
		global $gov2;
		if ($gov2->error || $this->error) {
			if ($gov2->error) {
				if ($gov2->error=="NotLogin") {
                    unset($this->content);
					$this->content("../controller/gov2view.php");
				} else {
					$this->error=$gov2->error;
					$this->error_message=sprintf(strip_tags($this->txt($gov2->error)),$message);
					$this->pagetitle="Authentication Failed";
				}
			} else {
				$this->pagetitle="Invalid Execution";
				$this->error_message=sprintf(strip_tags($this->txt($this->error)),$message);
			}
		}
	}
    
    function readxml($filename) {
        if (file_exists(xmlpath."/".$filename.".xml")) {
            $result=simplexml_load_file(xmlpath."/".$filename.".xml");
            return $result;
        } else {
            return "Failed";
        }    
    } 
    
    function navpath($data,$menu_id) {
        static $c; global $navpath;
        $c+=0;
        if (is_array($data->children)) {
            foreach ($data->children as $child) {
                if ((INT)$child->menu_id == (INT)$menu_id) {
                    $c++;
                    $navpath[$c][caption]=$child->caption;
                    $navpath[$c][url]=$child->url;
                } elseif($child->menu) {
                    $b=$c;
                    $this->navpath($child,$menu_id);
                    if ($c>$b) {
                        $c++;
                        $navpath[$c][caption]=$child->caption;
                        $navpath[$c][url]=$child->url;
                        break;
                    }
                }
            }
        }
        if (is_array($navpath)) {arsort($navpath);}
    }
    
    /*
	function sitemap($menus) {
        $result="<ul>\n";
        foreach ($menus->menu as $menuitem) {
            if (!$menuitem->type) {
                $result.="<li>$menuitem->caption</li>\n";
            } elseif ($menuitem->type=="dropdown") {
                $result.="<li>$menuitem->caption";
                $result.=$this->sitemap($menuitem);
                $result.="</li>\n";
            } elseif ($menuitem->type=="submenu") {
                foreach ($menuitem->menu as $menuitem) {
                    $result.="<li>$menuitem->caption";
                    $result.=$this->sitemap($menuitem);
                    $result.="</li>\n";
                }
            }
        }
        $result.="</ul>\n";
	return $result;
	}

	function pagination($records,$target="",$url="") {
		global $page,$PHP_SELF,$header;
		if (!$url) {$url=$PHP_SELF;}
		$page+=0;
		$pages=floor($records/$this->item_perpage);
		$mod=$records%$this->item_perpage;
		if ($mod) $pages++;
		if (!$page) $page++;
		if ($page>$pages) {$page=$pages;}

#-----------Paging 

		for ($a=1;$a<=$pages;$a=$a+5) {
			if ($page>=$a && $page<=$a+4) {
				$int_start=$a;
				$int_end=$a+4;
				if ($int_end>$pages) $int_end=$pages;
			}
		}

		$querystring=$this->querystring;
		if ($querystring) {$querystring="&$querystring";}

		for ($p=$int_start;$p<=$int_end;$p++) {
			if ($page==$p) {
				$pagelink[$p]="<span class=\"menu\"><u>$p</u></span>";
			} else {
				$pagelink[$p]=$this->lnk("$url?page=$p$querystring",$p,"menucurrent","","",$target);
			}
		}

		if (is_array($pagelink)) $paging=implode("&nbsp;&nbsp;",$pagelink);

#-----------Big Scroll 

		if ($int_start>1) {
			$prev_scroll=$int_start-1;
			$prev_scroll=$this->lnk("$url?page=$prev_scroll$querystring",$this->img("pointer_back_fast.gif")."&nbsp;","menucurrent","","",$target);
			$start_page=$this->lnk("$url?page=1$querystring","&nbsp;1&nbsp;","menucurrent","","",$target);
		}
		if ($int_end<$pages) {
			$next_scroll=$int_end+1;
			$next_scroll=$this->lnk("$url?page=$next_scroll$querystring","&nbsp;".$this->img("pointer_fast.gif"),"menucurrent","","",$target);
			$end_page=$this->lnk("$url?page=$pages$querystring",$pages,"menucurrent","","",$target);
		}

#-----------Page Scroll 
		$prev_page=$page-1;
		$next_page=$page+1;

		if ($page>1) {$page_nav =$this->lnk("$url?page=$prev_page$querystring",$this->img("pointer_back.gif")." Prev","menucurrent","","",$target);}
		else {$page_nav.="<font color=\"silver\">".$this->img("pointer_back.gif")." Prev</font>";}
		$page_nav.="&nbsp;|&nbsp;";
		if ($page<$pages) {$page_nav.=$this->lnk("$url?page=$next_page$querystring","Next ".$this->img("pointer.gif"),"menucurrent","","",$target);}
		else {$page_nav.="<font color=\"silver\">Next ".$this->img("pointer.gif")."</font>";}

		if (!$page) {$page=1;}
		$start=($page-1)*$this->item_perpage+1;
		$end=$start+$this->item_perpage-1;
		if ($end>$records) {$end=$records;}

		$result ="<table width=100% border=0 cellpadding=0 cellspacing=0><tr><td nowrap><span class=\"str\">Item $start-$end / $records</span></td>";
		if ($records>$this->item_perpage) $result.="<td width=100% nowrap><div align=\"center\"> <span class=\"str\">Page:</span><span class=\"menu\">$start_page $prev_scroll $paging $next_scroll $end_page</span></div></td>";
		if ($records>$this->item_perpage) $result.="<td align=right nowrap><span class=menu>$page_nav</span></td>";
		$result.="</tr></table>";
	if ($records>0) return $result;
	}

	function breadcrumb($data,$prefix) {
		global $PHP_SELF,$doc;
		ksort($data);
		$prefix=substr($prefix,0,-6);
		$result="$prefix >> ";
		while (list($key,$val)=each($data)) {
			$c++;
			$result.=$doc->lnk("$PHP_SELF?cmd=$val[cmd]&$val[qs]",$val["caption"]);
			if ($c < sizeof($data)) {$result.=" >> ";}
		}
		$result.="</div>";
	return $result;
	}	
    

    
    function trim_text($input, $length, $ellipses = true, $strip_html = true) {
        //strip tags, if desired
        if ($strip_html) {$input = strip_tags($input);}  
        //no need to trim, already shorter than trim length
        if (strlen($input) <= $length) {return $input;}  
        //find last space within length
        $last_space = strrpos(substr($input, 0, $length), ' ');
        $trimmed_text = substr($input, 0, $last_space);  
        //add ellipses (...)
        if ($ellipses) {
            $trimmed_text .= '...';
        }  
        return $trimmed_text;
    }
  */
}
?>