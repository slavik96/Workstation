<?php
// Вивід сторінок на сайті, задіяні дві функції page () and navigation ()
function page(){
    if(empty($_GET['page']) || $_GET['page'] < 0){
	$page=1;
    }else{
	if(!is_numeric($_GET['page'])) die ("Формат виводу сторінки помилковий!");
	$page=$_GET['page'];
    }
    return $page;
}


function navigation_new($onpage,$page,$t,$uslov,$get=''){
    $return=null;
    $count=mysql_query("select count(*) from ".$t.$uslov);
    $count=mysql_fetch_array($count);
    $count=$count[0];
	$pages=intval(($count - 1)/$onpage) + 1;
	$get=$get==''?'':$get;
    if($page!=1)
		$prev=" <a href=\"?page=".($page-1).$get."\" style='margin-right:50px; font-size: 10pt;'>Попередня</a>";
    if($page==1)
		$prev="<span style='margin-right:50px; font-size: 10pt;'>м</span>";
    if($page!=$pages)
		$next="<a href=\"?page=".($page+1).$get."\" style='margin-left:50px; font-size: 10pt;'>Наступна</a> ";
    if($page==$pages)
		$next="<span style='margin-left:50px; font-size: 10pt;'>Наступна</span> ";

	if($page - 4 > 0) $page4left = '&nbsp;&nbsp;<a href= ?page='. ($page - 4).$get .'>'. ($page - 4) .'</a>&nbsp;&nbsp;'; else $page4left='';  
	if($page - 3 > 0) $page3left = '&nbsp;&nbsp;<a href= ?page='. ($page - 3).$get .'>'. ($page - 3) .'</a>&nbsp;&nbsp;'; else $page3left=''; 
	if($page - 2 > 0) $page2left = '&nbsp;&nbsp;<a href= ?page='. ($page - 2).$get .'>'. ($page - 2) .'</a>&nbsp;&nbsp;'; else $page2left=''; 
	if($page - 1 > 0) $page1left = '&nbsp;&nbsp;<a href= ?page='. ($page - 1).$get .'>'. ($page - 1) .'</a>&nbsp;&nbsp;'; else $page1left=''; 
	if($page + 4 <= $pages) $page4right = '&nbsp;&nbsp;<a href= ?page='. ($page + 4).$get .'>'. ($page + 4) .'</a>&nbsp;&nbsp;'; else $page4right='';
	if($page + 3 <= $pages) $page3right = '&nbsp;&nbsp;<a href= ?page='. ($page + 3).$get .'>'. ($page + 3) .'</a>&nbsp;&nbsp;'; else $page3right='';  
	if($page + 2 <= $pages) $page2right = '&nbsp;&nbsp;<a href= ?page='. ($page + 2).$get .'>'. ($page + 2) .'</a>&nbsp;&nbsp;'; else $page2right='';  
	if($page + 1 <= $pages) $page1right = '&nbsp;&nbsp;<a href= ?page='. ($page + 1).$get .'>'. ($page + 1) .'</a>&nbsp;&nbsp;'; else $page1right=''; 

	if($page>5) $tochkileft="..."; else $tochkileft="";
	if($page<$pages-4) $tochkiright="..."; else $tochkiright="";
	
	    return "<a href=' ?page=1'>1</a> &nbsp;&nbsp;&nbsp;&nbsp; ".$prev.$tochkileft.$page4left.$page3left.$page2left.$page1left."<span style='color: #9bca08;'>&nbsp;&nbsp;".$page."&nbsp;&nbsp;</span>".$page1right.$page2right.$page3right.$page4right.$tochkiright.$next." &nbsp;&nbsp;&nbsp;&nbsp; <a href=' ?page=".$pages."'>".$pages."</a>";
		
}
?>